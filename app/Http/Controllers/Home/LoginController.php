<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\UserService as UserServer;
use App\Tools\Common;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Tools\Safety;
use Illuminate\Support\Facades\Cookie;

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
        $cookie = \App\Tools\Common::generateCookie('login');
        return response()->view('home.login')->withCookie($cookie);
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
        $result = \App\Tools\Common::checkCookie('login', '登陆');
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
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

//        $res5 = Safety::checkSqlNum($request->getClientIp(), 1111, 1111);
//
//        // 短信验证码次数验证
//        $res5 = Safety::checkIpSMSCode($request->getClientIp(), 1111);
////        dd($res5);
//        // 检查IP有没有被加入黑名单
//        $res1 = Safety::checkIpBlackList($request->getClientIp());
//        // 防止快速刷新
//        $res4 = Safety::preventFastRefresh($request->getClientIp());
//        // 通过IP请求数量验证
//        $res2 = Safety::number($request->getClientIp(), 100, '图片验证码接口');
//        // 请求数量，以及通过sessionID验证
//        $res3 = Safety::session_number($tmp);
//
//        if ($res3) {
//            return view('welcome');
//        }
        $result = \App\Tools\Common::checkCookie('checkCode', '登陆');
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
        \Session::forget('roleInfo');

        return redirect('/');
    }
}
