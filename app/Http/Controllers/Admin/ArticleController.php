<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Validator;
use App\Http\Controllers\Controller;
use App\Services\ArticleService as ArticleServer;

class ArticleController extends Controller
{
    protected  static $articleServer;
    public function __construct(ArticleServer $articleServer)
    {
        self::$articleServer = $articleServer;
    }

    /**
     * 文章后台首页
     * author 郭庆
     */
    public function index()
    {
        return view('admin.article.index');
    }

    /**
     * 获取分页数据
     * author 郭庆
     */
    public function create(Request $request)
    {
        $result = self::$articleServer -> selectData($request);
        if($result["status"]) return response() -> json(['StatusCode' => 200,'ResultData' => $result['msg']]);
        return response() -> json(['StatusCode' => 400,'ResultData' => $result['msg']]);
    }

    /**
     * Store a newly created resource in storage.
     *向文章表插入数据
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $data = $request -> all();
        $result = self::$articleServer -> insertData($data);
        if($result["status"]) return response() -> json(['StatusCode' => 200,'ResultData' => $result['msg']]);
        return response() -> json(['StatusCode'=> 400,'ResultData' => $result['msg']]);
    }

    /**
     * 拿取一条文章信息详情
     * author 郭庆
     */
    public function show($id)
    {
        $result = self::$articleServer -> getData($id);
        if($result["status"]) return response() -> json(['StatusCode' => 200,'ResultData' => $result['msg']]);
        return response() -> json(['StatusCode'=> 400,'ResultData' => $result['msg']]);
    }

    /**
     * 修改文章+报名状态
     *
     * @author 文章：郭庆 报名：郭庆
     */
    public function edit(Request $request, $id)
    {
        $status = $request -> input("status");
        $result = self::$articleServer -> changeStatus($id,$status);
        if($result["status"]) return response() -> json(['StatusCode' => 200,'ResultData' => $result['msg']]);
        return response() -> json(['StatusCode'=> 400,'ResultData' => $result['msg']]);
    }

    /**
     * 更改文章信息内容
     * author 郭庆
     */
    public function update(Request $request, $id)
    {
        $data = $request -> all();
        $where = ["guid" => $id];
        $result = self::$articleServer -> upDta($where, $data);
        if($result["status"]) return response() -> json(['StatusCode' => 200, 'ResultData' => $result['msg']]);
        return response() -> json(['StatusCode' => 400, 'ResultData' => $result['msg']]);
    }

    /**
     * 获取报名情况表信息
     * author 郭庆
     */
    public function destroy($id)
    {
        $result = self::$articleServer -> getOrderInfo($id);
        if($result["status"]) return response() -> json(['StatusCode' => 200, 'ResultData' => $result['msg']]);
        return response() -> json(['StatusCode' => 400, 'ResultData' => $result['msg']]);
    }

    /**
     * 上传图片
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
