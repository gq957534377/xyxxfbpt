<?php

namespace App\Http\Controllers\Admin;

use App\Tools\Avatar;
use Illuminate\Http\Request;
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
     *
     * @return array
     * @author 郭庆
     */
    public function index()
    {
        return view('admin.article.index');
    }

    /**
     * 获取分页数据
     *
     * @return array
     * @author 郭庆
     */
    public function create(Request $request)
    {
        $result = self::$articleServer->selectData($request);
        return response()->json($result);
    }

    /**
     * 向文章表插入数据
     *
     * @return array
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user'] = 1;
        $data['status'] = 1;
        $data['author'] = session('manager')->email;
        $data['headPic'] = "/admin/images/logo.jpg";

        $result = self::$articleServer->insertData($data);

        return response()->json($result);
    }

    /**
     * 拿取一条文章信息详情
     *
     * @return array
     * @author 郭庆
     */
    public function show($id)
    {
        $result = self::$articleServer->getData($id);
        return response()->json($result);
    }

    /**
     * 修改文章状态
     *
     * @return array
     * @author 郭庆
     */
    public function edit(Request $request, $id)
    {
        $status = $request->input("status");
        $user = $request->input('user');

        if ($status == 3 && $user == 2){
            $result = self::$articleServer->upDta(['guid'=>$id], ['status' => 3, 'reason' => $request["reason"], 'user'=>2]);
        }else{
            $result = self::$articleServer->changeStatus($id, $status);
        }
        return response()->json($result);
    }

    /**
     * 更改文章信息内容
     *
     * @return array
     * @author 郭庆
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $where = ["guid" => $id];
        $result = self::$articleServer->upDta($where, $data);
        return response()->json($result);
    }

    /**
     *
     *
     * @return array
     * @author 郭庆
     */
    public function destroy($id)
    {

    }

    /**
     * 上传图片到七牛
     * @param $request
     * @return array
     * @author 郭庆
     */
    public function bannerPic(Request $request)
    {
        //数据验证过滤
        $validator = \Validator::make($request->all(),[
            'avatar_file' => 'required|mimes:png,gif,jpeg,jpg,bmp'
        ],[
            'avatar_file.required' => '上传文件为空!',
            'avatar_file.mimes' => '上传的文件类型错误，请上传合法的文件类型:png,gif,jpeg,jpg,bmp。'

        ]);
        // 数据验证失败，响应信息
        if ($validator->fails()) return response()->json(['StatusCode' => '400','ResultData' => $validator->errors()->all()]);
        //上传
        $info = Avatar::avatar($request);
        if ($info['status'] == '400') return response()->json(['StatusCode' => '400','ResultData' => '文件上传失败!']);
        $avatarName = $info['msg'];

        return response()->json(['StatusCode' => '200','ResultData' => $avatarName]);
    }
}
