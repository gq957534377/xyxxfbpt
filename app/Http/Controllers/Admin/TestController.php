<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tools\CustomPage;
use App\Store\UserStore;


class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data = $request->all();  //where条件参数
        $pageNums = 2;  //一页的数据条数
        $nowPage = isset($data['nowPage']) ? (int)$data['nowPage'] : 1;   //获取当前页

        //参数规则
        $roles = [
            '普通用户' => ['role' => 1],    //查询data_user_info表
            '创业者用户' => ['role' => 2],
            '投资者用户' => ['role' => 3],
            '英雄会成员' => ['role' => 4],
            '待审核创业者用户' => ['status' => 1, 'role' => 2],     //查询data_role_info表
            '待审核投资者用户' => ['status' => 1, 'role' => 3],
            '待审核英雄会成员' => ['status' => 1, 'role' => 4],
            '审核失败创业者用户' => ['status' => 3, 'role' => 2],
            '审核失败投资者用户' => ['status' => 3, 'role' => 3],
            '审核失败英雄会成员' => ['status' => 3, 'role' => 4],
            '已禁用普通用户' => ['status' => 2, 'role' => 1],
            '已禁用创业者用户' => ['status' => 2, 'role' => 2],
            '已禁用投资者用户' => ['status' => 2, 'role' => 3],
            '已禁用英雄会成员' => ['status' => 2, 'role' => 4]
        ];

        //查询条件
        $where = $roles[$data['key']];

        //表名选择
        if($where['status' == 1 || $where['status' == 3]]){
            $table = 'data_role_info';
            $count = DB::table($table)->where('status',$where['status'])->andwhere('role',$where['role'])->count();
        }else{
            $table = 'data_user_info';
            $count = DB::table($table)->where('role',$where['role'])->count();
        }


        $totalPage = ceil($count / $paegNums);
        $baseUrl   = url($url);

        if($nowPage <= 0){
            $nowPage = 1;
        }elseif ($nowPage > $totalPage){
            $nowPage = $totalPage;
        }

        //创建分页
        $pageStr = CustomPage::getSelfPageView($nowPage, $totalPage, $baseUrl,null);
        //获取对应页的数据
        //$Data = new UserStore()->forPage($nowPage, $pageNums, $where);



        //return response()->json(['StatusCode' => 200,'ResultData' => [$pageStr,$Data]]);

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