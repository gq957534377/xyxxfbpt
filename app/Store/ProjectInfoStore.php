<?php
/**
 * 项目信息表数据仓储层.
 * User: 张洵之
 * Date: 2016/11/10
 * Time: 15:25
 */

namespace App\Store;

use DB;

class ProjectInfoStore
{

    //表名
    protected static $table = 'project_info_data';
    /**
     * 分页获得指定条件内容
     * @param string $filed array $where
     * @return array
     * author 张洵之
     */
    public function getList($filed,$where)
    {
        if(!is_string($filed)||!is_array($where))return null;
        $result = DB::table(self::$table)->whereIn($filed,$where)->get();
        return $result;
    }

    /**
     * 简单基本查询
     * @param $where
     * @return null
     * author
     */
    public function getRecord($where)
    {
        if(!is_array($where))return null;
        $result = DB::table(self::$table)->where($where)->get();
        return $result;
    }
}