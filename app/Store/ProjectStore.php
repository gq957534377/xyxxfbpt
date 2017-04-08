<?php

namespace App\Store;
use DB;

class ProjectStore {

    protected static $table = 'data_project_info';

    /**
     * 增加数据
     * @param $data
     * @return bool
     * @author 贾济林
     */
    public function addData($data)
    {
        if(empty($data)) return false;
        return DB::table(self::$table)->insert($data);
    }

    /**
     * 获取制定条件的数据
     * @param $where
     * @return bool
     * @author 贾济林
     */
    public function getData($where)
    {
        if(empty($where)) return false;
        return DB::table(self::$table)->where($where)->orderBy('addtime','desc')->get();
    }

    /**
     *拿取同一个字段下的所有数据
     * @param $where
     * @return mixed
     * author 杨志宇
     */
    public function getList($where,$filed)
    {
        return DB::table(self::$table)->where($where)->orderBy('addtime','desc')->lists($filed);
    }

    /**
     * 随机拿取3条数据
     * @return mixed
     * @author 郭庆
     */
    public function takeData($number)
    {
        if (empty($number)) return false;
        return DB::table(self::$table)
            ->where('status',1)
            ->orderByRaw('RAND()')
            ->take($number)
            ->get();
    }
    /**
     * 更新指定条件的数据
     * @param $param
     * @param $data
     * @return bool
     * author 贾济林
     */
    public function update($param, $data)
    {
        if(empty($data)) return false;
        return DB::table(self::$table)->where($param)->update($data);
    }

    /**
     * 获取指定页码、单页数据量、状态值的项目数据(根据项目id倒序排列)
     * @param $nowPage
     * @param $pageNum
     * @param $status
     * @return mixed
     * author 贾济林
     * @modify 杨志宇
     */
    public function getPage($nowPage, $pageNum, $where)
    {
        return DB::table(self::$table)
            ->where('status','<',3)
            ->where($where)
            ->forPage($nowPage, $pageNum)
            ->orderBy('addtime','desc')
            ->get();
    }

    /**
     * 获得指定集合内容
     * @param string $filed array $where
     * @return array
     * author 杨志宇
     */
    public function getWhereIn($filed,$where)
    {
        if(!is_string($filed)||!is_array($where))return false;
        $result = DB::table(self::$table)->whereIn($filed,$where)->get();
        return $result;
    }

    /**
     * 获取一条数据
     *@param array $where
     * @author 杨志宇
     */
    public function getOneData($where)
    {
        return DB::table(self::$table)->where($where)->first();
    }

    /**
     * 统计数量
     * @param array $where
     * @return mixed
     * author 杨志宇
     */
    public function getCount($where)
    {
        return DB::table(self::$table)->where($where)->count();
    }
}
