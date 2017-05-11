<?php

namespace App\Http\Controllers\Admin;

use App\Store\NcreStore;
use App\Tools\Avatar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\NoticeService as NoticeServer;
use Illuminate\Support\Facades\Validator;

class NcreController extends Controller
{
    protected static $ncreStore;

    public function __construct(NcreStore $ncreStore)
    {
        self::$ncreStore = $ncreStore;
    }

    /**
     * 通知后台首页
     *
     * @return array
     * @author 郭庆
     */
    public function index()
    {
        
        return view('admin.notice.index');
    }

    /**
     * 获取分页数据
     *
     * @return array
     * @author 郭庆
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $nowPage = isset($data["nowPage"]) ? (int)$data["nowPage"] : 1;//获取当前页
        $forPages = 5;//一页的数据条数
        $status = $data["status"];//通知状态：已发布 待审核 已下架
        $type = $data["type"];//获取通知类型

        $where = [];
        if ($status) {
            $where["status"] = $status;
        }
        if ($type != 'null') {
            $where["type"] = $type;
        }
        $result = self::$noticeServer->selectDatas($where, $nowPage, $forPages, "/notice/create");
        return response()->json($result);
    }

    /**
     * 向通知表插入数据
     *
     * @return array
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['status'] = 1;

        $result = self::$noticeServer->insertData($data);

        return response()->json($result);
    }

    /**
     * 拿取一条通知信息详情
     *
     * @return array
     * @author 郭庆
     */
    public function show($id)
    {
        $result = self::$noticeServer->getData($id);
        return response()->json($result);
    }

    /**
     * 修改通知状态
     *
     * @return array
     * @author 郭庆
     */
    public function edit(Request $request, $id)
    {
        $status = $request->input("status");
        $user = $request->input('user');

        if ($status == 3 && $user == 2) {
            $result = self::$noticeServer->upDta(['guid' => $id], ['status' => 3, 'reason' => $request["reason"], 'user' => 2]);
        } else {
            $result = self::$noticeServer->changeStatus(['id' => $id], $status);
        }
        return response()->json($result);
    }

    /**
     * 更改通知信息内容
     *
     * @return array
     * @author 郭庆
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $where = ["guid" => $id];
        $result = self::$noticeServer->upDta($where, $data);
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
        $validator = Validator::make($request->all(), [
            'avatar_file' => 'required|mimes:png,gif,jpeg,jpg,bmp'
        ], [
            'avatar_file.required' => '上传文件为空!',
            'avatar_file.mimes' => '上传的文件类型错误，请上传合法的文件类型:png,gif,jpeg,jpg,bmp。'

        ]);
        // 数据验证失败，响应信息
        if ($validator->fails()) return response()->json(['StatusCode' => '400', 'ResultData' => $validator->errors()->all()]);
        //上传
        $info = Avatar::avatar($request);
        if ($info['status'] == '400') return response()->json(['StatusCode' => '400', 'ResultData' => '文件上传失败!']);
        $avatarName = $info['msg'];

        return response()->json(['StatusCode' => '200', 'ResultData' => $avatarName]);
    }
}
