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
use App\Tools\Common;
use Illuminate\Support\Facades\DB;

class ArticleService
{
    /**
     * 引入文章数据仓储层
     */
    protected static $articleStore;
    protected static $commentStore;
    protected static $common;
    protected static $likeStore;

    public function __construct(
        ArticleStore $articleStore,
        CommentStore $commentStore,
        LikeStore $likeStore
    )
    {
        self::$articleStore = $articleStore;
        self::$commentStore = $commentStore;
        self::$likeStore = $likeStore;
    }

    /**
     * 查询对应文章类型的所有文章数据
     * @author 郭庆
     */
    public static function selectByType($type)
    {
        $data = self::$articleStore -> getData(['type' => $type]);
        if($data) return ['status' => true, 'msg' => $data];
        return ['status' => false, 'msg' => '暂时没有本文章信息'];
    }

    /**
     * 报名文章.
     *
     * @author 郭庆
     */
    public function articleOrder($data)
    {
        //判断是否已经报名
        $article = self::$articleOrderStore -> getSomeField(['user_id' => $data['user_id']], 'article_id');
        $isHas = in_array($data['article_id'], $article);
        if($isHas) return ['status' => false, 'msg' => '已经报名参加'];

        //添加新的报名记录
        $data['time'] = date("Y-m-d H:i:s", time());
        DB::beginTransarticle();
        try{
            //插入报名记录
            $result = self::$articleOrderStore -> addData($data);

            //给文章信息表参与人数字段加1
            $res = self::$articleStore -> incrementData(['guid' => $data['article_id']], 'people',1);

            //上述俩个操作全部成功则返回成功
            if($res && $result){
                DB::commit();
                return ['status' => true, 'msg' => '报名成功'];
            }
        }catch (Exception $e){
            //上述操作有一个失败就报错，数据库手动回滚
            Log::error('报名失败', [$data]);
            DB::rollback();
            return ['status' => false, 'msg' => '报名失败'];
        }
    }

    /**
     * 获取指定用户所报名参加的所有文章.
     * 返回一个文章id为元素的一维数组
     * @author 郭庆
     */
    public static function getArticle($user)
    {
        $article = self::$articleOrderStore -> getSomeField(['user_id' => $user], 'article_id');
        if (!$article) return ['status' => false, 'msg' => '获取报名文章清单失败'];
        return ['status' => true, 'msg' => $article];
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

        $result = self::$articleStore -> insertData($data);

        //判断插入是否成功，并返回结果
        if(isset($result)) return ['status' => true, 'msg' => $result];
        return ['status' => false, 'msg' => '存储数据发生错误'];
    }

    /**
     * 检查日期是否合乎逻辑
     *
     *  @author 郭庆
     */
    public function checkTime($data)
    {
        //转为时间戳
        $endtime = strtotime($data["end_time"]);
        $deadline = strtotime($data["deadline"]);
        $starttime = strtotime($data["start_time"]);

        //检测开始：报名截止时间 < 文章开始时间 < 文章结束时间
        if($endtime > $starttime && $starttime > $deadline && $deadline > time()){
            return ['status' => true];
        }elseif($endtime < $starttime){
            return ['status' => false, "msg" => "结束日期不可早于开始日期"];
        }elseif($endtime < $deadline){
            return ['status' => false, "msg" => "结束日期不可早于报名截止日期"];
        }elseif($deadline<time()){
            return ['status' => false, "msg" => "报名截止日期不可早于当前日期"];
        }else{
            return ['status' => false, "msg" => "开始日期不可早于报名截止日期"];
        }
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
        $data = $request -> all();
        $forPages = 5;//一页的数据条数
        $nowPage = isset($data["nowPage"]) ? (int)$data["nowPage"]:1;//获取当前页
        $status = $data["status"];//文章状态：开始前 进行中  结束
        $type = $data["type"];//获取数据类型
        $where = [];
        if($status){
            $where["status"] = $status;
        }
        if($type!="null"){
            $where["type"] = $type;
        }

        //创建分页
        $creatPage = Common::getPageUrls($data, "data_article_info", "/article/create", $forPages, null, $where);
        if(isset($creatPage)){
            $result["pages"] = $creatPage['pages'];
        }else{
            return ['status' => false, 'msg' => '生成分页样式发生错误'];
        }

        //获取对应页的数据
        $Data = self::$articleStore -> forPage($nowPage, $forPages, $where);
        if($Data || empty($Data)){
            $result["data"] = $Data;
            return ['status' => true, 'msg' => $result];
        }else{
            return ['status' => false, 'msg' => "数据参数有误！"];
        }
    }

