<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\userManagementService as Users;

class RoleManagementController extends Controller
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
        //
        return view('admin.user.role');
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {   //数据初始化
        $data = $request->all();

        $key = $data['key'];

        //参数范围限制
        if($key < 0 || $key > 5){
            return view('404');
        }
        //参数规则
        $roles = self::$users->applyRoles();

        //查询条件
        $where = ['status'=>$roles[$key]['status']];
        //dd($where);
        $table = $roles[$key]['table'];

        //获取条数
        $count = self::$users->getCount($table, $where);
        //没有数据返回400
        if ($count == 0){
            return response()->json(['StatusCode' => 400]);
        }

        $pageNums = 3;  //一页的数据条数
        $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;   //获取当前页
        $search = ['key' => $key];  //查询参数拼装

        //获取分页字符串
        $pageStr = self::$users->paramHandle('role',$count, $nowPage, $pageNums, $search);

        //获取对应页的数据
        $Data = self::$users->getTypelist($table, $where, $nowPage, $pageNums);

        //有则返回200和用户列表信息
        return response()->json(['StatusCode' => 200, 'ResultData' => [$pageStr,$Data]]);

    }

    /**
     * 用户审核操作
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //获取审核的用户guid
        $guid = $request->guid;

        //获取用户审核类型
        $role = $request->role;

        //获取status
        $status = $id;

        $update = self::$users->changeApplyStatus($guid, $role, $status);

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
