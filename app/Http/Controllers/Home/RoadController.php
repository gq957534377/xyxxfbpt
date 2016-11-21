<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\RoadService as roadServer;

class RoadController extends Controller
{
    protected static $roadServer = null;

    public function __construct(RoadServer $roadServer){
        self::$roadServer   = $roadServer;
    }
    /**
     * 获取所有路演信息 - 展示路演信息列表
     *
     * @return  后台路演信息管理页面 - 状态信息 & 错误原因 | 路演信息
     *
     * @author  郭庆
     */
    public function index()
    {
        $newRoad = self::$roadServer->getNewRoad();
        $historyRoad = self::$roadServer->getHistoryRoad();
        return view('home.road.index',['new'=>$newRoad,'history'=>$historyRoad]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $newRoad = self::$roadServer->getNewRoad();
        if(!$newRoad['status'])return view('home.road.new',['StatusCode'=>'400','ResultData'=>$newRoad['msg']]);
        return view('home.road.new',['new'=>$newRoad]);
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
        $where = ['roadShow_id'=>$id];
        $data  = self::$roadServer->getOneroad($where);
        return view('home.road.xiangqing',compact('data'));
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
