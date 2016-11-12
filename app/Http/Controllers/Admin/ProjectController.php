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
        $data = $request->all();
        $num = 3;
        if ($id = 'status1') $res = self::$projectServer->getFrstPage($num);
        //添加分页信息
        $pages = Common::getPageUrl($data, 'project_info_data', 'project/unchecked', $num);
        $res['pages'] = $pages['pages'];
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
        $nowPage = $data['nowPage'];
        $num = 3;
        $res = self::$projectServer->getPage($nowPage,$num);
        $pages = Common::getPageUrl($data, 'project_info_data', 'project/unchecked', $num);
        $res['pages'] = $pages['pages'];
        if (!$res['status']) return response()->json(['status'=>'400','msg'=>'查询失败']);
        return response()->json(['status'=>'200','data'=>$res]);
    }

    public function test()
    {
        return $res = self::$projectServer->getFrstPage('3');
    }
}
