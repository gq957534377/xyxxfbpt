<?php
/**
 * 后台数据仓库层
 * User: Twitch
 * Date: 2016/11/4
 * Time: 10:05
 */
namespace App\Store;

use Illuminate\Support\Facades\DB;

/**
 * Class AdminStore
 * 后台数据处理仓库层
 *
 * @package App\Store
 */
class AdminStore{
    // 表名
    protected static $table = 'data_admin_login';

    /**
     * 查询一条数据
     * @param array $where
     * @return one data
     * @ auther 郭庆
     */
    public function getOneData($where)
    {
        // 条件是否存在
        if(empty($where)) return false;
        // 返回指定数据
        return DB::table(self::$table)
                         ->where($where)
                         ->first();
    }

    /**
     * 查询所有数据
     * @return mixed
     * @auther 郭庆
     */
    public function getAllData()
    {
        // 返回指定表中说有数据
        return DB::table(self::$table)->get();
    }
    /**
     * 添加记录到数据
     * @param array $data
     * @return bool
     * @auther 郭庆
     */
    public function addData($data)
    {
        if (empty($data)) return false;
        return DB::table(self::$table)->insert($data);
    }

    /**
     * 更新记录到数据库
     * @param array $where
     * @param array $data
     * @return bool
     * @auther 郭庆
     */
    public function updateData($where,$data)
    {
        if(empty($where) || empty($data)) return false;
        return DB::table(self::$table)
                         ->where($where)
                         ->update($data);
    }
}
