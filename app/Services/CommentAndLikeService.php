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
use App\Redis\CommentCache;
use App\Tools\CustomPage;

class CommentAndLikeService
{
    protected static $actionStore;
    protected static $commentStore;
    protected static $likeStore;
    protected static $userStore;
    protected static $projectStore;
    protected static $sendStore;
    protected static $commentCache;

    public function __construct(
        ActionStore $actionStore,
        CommentStore $commentStore,
        LikeStore $likeStore,
        UserStore $userStore,
        ProjectStore $projectStore,
        SendStore $sendStore,
        CommentCache $commentCache
    ){
        self::$actionStore = $actionStore;
        self::$commentStore = $commentStore;
        self::$likeStore = $likeStore;
        self::$userStore = $userStore;
        self::$projectStore = $projectStore;
        self::$sendStore = $sendStore;
        self::$commentCache = $commentCache;
    }

    /**
     * 分页获得用户的评论信息
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
                $data = self::$projectStore->getOneData(['guid' => $id]);
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
        return false;
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
//        dd($commentData);
        foreach ($commentData as $data) {
            //内容表数据
            $contentData = $this->openData($this->getContentInContentId($data->action_id,$data->type));

            if (empty($contentData)) {
                $data->contentTitle = "内容已被删除";

            }else{
                $data->contentTitle = $contentData ->title;
            }

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
        if($pageData['totalPage']>1){
            $commentData['pageData'] = $pageData;
        }else{
            $commentData['pageData'] = null;
        }

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

        if($pageData['totalPage']>1){
            $likeDatas['pageData'] = $pageData;
        }else{
            $likeDatas['pageData'] = null;
        }

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
        $data["addtime"] = time();
        $data["changetime"] = time();
        // 判断两次评论之间的时间间隔
        $oldTime = $this->getUserCommentTime ($data['action_id'], session('user')->guid);

        if (($oldTime + config('safety.COMMENT_TIME')) > time()) {
            return ['StatusCode' => '400', 'ResultData' => '两次评论间隔过短，请稍后重试'];
        };

        $result = self::$commentStore->addData($data);

        if(!empty($result)) {
            self::$commentCache->insertIndex($result, $data['action_id']);
            $userData = $this->getUserCommentData($data['changetime'], $data['content']);
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
            return $res[0]->changetime;
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
            'time' => date('Y-m-d H:m:s',$time),
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
        //取得索引list
        $cacheIndex = self::$commentCache->getCacheIndex($page, $contentId);

        if(!$cacheIndex){
            //检查评论数量
            if(!self::$commentCache->getCommentNum($contentId)) return ['StatusCode' => '400', 'ResultData' => '暂无评论'];

            self::$commentCache->createIndex($contentId);//创建缓存索引

            $commentData = $this->getForPageUserComment(['action_id' => $contentId, 'status' => 1], $page);//取得评论表数据

            if($commentData['StatusCode'] == '400') return $commentData;

            $data = $this->addUserInfo($this->openData($commentData));//为每条评论添加对应用户信息

            if ($data){
                self::$commentCache->createCache($data['ResultData']);
            }

        }else{
            $data = ['StatusCode' => '200', 'ResultData' => $cache];
        }


        return $data;
    }

    /**
     * 为数据添加改数据有关用户信息数据
     * @param array $commentData 评论数据
     * @return array
     * author 张洵之
     */
    public function addUserInfo($commentData)
    {
        if(!$commentData) return false;

        foreach ($commentData as $data) {
            $userInfoData = self::$userStore->getOneData(['guid' => $data->user_id]);

            if (empty($userInfoData)) return false ;

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

        if(!$result) $result[0] =null;

        switch ($result[0]) {
            case 1 :
                return 1;//已收藏或点赞
                break;

            case 2 :
                return 2;//已取消收藏或点赞
                break;

            default :
                return 3;//暂无该用户数据
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
        $result = self::$likeStore->getLikeStatus($where, 'changetime');

        if($result) {
            $nowTime = time();//当前时间戳
            $changeTime = $result[0];//上次操作时间戳
            $time = $nowTime -$changeTime;//两次操作时间差值

            if($time<15) return false;

        }
        return true;
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
        if(!$this->likeTime($where)) return ['StatusCode' => '400', 'ResultData' => '操作过于频繁请稍后再试！'];

        $data = [
            'action_id' => $contentId, //内容ID
            'user_id' => $userId, //用户ID
            'support' => 1, //点赞状态 1：赞 2：取消赞
            'changetime' => time(),//修改日期
            'addtime' => time(),//添加日期
            'type' => $type //点赞外联属性 1-文章；2-项目；3-活动；
        ];

        switch ($result) {
            case 1 :
                $temp = self::$likeStore->updateData($where, ['support' => 2, 'changetime' => time()]);//取消赞或收藏
                break;

            case 2 :
                $temp = self::$likeStore->updateData($where, ['support' => 1, 'changetime' => time()]);//添加赞或收藏
                break;

            default :
                $temp = self::$likeStore->addData($data);//添加该用户点赞数据
        }

        if ($temp) return ['StatusCode' => '200', 'ResultData' => true];

        return ['StatusCode' => '400', 'ResultData' => '请求失败'];
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

        if($num) return $num;

        return 0;
    }
    /**
     * 统计评论数量
     * @param string|int $contentId 内容ID
     * @return int
     * author 张洵之
     */
    public function commentCount($where)
    {
        $num = self::$commentStore->getCount($where);
        return ['StatusCode' => '200', 'ResultData' => $num];
    }

    /**
     * 获得评论分页样式
     * @param string $id 内容id
     * @param int $nowPage 当前页
     * @return string
     * author 张洵之
     */
    public function getPageStyle($id,$nowPage)
    {
        $cache = self::$commentCache->getCommentNum($id);

        if(!$cache) {
            $totalNum = (int)$this->openData($this->commentCount(['action_id' => $id, 'status' => 1]));
            self::$commentCache->setCommentNum($id, $totalNum);
        }else {
            $totalNum = (int)$cache['num'];
        }

        $totalPage = ceil($totalNum/PAGENUM);

        if($totalPage<=1) return null;

        return CustomPage::getSelfPageView($nowPage, $totalPage, $id,null);
    }
}