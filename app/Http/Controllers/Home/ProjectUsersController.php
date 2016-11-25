<?php

namespace App\Http\Controllers\Home;

use App\Services\ProjectService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class ProjectUsersController extends Controller
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

    /**
     * 返回指定项目类型的数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 贾济林
     */
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

    /**
     * 获得投资者权限的项目详情
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @author 贾济林
     */
    public function show($id)
    {
        if ($id=='myproject') return view('home.user.myproject');
        $where = ['project_id'=>$id];
        $res = self::$projectServer->getData($where);
        if (!$res['status']) return response()->json(['status'=>'500','msg'=>'查询失败']);
        return response()->json(['status'=>'200','data'=>$res['data']]);
    }

    //个人中心项目启用禁止
    public function edit(Request $request, $id)
    {
        $disable = $request['disable'];
        $where = ['project_id'=>$id];
        $data  = ['disable'=>$disable];
        $res = self::$projectServer->changeAble($where,$data);
        if (!$res['status']) return response()->json(['status'=>'500','msg'=>'修改失败']);
        return response()->json(['status'=>'200','msg'=>'修改成功']);
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
