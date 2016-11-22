<?php
/**
 * 众筹模块控制器层
 * User: 张洵之
 * Date: 2016/11/8
 * Time: 12:10
 */

namespace App\Http\Controllers\Home;

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
     * 显示众筹首页
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     * @author 张洵之
     */
    public function index()
    {
        //
        return view("home.crowdfunding.index");
    }

    /**
     * 首页三球数据
     * @return \Illuminate\Http\JsonResponse
     * author 张洵之
     */
    public function create()
    {
        //
        $result = self::$crowdFundingServer->dynamicDataIndex();
        if($result["status"]){
            return response()->json(['StatusCode'=> 200,'ResultData'=>$result['msg']]);
        }else{
            return response()->json(['StatusCode'=> 400,'ResultData'=>$result['msg']]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //

    }

    /**
     * 显示列表页
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 张洵之
     */
    public function show($id)
    {
        $id = (int)$id;
        if($id>7||$id<0) return view("errors.503");
        $data = self::$crowdFundingServer->dynamicDataList($id,self::$request);
        return view("home.crowdfunding.list",["data"=>$data["msg"]]);
    }

    /**
     * 显示详情页
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 张洵之
     */
    public function edit($id)
    {
        $id = (int)$id;
        $data = self::$crowdFundingServer->crowdContent($id);
        if(!$data["status"]) return view("errors.503");
        return view('home.crowdfunding.details',["data"=>$data["msg"]]);
    }

    /**
     * 参与众筹
     * @param $project_id
     * @return \Illuminate\Http\JsonResponse
     * author 张洵之
     */
    public function update($project_id)
    {
        //
        $result = self::$crowdFundingServer->insertCapital($project_id,self::$request);
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
     * 输入参与金额页
     * @param $project_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * author 张洵之
     */
    public function investment($project_id)
    {
        return view("home.crowdfunding.investment",["project_id"=>$project_id]);
    }
}
