<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Store\HomeStore;
use App\Store\UserStore;
use App\Store\RoleStore;
use App\Services\UploadService as UploadServer;
use App\Tools\Common;
use App\Tools\CustomPage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserService {
    protected static $homeStore = null;
    protected static $userStore = null;
    protected static $roleStore = null;
    protected static $uploadServer = null;

    /**
     * UserService constructor.
     * @param HomeStore $homeStore
     * @param UserStore $userStore
     * @param RoleStore $roleStore
     */
    public function __construct(HomeStore $homeStore ,UserStore $userStore,  RoleStore $roleStore,UploadServer $uploadServer)
    {
        self::$homeStore = $homeStore;
        self::$userStore = $userStore;
        self::$roleStore = $roleStore;
        self::$uploadServer = $uploadServer;
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
        if(!$result) return ['status' => false,'msg' => '没有找到'];
        //返回数据
        return  ['status' => true,'msg' => $result];
    }

    /**
     * 获取申请角色信息
     * @param $where
     * @return array
     * @author 刘峻廷
     */
    public function roleInfo($where)
    {
        $result = self::$roleStore->getRole($where);
        //返回错误状态信息
        if(!$result) return ['status' => false,'msg' => '没有找到'];
        //返回数据
        return  ['status' => true,'msg' => $result];
    }

    /**
     * 注册用户
     * @param $data
     * @return string
     * @author 刘峻廷
     */
    public function addUser($data)
    {
        // 检验用户是否被注册
        $result = self::$homeStore->getOneData(['email' => $data['email']]);
        // 返回真，用户存在
        if($result) return ['status' => '400','msg' => '用户已存在！'];

        // 进行检验手机号是否唯一
        $result = self::$userStore->getOneData(['tel' => $data['phone']]);
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

        // 存入登录表
        $loginInfo = self::$homeStore -> addData($data);
        // 数据写入失败
        if(!$loginInfo) return ['status' => '400','msg' => '数据写入失败！'];

        // 添加数据成功到登录表，然后在往用户信息表里插入一条
        $userInfo = self::$userStore->addUserInfo(['guid' => $data['guid'],'nickname' => $nickname,'tel' => $phone,'email' =>  $data['email']]);
        if(!$userInfo) return ['status' => '400','msg' => '用户信息添加失败！'];

        return ['status'=>'200','msg'=>'注册成功'];
    }
    /**
     * 用户登录
     * @param array $data
     * @return string
     * @auther 刘峻廷
     */
    public function loginCheck($data)
    {
        // 对密码进行加密
        $pass = Common::cryptString($data['email'],$data['password'],'hero');
        // 查询数据
        $temp = self::$homeStore->getOneData(['email' => $data['email'],'password' => $pass]);
        // 返回假，说明此账号不存在或密码不正确
        if(!$temp) return ['status' => '400','msg' => '账号不存在或密码错误！'];
        // 返回真，再进行账号状态判断
        if($temp->status != '1') ['status' => '400','msg' => '账号存在异常，已锁定，请紧快与客服联系！'];

        // 数据提纯
        unset($temp->password);
        //   客户端请求过来的时间
        $time = $_SERVER['REQUEST_TIME'];

        // 更新数据表，登录和ip
        $info = self::$homeStore->updateData(['guid'=>$temp->guid],['logintime' => $time,'ip' => $data['ip']]);
        if(!$info) return ['status' => '400','msg' => '服务器数据异常！'];

        //获取角色状态
        $temp->role = self::$userStore->getOneData(['guid' => $temp->guid])->role;

        Session::put('user',$temp);
        return ['status' => '200','msg' => '登录成功！'];
    }

    /**
     * 发送短信，时间间隔验证
     * @param $phone
     * @return string
     * @author 刘峻廷
     */
    public function sendSmsCode($phone)
    {
        // 获取当前时间戳
        $nowTime = $_SERVER['REQUEST_TIME'];
        // 判断该号码两分中内是否发过短信
        $sms = Session::get('sms');
        $name = '英雄,';
        $number = mt_rand(100000, 999999);
        $content = ['name'=>$name,'number'=>$number];

        //校验
        if($sms['phone']==$phone){
            // 两分之内，不在发短信
            if(($sms['time'] + 120)> $nowTime ) return ['status' => '400','msg' => '短信已发送，请等待两分钟！'];
            // 两分钟之后，可以再次发送
            $resp = Common::sendSms($phone,$content,'兄弟会','SMS_25700502');

            // 发送失败
            if(!$resp) return ['status' => '400','msg' => '短信发送失败，请重新发送！'];
            // 成功，保存信息到session里，为了下一次校验
            $arr = ['phone' => $phone,'time' => $nowTime,'smsCode' => $number];
            Session::put('sms',$arr);

            return ['status' => '200','msg' => '发送成功，请注意查收！'];
        }else{
            $resp =  Common::sendSms($phone,$content,'兄弟会','SMS_25700502');
            // 发送失败
            if(!$resp) return ['status' => '400','msg' => '短信发送失败，请重新发送！'];
            $arr = ['phone' => $phone,'time' => $nowTime,'smsCode' => $number];
            Session::put('sms',$arr);

            return ['status' => '200','msg' => '发送成功，请注意查收！'];
        }
    }
    /**
     * 获取符合请求的所有用户记录
     * @param $data
     * @return array|bool
     * @author wang fei long
     */
    public function getData($data)
    {
        if (isset($data['name'])) return self::getOneData($data);
        if(!isset($data['role']) || !isset($data['status'])) return ['status' => false, 'data' => '请求参数错误'];
        // 1 普通用户 ；2 创业者 ；3 投资者
        if(!in_array($data['role'], ['1', '2', '3'])) return ['status' => false, 'data' => '请求参数错误'];
        $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;
        $userData = self::$userStore->getUsersData($nowPage, ['role' => $data['role'], 'status' => $data['status']]);

        if ($userData === false) return ['status' => false, 'data' => '缺少分页信息，数据获取失败'];
        if ($userData === []) return ['status' => 'empty', 'data' => '没有查询到数据'];

        $userPage = self::getPage($data, 'user/create');
        if (!$userPage) return ['status' => false, 'data' => '分页获取失败'];
        //拼装数据，返回所需格式
        $result = array_merge(['data'=> $userData], $userPage['data']);
        if (!$result) return ['status' => false, 'data' => '系统错误'];
        return ['status' => true, 'data' => $result];
    }

    /**
     * @param $data
     * @param $url
     * @return array
     * @author wang fei long
     */
    private static function getPage($data, $url)
    {
        $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;

        $count = self::$userStore->getUsersNumber(['role' => $data['role'], 'status' => $data['status']]);
        $totalPage = ceil($count / PAGENUM);
        $baseUrl   = url($url);
        if($nowPage <= 0) $nowPage = 1;
        if($nowPage > $totalPage) $nowPage = $totalPage;

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
    public static function getOneData($data)
    {
//        if(!isset($data['role'])) return ['status' => false, 'data' => '请求参数错误'];
//        if(!in_array($data['role'], ['1', '2', '3'])) return ['status' => false, 'data' => '请求参数错误'];
        $result = self::$userStore->getOneData(['guid' => $data['name']]);
        if (!$result) return ['status' => false, 'data' => '系统错误'];
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
       if (empty($where) || empty($data)) return ['status' => '400','msg' => '缺少数据'];
        // 提交数据给store层
        $info = self::$userStore->updateUserInfo($where,$data);

        if(!$info) return ['status'=> '400','msg' => '修改失败，您并没有做什么修改！'];
        return ['status' => '200','msg' => '修改成功！'];
    }

    /**
     * 头像上传
     * 跟身份证上传要进行整合
     * @param $where
     * @param $data
     * @return array
     * @author 刘峻廷
     */
    public function updataUserInfo2($data)
    {
        // 文件上传,检验条件
        if (empty($data)) return ['status' => '400','msg' => '缺少数据'];
        // 对上传的头像文件进行处理
        $uploadInfo = self::$uploadServer->uploadFile($data->file('headpic'));
        // 检验图上上传成与否
        if($uploadInfo['status'] == '400' || $uploadInfo['status'] == false) return ['status' => '400','msg' => $uploadInfo['msg']];

        //成功后数据进行修改，拿到图片名
        $headpic = $uploadInfo['msg'];
        // 提取数据,获取指定数据
        $guid = $data->all()['guid'];
        // 提交数据给store层
        $info = self::$userStore->updateUserInfo(['guid' => $guid],['headpic' => $headpic]);
        if(!$info) return ['status' => '400','msg' => '修改失败！'];
        return ['status' => '200','msg' => '修改成功！'];
    }


    /**
     * 申请成为创业者
     * @param $data
     * @return array
     * @author 刘峻廷
     */
    public function applyRole($data)
    {
        // 检验数据
        if(empty($data)) return ['status' => '400','msg' => '请填写完整信息！'];
        // 查看该用户是否已申请
        $info= self::$roleStore->getRole(['guid' => $data['guid']]);
        // 查询不为空
        if(!empty($info)) return ['status' => '400','msg' => '已申请'];
        //提交数据
        $result = self::$roleStore->addRole($data);
        // 返回信息处理
        if(!$result) return ['status' => '400','msg' => '申请失败'];

        // 申请成功后，根据新的用户信息对data_user_info表进行一次数据覆盖更新
        $user = [];
        $user['realname'] = $data['realname'];
        $user['birthday'] = $data['birthday'];
        $user['sex'] = $data['sex'];
        $user['hometown'] = $data['hometown'];
        $result = self::$userStore->updateUserInfo(['guid' => $data['guid']],$user);
        
        return ['status' => '200','msg' => '申请成功'];
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
     * 软删除
     * @param $data
     * @param $id
     * @return array
     * @author 王飞龙
     */
    public function deleteUserData($data, $id)
    {
        $result = self::$userStore->updateUserInfo(['guid' => $id], $data);
        if(!$result) return ['status' => 400, 'data' => '删除失败'];
        return ['status' => 200, 'data' => '删除成功'];
    }

    /**
     * 审核成功时修改多个数据表数据
     * @param $data
     * @param $id
     * @return array
     * @author wangfeilong
     */
    public function checkPass($data, $id){
        if (!isset($data['role']) || !isset($data['status'])) return ['status'=>true,'data'=>'请求参数错误！'];
        //使用事务
        $result = DB::transaction(function () use ($data, $id){
            self::$roleStore->updateUserInfo(['guid' => $id], ['status' => $data['status']]);
            self::$userStore->updateUserInfo(['guid' => $id], ['role' => $data['role']]);
        });
        if(!$result) return ['status'=>true,'data'=>'修改成功！'];
        else return ['status'=>false,'data'=>'修改失败，请重试！'];
    }
}