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
            $maxGold = 0;
        }
        //累计支持金额(万)
        $totalAmount = self::$crowdFundingStore->fieldSum("fundraising_now");
        if($totalAmount){
            $totalAmount = $totalAmount/10000 > 1?intval($totalAmount/10000)."万":$totalAmount;
        }else{
            $totalAmount = 0;
        }
        //单项最高支持人数(万)
        $maxPeoples = self::$crowdFundingStore->selectMaxOne("Number_of_participants");
        if($maxPeoples){
            $maxPeoples = $maxPeoples/10000 > 1?intval($maxPeoples/10000)."万":$maxPeoples;
        }else{
            $maxPeoples = 0;
        }
        if($maxGold||$totalAmount||$maxPeoples){
            $result = ["maxGold" => $maxGold,"totalAmount" => $totalAmount,"maxPeoples" => $maxPeoples];
        }else{
            $result = ['status'=>400,'msg'=>'请求错误'];
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
        $field = "guid";
        $projectIdArr = self::$crowdFundingStore->getList($where,$field,$page,16);
        $projectIdArr = isset($projectIdArr)?$projectIdArr:[];
        $projectArr = self::$projectInfoStore->getList("guid",$projectIdArr);
        $projectArr = isset($projectArr)?$projectArr:['status'=>400,'msg'=>'请求错误'];
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
            return ["endPage"=>$result];
        }else{
            return ['status'=>400,'msg'=>'请求错误'];
        }
    }
}