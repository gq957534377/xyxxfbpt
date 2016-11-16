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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
    public function store(Request $request)
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
