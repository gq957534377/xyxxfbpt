<?php

namespace App\Http\Controllers\Home;

use App\Services\ProjectService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class ProjectController extends Controller
{
    protected static $projectServer = null;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(ProjectService $projectService)
    {
        self::$projectServer = $projectService;
    }

    public function index()
    {
        echo 'index';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }
    public function test(Request $request)
    {

        $res = self::$projectServer->addProject($request);

        if(!$res) return response()->json(['status'=>'400','msg'=>'插入失败']);
        return response()->json(['status'=>'200','msg'=>'插入成功'],);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($id = 'publish') return view('Home.project.project_publish');
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

    /**
     * 获取七牛参数
     * @return \Illuminate\Http\JsonResponse
     * @author 贾济林
     */
    public function getuptoken()
    {
        // 需要填写你的 Access Key 和 Secret Key
        $accessKey = 'VsAP-hK_hVPKiq5CQcoxWNhBT9ZpZ1Ii4z3O_W51';
        $secretKey = '5dqfmvL15DFoAK1QzaVF2TwVzwJllOF8K4Puf1Po';

        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);

        // 要上传的空间
        $bucket = 'jacklin';

        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        $a = array('uptoken'=>$token);
        return response()->json($a);
    }
}
