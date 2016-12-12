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
    protected static $table = 'data_web_administrate';

    /**
     * 更新网站管理表数据
     * @param $data
     * @return bool
     * @author 王通
     */
    public function saveWebAdmin ($data)
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
    public function delWebAdmin ($id)
    {
        if (empty($id)) return false;
        return DB::table(self::$table)
            ->where('id', $id)
            ->update(['state' => '4']);
    }

    /**
     * 但条件查询未删除的记录
     * @param $data
     * @return bool
     */
    public function selectWebAdminId ($data)
    {
        if (empty($data)) return false;
        return DB::table(self::$table)
            ->where($data)
            ->where('state', '<>', 4)
            ->select('id')
            ->first();
    }

    /**
     * 得到表中未被软删除的数据
     * @return mixed
     * @author 王通
     */
    public function getConfig ()
    {
        return DB::table(self::$table)
            ->where('state', '<>', 4)
            ->get();
    }


    /**
     * 查询网站基本信息
     * @return mixed
     * @author 王通
     */
    public function getWebInfo ()
    {
        return DB::table(self::$table)
            ->where('state', 1)
            ->whereIn('name',['tel', 'time', 'email', 'record'])
            ->get();
    }
}