<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\AdminService as AdminServer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Tools\Common;

class LoginController extends Controller
{
    protected static $adminServer = null;
    /**
     * LoginController constructor.
     * 构造函数注入AdminServer业务层，将AdminServer业务层实例一个对象到本控制器中，调用
     * @param AdminServer $adminServer
     */
    public function __construct(AdminServer $adminServer)
    {
        self::$adminServer = $adminServer;
    }

    /**
     * 渲染Login视图
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.login');
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
     * 后台登录
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $data = $request->all();
        //验证码校验
        if($data['captcha'] != Session::get('code')){
            return back()->withErrors('验证码错误!');
        }
        //对数据格式再校验一次，始终坚信前端数据不可信
        $this->validate($request,[
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ]);

        // 获取登录ip
        $data['ip'] = $request->getClientIp();
        // 与数据库里数据进行校验，将这些业务逻辑交给服务层
        $info = self::$adminServer->loginCheck($data);
        switch($info['status']) {
            case '400':
                return back()->withErrors($info['msg']);
                break;
            case '500':
                Log::error($info['msg'],$data);//这边出错了那就不是逻辑问题了，抛给日志
                return back()->withErrors($info['msg']);
                break;
            case '200':
                return redirect('/');
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

    }

    /**
     * 返回验证码
     * @auther 郭庆
     */
    public function captcha($tmp)
    {
        return Common::captcha();
    }

    /**
     * 登出
     * @author 杨志宇
     */
    public function logout()
    {
        Session::forget('manager');
        return redirect('/login');
    }
}
