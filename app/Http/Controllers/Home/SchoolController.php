<?php

namespace App\Http\Controllers\Home;

use App\Services\ActionService;
use App\Store\ActionOrderStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\CommentAndLikeService as CommentServer;

class SchoolController extends Controller
{
    protected  static $actionServer;
    protected  static $commentServer;
    protected  static $actionOrderStore;
    public function __construct(
        ActionService $actionServer,
        CommentServer $commentServer,
        ActionOrderStore $actionOrderStore)
    {
        self::$actionServer = $actionServer;
        self::$commentServer = $commentServer;
        self::$actionOrderStore = $actionOrderStore;
    }
    /**
     * 根据所选英雄学院类型导航，返回相应的列表页+数据.
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function index(Request $request)
    {
        // 获取活动类型 -> 活动类型的对应状态的所有数据
        $data = $request->all();
        $where = [];
        if (!empty($data['type'])){
            $where['type'] = $data['type'];
        }
        if (!empty($data['status'])){
            $where['status'] = $data['status'];
        }
        $nowPage = 1;
        $result = self::$actionServer->selectData($where, $nowPage, 4, '/school', true, false);

        if($result["StatusCode"] == '200'){
            foreach ($result['ResultData']['data'] as $v){
                $status = self::$actionServer->setStatusByTime($v);
                if ($status['status']){
                    if (!is_string($status['msg'])){
                        $chage = self::$actionServer->changeStatus($v->guid, $status['msg'], 3);
                        if ($chage['StatusCode'] != '200'){
                            Log::info("用户第一次请求更改活动状态失败".$v->guid.':'.$chage['ResultData']);
                        }else{
                            $v->status = $status['msg'];
                        }
                    }
                }
            }
        }
        if (!empty($data['status'])){
            $result['status'] = (int)$data['status'];
        }else{
            $result['status'] = '204';
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
    public function create(Request $request)
    {
        // 获取活动类型 -> 活动类型的所有数据
        // 获取活动类型 -> 活动类型的所有数据
        if ($request->status != 204 && !empty($request->status)){
            $where = ['type'=> $request->type, 'status' => $request->status];
        }else{
            $where = ['type'=> $request->type];
        }
        $nowPage = isset($request->nowPage) ? (int)$request->nowPage:1;//获取当前页
        $result = self::$actionServer->selectData($where, $nowPage, 4, '/school', true, false);

        if($result["StatusCode"] == '200'){
            foreach ($result['ResultData']['data'] as $v){
                $status = self::$actionServer->setStatusByTime($v);
                if ($status['status']){
                    if (!is_string($status['msg'])){
                        $chage = self::$actionServer->changeStatus($v->guid, $status['msg'], $where['type']);
                        if ($chage['StatusCode'] != '200'){
                            Log::info("管理员用户第一次请求更改活动状态失败".$v->guid.':'.$chage['ResultData']);
                        }else{
                            $v->status = $status['msg'];
                        }
                    }
                }
            }
        }
        return response()->json($result);
    }

    /**
     * 英雄学院详情页.
     * @return array ：是否已经报名$isHas 活动详情$datas 登录状态$isLogin 点赞数量$likeNum 所有评论$comment+对应用户的信息
     * @param $request
     * @param $id
     * @author 郭庆
     */
    public function show($id)
    {
        //所需要数据的获取
        $data = self::$actionServer->getData($id,3);//活动详情
        if ($data['StatusCode'] == '200' && (int)$data['ResultData']->status == 4){
            $data['StatusCode'] = '400';
            $data['ResultData'] = '该活动已被删除';
        }
        if ($data['StatusCode'] == '404'){
            return view('errors.404');
        }
//        $likeNum = self::$commentServer->likeCount($id);//点赞人数
        $commentData = self::$commentServer->getComent($id,1);//评论数据
        $pageStyle = self::$commentServer->getPageStyle($id, 1);//分页样式
        //$isHas（是否已经报名参加）的设置
        if (!!empty(session('user')->guid)){
            $isLogin = false;
            $isHas = false;
            $likeStatus = 2;
        }else{
//            $likeStatus = self::$commentServer->likeStatus(session('user')->guid, $id);//当前用户点赞状态
            $action = self::$actionOrderStore->getSomeField(['user_id'=>session('user')->guid], 'action_id');//当前用户报名参加的所有活动
            if (!$action){
                $isHas = false;
            }else{
                $isHas = in_array($id, $action);
            }

            $isLogin = session('user')->guid;
        }

        $rand = self::$actionServer->getRandomActions(false);
        //返回详情页
        return view("home.action.details", [
            "list" => 3,
            "data" => $data,
            'isLogin' => $isLogin,
            'isHas' => $isHas,
//            'likeNum' => $likeNum,
//            'likeStatus' => $likeStatus,
            'comment' => $commentData,
            'contentId' => $id,
            'rand' => $rand,
            'pageStyle' => $pageStyle
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
