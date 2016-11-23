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
     * 活动后台首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * author 张洵之
     */
    public function index()
    {
        return view('admin.action.index');
    }

    /**
     * 获取分页数据
     * @return \Illuminate\Http\JsonResponse
     * author 张洵之
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
     * 拿取一条活动信息详情
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * author 张洵之
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
        $result = self::$actionServer->changeStatus($id,$status);
        if($result["status"]){
            return response()->json(['StatusCode'=> 200,'ResultData'=>$result['msg']]);
        }else{
            return response()->json(['StatusCode'=> 400,'ResultData'=>$result['msg']]);
        }
    }

    /**
     * 更改活动信息内容
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * author 张洵之
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
     * 获取参与者信息
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * author 张洵之
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
