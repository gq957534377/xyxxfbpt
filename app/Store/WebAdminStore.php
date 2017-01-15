<?php
/**
 * Created by PhpStorm.
 * User: wangt
 * Date: 2016/12/5
 * Time: 17:23
 */

namespace App\Store;

use DB;

class WebAdminStore
{
    protected static $table = 'data_web_info';

    /**
     * 更新网站管理表数据
     * @param $data
     * @return bool
     * @author 王通
     */
    public function saveWebAdmin($data)
    {
        if (empty($data)) return false;
        return DB::table(self::$table)->insert($data);
    }

    /**
     * 软删除旧信息
     * @param $data
     * @return bool
     * @author 王通
     */
    public function delWebAdmin($id)
    {
        if (empty($id)) return false;
        return DB::table(self::$table)
            ->where('id', $id)
            ->update(['status' => 4]);
    }

    /**
     * 但条件查询未删除的记录
     * @param $data
     * @return bool
     */
    public function selectWebAdminId($data)
    {
        if (empty($data)) return false;
        return DB::table(self::$table)
            ->where($data)
            ->where('status', '<>', 4)
            ->select('id')
            ->first();
    }

    /**
     * 得到表中未被软删除的数据
     * @return mixed
     * @author 王通
     */
    public function getConfig()
    {
        return DB::table(self::$table)
            ->where('status', '<>', 4)
            ->get();
    }


    /**
     * 查询网站基本信息
     * @return mixed
     * @author 王通
     */
    public function getWebInfo()
    {
        return DB::table(self::$table)
            ->where('status', 1)
            ->get();
    }

    /**
     * 得到指定id的数据
     * @param
     * @author 王通
     */
    public function getOneWebInfo ($where)
    {
        if (empty($where)) return false;
        return DB::table(self::$table)
            ->where($where)
            ->first();
    }

    /**
     * 计算符合条件的总条数
     * @param $where
     * @return int
     * @author 郭庆
     */
    public function getCount($where)
    {
        return DB::table(self::$table)
            ->where($where)
            ->count();
    }

    /**
     *拿取同一个字段下的所有数据
     * @param $where
     * @return mixed
     * author 郭庆
     */
    public function getList($where,$filed)
    {
        return DB::table(self::$table)->where($where)->orderBy('addtime','desc')->lists($filed);
    }
}