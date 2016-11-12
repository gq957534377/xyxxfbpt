<?php

namespace App\Http\Controllers\Admin;

use App\Tools\Common;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\TrainingService as TrainingService;

class TrainingController extends Controller
{
    protected static $TrainingService = null;

    /**
     * TrainingController constructor.
     * @param TrainingService $trainingService
     * @author 王拓
     */
    public function __construct(TrainingService $trainingService)
    {
        self::$trainingService = $trainingService;
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
     * 发布
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $data = $request->all();
//        //验证
//        $this->validate($request, [
//            'title' => 'required',
//            'groupname' => 'required',
//        ]);
//        $result = self::$TrainingService->addTraining($data);
//        switch ($result) {
//            case 'error';
//                return back()->withErrors("写入失败");
//                break;
//            case 'yes':
//                return redirect('/training');
//                break;
//        }
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
        $result = Common::getPageUrl($data, 'data_user_info', 'user_info_page');
        if ($result) {
            //获取当前页面数据
            $pageData = self::$trainingService->getTrainingList($result['nowPage']);
            return response()->json([
                'ServerNo' => 200,
                'ResultData' => [
                    'pages' => $result['pages'],
                    'data' => $pageData
                ]
            ]);
        }
        return response()->json(['ServerNo' => 400, 'ResultData' => '获取数据失败']);
    }
}
