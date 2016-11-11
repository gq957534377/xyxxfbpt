<?php
/**
 * Roald 后台业务服务层
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

class RoadController extends Controller
{
    protected static $roadServer = null;
    protected static $uploadServer = null;

    public function __construct(RoadServer $roadServer,UploadServer $uploadServer){
        self::$roadServer   = $roadServer;
        self::$uploadServer = $uploadServer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.road.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.road.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            "title"=>'required',
            "speaker" => "required",
            "brief" => "required|max:100",
        ]);
        if ($validator->fails()) {
            return response()->json(['ServerNo' => 400,'ResultData' => $validator->errors()->all()]);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
     * @return string
     */
    public function getInfoPage(Request $request)
    {
        $data    = $request->all();
        $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;
        // 获取分页URL与合法的当前页
        $result  = Common::getPageUrl($data, 'data_roadShow_info', '/road_info_page');
        if($result) {
            // 获取当前页对应的数据
            $pageData = self::$roadServer->getRoadList($result['nowPage']);
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 
     */
    public function updateStatus(Request $request)
    {
        $data   = $request->all();
        $result = self::$roadServer->updateRoadStatus($data);
        if($result['status']) return response()->json(['ServerNo' => 200, 'ResultData' => $result['msg']]);
        return response()->json(['ServerNo' => 400, 'ResultData' => $result['msg']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOneRoad(Request $request)
    {
        $data = $request->all();
        $guid = isset($data['name']) ? $data['name'] : '';
        if(empty($guid)) return response()->json(['ServerNo' => 400, 'ResultData' => '未找到相应数据']);
        $result = self::$roadServer->getOneRoad($guid);
        return response()->json(['ServerNo' => 200, 'ResultData' => $result['msg']]);
    }
}
