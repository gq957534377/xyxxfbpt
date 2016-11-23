<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/17
 * Time: 13:51
 * @author:郭庆
 */

namespace App\Services;
use App\Store\ActionStore;
use App\Store\ActionOrderStore;
use App\Store\CommentStore;
use App\Store\LikeStore;
use App\Tools\Common;
use Illuminate\Support\Facades\DB;

class ActionService
{
    /**
     * 引入活动数据仓储层
     */
    protected static $actionStore;
    protected static $commentStore;
    protected static $actionOrderStore;
    protected static $common;
    protected static $likeStore;

    public function __construct(ActionStore $actionStore, ActionOrderStore $actionOrderStore, CommentStore $commentStore, LikeStore $likeStore)
    {
        self::$actionStore = $actionStore;
        self::$commentStore = $commentStore;
        self::$actionOrderStore = $actionOrderStore;
        self::$likeStore = $likeStore;
    }

    /**
     * 查询对应活动类型的所有活动数据
     * @author 郭庆
     */
    public static function selectByType($type)
    {
        $data = self::$actionStore -> getData(['type' => $type]);
        if($data) return ['status' => true, 'msg' => $data];
        return ['status' => false, 'msg' => '暂时没有本活动信息'];
    }

    /**
     * 报名活动.
     *
     * @author 郭庆
     */
    public function actionOrder($data)
    {
        //判断是否已经报名
        $action = self::$actionOrderStore -> getSomeField(['user_id' => $data['user_id']], 'action_id');
        $isHas = in_array($data['action_id'], $action);
        if($isHas) return ['status' => false, 'msg' => '已经报名参加'];

        //添加新的报名记录
        $data['time'] = date("Y-m-d H:i:s", time());
        DB::beginTransaction();
        try{
            //插入报名记录
            $result = self::$actionOrderStore -> addData($data);

            //给活动信息表参与人数字段加1
            $res = self::$actionStore -> incrementData(['guid' => $data['action_id']], 'people',1);

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
     * 获取指定用户所报名参加的所有活动.
     * 返回一个活动id为元素的一维数组
     * @author 郭庆
     */
    public static function getAction($user)
    {
        $action = self::$actionOrderStore -> getSomeField(['user_id' => $user], 'action_id');
        if (!$action) return ['status' => false, 'msg' => '获取报名活动清单失败'];
        return ['status' => true, 'msg' => $action];
    }
    /**
     * 发布活动
     * @param $data
     * @return array
     * author 张洵之
     */
    public function insertData($data)
    {
        $data["guid"] = Common::getUuid();
        $data["time"] = date("Y-m-d H:i:s", time());
        $data["change_time"] = date("Y-m-d H:i:s", time());

        //检测时间是否符合标准
        $temp = $this -> checkTime($data);
        if($temp["status"]){
            $result = self::$actionStore -> insertData($data);
        }else{
            return ['status' => false, 'msg' => $temp["msg"]];
        }

        //判断插入是否成功，并返回结果
        if(isset($result)) return ['status' => true, 'msg' => $result];
        return ['status' => false, 'msg' => '存储数据发生错误'];
    }

    /**
     * 检查日期是否合乎逻辑
     * @param $data
     * author 张洵之
     */
    public function checkTime($data)
    {
        //转为时间戳
        $endtime = strtotime($data["end_time"]);
        $deadline = strtotime($data["deadline"]);
        $starttime = strtotime($data["start_time"]);

        //检测开始：报名截止时间 < 活动开始时间 < 活动结束时间
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
     * author 张洵之
     */
    public function selectData($request)
    {
        //数据初始化
        $data = $request -> all();
        $forPages = 5;//一页的数据条数
        $nowPage = isset($data["nowPage"]) ? (int)$data["nowPage"]:1;//获取当前页
        $status = $data["status"];//活动状态：开始前 进行中  结束
        $type = $data["type"];//获取数据类型
        $where = [];
        if($status){
            $where["status"] = $status;
        }
        if($type!="null"){
            $where["type"] = $type;
        }

        //创建分页
        $creatPage = Common::getPageUrls($data, "data_action_info", "/action/create", $forPages, null, $where);
        if(isset($creatPage)){
            $result["pages"] = $creatPage['pages'];
        }else{
            return ['status' => false, 'msg' => '生成分页样式发生错误'];
        }

        //获取对应页的数据
        $Data = self::$actionStore -> forPage($nowPage, $forPages, $where);
        if($Data || empty($Data)){
            $result["data"] = $Data;
            return ['status' => true, 'msg' => $result];
        }else{
            return ['status' => false, 'msg' => "数据参数有误！"];
        }
    }

    /**
     * 查询相关活动信息
     * @return array
     * author 郭庆
     */
    public function getData($guid)
    {
        if(!is_string($guid)){
            return ['status' => false, 'msg' => "参数有误！"];
        }
        //查询一条数据活动信息
        $data = self::$actionStore -> getOneData(["guid" => $guid]);
        if($data) return ['status' => true, 'msg' => $data];
        return ['status' => false, 'msg' => "活动信息获取失败！"];
    }

    /**
     * 修改活动/报名状态
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

        //判断请求的是改活动状态还是报名状态
        if(strlen($guid) != 32){
            $Data = self::$actionOrderStore -> updateData(["id" => $guid], ["status" => $status]);
        }else{
            $Data = self::$actionStore -> upload(["guid" => $guid], ["status" => $status]);
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
     * 修改活动内容
     * @param $where
     * @param $data
     * @return array
     * author 张洵之
     */
    public function upDta($where, $data)
    {
        $Data = self::$actionStore -> upload($where, $data);
        if($Data){
            $result["data"] = $Data;
            return ['status' => true, 'msg' => $result];
        }else{
            return ['status' => false, 'msg' => "数据参数有误！"];
        }
    }

    /**
     * @param $guid
     * author 张洵之
     */
    public function getOrderInfo($guid)
    {
        $where = ["action_id" => $guid];
        $result = self::$actionOrderStore -> getSomeData($where);
        if($result){
            return ['status' => true, 'msg' => $result];
        }else{
            return ['status' => false, 'msg' => "数据暂无数据！"];
        }
    }

    /**
     * 获取评论表+like表中某一个活动的评论
     * @author郭庆
     */
    public static function getComment($id)
    {
        $comment = self::$commentStore -> getSomeData(['action_id' => $id]);
        if(!$comment) return ['status' => false, 'msg' => '获取评论信息失败'];
        return ['status' => true, 'msg' => $comment];
    }

    /**
     * 获取点赞记录用于检测是否点赞
     *
     * @author 郭庆
     */
    public static function getLike($user_id, $action_id)
    {
        $result = self::$likeStore->getOneData(['action_id' => $action_id, 'user_id' => $user_id]);
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
    public static function chargeLike($user_id, $action_id,$data)
    {
        $result = self::$likeStore->updateData(['user_id' => $user_id, 'action_id' => $action_id], $data);
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