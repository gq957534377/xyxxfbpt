<?php

namespace App\Http\Controllers\Home;

use App\Services\UserService as UserServer;
use App\Tools\Common;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


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
     * @return 返回视图
     * @author 刘峻廷
     */
    public function index()
    {
        return view('home.register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * 注册新用户
     * @param Request $request
     * @return string
     * @author 刘峻廷
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // 校验两次密码
        if ($data['password'] != $data['confirm_password']) return json_encode(['msg' => '两次密码不一致']);
        // 校验短信验证码
        if($data['code']!= Session::get('sms')['smsCode']) return json_encode(['msg' => '短信验证码错误']);
        // 对数据再次校验
        $this->validate($request, [
            'email' => 'required|email',
            'nickname' => 'required|min:2',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6',
            'phone'=> 'required|min:11|max:11',
            'code'=> 'required'
        ]);
        // 获取客户端IP
        $data['ip'] = $request->getClientIp();
        // 提交数据到业务层，检验用户是否存在
        $info = self::$userServer->addUser($data);
        //返回视图成状态码
        switch ($info) {
            case 'exist':
                return json_encode(['msg' => '用户已存在！']);
                break;
            case 'error':
                return json_encode(['msg' => '数据异常！']);
                break;
            case 'yes':
                return json_encode(['msg' => '注册成功！']);
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    public function sendSms(Request $request)
    {
        $data = $request->all();
        $phone = $data['phone'];
        // 判断存在
        if (empty($phone)) return false;
        // 手机号校验
        $preg = '/^(1(([35][0-9])|(47)|[8][0126789]))\d{8}$/';
        if(!preg_match($preg,$phone)) return json_encode(['msg'=>'请输入正确的手机号！']);
        // 真，发送短信
        $info = self::$userServer->sendSmsCode($phone);

        switch ($info){
            case 'false':
                return json_encode(['msg'=>'短信已发送，请等待两分钟！']);
                break;
            case 'error':
                return json_encode(['msg'=>'发送失败！']);
                break;
            case 'yes':
                return json_encode(['msg'=>'发送成功！']);
                break;
        }
    }

}
