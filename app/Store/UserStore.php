<?php
/**
 * 用户仓库层
 * User: Twitch
 * Date: 2016/11/8
 * Time: 19:43
 */
namespace App\Store;
use Illuminate\Support\Facades\DB;

class UserStore {

    protected static $table = 'data_user_info';

    /**
     * 查询用户信息
     * @param $where
     * @return bool
     * @author 刘峻廷
     */
    public function getOneData($where)
    {
        if (empty($where)) return false;
        return DB::table(self::$table)->where($where)->first();
    }
    /**
     * 添加用户信息
     * @param array $data
     * @return bool
     * @author 刘峻廷
     */
    public function addUserInfo($data)
    {
        // 检验参数是否存在
        if(empty($data)) return false;
        // 添加数据，返回添加状态
        return DB::table(self::$table)->insert($data);
    }

    /**
     * 更新指定用户数据
     * @param array $where
     * @param array $data
     * @return bool
     * @author 刘峻廷
     */
    public function updateUserInfo($where,$data)
    {
        // 检验参数是否存在
        if(empty($where) || empty($data)) return false;
        // 指定条件，修改数据
        return DB::table(self::$table)->where($where)->update($data);

    }

    /**
     * @param array $condition
     * @return mixed
     * @author wang fei long
     */
    public function getUsersData($nowPage, $condition = [])
    {
        if(empty($nowPage)) return false;
        // 检验条件是否存在
        if(empty($condition)) DB::table(self::$table)->forPage($nowPage, PAGENUM)->get();
        // 获取数据
        return DB::table(self::$table)->where($condition)->forPage($nowPage, PAGENUM)->get();
    }

    /**
     * 依条件获取记录条数
     * @param $condition
     * @return mixed
     * @author wang fei long
     */
    function getUsersNumber($condition = [])
    {
        if(empty($condition)) return DB::table(self::$table)->count();
        return DB::table(self::$table)->where($condition)->count();
    }
}
