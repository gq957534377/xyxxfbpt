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
        if($temp){
            $result = self::$actionStore->insertData($data);
        }else{
            return ['status'=>false,'msg'=>'日期前后错误，请认真填写！'];
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
            return true;
        }else{
            return false;
        }
    }

}