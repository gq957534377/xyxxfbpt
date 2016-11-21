<?php
/**
 * 前台数据仓库层.
 * User: Twitch
 * Date: 2016/11/8
 * Time: 8:58
 */
namespace App\Store;

use Illuminate\Support\Facades\DB;

class HomeStore {
    // 表名
    protected static $table = "data_user_login";

    /**
     * 查询一条记录
     * @param array $where
     * @return bool
     * @author 刘峻廷
     */
    public function getOneData($where)
    {
        // 条件存在否
        if(empty($where)) return false;
        // 返回查询记录
        return DB::table(self::$table)->where($where)->first();
    }

    /**
     * 添加一条数据
     * @param array $data
     * @return bool
     * @author 刘峻廷
     */
    public function addData($data)
    {
        // 判断数据是否存在
        if(empty($data)) return false;
        // 添加数据
        return DB::table(self::$table)->insert($data);
    }

    /**
     * 数据修改
     * @param array $where
     * @param array $data
     * @return bool
     * @author 刘峻廷
     */
    public function updateData($where,$data)
    {
        // 数据判断是否存在
        if(empty($where) || empty($data)) return false;
        // 修改数据
        return DB::table(self::$table)->where($where)->update($data);
    }
}
