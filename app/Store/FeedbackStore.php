<?php
/**
 * Created by PhpStorm.
 * User: wangt
 * Date: 2016/12/28
 * Time: 17:11
 */

namespace App\Store;

use DB;


class FeedbackStore
{
    //表名
    protected static $table = 'data_feedback_info';

    /**
     * 获取总记录数
     * @param $where
     * @return bool
     * @author 王通
     */
    public function getCount($where)
    {
        if (empty($where)) return false;
        return DB::table(self::$table)->where($where)->count();
    }

    /**
     * 分页查询数据
     * @param $page 当前页
     * @param $tolPage 总页数
     * @param $where 查询条件
     * @param $sort 排序方式（默认desc降序）
     * @return null
     * author 王通
     */
    public function forPage($page, $tolPage, $where, $sort = "desc")
    {
        return DB::table(self::$table)
            ->where($where)
            ->orderBy("addtime", $sort)
            ->forPage($page, $tolPage)
            ->get();
    }
}