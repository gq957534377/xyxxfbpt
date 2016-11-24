<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;
use App\Services\ActionService as ActionServer;
use App\Services\UserService as UserServer;

class ActionController extends Controller
{
    protected static $request;
    protected  static $actionServer;
    protected  static $userServer;
    public function __construct(Request $request, ActionServer $actionServer, UserServer $userServer)
    {
        self::$actionServer = $actionServer;
        self::$request = $request;
        self::$userServer = $userServer;
    }
    /**
     * 根据所选活动类型导航，返回相应的列表页+数据.
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function index()
    {
        $type = self::$request -> all()['type'];
        $result = self::$actionServer -> selectByType($type);
        if ($result['status']) return view('home.action.index', ['msg' => $result['msg']]);
        return view('home.action.index', ['msg' => $result['msg']]);
    }

    /**
     * 添加评论
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = self::$request -> all();
        $result = self::$actionServer -> comment($data);
        if(!$result['status']) return response() -> json(['StatusCode' => 400, 'ResultData' => $result['msg']]);
        return response() -> json(['StatusCode' => 200, 'ResultData' => $result['msg']]);
    }

    /**
     * Store a newly created resource in storage.
     *向活动表插入数据
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function store()
    {
        $data = self::$request -> all();
        $result = self::$actionServer -> actionOrder($data);
        if(!$result['status']) return response() -> json(['StatusCode' => 400, 'ResultData' => $result['msg']]);
        return response() -> json(['StatusCode' => 200, 'ResultData' => $result['msg']]);
    }

    /**
     * 详情页.
     * 传入：是否已经报名$isHas 活动详情$datas 登录状态$isLogin 点赞数量$likeNum 所有评论$comment+对应用户的信息
     * @param  int  $id
     * @author 郭庆
     */
    public function show($id)
    {
        //所需要数据的获取
        $session = self::$request -> session() -> all();
        $data = self::$actionServer -> getData($id);//活动详情
        $likeNum = self::$actionServer-> getLikeNum($id);//支持/不支持人数

        //$isHas（是否已经报名参加）的设置
        if (!isset($session['user'])){
            $isLogin = false;
            $isHas = false;
        }else{
            $action = self::$actionServer -> getAction($session['user'] -> guid);//当前用户报名参加的所有活动
            $isLogin = $session['user']->guid;
            if ($action['status']) $isHas = in_array($data["msg"] -> guid, $action['msg']);
        }

        //$datas活动详情设置
        $datas = $data["msg"];

        //返回详情页
        return view("home.action.xiangqing", [
            "data" => $data["msg"],
            'isLogin' => $isLogin,
            'isHas' => $isHas,
            'likeNum' => $likeNum['msg']
        ]);
    }

    /**
     * 点赞
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $support = self::$request -> all();
        $user_id = self::$request -> session() -> get('user')->guid;

        //判断是否点赞了
        $isHas = self::$actionServer->getLike($user_id,$id);
        if($isHas['status']) {
            if ($isHas['msg']->support == $support['support']) return ['StatusCode' => 400,  'ResultData' => '已经参与'];
            $setLike = self::$actionServer->chargeLike($user_id, $id, $support);

            if ($setLike) return ['StatusCode' => 200,  'ResultData' => self::$actionServer-> getLikeNum($id)['msg']];
            return ['StatusCode' => 400,  'ResultData' => '点赞失败'];
        }else{

            //没有点赞则加一条新记录
            $result = self::$actionServer -> setLike(['support' => $support['support'], 'action_id' => $id, 'user_id' => $user_id]);
            if($result['status']) return ['StatusCode' => 200,  'ResultData' => self::$actionServer-> getLikeNum($id)['msg']];
            return ['StatusCode' => 400, 'ResultData' => '点赞失败'];
        }
    }

    /**
     * 展示评论
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update($id)
    {
        $result = self::$actionServer -> getComment($id);
        if (!$result['status']){
            return ['StatusCode' => 400, 'ResultData' => $result['msg']];
        }else{
            foreach ($result['msg'] as $v)
            {
                $res = self::$userServer -> userInfo(['guid' => $v -> user_id]);
                if($res['status']){
                    $v -> user_name = $res['msg'] -> nickname;
                    $v -> headpic = $res['msg'] -> headpic;
                }else{
                    $v -> user_name = '无名英雄';
                    $v -> headpic = '';
                }
            }
        }
        return ['StatusCode' => 200, 'ResultData' => $result['msg']];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
