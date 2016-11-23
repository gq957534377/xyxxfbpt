<?php
/**
 * Created by PhpStorm.
 * User: 郭庆
 * Date: 2016/11/08
 * Time: 16:34
 */
namespace App\Store;

use Illuminate\Support\Facades\DB;

/**
 * Class roadStore
 * 后台数据处理仓库层
 *
 * @package App\Store
 */
class ActionOrderStore{
    // 表名
    protected static $table = 'rel_action_order';

    /**
     * 查询一条数据
     * @param array $where
     * @return one data
     * @ author 郭庆
     */
    public function getOneData($where)
    {
        if(empty($where)) return false;
        return DB::table(self::$table)->where($where)->first();
    }

    /**获取指定页码的数据
     * @页码
     * @return object|false
     * @author 郭庆
     */
    public function getPageData($nowPage,$where)
    {
        if(empty($nowPage)) return false;
        return DB::table(self::$table)->where($where)->forPage($nowPage, PAGENUM)->orderBy('time','desc')->get();
    }

    /**
     * 查询指定条件所有数据
     * @return mixed
     * @author 郭庆
     */
    public static function getSomeData($where)
    {
        return DB::table(self::$table)->where($where)->get();
    }
    public static function getSomeField($where,$field)
    {
        return DB::table(self::$table)->where($where)->lists($field);
    }
    /**
     * 查询所有数据
     * @return mixed
     * @author 郭庆
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
     * @author 郭庆
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
     * @author 郭庆
     */
    public function updateData($where,$data)
    {
        if(empty($where) || empty($data)) return false;
        return DB::table(self::$table)->where($where)->update($data);
    }

    /**
     * 得到指定条件的报名id
     * @param $where
     * @return bool
     * @author 贾济林
     */
    public function getActivityId($where, $list)
    {
        if(empty($where)) return false;
        return DB::table(self::$table)->where($where)->lists($list);
    }
}

