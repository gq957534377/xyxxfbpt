<?php
/**
 * 公司 数据仓库层.
 * User: Twitch
 * Date: 2016/12/25
 * Time: 21:49
 */
namespace App\Store;
use Illuminate\Support\Facades\DB;

class CompanyStore{
    // 表名
    protected static $table = 'data_company_info';


    /**
     * 添加一条数据
     * @param $data
     * @return bool
     * @author 刘峻廷
     */
    public static function addOneData($data)
    {
        if (empty($data)) return false;

        return DB::table(self::$table)->insert($data);
    }

    /**
     * 获取指定一条数据
     * @param $where
     * @return bool
     * @author 刘峻廷
     */
    public static function getOneData($where)
    {
        if (empty($where)) return false;

        return DB::table(self::$table)->where($where)->first();
    }
}