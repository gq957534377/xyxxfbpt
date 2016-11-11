<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\UserService as UserServer;

class UserController extends Controller
{
    protected static $userServer = null;

    public function __construct(UserServer $userServer)
    {
        self::$userServer = $userServer;
    }
    /**
     * 显示个人中心页
     *
     * @return \Illuminate\Http\Response
     * @author 刘峻廷
     */
    public function index()
    {
        return view('home.user.index');
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
        //
    }

    /**
     * 提取个人信息
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(empty($id)) return response()->json(['StatusCode'=>500,'ResultData'=>'服务器数据异常']);
      // 获取到用户的id，返回数据
        $info = self::$userServer->userInfo($id);

        if(!$info['status']) return response()->json(['StatusCode'=>404,'ResultData'=>'未查询到数据']);
        return response()->json(['StatusCode'=>200,'ResultData'=>$info]);
    }

    /**
     * 编辑个人中心
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


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
        $data = $request->all();
        return response()->josn($data);
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

    public function getUserInfo()
    {
        //检验用户是否登录
        $userinfo = self::$userServer->signOn();
        if(!$userinfo) return response()->json(['Status'=>404,'ResultData'=>'没有登录']);
        return response()->json(['StatusCode'=> 200,'ResultData'=> $userinfo]);
    }
}
