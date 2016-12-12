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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = 3;
        $result = self::$actionServer->actionTypeData($type);
        if($result["StatusCode"] == '200'){
            foreach ($result['ResultData'] as $v){
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
            return view('home.school.index', ['schooldata' => $result['ResultData']]);
        }
        return view('home.school.index');
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
