<?php
/**
 * Admin 后台业务服务层
 * User: Twitch
 * Date: 2016/11/4
 * Time: 10:01
 */
namespace App\Services;

use App\Store\AdminStore;
use App\Tools\Common;
use Illuminate\Support\Facades\Session;

class AdminService {
    protected static $adminStore = null;

    public function __construct(AdminStore $adminStore)
    {
        self::$adminStore = $adminStore;
    }

    /**
     * 用户注册
     * @param array $data
     * @return string
     * @auther 刘峻廷
     */
    public static function addUser($data)
    {
        //查询用户是否被注册
        $result = self::$adminStore->getOneData(['email'=>$data['email']]);
        //真，返回存在
        if ($result) return 'exist';
        // 添加用户数据，先对数据提纯
        unset($data['_token']);
        unset($data['confirm_password']);
        unset($data['username']);
        $data['password'] = Common::cryptString($data['email'],$data['password']);
        $data['guid'] = Common::getUuid();
        $data['addtime'] = $_SERVER['REQUEST_TIME'];
        //存入
        $info = self::$adminStore->addData($data);
        // 数据写入失败
        if(!$info) return 'error';
        // 添加成功
        return 'yes';
    }
    /**
     * 登录验证并更新登录时间和IP
     * @param $data
     * @return string
     * @auther 刘峻廷
     */
    public function loginCheck($data){
        //先进行密码加密
        $pass = Common::cryptString($data['email'],$data['password']);
        //检验用户
        $temp =self::$adminStore->getOneData(['email'=> $data['email'],'password'=> $pass]);
        // 查询不到，返回 error
        if(!$temp) return 'error';
        // 查询到数据，再进行状态判断
        if($temp->status != '1') return 'status';
        //验证成功后，更新此次登录时间和IP，密码不刷新
        unset($temp->password);
        // 获取客户端发起请求的时间
        $time = $_SERVER['REQUEST_TIME'];
        $info = self::$adminStore->updateData(['guid'=>$temp->guid],['ip'=>$data['ip'],'loginTime'=>$time]);
        //验证更新
        if(!$info) return 'noUpdate';
        Session::put('manager',$temp);
        return 'yes';
    }
}