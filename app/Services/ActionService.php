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

    public function insertData($data)
    {
        unset($data["_token"]);
        $data["guid"] = Common::getUuid();
        $data["time"] = date("Y-m-d H:i:s",time());
        $data["change_time"] = date("Y-m-d H:i:s",time());
        $result = self::$actionStore->insertData($data);
        if(isset($result)){
            return ['status'=>true,'msg'=>$result];
        }else{
            return ['status'=>false,'msg'=>'存储数据发生错误'];
        }
    }


}