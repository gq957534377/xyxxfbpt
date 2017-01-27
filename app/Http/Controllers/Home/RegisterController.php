<?php

namespace App\Http\Controllers\Home;

use App\Services\UserService as UserServer;
use App\Tools\Common;
use App\Tools\Safety;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Redis\BaseRedis;


class RegisterController extends Controller
{
    protected static $userServer = null;

    /**
     * 构造函数依赖注入
     * RegisterController constructor.
     * @param UserServer $userServer
     */
    public function __construct(UserServer $userServer)
    {
        self::$userServer = $userServer;
    }

    /**
     * @author 刘峻廷
     * @modify 王通
     */
    public function index()
    {
        if (!empty(session('user'))) return redirect('/');
        $cookie = \App\Tools\Common::generateCookie('checkCode');

        $val = md5(session()->getId());
        return response()->view('home.register', ['sesid' => $val])->withCookie($cookie);
    }

    /**
     * 检查验证码是否正确
     * @param
     * @return
     * @author 郭庆
     */
    public function create(Request $request)
    {
        $code = $request->get('code');
        if ($code == Session::get('code')) return response()->json(['StatusCode' => '200', 'ResultData' => '验证码正确']);;
        return response()->json(['StatusCode' => '400', 'ResultData' => '验证码错误']);
    }


    /**
     * 注册新用户
     * @param Request $request
     * @return string
     * @author 刘峻廷
     * @modify 王通
     */
    public function store(Request $request)
    {
        // 登陆安全验证
        $result = \App\Tools\Common::checkCookie('checkCode', '登陆');
        if ($result != 'ok') return $result;
        $data = $request->all();

        $validate = [
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6',
        ];
        $valiinfo = [
            'password.required' => '请填写密码',
            'confirm_password.required' => '请填写确认密码',
            'password.min' => '密码过短，不能小于６位',
            'confirm_password.min' => '确认密码密码过短，不能小于６位',
        ];


        // 验证过滤数据
        $validator = Validator::make($data, $validate, $valiinfo);

        if ($validator->fails()) return response()->json(['StatusCode' => '400', 'ResultData' => $validator->errors()->all()]);
        // 验证手机验证码
        if ($data['phone_code'] != session('sms')['smsCode']) return response()->json(['StatusCode' => '400', 'ResultData' => '手机验证码错误']);
        $data['ip'] = $request->getClientIp();
        session(['phone_number' => $data['phone_number']]);
        unset($data['_token']);
        unset($data['confirm_password']);
        unset($data['code']);
        unset($data['phone_code']);
        // 提交数据到业务层，检验用户是否存在
        $info = self::$userServer->addUser($data);
        //注册成功，提供登陆所需要的数据
        if ($info['StatusCode'] == '200'){
            // 获取登录IP
            $data['ip'] = $request->getClientIp();
        }
        return response()->json($info);
    }

    /**
     * 发送短信验证码短信
     * @param  int $id
     * @author 郭庆
     */
    public function show($id)
    {
        // 判断存在
        if (empty($id)) return response()->json(['StatusCode' => '400', 'ResultData' => '操作有误，请重新操作']);
        // 手机号校验
        $preg = '/^(1(([3578][0-9])|(47)|[8][0126789]))\d{8}$/';
        if (!preg_match($preg, $id)) return response()->json(['StatusCode' => '400', 'ResultData' => '请输入正确的手机号！']);
        // 查询该手机是否已注册
        $info = self::$userServer->userInfo(['phone_number' => $id]);

        if ($info['StatusCode'] == '200') return response()->json(['StatusCode' => '400', 'ResultData' => '此手机号已被注册！']);

        // 真，发送短信
        $info = self::$userServer->sendSmsCode($id);

        return response()->json($info);

    }

    /**
     * 判断用户是否存在
     * @param
     * @return array
     * @author 郭庆
     */
    public function edit($name)
    {
        $info = self::$userServer->userInfo(['username' => $name]);

        if ($info['StatusCode'] == '200') return response()->json(['StatusCode' => '400', 'ResultData' => '用户名已被占用！']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
