<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/17
 * Time: 13:51
 * @author:郭庆
 */

namespace App\Services;
use App\Store\ArticleStore;
use App\Store\CommentStore;
use App\Store\LikeStore;
use App\Store\SendStore;
use App\Tools\Common;
use App\Services\UserService as UserServer;

class ArticleService
{
    /**
     * 引入文章数据仓储层
     */
    protected static $articleStore;
    protected static $commentStore;
    protected static $common;
    protected static $likeStore;
    protected static $sendStore;
    protected static $userServer;

    public function __construct(
        ArticleStore $articleStore,
        CommentStore $commentStore,
        LikeStore $likeStore,
        SendStore $sendStore,
        UserServer $userServer
    ){
        self::$articleStore = $articleStore;
        self::$commentStore = $commentStore;
        self::$likeStore = $likeStore;
        self::$sendStore = $sendStore;
        self::$userServer = $userServer;
    }

    /**
     * 查询对应文章类型的所有文章数据
     * @param $type
     * @return array
     * @author 郭庆
     * @modify 王通
     */
    public static function selectByType($type)
    {

        $data = self::$sendStore->getData(['type' => $type, 'status' => 1]);

        if($data) return ['StatusCode' => '200', 'ResultData' => $data];
        return ['StatusCode' => '201', 'ResultData' => '暂时没有本文章信息'];

    }

    /**
     * 发布文章
     * @param $data
     * @return array
     * author 郭庆
     */
    public function insertData($data)
    {
        $data["guid"] = Common::getUuid();
        $data["time"] = date("Y-m-d H:i:s", time());

        $result = self::$sendStore->insertData($data);

        //判断插入是否成功，并返回结果
        if(isset($result)) return ['status' => true, 'msg' => $result];
        return ['status' => false, 'msg' => '存储数据发生错误'];
    }

    /**
     * 分页查询
     * @param $request
     * @return array
     * author 郭庆
     */
    public function selectData($request)
    {
        //数据初始化
        $data = $request->all();
        $forPages = 5;//一页的数据条数
        $nowPage = isset($data["nowPage"]) ? (int)$data["nowPage"]:1;//获取当前页
        $status = $data["status"];//文章状态：已发布 待审核 已下架
        $type = $data["type"];//获取文章类型
        $user = $data["user"];//用户类型

        $where = [];
        if($status){
            $where["status"] = $status;
        }
        if($type!="null"){
            if ($type != 3){
                $where["type"] = $type;
            }
        }
        if ($user){
            $where['user'] = $user;
        }

        //创建分页
        $creatPage = Common::getPageUrls($data, "data_send_info", "/article/create", $forPages, null, $where);
        if(isset($creatPage)){
            $result["pages"] = $creatPage['pages'];
        }else{
            return ['status' => false, 'msg' => '生成分页样式发生错误'];
        }

        //获取对应页的数据
        $res = self::$sendStore->forPage($nowPage, $forPages, $where);

        if($res || empty($res)){
            $result['data'] = $res;
            return ['status' => true, 'msg' => $result];
        }else{
            return ['status' => false, 'msg' => "获取分页数据失败！"];
        }
    }

    /**
     * 查询相关文章信息
     * @param $guid
     * @return array
     * author 郭庆
     */
    public function getData($guid)
    {
        if(!$guid){
            return ['status' => false, 'msg' => "参数有误！"];
        }
        //查询一条数据文章信息
        $data = self::$sendStore->getOneData(["guid" => $guid]);
        if($data) return ['status' => true, 'msg' => $data];
        return ['status' => false, 'msg' => "文章信息获取失败！"];
    }

    /**
     * 修改文章状态
     * @param $guid
     * @param $status
     * @param $user
     * @return array
     * author 郭庆
     */
    public function changeStatus($guid, $status, $user)
    {
        if(!(isset($guid) && isset($status))){
            return ['status' => false, 'msg' => "参数有误 ！"];
        }

        $Data = self::$sendStore->upload(["guid" => $guid], ["status" => $status]);

        //判断修改结果并返回
        if($Data){
            $result["data"] = $Data;
            return ['status' => true, 'msg' => $result];
        }else{
            return ['status' => false, 'msg' => "数据参数有误！"];
        }
    }

