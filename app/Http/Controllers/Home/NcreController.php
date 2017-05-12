<?php

namespace App\Http\Controllers\Home;

use App\Store\NcreStore;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NcreController extends Controller
{
    private static $ncreStore;

    public function __construct(NcreStore $ncreStore)
    {
        self::$ncreStore = $ncreStore;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.study.ncre');
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
     * 说明: 根据身份证号，姓名调用接口查询成绩
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        if (empty($data['XM']) || empty($data['ZJH'])) return response()->json(['StatusCode' => '400', 'ResultData' => '缺少参数']);
        $result = self::$ncreStore->getOneData(['zjh' => $data['ZJH']]);
        if(empty($result)) return response()->json(['StatusCode' => '400', 'ResultData' => '不存在该记录']);
        else return response()->json(['StatusCode' => '200', 'ResultData' => $result]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
