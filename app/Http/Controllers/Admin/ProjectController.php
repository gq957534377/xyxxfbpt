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

    /**单例引入projectService
     * ProjectController constructor.
     * @param ProjectService $projectService
     * @author 贾济林
     */
    public function __construct(ProjectService $projectService)
    {
        self::$projectServer = $projectService;
    }

    /**
     * 返回待审核视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 贾济林
     */
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
     * 审核操作，修改项目状态值
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 贾济林
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $res = self::$projectServer->changeStatus($data);
        if(!$res) return response()->json(['status'=>'500','msg'=>'修改失败']);
        return response()->json(['status'=>'200','msg'=>'修改成功']);
    }

    /**
     * 根据路由返回对应视图
     * @param $id
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 贾济林
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
     * 返回对应状态值的首页分页数据对应列表分页
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @author 贾济林
     */
    public function update(Request $request, $id)
    {
        //整理请求数据
        $data = $request->all();
        $status = $data['status'];
        $table = 'project_info_data';
        $totalPage = DB::table($table)->where(['status'=>$status])->count();
        $nowPage = 1;
        $num = 1;

        //获取首页数据
        $res = self::$projectServer->getFrstPage($num, $status);
        //获取分页
        $pages = self::getpage($request,$num,$status);
        //整理返回数据
        $res['pages'] = $pages;
        if (!$res['status']) return response()->json(['status'=>'400','msg'=>'查询失败']);
        return response()->json(['status'=>'200','data'=>$res]);
    }

    /**
     * 获取三种项目状态对应的分页数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 贾济林
     */
    public function destroy(Request $request)
    {
        //整理参数
        $data = $request->all();
        $status = $data['status'];
        $nowPage = $data['nowPage'];
        $num = 1;

        //获取分页数据
        $res = self::$projectServer->getPage($nowPage,$num,$status);

        //获取分页
        $pages = self::getpage($request,$num,$status);

        //整理返回数据
        $res['pages'] = $pages;
        if (!$res['status']) return response()->json(['status'=>'400','msg'=>'查询失败']);
        return response()->json(['status'=>'200','data'=>$res]);
    }

    /**
     * 获取对应项目状态的分页
     * @param $request
     * @param $num
     * @param $status
     * @return string
     * @author 贾济林
     */
    public function getpage($request, $num, $status)
    {
        //整理参数
        $data = $request->all();
        $table = 'project_info_data';
        $baseUrl = url('project/unchecked');
        $count = DB::table($table)->where(['status'=>$status])->count();
        $totalPage = ceil($count/$num);
        $nowPage = isset($data['nowPage']) ? $data['nowPage'] : 1;

        //获取分页
        $pages = CustomPage::getSelfPageView($nowPage, $totalPage, $baseUrl, '');
        return $pages;
    }

}
