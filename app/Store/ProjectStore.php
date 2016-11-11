<?php

namespace App\Store;
use Illuminate\Support\Facades\DB;

class ProjectStore {

    protected static $table = 'project_info_data';

    /**
     * 添加项目
     * @param array $data
     * @return bool
     * @auther 贾济林
     */
    public function addData($data)
    {
        // 检验参数是否为空
        if(empty($data)) return false;
        // 添加数据，返回添加状态
        return DB::table(self::$table)->insert($data);
    }

}
