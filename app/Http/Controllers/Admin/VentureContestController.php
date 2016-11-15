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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author maolin
     */
    public function store(Request $request)
    {
        // Data validation
        $validator = Validator::make($request->all(), [
            "name" =>'required',
            "order"=>'required|digits_between:1,3',
            "org"  =>'required',
            //"content"=>'required',
            "peoples"=>'required|digits_between:1,50',
            "start_time"=>'required',
            "end_time"  =>'required',
            "deadline"  =>'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['ServerNo' => 400,'ResultData' => $validator->errors()->all()]);
        }
        // 开始进行数据插入
        $result = self::$matchServer->insert($request->all());
//        return $result;
        if(!$result) return response()->json(['status'=>'400','msg'=>'发布失败']);
        return response()->json(['status'=>'200','msg'=>'发布成功']);
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
        $result=self::$matchServer->getPageData($id);
        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 从后台获取一条数据
        $result = self::$matchServer->getOntData($id);
        return $result;
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
        return $request->all();
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
    }

}
