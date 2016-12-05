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

    public function delWebAdmin ($data)
    {
        if (empty($data)) return false;
        return DB::table(self::$table)->where($data)->delete();
    }
}