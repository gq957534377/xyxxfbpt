<?php
/**
 * Created by PhpStorm.
 * User: 王拓
 * Date: 2016/11/11
 * Time: 9:01
 */
namespace App\Store;

use Illuminate\Support\Facades\DB;

class TrainingStore
{
    //表名
    protected static $table = 'data_training_info';

    /**
     * 加一条语句到数据库
     * @param $data
     * @return bool
     * @author 王拓
     */
    public function addData($data)
    {
        // 检查$data是否为空
        if (empty($data)) return false;
        // 添加数据到数据库
        return DB::table(self::$table)->insert($data);
    }

    /**
     * 从数据库中获取一条数据
     * @param $where
     * @return bool
     * @author 王拓
     */
    public function getOneData($where)
    {
        // 检查$where是否为空
        if (empty($where)) return false;
        // 从数据库中获取一条指定数据
        return DB::table(self::$table)->where($where)->first();
    }

    /**
     * 获取数据库中整张表的数据
     * @return mixed
     * @author 王拓
     */
    public function getAllData()
    {
        // 获取数据库整张表的数据
        return DB::table(self::$table)->get();
    }

    /**
     * 更新数据库中的数据
     * @param $where
     * @param $data
     * @return bool
     * @author 王拓
     */
    public function updateData($where, $data)
    {
        if (empty($where) || empty($data)) return false;
        return DB::table(self::$table)->where($where)->update($data);
    }

    /**
     * 删除一条数据
     * @param $id
     * @return bool
     * @author 王拓
     */
    public function deleteData($id)
    {
        if (empty($id)) return false;
        return DB::table(self::$table)->where($id)->delete();
    }

    /**
     * 获取分页细信息
     * @param $nowPage
     * @return bool
     * @author 王拓
     */
    public function getPageData($nowPage)
    {
        if (empty($nowPage)) return false;
        return DB::table(self::$table)->forPage($nowPage, PAGENUM)->get();
    }
}