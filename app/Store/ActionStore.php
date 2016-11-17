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

    /**
     * 插入数据
     * @param $data
     * @return null
     * author 张洵之
     */
    public function insertData($data)
    {
        if(!is_array($data)) return null;
        $result = DB::table(self::$table)->insertGetId($data);
        return $result;
    }

    /**
     * 分页查询数据
     * @param $page
     * @param $tolPage
     * @param $where
     * @return null
     * author 张洵之
     */
    public function forPage($page,$tolPage,$where)
    {
        if(!is_int($page)||!is_int($tolPage) ||!is_array($where))return null;
        $result["data"] = DB::table(self::$table)->where($where)->orderBy("change_time","desc")->forPage($page,$tolPage)->get();
        $result["status"] = true;
        return $result;
    }

    /**
     * 基本条件查询
     * @param $where
     * @return null
     * author 张洵之
     */
    public function getData($where)
    {
        if(!is_array($where)) return null;
        $result["data"] = DB::table(self::$table)->where($where)->get();
        $result["status"] = true;
        return $result;
    }
}