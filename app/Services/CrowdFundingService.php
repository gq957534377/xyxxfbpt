<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/9
 * Time: 14:11
 */

namespace App\Services;

use App\Store\CrowdFundingStore;
use App\Store\ProjectInfoStore;
use App\Tools\Common;

class CrowdFundingService
{
    protected static $crowdFundingStore = null;
    protected static $projectInfoStore = null;

    public function __construct(CrowdFundingStore $crowdFundingStore,ProjectInfoStore $projectInfoStore)
    {
        self::$crowdFundingStore = $crowdFundingStore;
        self::$projectInfoStore = $projectInfoStore;
    }
    /**
     * 返回众筹首页所需动态数据
     *
     * @return array
     * @author 张洵之
     */
    public function dynamicDataIndex()
    {
        //单项最高筹集金额(万)
        $maxGold = self::$crowdFundingStore->selectMaxOne("fundraising_now");
        if($maxGold){
            $maxGold = $maxGold/10000 >1?intval($maxGold/10000)."万":$maxGold;
        }else{
            return ['status'=>false,'msg'=>'发生错误'];
        }
        //累计支持金额(万)
        $totalAmount = self::$crowdFundingStore->fieldSum("fundraising_now");
        if($totalAmount){
            $totalAmount = $totalAmount/10000 > 1?intval($totalAmount/10000)."万":$totalAmount;
        }else{
            return ['status'=>false,'msg'=>'发生错误'];
        }
        //单项最高支持人数(万)
        $maxPeoples = self::$crowdFundingStore->selectMaxOne("Number_of_participants");
        if($maxPeoples){
            $maxPeoples = $maxPeoples/10000 > 1?intval($maxPeoples/10000)."万":$maxPeoples;
        }else{
            return ['status'=>false,'msg'=>'发生错误'];
        }
        if($maxGold||$totalAmount||$maxPeoples){
            $result = ['status'=>true,'msg'=>["maxGold" => $maxGold,"totalAmount" => $totalAmount,"maxPeoples" => $maxPeoples]];
        }else{
            $result = ['status'=>false,'msg'=>'发生错误'];
        }
        return $result;
    }
    /**
     * 返回众筹列表页所需动态数据
     *@param object $request
     * @return array
     * @author 张洵之
     */
    public function dynamicDataList($request)
    {
        $class = $request->input("type");
        $page = (int)$request->input("page");
        $where = ["project_type"=>$class,"status"=>1];
        $field = "project_id";
        $projectIdArr = self::$crowdFundingStore->getList($where,$field,$page,16);
        $projectIdArr = isset($projectIdArr)?$projectIdArr:[];
        $projectArr = self::$projectInfoStore->getList("project_id",$projectIdArr);
        $projectArr = isset($projectArr)?['status'=>true,'msg'=>$projectArr]:['status'=>false,'msg'=>'发生错误'];
        return $projectArr;
    }

    /**
     * 返回总页数
     * @param $id
     * @return array
     * @author 张洵之
     */
    public function endPage($id)
    {
        $where = ["project_type"=>$id];
        $result = self::$crowdFundingStore->selectListNum($where);
        if(isset($result)){
            $result = ceil($result/16);
            return ['status'=>true,'msg'=>["endPage"=>$result]];
        }else{
            return ['status'=>false,'msg'=>'发生错误'];
        }
    }

    /**
     * 判断请求信息类型
     * @param $id
     *@return array
     * @author 张洵之
     */
    public function AdminShow($id)
    {
        $type = explode("_",$id)[1];//请求类型判断
        $projectId = explode("_",$id)[0];
        switch ($type){
            case "publish":return $this->publish($projectId);break;
            case "revise":return $this->revise($projectId);break;
            case "close":return $this->close($projectId);break;
            default:return ['status'=>false,'msg'=>'发生错误'];
        }
    }

