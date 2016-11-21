<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/21
 * Time: 12:06
 * 众筹资金详情表
 */
namespace App\Store;

use DB;

class CrowdCapitalStore
{
    //表名
    protected static $table = 'crowd_capital_data';

    /**
     * 插入数据
     * @param $data
     * @return bool|null
     * author 张洵之
     */
    public function insertData($data)
    {
        if(!is_array($data))return null;
        DB::table(self::$table)->insert($data);
        return true;
    }

}
