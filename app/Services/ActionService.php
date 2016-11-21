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
use App\Tools\Common;
use Illuminate\Support\Facades\DB;

class ActionService
{
    /**
     * 引入活动数据仓储层
     */
    protected static $actionStore;
    protected static $actionOrderStore;
    protected static $common;
    public function __construct(ActionStore $actionStore,ActionOrderStore $actionOrderStore)
    {
        self::$actionStore = $actionStore;
        self::$actionOrderStore = $actionOrderStore;
    }

    /**
     * 查询对应活动类型的所有活动数据
     * @param $type
     * @return array
     * @author 郭庆
     */
    public static function selectByType($type)
    {
        $data = self::$actionStore->getData(['type'=>$type]);
        if($data)return ['status'=>true,'msg'=>$data];
        return ['status'=>false,'msg'=>'暂时没有本活动信息'];
    }

    /**
     * 报名活动.
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function actionOrder($data)
    {
        $action = self::$actionOrderStore->getSomeField(['user_id'=>$data['user_id']],'action_id');
        $isHas = in_array($data['action_id'],$action);
        if($isHas)return ['status'=>false,'msg'=>'已经报名参加'];
        $data['time'] = date("Y-m-d H:i:s",time());
        DB::beginTransaction();
        try{
            $result = self::$actionOrderStore->addData($data);
            $res = self::$actionStore->incrementData(['guid'=>$data['action_id']],'people',1);
            if($res && $result){
                DB::commit();
                return ['status' => true, 'msg' => '报名成功'];
            }
        }catch (Exception $e){
            Log::error('报名失败', [$data]);
            DB::rollback();
            return ['status' => false, 'msg' => '报名失败'];
        }
    }

    /**
     * 获取指定用户所报名参加的所有活动.
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public static function getAction($user)
    {
        $action = self::$actionOrderStore->getSomeField(['user_id'=>$user],'action_id');
        return $action;
    }
    /**
     * 发布活动
     * @param $data
     * @return array
     * author 张洵之
     */
    public function insertData($data)
    {
        unset($data["_token"]);
        $data["guid"] = Common::getUuid();
        $data["time"] = date("Y-m-d H:i:s",time());
        $data["change_time"] = date("Y-m-d H:i:s",time());
        $temp = $this->checkTime($data);
        if($temp["status"]){
            $result = self::$actionStore->insertData($data);
        }else{
            return ['status'=>false,'msg'=>$temp["msg"]];
        }
        if(isset($result)){
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>'存储数据发生错误'];
        }
    }

    /**
     * 检查日期是否合乎逻辑
     * @param $data
     * @return bool
     * author 张洵之
     */
    public function checkTime($data)
    {
        $endtime = strtotime($data["end_time"]);
        $deadline = strtotime($data["deadline"]);
        $starttime = strtotime($data["start_time"]);
        if($endtime>$starttime&&$starttime>$deadline&&$deadline>time()){
            return ['status'=>true];
        }elseif($endtime<$starttime){
            return ['status'=>false,"msg"=>"结束日期不可早于开始日期"];
        }elseif($endtime<$deadline){
            return ['status'=>false,"msg"=>"结束日期不可早于报名截止日期"];
        }elseif($deadline<time()){
            return ['status'=>false,"msg"=>"报名截止日期不可早于当前日期"];
        }else{
            return ['status'=>false,"msg"=>"开始日期不可早于报名截止日期"];
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
        $data = $request->all();
        $forPages = 1;//一页的数据
        $nowPage = isset($data["nowPage"])?(int)$data["nowPage"]:1;
        $status = $data["status"];
        $type = $data["type"];
        $where =[];
        if($status){
            $where["status"] = $status;
        }
        if($type!="null"){
            $where["type"] = $type;
        }
        $creatPage = Common::getPageUrls($data,"data_action_info","/action/create",$forPages,null,$where);
        if(isset($creatPage)){
            $result["pages"]=$creatPage['pages'];
        }else{
            return ['status'=>false,'msg'=>'生成分页样式发生错误'];
        }
        $Data = self::$actionStore->forPage($nowPage,$forPages,$where);
        if($Data || empty($Data)){
            $result["data"] = $Data;
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>"数据参数有误！"];
        }
    }

    /**
     * 查询相关数据
     * @param $guid
     * @return array
     * author 张洵之
     */
    public function getData($guid)
    {
        if(!is_string($guid)){
            return ['status'=>false,'msg'=>"缺少参数！"];
        }
        $Data = self::$actionStore->getData(["guid"=>$guid]);
        if($Data){
            $result["data"] = $Data;
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>"数据参数有误！"];
        }
    }

    /**
     * 修改活动状态
     * @param $guid
     * @param $status
     * @return array
     * author 张洵之
     */
    public function changeStatus($guid,$status)
    {
        if(!(isset($guid)&&isset($status))){
            return ['status'=>false,'msg'=>"参数有误 ！"];
        }
        if($status == 1){
            $status = 3;
        }else{
            $status = 1;
        }
        $Data = self::$actionStore->upload(["guid"=>$guid],["status"=>$status]);
        if($Data){
            $result["data"] = $Data;
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>"数据参数有误！"];
        }
    }

    /**
     * 修改互动内容
     * @param $where
     * @param $data
     * @return array
     * author 张洵之
     */
    public function upDta($where,$data)
    {
        $Data = self::$actionStore->upload($where,$data);
        if($Data){
            $result["data"] = $Data;
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>"数据参数有误！"];
        }
    }

    /**
     * @param $guid
     * author 张洵之
     */
    public function getOrderInfo($guid)
    {
        $where = ["action_id"=>$guid];
        $result = self::$actionOrderStore->getSomeData($where);
        if($result){
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>"数据暂无数据！"];
        }
    }
    /**
     * 修改活动报名状态
     * @author 郭庆
     */
    public function orderStatus($guid,$status)
    {
        if(!(isset($guid)&&isset($status))){
            return ['status'=>false,'msg'=>"参数有误 ！"];
        }
        if($status == 1){
            $status = 2;
        }else{
            $status = 1;
        }
        $Data = self::$actionOrderStore->updateData(["id"=>$guid],["status"=>$status]);
        if($Data){
            $result["data"] = $Data;
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>"数据参数有误！"];
        }
    }
}