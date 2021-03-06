<?php

namespace App\Http\Controllers\Home;

use App\Store\ActionOrderStore;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Services\ActionService as ActionServer;

class ActionOrderController extends Controller
{
    protected static $actionServer;
    protected static $actionOrderStore;

    public function __construct(
        ActionServer $actionServer,
        ActionOrderStore $actionOrderStore)
    {
        self::$actionServer = $actionServer;
        self::$actionOrderStore = $actionOrderStore;
    }

    /**
     * 个人中心我参加的活动的列表页
     * @param $request
     * @return [] 活动详情
     * @author 郭庆
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $actions = self::$actionOrderStore->getSomeField(['user_id' => session('user')->guid], 'action_id');
        if (!empty($data['status'])) {
            $where["status"] = (int)$data["status"];
            $status = $data['status'];
        } else {
            $status = 6;
        }
        $where['type'] = $data['type'];

        if (!$actions) {
            if ($actions == []) {
                return view('home.user.activity.index', ['StatusCode' => '204', 'ResultData' => ['type' => $data['type'], 'status' => $status, 'data' => "你还未报名参加任何活动"]]);
            } else {
                return view('home.user.activity.index', ['StatusCode' => '400', 'ResultData' => ['type' => $data['type'], 'status' => $status, 'data' => "获取所报名参加的活动失败"]]);
            }
        }

        $nowPage = !empty($data["nowPage"]) ? (int)$data["nowPage"] : 1;//获取当前页
        $forPages = 3;//一页的数据条数

        $result = self::$actionServer->getOrderActions($where, $actions, $nowPage, $forPages, 'action_order/create');
        $result['ResultData']['status'] = $status;
        $result['ResultData']['type'] = $data['type'];
        return view('home.user.activity.index', $result);
    }

    /**
     * 个人中心获取报名参加的活动的列表的请求分页
     * @param
     * @return array
     * @author 郭庆
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $actions = self::$actionOrderStore->getSomeField(['user_id' => session('user')->guid], 'action_id');
        $where = [];
        if (!empty($data['type'])) {
            $where["type"] = (int)$data['type'];
        }

        if (!empty($data['status'])) {
            $where["status"] = (int)$data["status"];
            $status = $data['status'];
        } else {
            $status = 6;
        }
        if (!$actions) {
            if ($actions == []) {
                return response()->json(['StatusCode' => '204', 'ResultData' => ['type' => $data['type'], 'status' => $status, 'data' => "你还未报名参加任何活动"]]);
            } else {
                return response()->json(['StatusCode' => '400', 'ResultData' => ['type' => $data['type'], 'status' => $status, 'data' => "获取所报名参加的活动失败"]]);
            }
        }

        $nowPage = !empty($data["nowPage"]) ? (int)$data["nowPage"] : 1;//获取当前页
        $forPages = 3;//一页的数据条数
        $where = [];

        $result = self::$actionServer->getOrderActions($where, $actions, $nowPage, $forPages, 'action_order/create');
        $result['status'] = $status;
        $result['type'] = $data['type'];
        return response()->json($result);
    }

    /**
     * 向活动报名表插入数据
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $result = self::$actionServer->actionOrder($data);
        return response()->json($result);
    }

    /**
     *
     * @param
     * @return array
     * @author 郭庆
     */
    public function show($id)
    {

    }

    /**
     *
     * @param
     * @return array
     * @author 郭庆
     */
    public function edit($id)
    {

    }

    /**
     *
     * @param
     * @return array
     * @author 郭庆
     */
    public function update(Request $request, $id)
    {

    }

    /**
     *
     * @param
     * @return array
     * @author 郭庆
     */
    public function destroy($id)
    {

    }
}
