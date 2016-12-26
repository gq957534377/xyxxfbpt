<?php

namespace App\Store;
use Illuminate\Support\Facades\DB;

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

    public function getAllData()
    {
        return DB::table(self::$table)->get();
    }

    /**
     * 随机拿取3条数据
     * @return mixed
     * @author 刘峻廷
     */
    public function takeData($number)
    {
        if (empty($number)) return false;
        return DB::table(self::$table)->orderByRaw('RAND()')->take($number)->get();
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
     */
    public function getPage($nowPage, $pageNum, $status)
    {
        return DB::table(self::$table)->where(['status'=>$status])->forPage($nowPage, $pageNum)->orderBy('addtime','desc')->get();
    }

    /**
     * 获得指定集合内容
     * @param string $filed array $where
     * @return array
     * author 张洵之
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
     * @return \Illuminate\Http\Response
     * @author 张洵之
     */
    public function getOneData($where)
    {
        return DB::table(self::$table)->where($where)->first();
    }
}
