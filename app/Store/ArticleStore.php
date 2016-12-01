<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/17
 * Time: 13:52
 * 文章内容管理数据仓储层
 */

namespace App\Store;

use Illuminate\Support\Facades\DB;

class ArticleStore
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
        return DB::table(self::$table)->where($where)->first();
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
        if (!is_int($page) || !is_int($tolPage) || !is_array($where)) return false;
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
        return DB::table(self::$table)->where($where)->get();
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
     * 给某个字段自增data
     * @author 郭庆
     */
    public static function incrementData($where, $field, $data)
    {
        return DB::table(self::$table)->where($where)->increment($field, $data);
    }
}