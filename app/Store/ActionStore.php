<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/17
 * Time: 13:52
 * 活动信息表数据仓储层
 */

namespace App\Store;

use Illuminate\Support\Facades\DB;

class ActionStore
{
    protected static $table = "data_action_info";

    /**
     * 插入数据
     * @param $data
     * @return null
     * author 张洵之
     */
    public function insertData($data)
    {
        if(!is_array($data)) return false;
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
     * author 张洵之
     */
    public function forPage($page, $tolPage, $where)
    {
        if (!is_int($page) || !is_int($tolPage) || !is_array($where)) return false;
        return DB::table(self::$table)
           ->where($where)
           ->orderBy("addtime","desc")
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
     * 查询某一类型活动列表业所需的活动
     * @param
     * @return array
     * @author 郭庆
     */
    public static function getListData($type)
    {
        return DB::table(self::$table)->where(['type' => $type])->where('status', '!=', '4')->get();
    }

    /**
     * 更新数据
     * @param $where
     * @param $data
     * @return null
     * author 张洵之
     */
    public function upload($where, $data)
    {
        if(!is_array($where) || !is_array($data)) return false;
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

    /**
     * 获取三条活动数据
     * @param $type
     * @param int $number
     * @return mixed
     * @author 刘峻廷
     */
    public function takeActions($where,$number)
    {
        return DB::table(self::$table)->where($where)->take($number)->get();
    }

    /**
     * 得到指定状态的数量
     * @param $where
     * @return mixed
     * @author 郭庆
     */
    public function getCount ($where)
    {
        return DB::table(self::$table)->where($where)->count();
    }

}