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
     * @author 王飞龙
     */
    public function create(Request $request)
    {
        $data = $request->all();
        //初步判断数据
        if (empty($data))
            return response()->json(['StatusCode' => 400, 'ResultData' => '请求参数错误']);

        //判断数据是否有memeber字段
        if (isset($data["memeber"])) {
            unset($data['role']);
        }

        //获取数据
        $result = self::$userServer->getData($data);

        //判断获取的数据
        if ($result['status'] === 'empty')
            return response()->json(['StatusCode' => 300, 'ResultData' => $result['data']]);

        //判断获取的数据
        if (!$result['status'])
            return response()->json(['StatusCode' => 400, 'ResultData' => $result['data']]);

        //返回正确数据
        return response()->json(['StatusCode' => 200, 'ResultData' => $result['data']]);
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
    public function show(Request $request, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
    }

    /**
     * 审核操作
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author 王飞龙
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        //初步判断请求数据
        if (!isset($id) || empty($data))
            return response()->json(['StatusCode' => 400, 'ResultData' => '请求参数错误']);

        //判断数据中是否有审核通过的信号
        if (isset($data['msg']) && $data['msg'] == "check_pass"){
            $result = self::$userServer->checkPass($data, $id);

            //判断返回数据
            if (!$result['status'])
                return response()->json(['StatusCode' => 400, 'ResultData' => $result['data']]);

            //返回正确的数据
            return response()->json(['StatusCode' => 200, 'ResultData' => $result['data']]);
        }

        //获取数据
        $result = self::$userServer->updataUserInfo(['guid' => $id], $data);
        $result['data'] = $result['msg'];

        //判断返回数据
        if($result['status'] == 400)
            return response()->json(['StatusCode' => 400, 'ResultData' => $result['data']]);

        //返回正确数据
        return response()->json(['StatusCode' => 200, 'ResultData' => $result['data']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
    }

}