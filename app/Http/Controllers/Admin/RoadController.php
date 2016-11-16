<?php
/**
 * Road 后台
 * User: 郭庆
 * Date: 2016/11/08
 * Time: 16：34
 */
namespace App\Http\Controllers\Admin;

use App\Tools\Common;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\RoadService as RoadServer;
use App\Services\UploadService as UploadServer;
use Illuminate\Support\Facades\Input;

class RoadController extends Controller
{
    protected static $roadServer = null;
    protected static $uploadServer = null;

    public function __construct(RoadServer $roadServer,UploadServer $uploadServer){
        self::$roadServer   = $roadServer;
        self::$uploadServer = $uploadServer;
    }
    /**
     * 展示路演管理页面
     * @return list视图
     * @author 郭庆
     */
    public function index()
    {
        return view('admin.road.road_list');
    }

    /**
     * 修改路演信息状态
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function create(Request $request)
    {
        $data   = $request->all();
        $result = self::$roadServer->updateRoadStatus($data);
        if($result['status']) return response()->json(['ServerNo' => 200, 'ResultData' => $result['msg']]);
        return response()->json(['ServerNo' => 400, 'ResultData' => $result['msg']]);
    }

    /**
     * 路演发布
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            "title"=>'required',
            "speaker" => "required",
            "brief" => "required|max:100",
        ]);
        if ($validator->fails()) {
            return response()->json(['ServerNo' => 400,'ResultData' => $validator->errors()->first()]);
        }
        // 校验是否注册成功
        $result = self::$roadServer->CheckAddRoad($request);
        if(!$result['status']) {
            return response()->json(['ServerNo' => 400, 'ResultData' => $result['msg']]);
        }
        // 成功跳转
        return response()->json(['ServerNo' => 200, 'ResultData' => $result['msg']]);
    }

    /**
     * 查询一条路演详情
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function show(Request $request,$id)
    {
        if(empty($id)) return response()->json(['ServerNo' => 400, 'ResultData' => '未找到相应数据']);
        $where = ['roadShow_id'=>$id];
        $result = self::$roadServer->getOneRoad($where);
        $result['msg']->start_time=date('Y-m-d\TH:i:s',$result['msg']->start_time);
        $result['msg']->end_time=date('Y-m-d\TH:i:s', $result['msg']->end_time);
        $result['msg']->deadline=date('Y-m-d\TH:i:s', $result['msg']->deadline);
        $result['msg']->time=date('Y-m-d\TH:i:s', $result['msg']->time);
        return response()->json(['ServerNo' => 200, 'ResultData' => $result['msg']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function edit($id)
    {

    }

    /**
     * 修改路演信息详情
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $where = ['roadShow_id'=>$id];
        $re   = self::$roadServer->updateRoad($data,$where);
        if($re) return response()->json(['ServerNo' => 200, 'ResultData' => $re]);
        return response()->json(['ServerNo' => 500, 'ResultData' => '路演活动修改失败']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function destroy($id)
    {

    }

    /**
     * 分页请求并返回相应数据和分页视图
     * @author 郭庆
     */
    public function getInfoPage(Request $request)
    {
        $data    = $request->all();
        $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;
        // 获取分页URL与合法的当前页

        $result  = Common::getPageUrl($data, 'data_roadShow_info', '/road_info_page',3,['status'=>$data['type']]);
        if($result) {
            // 获取当前页对应的数据
            $pageData = self::$roadServer->getRoadList($result['nowPage'],$data['type']);
            if(!$pageData['status'])
                return response()->json([
                    'ServerNo'   => 400,
                    'ResultData' => "没有数据",
                ]);
            foreach ($pageData['msg'] as $v)
            {
                $v->start_time=date('Y-m-d\TH:i:s', $v->start_time);
                $v->end_time=date('Y-m-d\TH:i:s', $v->end_time);
                $v->deadline=date('Y-m-d\TH:i:s', $v->deadline);
                $v->time=date('Y-m-d\TH:i:s', $v->time);
            }
            return response()->json([
                'ServerNo'   => 200,
                'ResultData' => [
                    'pages'  => $result['pages'],
                    'data'   => $pageData['msg']
                ],
            ]);
        }
        return response()->json(['ServerNo' => 400, 'ResultData' => '获取数据失败']);
    }

    /**
     * 上传图片
     * @return \Illuminate\Http\JsonResponse
     * @author 郭庆
     */
    public function upload()
    {
        $file=Input::file('Filedata');
        if($file->isValid()){
            $realPath=$file->getRealPath();//临时文件的绝对路径
            $extension=$file->getClientOriginalName();//上传文件的后缀
            $hz = explode('.',$extension)[1];
            $newName=date('YmdHis').mt_rand(100,999).'.'.$hz;
            $path=$file->move(public_path('uploads/image/admin/road'),$newName);
            $result = 'uploads/image/admin/road/'.$newName;
            return response()->json(['res'=>$result]);
        }else{
        }

    }
}
