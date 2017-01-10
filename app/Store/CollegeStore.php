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

class CollegeStore
{
    protected static $table = "data_college_info";

    /**
     * 插入数据
     * @param $data
     * @return null
     * author 郭庆
     */
    public function insertData($data)
    {
        if(!is_array($data)) return false;
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
//        dd($where);
        if (!is_int($page) || !is_int($tolPage) || !is_array($where)) return false;
        if (!empty($where['status']) && $where['status'] == 4){
            return DB::table(self::$table)
                ->where($where)
                ->orderBy("addtime","desc")
                ->forPage($page,$tolPage)
                ->get();
        }else{
            return DB::table(self::$table)
                ->where($where)
                ->Where('status', '<>', 4)
                ->orderBy("addtime","desc")
                ->forPage($page,$tolPage)
                ->get();
        }
    }

    /**
     * 查询指定条件所有数据
     * @return mixed
     * @author 郭庆
     */
    public static function getData($where)
    {
        if (!empty($where['status']) && $where['status'] == 4){
            return DB::table(self::$table)->where($where)->get();
        }else{
            return DB::table(self::$table)
                ->where($where)
                ->where('status', '<>', 4)
                ->get();
        }
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
     * author 郭庆
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
     * 获取三条数据
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
     * 获取三条学院培训数据
     * @param $where
     * @param $number
     * @return mixed
     * @author 刘峻廷
     */
    public function takeSchoolData($number)
    {
        return DB::table(self::$table)->where('status', '<', '3')->take($number)->get();
    }

    /**
     * 得到指定状态的数量
     * @param $where
     * @return mixed
     * @author 郭庆
     */
    public function getCount ($where)
    {
//        dd($where);
        if (!empty($where['status']) && $where['status'] == 4){
            return DB::table(self::$table)->where($where)->count();
        }else{
            return DB::table(self::$table)
                ->where($where)
                ->where('status', '<>', 4)
                ->count();
        }
    }

    /**
     * 获取固定时间范围开始的活动
     * @param [] $between 时间范围
     * @return array
     * @author 郭庆
     */
    public static function dateBetween($between)
    {
        return DB::table(self::$table)->whereBetween('start_time', $between)->get();
    }
    /**
     * 获取满足指定字段的集合的所有数据
     * @param string $field 字段
     * @param  [] $array 集合
     * @author 郭庆
     */
    public function getActionsPage($where, $field, $array, $page, $pageNum)
    {
        return DB::table(self::$table)
            ->where($where)
            ->whereIn($field, $array)
            ->orderBy('addtime','desc')
            ->forPage($page,$pageNum)
            ->get();
    }
    /**
     * 获取满足指定字段的集合的所有数据的个数
     * @param string $field 字段
     * @param  [] $array 集合
     * @author 郭庆
     */
    public static function getActionsCount($where, $field, $array)
    {
        return DB::table(self::$table)
            ->where($where)
            ->whereIn($field, $array)
            ->count();
    }

    /**
     * 获取指定条数随机数据
     * @param $where
     * @param $number
     * @return mixed
     * @author 王通
     */
    public function RandomActions($number, $start)
    {
        return DB::table(self::$table)
            ->where('status', '<>', 4)
            ->skip($start)
            ->take($number)
            ->get();
    }

}