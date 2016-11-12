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
        $where = ["project_type"=>$class];
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

    public function startCrowdFuding($request)
    {
        $requestArr = $request->all();
        unset($requestArr["_token"]);//移出token
        $where = ["project_id"=>$requestArr["project_id"]];
        $requestArr["status"] = 1;
        $requestArr["changetime"] = date("Y-m-d H:i:s",time());
        $result = self::$crowdFundingStore->uplodData($where,$requestArr);
        if(isset($result)){
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>'发生错误'];
        }
    }
}