    /**
     * 查询相关文章信息
     * @return array
     * author 郭庆
     */
    public function getData($guid)
    {
        if(!is_string($guid)){
            return ['status' => false, 'msg' => "参数有误！"];
        }
        //查询一条数据文章信息
        $data = self::$articleStore -> getOneData(["guid" => $guid]);
        if($data) return ['status' => true, 'msg' => $data];
        return ['status' => false, 'msg' => "文章信息获取失败！"];
    }

    /**
     * 修改文章/报名状态
     * @param $guid
     * @param $status
     * @return array
     * author 郭庆
     */
    public function changeStatus($guid, $status)
    {
        if(!(isset($guid) && isset($status))){
            return ['status' => false, 'msg' => "参数有误 ！"];
        }

        //修改状态
        if($status == 1){
            $status = 3;
        }else{
            $status = 1;
        }

        //判断请求的是改文章状态还是报名状态
        if(strlen($guid) != 32){
            $Data = self::$articleOrderStore -> updateData(["id" => $guid], ["status" => $status]);
        }else{
            $Data = self::$articleStore -> upload(["guid" => $guid], ["status" => $status]);
        }

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
        $Data = self::$articleStore -> upload($where, $data);
        if($Data){
            $result["data"] = $Data;
            return ['status' => true, 'msg' => $result];
        }else{
            return ['status' => false, 'msg' => "数据参数有误！"];
        }
    }

    /**
     * 获取报名信息
     *
     * @author 郭庆
     */
    public function getOrderInfo($guid)
    {
        $where = ["article_id" => $guid];
        $result = self::$articleOrderStore -> getSomeData($where);
        if($result){
            return ['status' => true, 'msg' => $result];
        }else{
            return ['status' => false, 'msg' => "数据暂无数据！"];
        }
    }

    /**
     * 获取评论表+like表中某一个文章的评论
     * @author郭庆
     */
    public static function getComment($id)
    {
        $comment = self::$commentStore -> getSomeData(['article_id' => $id]);
        if(!$comment) return ['status' => false, 'msg' => '获取评论信息失败'];
        return ['status' => true, 'msg' => $comment];
    }

    /**
     * 获取点赞记录用于检测是否点赞
     *
     * @author 郭庆
     */
    public static function getLike($user_id, $article_id)
    {
        $result = self::$likeStore->getOneData(['article_id' => $article_id, 'user_id' => $user_id]);
        if (!$result) return ['status' => false, 'msg' => '还未点赞'];
        return ['status' => true, 'msg' => $result];
    }

    /**
     * 添加点赞记录.
     *
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
     */
    public static function chargeLike($user_id, $article_id,$data)
    {
        $result = self::$likeStore->updateData(['user_id' => $user_id, 'article_id' => $article_id], $data);
        if ($result) return ['status' => true, 'msg' => $result];
        return ['status' => false, 'msg' => '操作失败'];
    }
    /**
     * 发表评论
     */
    public static function comment($data)
    {
        $data["time"] = date("Y-m-d H:i:s", time());
        $result = self::$commentStore -> addData($data);
        if($result) return ['status' => true, 'msg' => $result];
        return ['status' => false, 'msg' => '存储数据发生错误'];
    }
}