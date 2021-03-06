<?php
/*后台用户管理service*/
namespace App\Services;

use App\Store\UserStore;
use App\Store\HomeStore;
use App\Tools\CustomPage;
use DB;

class UserManagementService
{
    protected static $data_user_info;    //data_user_info 数据仓库
    protected static $data_user_login;    //data_user_login 用户登录数据仓库

   public function __construct(
       UserStore $userStore,
       HomeStore $homeStore
   ){
       self::$data_user_info = $userStore;
       self::$data_user_login = $homeStore;
   }

    /**
     * 说明: 获取用户分页数据
     *
     * @param $where
     * @param $nowPage
     * @param $forPages
     * @param $url
     * @return array
     * @author 郭庆
     */
    public function selectData($where, $nowPage, $forPages, $url)
    {
        //获取符合条件的数据的总量
        $count = self::$data_user_info->getUserCount($where);
        if (!$count) return ['StatusCode' => '204', 'ResultData' => "暂无数据"];
        //计算总页数
        $totalPage = ceil($count / $forPages);

        //获取对应页的数据
        $result['data'] = self::$data_user_info->getUserTypelist($where, $nowPage, $forPages);

        if (!empty($result['data'])) {
            if ($totalPage > 1) {
                //创建分页样式
                $creatPage = CustomPage::getSelfPageView($nowPage, $totalPage, $url, null);

                if ($creatPage) {
                    $result["pages"] = $creatPage;
                } else {
                    return ['StatusCode' => '500', 'ResultData' => '生成分页样式发生错误'];
                }

            } else {
                $result['totalPage'] = $totalPage;
                $result["pages"] = '';
            }
            return ['StatusCode' => '200', 'ResultData' => $result];
        } else {
            return ['StatusCode' => '500', 'ResultData' => '获取分页数据失败！'];
        }
    }

    /** 获取条数
     * @param $table 要查询的数据仓库
     * @param $where    查询条件
     * @return int 返回数据的条数
     * @author 郭庆
     */
    public function getCount($table, $where)
    {
        switch ($table){
            case 'data_user_info':
                return self::$data_user_info->getUserCount($where);
            break;

            case 'data_apply_syb':
                return self::$data_apply_syb->getSybCount($where);
            break;

            case 'data_apply_investor':
                return self::$data_apply_investor->getInvCount($where);
                break;

            case 'data_apply_member':
                return self::$data_apply_member->getMemCount($where);
                break;

            default:
                return '';
        }
    }

    /** 获取用户列表或者审核列表信息
     * @param $table    数据仓库选择
     * @param $where    查询条件
     * @param $nowPage  当天页
     * @param $pageNums     每页显示的数据条数
     * @return array    返回的数据列表
     * @author 郭庆
     */
    public function getTypelist($table, $where, $nowPage, $pageNums)
    {
        switch ($table){
            case 'data_user_info':
                return self::$data_user_info->getUserTypelist($where, $nowPage, $pageNums);
            break;

            case 'data_apply_syb':
                return self::$data_apply_syb->getSybList($where, $nowPage, $pageNums);
            break;

            case 'data_apply_investor':
                return self::$data_apply_investor->getInvList($where, $nowPage, $pageNums);
            break;

            case 'data_apply_member':
                return self::$data_apply_member->getMemberList($where, $nowPage, $pageNums);
            break;
            default:
                return '';
        }
    }

    /**
     * user类型参数规则
     * @return array 返回请求的参数匹配规则
     * @author 郭庆
     */
    public function userRoles()
    {
         //参数规则
        $userRoles = [
                //查询data_user_info表,
                ['status' => 1],    //查询所有可用用户
                ['status' => 1, 'role' => 1],    //查询data_user_info表,普通用户
                ['status' => 1, 'role' => 2],      //创业者用户
                ['status' => 1, 'role' => 3],      //投资者用户
                ['status' => 1, 'memeber' => 2],      //校园信息发布平台会员
                ['status' => 2, 'role' => 1],      //'已禁用普通用户' =>查询data_user_info表,普通用户
                ['status' => 2, 'role' => 2],     //'已禁用创业者用户' =>
                ['status' => 2, 'role' => 3],     //'已禁用投资者用户' =>
                ['status' => 2, 'memeber' => 2],    //'已禁用校园信息发布平台成员' =>
        ];
        return $userRoles;
    }

