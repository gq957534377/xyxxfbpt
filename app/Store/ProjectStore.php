<?php

namespace App\Store;
use Illuminate\Support\Facades\DB;

class ProjectStore {

    protected static $table = 'project_info_data';

    /**
     * 给project_info表增加数据
     * @param $data
     * @return bool
     * @author 贾济林
     */
    public function addData($data)
    {
        // 检验参数是否为空
        if(empty($data)) return false;
        // 添加数据，返回添加状态
        return DB::table(self::$table)->insert($data);
    }

    public function getData($data)
    {
        if(empty($data)) return false;
        return DB::table(self::$table)->where($data)->get();
    }

}
