<?php

namespace App\Http\Controllers\Admin;

use App\Tools\Common;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\TrainingService as TrainingService;
use App\Services\UploadService as UploadServer;

class TrainingController extends Controller
{
    protected static $trainingService = null;
    protected static $uploadserver = null;

    /**
     * TrainingController constructor.
     * @param TrainingService $trainingService
     * @author 王拓
     */
    public function __construct(TrainingService $trainingService, UploadServer $uploadService)
    {
        self::$trainingService = $trainingService;
        self::$uploadserver = $uploadService;
    }

    /**
     * 显示技术培训列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.training.list');
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 王拓
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            "title" => "required",
            'groupname' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['ServerNo' => 400, 'ResultData' => $validator->errors()->first()]);
        }
        //校验是否成功
        $result = self::$TrainingService->addTraining($request);
        if (!$result['status']) {
            return response()->json(['ServerNo' => 400, 'ResultData' => $result['msg']]);
        }
        return response()->json(['ServerNo' => 200, 'ResultData' => $request['msg']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 获取分页数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 王拓
     */
    public function getInfoPage(Request $request)
    {
        $data = $request->all();
        $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;
        //获取分页URL与合法的当前页
        $result = Common::getPageUrl($data, 'data_training_info', '/training_info_page', 5);
        if ($result) {
            //获取当前页面数据
            $pageData = self::$trainingService->getTrainingList($result['nowPage']);
            return response()->json([
                'ServerNo' => 200,
                'ResultData' => [
                    'pages' => $result['pages'],
                    'data' => $pageData['msg']
                ]
            ]);
        }
        return response()->json(['ServerNo' => 400, 'ResultData' => '获取数据失败']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 王拓
     */
    public function updateStatus(Request $request)
    {
        $data = $request->all();
        $result = self::$trainingService->updateTrainingStatus($data);
        if ($result['status']) return response()->json([ServerNo => 200, 'ResultData' => $result['msg']]);
        return response()->json(['serverNo' => 400, 'ResuleData' => $result['msg']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 王拓
     */
    public function getOneTraining(Request $request)
    {
        $data = $request->all();
        $guid = isset($data['name']) ? $data['name'] : '';
        if(empty($guid)) return response()->json(['ServerNo' => 400, 'ResultData' => '未找到相应数据']);
        $where = ['training_guid'=>$guid];
        $result = self::$trainingService->getOneTraining($where);
        return response()->json(['ServerNo' => 200, 'ResultData' => $result['msg']]);
    }
}