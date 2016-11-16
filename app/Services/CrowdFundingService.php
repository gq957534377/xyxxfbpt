<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/9
 * Time: 14:11
 */

namespace App\Services;

use App\Store\CrowdFundingStore;
use App\Store\ProjectStore;
use App\Tools\Common;
use DB;

class CrowdFundingService
{
    protected static $crowdFundingStore = null;
    protected static $projectStore = null;

    public function __construct(CrowdFundingStore $crowdFundingStore,ProjectStore $ProjectStore)
    {
        self::$crowdFundingStore = $crowdFundingStore;
        self::$projectStore = $ProjectStore;
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
        if(isset($maxGold)){
            $maxGold = $maxGold/10000 >1?intval($maxGold/10000)."万":$maxGold;
        }else{
            return ['status'=>false,'msg'=>'发生错误1'];
        }
        //累计支持金额(万)
        $totalAmount = self::$crowdFundingStore->fieldSum("fundraising_now");
        if(isset($totalAmount)){
            $totalAmount = $totalAmount/10000 > 1?intval($totalAmount/10000)."万":$totalAmount;
        }else{
            return ['status'=>false,'msg'=>'发生错误2'];
        }
        //单项最高支持人数(万)
        $maxPeoples = self::$crowdFundingStore->selectMaxOne("Number_of_participants");
        if(isset($maxPeoples)){
            $maxPeoples = $maxPeoples/10000 > 1?intval($maxPeoples/10000)."万":$maxPeoples;
        }else{
            return ['status'=>false,'msg'=>'发生错误3'];
        }
        if(isset($maxGold)||isset($totalAmount)||isset($maxPeoples)){
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
    public function dynamicDataList($id,$request)
    {
        $page = (int)$request->input("nowPage");
        $page = isset($page)?$page:1;
        $where = ["project_type"=>$id,"status"=>1];
        $field = "project_id";
        $creatPage = Common::getPageUrls($request->all(),"crowd_funding_data","crowd_funding/".$id,4,null,$where);
        $projectIdArr = self::$crowdFundingStore->getList($where,$field,$page,4);
        $projectIdArr = isset($projectIdArr)?$projectIdArr:[];
        $projectArr = self::$projectStore->getWhereIn("project_id",$projectIdArr);//项目信息
        $crowdinfoArr =self::$crowdFundingStore->getWhereIn("project_id",$projectIdArr);//众筹信息
        if(isset($crowdinfoArr)&&isset($projectArr)){
            return ['status'=>true,'msg'=>["projectInfo"=>$projectArr,"crowdInfo"=>$crowdinfoArr,"forPage"=>$creatPage]];
        }
            return ['status'=>false,'msg'=>'数据为空'];
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
        $result = self::$crowdFundingStore->getWhere($where);
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
        $status = $request->input("status");
        $tolPages = 5;//一页的数据条数
        $where = [$status];
        $creatPage = Common::getPageUrls($request,"crowd_funding_data","crowd_forpage",$tolPages,"status",$where);
        if(isset($creatPage)){
            $result["page"]=$creatPage;
        }else{
           return ['status'=>false,'msg'=>'生成分页样式发生错误'];
        }
        $nowPage =(int)$request->input("nowPage");
        $dbDatearr = self::$crowdFundingStore->forPage($nowPage,$tolPages,["status"=>$status]);
        $result["data"] = $this->forPageHtml($dbDatearr,$status);
        if(isset($result)){
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>'发生错误'];
        }
    }

    /**
     * 分页方法附属方法
     * @param $data
     * @param $myStatus
     * @return null
     * author 张洵之
     */
    public function forPageHtml($data,$myStatus)
    {
        if(!is_array($data)||!isset($myStatus)) return null;
            $arrNum =count($data);
            for ($i=0;$i<$arrNum;$i++){
                $status = $data[$i]->status;
                if($status == 1){
                        $data[$i]->btn ="<div class='btn-group' zxz-id='".$data[$i]->project_id."'><button zxz-type='revise' class='btn btn-sm btn-success '> <i class='fa fa-wrench'></i> </button><button zxz-type='close' class='btn btn-sm btn-danger '> <i class='fa fa-remove'></i></button></div>";
                }else{
                    $data[$i]->btn ="<div class='btn-group' zxz-id='".$data[$i]->project_id."'><button zxz-type='publish' class='btn btn-sm btn-primary '><i class='fa fa-keyboard-o'></i></div>";
                }
            }
            return $data;
    }

    /**
     * 查看可发布项目的标题
     * @return array
     * @author 张洵之
     */
    public function selectPublish()
    {
        $where = ["status"=>"3","crowd_status"=>0];
        $result = self::$projectStore->getData($where);
        if(isset($result)){
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>'发生错误'];
        }
    }

    /**
     * 创建发布众筹项目；
     * @param array $data
     * @return array
     * @author 张洵之
     */
    public function insertCrowdFunding($data,$project_status)
    {
        if(!is_array($data)||!is_array($project_status))return['status'=>false,'msg'=>'数据应该为一个数组'];
        $result = DB::transaction(function() use($data,$project_status)
        {
            self::$projectStore->update(["project_id"=>$data["project_id"]],$project_status);
            self::$crowdFundingStore->insertData($data);
            return true;
        });
        if(isset($result)){
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>'存储数据发生错误'];
        }
    }

    /**
     * put方法Server层路由
     * @param $request
     * @param $id
     * @return array
     * @author 张洵之
     */
    public function serverRoute($request,$id)
    {
        switch ($id){
            case "publish":return $this->insertCrowd($request);break;
            case "updata":return $this->updataCrowd($request);break;
        }
    }

    /**
     * 创建存储数据
     * @param $request
     * @return array
     * @author 张洵之
     */
    public function createUplodData($request)
    {
        $data = $request->all();
        unset($data["_token"]);
        unset($data["_method"]);
        $time = 24*3600*$data["days"];
        $endtime = 24*3600*$data["enddays"];
        $data["starttime"] = date("Y-m-d H:i:s",time()+$time);
        $data["endtime"] = date("Y-m-d H:i:s",time()+$endtime);
        unset($data["days"]);
        unset($data["enddays"]);
        $data["status"] = 1;
        return $data;
    }

    /**
     * 创建众筹项目
     * @param $request
     * @return array
     * @author 张洵之
     */
    public function insertCrowd($request)
    {
        $data = $this->createUplodData($request);
        $project_status["crowd_status"] = 1;
        $result = $this ->insertCrowdFunding($data,$project_status);
        if($result["status"]){
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>$result['msg']];
        }
    }

    /**
     * 更新众筹数据
     * @param $request
     * @return array
     * author 张洵之
     */
    public function updataCrowd($request)
    {
        $data = $this->createUplodData($request);
        $result = self::$crowdFundingStore->uplodData(["project_id"=>$data["project_id"]],$data);
        if($result){
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>$result];
        }
    }


    public function crowdContent($project_id)
    {
        $where = ["project_id"=>$project_id];
        $pojectInfo = self::$projectStore->getData($where);
        $crowdInfo = self::$crowdFundingStore->getWhere($where);
        $result = ["pojectInfo"=>$pojectInfo,"crowdInfo"=>$crowdInfo];
        if($result){
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>$result];
        }
    }
}