    /**
     * 修改文章内容
     * @param $where
     * @param $data
     * @return array
     * author 郭庆
     */
    public function upDta($where, $data)
    {
        $data["time"] = date("Y-m-d H:i:s", time());
        $Data = self::$sendStore->upload($where, $data);
        if($Data){
            $result["data"] = $Data;
            return ['status' => true, 'msg' => $result];
        }else{
            return ['status' => false, 'msg' => "数据参数有误！"];
        }
    }

    /**
     * 获取评论表+like表中某一个文章的评论
     * @param $id
     * @return array
     * @author 郭庆
     */
    public static function getComment($id, $limit)
    {
        $comment = self::$commentStore->getSomeData(['action_id' => $id], $limit);
        if(!$comment) return ['StatusCode' => '201', 'ResultData' => '暂无评论'];
        // return ['status' => true, 'msg' => $comment];

            foreach ($comment as $v)
            {
                $res = self::$userServer->userInfo(['guid' => $v->user_id]);
                if($res['status']){
                    $v->user_name = $res['msg']->nickname;
                    $v->headpic = $res['msg']->headpic;
                }else{
                    $v->user_name = '无名英雄';
                    $v->headpic = '';
                }
            }

        return ['StatusCode' => '200', 'ResultData' => $comment];
    }

    /**
     * 获取点赞记录用于检测是否点赞
     * @param $user_id
     * @param $article_id
     * @return array
     * @author 郭庆
     */
    public static function getLike($user_id, $article_id)
    {
        $result = self::$likeStore->getOneData(['action_id' => $article_id, 'user_id' => $user_id]);
        if (!$result) return ['status' => false, 'msg' => '还未点赞'];
        return ['status' => true, 'msg' => $result];
    }

    /**
     * 添加点赞记录.
     * @param $data
     * @return array
     * @author 郭庆
     */
    public static function setLike($data)
    {
        $result = self::$likeStore->addData($data);
        if(!$result) return ['status' => false, 'msg' => '点赞失败'];
        return ['status' => true, 'msg' => $result];
    }

    /**
     * 获取点赞数量
     * @param $id
     * @return array
     * @author 郭庆
     */
    public static function getLikeNum($id)
    {
        $like = self::$likeStore->getSupportNum($id);//点赞数量
        $no_like = self::$likeStore->getNoSupportNum($id);//不支持数量

        //判断获取结果并返回
        if (isset($like) && isset($no_like)) return ['status' => true, 'msg' => [$like,$no_like]];
        return ['status' => false, 'msg' => '获取点赞数量失败'];
    }

    /**
     * 修改点赞/不支持
     * @param $user_id
     * @param $article_id
     * @param $data
     * @return array
     * @author 郭庆
     */
    public static function chargeLike($user_id, $article_id, $data)
    {
        $result = self::$likeStore->updateData(['user_id' => $user_id, 'action_id' => $article_id], $data);
        if ($result) return ['status' => true, 'msg' => $result];
        return ['status' => false, 'msg' => '操作失败'];
    }

    /**
     * 发表评论
     * @param $data
     * @return array
     * @author 郭庆
     */
    public static function comment($data)
    {
        $data["time"] = date("Y-m-d H:i:s", time());
        $result = self::$commentStore->addData($data);
        if($result) return ['StatusCode' => '200', 'ResultData' => $data];

        return ['StatusCode' => '400', 'ResultData' => '存储数据发生错误'];

    }

    /**
     * 获取指定用户所发表的所有文章
     * @param $id
     * @param $status
     * @return array
     * @author 郭庆
     */
    public static function getArticleByUser($id, $status)
    {
        $result = self::$sendStore->getData(['user_id' => $id, 'status' => $status]);
        if($result) return ['status' => true, 'msg' => $result];
        return ['status' => false, 'msg' => $result];
    }

    /**
     * 用户发布文稿
     * @param $data
     * @return array
     * @author 郭庆
     */
    public static function addSend($data)
    {
        $data["guid"] = Common::getUuid();
        $data["time"] = date("Y-m-d H:i:s", time());

        $result = self::$sendStore->insertData($data);

        //判断插入是否成功，并返回结果
        if(isset($result)) return ['status' => true, 'msg' => $result];
        return ['status' => false, 'msg' => '存储数据发生错误'];
    }
}