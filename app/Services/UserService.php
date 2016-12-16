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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Tools\CropAvatar as Crop;


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
    public function __construct(HomeStore $homeStore, UserStore $userStore, RoleStore $roleStore, UploadServer $uploadServer)
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
        if(!$result) return ['StatusCode' => '400','ResultData' => '没有找到该用户信息!'];;
        //返回数据
        return ['StatusCode' => '200','ResultData' => $result];
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
     * @modify 王通
     */
    public function addUser($data)
    {
        // 检验用户是否被注册
        $result = self::$homeStore->getOneData(['tel' => $data['tel']]);
        // 返回真，用户存在
        if ($result) return ['status' => '400', 'msg' => '用户已存在！'];

        // 进行检验手机号是否唯一
        $result = self::$userStore->getOneData(['tel' => $data['tel']]);
        // 返回真，用户存在
        if ($result) return ['status' => '400', 'msg' => '用户已存在！'];

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

        // 添加数据成功到登录表，然后在往用户信息表里插入一条
        $userInfo = self::$userStore->addUserInfo(['guid' => $data['guid'], 'tel' => $phone, 'headpic' => 'http://ogd29n56i.bkt.clouddn.com/20161129112051.jpg']);

        if (!$userInfo) {
            Log::error('用户注册信息写入失败', $userInfo);
            DB::rollback();
            return ['status' => '500', 'msg' => '用户信息添加失败，请重新注册!'];
        } else {
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
        // 检验用户是否被注册
        $result = self::$homeStore->getOneData(['tel' => $data['tel']]);
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
    public function loginCheck($data)
    {
        // 对密码进行加密
        $pass = Common::cryptString($data['tel'],$data['password'],'hero');
        // 查询数据
        $temp = self::$homeStore->getOneData(['tel' => $data['tel']]);
        // 返回假，说明此账号不存在
        if(!$temp) return ['status' => '400','msg' => '账号不存在或输入错误！'];
        // 查询数据
        $temp = self::$homeStore->getOneData(['tel' => $data['tel'],'password' => $pass]);
        // 返回假，说明此密码不正确
        if(!$temp) return ['status' => '400','msg' => '密码错误！'];
        // 返回真，再进行账号状态判断
        if($temp->status != '1') ['status' => '400','msg' => '账号存在异常，已锁定，请紧快与客服联系！'];

        // 数据提纯
        unset($temp->password);
        //   客户端请求过来的时间
        $time = $_SERVER['REQUEST_TIME'];

        // 更新数据表，登录和ip
        $info = self::$homeStore->updateData(['guid'=>$temp->guid],['logintime' => $time,'ip' => $data['ip']]);
        if(!$info) return ['status' => '500','msg' => '服务器数据异常！'];

        //将一些用户的信息推到session里，方便维持

        $userInfo = self::$userStore->getOneData(['guid' => $temp->guid]);

        //获取角色状态
        $temp->role = $userInfo->role;
        //获取用户信息头像
        $temp->headpic = $userInfo->headpic;
        //获取用户昵称
        $temp->nickname = $userInfo->nickname;
        //获取用户的Memeber状态
        $temp->memeber = $userInfo->memeber;

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
        $content = ['name' => $name,'number' => $number];

        //校验
        if($sms['phone']==$phone){
            // 两分之内，不在发短信
            if(($sms['time'] + 60)> $nowTime ) return ['StatusCode' => '400','ResultData' => '短信已发送，请等待两分钟！'];
            // 两分钟之后，可以再次发送
            $resp = Common::sendSms($phone,$content,'兄弟会','SMS_25700502');

            // 发送失败
            if(!$resp) return ['StatusCode' => '400','ResultData' => '短信发送失败，请重新发送！'];
            // 成功，保存信息到session里，为了下一次校验
            $arr = ['phone' => $phone,'time' => $nowTime,'smsCode' => $number];
            Session::put('sms',$arr);

            return ['StatusCode' => '200','ResultData' => '发送成功，请注意查收！'];
        }else{
            $resp =  Common::sendSms($phone, $content, '兄弟会', 'SMS_25700502');

            // 发送失败
            if(!$resp) return ['StatusCode' => '400','ResultData' => '短信发送失败，请重新发送！'];
            $arr = ['phone' => $phone,'time' => $nowTime,'smsCode' => $number];
            Session::put('sms',$arr);

            return ['StatusCode' => '200','ResultData' => '发送成功，请注意查收！'];
        }
    }

    /**
     * 获取符合请求的所有用户记录
     * @param $data
     * @return array|bool
     * @author 王飞龙
     */
    public function getData($data)
    {
        if (isset($data['memeber'])) {

            if (!isset($data['status'])) return ['status' => false, 'data' => '请求参数错误'];

            if (!in_array($data['memeber'], ['1', '2', '3', '4', '5', '6'])) return ['status' => false, 'data' => '请求参数错误'];

            // 当前页
            $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;

            //获取数据

            $userData = self::$userStore->getUsersData($nowPage, ['memeber' => $data['memeber']]);
            
        } else {
            //data中若有key为name的数据，则调用getOneData()
            if (isset($data['name']))
                return self::getOneData($data);

            //进一步判断data中的数据
            if(!isset($data['role']) || !isset($data['status']))
                return ['status' => false, 'data' => '请求参数错误'];

            // 1 普通用户 ；2 创业者 ；3 投资者
            if(!in_array($data['role'], ['1', '2', '3', '4']))
                return ['status' => false, 'data' => '请求参数错误'];

            $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;

            //获取数据
            $userData = self::$userStore->getUsersData($nowPage, ['role' => $data['role'], 'status' => $data['status']]);
        }

        
        //对获取的数据做判断
        if ($userData === false)
            return ['status' => false, 'data' => '缺少分页信息，数据获取失败'];
        if ($userData === [])
            return ['status' => 'empty', 'data' => '没有查询到数据'];

        //获取分页
        $userPage = self::getPage($data, 'user/create');

        //判断分页获取情况
        if (!$userPage)
            return ['status' => false, 'data' => '分页获取失败'];

        //拼装数据，返回所需格式
        $result = array_merge(['data'=> $userData], $userPage['data']);

        //判断
        if (!$result)
            return ['status' => false, 'data' => '系统错误'];

        //正确数据
        return ['status' => true, 'data' => $result];
    }

    /**
     * 获取分页
     * @param $data
     * @param $url
     * @return array
     * @author 王飞龙
     */
    private static function getPage($data, $url)
    {

        $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;

        if (isset($data['memeber'])) {
            $count = self::$userStore->getUsersNumber(['memeber' => $data['memeber'], 'status' => $data['status']]);
        } else {
            $count = self::$userStore
                ->getUsersNumber(['role' => $data['role'], 'status' => $data['status']]);
        }

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
                'pages'   => CustomPage::getSelfPageView($nowPage, $totalPage, $baseUrl, null)
            ]
        ];
    }

    /**
     * 获取一条用户信息
     * @param $data
     * @return array
     * @Author wang fei long
     */
    public static function getOneData($data)
    {
        $result = self::$userStore->getOneData(['guid' => $data['name']]);

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
       if (empty($where) || empty($data)) return response()->json(['StatusCode' => '400','ResultData' => '缺少数据']);
        // 提交数据给store层
        $info = self::$userStore->updateUserInfo($where,$data);

        if(!$info) return response()->json(['StatusCode' => '400','ResultData' => '修改失败，您并没有做什么修改！']);

        return response()->json(['StatusCode' => '200','ResultData' => '更新成功!']);
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

        //成功后再进行数据重组，转存到session中
        $temp = self::$homeStore->getOneData(['guid' => $guid]);
        $userInfo = self::$userStore->getOneData(['guid' => $guid]);
        //获取角色状态
        $temp->role = $userInfo->role;
        //获取用户信息头像
        $temp->headpic = $userInfo->headpic;

        Session::put('user',$temp);

        return ['StatusCode' => '200','ResultData' => $avatarName];

    }


    /**
     * 申请成为创业者 或 投资者
     * @param $data
     * @return array
     * @author 刘峻廷
     */
    public function applyRole($data)
    {
        // 校验当前用户的角色
        $userInfo = self::$userStore->getOneData(['guid' => $data['guid']]);

        if ($data['role'] == 4) {
            if ($userInfo->memeber == 4)  return ['StatusCode' => '400', 'ResultData' => '您已是英雄会成员！'];
            // 查看该用户是否已申请
            $info= self::$roleStore->getRole(['guid' => $data['guid'], 'role' => '4']);

        } else {
            if ($userInfo->role == 2) {
                return ['StatusCode' => '400', 'ResultData' => '您已是创业者！'];
            } else if ($userInfo->role == 3) {
                return ['StatusCode' => '400', 'ResultData' => '您已是投资者！'];
            }
            // 查看该用户是否已申请
            $info= self::$roleStore->getRole(['guid' => $data['guid']]);
        }


        // 查询不为空
        if(!empty($info)) {
            // 判断审批状态
            if ($info->status == '1') {
                return ['StatusCode' => '400', 'ResultData' => '您已有申请项，正在审核中，请耐心等待...'];
            } else if ($info->status == '2') {
                return ['StatusCode' => '400', 'ResultData' => '已申请成功，无需再次申请。'];
            }
        };

        // 事务处理
        DB::beginTransaction();
        try {
            if ($data['role'] == 4) {
                $data['realname'] = $userInfo->realname;
                $data['tel'] = $userInfo->tel;
            }
            $result = self::$roleStore->addRole($data);

            // 返回信息处理
            if(!$result) {
                Log::error('申请角色失败', $result);
                return ['StatusCode' => '400', 'ResultData' => '申请失败，请重新申请...'];
            };
            // 申请成功后，根据新的用户信息对data_user_info表进行一次数据覆盖更新
            $user = [];
            // 申请会员的
            $user['realname'] = $data['realname'];
            $user['tel'] = $data['tel'];


            self::$userStore->updateUserInfo(['guid' => $data['guid']], $user);

            DB::commit();
            return ['StatusCode' => '200', 'ResultData' => '申请成功，等待审核...'];
        } catch (Exception $e) {
            DB::rollback();
            return ['StatusCode' => '400', 'ResultData' => '申请失败，请重新申请...'];
        }
    }

    /**
     * 审核成功时修改多个数据表数据
     * @param $data
     * @param $id
     * @return array
     * @author 王飞龙
     */
    public function checkPass($data, $id){

        //判断请求合法性
        if (!isset($data['role']) || !isset($data['status']))
            return ['status'=>true,'data'=>'请求参数错误！'];
        //使用事务
        $result = DB::transaction(function () use ($data, $id){
            self::$roleStore->updateUserInfo(['guid' => $id], ['status' => $data['status']]);
            self::$userStore->updateUserInfo(['guid' => $id], ['role' => $data['role']]);
        });

        if(!$result)
            return ['status'=>true,'data'=>'修改成功！'];
        else
            return ['status'=>false,'data'=>'修改失败，请重试！'];
    }

    /**
     * 更改邮箱绑定
     * @param $data
     * @param $guid
     * @return array
     * @author 刘峻廷
     */
    public function changeEmail($data,$guid)
    {
        // 检验数据
        if (!is_array($data) || empty($guid)) return ['status' => '400','msg' => '缺少数据！'];

       // 输入信息和数据进行比对
        $result = self::$userStore->getOneData(['guid' => $guid, 'email' => $data['email']]);

        if (!$result) ['status'=> '400', 'msg' => '原始邮箱错误，请重新输入。'];

        // 再次进行新邮箱和原始邮箱是否一样
        if ($result->email == $data['newEmail']) return ['status'=> '400', 'msg' => '原始邮箱与新邮箱相同，请更换一个。'];

        // 再次进行 新邮箱是否存在数据表中
        $result = self::$userStore->getOneData(['email' => $data['newEmail']]);
        if ($result) return ['status' => '400', 'msg' => '您输入的新邮箱已存在，请更换一个!'];

        // 确认密码是否正确,先对密码加密
        $result = self::$homeStore->getOneData(['guid' => $guid]);
        $pass = Common::cryptString($result->email, $data['password'], 'hero');

        if ($result->password != $pass) return ['status' => '400', 'msg' => '账号密码错误!'];

        // 进行更新邮箱
        $result = self::$userStore->updateUserInfo(['guid' => $guid], ['email' => $data['newEmail']]);

        if (!$result) {
            Log::error('更换邮箱错误',$result);
            return ['status' => '400', 'msg' => '数据更新失败!'];
        } else {
            return ['status' => '200', 'msg' => '更改邮箱绑定成功!'];
        }

    }

    /**
     * 更改手机号绑定
     * @param $data
     * @param $guid
     * @return array
     * @author 刘峻廷
     */
    public function changeTel($data,$guid)
    {
        // 检验数据
        if (!is_array($data) || empty($guid)) return ['status' => '400','msg' => '缺少数据！'];
     
        // 输入信息和数据进行比对
        $result = self::$userStore->getOneData(['guid' => $guid, 'tel' => $data['tel']]);

        if (!$result) return ['status'=> '400', 'msg' => '原始手机号错误，请重新输入。'];

        // 再次进行新邮箱和原始邮箱是否一样
        if ($result->tel == $data['newTel']) return ['status'=> '400', 'msg' => '原始手机号与新手机号相同，请更换一个。'];

        // 再次进行 新邮箱是否存在数据表中
        $result = self::$userStore->getOneData(['tel' => $data['newTel']]);
        if ($result) return ['status' => '400', 'msg' => '您输入的新手机号已存在，请更换一个!'];

        // 确认密码是否正确,先对密码加密
        $result = self::$homeStore->getOneData(['guid' => $guid]);
        $pass = Common::cryptString($result->email, $data['password'], 'hero');

        if ($result->password != $pass) return ['status' => '400', 'msg' => '账号密码错误!'];

        // 进行更新邮箱
        $result = self::$userStore->updateUserInfo(['guid' => $guid], ['tel' => $data['newTel']]);

        if (!$result) {
            Log::error('更换手机号错误',$result);
            return ['status' => '400', 'msg' => '数据更新失败!'];
        } else {
            return ['status' => '200', 'msg' => '更改手机号绑定成功!'];
        }

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
}