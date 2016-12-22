<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Store\UserStore;
use App\Store\RoleStore;
use App\Services\userManagementService as Users;


class UserManagementController extends Controller
{

    protected static $users;    //用户管理service
    /**
     *
     */
    public function __construct(Users $users)
    {
        self::$users = $users;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //返回后台用户管理首页
        return view('admin.user.index');
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

    /** 通过不同参数，返回对应类型的用户列表
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author lw
     */
    public function show(Request $request)
    {   //数据初始化
        $data = $request->all();

        //参数范围限制
        if($data['key'] < 0 || $data['key'] > 16){
            return view('404');
        }
        //参数规则
        $roles = self::$users->roles();

        //查询条件
        $where = $roles[$data['key']];

        //表名选择,并获取数据的条数
        if($data['key'] > 8){
            $table = 'data_role_info';
        }else{
            $table = 'data_user_info';
        }

        //获取条数
        $count = self::$users->getCount($table, $where);
        //没有数据返回400
        if ($count == 0){
            return response()->json(['StatusCode' => 400]);
        }

        $pageNums = 5;  //一页的数据条数
        $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;   //获取当前页
        $search = ['key' => $data['key']];  //查询参数拼装

        //获取分页字符串
        $pageStr = self::$users->paramHandle($count, $nowPage, $pageNums, $search);

        //获取对应页的数据
        $Data = self::$users->getTypelist($table, $where, $nowPage, $pageNums);

        //有则返回200和用户列表信息
        return response()->json(['StatusCode' => 200, 'ResultData' => [$pageStr,$Data]]);

    }

    /** 执行用户的启用、禁用操作： 1为禁用 2为启用
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if($id < 1 && $id > 2){
            return response()->json(['statusCode' => 204,'resultDate' => "参数不在合法范围"]);
        }

        //获取用户guid
        $guid = $request->input('guid');

        //执行启用或者禁用
        $update = self::$users->changeStatus(['guid'=>$guid], ['status' => $id]);

        if(!$update) return response()->json(['statusCode' => 400,'resultData' =>'操作失败！']);
        return response()->json(['statusCode' => 200,'resultData' =>'操作成功！']);

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
