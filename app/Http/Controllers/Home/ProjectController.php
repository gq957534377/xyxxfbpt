<?php

namespace App\Http\Controllers\Home;

use App\Services\ProjectService;
use App\Services\UserRoleService;
use App\Services\UserService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Qiniu\Auth;
use App\Tools\Common;

class ProjectController extends Controller
{
    protected static $projectServer = null;
    protected static $userRoleServer = null;
    protected static $userServer = null;


    /**单例引入projectService
     * ProjectController constructor.
     * @param ProjectService $projectService
     */
    public function __construct(ProjectService $projectService, UserService $userServer, UserRoleService $userRoleServer)
    {
        self::$projectServer = $projectService;
        self::$userServer = $userServer;
        self::$userRoleServer = $userRoleServer;
    }

    /**返回项目列表页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 贾济林
     * @modify 刘峻廷
     */
    public function index()
    {
        $where = ['disable'=>'0','status'=>'3'];

        $res = self::$projectServer->getData($where);
        // 处理内容，限制字数
        $projects = $res['data'];
        Common::wordLimit($projects, 'content', 15);

        if (!$res['status']) {
            $projects = [];
            return view('heroHome.projects.index', compact('projects'));
        } else {
            return view('heroHome.projects.index', compact('projects'));
        }

    }

    /**
     * 根据用户session得到角色值
     * @return \Illuminate\Http\JsonResponse
     * @author 贾济林
     */
    public function create()
    {
        $guid = session('user')->guid;
        $res = self::$projectServer->getRole($guid);
        if (!$res['status']) return response()->json(['status'=>'500','msg'=>'查询失败']);
        return response()->json(['status'=>'200','data'=>$res['data']]);
    }

    /**
     * 项目发布
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 贾济林
     */
    public function store(Request $request)
    {
        //验证请求数据
        $this->addDataValidator($request);

        $data = $request->all();
        $res = self::$projectServer->addProject($request);

        if(!$res) return response()->json(['status'=>'400','msg'=>'插入失败']);
        return response()->json(['status'=>'200','msg'=>'插入成功']);
    }

    /**
     * 返回项目详情视图
     * @param $id
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 贾济林
     * @modify 刘峻廷
     */
    public function show($id)
    {
        // 项目详情
        $where = ['project_id'=>$id];
        $res = self::$projectServer->getData($where);

        if (!$res['status']) return response()->json(['status'=>'500','msg'=>'查询失败']);
        $project_details = $res['data'][0];

        // 获取项目属于者具体信息
        $userResult =self::$userServer->userInfo(['guid' => $project_details->guid]);
        if (!$userResult['status']) return response()->json(['status'=>'500','msg'=>'查询失败']);
        $headpic = $userResult['msg']->headpic;

        $roleResult = self::$userRoleServer->userInfo(['guid' => $project_details->guid]);

        if (!$userResult['status']) return response()->json(['status'=>'500','msg'=>'查询失败']);
        $userinfo = $userResult['msg'];
        $userinfo->headpic = $headpic;

//        return view('home.project.pro_details')->with('data',$res['data']);
        return view('heroHome.projects.details', compact('project_details', 'userinfo'));
    }

    /**
     * 返回七牛upToken
     * @return \Illuminate\Http\JsonResponse
     * @author 贾济林
     */
    public function edit($id)
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

    /**
     * 返回个人项目列表
     * @param Request $request
     * @param $id
     * @return mixed
     * @author 贾济林
     */
    public function update(Request $request, $id)
    {
        $res = self::$projectServer->getProject();
        if (!$res['status']) return response()->json(['status'=>'500','msg'=>'查询失败']);
        return response()->json(['status'=>'200','data'=>$res['data']]);
    }

    /**
     * 获得指定id的项目数据
     * @param $id
     * @return mixed
     * @author 贾济林
     */
    public function destroy($id)
    {
        $where = ['project_id'=>$id];
        $res = self::$projectServer->getData($where);
        if (!$res['status']) return response()->json(['status'=>'500','msg'=>'查询失败']);
        return response()->json(['status'=>'200','data'=>$res['data']]);
    }

    /**对前台加载的数据进行验证
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     * @author 贾济林
     */
    public function addDataValidator($request)
    {
        $validator = \Validator::make($request->all(), [
            'title'   => 'required|max:10',
            'content' => 'required',
            'image'   => 'required',
            'file'    => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['ServerNo' => 400, 'ResultData' => $validator->errors()->first()]);
        }

    }

}
