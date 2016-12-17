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
use Illuminate\Support\Facades\Log;

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
     * @param $type
     * @return array
     * @author 郭庆
     * @modify 刘峻廷
     */
    public function actionTypeData($type)
    {
        $data = self::$actionStore->getListData($type);

        if (empty($data)) return ['StatusCode' => '400', 'ResultData' => '暂时没有本活动信息'];
        return ['StatusCode' => '200', 'ResultData' => $data];
    }
    public static function selectByType($type)
    {
        $data = self::$actionStore->getListData($type);
        if($data) return ['status' => true, 'msg' => $data];
        if ($data!=[]) \Log::info('前端查询列表失败:'.$data);
        return ['status' => false, 'msg' => '暂时没有本活动信息'];
    }

    /**
     * 报名活动
     * @param $data
     * @return array
     * @author 郭庆
     */
    public function actionOrder($data)
    {
        //判断是否已经报名
        $action = self::$actionOrderStore->getSomeField(['user_id' => $data['user_id']], 'action_id');
        $isHas = in_array($data['action_id'], $action);
        if($isHas) return ['status' => false, 'msg' => '已经报名参加'];

        //添加新的报名记录
        $data['time'] = date("Y-m-d H:i:s", time());
        DB::beginTransaction();
        try{
            //插入报名记录
            $result = self::$actionOrderStore->addData($data);

            //给活动信息表参与人数字段加1
            $res = self::$actionStore->incrementData(['guid' => $data['action_id']], 'people',1);

            //上述俩个操作全部成功则返回成功
            if($res && $result){
                DB::commit();
                return ['status' => true, 'msg' => '报名成功'];
            }
        }catch (Exception $e){
            //上述操作有一个失败就报错，数据库手动回滚
            \Log::error('报名失败', [$data]);
            DB::rollback();
            return ['status' => false, 'msg' => '报名失败'];
        }
    }

    /**
     * 获取指定用户所报名参加的所有活动.
     * @return array 返回一个活动id为元素的一维数组
     * @author 郭庆
     */
    public static function getAction($user)
    {
        $action = self::$actionOrderStore->getSomeField(['user_id' => $user], 'action_id');
        if ($action) {
            return ['status' => true, 'msg' => $action];
        }else{
            if (!is_array($action)) \Log::info('获取'.$user.'数据失败：'.$action);
            return ['status' => false, 'msg' => '获取报名活动清单失败'];
        }
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
        $temp = $this->checkTime($data);
        if($temp["status"]){
            $result = self::$actionStore->insertData($data);
        }else{
            return ['status' => false, 'msg' => $temp["msg"]];
        }

        //判断插入是否成功，并返回结果
        if(isset($result)) return ['status' => true, 'msg' => $result];
        \Log::info('发表评论失败', $data, $result);
        return ['status' => false, 'msg' => '存储数据发生错误'];
    }

    /**
     * 检查日期是否合乎逻辑
     *
     *  @author 张洵之
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
     * 每次加载页面更新活动状态
     * @param $data
     * @return array
     * @author 郭庆
     */
    public static function setStatusByTime($data)
    {
        //目前的状态
        $old = $data->status;

        //转为时间戳
        $endTime = strtotime($data->end_time);
        $deadline = strtotime($data->deadline);
        $startTime = strtotime($data->start_time);
        $time = time();

        //设置状态
        if ($old == 4){
            return ['status' => true, "msg" => "无需更改"];
        }else{
            //判断时间设置状态
            if ($time < $deadline){
                $status = 1;
            }elseif ($time > $startTime && $time < $endTime){
                $status = 2;
            }elseif ($time > $endTime){
                $status = 3;
            }elseif ($time > $deadline && $time < $startTime){
                $status = 5;
            }else{
                return ['status' => false, "msg" => "数据有误"];
            }
        }

        //返回所需要更改的状态
        if ($old == $status) return ['status' => false, "msg" => '无需更改'];
        return ['status' => true, "msg" => $status];
    }
    /**
     * 分页查询
     * @param $request
     * @return array
     * author 张洵之
     * @modify 郭庆
     */
    public function selectData($request)
    {
        //数据初始化
        $data = $request->all();
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
            \Log::info('生成分页出错:', $creatPage);
            return ['status' => false, 'msg' => '生成分页样式发生错误'];
        }

        //获取对应页的数据
        $Data = self::$actionStore->forPage($nowPage, $forPages, $where);
        if($Data || empty($Data)){
            $result["data"] = $Data;
            return ['status' => true, 'msg' => $result];
        }else{
            \Log::info('获取活动分页数据出错:', $Data);
            return ['status' => false, 'msg' => "数据参数有误！"];
        }
    }

    /**
     * 获取所有活动数据
     * @param
     * @return array
     * @author 郭庆
     */
    public static function getAllAction()
    {
        $data = self::$actionStore->getData([]);
        if ($data) return ['status' => true, 'msg' => $data];
        return ['status' => false, 'msg' => "获取所有活动失败"];
    }

    /**
     * 查询相关活动信息
     * @param $guid
     * @return array
     * author 郭庆
     */
    public function getData($guid)
    {
        if(!is_string($guid)){
            return ['status' => false, 'msg' => "参数有误！"];
        }
        //查询一条数据活动信息
        $data = self::$actionStore->getOneData(["guid" => $guid]);
        if($data) return ['status' => true, 'msg' => $data];
        \Log::info('获取'.$guid.'活动详情出错:'.$data);
        return ['status' => false, 'msg' => "活动信息获取失败！"];
    }

    /**
     * 修改活动/报名状态
     * @param $guid 所要修改的id
     * @param $status 改为的状态
     * @return array
     * author 郭庆
     */
    public function changeStatus($guid, $status)
    {
        if(!(isset($guid) && isset($status))){
            return ['status' => false, 'msg' => "参数有误 ！"];
        }

        //判断请求的是改活动状态还是报名状态
        if(strlen($guid) != 32){
            $Data = self::$actionOrderStore->updateData(["id" => $guid], ["status" => $status]);
        }else{
            $Data = self::$actionStore->upload(["guid" => $guid], ["status" => $status]);
        }

        //判断修改结果并返回
        if($Data){
            $result["data"] = $Data;
            return ['status' => true, 'msg' => $result];
        }else{
            if ($Data != 0) \Log::info('修改'.$guid.'活动/报名状态出错:'.$Data);
            return ['status' => false, 'msg' => $Data];
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
        $Data = self::$actionStore->upload($where, $data);
        if($Data){
            $result["data"] = $Data;
            return ['status' => true, 'msg' => $result];
        }else{
            \Log::info('修改'.$where['guid'].'活动出错:'.$Data);
            return ['status' => false, 'msg' => "数据参数有误！"];
        }
    }

    /**
     * 获取报名信息
     * @param $guid
     * @return array
     * @author 郭庆
     */
    public function getOrderInfo($guid)
    {
        $where = ["action_id" => $guid];
        $result = self::$actionOrderStore->getSomeData($where);
        if($result){
            return ['status' => true, 'msg' => $result];
        }else{
            if (!is_array($result)) \Log::info('获取'.$guid.'报名信息出错:'.$result);
            return ['status' => false, 'msg' => "数据暂无数据！"];
        }
    }

    /**
     * 获取评论表+like表中某一个活动的评论
     * @param $id
     * @return array
     * @author 郭庆
     */
    public static function getComment($id)
    {
        $comment = self::$commentStore->getSomeData(['action_id' => $id]);
        if($comment) {
            return ['status' => true, 'msg' => $comment];
        }else{
            if (!is_array($comment)) \Log::info('获取'.$id.'活动的评论出错:'.$comment);
            return ['status' => false, 'msg' => '获取评论信息失败'];
        }
    }

    /**
     * 获取点赞记录用于检测是否点赞
     * @param $user_id : 用户id
     * @param $action_id : 活动id
     * @return array
     * @author 郭庆
     */
    public static function getLike($user_id, $action_id)
    {
        $result = self::$likeStore->getOneData(['action_id' => $action_id, 'user_id' => $user_id]);
        if ($result) return ['status' => true, 'msg' => $result];
        \Log::info($action_id.'人'.'获取'.$action_id.'活动的点赞记录出错:'.$result);
        return ['status' => false, 'msg' => '还未点赞'];
    }

    /**
     * 添加点赞记录.
     * @param $data ：点赞表对应的数据
     * @return array
     * @author 郭庆
     */
    public static function setLike($data)
    {
        $result = self::$likeStore->addData($data);
        if($result) return ['status' => true, 'msg' => $result];
        \Log::info($data['user_id'].'人点赞失败：'.$result);
        return ['status' => false, 'msg' => '点赞失败'];
    }

    /**
     * 获取点赞数量
     * @param $id：活动id
     * @return array : ['点赞数量','点不支持数量']
     * @author 郭庆
     */
    public static function getLikeNum($id)
    {
        $like = self::$likeStore->getSupportNum($id);//点赞数量
        $no_like = self::$likeStore->getNoSupportNum($id);//不支持数量

        //判断获取结果并返回
        if (isset($like) && isset($no_like)) return ['status' => true, 'msg' => [$like,$no_like]];
        \Log::info('获取'.$id.'活动点赞记录失败：支持-'.$like.'不支持'.$no_like);
        return ['status' => false, 'msg' => '获取点赞数量失败'];
    }

    /**
     * 修改点赞/不支持
     * @param $user_id ：用户id
     * @param $action_id : 活动id
     * @param $data : 数据
     * @return array
     * @author 郭庆
     */
    public static function chargeLike($user_id, $action_id, $data)
    {
        $result = self::$likeStore->updateData(['user_id' => $user_id, 'action_id' => $action_id], $data);
        if ($result) return ['status' => true, 'msg' => $result];
        \Log::info('修改'.$action_id.'点赞失败：'.$result);
        return ['status' => false, 'msg' => '操作失败'];
    }

    /**
     * 发表评论
     * @param $data ：评论表字段对应的数据['用户id','活动id','评论内容']
     * @return array
     * @author 郭庆
     */
    public static function comment($data)
    {
        $data["time"] = date("Y-m-d H:i:s", time());
        $result = self::$commentStore->addData($data);
        if($result) return ['status' => true, 'msg' => $result];
        \Log::info('发表评论'.$data['action_id'].'失败：'.$result);
        return ['status' => false, 'msg' => '存储数据发生错误'];
    }

    /**
     * 修改活动报名状态
     * @param $guid ：活动id
     * @param $status : 当前状态
     * @return array
     * @author 郭庆
     */
    public function switchStatus($guid, $status)
    {
        $res = self::$actionOrderStore->updateData(['action_id' => $guid], ['status' => $status]);
        if ($res==0) return ['status' => false, 'msg' => '修改失败'];
        return ['status' => true, 'msg' => '修改成功'];
    }

    /**
     * 得到指定条件的所有活动id
     * @param $where
     * @return array
     * @author 贾济林
     */
    public function getActivityId($where)
    {
        $action = self::$actionOrderStore->getActivityId($where, 'action_id');
        if (empty($action)) return ['status' => false, 'msg' => '查询失败'];
        return ['status' => true, 'data' => $action];
    }

    /**
     * 拿取三条活动数据
     * @param $type
     * @param int $number
     * @return array
     * @author 刘峻廷
     */
    public function takeActions($type, $status = null,$number = 3)
    {

        if (!isset($type)) return ['status' => false, 'msg' => '缺少参数'];

        if (isset($status)) {
            $where = ['type' => $type, 'status' => $status];
        } else {
            $where = ['type' => $type];
        }

        $result = self::$actionStore->takeActions($where,$number);

        if ($result) return ['status' => true, 'msg' => $result];

        Log::error('拿取三条活动数据失败', $result);

        return ['status' => false, 'msg' => '查询失败'];
    }

    /**
     * 字符限制，添加省略号
     * @param $words
     * @param $limit
     * @return string
     * @author 刘峻廷
     */
    public function wordLimit($words, $filed,$limit)
    {
        foreach($words as $word){
            $content = trim($word->$filed);
            $content = mb_substr($content, 0, $limit, 'utf-8').' ...';;
            $word->$filed = $content;
        }

    }
}