    /**
     * 角色申请规则
     * @return array
     */
    public function applyRoles()
    {
        $applyRoles = [
            ['table' => 'data_apply_syb','status' => 5],    //待审核创业者
            ['table' => 'data_apply_investor','status' => 5],   //待审核投资者
            ['table' => 'data_apply_member','status' => 5],   //待审核投资者

            ['table' => 'data_apply_syb','status' => 7],    //待审核创业者
            ['table' => 'data_apply_investor','status' => 7],   //待审核投资者
            ['table' => 'data_apply_member','status' => 7],   //待审核投资者
        ];
        return $applyRoles;
    }

    /**     分页HTML字符串拼装
     * @param $url url选择 user 为用户常规管理   role 为用户审核管理
     * @param $count    总条数
     * @param $nowPage  当前页
     * @param $pageNums     每页条数
     * @param $search       查询字符串
     * @return string   返回拼装好的HTML字符串
     * @author 郭庆
     */
    public function paramHandle($url, $count, $nowPage, $pageNums, $search)
    {
        //总页数
        $totalPage = ceil($count / $pageNums);
        //分页求情的地址
        switch($url){
            case 'user':
                $url = '/user_management/show';
                break;
            case 'role':
                $url = '/role_management/show';
        }
        $baseUrl   = url($url);

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

    /**
     * @param $where array、 用户guid
     * @param $status  array  要修改的状态
     * @return bool  修改成功为真  失败假
     * @author 郭庆
     */
    public function changeStatus($where, $status)
    {
        DB::beginTransaction();
            $res1 = self::$data_user_info->changeStatus($where, $status);
            $res2 = self::$data_user_login->changeStatus($where, $status);

        if(!$res1 || !$res2) {
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
    }

    /**
     * 审核用户操作
     * @param  string $guid 需要审核的用户
     * @param  int $role  审核的角色 2：创业者  3 投资者 4 校园信息发布平台员
     * @param  int $status 通过的状态  6 审核通过  7 拒绝
     * @return bool 成功 return true   失败  return false
     */
    public function changeApplyStatus($guid, $role, $status)
    {
        $where = ['guid'=>$guid];
        $status = ['status'=>$status];

        //拒绝通过操作
        if($status['status']==7){
            switch ($role){
                //审核创业者
                case 2:
                    $res = self::$data_apply_syb->changeStatus($where, $status);
                    if(!$res) return false;
                    return true;
                    break;

                case 3:
                    //投资者
                    $res = self::$data_apply_investor->changeStatus($where, $status);
                    if(!$res) return false;
                    return true;
                    break;

                case 4:
                    //校园信息发布平台会员
                    $res = self::$data_apply_member->changeStatus($where, $status);
                    if(!$res) return false;
                    return true;
                    break;



            }
        }else if($status['status'] == 6){
            //审核通过
            switch ($role){
                case 2:
                    //通过用户审核创业者
                    DB::beginTransaction();
                    $res1 = self::$data_apply_syb->changeStatus($where, ['status'=>6]);    //  status = 6
                    //普通用户提升为2 如果已经是投资者 改为23
                    if(self::$data_user_info->getOneData($where)->role == 1){
                        $res2 = self::$data_user_info->changeStatus($where, ['role'=>2]);  //用户信息角色改为role=3
                    }else{
                        $res2 = self::$data_user_info->changeStatus($where, ['role'=>23]);
                    }   //用户信息角色改为role=2
                    if(!$res1 || !$res2){
                        DB::rollBack();
                        return false;
                    }
                    DB::commit();
                    return true;
                break;

                case 3:
                    //通过用户审核投资者
                    DB::beginTransaction();
                    $res3 = self::$data_apply_investor->changeStatus($where, $status);    //  status = 6
                    //普通用户提升为3 如果已经是创业者 改为23
                    if(self::$data_user_info->getOneData($where)->role == 1){
                        $res4 = self::$data_user_info->changeStatus($where, ['role'=>3]);   //用户信息角色改为role=3
                    }else{
                        $res4 = self::$data_user_info->changeStatus($where, ['role'=>23]);
                    }

                    if(!$res3 || !$res4){
                        DB::rollBack();
                        return false;
                    }
                    DB::commit();
                    return true;
                    break;

                case 4:
                    //通过用户审核校园信息发布平台员
                    DB::beginTransaction();
                    $res5 = self::$data_apply_member->changeStatus($where, ['status' => 6]);    //  status = 6
                    $res6 = self::$data_user_info->changeMember($where);   //用户信息角色 memeber=2
                    if(!$res5 || !$res6){
                        DB::rollBack();
                        return false;
                    }
                    DB::commit();
                    return true;
                    break;

                case 5:
                    //通过公司审核
                    $res7 = self::$data_company_info->changeStatus($where,['status' => 6]);
                    if(!$res7) return false;
                    return true;
                break;
            }
        }


    }


}