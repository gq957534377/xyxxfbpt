<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\OpenIMService;
use App\Services\FeedbackService;
use Validator;
use App\Services\SafetyService;

class OpenIMController extends Controller
{

    protected static $openim;
    protected static $feedback;
    protected static $safetyService;
    /**
     * 单例引入
     * OpenIMService constructor.
     * @param OpenIMStore $openim
     */
    public function __construct(
        OpenIMService $openim,
        FeedbackService $feedback,
        SafetyService $safetyService)
    {
        self::$openim = $openim;
        self::$feedback = $feedback;
        self::$safetyService = $safetyService;
    }
    /**
     * OpenIM 阿里云旺+千牛聊天工具
     *
     * @return \Illuminate\Http\Response
     * @author 王通
     */
    public function index()
    {
        $resultCookie = \App\Tools\Common::checkCookie('feedback', '联系客服');
        if ($resultCookie != 'ok') return $resultCookie;
        // 判断用户是否登录，如果未登录则临时生成一个随机数，账号密码写入OpenIM服务器以便用户登录使用
        if (!empty(session('user')->guid)) {
            $uid = session('user')->guid;
            $nick = session('user')->tel;
            $icon_url = session('user')->headpic ? session('user')->headpic : null;
            $mobile = session('user')->tel;
        } else {
            return response()->json(['StatusCode' => '400', 'ResultData' => '请先登录！']);
        }

        $res = self::$openim->getOpenIM($uid, $nick, $icon_url, $mobile);
        return response()->json($res);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home.public.openimLeft');
    }

    /**
     * 意见反馈
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $resultCookie = \App\Tools\Common::checkCookie('feedback', '意见反馈');
        if ($resultCookie != 'ok') return response()->json($resultCookie);
        $ip = $request->getClientIp();

        if (self::$safetyService->checkIpInSet(SET_FEEDBACK_IP . date('Y-m-d', time()), $ip)) {
            return ['StatusCode' => '400','ResultData' => '谢谢支持，您已经提过意见了，请明天再来'];
        };
        // 验证过滤数据
        $validator = Validator::make($request->all(), [
            'description' => 'required|max:400',
            'fb_email' => 'email',
        ], [
            'description.required' => '意见不能为空',
            'description.max' => '意见最长为400个字符',
            'fb_email.email' => '联系方式必须为邮箱，或者匿名投稿',

        ]);

        if ($validator->fails()) return response()->json(['StatusCode' => '400','ResultData' => $validator->errors()->all()]);
        $result = self::$feedback->saveFeedback(['description' => $request['description'], 'fb_email' => $request['fb_email'], 'ip' => $ip]);
        return response()->json($result);
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
        //
    }
}
