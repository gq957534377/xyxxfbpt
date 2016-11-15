<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Services\MatchService;
use Illuminate\Support\Facades\Validator;

class VentureContestController extends Controller
{
    protected static $matchServer = null;
    public function __construct(MatchService $matchServer)
    {
        self::$matchServer = $matchServer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function index()
    {
        //
        return view('admin.match.infomatch');
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
     * 发布创业大赛
     * @param Request $request
     * @return bool
     * @author 茂林
     */
    public function store(Request $request)
    {
        // Data validation
         return $result=$request->all();
        if($result) return 1;
        if(!$result) return 2;
        return 3;
        $validator = Validator::make($request->all(), [
            "name" =>'required',
            "order"=>'required|digits_between:1,3',
            "org"  =>'required',
            "title"=>'required',
            "content"=>'required',
            "peoples"=>'required|digits_between:1,50',
            "start_time"=>'required',
            "end_time"  =>'required',
            "deadline"  =>'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['ServerNo' => 400,'ResultData' => $validator->errors()->all()]);
        }
        return $request->all();
        $result = self::$matchServer->insert($request->all());
        if(!$result) return response()->json(['status'=>'400','msg'=>'插入失败']);
        return response()->json(['status'=>'200','msg'=>'插入成功']);
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
        // 删除数据
        $result = self::$matchServer->deleteOne($id);
        return $result;
    }
    public function paging(Request $request)
    {
        // 跟去前台传过来的数据显示数据
        $result=self::$matchServer->getPageData("1");
        return $result;
    }

}
