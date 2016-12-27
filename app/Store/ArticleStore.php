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
        return DB::table(self::$table)
            ->where($where)
            ->where('status', '<>', 5)
            ->first();
    }

    /**
     * 获取IN数组中对应的用户账户，
     *
     * @return \Illuminate\Http\Response
     * @author 王通
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
     * 分页查询数据
     * @param $page 当前页
     * @param $tolPage 总页数
     * @param $where 查询条件
     * @param $sort 排序方式（默认desc降序）
     * @return null
     * author 郭庆
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
     * author 王通
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
     * @author 王通
     */
    public function getCount ($where)
    {
        return DB::table(self::$table)->where($where)->count();
    }

    /**
     * 获取一条数据
     *@param array $where
     * @return \Illuminate\Http\Response
     * @author 张洵之
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
     * @author 刘峻廷
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
     * 获取所有文章列表
     * @return mixed
     */
    public function getAllArticle()
    {
        return DB::table(self::$table)->get();
    }
}