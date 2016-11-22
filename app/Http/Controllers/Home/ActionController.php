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
     *
     * @param  int  $id
     * @author 郭庆
     */
    public function show($id)
    {
        $session = self::$request -> session() -> all();
        $data = self::$actionServer -> getData($id);
        $result = self::$actionServer -> getCommentLike($id);
        if($data["status"]){
            if (!isset($session['user'])){
                $isHas = false;
            }else{
                $action = self::$actionServer -> getAction($session['user'] -> guid);
                $isHas = in_array($data["msg"]["data"][0] -> guid, $action);
            }
            if (!$result['status'])
                return view("home.action.xiangqing",["data" => $data["msg"]["data"][0], 'session' => $session, 'id' => $id, 'isHas' => $isHas, 'comment' => $result['msg'], 'like' => $result['msg']]);
                foreach ($result['msg'][0] as $v)
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
                return view("home.action.xiangqing", ["data" => $data["msg"]["data"][0], 'session' => $session, 'id' => $id, 'isHas' => $isHas, 'comment' => $result['msg'][0], 'like' => $result['msg'][1]]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = self::$request -> all();
        $result = self::$actionServer -> like($id, $field['temp']);
        if($result['status']) return ['StatusCode' => 200,  'ResultData' => $result['msg']];
        return ['StatusCode' => 400, 'ResultData' => $result['msg']];;
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
