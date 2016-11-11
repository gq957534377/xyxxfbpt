<?php
/**
 * 众筹表数据仓储层
 * User: 张洵之
 * Date: 2016/11/9
 * Time: 14:10
 */

namespace App\Store;

use DB;

class CrowdFundingStore
{
    //表名
    protected static $table = 'crowd_funding_data';
    /**
     * 返回拥有该字段最大值的整条记录
     * @param string $field
     * @return array
     * @ author 张洵之
     */
    public function selectMaxOne($field)
    {
        $result = DB::table(self::$table)->max($field);
        return $result;
    }
    /**
     * 返回某字段的和
     * @param string $field
     * @return array
     * @ author 张洵之
     */
    public function fieldSum($field)
    {
        if(!is_string($field))return null;
        $result= DB::table(self::$table)->sum($field);
        return $result;
    }
    /**
     * 返回条件查询某列结果
     * @param array $where string $field
     * @return array
     * @ author 张洵之
     */
    public function selectLists($where,$field)
    {
        if(!is_array($where)||!is_string($field))return null;
        $result = DB::table(self::$table)->where($where)->lists($field);
        return $result;
    }
    /**
     * 返回条件查询数量
     * @param array $where
     * @return int
     * @ author 张洵之
     */
    public function selectListNum($where)
    {
        if(!is_array($where))return null;
        $result = DB::table(self::$table)->where($where)->count();
        return $result;
    }

    /**
     * 分页获得指定条件内容
     * @param string $filed array $where int $page  int $pages
     * @return array
     * author 张洵之
     */
    public function getList($where,$field,$page,$pages)
    {
        if(!is_array($where)||!is_int($page)||!is_int($pages)||!is_string($field))return null;
        $result = DB::table(self::$table)->where($where)->forPage($page,$pages)->lists($field);
        return $result;
    }
}