<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
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
                        if (!$chage['status']){
                            Log::info("普通用户第一次请求更改活动状态失败".$v->guid.':'.$chage['msg']);
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
     * @param
     * @return array
     * @author 张洵之
     */
    public function store(Request $request)
    {
        $data = $request -> all();
        $result = self::$actionServer -> insertData($data);
        if($result["status"]) return response() -> json(['StatusCode' => 200,'ResultData' => $result['msg']]);
        return response() -> json(['StatusCode'=> 400,'ResultData' => $result['msg']]);
    }

    /**
     * 拿取一条活动信息详情
     * @param
     * @return array
     * @author 张洵之
     */
    public function show($id)
    {
        $result = self::$actionServer -> getData($id);
        if($result["status"]) return response() -> json(['StatusCode' => 200,'ResultData' => $result['msg']]);
        return response() -> json(['StatusCode'=> 400,'ResultData' => $result['msg']]);
    }

    /**
     * 修改活动+报名状态
     *
     * @author 活动：张洵之 报名：郭庆
     */
    public function edit(Request $request, $id)
    {
        $status = $request -> input("status");
        $result = self::$actionServer -> changeStatus($id,$status);
        if($result["status"]) return response() -> json(['StatusCode' => 200,'ResultData' => $result['msg']]);
        return response() -> json(['StatusCode'=> 400,'ResultData' => $result['msg']]);
    }

    /**
     * 更改活动信息内容
     * author 张洵之
     */
    public function update(Request $request, $id)
    {
        $data = $request -> all();
        $where = ["guid" => $id];
        $result = self::$actionServer -> upDta($where, $data);
        if($result["status"]) return response() -> json(['StatusCode' => 200, 'ResultData' => $result['msg']]);
        return response() -> json(['StatusCode' => 400, 'ResultData' => $result['msg']]);
    }

    /**
     * 获取报名情况表信息
     * author 张洵之
     */
    public function destroy($id)
    {
        $result = self::$actionServer -> getOrderInfo($id);
        if($result["status"]) return response() -> json(['StatusCode' => 200, 'ResultData' => $result['msg']]);
        return response() -> json(['StatusCode' => 400, 'ResultData' => $result['msg']]);
    }

    /**
     * 上传图片
     *
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public function upload()
    {
        $file = Input::file('Filedata');
        if($file->isValid()){
            $realPath = $file->getRealPath();//临时文件的绝对路径
            $extension = $file->getClientOriginalName();//上传文件的后缀
            $hz = explode('.', $extension)[1];
            $newName = date('YmdHis').mt_rand(100,999).'.'.$hz;
            $path = $file->move(public_path('uploads/image/admin/road'), $newName);
            $result = 'uploads/image/admin/road/'.$newName;
            return response()->json(['res' => $result]);
        }
    }
}
