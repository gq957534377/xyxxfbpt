<?php

namespace App\Store;
use Illuminate\Support\Facades\DB;

class ProjectStore {

    protected static $table = 'project_info_data';

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
     * @param $data
     * @return bool
     * @author 贾济林
     */
    public function getData($data)
    {
        if(empty($data)) return false;
        return DB::table(self::$table)->where($data)->get();
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
        return DB::table(self::$table)->where(['status'=>$status])->forPage($nowPage, $pageNum)->orderBy('project_id','desc')->get();
    }

    /**
     * 分页获得指定条件内容
     * @param string $filed array $where
     * @return array
     * author 张洵之
     */
    public function getList($filed,$where)
    {
        if(!is_string($filed)||!is_array($where))return null;
        $result = DB::table(self::$table)->whereIn($filed,$where)->get();
        return $result;
    }


}
