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
        return $result = DB::table(self::$table)->insert($data);
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
     * 获取IN数组中对应的用户账户，
     *
     * @return \Illuminate\Http\Response
     * @author 杨志宇
     */
    public function getDataUserId($where)
    {
        return DB::table(self::$table)
            ->select('user_id')
            ->whereIn('guid', $where)
            ->where('status', '<>', 5)
            ->distinct()
            ->get();
    }

    /**
     * 说明: 分页查询数据
     *
     * @param $page
     * @param $tolPage
     * @param $where
     * @param string $sort
     * @return mixed
     * @author 郭庆
     */
    public function forPage($page, $tolPage, $where, $sort="desc")
    {
        return DB::table(self::$table)
            ->where($where)
            ->orderBy("addtime", $sort)
            ->forPage($page, $tolPage)
            ->get();
    }

    /**
     * 查询指定条件所有数据
     * @return mixed
     * @author 郭庆
     */
    public static function getData($where)
    {
        return DB::table(self::$table)->where($where)->orderBy("addtime", "desc")->get();
    }


    /**
     * 得到数据中所有未被删除的GUID
     * @param $where
     * @return mixed
     */
    public function getAllGuid($where)
    {
        if (empty($where)) return false;
        return DB::table(self::$table)->where($where)->orderBy("addtime", "desc")->lists('guid');
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
     * 批量 更新数据
     * @param $where
     * @param $data
     * @return null
     * author 杨志宇
     */
    public function updataAll($where, $data)
    {
        return DB::table(self::$table)->whereIn('guid', $where)->update($data);
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
    public function getCount($where)
    {
        return DB::table(self::$table)
            ->where($where)
            ->count();
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

    /**
     * 获取八条文章数据
     * @param $where
     * @param $number
     * @return mixed
     * @author 郭庆
     */
    public function takeArticles($where, $number)
    {
        return DB::table(self::$table)
            ->where($where)
            ->orderBy('addtime', 'desc')
            ->take($number)
            ->get();
    }

    /**
     * 获取指定条数随机数据
     * @param array $where  数据条件
     * @param int $number 取出的条数
     * @param int $start 开始的位置
     * @return mixed
     * @author 杨志宇
     */
    public function RandomArticles($where, $number, $start)
    {
        return DB::table(self::$table)
            ->where($where)
            ->skip($start)
            ->take($number)
            ->get();
    }

    /**
     * 获取所有文章列表
     * @return mixed
     * @author 郭庆 beta
     */
    public function getAllArticle()
    {
        return DB::table(self::$table)->orderBy('addtime','desc')->get();
    }
}