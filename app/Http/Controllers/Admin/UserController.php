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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('admin.user.user');
    }

    /**
     * 返回用户JSON数据 包含分页信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author wang fei long
     */
    public function create(Request $request)
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author wangfeilong
     * 经测试，store方法可以带Request $request参数
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
     * 经测试，show方法可以带Request $request参数
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
     * 经测试，edit方法可以带Request $request参数
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
     * 经测试，update方法可以带Request $request参数
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
     * 经测试，destroy方法可以带Request $request参数
     */
    public function destroy(Request $request, $id)
    {
//                        dd($id);
//        $data = $request->all();
//        dd($data);
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