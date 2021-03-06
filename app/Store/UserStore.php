<?php
/**
 * 用户仓库层
 * User: Twitch
 * Date: 2016/11/8
 * Time: 19:43
 */
namespace App\Store;
use Illuminate\Support\Facades\DB;

class UserStore
{

    protected static $table = 'data_user_info';

    /**
     * 查询用户信息
     * @param $where
     * @return bool
     * @author 郭庆
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
     * @author 郭庆
     */
    public function addUserInfo($data)
    {
        // 检验参数是否存在
        if(empty($data)) return false;
        // 添加数据，返回添加状态
        return DB::table(self::$table)->insert($data);
    }

    /**
     * 统计当前有多少个用户
     * @return mixed
     * @author 郭庆
     */
    public function countUsers()
    {
        return DB::table(self::$table)->count();
    }

    /**
     * 更新指定用户数据
     * @param array $where
     * @param array $data
     * @return bool
     * @author 郭庆
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
     * @param $where
     * @param $page
     * @param $tolPage
     *
     * @return mixed
     * @author 郭庆
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
     * @author 郭庆
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
     * @author 郭庆
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


    /** 修改用户状态 status 1 为启用，2 为禁用
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
    /**
     * 获取满足指定字段的集合的所有数据的个数
     * @param string $field 字段
     * @param  [] $array 集合
     * @author 郭庆
     */
    public function getUsersCount($field, $array)
    {
        return DB::table(self::$table)->whereIn($field, $array)->count();
    }

    /**
     * 获取满足指定字段的集合的所有数据
     * @param string $field 字段
     * @param  [] $array 集合
     * @author 郭庆
     */
    public function getUsersPage($field, $array, $page, $pageNum)
    {
        return DB::table(self::$table)
            ->whereIn($field, $array)
            ->orderBy('memeber','desc')
            ->forPage($page,$pageNum)
            ->get();
    }

    public function changeMember($where)
    {
        return DB::table(self::$table)->where($where)->update(['memeber'=> 2]);

    }
}
