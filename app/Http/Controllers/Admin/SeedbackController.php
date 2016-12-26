<?php

namespace App\Http\Controllers\Admin;

use App\Services\SeedbackService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SeedbackController extends Controller
{

    protected static $seedbackService = null;
    // 构造函数注入服务
    public function __construct(SeedbackService $seedbackService)
    {
        self::$seedbackService = $seedbackService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.webadminstrtion.seedback');
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
     * 取出意见列表数据
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 王通
     */
    public function show($id, Request $request)
    {
        $forPages = 2;
        $url = '/seedback/1';
        if ($request['nowPage']) {
            $page = $request['nowPage'];
        } else {
            $page = 1;
        }

        return self::$seedbackService->getSeedbackList($page, $forPages, $url);
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
     * 删除指定的数据
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 王通
     */
    public function destroy($id, Request $request)
    {

        if (empty($request['iparr'])) {
            return response()->json(['StatusCode' => '400', 'ResultData' => '查询失败']);
        }
        $result = self::$seedbackService->delSeedback($request['iparr']);
        return $result;
    }
}
