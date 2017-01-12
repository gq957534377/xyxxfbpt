<?php

namespace App\Services;

use App\Redis\UserAccountCache;
use App\Store\HomeStore;
use App\Store\UserStore;
use App\Store\CompanyStore as CompanyStore;
use App\Services\UploadService as UploadServer;
use App\Services\UserRoleService as UserRoleServer;
use App\Tools\Common;
use App\Tools\CustomPage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Mail;

class UserService {
    protected static $accountCache = null;
    protected static $homeStore = null;
    protected static $userStore = null;
    protected static $companyStore = null;
    protected static $uploadServer = null;
    protected static $userRoleServer = null;

    /**
     * UserService constructor.
     * @param HomeStore $homeStore
     * @param UserStore $userStore
     */
    public function __construct(
        UserAccountCache $accountCache,
        HomeStore $homeStore,
        UserStore $userStore,
        CompanyStore $companyStore,
        UploadServer $uploadServer,
        UserRoleServer $userRoleServer
    ){
        self::$accountCache = $accountCache;
        self::$homeStore = $homeStore;
        self::$userStore = $userStore;
        self::$companyStore = $companyStore;
        self::$uploadServer = $uploadServer;
        self::$userRoleServer = $userRoleServer;
    }

    /**
     * 获取用户信息
     * @param $where
     * @return array
     * @author 刘峻廷
     */
    public function userInfo($where)
    {
        $result = self::$userStore->getOneData($where);
        //返回错误状态信息
        if(!$result) return ['StatusCode' => '400','ResultData' => '没有找到该用户信息!'];;
        //返回数据
        return ['StatusCode' => '200','ResultData' => $result];
    }

    /**
     * 注册用户
     * @param $data
     * @return string
     * @author 刘峻廷
     * @modify 王通
     */
    public function addUser($data)
    {

//        // 检验用户是否被注册
//        $result = self::$homeStore->getOneData(['tel' => $data['tel']]);
//        // 返回真，用户存在
//        if ($result) return ['status' => '400', 'msg' => '用户已存在！'];

        // 返回假，添加数据，先对数据提纯
        $data['guid'] = Common::getUuid();
        $data['password'] = Common::cryptString($data['tel'], $data['password'], 'hero');
        $data['addtime'] = $_SERVER['REQUEST_TIME'];

        $phone = $data['tel'];
        unset($data['confirm_password']);
        unset($data['stage']);

        // 执行事务
        DB::beginTransaction();

        // 存入登录表
        $loginInfo = self::$homeStore -> addData($data);
        // 数据写入失败
        if (!$loginInfo) {
            Log::error('注册用户失败', $data);
            return ['status' => '500', 'msg' => '数据写入失败！'];
        };

        // 获取当前的用户量
        // $countUsers = self::$userStore->countUsers();

        // 添加数据成功到登录表，然后在往用户信息表里插入一条
        $userInfo = self::$userStore->addUserInfo(['guid' => $data['guid'], 'tel' => $phone, 'headpic' => 'http://ogd29n56i.bkt.clouddn.com/20161129112051.jpg', 'addtime' => $data['addtime']]);
        if (!$userInfo) {
            Log::error('用户注册信息写入失败', $userInfo);
            DB::rollback();
            return ['status' => '500', 'msg' => '用户信息添加失败，请重新注册!'];
        } else {
            // 用户注册成功，写入redis
            $data['status'] = 1;
            self::$accountCache->insertOneAccount($data);
            DB::commit();
            return ['status'=>'200', 'msg'=>'注册成功'];
        }


    }

