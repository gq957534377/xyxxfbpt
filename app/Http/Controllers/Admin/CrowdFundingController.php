<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\CrowdFundingService as CrowdFundingServer;

class CrowdFundingController extends Controller
{
    protected static $crowdFundingServer = null;
    protected static $request = null;

    public function __construct(CrowdFundingServer $crowdFundingServer,Request $request)
    {
        self::$crowdFundingServer = $crowdFundingServer;
        self::$request = $request;
    }
    /**
     *众筹后台管理首页
     * @return \Illuminate\Http\Response
     * @author 张洵之
     */
    public function index()
    {
        //
        return view("admin.crowdfunding.approval");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @author 张洵之
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *发布众筹
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author 张洵之
     */
    public function store()
    {
        $result = self::$crowdFundingServer->startCrowdFuding(self::$request);
        if($result["status"]){
            return response()->json(['StatusCode'=> 200,'ResultData'=>$result['msg']]);
        }else{
            return response()->json(['StatusCode'=> 400,'ResultData'=>$result['msg']]);
        }
    }

    /**
     *查询申报众筹项目
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 张洵之
     */
    public function show($id)
    {
        //
        $result = self::$crowdFundingServer->AdminShow($id);
        if($result["status"]){
            return response()->json(['StatusCode'=> 200,'ResultData'=>$result['msg']]);
        }else{
            return response()->json(['StatusCode'=> 400,'ResultData'=>$result['msg']]);
        }
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
    public function update($id)
    {
        //
        $result = self::$crowdFundingServer->serverRoute(self::$request,$id);
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
    }

    /**
     * 分页接口
     * @return \Illuminate\Http\JsonResponse
     * @author 张洵之
     */
    public function forPage()
    {
        $result = self::$crowdFundingServer->forPage(self::$request);
        if($result["status"]){
            return response()->json(['StatusCode'=> 200,'ResultData'=>$result['msg']]);
        }else{
            return response()->json(['StatusCode'=> 400,'ResultData'=>$result['msg']]);
        }
    }

    /**
     * 修改发布的中筹项目
     * @return \Illuminate\Http\JsonResponse
     * @author 张洵之
     */
    public function revise()
    {
        $result = self::$crowdFundingServer->reviseCrowdFunding(self::$request);
        if($result["status"]){
            return response()->json(['StatusCode'=> 200,'ResultData'=>$result['msg']]);
        }else{
            return response()->json(['StatusCode'=> 400,'ResultData'=>$result['msg']]);
        }
    }

    /**
     * 查看可发布的项目
     * @return \Illuminate\Http\JsonResponse
     * @author 张洵之
     */
    public function selectPublish()
    {
        $result = self::$crowdFundingServer->selectPublish();
        if($result["status"]){
            return response()->json(['StatusCode'=> 200,'ResultData'=>$result['msg']]);
        }else{
            return response()->json(['StatusCode'=> 400,'ResultData'=>$result['msg']]);
        }
    }
}
