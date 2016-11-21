<?php
/**
 * 后台 针对表data_role_info
 * @author wangfeilong
 */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\UserRoleService;

class UserRoleController extends Controller
{
    protected static $userRoleServer = null;
    // 构造函数注入服务
    public function __construct(UserRoleService $userRoleService)
    {
        self::$userRoleServer = $userRoleService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.user');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();
        if (empty($data)) return response()->json(['StatusCode' => 400, 'ResultData' => '请求参数错误']);
        $result = self::$userRoleServer->getData($data);
        if ($result['status'] === 'empty')
            return response()->json(['StatusCode' => 300, 'ResultData' => $result['data']]);
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
        $data = $request->all();
        if (!isset($id) || empty($data)) return response()->json(['StatusCode' => 400, 'ResultData' => '请求参数错误']);
        $result = self::$userRoleServer->updataUserInfo(['guid' => $id], $data);
        $result['data'] = $result['msg'];
        if($result['status'] == 400)
            return response()->json(['StatusCode' => 400, 'ResultData' => $result['data']]);
        return response()->json(['StatusCode' => 200, 'ResultData' => $result['data']]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @author wang fei long
     */
    public function destroy(Request $request, $id)
    {
        //
    }
}