    /**
     * 注册用户 旧
     * @param $data
     * @return string
     * @author 刘峻廷
     */
    public function addUserOld($data)
    {
        // 检验用户是否被注册
        $result = self::$homeStore->getOneData(['email' => $data['email']]);
        // 返回真，用户存在
        if($result) return ['status' => '400','msg' => '用户已存在！'];

        // 返回假，添加数据，先对数据提纯
        $data['guid'] = Common::getUuid();
        $data['password'] = Common::cryptString($data['email'],$data['password'],'hero');
        $data['addtime'] = $_SERVER['REQUEST_TIME'];
        // 保存两个用户信息字段
        $nickname = $data['nickname'];
        $phone = $data['phone'];
        unset($data['confirm_password']);
        unset($data['_token']);
        unset($data['nickname']);
        unset($data['code']);
        unset($data['phone']);

        // 执行事务
        DB::beginTransaction();

        // 存入登录表
        $loginInfo = self::$homeStore -> addData($data);
        // 数据写入失败
        if (!$loginInfo) {
            Log::error('注册用户失败',$data);
            return ['status' => '500','msg' => '数据写入失败！'];
        };

        // 添加数据成功到登录表，然后在往用户信息表里插入一条
        $userInfo = self::$userStore->addUserInfo(['guid' => $data['guid'],'nickname' => $nickname,'tel' => $phone,'email' =>  $data['email'],'headpic' => 'http://ogd29n56i.bkt.clouddn.com/20161129112051.jpg']);

        if (!$userInfo) {
            Log::error('用户注册信息写入失败',$userInfo);
            DB::rollback();
            return ['status' => '500','msg' => '用户信息添加失败，请重新注册!'];
        } else {
            DB::commit();
            return ['status'=>'200','msg'=>'注册成功'];
        }


    }


    /**
     * 验证手机号是否存在
     * @param $data
     * @return bool
     */
    public function checkUser($data)
    {
        // 先判断Account队列缓存是否存在
        if (!self::$accountCache->exists()) {
            // 不存在，读取MySql存入redis,并且将获取到的对象转成数组
            $accountList = CustomPage::objectToArray(self::$homeStore->getAllData());

            if (count($accountList)) {
                self::$accountCache->setUserAccountList($accountList);
            }
        }

        $result = self::$accountCache->getOneAccount($data['tel']);
        // 检验用户是否被注册
        //  $result = self::$homeStore->getOneData(['tel' => $data['tel']]);
        // 返回真，用户存在
        return $result;
    }
    /**
     * 用户登录
     * @param array $data
     * @return string
     * @auther 刘峻廷
     * @modify 王通
     */
    public function  loginCheck($data)
    {
        // 先判断Account队列缓存是否存在
        if (!self::$accountCache->exists()) {
            // 不存在，读取MySql存入redis,并且将获取到的对象转成数组
            $accountList = CustomPage::objectToArray(self::$homeStore->getAllData());

            if (count($accountList)) {
                self::$accountCache->setUserAccountList($accountList);
            }
        }

        // 存在，判断list队列中该账户是否存在
        $temp = self::$accountCache->getOneAccount($data['tel']);

        if (empty($temp)) {
            // 查询数据
            $temp = self::$homeStore->getOneData(['tel' => $data['tel']]);
        }

        // 返回假，说明此账号不存在
        if(!$temp) return ['StatusCode' => '400','ResultData' => '账号不存在或输入错误！'];
        // 对密码进行加密
        $pass = Common::cryptString($data['tel'],$data['password'],'hero');
        // 密码校验
        if ($pass != $temp->password) return ['StatusCode' => '400','ResultData' => '密码错误！'];

        // 返回真，再进行账号状态判断
        if($temp->status == '2') return ['StatusCode' => '400','ResultData' => '账号已被禁用，请紧快与客服联系！'];

        // 数据提纯
        unset($temp->password);
        //   客户端请求过来的时间
        $time = $_SERVER['REQUEST_TIME'];

        // 更新数据表，登录和ip
        $info = self::$homeStore->updateData(['guid'=>$temp->guid],['logintime' => $time,'ip' => $data['ip']]);

        if(!$info) {
            Log::error('更新用户登录信息失败', $data);
            return ['StatusCode' => '400', 'ResultData' => '服务器数据异常！'];
        }
        // 更新成功，redis同步更新
        $temp->logintime = $time;
        $temp->ip = $data['ip'];
        $redisInfo = self::$accountCache->setOneAccount(CustomPage::objectToArray($temp));

        if ($redisInfo != 'OK') {
            Log::info($temp->tel.'用户登录更新redis失败');
        }

        //将一些用户的信息推到session里，方便维持
        $userInfo = self::$userStore->getOneData(['guid' => $temp->guid]);

        // 用户信息缺失，需要给用户信息表重新插入一条基本信息
        if (!$userInfo) {
            Log::error('账号异常，用户信息缺失', ['guid' => $temp->guid, 'tel' => $temp->tel, 'time' => $time ]);
            $userInfo = self::$userStore->addUserInfo(['guid' => $temp->guid, 'tel' => $temp->tel]);

            if (!$userInfo) {
                Log::error('账号异常，用户信息缺失,补充用户信息失败', ['guid' => $temp->guid, 'tel' => $temp->tel, 'time' => $time, 'headpic' => '/home/img/user_center.jpg' ]);
                return ['StatusCode' => '400','ResultData' => '账号异常，请联系管理员！'];
            }
        }

        //获取角色状态
        $temp->role = $userInfo->role;
        //获取用户信息头像
        $temp->headpic = $userInfo->headpic;
        //获取用户昵称
        $temp->nickname = $userInfo->nickname;
        //获取用户的Memeber状态
        $temp->memeber = $userInfo->memeber;

        Session::put('user', $temp);

        return ['StatusCode' => '200','ResultData' => '登录成功！'];
    }

