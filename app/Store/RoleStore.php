<?php
/**
 * 操作data_role_info数据表
 * User: wang fei long
 * Date: 2016/11/10
 * Time: 18:10
 */

namespace App\Store;


use Illuminate\Support\Facades\DB;

class RoleStore
{
    // 表名
    protected static $table = 'data_role_info';

    /**
     * @param $condition
     * @return bool
     * @author wang fei long
     */
    function getUsers($condition)
    {
        // 检验条件是否存在
        if(empty($condition)) return false;
        // 获取数据
        return DB::table(self::$table)->where($condition)->get();
    }
}