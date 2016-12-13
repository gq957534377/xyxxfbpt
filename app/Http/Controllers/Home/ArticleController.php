<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use Validator;
use App\Http\Controllers\Controller;
use App\Services\ArticleService as ArticleServer;
use App\Services\UserService as UserServer;

class ArticleController extends Controller
{
    protected  static $articleServer;
    protected  static $userServer;
    public function __construct(ArticleServer $articleServer, UserServer $userServer)
    {
        self::$articleServer = $articleServer;
        self::$userServer = $userServer;
    }
    /**
     * 根据所选文章类型导航，返回相应的列表页+数据.
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function index(Request $request)
    {
        $type = $request['type'];
        $result = self::$articleServer -> selectByType($type);
        if ($result['status']) return view('home.article.index', ['msg' => $result['msg'], 'type' => $type]);
        return view('home.article.index', ['msg' => $result['msg'], 'type' => $type]);
    }

    /**
     * 添加评论
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function create(Request $request)
    {
        $data = $request -> all();
        $result = self::$articleServer -> comment($data);
        if(!$result['status']) return response() -> json(['StatusCode' => 400, 'ResultData' => $result['msg']]);
        return response() -> json(['StatusCode' => 200, 'ResultData' => $result['msg']]);
    }

    /**
     * Store a newly created resource in storage.
     * 向文章表插入数据
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $data = $request -> all();
        $result = self::$articleServer -> articleOrder($data);
        if(!$result['status']) return response() -> json(['StatusCode' => 400, 'ResultData' => $result['msg']]);
        return response() -> json(['StatusCode' => 200, 'ResultData' => $result['msg']]);
    }

    /**
     * 详情页.
     * 传入： 文章详情$datas 登录状态$isLogin 点赞数量$likeNum
     * @param  int  $id
     * @author 郭庆
     */
    public function show(Request $request, $id)
    {
        //所需要数据的获取
        $session = $request -> session() -> all();
        if($request->input('type')==3) {
            $user = 2;
        }else{
            $user = 1;
        }
        $data = self::$articleServer -> getData($id,$user);//文章详情
        $likeNum = self::$articleServer-> getLikeNum($id);//支持/不支持人数
        //$isHas（是否已经登陆参加）的设置
        if (!isset($session['user'])){
            $isLogin = false;
        }else{
            $isLogin = $session['user']->guid;
        }

        //$datas文章详情设置
        $datas = $data["msg"];

        //返回详情页
        return view("home.article.xiangqing", [
            "data" => $data["msg"],
            'isLogin' => $isLogin,
            'likeNum' => $likeNum['msg']
        ]);
    }

    /**
     * 点赞
     * @param $request
     * @param $id
     * @return array
     * @author 郭庆
     */
    public function edit(Request $request, $id)
    {
        $support = $request -> all();
        if (empty(session('user'))) {
            return view('home.login');
        }
        $user_id = session('user')->guid;

        //判断是否点赞了
        $isHas = self::$articleServer->getLike($user_id, $id);

        if($isHas['status']) {
            if ($isHas['msg']->support == 1) {
                $setLike = self::$articleServer->chargeLike($user_id, $id, ['support' => 2]);
            } else {
                $setLike = self::$articleServer->chargeLike($user_id, $id, ['support' => 1]);
            }

            if ($setLike) return ['StatusCode' => '200',  'ResultData' => self::$articleServer-> getLikeNum($id)['msg']];
            return ['StatusCode' => '400',  'ResultData' => '点赞失败'];
        }else{

            //没有点赞则加一条新记录
            $result = self::$articleServer -> setLike(['support' => 1, 'action_id' => $id, 'user_id' => $user_id]);
            if($result['status']) return ['StatusCode' => '200',  'ResultData' => self::$articleServer-> getLikeNum($id)['msg']];
            return ['StatusCode' => '400', 'ResultData' => '点赞失败'];
        }
    }

    /**
     * 展示评论
     * @param $id
     * @return array
     *
     * @author 郭庆
     */
    public function update($id)
    {
        $result = self::$articleServer -> getComment($id);
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

    /**
     * 新增评论
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 王通
     */
    public function setComment (Request $request)
    {
        // 验证参数
        $validator = Validator::make($request->all(), [
            'content' => 'required|max:150',
            'action_id' => 'required',
        ], [
            'content.required' => '评论内容不能为空',
            'action_id.required' => '非法请求',
            'content.max' => '评论过长',
        ]);

        if ($validator->fails()) {
            return response()->json(['StatusCode' => '400','ResultData' => $validator->errors()->all()]);
        }
        $data = $request->all();

        $data['user_id'] = session('user')->guid;
        $result = self::$articleServer->comment($data);
        $comment = self::$articleServer->getComment($data['action_id'], 1);
        // 判断有没有请求道评论数据
        if ($comment['StatusCode'] == '200') {
            $result['ResultData'] = $comment['ResultData'][0];
        } else {
            return response()->json(['StatusCode' => '201', 'ResultData' => '数据出错']);
        }

        return response()->json($result);
    }
}
