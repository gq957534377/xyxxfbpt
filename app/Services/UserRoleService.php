<?php

namespace App\Services;

use App\Store\HomeStore;
use App\Store\UserStore;
use App\Store\RoleStore;
use App\Store\ApplySybStore;
use App\Store\ApplyInvestorStore;
use App\Store\ApplyMemberStore;
use App\Store\CompanyStore;
use App\Services\UploadService as UploadServer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Tools\CustomPage;
use Illuminate\Support\Facades\DB;


class UserRoleService {
    protected static $homeStore = null;
    protected static $userStore = null;
    protected static $roleStore = null;
    protected static $applySybStore = null;
    protected static $applyInvestorStore = null;
    protected static $applyMemberStore = null;
    protected static $companyStore = null;
    protected static $uploadServer = null;


    /**
     * UserService constructor.
     * @param HomeStore $homeStore
     * @param UserStore $userStore
     * @param RoleStore $roleStore
     */
    public function __construct(
        HomeStore $homeStore,
        UserStore $userStore,
        RoleStore $roleStore,
        ApplySybStore $applySybStore,
        ApplyInvestorStore $applyInvestorStore,
        ApplyMemberStore $applyMemberStore,
        CompanyStore $companyStore,
        UploadServer $uploadServer
    ){
        self::$homeStore = $homeStore;
        self::$userStore = $userStore;
        self::$roleStore = $roleStore;
        self::$applySybStore = $applySybStore;
        self::$applyInvestorStore = $applyInvestorStore;
        self::$applyMemberStore = $applyMemberStore;
        self::$companyStore = $companyStore;
        self::$uploadServer = $uploadServer;
    }

    /**
     * 获取角色表用户信息
     * @param $where
     * @return array
     * @author 刘峻廷
     */
    public function userInfo($where)
    {
//        $result = self::$userStore->getOneData(['guid'=>$where]);

        $result = self::$roleStore->getRole($where);
        //返回错误状态信息
        if(!$result) return ['StatusCode'=> '400','ResultData' => '没有找到'];
        //返回数据
        return  ['StatusCode' => '200', 'ResultData' => $result];
    }

    /**
     * 获取符合请求的所有用户记录
     * @param $data
     * @return array|bool
     * @author wang fei long
     */
    public function getData($data)
    {
        if (isset($data['name']))
            return self::getOneData($data);

        if(!isset($data['role']) || !isset($data['status']))
            return ['status' => false, 'data' => '请求参数错误'];
        if(!in_array($data['role'], ['4', '5']))
            return ['status' => false, 'data' => '请求参数错误'];

        $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;

        $userData = self::$roleStore
            ->getUsersData($nowPage, ['role' => ($data['role'] - 2), 'status' => $data['status']]);
        if ($userData === false)
            return ['status' => false, 'data' => '缺少分页信息，数据获取失败'];
        if ($userData === [])
            return ['status' => 'empty', 'data' => '没有查询到数据'];

        $userPage = self::getPage($data, 'user_role/create');
        if (!$userPage)
            return ['status' => false, 'data' => '分页获取失败'];

        //拼装数据，返回所需格式
        $result = array_merge(['data'=> $userData], $userPage['data']);
        if (!$result)
            return ['status' => false, 'data' => '系统错误'];

        return ['status' => true, 'data' => $result];
    }

    /**
     * 获取分页
     * @param $data
     * @param $url
     * @return array
     * @author wang fei long
     */
    private static function getPage($data, $url)
    {
        $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;
        $count = self::$roleStore
            ->getUsersNumber(['role' => ($data['role'] - 2), 'status' => $data['status']]);
        $totalPage = ceil($count / PAGENUM);
        $baseUrl   = url($url);

        if($nowPage <= 0)
            $nowPage = 1;
        if($nowPage > $totalPage)
            $nowPage = $totalPage;

        return [
            'status' => true,
            'data' => [
                'nowPage' => $nowPage,
                'pages'   => CustomPage::getSelfPageView($nowPage, $totalPage, $baseUrl,null)
            ]
        ];
    }

    /**
     * 获取一条用户信息，后台
     * @param $data
     * @return array
     * @Author wang fei long
     */
    public function getOneData($data)
    {
        $result = self::$roleStore
            ->getOneData(['guid' => $data['name']]);

        if (!$result)
            return ['status' => false, 'data' => '系统错误'];

        return ['status' => true, 'data' => $result];
    }

