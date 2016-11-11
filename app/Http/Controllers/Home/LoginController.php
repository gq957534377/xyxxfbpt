<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\UserService as UserServer;
use App\Tools\Common;
use Illuminate\Support\Facades\Session;

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
     */
    public function index()
    {
        return view('home.login');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // 先校验验证码
        if($data['homeCaptcha'] != Session::get('homeCode'))
        {
            return back()->withErrors('验证码错误！');
        }
        //验证数据
        $this->validate($request,[
            'email' =>  'required|email',
            'password' => 'required|min:6',
        ]);
        // 获取登录IP
        $data['ip'] = $request->getClientIp();
        // 校验邮箱和账号,拿到状态码
        $info = self::$userServer->loginCheck($data);
        switch ($info){
            case 'error':
                return json_encode(['msg' => '账号不存在或密码错误！']);
                break;
            case 'status':
                return json_encode(['msg' => '账号存在异常，已被锁定，请联系客服！']);
                break;
            case 'noUpdate':
                return json_encode(['msg' => '服务器数据异常！']);
                break;
            case 'yes':
                return json_encode(['msg' => 'yes']);
                break;
        }
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
    public function captcha($tmp)
    {
        return Common::captcha($tmp,2);
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/');
    }
}
