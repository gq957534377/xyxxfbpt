<?php
/**
 * Created by PhpStorm.
 * User: wangt
 * Date: 2016/12/7
 * Time: 15:05
 */

namespace App\Store;

use DB;

class PictureStore
{
    // 表名
    protected static $table = "data_picture_info";


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
 * 得到指定类型的数据
 * @param $where
 * @return bool
 * @author 王通
 */
    public function getPicture ($where)
    {
        if (empty($where)) return false;
        return DB::table(self::$table)
            ->where($where)
            ->where('status', '<>', 4)
            ->get();
    }

    /**
     * 得到指定类型的数据 IN一次性获取
     * @param $where
     * @return bool
     * @author 王通
     */
    public function getPictureIn ($where)
    {
        if (empty($where)) return false;
        return DB::table(self::$table)
            ->whereIn('type', $where)
            ->where('status', '<>', 4)
            ->get();
    }
    /**
     * 得到所有未删除的数据
     * @param $where
     * @return bool
     * @author 王通
     */
    public function getPictureAll ()
    {
        return DB::table(self::$table)
            ->where('status', '<>', 4)
            ->get();
    }

    /**
     * 删除指定ID的数据
     * @param $where
     * @return bool
     * @author 王通
     */
    public function updatePic ($where, $field)
    {
        if (empty($where) || empty($field)) return false;
        return DB::table(self::$table)
            ->where($where)
            ->update($field);
    }

    /**
     * 获取所有的投资机构和合作机构
     * @param
     * @return array
     * @author 郭庆
     */
    public static function getGroup()
    {
        return DB::table(self::$table)->wherein('type',[3,5])->get();
    }

}