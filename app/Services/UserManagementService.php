<?php
/*后台用户管理service*/
namespace App\Services;

use App\Store\UserStore;
use App\Store\ApplySybStore;
use App\Store\ApplyInvestorStore;
use App\Store\ApplyMemberStore;
use App\Store\HomeStore;
use App\Store\CompanyStore;

use App\Tools\CustomPage;
use Illuminate\Support\Facades\DB;

class userManagementService
{
    protected static $data_user_info;    //data_user_info 数据仓库
    protected static $data_apply_syb;    //data_apply_syb 申请创业者数据仓库
    protected static $data_apply_investor;  //data_apply_investor 申请投资者
    protected static $data_apply_member;    //data_apply_member 申请英雄会会员
    protected static $data_user_login;    //data_user_login 用户登录数据仓库
    protected static $data_company_info;    //用户公司数据仓库

   public function __construct(
       UserStore $userStore,
       ApplySybStore $applySybStore,
       ApplyInvestorStore $applyInvestorStore,
       ApplyMemberStore $applyMemberStore,
       HomeStore $homeStore,
       CompanyStore $companyStore
   ){
       self::$data_user_info = $userStore;
       self::$data_apply_syb = $applySybStore;
       self::$data_apply_investor = $applyInvestorStore;
       self::$data_apply_member = $applyMemberStore;
       self::$data_user_login = $homeStore;
       self::$data_company_info = $companyStore;
   }

    /** 获取条数
     * @param $table 要查询的数据仓库
     * @param $where    查询条件
     * @return int 返回数据的条数
     * @author lw
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
     * @author lw
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
     * @author lw
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
                ['status' => 1, 'memeber' => 2],      //英雄会会员
                ['status' => 2, 'role' => 1],      //'已禁用普通用户' =>查询data_user_info表,普通用户
                ['status' => 2, 'role' => 2],     //'已禁用创业者用户' =>
                ['status' => 2, 'role' => 3],     //'已禁用投资者用户' =>
                ['status' => 2, 'memeber' => 2],    //'已禁用英雄会成员' =>
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
     * @author lw
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
     * @author lw
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
     * @param  int $role  审核的角色 2：创业者  3 投资者 4 英雄会员
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
                    //英雄会会员
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
                    //通过用户审核英雄会员
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