<?php

namespace App\Http\Controllers\Admin;

use App\Services\ProjectService;
use App\Tools\Common;
use App\Tools\CustomPage;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    protected static $projectServer = null;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function __construct(ProjectService $projectService)
    {
        self::$projectServer = $projectService;
    }

    public function index()
    {
        return view('admin.project.unchecked_pros');
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
        $res = self::$projectServer->changeStatus($data);
        if(!$res) return response()->json(['status'=>'500','msg'=>'修改失败']);
        return response()->json(['status'=>'200','msg'=>'修改成功']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($id == 'unchecked') return view('admin.project.unchecked');
        if ($id == 'pass') return view('admin.project.pass');
        if ($id == 'nopass') return view('admin.project.nopass');
        return false;
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
        //获取需要的数据
        $data = $request->all();
        $status = $data['status'];
        $table = 'project_info_data';
        $totalPage = DB::table($table)->where(['status'=>$status])->count();
        $nowPage = 1;
        $num = 1;

//        获取首页数据
        $res = self::$projectServer->getFrstPage($num, $status);

        $pages = self::getpage($request,$num,$status);
        $res['pages'] = $pages;
        if (!$res['status']) return response()->json(['status'=>'400','msg'=>'查询失败']);
        return response()->json(['status'=>'200','data'=>$res]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->all();
        $status = $data['status'];
        $nowPage = $data['nowPage'];
        $num = 1;
        $res = self::$projectServer->getPage($nowPage,$num,$status);
        $pages = self::getpage($request,$num,$status);
        $res['pages'] = $pages;
        if (!$res['status']) return response()->json(['status'=>'400','msg'=>'查询失败']);
        return response()->json(['status'=>'200','data'=>$res]);
    }

    //返回分页
    public function getpage($request, $num, $status)
    {
        $data = $request->all();
        $table = 'project_info_data';
        $baseUrl = url('project/unchecked');
        $count = DB::table($table)->where(['status'=>$status])->count();
        $totalPage = ceil($count/$num);
        $nowPage = isset($data['nowPage']) ? $data['nowPage'] : 1;
        $pages = CustomPage::getSelfPageView($nowPage, $totalPage, $baseUrl, '');
        return $pages;
    }

    public function test(Request $request)
    {
        $data = $request->all();
        $table = 'project_info_data';
        $baseUrl = url('project/unchecked');
        $status = $data['status'];
        $num = 1;
        $count = DB::table($table)->where(['status'=>$status])->count();
        $totalPage = ceil($count/$num);
        $nowPage = isset($data['nowPage']) ? $data['nowPage'] : 1;
        $pages = CustomPage::getSelfPageView($nowPage, $totalPage, $baseUrl, '');
        echo $pages;
    }

}
