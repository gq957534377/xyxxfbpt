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
     * 获取分页数据
     * @param array $condition
     * @return mixed
     * @author 王飞龙
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
     * @author 王飞龙
     */
    function getUsersNumber($condition = [])
    {
        if(empty($condition)) return DB::table(self::$table)->count();
        return DB::table(self::$table)->where($condition)->count();
    }

    /**
     * 删除数据
     * @param array $condition
     * @return bool
     * @author 王飞龙
     */
    function deleteData($condition = [])
    {
        if(empty($condition)) return false;
        return DB::table(self::$table)->where($condition)->delete();
    }

    /**
     * 获取分页数据
     * @param $where
     * @param $page
     * @param $tolPage
     *
     * @return mixed
     * @author lw
     */
    public function forPage($page, $tolPage, $where)
    {
        if (!is_int($page) || !is_int($tolPage) || !is_array($where)) return false;
        return DB::table(self::$table)
            ->where($where)
            ->orderBy("addtime","desc")
            ->forPage($page,$tolPage)
            ->get();
    }

    /**
     * @param $where 查询条件
     * @return bool 返回的条数
     * @author lw
     */
    public function getUserCount($where)
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
    public function getUserTypelist($where, $nowPage, $pageNums)
    {
        if(empty($where)) return false;
        return DB::table(self::$table)
            ->where($where)
            ->orderBy('addtime','desc')
            ->forPage($nowPage, $pageNums)
            ->get();
    }

}
