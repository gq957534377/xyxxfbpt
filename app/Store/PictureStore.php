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
    protected static $table = "data_picture";


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
            ->get();
    }

}