    /**
     * 忘记密码的情况，修改密码
     * @param $data
     * @return array
     * @author 王通
     */
    public function talChangePassword($data)
    {
        // 查询用户的信息
        $result = self::$homeStore->getOneData(['tel' => $data['tel']]);

        // 判断数据
        if (!$result) return ['StatusCode' => '400', 'ResultData' => '账号不存在'];

        //加密密码
        $pass = Common::cryptString($result->tel, $data['password'], 'hero');

        if ($result->password == $pass) return ['StatusCode' => '400', 'ResultData' => '原始密码与新密码相同，请更换密码'];
        if($result->status != '1') return ['StatusCode' => '400','ResultData' => '账号存在异常，已锁定，请紧快与客服联系！'];
        // 更新密码

        $result = self::$homeStore->updateData(['tel' => $data['tel']], ['password' => $pass]);
        Session::put('sms',null);
        if (!$result) {
            \Log::error('前端用户修改密码失败', $result);
            return ['StatusCode' => '400', 'ResultData' => '修改密码失败'];
        } else {
            return ['StatusCode' => '200', 'ResultData' => '修改密码成功'];
        }
    }
    /**
     * 发送短信，时间间隔验证
     * @param $phone
     * @return string
     * @author 刘峻廷
     * @modify 王通
     */
    public function sendSmsCode($phone)
    {
        // 获取当前时间戳
        $nowTime = $_SERVER['REQUEST_TIME'];
        // 判断该号码两分中内是否发过短信
        $sms = Session::get('sms');
        $number = mt_rand(100000, 999999);
        $content = ['phone' => $phone,'number' => $number];
        $resIp = SafetyService::checkIpSMSCode(\Request::getClientIp(), $number);
        $resPhoto = SafetyService::checkPhoneSMSCode($phone, $number);
        if ($resIp || $resPhoto) {
            return ['StatusCode' => '400','ResultData' => '获取验证码过于频繁，请稍后再试!!'];
        }

        //校验
        if($sms['phone']==$phone){
            // 两分之内，不在发短信
            if(($sms['time'] + 60)> $nowTime ) return ['StatusCode' => '400','ResultData' => '短信已发送，请等待！'];
            // 两分钟之后，可以再次发送
            $resp = Common::sendSms($phone, $content);

            // 发送失败
            if(!$resp) return ['StatusCode' => '400','ResultData' => '短信发送失败，请重新发送！'];
            // 成功，保存信息到session里，为了下一次校验
            $arr = ['phone' => $phone,'time' => $nowTime,'smsCode' => $number];
            Session::put('sms',$arr);
            Log::info(date('Y-m-d', $nowTime) . \Request::getClientIp() . '请求短信' . '手机号' . $phone);
            return ['StatusCode' => '200','ResultData' => '发送成功，请注意查收！'];
        }else{

            $resp =  Common::sendSms($phone, $content);

            // 发送失败
            if(!$resp) return ['StatusCode' => '400','ResultData' => '短信发送失败，请重新发送!！'];
            $arr = ['phone' => $phone,'time' => $nowTime,'smsCode' => $number];
            Session::put('sms',$arr);
            Log::info(date('Y-m-d', $nowTime) . \Request::getClientIp() . '请求短信' . '手机号' . $phone);
            return ['StatusCode' => '200','ResultData' => '发送成功，请注意查收！'];
        }
    }


