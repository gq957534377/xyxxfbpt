<?php

namespace App\Http\Controllers\Home;

use App\Services\ProjectService;
use App\Services\UserRoleService;
use App\Services\UserService;
use App\Services\CommentAndLikeService;
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
    protected static $commentServer = null;

    public function __construct(ProjectService $projectService, UserService $userServer, UserRoleService $userRoleServer, CommentAndLikeService $commentServer)
    {
        self::$projectServer = $projectService;
        self::$userServer = $userServer;
        self::$userRoleServer = $userRoleServer;
        self::$commentServer = $commentServer;
    }

    /**返回项目列表页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 贾济林
     * @modify 刘峻廷
     * @modify 张洵之
     */
    public function index(Request $request)
    {
        $type = $request->input('type');

        if(!empty($type)) {
            $where = ['status' => '1', 'financing_stage' => $type-1];
        }else{
            $where = ['status'=>'1'];
        }

        $res = self::$projectServer->getData(1, 8,$where);
        $num = self::$projectServer->getCount($where);

        if ($res['StatusCode'] == '400') {
            $projects = [];
            return view('home.projects.index', compact('projects', 'type', 'num'));
        } else {
            $projects = $res['ResultData'];
            Common::wordLimit($projects, 'content', 15);
            return view('home.projects.index', compact('projects', 'type', 'num'));
        }

    }

    /**
     * 返回创建项目视图
     * @return \Illuminate\Http\JsonResponse
     * @author 张洵之
     */
    public function create()
    {
        return view('home.user.creatMyProject');
    }

    /**
     * 项目发布
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 贾济林
     * @modify 张洵之
     */
    public function store(Request $request)
    {
        //验证请求数据
        $role = session('user')->role;

        if ($role != 2) return response()->json(['status'=>'400','msg'=>'非创业者不可创建项目']);

        $validataResult = $this->addDataValidator($request);

        if($validataResult) return $validataResult;

        $data = $request->all();
        $result = self::$projectServer->addProjects($data);
        return response()->json($result);
    }

    /**
     * 返回项目详情视图
     * @param $id
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author 贾济林
     * @modify 刘峻廷
     * @modify 张洵之
     */
    public function show($id)
    {
        // 项目详情
        $res = self::$projectServer->getProject($id);

        if($res['StatusCode'] == '400') return view('errors.404');

//        $likeNum = self::$commentServer->likeCount($id);
//        //判断点赞状态
//        if(isset(session('user')->guid)){
//            $likeStatus = self::$commentServer->likeStatus(session('user')->guid, $id);
//        }else{
//            $likeStatus = 3;
//        }

        $project_details = $res['ResultData'];
        // 获取项目属于者具体信息
        $commentData = self::$commentServer->getComent($id,1);
        return view('home.projects.details', compact(
            'project_details', //内容详情数据
            'commentData', //评论内容数据
            'id'//项目guid
//            'likeNum', //点赞数
//            'likeStatus'//点赞状态
        ));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function edit($id)
    {
        empty(session('user')->guid) ;

    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
    }

    /**
     * 对前台加载的数据进行验证
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     * @author 贾济林
     * modify 张洵之
     */
    public function addDataValidator($request)
    {
        $validator = \Validator::make($request->all(), [
            'title'   => 'required|max:64',
            'content' => 'required|between:120,800',
            'brief_content'   => 'required|between:20,60',
            'industry'    => 'required|integer',
            'financing_stage' => 'required|integer',
            'logo_img' => 'required|url|string',
            'banner_img' => 'required|url|string',
            'team_member' => 'required|string',
            'project_experience'=> 'string',
            'file'=> 'string',
            'privacy' => 'required|integer'
        ], [
            'title.required'   => '未填写项目标题',
            'title.max' => '标题不可以超过64个字符',
            'content.required' => '项目详情不可为空',
            'content.between' => '项目详情应在120~800字符之间',
            'brief_content.required' => '项目一句话简介不可为空',
            'brief_content.between' => '项目一句话简介应在20~60字符之间',
            'industry.required' => '请选一个行业！',
            'industry.integer' => '行业输入类型错误',
            'financing_stage.required' => '请选一个融资阶段！',
            'financing_stage.integer' => '融资阶段输入类型错误',
            'logo_img.required' => '项目logo不可为空',
            'logo_img.url' => '无法识别logo地址',
            'logo_img.string' => 'logo输入类型错误',
            'banner_img.required' => '项目banner不可为空',
            'banner_img.url' => '无法识别banner地址',
            'banner_img.string' => 'banner输入类型错误',
            'team_member.required' => '项目核心成员缺失',
            'team_member.string' => '项目核心成员输入类型错误',
            'project_experience.string' =>  '项目历程输入类型错误',
            'file.string' =>  '文件输入类型错误',
            'privacy.required' => '请为项目设置隐私',
            'privacy.integer' => '隐私设置输入类型错误'
        ]);

        if ($validator->fails()) {
            return response()->json(['StatusCode' => 400, 'ResultData' => $validator->errors()->first()]);
        }

    }

    /**
     * 返回七牛存储Token
     * @return \Illuminate\Http\JsonResponse
     * author 张洵之
     */
    public function getToken()
    {
        $token = Common::getToken();
        $result = array('uptoken'=>$token);
        return response()->json($result);
    }

    /**
     * 项目列表页ajax请求处理器
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 张洵之
     */
    public function lists(Request $request)
    {
        $type = (int)$request->input('typeId');
        $nowPage = (int)$request->input('nowPage');

        if($type-1>0) {
            $where = ['status' => '1', 'financing_stage' => $type-1];
        }else{
            $where = ['status'=>'1'];
        }

        $result = self::$projectServer->getData($nowPage, 4 , $where);

        return response()->json($result);
    }

}
