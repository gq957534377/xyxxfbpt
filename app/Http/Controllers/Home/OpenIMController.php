<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\OpenIMService;

class OpenIMController extends Controller
{

    protected static $openim;
    /**
     * 单例引入
     * OpenIMService constructor.
     * @param OpenIMStore $openim
     */
    public function __construct(OpenIMService $openim)
    {
        self::$openim = $openim;
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
