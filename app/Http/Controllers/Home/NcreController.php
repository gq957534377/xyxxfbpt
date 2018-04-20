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
    public function index(Request $request)
    {
        \Log::info('ncre访问者IP' . $request->getClientIp() . '来源:'.$this->getLocation($request->getClientIp()));
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

    /**
     * 说明:获取ip地址
     *
     * @param string $ip
     * @return string
     * @author 王浩
     */
    public function getLocation($ip = '')
    {
        empty($ip) && $ip = getip();
        if ($ip == "127.0.0.1") return "本机地址";
        $api = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=$ip";
        $json = @file_get_contents($api);//调用新浪IP地址库
        $arr = json_decode($json, true);//解析json
        $country = $arr['country']; //取得国家
        $province = $arr['province'];//获取省份
        $city = $arr['city']; //取得城市
        if ((string)$country == "中国") {
            if ((string)($province) != (string)$city) {
                $_location = $province . $city;
            } else {
                $_location = $country . $city;
            }
        } else {
            $_location = $country;
        }
        return $_location;
    }
}