    /**
     * 修改用户信息
     * @param $where
     * @param $data
     * @return array
     * @author 刘峻廷
     */
    public function updataUserInfo($where,$data)
    {
        // 检验条件
       if (empty($where) || empty($data)) return ['status'=>400,'msg'=>'缺少数据'];
        // 提交数据给store层
        $info = self::$roleStore->updateUserInfo($where,$data);
        if(!$info) return ['status'=>400,'msg'=>'修改失败！'];
        return ['status'=>200,'msg'=>'修改成功！'];
    }

    /**
     * @param $where
     * @param $data
     * @return array
     * @author wang fei long
     */
    public function updataUserRoleInfo($where,$data)
    {
        // 检验条件
        if (empty($where) || empty($data)) return ['status' => false, 'data' => '请求参数错误'];
        // 提交数据给store层
        $info = self::$roleStore->updateUserInfo($where,$data);
        if(!$info) return ['status'=>false,'data'=>'修改失败！'];
        return ['status'=>true,'data'=>'修改成功！'];
    }

    /**
     * 修改user_info中的角色值
     * @param $where
     * @param $data
     * @return array
     * @author 贾济林
     */
    public function userRoleChange($where,$data)
    {
        // 检验条件
        if (empty($where) || empty($data)) return ['status' => false, 'data' => '请求参数错误'];
        // 提交数据给store层
        $info = self::$userStore->updateUserInfo($where,$data);
        if(!$info) return ['status'=>false,'data'=>'修改失败！'];
        return ['status'=>true,'data'=>'修改成功！'];
    }

    /**
     * 用户审核，修改角色
     * @param $where
     * @param $data
     * @return array
     * @modify 刘峻廷
     */
    public function userCheck($where, $data)
    {
        if (isset($data['memeber'])) {

                // 开启事务，英雄会会员修改状态
                DB::transaction(function () use ($where, $data){

                    //同时修改用户表中的会员值和会员表中的状态值
                    $res_role = self::updataUserInfo($where, $data);

                    //获取角色表中的角色值
                    $roleData = self::$roleStore->getRole($where);
                    $memeber = $roleData->memeber;
                    $userData = ['memeber' => $memeber];

                    $res_user = self::userRoleChange($where, $userData);
                });

        } else {
            //如果不通过，直接修改角色表中状态
            if ($data['status']==3) $res_role = self::updataUserInfo($where, $data);

            //如果通过，开启事务，同时操作角色表和用户表
            if ($data['status']==2) {
                DB::transaction(function () use ($where, $data){

                    //获取角色表中的角色值
                    $roleData = self::$roleStore->getRole($where);
                    $role = $roleData->role;
                    $userData = ['role' => $role];

                    //同时修改用户表中的角色值和角色表中的状态值
                    $res_role = self::updataUserInfo($where, $data);
                    $res_user = self::userRoleChange($where, $userData);
                });

            }
        }


        if(isset($res_role)&&$res_role['status']==400) return ['status'=>400,'msg'=>'修改失败！'];
        return ['status'=>200,'msg'=>'修改成功！'];
    }
    
    /**
     * 获得指定条件的数据
     * @param $where
     * @return array
     * @author 贾济林
     */
    public function getList($where)
    {
        $res = self::$roleStore->getList($where);
        if ($res==0) return ['status' => '500', 'msg' => '未找到数据'];
        return ['status' => '200', 'data' => $res];
    }

    /**
     * 创业者 验证字段
     * @param $request
     * @return array
     * @author 刘峻廷
     */
    public function sybValidator($request)
    {
        $validator = Validator::make($request->all(),[
            'guid' => 'required',
            'role' => 'required',
            'realname' => 'required|min:2',
            'card_pic_a' => 'required',
            'card_pic_b' => 'required',
            'school_address' => 'required',
            'school_name' => 'required',
            'enrollment_year' => 'required',
            'graduation_year' => 'required',
            'education' => 'required',
            'major' => 'required',

        ],[
            'guid.required' => '非法操作',
            'role.required' => '非法操作',
            'realname.required' => '请填写您的真实姓名',
            'realname.min' => '真实姓名最少两位',
            'card_pic_a.required' => '请上传您的出身份证正面照',
            'card_pic_b.required' => '请上传您的出身份证反面照',
            'school_address.required' => '请选择您所在院校的省份',
            'school_name.required' => '请选择您所在院校的名字',
            'enrollment_year.required' => '请输入您的入学时间',
            'graduation_year.required' => '请输入您的毕业时间',
            'education.required' => '请输入您的学历',
            'major.required' => '请输入您的专业名称',

        ]);

        // 数据验证失败，响应信息
        if ($validator->fails()) return ['StatusCode' => '400','ResultData' => $validator->errors()->all()];
    }

