<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/17
 * Time: 13:52
 * 活动信息表数据仓储层
 */

namespace App\Store;
use DB;

class ActionStore
{
    protected static $table ="data_action_info";

    public function insertData($data)
    {
        if(!is_array($data)) return null;
        $result = DB::table(self::$table)->insertGetId($data);
        return $result;
    }
}