<?php
/**
 * 后台用户控制器
 * @author wangfeilong
 */
namespace App\Http\Controllers\Admin;

use App\Services\UserService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected static $userServer = null;
    // 构造函数注入服务
    public function __construct(UserService $userService)
    {
        self::$userServer = $userService;
    }

    /**
     * 显示 不同类型用户列表
     *
     * @return \Illuminate\Http\Response
     * @author 王飞龙
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $role = $data['role'];
        switch ($role){
            // 待审核用户
            case "0":
//                $result = self::$userServer->getUserList($role);
//                // 如果$result返回错误
//                if(!$result['status'])
//                    return response()->json(['StatusCode' => 400, 'ResultData' => $result['msg']]);
//
//                return response()->json(['StatusCode' => 200, 'ResultData' => $result]);

               /************************************************/

                $result = self::$userServer->getUserList($role);
                return view('admin.user.checkingUserList', ['data' => $result]);
            // 普通用户
            case "1":
                $result = self::$userServer->getUserList($role);
                return view('admin.user.normalUserList', ['data' => $result]);
            // 创业者用户
            case "2":
                $result = self::$userServer->getUserList($role);
                return view('admin.user.entrepreneursUserList', ['data' => $result]);
            // 其它请求
            default:
                return redirect('/');
        }
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
