<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tools\ExtCurl;

class JisuanjiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.study.jisuanji');
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

        $header = array(
            'Referer: http://tyfishing.cn/sxuncre.aspx',
            'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:49.0) Gecko/20100101 Firefox/49.0',
            'Charset=utf-8',
            'X-Requested-With: XMLHttpRequest'
        );

        $result = ExtCurl::request('http://tyfishing.cn/NCRE.aspx?action=getCJ&ZJH=' . $data['ZJH'] . '&XM=' . $data['XM'], 'GET', null, false, '', $header, 'http://tyfishing.cn/sxuncre.aspx');
//dd($result);
        if (strlen($result) > 100) return response()->json(['StatusCode' => '500', 'ResultData' => '远程服务端出错']);

        return response()->json(['StatusCode' => '200', 'ResultData' => json_decode($result)]);
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
