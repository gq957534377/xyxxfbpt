<?php

namespace App\Services;

use App\Store\HomeStore;
use App\Store\UserStore;
use App\Store\ApplySybStore;
use App\Store\ApplyInvestorStore;
use App\Store\ApplyMemberStore;
use App\Store\CompanyStore;
use App\Services\UploadService as UploadServer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;



class UserRoleService {
    protected static $homeStore = null;
    protected static $userStore = null;
    protected static $applySybStore = null;
    protected static $applyInvestorStore = null;
    protected static $applyMemberStore = null;
    protected static $companyStore = null;
    protected static $uploadServer = null;


    /**
     * UserService constructor.
     * @param HomeStore $homeStore
     * @param UserStore $userStore
     */
    public function __construct(
        HomeStore $homeStore,
        UserStore $userStore,
        ApplySybStore $applySybStore,
        ApplyInvestorStore $applyInvestorStore,
        ApplyMemberStore $applyMemberStore,
        CompanyStore $companyStore,
        UploadServer $uploadServer
    ){
        self::$homeStore = $homeStore;
        self::$userStore = $userStore;
        self::$applySybStore = $applySybStore;
        self::$applyInvestorStore = $applyInvestorStore;
        self::$applyMemberStore = $applyMemberStore;
        self::$companyStore = $companyStore;
        self::$uploadServer = $uploadServer;
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
            'realname' => 'required|min:2|max:16',
            'card_pic_a' => 'required',
            'card_pic_b' => 'required',
            'school_address' => 'required|regex:/^[\x80-\xff]+$/',
            'school_name' => 'required|regex:/^[\x80-\xff-a-zA-Z]+$/',
            'enrollment_year' => 'required',
            'graduation_year' => 'required',
            'education' => 'required',
            'major' => 'required|regex:/^[\x80-\xff-a-zA-Z0-9]+$/',

        ],[
            'guid.required' => '非法操作',
            'role.required' => '非法操作',
            'realname.required' => '请填写您的真实姓名',
            'realname.min' => '真实姓名最少两位',
            'realname.max' => '真实姓名最长16位',
            'card_pic_a.required' => '请上传您的出身份证正面照',
            'card_pic_b.required' => '请上传您的出身份证反面照',
            'school_address.required' => '请选择您所在院校的省份',
            'school_address.regex' => '省份只允许输入中文',
            'school_name.required' => '请选择您所在院校的名字',
            'school_name.regex' => '请选择您所在院校的名字只允许输入中文、字母',
            'enrollment_year.required' => '请输入您的入学时间',
            'graduation_year.required' => '请输入您的毕业时间',
            'education.required' => '请输入您的学历',
            'major.required' => '请输入您的专业名称',
            'major.regex' => '专业名称只允许输入中文、字母、数字、下划线',

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
            'realname' => 'required|min:2|max:16',
            'work_year' => 'required|integer|digits_between:1,2',
            'scale' => 'required',
            'company' => 'required|regex:/^[\x80-\xff-a-zA-Z0-9]+$/',
            'company_address' => 'required',
            'field' => 'required|regex:/^[\x80-\xff_\-\/_a-zA-Z0-9]+$/',
            'card_pic_a' => 'required',
        ],[
            'guid.required' => '非法操作',
            'role.required' => '非法操作',
            'realname.required' => '请填写您的真实姓名',
            'realname.min' => '真实姓名最少两位',
            'realname.max' => '真实姓名最长16位',
            'work_year.required' => '请输入从业年份',
            'work_year.integer' => '请输入整型',
            'work_year.digits_between' => '请输入两位以内数字',
            'scale.required' => '请输入投资规模',
            'company.required' => '请输入公司名称',
            'company.regex' => '公司名称只允许输入中文、字母、数字、下划线',
            'company_address.required' => '请输入公司所在地',
            'field.required' => '请选择行业领域',
            'field.regex' => '行业领域格式不对',
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
        \DB::beginTransaction();

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

        if (!isset($userInfo->realname)){
            $result = self::$userStore->updateUserInfo(['guid' => $data['guid']], ['realname' => $data['realname']]);

            if (!$result) {
                \Log::error('添加角色申请记录成功，同步更新用户信息失败', ['guid' => $data['guid']], ['realname' => $data['realname']]);
                \DB::rollBack();
                return ['StatusCode' => '400', 'ResultData' => '添加角色申请记录失败，请重新申请'];
            }
        }

        if ($userInfo->realname != $data['realname']) {
            \Log::error('核实真实姓名', ['guid' => $data['guid']], ['realname' => $data['realname']]);
            \DB::rollBack();
            return ['StatusCode' => '400', 'ResultData' => '核实真实姓名，与本平台真实姓名不一致'];
        }

        \DB::commit();
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