    /**
     * 查询申报众筹项目资料
     * @param $projectId
     * @return array
     * @author 张洵之
     */
    public function publish($projectId)
    {
        $where = ["project_id"=>$projectId];
        $result = self::$projectInfoStore->getRecord($where);
        if(isset($result)){
            $result["type"] = "publish";
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>'发生错误'];
        }
    }

    /**
     * 查询某条记录详细信息
     * @param $projectId
     * @return array
     */
    public function revise($projectId)
    {
        $where = ["project_id"=>$projectId];
        $result = self::$crowdFundingStore->getWhere($where);
        $endDay =  floor((strtotime($result[0]->endtime)-time())/(3600*24));
        $endHour = floor(((strtotime($result[0]->endtime)-time())/(3600*24) - $endDay)*24);
        $endScend =floor((((strtotime($result[0]->endtime)-time())/(3600*24) - $endDay)*24 - $endHour)*60);
        $result[0]->endtime =$endDay."天".$endHour."时".$endScend."分";
        if(isset($result)){
            $result["type"] = "revise";
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>'发生错误'];
        }
    }

    function close($projectId){
        $where = ["project_id"=>$projectId];
        $requestArr = ["status"=>"0"];
        $resultArr = self::$crowdFundingStore->uplodData($where,$requestArr);
        if(isset($resultArr)){
            $result["type"] = "close";
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>'发生错误'];
        }
    }

    /**
     * 执行众筹发布
     * @param $request
     * @return array
     * @author 张洵之
     */
    public function startCrowdFuding($request)
    {
        $requestArr = $request->all();
        unset($requestArr["_token"]);//移出token
        $where = ["project_id"=>$requestArr["project_id"]];
        $requestArr["status"] = 1;
        $time = 24*3600*$requestArr["days"];
        unset($requestArr["days"]);
        $requestArr["endtime"] = date("Y-m-d H:i:s",time()+$time);
        $result = self::$crowdFundingStore->uplodData($where,$requestArr);
        if(isset($result)){
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>'发生错误'];
        }
    }

    /**
     * 修改众筹表
     * @param $request
     * @return array
     * @author 张洵之
     */
    public function reviseCrowdFunding($request)
    {
        $requestArr = $request->all();
        unset($requestArr["_token"]);//移出token
        $where = ["project_id"=>$requestArr["project_id"]];
        $addTime =24*3600*$requestArr["days"] + 3600*$requestArr["hour"];
        unset($requestArr["days"]);//移出days
        unset($requestArr["hour"]);//移出hour
        $arr = self::$crowdFundingStore->getWhere($where);
        $endTime = strtotime($arr[0]->endtime) + $addTime ;
        $requestArr["endtime"] = date("Y-m-d H:i:s",$endTime);
        $result = self::$crowdFundingStore->uplodData($where,$requestArr);
        if(isset($result)){
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>'发生错误'];
        }
    }

    /**
     * 生成分页样式
     * @param $request
     * @return array
     * @author 张洵之
     */
    public function forPage($request)
    {
        $tolPages = 5;//一页的数据条数
        $where = [0,1];
        $creatPage = Common::getPageUrls($request,"crowd_funding_data","crowd_forpage",$tolPages,"status",$where);
        if(isset($creatPage)){
            $result["page"]=$creatPage;
        }else{
           return ['status'=>false,'msg'=>'生成分页样式发生错误'];
        }
        $nowPage =(int)$request->input("nowPage");
        $dbDatearr = self::$crowdFundingStore->forPage($nowPage,$tolPages);
        if(isset($dbDatearr)){
            $arrNum =count($dbDatearr);
            for ($i=0;$i<$arrNum;$i++){
                $status = $dbDatearr[$i]->status;
                if($status == "1"){
                    $dbDatearr[$i]->btn ="<div class='btn-group' zxz-id='".$dbDatearr[$i]->project_id."'><button zxz-type='revise' class='btn btn-sm btn-success '> <i class='fa fa-wrench'></i> </button><button zxz-type='close' class='btn btn-sm btn-danger '> <i class='fa fa-remove'></i></button></div>";
                }elseif($status == "0")
                {
                    $dbDatearr[$i]->btn ="<div class='btn-group' zxz-id='".$dbDatearr[$i]->project_id."'><button zxz-type='publish' class='btn btn-sm btn-primary '><i class='fa fa-keyboard-o'></i></div>";
                }else{
                    unset($dbDatearr[$i]);
                }
            }
        }else{
            return ['status'=>false,'msg'=>'读取数据发生错误'];
        }
        $result["data"] = $dbDatearr;
        if(isset($result)){
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>'发生错误'];
        }
    }

    /**
     * 查看可发布项目的标题
     * @return array
     * @author 张洵之
     */
    public function selectPublish()
    {
        $where = ["status"=>"3"];
        $result = self::$projectInfoStore->getRecord($where);
        if(isset($result)){
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>'发生错误'];
        }
    }

    /**
     * 创建待发布中筹项目；
     * @param array $data
     * @return array
     * @author 张洵之
     */
    public function insertCrowdFunding($data)
    {
        if(!is_array($data))return['status'=>false,'msg'=>'数据应该为一个数组'];
        $result = self::$crowdFundingStore->insertData($data);
        if(isset($result)){
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>'发生错误'];
        }
    }
}
