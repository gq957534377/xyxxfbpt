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
     * @author 郭庆
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
     * @author 郭庆
     */
    public static function getOneData($where)
    {
        if (empty($where)) return false;

        return DB::table(self::$table)->where($where)->first();
    }

    /** 修改用户状态 status 6 为通过，7为拒绝
     * @param $where  string  用户guid
     * @param $status  array  要修改的状态
     * @return bool
     *@author 郭庆
     */
    public function changeStatus($where, $status)
    {
        if (empty($where)) return false;
        return DB::table(self::$table)->where($where)->update($status);
    }
}