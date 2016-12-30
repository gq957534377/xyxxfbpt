<?php
/**
 * Created by PhpStorm.
 * User: wangt
 * Date: 2016/12/30
 * Time: 14:25
 */

namespace App\Store;


use DB;

class RollingPictureStore
{
    // 表名
    protected static $table = "data_rollingpic_info";

    /**
     * 取出所有的轮播图
     * @return array
     * @author 王通
     */
    public function getAllPic()
    {
        return DB::table(self::$table)->where('status', 1)->get();

    }

    /**
     * 保存图片信息
     * @param $data array
     * @return bool
     * @author 王通
     */
    public function savePicture ($data)
    {
        if (empty($data)) return false;
        return DB::table(self::$table)->insert($data);
    }

    /**
     * 删除指定ID的数据
     * @param $where
     * @return bool
     * @author 王通
     */
    public function updataRolling ($where, $field)
    {
        if (empty($where) || empty($field)) return false;
        return DB::table(self::$table)
            ->where($where)
            ->update($field);
    }
}