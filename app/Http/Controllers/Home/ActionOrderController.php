<?php

namespace App\Http\Controllers\Home;

use App\Services\UserService;
use App\Store\ActionOrderStore;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Services\ActionService as ActionServer;

class ActionOrderController extends Controller
{
    protected  static $actionServer;
    protected  static $userServer;
    protected  static $actionOrderStore;
    public function __construct(ActionServer $actionServer, UserService $userServer, ActionOrderStore $actionOrderStore)
    {
        self::$actionServer = $actionServer;
        self::$userServer = $userServer;
        self::$actionOrderStore = $actionOrderStore;
    }

    /**
     * 个人中心报名列表页
     * @param $request
     * @return [] 活动详情
     * @author 郭庆
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $list = (int)$data['list'];
        $actions = self::$actionOrderStore->getSomeField(['user_id'=>session('user')->guid], 'action_id');
        $where = [];
        if (!empty($data['type']) && $list != 3){
            $where["type"] = $data['type'];
        }

        if (!empty($data['status'])){
            $where["status"] = (int)$data["status"];
            $status = $data['status'];
        }else{
            $status = 6;
        }
        if (!$actions){
            if ($actions == []){
                return view('home.user.activity.index',['StatusCode' => '204', 'ResultData' => ['list'=>$list, 'status'=>$status, 'data' => "你还未报名参加任何活动"]]);
            }else{
                return view('home.user.activity.index',['StatusCode' => '400', 'ResultData' => ['list'=>$list, 'status'=>$status, 'data' => "获取所报名参加的活动失败"]]);
            }
        }

        $nowPage = !empty($data["nowPage"]) ? (int)$data["nowPage"]:1;//获取当前页
        $forPages = 1;//一页的数据条数

        $result = self::$actionServer->getOrderActions($where, $actions, $nowPage, $forPages, 'action_order/create',$list);
        $result['status'] = $status;
        return view('home.user.activity.index',$result);
    }

    /**
     * 个人中心获取报名参加的活动的列表
     * @param
     * @return array
     * @author 郭庆
     * @modify 郭庆
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $list = (int)$data['list'];
        $actions = self::$actionOrderStore->getSomeField(['user_id'=>session('user')->guid], 'action_id');
        $where = [];
        if (!empty($data['type']) && $list != 3){
            $where["type"] = $data['type'];
        }

        if (!empty($data['status'])){
            $where["status"] = (int)$data["status"];
            $status = $data['status'];
        }else{
            $status = 6;
        }
        if (!$actions){
            if ($actions == []){
                return response() -> json(['StatusCode' => '204', 'ResultData' => ['list'=>$list, 'status'=>$status, 'data' => "你还未报名参加任何活动"]]);
            }else{
                return response() -> json(['StatusCode' => '400', 'ResultData' => ['list'=>$list, 'status'=>$status, 'data' => "获取所报名参加的活动失败"]]);
            }
        }

        $nowPage = !empty($data["nowPage"]) ? (int)$data["nowPage"]:1;//获取当前页
        $forPages = 1;//一页的数据条数
        $where = [];

        if(!empty($data["status"])){
            $where["status"] = (int)$data["status"];
        }
        if (!empty($data['type']) && $list != 3){
            $where["type"] = $data['type'];
        }

        $result = self::$actionServer->getOrderActions($where, $actions, $nowPage, $forPages, 'action_order/create',$list);
        $result['status'] = $status;
        return response() -> json($result);
    }

    /**
     * 向报名表插入数据
     * @param $request
     * @return array
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $result = self::$actionServer->actionOrder($data);
        return response()->json($result);
    }

    /**
     * 拿取一条活动信息详情
     * @param $id 活动id
     * @return array
     * @author 郭庆
     */
    public function show($id)
    {

    }

    /**
     * 修改报名状态
     * @param $request
     * @param $id 活动id/报名记录id
     * @author 郭庆
     */
    public function edit(Request $request, $id)
    {

    }

    /**
     * 更改活动信息内容
     * @param $request
     * @param $id 所要修改的活动id
     * author 郭庆
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * 获取报名情况表信息
     * @param $id 活动id
     * @return array
     * author 郭庆
     */
    public function destroy($id)
    {

    }


}
