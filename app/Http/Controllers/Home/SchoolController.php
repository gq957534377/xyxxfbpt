<?php

namespace App\Http\Controllers\Home;

use App\Services\ActionService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\CommentAndLikeService as CommentServer;
use App\Services\UserService as UserServer;

class SchoolController extends Controller
{
    protected  static $actionServer;
    protected  static $userServer;
    protected  static $commentServer;
    public function __construct(ActionService $actionServer, UserServer $userServer, CommentServer $commentServer)
    {
        self::$actionServer = $actionServer;
        self::$userServer = $userServer;
        self::$commentServer = $commentServer;
    }
    /**
     * 根据所选活动类型导航，返回相应的列表页+数据.
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     * @modify 张洵之
     */
    public function index(Request $request)
    {
        // 获取活动类型 -> 活动类型的对应状态的所有数据
        $data = $request->all();
        $where = [];
        if (isset($data['type'])){
            $where['type'] = $data['type'];
        }
        if (isset($data['status'])){
            $where['status'] = $data['status'];
        }
        $nowPage = 1;
        $result = self::$actionServer->selectData($where, $nowPage, 10, '/action', true, false);

        if($result["StatusCode"] == 200){
            foreach ($result['ResultData']['data'] as $v){
                $status = self::$actionServer->setStatusByTime($v);
                if ($status['status']){
                    if (!is_string($status['msg'])){
                        $chage = self::$actionServer->changeStatus($v->guid, $status['msg'], 3);
                        if ($chage['StatusCode'] != 200){
                            Log::info("管理员用户第一次请求更改活动状态失败".$v->guid.':'.$chage['ResultData']);
                        }else{
                            $v->status = $status['msg'];
                        }
                    }
                }
            }
        }
        if (isset($data['status'])){
            $result['status'] = (int)$data['status'];
        }else{
            $result['status'] = 204;
        }
        $result['type'] = $data['type'];
        $result['nowPage'] = $nowPage;
        return view('home.school.index', $result);
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
    /**
     * 详情页.
     * @return array ：是否已经报名$isHas 活动详情$datas 登录状态$isLogin 点赞数量$likeNum 所有评论$comment+对应用户的信息
     * @param $request
     * @param $id
     * @author 郭庆
     *@modify 张洵之
     */
    public function show($id)
    {
        //所需要数据的获取
        $data = self::$actionServer->getData($id,3);//活动详情
        $likeNum = self::$commentServer->likeCount($id);//点赞人数
        $commentData = self::$commentServer->getComent($id,1);//评论数据
        //$isHas（是否已经报名参加）的设置
        if (!isset(session('user')->guid)){
            $isLogin = false;
            $isHas = false;
            $likeStatus = 2;
        }else{
            $likeStatus = self::$commentServer->likeStatus(session('user')->guid, $id);//当前用户点赞状态
            $action = self::$actionServer->getAction('action_id', ['user_id'=>session('user')->guid]);//当前用户报名参加的所有活动
            $isLogin = session('user')->guid;
            if ($action['status']){
                $isHas = in_array($data["ResultData"]->guid, $action['msg']);
            }else{
                $isHas = false;
            }
        }

        //返回详情页
        return view("home.action.details", [
            "data" => $data["ResultData"],
            'isLogin' => $isLogin,
            'isHas' => $isHas,
            'likeNum' => $likeNum,
            'likeStatus' => $likeStatus,
            'comment' => $commentData,
            'contentId' => $id
        ]);
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
