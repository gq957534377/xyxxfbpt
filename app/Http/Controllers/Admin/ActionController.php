<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;
use App\Http\Controllers\Controller;
use App\Services\ActionService as ActionServer;

class ActionController extends Controller
{
    protected  static $actionServer;
    public function __construct(ActionServer $actionServer)
    {
        self::$actionServer = $actionServer;
    }

    /**
     * 活动后台首页
     * @param
     * @return 活动管理页面
     * @author 张洵之
     */
    public function index()
    {
        return view('admin.action.index');
    }

    /**
     * 获取分页数据
     * @param
     * @return array
     * @author 张洵之
     * @modify 郭庆
     */
    public function create(Request $request)
    {
        $result = self::$actionServer -> selectData($request);
        if($result["status"]){
            foreach ($result['msg']['data'] as $v){
                $status = self::$actionServer->setStatusByTime($v);
                if ($status['status']){
                    if (!is_string($status['msg'])){
                        $chage = self::$actionServer->changeStatus($v->guid, $status['msg']);
                        if ($chage['StatusCode'] != 200){
                            Log::info("普通用户第一次请求更改活动状态失败".$v->guid.':'.$chage['ResultData']);
                        }else{
                            $v->status = $status['msg'];
                        }
                    }
                }
            }
            return response() -> json(['StatusCode' => 200,'ResultData' => $result['msg']]);
        }
        return response() -> json(['StatusCode' => 400,'ResultData' => $result['msg']]);
    }

    /**
     * 获取分页数据
     * @param $request
     * @return array
     * @author 张洵之
     * @modifif 郭庆
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
     * @author 张洵之
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
     * @author 活动：张洵之 报名：郭庆
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
}
