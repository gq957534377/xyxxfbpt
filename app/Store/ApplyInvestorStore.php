<?php
/**
 * Created by PhpStorm.
 * User: Twitch
 * Date: 2016/12/28
 * Time: 11:21
 */

namespace App\Store;

use Illuminate\Support\Facades\DB;

class ApplyInvestorStore
{
    protected static $table = 'data_apply_investor';

    /**
     * 根据指定条件，获取最新一条的记录
     * @param $where
     * @return bool
     * @author 刘峻廷
     */
    public function getOneData($where)
    {
        if (empty($where)) return false;
        return DB::table(self::$table)->where($where)->orderBy('id', 'desc')->first();
    }

    /**
     * 添加一条记录
     * @param $data
     * @return bool
     * @author 刘峻廷
     */
    public function addOneData($data)
    {
        if (empty($data)) return false;
        return DB::table(self::$table)->insertGetId($data);
    }

    /**
     * 修改申请记录
     * @param $where
     * @param $data
     * @return bool
     * @author 刘峻廷
     */
    public function updataOneData($where, $data)
    {
        if (empty($where) || empty($data)) return false;
        return DB::table(self::$table)->where($where)->update($data);
    }

    /**
     * @param $where 查询条件
     * @return bool 返回的条数
     * @author lw
     */
    public function getInvCount($where)
    {
        if(empty($where)) return false;
        return DB::table(self::$table)->where($where)->count();
    }

    /**
     * @param $where    查询条件
     * @param $nowPage  当前页数
     * @param $pageNums     每页显示条数
     * @return array    用户列表
     * @author lw
     */
    public function getInvlist($where, $nowPage, $pageNums)
    {
        if(empty($where)) return false;
        return DB::table(self::$table)
            ->where($where)
            ->orderBy('addtime','desc')
            ->forPage($nowPage, $pageNums)
            ->get();
    }
}