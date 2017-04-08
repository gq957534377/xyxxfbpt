<?php

namespace App\Http\Controllers\Home;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserService as UserServer;
use App\Tools\Common;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Services\SafetyService;


class LoginController extends Controller
{
    protected static $userServer = null;
    protected static $safetyService;

    public function __construct(UserServer $userServer, SafetyService $safetyService)
    {
        self::$userServer = $userServer;
        self::$safetyService = $safetyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @modify 杨志宇
     */
    public function index()
    {
        if (!empty(session('user'))) return redirect('/');
        $cookie = Common::generateCookie('login');
        // 获取登录错误次数 判断是否要显示验证码

        $errNum = self::$safetyService->getString(Input::getClientIp());
        if (empty($errNum) || $errNum < LOGIN_ERROR_NUM) {
            $k = false;
        } else {
            $k = true;
            $val = md5(session()->getId());
            return response()->view('home.login', ['errCheck' => $k, 'sesid' => $val])->withCookie($cookie);
        }
        return response()->view('home.login', ['errCheck' => $k])->withCookie($cookie);
    }

    /**
     * 修改密码界面
     *
     * @return \Illuminate\Http\Response
     * @author 杨志宇
     */
    public function create()
    {
        if (!empty(session('user'))) return redirect('/');
        $cookie = Common::generateCookie('changePasswd');
        $checkCode = Common::generateCookie('checkCode');
        return response()->view('home.changePasswd')->withCookie($cookie)->withCookie($checkCode);
    }

    /**
     * 登录校验
     *
     * @param  \Illuminate\Http\Request $request
     * @author 郭庆
     * @modify 杨志宇
     */
    public function store(Request $request)
    {
        // 登陆安全验证
        $result = Common::checkCookie('login', '登陆');
        if (!$result) return $result;
        $data = $request->all();
        $fild = filter_var($data['phone_number'], FILTER_VALIDATE_INT) ? 'phone_number' : 'username';

        // 获取登录IP
        $data['ip'] = $request->getClientIp();
        // 获取登录错误次数
        $errNum = self::$safetyService->getString($data['ip']);
        // 判断登录次数如果超过限定的话，
        if ($errNum > LOGIN_ERROR_NUM) {
            if (session('code') != $data['code']) {
                return response()->json(['StatusCode' => '400', 'ResultData' => '请输入正确验证码']);
            }
        };
        //验证数据
        $this->validate($request, [
            'phone_number' => 'required',
            'password' => 'required',
        ], [
            'phone_number.required' => '手机号/用户名不能为空',
            'password.required' => '密码不能为空'
        ]);

        // 校验账号,拿到状态码
        $info = self::$userServer->loginCheck(['password' => $data['password'], $fild => $data['phone_number'], 'ip' => $data['ip']]);
        // 每登录错误一次，切验证码为空，则错误次数加一。
        if ($info['StatusCode'] != '200' && empty($data['code'])) {
            // 如果错误次数超过三次，则返回错误信息，前台显示验证码输入框
            if (self::$safetyService->getCountIp($data['ip']) > LOGIN_ERROR_NUM) {
                return response()->json(['StatusCode' => '411', 'ResultData' => '请输入验证码']);
            };
        }
        return response()->json($info);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
     * 忘记密码，修改密码
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @author 杨志宇
     */
    public function update(Request $request, $id)
    {
        // 登陆安全验证
        $result = Common::checkCookie('changePasswd', '修改密码');
        if ($result != 'ok') return $result;
        $data = $request->all();
//        dd(session('sms'), $data);
        $sms = session('sms');
        if ($data['code'] != $sms['smsCode']) {
            return response()->json(['StatusCode' => '400', 'ResultData' => ['验证码错误!']]);
        } elseif ($data['phone_number'] != $sms['phone']) {
            return response()->json(['StatusCode' => '400', 'ResultData' => ['请输入正确手机号!']]);
        } elseif ($data['password'] != $data['confirm_password']) {
            return response()->json(['StatusCode' => '400', 'ResultData' => ['两次密码不相同!']]);
        }
        $result = self::$userServer->talChangePassword($data);
        return response()->json($result);
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

    /**
     * 获取图片验证码
     * @param $tmp
     * @return \Gregwar\Captcha\PhraseBuilder|null|string
     * @author 郭庆
     */
    public function captcha()
    {
        $result = Common::checkCookie('checkCode', '验证码');
        if ($result != 'ok') {
            return Common::captchaStatus();
        }
        return Common::captcha();
    }

    /**
     * 登出
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author 郭庆
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
     * @author 杨志宇
     */
    public function sendSms(Request $request, $id)
    {
        // 判断存在
        if (empty($id)) return false;
        if ($request['piccode'] != session('code')) {
            return response()->json(['StatusCode' => '400', 'ResultData' => '验证码错误！']);
        }
        // 手机号校验
        $preg = '/^(1(([3578][0-9])|(47)|[8][0126789]))\d{8}$/';
        if (!preg_match($preg, $id)) return response()->json(['StatusCode' => '400', 'ResultData' => '请输入正确的手机号！']);
        // 查询该手机是否已注册
        $info = self::$userServer->checkUser(['phone_number' => $id]);

        if (empty($info->status)) return response()->json(['StatusCode' => '400', 'ResultData' => '该手机号暂未注册，请输入正确手机号！']);
        if ($info->status != 1) return response()->json(['StatusCode' => '400', 'ResultData' => '该手机号异常，请联系管理员！']);

        // 真，发送短信
        $info = self::$userServer->sendSmsCode($id);

        return response()->json($info);

    }
}
