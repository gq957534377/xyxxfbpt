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
        $data = $request->all();

        //参数范围限制
        if($data['key'] < 0 || $data['key'] > 13){
            return response()->josn(['StatusCode' => 403]);
        }
        //参数规则
        $roles = [
            ['role' => 1],    //查询data_user_info表,普通用户
            ['role' => 2],      //创业者用户
            ['role' => 3],      //投资者用户
            ['role' => 4],      //英雄会会员
            ['status' => 1, 'role' => 2],     //查询data_role_info表,'待审核创业者用户' =>
            ['status' => 1, 'role' => 3],     //  '待审核投资者用户' =>
            ['status' => 1, 'role' => 4],     //'待审核投资者用户' =>
            ['status' => 3, 'role' => 2],    // '审核失败创业者用户' =>
            ['status' => 3, 'role' => 3],    //'审核失败投资者用户' =>
            ['status' => 3, 'role' => 4],    //'审核失败英雄会成员' =>
            ['status' => 2, 'role' => 1],      //'已禁用普通用户' =>
            ['status' => 2, 'role' => 2],     //'已禁用创业者用户' =>
            ['status' => 2, 'role' => 3],     //'已禁用投资者用户' =>
            ['status' => 2, 'role' => 4]      //'已禁用英雄会成员' =>
        ];

        //查询条件
        $where = $roles[$data['key']];

        //表名选择
        if(count($where) > 1){
            $table = 'data_role_info';
            $count = \DB::table($table)->where('status', $where['status'])->where('role', $where['role'])->count();


        }else{
            $table = 'data_user_info';
            $count = \DB::table($table)->where('role', $where['role'])->count();

        }

        //没有数据返回400
        if ($count == 0){
            return response()->json(['StatusCode' => 400]);
        }

        $pageNums = 1;  //一页的数据条数
        $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;   //获取当前页
        //总页数
        $totalPage = ceil($count / $pageNums);
        //分页求情的地址
        $baseUrl   = url('/test/show');

        if($nowPage <= 0){
            $nowPage = 1;
        }elseif ($nowPage > $totalPage){
            $nowPage = $totalPage;
        }

        //创建分页
        if ($totalPage > 1){
            $search = ['key' => $data['key']];
            $pageStr = CustomPage::getSelfPageView($nowPage, $totalPage, $baseUrl, $search);
        }else{
            $pageStr = '';
        }

        //获取对应页的数据
        if (count($where) > 1){
            $Data = \DB::table($table)
                ->where('status', $where['status'])
                ->where('role', $where['role'])
                ->forPage($nowPage, $pageNums)
                ->get();
        }else{
            $Data = \DB::table($table)->where('role', $where['role'])->forPage($nowPage, $pageNums)->get();
        }




        //有则返回200和用户列表信息
        return response()->json(['StatusCode' => 200, 'ResultData' => [$pageStr,$Data]]);

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
