<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\UserService as UserServer;
use App\Tools\Common;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
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
     * 登录校验
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author 刘峻廷
     * @modify 王通
     */
    public function store(Request $request)
    {
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

        switch ($info['status']){
            case '400':
                return response()->json(['StatusCode' => '400','ResultData' => $info['msg']]);
                break;
            case '500':
                Log::error($info['msg'],$data);
                return response()->json(['StatusCode' => '500','ResultData' => $info['msg']]);
                break;
            case '200':
                return response()->json(['StatusCode' => '200','ResultData' => $info['msg']]);
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
    public function captcha($tmp, Request $request)
    {

        $res4 = Safety::PreventFastRefresh(config('safety.PREVEN_TFAST_REFRESH') . $request->getClientIp());

        $res1 = Safety::checkIpBlackList(config('safety.BLACKLIST') . $request->getClientIp());
        $res2 = Safety::number($request->getClientIp(), 100, '图片验证码接口');
        $res3 = Safety::session_number($tmp);
//        dd($res4);
//        if ($res1 || $res2 || $res3 || $res4) {
//            return view('welcome');
//        }
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
}
