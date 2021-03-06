<?php

namespace App\Http\Controllers\Home;

use App\Redis\ActionCache;
use App\Store\ActionOrderStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\ActionService as ActionServer;
use App\Services\UserService as UserServer;
use App\Services\CommentAndLikeService as CommentServer;

class ActionController extends Controller
{
    protected  static $actionServer;
    protected  static $userServer;
    protected  static $commentServer;
    protected  static $actionOrderStore;
    protected  static $actionCache;
    public function __construct(
        ActionServer $actionServer,
        UserServer $userServer,
        CommentServer $commentServer,
        ActionOrderStore $actionOrderStore,
        ActionCache $actionCache
    )
    {
        self::$actionServer = $actionServer;
        self::$userServer = $userServer;
        self::$commentServer = $commentServer;
        self::$actionOrderStore = $actionOrderStore;
        self::$actionCache = $actionCache;
    }
    /**
     * 根据所选活动类型导航，返回相应的列表页+数据.
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
        $result = self::$actionServer->selectData($where, $nowPage, 5, '/action/create');

        if($result["StatusCode"] == '200'){
            foreach ($result['ResultData']['data'] as $v){
                $status = self::$actionServer->setStatusByTime($v);
                if ($status['status']){
                    if (!is_string($status['msg'])){
                        $chage = self::$actionServer->changeStatus($v->guid, $status['msg']);
                        if ($chage['StatusCode'] != '200'){
                            Log::info("管理员用户第一次请求更改活动状态失败".$v->guid.':'.$chage['ResultData']);
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

//        dd($result);
        return view('home.action.index', $result);
    }

    /**
     * 后续ajax请求分页数据
     * @param $request
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function create(Request $request)
    {
        $data = $request->all();
        // 获取活动类型 -> 活动类型的所有数据
        if (!empty($data['status']) && $data['status'] != 204){
            $where = ['type'=> $data['type'], 'status' => $data['status']];
        }else{
            $where = ['type'=> $data['type']];
        }

        $nowPage = $data['nowPage'];//获取当前页
        $result = self::$actionServer->selectData($where, $nowPage, 5, '/action/create');

        if($result["StatusCode"] == '200'){
            foreach ($result['ResultData']['data'] as $v){
                $status = self::$actionServer->setStatusByTime($v);
                if ($status['status']){
                    if (!is_string($status['msg'])){
                        $chage = self::$actionServer->changeStatus($v->guid, $status['msg']);
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
     *
     * @param
     * @return array
     * @author 郭庆
     */
    public function store(Request $request)
    {

    }

    /**
     * 详情页.
     * @return array ：是否已经报名$isHas 活动详情$datas 登录状态$isLogin 点赞数量$likeNum 所有评论$comment+对应用户的信息
     * @param $request
     * @param $id
     * @author 郭庆
     *@modify 杨志宇
     */
    public function show($id)
    {
        //所需要数据的获取
        $data = self::$actionServer->getData($id);//活动详情
        if ($data['StatusCode'] == '200' && (int)$data['ResultData']->status == 4){
            return view('errors.404');
        }
        if ($data['StatusCode'] == '404'){
            return view('errors.404');
        }
        $likeNum = self::$commentServer->likeCount($id);//点赞人数
        $commentData = self::$commentServer->getComent($id,1);//评论数据
        $pageStyle = self::$commentServer->getPageStyle($id, 1);//分页样式
        //$isHas（是否已经报名参加）的设置
        if (empty(session('user')->guid)){
            $isLogin = false;
            $isHas = false;
            $likeStatus = 2;
        }else{
            $likeStatus = self::$commentServer->likeStatus(session('user')->guid, $id);//当前用户点赞状态
            $isHas = self::$actionCache->getOrderActions(session('user')->guid, $id);//当前用户是否报名参加活动
            $isLogin = session('user')->guid;
        }
        $rand = self::$actionServer->getRandomActions();
        //返回详情页
        return view("home.action.details", [
            "list" => 1,
            "data" => $data,
            'isLogin' => $isLogin,
            'isHas' => $isHas,
            'likeNum' => $likeNum,
            'likeStatus' => $likeStatus,
            'comment' => $commentData,
            'contentId' => $id,
            'rand' => $rand,
            'pageStyle' => $pageStyle
        ]);
    }

    /**
     * 点赞
     * @param $request
     * @param $id
     * @return array
     *
     * @author 杨志宇
     */
    public function edit($id,Request $request)
    {
        if(! !empty(session('user')->guid)) return response()->json(['StatusCode' => '401', 'ResultData' => '用户未登录']);

        $type = $request->input('type');
        $result = self::$commentServer->changeLike($id,$type);
        return response()->json($result);
    }

    /**
     *
     * @param
     * @return array
     * @author 郭庆
     */
    public function update($id)
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
