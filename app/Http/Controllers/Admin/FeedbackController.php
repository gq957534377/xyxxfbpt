<?php

namespace App\Http\Controllers\Admin;

use App\Services\FeedbackService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{

    protected static $feedbackService = null;
    // 构造函数注入服务
    public function __construct(FeedbackService $feedbackService)
    {
        self::$feedbackService = $feedbackService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.webadminstrtion.feedback');
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
        $url = '/feedback/1';
        if ($request['nowPage']) {
            $page = $request['nowPage'];
        } else {
            $page = 1;
        }

        return self::$feedbackService->getFeedbackList($page, $forPages, $url);
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
        $result = self::$feedbackService->delFeedback($request['iparr']);
        return $result;
    }
}
