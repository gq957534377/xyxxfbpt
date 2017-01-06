<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\UserService as UserServer;
use App\Tools\Common;
use App\Tools\Safety;

class LoginController extends Controller
{
    protected static $userServer = null;

    public function __construct(UserServer $userServer)
    {
        self::$userServer = $userServer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @modify 王通
     */
    public function index()
    {
        if (!empty(session('user'))) return redirect('/');
        $cookie = Common::generateCookie('login');
        return response()->view('home.login')->withCookie($cookie);
    }

    /**
     * 修改密码界面
     *
     * @return \Illuminate\Http\Response
     * @author 王通
     */
    public function create()
    {
        if (!empty(session('user'))) return redirect('/');
        $cookie = Common::generateCookie('changePasswd');
        return response()->view('home.changePasswd')->withCookie($cookie);
    }

    /**
     * 登录校验
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author 刘峻廷
     * @modify 王通
     */
    public function store(Request $request)
    {
        // 登陆安全验证
        $result = Common::checkCookie('login', '登陆');
        if ($result != 'ok') return $result;

        $data = $request->all();

        //验证数据
        $this->validate($request,[
            'tel' =>  'required',
            'password' => 'required|min:6',
        ]);

        // 获取登录IP
        $data['ip'] = $request->getClientIp();
        // 校验邮箱和账号,拿到状态码
        $info = self::$userServer->loginCheck($data);
        return response()->json($info);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 忘记密码，修改密码
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 王通
     */
    public function update(Request $request, $id)
    {
        // 登陆安全验证
        $result = Common::checkCookie('changePasswd', '登陆');
        if ($result != 'ok') return $result;
        $data = $request->all();
//        dd(session('sms'), $data);
        $sms = session('sms');
        if ($data['code'] != $sms['smsCode']) {
            return response()->json(['StatusCode' => '400','ResultData' => ['验证码错误!']]);
        } elseif ($data['tel'] != $sms['phone']) {
            return response()->json(['StatusCode' => '400','ResultData' => ['请输入正确手机号!']]);
        } elseif ($data['password'] != $data['confirm_password']) {
            return response()->json(['StatusCode' => '400','ResultData' => ['两次密码不相同!']]);
        }
        $result = self::$userServer->talChangePassword($data);
        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 获取图片验证码
     * @param $tmp
     * @return \Gregwar\Captcha\PhraseBuilder|null|string
     * @author 刘峻廷
     */
    public function captcha($tmp, Request $request)
    {
        $result = Common::checkCookie('checkCode', '登陆');
        if ($result != 'ok') return $result;
        return Common::captcha($tmp);
    }

    /**
     * 登出
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author 刘峻廷
     */
    public function logout()
    {
        Session::forget('user');
        return redirect('/');
    }

    /**
     * 发送短信验证码短信
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @author 王通
     */
    public function sendSms(Request $request, $id)
    {

        // 判断存在
        if (empty($id)) return false;
        if ($request['piccode'] != session('code')) {
            return response()->json(['StatusCode'=>'400','ResultData' =>'验证码错误！']);
        }
        // 手机号校验
        $preg = '/^(1(([3578][0-9])|(47)|[8][0126789]))\d{8}$/';
        if(!preg_match($preg, $id)) return response()->json(['StatusCode'=>'400','ResultData' =>'请输入正确的手机号！']);
        // 查询该手机是否已注册
        $info = self::$userServer->checkUser(['tel' => $id]);

        if(empty($info->status)) return response()->json(['StatusCode'=>'400','ResultData' => '该手机号暂未注册，请输入正确手机号！']);
        if($info->status != 1) return response()->json(['StatusCode'=>'400','ResultData' => '该手机号异常，请联系管理员！']);

        // 真，发送短信
        $info = self::$userServer->sendSmsCode($id);

        return response()->json($info);

    }
}
