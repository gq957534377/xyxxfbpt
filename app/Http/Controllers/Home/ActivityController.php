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
        //获取用户id，取得所有活动id
        $guid = session('user')->guid;
        $actionguid = self::$actionService->getAction($guid);

        //拼接活动信息数据
        $data = [];
        foreach ($actionguid as $v){
            $res = self::$actionService->getData($v);
            array_push($data,$res['msg']['data'][0]);
        }

        if (empty($data)) return response()->json(['status'=>'500','msg'=>'未找到数据']);
        return view('home.user.activity.activity')->with('data',$data);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
