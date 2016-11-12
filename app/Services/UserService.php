<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Store\HomeStore;
use App\Store\UserStore;
use App\Store\RoleStore;
use App\Tools\Common;
use App\Tools\CustomPage;
use Illuminate\Support\Facades\Session;

class UserService {
    protected static $homeStore = null;
    protected static $userStore = null;
    protected static $roleStore = null;

    /**
     * UserService constructor.
     * @param HomeStore $homeStore
     * @param UserStore $userStore
     * @param RoleStore $roleStore
     */
    public function __construct(HomeStore $homeStore ,UserStore $userStore,  RoleStore $roleStore)
    {
        self::$homeStore = $homeStore;
        self::$userStore = $userStore;
        self::$roleStore = $roleStore;
    }

    /**
     * 获取用户信息
     * @param $where
     * @return array
     * @author 刘峻廷
     */
    public function userInfo($where)
    {
        $result = self::$userStore->getOneData(['guid'=>$where]);
        //返回错误状态信息
        if(!$result) return ['status'=>false,'msg'=>'没有找到'];
        //返回数据
        return  ['status'=>true,'msg'=>$result];
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
        $result = self::$homeStore->getOneData(['email'=>$data['email']]);
        // 返回真，用户存在
        if($result) return 'exist';
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
        if(!$loginInfo) return 'error';
        // 添加成功
        $userInfo = self::$userStore->addUserInfo(['guid'=>$data['guid'],'nickname'=>$nickname,'tel'=>$phone,'email'=> $data['email']]);
        $userInfo = self::$userStore->addUserInfo(['guid'=>$data['guid'],'nickname'=>$nickname,'tel'=>$phone]);
        return 'yes';
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
        $temp = self::$homeStore->getOneData(['email'=>$data['email'],'password'=>$pass]);
        // 返回假，说明此账号不存在或密码不正确
        if(!$temp) return 'error';
        // 返回真，再进行账号状态判断
        if($temp->status != '1') return 'status';
        // 数据提纯
        unset($temp->password);
        //   客户端请求过来的时间
        $time = $_SERVER['REQUEST_TIME'];
        // 更新数据表，登录和ip
        $info = self::$homeStore->updateData(['guid'=>$temp->guid],['logintime'=>$time,'ip'=>$data['ip']]);
        if(!$info) return 'noUpdate';
        Session::put('user',$temp);
        return 'yes';
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
        $nowTime = time();
        // 判断该号码两分中内是否发过短信
        $sms = Session::get('sms');
        $name = '英雄,';
        $number = rand(100000, 999999);
        $content = ['name'=>$name,'number'=>$number];
        if($sms['phone']==$phone){
            // 两分之内，不在发短信
            if(($sms['time'] + 120)> $nowTime ) return 'false';
            // 两分钟之后，可以再次发送
            $resp = Common::sendSms($phone,$content,'兄弟会','SMS_25700502');
            // 发送失败
            if(!$resp) return 'error';
            $arr = ['phone'=>$phone,'time'=>$nowTime,'smsCode'=>$number];
            Session::put('sms',$arr);
            return 'yes';
        }else{
            $resp =  Common::sendSms($phone,$content,'兄弟会','SMS_25700502');
            // 发送失败
            if(!$resp) return 'error';
            $arr = ['phone'=>$phone,'time'=>$nowTime,'smsCode'=>$number];
            Session::put('sms',$arr);
            return 'yes';
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
        if(!isset($data['role'])) return ['status' => false, 'data' => '请求参数错误'];
        if(!in_array($data['role'], ['0', '1', '2'])) return ['status' => false, 'data' => '请求参数错误'];
        $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;
        $userPage = self::getPage($data);
        // 转向RoleStore层
        if ($data['role'] == '0'){
            $userData = self::$roleStore->getUsersData($nowPage, ['status' => '1']);
            //拼装数据,返回所需格式
            $result = array_merge(['data'=> $userData], $userPage['data']);
            if (!$result) return ['status' => false, 'data' => '系统错误'];
            return ['status' => true, 'data' => $result];
        }
        $userData = self::$userStore->getUsersData($nowPage, ['role' => $data['role']]);
        //拼装数据，返回所需格式
        $result = array_merge(['data'=> $userData], $userPage['data']);
        if (!$result) return ['status' => false, 'data' => '系统错误'];
        return ['status' => true, 'data' => $result];
    }

    /**
     * 获取分页
     * @param $data
     * @return array|bool
     * @author wang fei long
     */
    private static function getPage($data)
    {
        if(!isset($data['role'])) return ['status' => false, 'data' => '请求参数错误'];
        if(!in_array($data['role'], ['0', '1', '2'])) return ['status' => false, 'data' => '请求参数错误'];
        $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;
        $count = self::$roleStore->getUsersNumber();
        $totalPage = ceil($count / PAGENUM);
        $baseUrl   = url('users_page');
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
    public function updataUserInfo($data)
    {

    }
}