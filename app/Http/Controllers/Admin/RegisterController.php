<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\AdminService as AdminServer;

class RegisterController extends Controller
{
    protected static $adminServer = null;

    /**
     * RegisterController constructor.
     * 构造函数注入，将AdminServer类实例注入到本类当中
     * @param AdminServer $adminServer
     */
    public function __construct(AdminServer $adminServer)
    {
        self::$adminServer = $adminServer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.register');
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
        // 两次密码先校验
        if($data['password'] != $data['confirm_password']) return back()->withErrors('两次不一致');
        // 在对数据进行校验一次
        $this->validate($request ,[
            'email'     => 'required|email',
            'username'  => 'required|min:2|max:10',
            'password'  => 'required|min:6'
        ]);
        $data['ip'] = $request->getClientIp();
        // 将数据提交到业务层,检验是否已被注册
        $info = self::$adminServer->addUser($data);
        switch ($info){
            case 'exist':
                return back()->withErrors('此邮箱已存在！');
                break;
            case 'error':
                return back()->withErrors('数据异常，注册失败，请重新注册！');
                break;
            case 'yes':
                return redirect('/login')->with('dataStatus','注册成功，请登录！');
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
}
