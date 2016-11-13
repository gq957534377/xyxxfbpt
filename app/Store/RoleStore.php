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
     * @param array $condition
     * @return mixed
     * @author wang fei long
     */
    function getUsersData($nowPage, $condition =[])
    {
        if(empty($nowPage)) return false;
        // 检验条件是否存在
        if(empty($condition)) DB::table(self::$table)->forPage($nowPage, PAGENUM)->get();
        // 获取数据
        return DB::table(self::$table)->where($condition)->forPage($nowPage, PAGENUM)->get();
    }

    /**
     * 依条件获取记录条数
     * @param $condition
     * @return mixed
     * @author wang fei long
     */
    function getUsersNumber($condition = [])
    {
        if(empty($condition)) return DB::table(self::$table)->count();
        return DB::table(self::$table)->where($condition)->count();
    }

    /**
     * 获取一条数据
     * @param $condition
     * @return bool
     * @author wang fei long
     */
    public function getOneData($condition)
    {
        if (empty($condition)) return false;
        return DB::table(self::$table)->where($condition)->first();
    }

    /**
     * @param $where
     * @param $data
     * @return bool
     * @author wang fei long
     */
    public function updateUserInfo($where,$data)
    {
        // 检验参数是否存在
        if(empty($where) || empty($data)) return false;
        // 指定条件，修改数据
        return DB::table(self::$table)->where($where)->update($data);

    }

    /**
     * @param array $condition
     * @return bool
     * @author wang fei long
     */
    function deleteData($condition = [])
    {
        if(empty($condition)) return false;
        return DB::table(self::$table)->where($condition)->delete();
    }
}