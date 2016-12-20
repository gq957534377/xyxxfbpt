<?php
/*后台用户管理service*/
namespace App\Services;

use App\Store\UserStore;
use App\Store\RoleStore;
use App\Store\HomeStore;

use App\Tools\CustomPage;

class userManagementService
{
    protected static $data_user_info;    //data_user_info 数据仓库
    protected static $data_role_info;    //data_role_info 数据仓库
    protected static $data_user_login;    //data_user_login 数据仓库

   public function __construct(UserStore $userStore, RoleStore $roleStore, HomeStore $homeStore)
   {
       self::$data_user_info = $userStore;
       self::$data_role_info = $roleStore;
       self::$data_user_login = $homeStore;
   }

    /** 获取条数
     * @param $table 要查询的数据仓库
     * @param $where    查询条件
     * @return int 返回数据的条数
     * @author lw
     */
    public function getCount($table, $where)
    {
        //获取data_uer_info表的条数
        if ($table == 'data_user_info' ){
            return self::$data_user_info->getUserCount($where);
        }
        //获取data_role_info表的条数,待审核和审核失败
        if($table == 'data_role_info'){
            return self::$data_role_info->getRoleCount($where);
        }


    }

    /** 获取用户列表或者审核列表信息
     * @param $table    数据仓库选择
     * @param $where    查询条件
     * @param $nowPage  当天页
     * @param $pageNums     每页显示的数据条数
     * @return array    返回的数据列表
     * @author lw
     */
    public function getTypelist($table, $where, $nowPage, $pageNums)
    {
        if ($table == 'data_user_info' ){
            return self::$data_user_info->getUserTypelist($where, $nowPage, $pageNums);
        }

        if ($table == 'data_role_info' ){
            return self::$data_role_info->getRoleTypelist($where, $nowPage, $pageNums);
        }
    }

    /**
     * 参数规则
     * @return array 返回请求的参数匹配规则
     * @author lw
     */
    public function roles()
    {
         //参数规则
        $roles = [
                //查询data_user_info表,
                ['status' => 1, 'role' => 1],    //查询data_user_info表,普通用户
                ['status' => 1, 'role' => 2],      //创业者用户
                ['status' => 1, 'role' => 3],      //投资者用户
                ['status' => 1, 'memeber' => 2],      //英雄会会员
                //查询data_role_info表
                ['status' => 1, 'role' => 2],     //查询data_role_info表,'待审核创业者用户' =>
                ['status' => 1, 'role' => 3],     //  '待审核投资者用户' =>
                ['status' => 1, 'role' => 4],     //'待审核投资者用户' =>
                ['status' => 3, 'role' => 2],    // '审核失败创业者用户' =>
                ['status' => 3, 'role' => 3],    //'审核失败投资者用户' =>
                ['status' => 3, 'role' => 4],    //'审核失败英雄会成员' =>
                //查询data_user_info表,
                ['status' => 2, 'role' => 1],      //'已禁用普通用户' =>查询data_user_info表,普通用户
                ['status' => 2, 'role' => 2],     //'已禁用创业者用户' =>
                ['status' => 2, 'role' => 3],     //'已禁用投资者用户' =>
                ['status' => 2, 'memeber' => 2],    //'已禁用英雄会成员' =>
                //页面默认加载所有正常用户信息
                ['status' => 1]
        ];
        return $roles;
    }

    /**     分页HTML字符串拼装
     * @param $count    总条数
     * @param $nowPage  当前页
     * @param $pageNums     每页条数
     * @param $search       查询字符串
     * @return string   返回拼装好的HTML字符串
     * @author lw
     */
    public function paramHandle($count, $nowPage, $pageNums, $search)
    {
        //总页数
        $totalPage = ceil($count / $pageNums);
        //分页求情的地址
        $baseUrl   = url('/test/show');

        if($nowPage <= 0){
            $nowPage = 1;
        }elseif ($nowPage > $totalPage){
            $nowPage = $totalPage;
        }

        //创建分页
        if ($totalPage > 1){
            $pageStr = CustomPage::getSelfPageView($nowPage, $totalPage, $baseUrl, $search);
        }else{
            $pageStr = '';
        }

        return $pageStr;
    }


}