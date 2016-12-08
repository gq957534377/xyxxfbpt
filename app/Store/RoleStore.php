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
     * 获取分页数据
     * @param array $condition
     * @return mixed
     * @author 王飞龙
     */
    public function getUsersData($nowPage, $condition =[])
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
     * @author 王飞龙
     */
    public function getUsersNumber($condition = [])
    {
        if(empty($condition)) return DB::table(self::$table)->count();
        return DB::table(self::$table)->where($condition)->count();
    }

    /**
     * 添加申请创业者信息
     * @param array $data
     * @return bool
     * @author 刘峻廷
     */
    public function addRole($data)
    {
        // 检验数据是否存在
       if(empty($data)) return false;
        return DB::table(self::$table)->insert($data);
    }

    /**
     * 获取指定申请者信息
     * @param $where
     * @return bool
     * @author 刘峻廷
     */
    public function getRole($where)
    {
        // 条件检测
        if (empty($where)) return false;
        return DB::table(self::$table)->where($where)->first();
    }

     /** 获取一条数据
     * @param $condition
     * @return bool
     * @author 王飞龙
     */
    public function getOneData($condition)
    {
        if (empty($condition)) return false;
        return DB::table(self::$table)->where($condition)->first();
    }

    /**
     * 修改数据
     * @param $where
     * @param $data
     * @return bool
     * @author 王飞龙
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
     * @author 王飞龙
     */
    function deleteData($condition = [])
    {
        if(empty($condition)) return false;
        return DB::table(self::$table)->where($condition)->delete();
    }

    /**
     * 获取指定条件的数据
     * @param $where
     * @return bool
     * @author 贾济林
     */
    public function getList($where)
    {
        if(empty($where)) return false;
        return DB::table(self::$table)->where($where)->get();
    }
}