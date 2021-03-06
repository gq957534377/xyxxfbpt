<?php
/**
 * 众筹表数据仓储层
 * User: 杨志宇
 * Date: 2016/11/9
 * Time: 14:10
 */

namespace App\Store;

use DB;

class CrowdFundingStore
{
    //表名
    protected static $table = 'data_crowd_funding';
    /**
     * 返回拥有该字段最大值的整条记录
     * @param string $field
     * @return array
     * @ author 杨志宇
     */
    public function selectMaxOne($field)
    {
        if(!is_string($field))return false;

        $result = DB::table(self::$table)->max($field);

        if($result){
            return $result;
        }else{
            return 0;
        }
    }
    /**
     * 返回某字段的和
     * @param string $field
     * @return array
     * @ author 杨志宇
     */
    public function fieldSum($field)
    {
        if(!is_string($field))return false;

        $result= DB::table(self::$table)->sum($field);

        if($result){
            return $result;
        }else{
            return 0;
        }
    }
    /**
     * 返回条件查询某列结果
     * @param array $where string $field
     * @return array
     * @ author 杨志宇
     */
    public function selectLists($where,$field)
    {
        if(!is_array($where) || !is_string($field))return false;

        $result = DB::table(self::$table)->where($where)->lists($field);
        return $result;
    }
    /**
     * 返回条件查询数量
     * @param array $where
     * @return int
     * @ author 杨志宇
     */
    public function selectListNum($where)
    {
        if(!is_array($where))return false;

        $result = DB::table(self::$table)->where($where)->count();
        return $result;
    }

    /**
     * 分页获得指定条件内容
     * @param string $filed array $where int $page  int $pages
     * @return array
     * @author 杨志宇
     */
    public function getList($where,$field,$page,$pages)
    {
        if(!isset($where) || !isset($page) || !isset($pages) || !isset($field))return false;

        $result = DB::table(self::$table)
            ->where($where)
            ->forPage($page,$pages)
            ->lists($field);
        return $result;
    }

    /**
     * 更新数据
     * @param $where
     * @param $update
     * @author 杨志宇
     */
    public function uplodData($where,$update)
    {
        if(!is_array($where)||!is_array($update))return false;

        $result = DB::table(self::$table)->where($where)->update($update);
        return $result;
    }

    /**
     * 分页返回数据
     * @param $page
     * @param $tolPage
     * @return null
     * @author 杨志宇
     */
    public function forPage($page,$tolPage,$where)
    {
        if(!isset($page) || !isset($tolPage) || !isset($where))return false;

        $result = DB::table(self::$table)
            ->where($where)
            ->orderBy("changetime","desc")
            ->forPage($page,$tolPage)
            ->get();

        return $result;
    }

    /**
     * 基本条件查询
     * @param $where
     * @return null
     * @author 杨志宇
     */
    public function getWhere($where)
    {
        if(!is_array($where))return false;
        $result = DB::table(self::$table)->where($where)->get();
        return $result;
    }

    /**
     * 查询指定集合内的内容
     * @param $field
     * @param $where
     * @return null
     * author 杨志宇
     */
    public function getWhereIn($field,$where)
    {
        if(!isset($where) || !isset($field))return false;

        $result = DB::table(self::$table)
            ->whereIn($field,$where)
            ->orderBy("project_id","asc")
            ->get();
        return $result;
    }

    /**
     * 添加数据
     * @param $data
     * @return int|null
     * @author 杨志宇
     */
    public function insertData($data)
    {
        if(!isset($data))return false;

        $result = DB::table(self::$table)->insertGetId($data,"project_id");
        return $result;
    }

    /**
     * 已筹资金字段增加金额
     * @param $where
     * @param $field
     * @param $data
     * @return bool
     * author 杨志宇
     */
    public function addFunshing($where,$data)
    {
        if(empty($data) || empty($data)) return false;

        $result = DB::table(self::$table)->where($where)->increment($data);
        return $result;
    }
}