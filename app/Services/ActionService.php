<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/17
 * Time: 13:51
 */

namespace App\Services;
use App\Store\ActionStore;
use App\Tools\Common;

class ActionService
{
    /**
     * 引入活动数据仓储层
     */
    protected static $actionStore;
    protected static $common;
    public function __construct(ActionStore $actionStore)
    {
        self::$actionStore = $actionStore;
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
        if($endtime>$starttime&&$starttime>$deadline){
            return ['status'=>true];
        }elseif($endtime<$starttime){
            return ['status'=>true,"msg"=>"结束日期不可早于开始日期"];
        }elseif($endtime<$deadline){
            return ['status'=>true,"msg"=>"结束日期不可早于报名截止日期"];
        }else{
            return ['status'=>true,"msg"=>"开始日期不可早于报名截止日期"];
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
        $forPages = 10;//一页的数据
        $nowPages = isset($data["nowPages"])?(int)$data["nowPages"]:1;
        $status = $data["status"];
        $type = $data["type"];
        $where =[];
        if($status){
            $where["status"] = $status;
        }
        if($type){
            $where["type"] = $type;
        }
        $creatPage = Common::getPageUrls($request,"data_action_info","action/create",$forPages,null,$where);
        if(isset($creatPage)){
            $result["page"]=$creatPage;
        }else{
            return ['status'=>false,'msg'=>'生成分页样式发生错误'];
        }
        $Data = self::$actionStore->forPage($nowPages,$forPages,$where);
        if($Data["status"]){
            $result["data"] = $Data["data"];
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>"数据参数有误！"];
        }
    }
}