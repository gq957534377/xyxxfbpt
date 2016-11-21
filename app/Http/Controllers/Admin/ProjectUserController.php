<?php

namespace App\Http\Controllers\Home;

use App\Services\ProjectService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class ProjectUserController extends Controller
{
    protected static $projectServer = null;
    /**单例引入projectService
     * ProjectController constructor.
     * @param ProjectService $projectService
     */
    public function __construct(ProjectService $projectService)
    {
        self::$projectServer = $projectService;
    }

    //返回指定项目类型的数据
    public function index(Request $request)
    {
        $data = $request->all();
        $project_type = $data['project_type'];
        $where = ['project_type'=>$project_type];
        $res = self::$projectServer->getData($where);
        if (!$res['status']) return response()->json(['status'=>'500','msg'=>'查询失败']);
        return response()->json(['status'=>'200','data'=>$res['data']]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {
        echo $id;
    }

    public function edit($id)
    {

    }


    //个人中心数据项目数据更新
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $where = ['project_id'=> $id];
        $res = self::$projectServer->updateData($data,$where);
        if (!$res['status']) return response()->json(['status'=>'500','msg'=>'您没有做任何改变哦']);
        return response()->json(['status'=>'200','msg'=>'更新成功']);

    }


    public function destroy($id)
    {

    }


}
