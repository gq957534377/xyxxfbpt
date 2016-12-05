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

class UserRoleService {
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
     * 头像上传
     * 跟身份证上传要进行整合
     * @param $where
     * @param $data
     * @return array
     * @author 刘峻廷
     */
    public function updataUserInfo2($data)
    {
        // 检验条件
        if (empty($data)) return ['status'=>400,'msg'=>'缺少数据'];
        // 对上传的头像文件进行处理
        $uploadInfo = self::$uploadServer->uploadFile($data->file('headpic'));
        // 检验图上上传成与否
        if($uploadInfo['status']=='400' || $uploadInfo['status'] == false) return ['status'=>'400','msg'=>$uploadInfo['msg']];
        //拿到图片名
        $headpic = $uploadInfo['msg'];
        // 提取数据,获取指定数据
        $guid = $data->all()['guid'];
        // 提交数据给store层
        $info = self::$userStore->updateUserInfo(['guid'=>$guid],['headpic'=>$headpic]);
        if(!$info) return ['status'=>400,'msg'=>'修改失败！'];
        return ['status'=>200,'msg'=>'修改成功！','data'=>$headpic];
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
        if(empty($data)) return ['status'=>'400','msg'=>'请填写完整信息！'];
        // 查看该用户是否已申请
        $info= self::$roleStore->getRole(['guid'=>$data['guid']]);
        if(!empty($info)) return ['status'=>'404','msg'=>'已申请'];
        //提纯数据
        unset($data['_method']);
        unset($data['email']);
        //提交数据
        $result = self::$roleStore->addRole($data);
        // 返回信息处理
        if(!$result) return ['status'=>'400','msg'=>'申请失败'];
        return ['status'=>'400','msg'=>'申请成功'];
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

}