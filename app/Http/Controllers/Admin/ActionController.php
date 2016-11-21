<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;
use App\Services\ActionService as ActionServer;

class ActionController extends Controller
{
    protected static $request;
    protected  static $actionServer;
    public function __construct(Request $request,ActionServer $actionServer)
    {
        self::$actionServer = $actionServer;
        self::$request = $request;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.action.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $result = self::$actionServer->selectData(self::$request);
        if($result["status"]){
            return response()->json(['StatusCode'=> 200,'ResultData'=>$result['msg']]);
        }else{
            return response()->json(['StatusCode'=> 400,'ResultData'=>$result['msg']]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *向活动表插入数据
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author 张洵之
     */
    public function store()
    {
        //
        $data = self::$request->all();
        $result = self::$actionServer->insertData($data);
        if($result["status"]){
            return response()->json(['StatusCode'=> 200,'ResultData'=>$result['msg']]);
        }else{
            return response()->json(['StatusCode'=> 400,'ResultData'=>$result['msg']]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @展示活动详情
     * @author
     */
    public function show($id)
    {
        $result = self::$actionServer->getData($id);
        if($result["status"]){
            return response()->json(['StatusCode'=> 200,'ResultData'=>$result['msg']]);
        }else{
            return response()->json(['StatusCode'=> 400,'ResultData'=>$result['msg']]);
        }
    }

    /**
     * 修改活动+报名状态
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 活动：张洵之 报名：郭庆
     */
    public function edit($id)
    {

        $status = self::$request->input("status");
        if (self::$request->input("type")=='1'){
            $result = self::$actionServer->orderStatus($id,$status);
        }else{
            $result = self::$actionServer->changeStatus($id,$status);
        }
        if($result["status"]){
            return response()->json(['StatusCode'=> 200,'ResultData'=>$result['msg']]);
        }else{
            return response()->json(['StatusCode'=> 400,'ResultData'=>$result['msg']]);
        }
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
        $data = self::$request->all();
        $where = ["guid" => $id];
        $result = self::$actionServer->upDta($where,$data);
        if($result["status"]){
            return response()->json(['StatusCode'=> 200,'ResultData'=>$result['msg']]);
        }else{
            return response()->json(['StatusCode'=> 400,'ResultData'=>$result['msg']]);
        }
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
        $result = self::$actionServer->getOrderInfo($id);
        if($result["status"]){
            return response()->json(['StatusCode'=> 200,'ResultData'=>$result['msg']]);
        }else{
            return response()->json(['StatusCode'=> 400,'ResultData'=>$result['msg']]);
        }
    }
}
