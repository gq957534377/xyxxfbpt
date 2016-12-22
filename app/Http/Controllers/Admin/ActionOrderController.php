<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;
use App\Http\Controllers\Controller;
use App\Services\ActionService as ActionServer;

class ActionOrderController extends Controller
{
    protected  static $actionServer;
    public function __construct(ActionServer $actionServer)
    {
        self::$actionServer = $actionServer;
    }

    /**
     * 报名列表页
     * @param $request
     * @return [] 活动详情
     * @author 郭庆
     */
    public function index(Request $request)
    {
        $id = $request->get('id');
        $list = (int)$request->get('list');

        $result = self::$actionServer -> getData($id,$list);
        return view('admin.action.actionOrder',$result);
    }

    /**
     * 获取分页数据
     * @param
     * @return array
     * @author 郭庆
     * @modify 郭庆
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $nowPage = isset($data["nowPage"]) ? (int)$data["nowPage"]:1;//获取当前页
        $forPages = 1;//一页的数据条数
        $where = [];

        if($data["status"]){
            $where["status"] = (int)$data["status"];
        }
        if ($data['action_id']){
            $where["action_id"] = $data['action_id'];
        }

        $result = self::$actionServer->getOrderInfo($where, $nowPage, $forPages, 'action_order/create');

        return response() -> json($result);
    }

    /**
     * 获取分页数据
     * @param $request
     * @return array
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $data = $request -> all();
        $result = self::$actionServer -> insertData($data);
        return response() -> json($result);
    }

    /**
     * 拿取一条活动信息详情
     * @param $id 活动id
     * @return array
     * @author 郭庆
     */
    public function show($id)
    {
        $result = self::$actionServer -> getData($id);
        return response() -> json($result);
    }

    /**
     * 修改活动+报名状态
     * @param $request
     * @param $id 活动id/报名记录id
     * @author 郭庆
     */
    public function edit(Request $request, $id)
    {
        $status = $request -> input("status");
        $result = self::$actionServer -> changeStatus($id,$status);
        return response() -> json($result);
    }

    /**
     * 更改活动信息内容
     * @param $request
     * @param $id 所要修改的活动id
     * author 郭庆
     */
    public function update(Request $request, $id)
    {
        $data = $request -> all();
        $where = ["guid" => $id];
        $result = self::$actionServer -> upDta($where, $data);
        return response() -> json($result);
    }

    /**
     * 获取报名情况表信息
     * @param $id 活动id
     * @return array
     * author 郭庆
     */
    public function destroy($id)
    {
        $result = self::$actionServer -> getOrderInfo($id);
        return response() -> json($result);
    }

    /**
     * 返回活动发布视图
     * @return view
     * @author 郭庆
     */
    public function actionAdd()
    {
        return view('admin.action.add');
    }
    /**
     * 返回活动修改视图
     * @param $id 活动id
     * @return view
     * @author 郭庆
     */
    public function actionChange($id)
    {
        return view('admin.action.edit');
    }
    /**
     * 返回报名列表管理视图
     * @param $id 活动id
     * @return view
     * @author 郭庆
     */
    public function actionOrder($id)
    {
        return view('admin.action.order');
    }
}