    /**
     * 修改用户信息
     * @param $where
     * @param $data
     * @return array
     * @author 刘峻廷
     */
    public function updataUserInfo($where, $data)
    {
        // 检验条件
       if (empty($where) || empty($data)) return ['StatusCode' => '400','ResultData' => '缺少数据'];
        // 提交数据给store层
        $info = self::$userStore->updateUserInfo($where, $data);

        if(!$info) return ['StatusCode' => '400','ResultData' => '修改失败，您并没有做什么修改！'];

        session('user')->nickname = $data['nickname'];

        return ['StatusCode' => '200','ResultData' => '更新成功!'];
    }

    /**
     * 头像上传
     *
     * @param $where
     * @param $data
     * @return array
     * @author 刘峻廷
     */
    public function avatar($guid,$avatarName)
    {
        // 检验数据
        if(empty($guid) || empty($avatarName)) return ['StatusCode' => '400','ResultData' => '缺少数据'];
        //转交store层
        $info = self::$userStore->updateUserInfo(['guid' => $guid],['headpic' => $avatarName]);

        if(!$info) {
            Log::error('头像上传失败',$info);
            return ['StatusCode' => '400','ResultData' => '保存失败'];
        }

        session('user')->headpic = $avatarName;
        return ['StatusCode' => '200','ResultData' => $avatarName];

    }

    /**
     * 账号密码修改
     * @param object $request
     * @return array
     * @author 刘峻廷
     */
    public function changePassword($request)
    {
        // 先判断Account队列缓存是否存在
        if (!self::$accountCache->exists()) {
            // 不存在，读取MySql存入redis,并且将获取到的对象转成数组
            $accountList = CustomPage::objectToArray(self::$homeStore->getAllData());

            if (count($accountList)) {
                self::$accountCache->setUserAccountList($accountList);
            }
        }

        // 查询用户的信息
        $result = self::$homeStore->getOneData(['guid' => $request->guid]);

        // 判断数据
        if (!$result) return ['StatusCode' => '400', 'ResultData' => '账号不存在'];

        //加密密码
        $pass = Common::cryptString($result->email, $request->password, 'hero');

        if  ($result->password != $pass) return ['StatusCode' => '400', 'ResultData' => '原始密码错误'];

        // 对新密码进行加密，然后与旧密码进行对比
        $new_pass = Common::cryptString($result->email, $request->new_password, 'hero');

        if ($pass == $new_pass) return ['StatusCode' => '400', 'ResultData' => '原始密码与新密码相同，请更换密码'];

        // 更新密码

        $result = self::$homeStore->updateData(['guid' => $request->guid], ['password' => $new_pass]);

        if (!$result) {
            \Log::error('前端用户修改密码失败', $request->all());
            return ['StatusCode' => '400', 'ResultData' => '修改密码失败'];
        } else {
            $redisResult = self::$accountCache->setOneAccount(CustomPage::objectToArray(self::$homeStore->getOneData(['guid' => $request->guid])));
            if ($redisResult != 'OK') {
                \Log::info($request->guid.'用户修改密码写入缓存失败!');
            }
            return ['StatusCode' => '200', 'ResultData' => '修改密码成功'];
        }

    }

