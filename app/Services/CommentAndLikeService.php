<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/14
 * Time: 13:07
 */

namespace App\Services;

use App\Store\CommentStore;
use App\Store\LikeStore;
use App\Store\ActionStore;
use App\Tools\Common;
use Illuminate\Contracts\Logging\Log;

class CommentAndLikeService
{
    protected static $actionStore;
    protected static $commentStore;
    protected static $likeStore;

    public function __construct(
        ActionStore $actionStore,
        CommentStore $commentStore,
        LikeStore $likeStore
    ){
        self::$actionStore = $actionStore;
        self::$commentStore = $commentStore;
        self::$likeStore = $likeStore;
    }

    /**
     * 分页获得当前用户的评论信息
     * @param int $page 页码
     * @return array
     * author 张洵之
     */
    public function getForPageUserComment($where, $page)
    {
        //评论内容数据
        $data = self::$commentStore->getPageData($page, $where);

        if (empty($data)) return ['StatusCode' => '400', 'ResultData' => '暂时没有评论信息'];

        return ['StatusCode' => '200', 'ResultData' => $data];
    }

    /**
     * 查找一组内容id(数组)中的一组活动内容
     * @param string $id 内容id
     * @return array
     * author 张洵之
     */
    public function getContentInContentId($id)
    {
        //被评论的内容数据
        $where = ['guid' => $id];
        $data = self::$actionStore->getOneData($where);

        if (empty($data)) return ['StatusCode' => '400', 'ResultData' => '暂时没有相关内容信息'];

        return ['StatusCode' => '200', 'ResultData' => $data];
    }
    /**
     * 数据解封包
     * @param array $data 要被解封包的数据
     * @return null
     * author 张洵之
     */
    public function openData($data)
    {
        if($data['StatusCode'] == '200') return $data["ResultData"];
        return null;
    }

    /**
     * 分页方法
     * @param object $request Request对象
     * @param array $where 查询条件
     * @param string $table 表名
     * @return mixed
     * author 张洵之
     */
    public function forPage( $request, $where, $table)
    {
        $url = $request->url();
        return Common::getPageUrls($request, $table, $url, 5, null, $where);
    }


    /**
     *为每条数据添加与之相关的内容数据
     * @param array $commentdata
     * @return array
     * author 张洵之
     */
    public function getContents($datas)
    {
        foreach ($datas as $data) {
            //活动内容表数据
            $contentData = $this->openData($this->getContentInContentId($data->action_id));

            if (empty($contentData)) return ['StatusCode' => '400', 'ResultData' => $data->action_id];

            $data->contentTitle = $contentData ->title;
        }

        return ['StatusCode' => '200', 'ResultData' => $datas];
    }

    /**
     *获得当前用户评论数据及被评论内容标题
     * @param int $page 页码
     * @param object $request Request对象
     * @return array
     * author 张洵之
     */
    public function getCommentsTitles($page, $request)
    {
        $userId = session('user')->guid;
        $where = ['user_id' => $userId];
        //分页样式
        $pageData = $this->forPage($request, $where, 'data_comment_info');

        if(empty($pageData)) return ['StatusCode' => '400', 'ResultData' => '分页方法错误'];

        //评论表数据
        $commentdata = $this->openData($this->getForPageUserComment($where, $page));

        if (empty($commentdata)) return ['StatusCode' => '400', 'ResultData' => '暂无评论数据'];

        //拼装了内容标题的评论数据
        $commentdata = $this->openData($this->getContents($commentdata));
        //拼装分页样式
        $commentdata['pageData'] = $pageData;
        return ['StatusCode' => '200', 'ResultData' => $commentdata];
    }

    /**
     * 分页获得点赞数据
     * @param array $where 查询条件
     * @param int $page  页码
     * @return array
     * author 张洵之
     */
    public function getLikeData($where, $page)
    {
        $data = self::$likeStore->getPageData($page,$where);

        if (empty($data)) return ['StatusCode' => '400', 'ResultData' => '暂时没有相关内容信息'];

        return ['StatusCode' => '200', 'ResultData' => $data];
    }

    /**
     *获得当前用户点赞数据及点赞内容标题
     * @param int $page 页码
     * @param object $request Request对象
     * @return array
     * author 张洵之
     */
    public function getLikesTitles($page, $request)
    {
        $userId = session('user')->guid;
        //当前用户且点赞成功
        $where = ['user_id' => $userId, 'support' => 1];
        //分页样式
        $pageData = $this->forPage($request, $where, 'data_like_info');

        if(empty($pageData)) return ['StatusCode' => '400', 'ResultData' => '分页方法错误'];

        //点赞数据
        $likeData = $this->openData($this->getLikeData($where, $page));

        if (empty($likeData)) return ['StatusCode' => '400', 'ResultData' => '暂无点赞数据'];

        //拼装了内容标题的点赞数据
        $likeDatas = $this->openData($this->getContents($likeData));

        if (empty($likeDatas)) return ['StatusCode' => '400', 'ResultData' => '点赞数据拼装失败'];

        $likeDatas['pageData'] = $pageData;
        return ['StatusCode' => '200', 'ResultData' => $likeDatas];
    }
}