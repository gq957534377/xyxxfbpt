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

class CommentAndLikeService
{
    protected static $actionStore;
    protected static $commentStore;
    protected static $likeStore;

    public function __construct(ActionStore $actionStore, CommentStore $commentStore, LikeStore $likeStore)
    {
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
    public function getForPageUserComment($where,$page)
    {
        //评论内容数据
        $data = self::$commentStore->getPageData($page,$where);

        if (empty($data)) return ['StatusCode' => '400', 'ResultData' => '暂时没有评论信息'];

        return ['StatusCode' => '200', 'ResultData' => $data];
    }

    /**
     * 查找一组内容id(数组)中的一组活动内容
     * @param string $id 内容id
     * @return array
     * author 张洵之
     */
    public function getContentInArrContentId($id)
    {
        //被评论的内容数据
        $where = ['guid' => $id];
        $data = self::$actionStore->getOneData($where);

        if (empty($data)) return ['StatusCode' => '400', 'ResultData' => '暂时没有相关内容信息'];

        return ['StatusCode' => '200', 'ResultData' => $data];
    }
    /**
     * 数据解封包
     * @param $data 要被解封包的数据
     * @return null
     * author 张洵之
     */
    public function openData($data)
    {
        if($data['StatusCode'] == '200') return $data["ResultData"];

        return null;
    }

    public function forPage($page, $request,$where)
    {
        $url = $request->url();
        return Common::getPageUrls($request, 'data_comment_info', $url, 5, null, $where);
    }

    /**
     * 分页获得当前用户评论信息
     * @param $page 页码
     * @return array
     * author 张洵之
     */
    public function getCommentsTitles($page, $request)
    {
        $userId = session('user')->guid;
        $where = ['user_id' => $userId];
        //分页样式
        $pageData = $this->forPage($page, $request, $where);
        if(empty($pageData)) return ['StatusCode' => '400', 'ResultData' => '分页方法错误'];
        //被评论内容的guid
        $commentdata = $this->openData($this->getForPageUserComment($where, $page));

        if (empty($commentdata)) return ['StatusCode' => '400', 'ResultData' => '暂无评论数据'];

        foreach ($commentdata as $data) {

            $contentData = $this->openData($this->getContentInArrContentId($data->action_id));

            if (empty($contentData)) return ['StatusCode' => '400', 'ResultData' => $data->action_id];

            $data->contentTitle = $contentData ->title;
        }
        //拼装分页样式
        $commentdata['pageData'] = $pageData;
        return ['StatusCode' => '200', 'ResultData' => $commentdata];
    }
}