    /**
     * 发送Email
     * @param object $request
     * @return array
     * @author 刘峻廷
     */
     public function sendEmail($request)
     {
         $userInfo = self::$userStore->getOneData(['guid' => $request->guid]);

         // 给新邮箱发送邮件
         $name = $userInfo->nickname;
         $content = strtolower(str_random(4));
         $to = $request->newEmail;

         //先判断当前账号是否已经发过Email了
         // 获取当前时间戳
         $nowTime = $_SERVER['REQUEST_TIME'];
         $email = Session::get('email');

         if (isset($email) && $email['email'] == $to) {

             // 60秒内不能再次发送Email
             if (($email['time'] + 60) > $nowTime) return ['StatusCode' => '400', 'ResultData' => '邮箱已经发送了，请等待60秒!'];
         }

         // 发送Email
         $flag = Mail::send('home.email.emails', ['name' => $name, 'content' => $content], function($message) use ($to){
             $message->to($to)->subject('琦力英雄会，邮箱改绑');
         });

         if(!$flag) return ['StatusCode' => '400', 'ResultData' => '邮件发送失败！'];

         // 发送成功，向Session 里存值，当前发送邮箱账号、请求时间、验证码
         $arr = ['email' => $to, 'time' => $_SERVER['REQUEST_TIME'], 'code' => $content];
         Session::put('email', $arr);

         return ['StatusCode' => '200', 'ResultData' => '邮件发送成功！'];
     }

    /**
     * 更改邮箱绑定
     * @param $data
     * @param $guid
     * @return array
     * @author 刘峻廷
     */
    public function changeEmail($where, $data)
    {
        // 检验数据
        if (empty($where) || empty($data)) return ['StatusCode' => '400', 'ResultData' => '缺少数据信息'];

       // 判断当前用户的邮箱和更新的邮箱进行比对
        $result = self::$homeStore->getOneData(['guid' => $where]);

        if (!$result) return ['StatusCode' => '400', 'ResultData' => '当前用户不存在！'];

        // 原始邮箱和新邮箱是否一样
        if ($result->email == $data) return ['StatusCode' => '400', 'ResultData' => '原始邮箱与新邮箱相同，请更换一个。'];

        // 新改绑的邮箱是否已经存在

        $result = self::$homeStore->getOneData(['email' => $data]);

        if ($result) ['StatusCode' => '400', 'ResultData' => '您输入的新邮箱已存在，请更换一个!'];

        // 更新邮箱

        $result = self::$homeStore->updateData(['guid' => $where], ['email' => $data]);

        if (!$result) {
            \Log::error('更换邮箱错误', $result);
            return['StatusCode' => '400', 'ResultData' => '绑定邮箱失败!'];
        } else {
            $redisResult = self::$accountCache->setOneAccount(CustomPage::objectToArray(self::$homeStore->getOneData(['guid' => $where])));
            if ($redisResult != 'OK') {
                \Log::info($where.'用户修改密码写入缓存失败!');
            }
            $email = substr_replace(trim($data), '****', 2, 4);
            return ['StatusCode' => '200', 'ResultData' => $email];
        }

    }

