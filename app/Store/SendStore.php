<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/17
 * Time: 13:52
 * USER:郭庆
 * 用户来搞数据仓储层
 */

namespace App\Store;

use Illuminate\Support\Facades\DB;

class SendStore
{
    protected static $table = "data_article_info";

    /**
     * 插入数据
     * @param $data
     * @return null
     * author 郭庆
     */
    public function insertData($data)
    {
        return $result = DB::table(self::$table)->insertGetId($data);
    }

    /**
     * 获取一条数据
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function getOneData($where)
    {
        return DB::table(self::$table)
            ->where($where)
            ->where('status', '<>', 5)
            ->first();
    }

    /**
     * 获取IN数组中对应的数据
     *
     * @return \Illuminate\Http\Response
     * @author 杨志宇
     */
    public function getAllData($where)
    {
        return DB::table(self::$table)
            ->whereIn($where)
            ->where('status', '<>', 5)
            ->first();
    }
    /**
     * 分页查询数据
     * @param $page
     * @param $tolPage
     * @param $where
     * @return null
     * author 郭庆
     */
    public function forPage($page, $tolPage, $where)
    {
        return DB::table(self::$table)
           ->where($where)
           ->orderBy("time","desc")
           ->forPage($page,$tolPage)
            ->get();
    }

    /**
     * 查询指定条件所有数据
     * @return mixed
     * @author 郭庆
     */
    public static function getData($where)
    {
        return DB::table(self::$table)->where($where)->orderBy("time","desc")->get();
    }

    /**
     * 更新数据
     * @param $where
     * @param $data
     * @return null
     * author 郭庆
     */
    public function upload($where, $data)
    {
        return DB::table(self::$table)->where($where)->update($data);
    }

    /**
     * 批量
     * @param $where
     * @param $data
     * @return null
     * author 杨志宇
     */
    public function updataAll($where, $data)
    {
        return DB::table(self::$table)->whereIn($where)->update($data);
    }

    /**
     * 给某个字段自增data
     * @author 郭庆
     */
    public static function incrementData($where, $field, $data)
    {
        return DB::table(self::$table)->where($where)->increment($field, $data);
    }

    /**
     * 得到指定状态的数量
     * @param $where
     * @return mixed
     * @author 杨志宇
     */
    public function getCount ($where)
    {
        return DB::table(self::$table)->where($where)->count();
    }

    /**
     * 获取一条数据
     *@param array $where
     * @return \Illuminate\Http\Response
     * @author 杨志宇
     */
    public function getOneDatas($where)
    {
        return DB::table(self::$table)->where($where)->first();
    }
}