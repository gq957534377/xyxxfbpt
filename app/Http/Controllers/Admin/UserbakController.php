<?php
/**
 * 后台 针对表data_user_info
 * @author wangfeilong
 */
namespace App\Http\Controllers\Admin;

use App\Services\UserService;
use App\Tools\Common;
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
     * 为不同用户分配不同页面
     * @return \Illuminate\Http\Response
     * @author 王飞龙
     * 经测试，index方法可以带Request $request参数
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $role = $data['role'];
        switch ($role){
            // 待审核用户
            case "0":
                return view('admin.user.checking');
            // 普通用户
            case "1":
                return view('admin.user.normal');
            // 创业者用户
            case "2":
                return view('admin.user.entrepreneurs');
            // 其它情形
            default:
                return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @author wangfeilong
     * 经测试，create方法可以带Request $request参数
     */
    public function create(Request $request)
    {
//        $data = $request->all();
//        dd($data);
//        echo '1111111';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author wangfeilong
     * 经测试，create方法可以带Request $request参数
     */
    public function store(Request $request)
    {
//        $data = $request->all();
//        dd($data);
//        echo '1111111';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author wangfeilong
     * 经测试，create方法可以带Request $request参数
     */
    public function show(Request $request, $id)
    {
//        dd($id);
//        $data = $request->all();
//        dd($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author wangfeilong
     * 经测试，create方法可以带Request $request参数
     */
    public function edit(Request $request, $id)
    {
//        dd($id);
//        $data = $request->all();
//        dd($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author wangfeilong
     * 经测试，create方法可以带Request $request参数
     */
    public function update(Request $request, $id)
    {
//                dd($id);
//        $data = $request->all();
//        dd($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author wangfeilong
     * 经测试，create方法可以带Request $request参数
     */
    public function destroy(Request $request, $id)
    {
//                        dd($id);
//        $data = $request->all();
//        dd($data);
    }

    /**
     * 获取用户数据 包含分页信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author wang fei long
     */
    public function getUserData(Request $request)
    {
        $data = $request->all();
        if (empty($data)) return response()->json(['StatusCode' => 400, 'ResultData' => '请求参数错误']);
        $result = self::$userServer->getData($data);
        // 如果$result返回错误
        if(!$result['status'])
            return response()->json(['StatusCode' => 400, 'ResultData' => $result['data']]);
        return response()->json(['StatusCode' => 200, 'ResultData' => $result['data']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author wang fei long
     */
    public function getOneData(Request $request)
    {
        $data = $request->all();
        if (empty($data)) return response()->json(['StatusCode' => 400, 'ResultData' => '请求参数错误']);
        $result = self::$userServer->getOneData($data);
        // 如果$result返回错误
        if(!$result['status'])
            return response()->json(['StatusCode' => 400, 'ResultData' => $result['data']]);
        return response()->json(['StatusCode' => 200, 'ResultData' => $result['data']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author wang fei long
     */
    public function updateData(Request $request)
    {
        $all = $request->all();
        $p = empty($all) || !isset($all['id']) || !isset($all['role']) || !in_array($all['role'], ['0', '1', '2']);
        if ($p) return response()->json(['StatusCode' => 400, 'ResultData' => '请求参数错误']);
        $data = $all;
        unset($data['id']);
        unset($data['role']);
        if ($all['role'] == 0){
            $result = self::$userServer->updataUserRoleInfo(['guid' => $all['id']], $data);
            if(!$result['status'])
                return response()->json(['StatusCode' => 400, 'ResultData' => $result['data']]);
        } else {
            $result = self::$userServer->updataUserInfo(['guid' => $all['id']], $data);
            $result['data'] = $result['msg'];
            if($result['status'] == 400)
                return response()->json(['StatusCode' => 400, 'ResultData' => $result['data']]);
        }
        return response()->json(['StatusCode' => 200, 'ResultData' => $result['data']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author wang fei long
     */
    public function deleteData(Request $request)
    {
        $data = $request->all();
        if (empty($data)) return response()->json(['StatusCode' => 400, 'ResultData' => '请求参数错误']);
        $result = self::$userServer->deleteUserData($data);
        // 如果$result返回错误
        if(!$result['status'])
            return response()->json(['StatusCode' => 400, 'ResultData' => $result['data']]);
        return response()->json(['StatusCode' => 200, 'ResultData' => $result['data']]);
    }

}