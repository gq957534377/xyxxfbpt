<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\OpenIMService;
use App\Services\SeedbackService;
use Illuminate\Support\Facades\Input;
use Validator;

class OpenIMController extends Controller
{

    protected static $openim;
    protected static $seedback;
    /**
     * 单例引入
     * OpenIMService constructor.
     * @param OpenIMStore $openim
     */
    public function __construct(OpenIMService $openim, SeedbackService $seedback)
    {
        self::$openim = $openim;
        self::$seedback = $seedback;
    }
    /**
     * OpenIM 阿里云旺+千牛聊天工具
     *
     * @return \Illuminate\Http\Response
     * @author 王通
     */
    public function index()
    {
        // 判断用户是否登录，如果未登录则临时生成一个随机数，账号密码写入OpenIM服务器以便用户登录使用
        if (!empty(session('user')->guid)) {
            $uid = session('user')->guid;
            $nick = session('user')->nickname ? session('user')->nickname : session('user')->tel;
            $icon_url = session('user')->headpic ? session('user')->headpic : null;
            $mobile = session('user')->tel;
        } else {
            $uid = time() . '' . mt_rand(1,1000);
            $nick = '游客';
            $icon_url =  null;
            $mobile = null;
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
        //
    }

    /**
     * 意见反馈
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ip = $request->getClientIp();
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
        $result = self::$seedback->saveSeedback(['description' => $request['description'], 'fb_email' => $request['fb_email'], 'ip' => $ip]);
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