    /**
     * 投资者 验证字段
     * @param $request
     * @return array
     * @author 刘峻廷
     */
    public function investorValidator($request)
    {
        $validator = Validator::make($request->all(),[
            'guid' => 'required',
            'role' => 'required',
            'realname' => 'required|min:2',
            'work_year' => 'required|integer|digits_between:1,2',
            'scale' => 'required',
            'company' => 'required',
            'company_address' => 'required',
            'field' => 'required',
            'card_pic_a' => 'required',
        ],[
            'guid.required' => '非法操作',
            'role.required' => '非法操作',
            'realname.required' => '请填写您的真实姓名',
            'realname.min' => '真实姓名最少两位',
            'work_year.required' => '请输入从业年份',
            'work_year.integer' => '请输入整型',
            'work_year.digits_between' => '请输入两位以内数字',
            'scale.required' => '请输入投资规模',
            'company.required' => '请输入公司名称',
            'company_address.required' => '请输入公司所在地',
            'field.required' => '请选择行业领域',
            'card_pic_a.required' => '请上传身份证件照',
        ]);

        // 数据验证失败，响应信息
        if ($validator->fails()) return ['StatusCode' => '400','ResultData' => $validator->errors()->all()];
    }

    /**
     * 申请角色
     * @param array $data
     * @return array
     * @author 刘峻廷
     */
    public function applyRole($data) {
        // 校验当前用户的角色
        $userInfo = self::$userStore->getOneData(['guid' => $data['guid']]);

        // 身份角色先过滤，不让进行二次申请
        switch ($data['role']) {
            case '2':
                if ($userInfo->role == '2') return  ['StatusCode' => '400', 'ResultData' => '您已是创业者，无需申请！'];
                $info = self::$applySybStore->getOneData(['guid' => $data['guid']]);
                break;
            case '3':
                if ($userInfo->role == '3') return  ['StatusCode' => '400', 'ResultData' => '您已是投资者，无需申请！'];
                $info = self::$applyInvestorStore->getOneData(['guid' => $data['guid']]);
                break;
            case '4':
                if ($userInfo->role == '4') return  ['StatusCode' => '400', 'ResultData' => '您已是英雄会成员，无需申请！'];
                $info = self::$applyMemberStore->getOneData(['guid' => $data['guid']]);
                break;
        }

        // 返回查询记录存在，并且状态不是7的都不允许再次申请
        if (!empty($info)) {
            if ($info->status != '7') return ['StatusCode' => '400', 'ResultData' => '已申请，正在审核中'];
        }

        // 通过后，申请角色
        switch ($data['role']) {
            case '2':
                $result = self::$applySybStore->addOneData($data);
                break;
            case '3':
                $result = self::$applyInvestorStore->addOneData($data);
                break;
            case '4':
                $result = self::$applyMemberStore->addOneData($data);
                break;
        }

        if (!$result) {
            \Log::error('添加角色申请记录失败', $data);
            return ['StatusCode' => '400', 'ResultData' => '添加角色申请记录失败，请重新申请'];
        }

        return ['StatusCode' => '200', 'ResultData' => '申请成功，等待审核...'];
    }

    /**
     * 获取角色信息，存入session
     * @param $guid
     * @author 刘峻廷
     */
    public function getRoleInfo($guid)
    {

        $syb = self::$applySybStore->getOneData(['guid' => $guid]);
        if (!$syb) {
            $roleInfo[2] = null;
        }else{
            // 如果是创业者了，获取下公司信息
            $company = self::$companyStore->getOneData(['guid' => $guid]);
            if (!$company) {
                $company = [];
            }
            $syb->company = $company;
        }

        $investor = self::$applyInvestorStore->getOneData(['guid' => $guid]);
        if (!$investor) {
            $roleInfo[3] = null;
        }
        // 往session里存入
        $roleInfo[2] = $syb;
        $roleInfo[3] = $investor;

        return $roleInfo;
    }

    /**
     * 修改申请角色信息
     * @param $where
     * @param $data
     * @return array
     * @author 刘峻廷
     */
    public function updateRoleInfo($where, $data)
    {
        switch ($data['role']) {
            case '2':
                beack;
            case '3':
                $result = self::$applyInvestorStore->updataOneData(['id' => $where], $data);
                break;
        }

        if (!$result) {
            Log::error('更新申请角色信息失败', $data);
            return ['StatusCode' => '400', 'ResultData' => '更新申请角色信息失败'];
        }

        // 更新session
        session('roleInfo')[$data['role']]->scale = $data['scale'];
        session('roleInfo')[$data['role']]->filed = $data['field'];

        return ['StatusCode' => '200', 'ResultData' => '更新申请角色信息成功'];
    }

}