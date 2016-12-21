<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\ActionService as ActionServer;
use App\Services\UserService as UserServer;

class SchoolController extends Controller
{
    protected  static $actionServer;
    protected  static $userServer;
    public function __construct(ActionServer $actionServer, UserServer $userServer)
    {
        self::$actionServer = $actionServer;
        self::$userServer = $userServer;
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
        $result = self::$actionServer->selectData($where, $nowPage, 10, '/action', false);

        if($result["StatusCode"] == 200){
            foreach ($result['ResultData']['data'] as $v){
                $status = self::$actionServer->setStatusByTime($v);
                if ($status['status']){
                    if (!is_string($status['msg'])){
                        $chage = self::$actionServer->changeStatus($v->guid, $status['msg']);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
