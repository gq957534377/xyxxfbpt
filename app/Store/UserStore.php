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
     * @auther 刘峻廷
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
     * @auther 刘峻廷
     */
    public function updateUserInfo($where,$data)
    {
        // 检验参数是否存在
        if(empty($where) || empty($data)) return false;
        // 指定条件，修改数据
        return DB::table(self::$table)->where($where)->update($data);

    }

    /**
     * @param $condition
     * @return bool
     * @author wang fei long
     * 需要进一步修改
     */
    public function getUsers($condition)
    {
        // 检验条件是否存在
        if(empty($condition)) return false;
        // 获取数据
        return DB::table(self::$table)->where($condition)->get();
    }
}
