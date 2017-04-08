<?php
/**
 * 用户仓库层
 * User: wangtong
 * Date: 2016/11/8
 * Time: 19:43
 */
namespace App\Store;
use DB;

class OpenIMStore
{

    protected static $table = 'data_im_login';

    /**
     * 判断账号是会否存在
     * @param $data
     * @return bool
     * @author 杨志宇
     */
    public function getInfo ($data)
    {
        if (empty($data)) return false;
        return DB::table(self::$table)->where($data)->first();
    }

    /**
     * 把IM账号信息保存到数据库
     * @param $data
     * @return bool
     * @author 杨志宇
     */
    public function insertInfo ($data)
    {
        if (empty($data)) return false;
        return DB::table(self::$table)->insert($data);
    }

}