    /**
     * 更改手机号绑定
     * @param $data
     * @param $guid
     * @return array
     * @author 刘峻廷
     */
    public function changeTel($guid, $data)
    {
        // 执行事务
        \DB::beginTransaction();

        $result = self::$homeStore->updateData(['guid' => $guid], ['tel' => $data]);

        if (!$result) {
            \Log::error('用户账号手机绑定修改失败', ['guid' => $guid, ['tel' => $data]]);
            return ['StatusCode' => '400', 'ResultData' => '手机改绑失败!'];
        }

        $result = self::$userStore->updateUserInfo(['guid' => $guid], ['tel' => $data]);

        if (!$result) {
            \Log::error('用户账号手机绑定，更新用户中心信息表失败', ['guid' => $guid], ['tel' => $data]);
            \DB::rollback();
            return ['StatusCode' => '400', 'ResultData' => '手机改绑失败!'];
        }
        $redisResult = self::$accountCache->setOneAccount(CustomPage::objectToArray(self::$homeStore->getOneData(['guid' => $guid])));
        if ($redisResult != 'OK') {
            \Log::info($guid.'用户手机绑定写入缓存失败!');
        }
        \DB::commit();
        return ['StatusCode' => '200', 'ResultData' => '手机改绑成功，请重新登录!'];

    }

    /**
     * 获取账号信息
     * @param $where
     * @return array
     * @author 刘峻廷
     */
    public function accountInfo($where)
    {
        $result = self::$homeStore->getOneData($where);

        // 判断数据
        if (!$result) return ['StatusCode' => '400', 'ResultData' => '账号不存在'];

        return ['StatusCode' => '200', 'ResultData' => $result];

    }

    /**
     * 获取指定guid的所有用户的信息
     * @param [] $guids 用户guid数组
     * @return array
     * @author 郭庆
     */
    public function getUsers($guids, $nowPage, $forPages, $url, $disPlay=true)
    {
        $count = self::$userStore->getUsersCount('guid', $guids);
        if (!$count) {
            //如果没有数据直接返回201空数组，函数结束
            if ($count == 0) return ['StatusCode' => '204', 'ResultData' => []];
            return ['StatusCode' => '400', 'ResultData' => '数据参数有误'];
        }

        //计算总页数
        $totalPage = ceil($count / $forPages);
        //获取所有数据
        $result['data'] = self::$userStore->getUsersPage('guid', $guids, $nowPage, $forPages);
        if($result['data']){
            if ($disPlay && $totalPage > 1) {
                //创建分页样式
                $creatPage = CustomPage::getSelfPageView($nowPage, $totalPage, $url, null);

                if($creatPage){
                    $result["pages"] = $creatPage;
                }else{
                    return ['StatusCode' => '500','ResultData' => '生成分页样式发生错误'];
                }
            }else{
                $result['totalPage'] = $totalPage;
                $result["pages"] = '';
            }
            return ['StatusCode' => '200','ResultData' => $result];
        }else{
            return ['StatusCode' => '500','ResultData' => '获取报名分页数据失败！'];
        }
    }

    /**
     * 添加公司
     * @param $data
     * @return array
     * @author 刘峻廷
     */
    public function addCompany($data)
    {
        // 查询数据表里是否已有数据
        $result = self::$companyStore->getOneData(['guid' => $data['guid']]);

        if ($result) return ['StatusCode' => '400', 'ResultData' => '已添加'];

        $result = self::$companyStore->addOneData($data);

        if (!$result) {
            Log::error('添加公司信息失败', $data);
            return ['StatusCode' => '400', 'ResultData' => '添加失败'];
        }
        return ['StatusCode' => '200', 'ResultData' => '创建成功，等待审核'];

    }

    /**
     * 获取公司信息
     * @param $where
     * @return array
     * @author 刘峻廷
     */
    public function getCompany($where)
    {
        if (empty($where)) return ['StatusCode' => '400', 'ResultData' => '请求参数缺失'];

        $result = self::$companyStore->getOneData(['guid' => $where]);

        if (!$result) return ['StatusCode' => '400', 'ResultData' => '请添加公司信息'];

        return ['StatusCode' => '200', 'ResultData' => $result];
    }

}