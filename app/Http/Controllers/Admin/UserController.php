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
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        if (!isset($id) || empty($data)) return response()->json(['StatusCode' => 400, 'ResultData' => '请求参数错误']);
        //审核通过信号
        if (isset($data['msg']) && $data['msg'] == "check_pass"){
            $result = self::$userServer->checkPass($data, $id);
            if (!$result['status'])
                return response()->json(['StatusCode' => 400, 'ResultData' => $result['data']]);
            return response()->json(['StatusCode' => 200, 'ResultData' => $result['data']]);
        }
        $result = self::$userServer->updataUserInfo(['guid' => $id], $data);
        $result['data'] = $result['msg'];
        if($result['status'] == 400)
            return response()->json(['StatusCode' => 400, 'ResultData' => $result['data']]);
        return response()->json(['StatusCode' => 200, 'ResultData' => $result['data']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author wangfeilong
     */
    public function destroy(Request $request, $id)
    {
//        $data = $request->all();
//        $p = (isset($id) || !empty($data) || isset($data['status']));
//        if (!$p) return response()->json(['StatusCode' => 400, 'ResultData' => '请求参数错误']);
//        $result = self::$userServer->deleteUserData($data, $id);
//        // 如果$result返回错误
//        if($result['status'] == 400)
//            return response()->json(['StatusCode' => 400, 'ResultData' => $result['data']]);
//        return response()->json(['StatusCode' => 200, 'ResultData' => $result['data']]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author wang fei long
     */
    public function getOneData(Request $request)
    {
//        $data = $request->all();
//        if (empty($data)) return response()->json(['StatusCode' => 400, 'ResultData' => '请求参数错误']);
//        $result = self::$userServer->getOneData($data);
//        // 如果$result返回错误
//        if(!$result['status'])
//            return response()->json(['StatusCode' => 400, 'ResultData' => $result['data']]);
//        return response()->json(['StatusCode' => 200, 'ResultData' => $result['data']]);
    }

}