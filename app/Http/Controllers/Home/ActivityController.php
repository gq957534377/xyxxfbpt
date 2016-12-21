<?php

namespace App\Http\Controllers\Home;

use App\Services\ActionService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    protected static $actionService;

    public function __construct(ActionService $actionService)
    {
        self::$actionService = $actionService;
    }

    /**
     * 获得单个用户的所有活动信息
     * @return $this|\Illuminate\Http\JsonResponse
     * @author 贾济林
     */
    public function index()
    {
        return view('errors.404');
        //获取用户id，取得所有活动id
        $guid = session('user')->guid;
        $where = ['user_id' => $guid,'status' => '1'];

        $tmp = self::$actionService->getActivityId($where);

        //如果数据为空，返回空数组
        if (!$tmp['status']) return view('home.user.activity.index')->with('data',[]);
        $actionguid = $tmp['data'];

        //拼接活动信息数据
        $data = [];
        foreach ($actionguid as $v){
            $res = self::$actionService->getData($v);
            array_push($data,$res['msg']);
        }

        // 活动类型数据处理，划分三个组

        if (empty($data)) return view('home.user.activity.index')->with('data',[]);
        return view('home.user.activity.index')->with('data',$data);
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
        //
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
     * 修改活动报名状态
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @author 贾济林
     */
    public function destroy(Request $request, $id)
    {
        $activity_id = $request['activity_id'];
        $res = self::$actionService->switchStatus($activity_id,3);
        if (!$res['status']) return response()->json(['status' => '500', 'msg' => '修改失败']);
        return response()->json(['status' => '200', 'msg' => '修改成功']);
    }
}
