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
use App\Store\ProjectStore;
use App\Store\SendStore;
use App\Tools\Common;
use App\Store\UserStore;
use Illuminate\Contracts\Logging\Log;

class CommentAndLikeService
{
    protected static $actionStore;
    protected static $commentStore;
    protected static $likeStore;
    protected static $userStore;
    protected static $projectStore;
    protected static $sendStore;

    public function __construct(
        ActionStore $actionStore,
        CommentStore $commentStore,
        LikeStore $likeStore,
        UserStore $userStore,
        ProjectStore $projectStore,
        SendStore $sendStore
    ){
        self::$actionStore = $actionStore;
        self::$commentStore = $commentStore;
        self::$likeStore = $likeStore;
        self::$userStore = $userStore;
        self::$projectStore = $projectStore;
        self::$sendStore = $sendStore;
    }

    /**
     * 分页获得当前用户的评论信息
     * @param array $where 查询条件
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
     * @param int $type 内容类型 1-文章；2-项目；3-活动；
     * @return array
     * author 张洵之
     */
    public function getContentInContentId($id,$type)
    {
        //被评论的内容数据
        switch ($type){

            case 1 :
                $data = self::$sendStore->getOneDatas(['guid' => $id]);
                break;

            case 2 :
                $data = self::$projectStore->getOneData(['project_id' => $id]);
                break;

            default :
                $data = self::$actionStore->getOneData(['guid' => $id]);

        }

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
     * @param array $commentData 评论数据
     * @return array
     * author 张洵之
     */
    public function getContents($commentData)
    {
        foreach ($commentData as $data) {
            //活动内容表数据
            $contentData = $this->openData($this->getContentInContentId($data->action_id,$data->type));
            if (empty($contentData)) return ['StatusCode' => '400', 'ResultData' => $data->action_id];

            $data->contentTitle = $contentData ->title;
        }

        return ['StatusCode' => '200', 'ResultData' => $commentData];
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
        $commentData = $this->openData($this->getForPageUserComment($where, $page));

        if (empty($commentData)) return ['StatusCode' => '400', 'ResultData' => '暂无评论数据'];

        //拼装了内容标题的评论数据
        $commentData = $this->openData($this->getContents($commentData));
        //拼装分页样式
        $commentData['pageData'] = $pageData;

        return ['StatusCode' => '200', 'ResultData' => $commentData];
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

    /**
     * 发表评论
     * @param array $data 前台数据
     * @return array
     * @author 郭庆
     * @modify 王通
     * @modify 张洵之
     */
    public  function comment($data)
    {
        $data["time"] = date("Y-m-d H:i:s", time());

        // 判断两次评论之间的时间间隔
        $oldTime = $this->getUserCommentTime ($data['action_id'], session('user')->guid);

        if (($oldTime + config('safety.COMMENT_TIME')) > time()) {
            return ['StatusCode' => '400', 'ResultData' => '两次评论间隔过短，请稍后重试'];
        };

        $result = self::$commentStore->addData($data);
        if($result) {
            $userData = $this->getUserCommentData($data['time'], $data['content']);
            return ['StatusCode' => '200', 'ResultData' => $userData];
        }

        return ['StatusCode' => '400', 'ResultData' => '存储数据发生错误'];

    }

    /**
     * 得到该用户上次评论同文章的时间
     * @param string $acricle_id   文章ID
     * @param string $user_id  用户ID
     * @return int $time  时间戳
     * @author 王通
     */
    public  function getUserCommentTime ($acricle_id, $user_id)
    {
        $res = self::$commentStore->getCommentTime($acricle_id, $user_id);
        if (empty($res)) {
            return 0;
        } else {
            return strtotime($res[0]->time);
        }
    }

    /**
     * 拼装评论成功后返回的数据
     * @param string $time 评论发布日期
     * @param string $content   评论内容
     * @return array
     * author 张洵之
     */
    public function getUserCommentData($time,$content)
    {
        $userImg = session('user')->headpic;
        $nikename = session('user')->nickname;
        return [
            'userImg' => $userImg,
            'nikename' => $nikename,
            'time' => $time,
            'content' => $content
        ];
    }

    /**
     * 获取该内容下的评论
     * @param int|string $contentId 内容ID
     * @param int $page 页码
     * @return array
     * author 张洵之
     */
    public function getComent($contentId, $page)
    {
        $commentData = $this->getForPageUserComment(['action_id' => $contentId], $page);

        if($commentData['StatusCode'] == '400') return $commentData;

        $commentData = $this->addUserInfo($this->openData($commentData));
        return $commentData;
    }

    /**
     * 为数据添加改数据有关用户信息数据
     * @param array $commentData 评论数据
     * @return array
     * author 张洵之
     */
    public function addUserInfo($commentData)
    {
        foreach ($commentData as $data) {
            $userInfoData = self::$userStore->getOneData(['guid' => $data->user_id]);

            if (empty($userInfoData)) return ['StatusCode' => '400', 'ResultData' => $data->user_id];

            $data->userImg = $userInfoData->headpic;//添加用户头像
            $data->nikename = $userInfoData->nickname;//添加用户昵称
        }
        return ['StatusCode' => '200', 'ResultData' => $commentData];
    }

    /**
     * 查询点赞状态
     * @param string $userId 用户id
     * @param string $contentId 内容id
     * @return bool
     * author 张洵之
     */
    public function likeStatus($userId, $contentId)
    {
        $where = ['action_id' => $contentId, 'user_id' => $userId];
        $result = self::$likeStore->getLikeStatus($where, 'support');

        switch ($result) {
            case 1 :
                return 1;//已收藏或点赞
                break;

            case 2 :
                return 2;//已取消收藏或点赞
                break;

            default :
                return 3;//暂无改用户数据
        }
    }

    /**
     * 查询用户上次与本次操作间隔是否合法
     * @param array $where 查询条件
     * @return bool
     * author 张洵之
     */
    public function likeTime($where)
    {
        $result = self::$likeStore->getLikeStatus($where, 'time');

        if($result) {
            $nowTime = time();//当前时间戳
            $changeTime = strtotime($result);//上次操作时间戳
            $time = $nowTime -$changeTime;//两次操作时间差值

            if($time<15) return false;

            return true;
        }else{
            return true;
        }
    }

    /**
     * 更改当前用户点赞状态
     * @param string $contentId 内容ID
     * @param int $type 点赞外联属性 1-文章；2-项目；3-活动；
     * @return array
     * author 张洵之
     */
    public function changeLike($contentId, $type)
    {
        //当前用户id
        $userId = $userId = session('user')->guid;
        $result = $this->likeStatus($userId, $contentId);
        $where = ['action_id' => $contentId, 'user_id' => $userId];

        //查询用户上次与本次操作间隔是否合法
        if(!$this->likeTime($where)) return ['StatusCode' => '400', 'ResultData' => false];

        $data = [
            'action_id' => $contentId, //内容ID
            'user_id' => $userId, //用户ID
            'support' => 1, //点赞状态 1：赞 2：取消赞
            'time' => date('Y-m-d H:i:s',time()),//修改日期
            'addtime' => date('Y-m-d H:i:s',time()),//添加日期
            'type' => $type //点赞外联属性 1-文章；2-项目；3-活动；
        ];

        switch ($result) {
            case 1 :
                $temp = self::$likeStore->updateData($where, ['support' => 2, 'time' => date('Y-m-d H:i:s',time())]);//取消赞或收藏
                break;

            case 2 :
                $temp = self::$likeStore->updateData($where, ['support' => 1, 'time' => date('Y-m-d H:i:s',time())]);//添加赞或收藏
                break;

            default :
                $temp = self::$likeStore->addData($data);//添加该用户点赞数据
        }

        if ($temp) return ['StatusCode' => '200', 'ResultData' => true];

        return ['StatusCode' => '400', 'ResultData' => false];
    }

    /**
     * 统计某个内容点赞数量
     * @param string|int $contentId 内容ID
     * @return int
     * author 张洵之
     */
    public function likeCount($contentId)
    {
        $num = self::$likeStore->getSupportNum($contentId);

        if($num)return $num;

        return 0;
    }
}