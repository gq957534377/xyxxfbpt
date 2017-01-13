<?php

namespace App\Http\Controllers\Admin;

use App\Store\PictureStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\ActionService as ActionServer;

class ActionController extends Controller
{
    protected  static $actionServer;
    protected  static $pictureStore;
    public function __construct(ActionServer $actionServer, PictureStore $pictureStore)
    {
        self::$actionServer = $actionServer;
        self::$pictureStore = $pictureStore;
    }

    /**
     * 活动后台首页
     * @param
     * @return 活动管理页面
     * @author 郭庆
     */
    public function index(Request $request)
    {
        $type = (int)$request->get('type');

        return view('admin.action.index',['type' => $type]);
    }

    /**
     * 获取分页数据
     * @param
     * @return array
     * @author 郭庆
     * @modify 郭庆
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $nowPage = isset($data["nowPage"]) ? (int)$data["nowPage"]:1;//获取当前页
        $forPages = 3;//一页的数据条数
        $status = $data["status"];//文章状态：已发布 待审核 已下架
        $type = (int)$data["type"];//获取文章类型
        $where = [];

        if($status){
            $where["status"] = (int)$status;
        }
        if ($type == 3) {
            if (isset($data['college_type'])){
                if ($data['college_type'] != 4){
                    $where['type'] = (int)$data['college_type'];
                }
            }
            $list = true;
        } else {
            $list = false;
            $where['type'] = $type;
        }

        $result = self::$actionServer->selectData($where, $nowPage, $forPages, "/action/create", $list);
        if($result["StatusCode"] == '200'){
            foreach ($result['ResultData']['data'] as $v){
                $status = self::$actionServer->setStatusByTime($v);
                if ($status['status']){
                    if (!is_string($status['msg'])){
                        $chage = self::$actionServer->changeStatus($v->guid, $status['msg'],$type);
                        if ($chage['StatusCode'] != '200'){
                            Log::info("管理员用户第一次请求更改活动状态失败".$v->guid);
                        }else{
                            $v->status = $status['msg'];
                        }
                    }
                }
            }
        }
        return response() -> json($result);
    }

    /**
     * 发布活动
     * @param $request
     * @return array
     * @author 郭庆
     */
    public function store(Request $request)
    {
        $data = $request -> all();
        $result = self::$actionServer -> insertData($data);
        return response() -> json($result);
    }

    /**
     * 拿取一条活动信息详情
     * @param $id 活动id
     * @return array
     * @author 郭庆
     */
    public function show($id,Request $request)
    {
        $list = $request->get('list');
        $result = self::$actionServer -> getData($id,$list);
        return response() -> json($result);
    }

    /**
     * 修改活动状态
     * @param $request
     * @param $id 活动id
     * @author 郭庆
     */
    public function edit(Request $request, $id)
    {
        $status = $request -> input("status");
        $list = $request->get('list');
        $result = self::$actionServer -> changeStatus($id, $status, $list);
        return response() -> json($result);
    }

    /**
     * 更改活动信息内容
     * @param $request
     * @param $id 所要修改的活动id
     * author 郭庆
     */
    public function update(Request $request, $id)
    {
        $data = $request -> all();
        $where = ["guid" => $id];

        $result = self::$actionServer -> upDta($where, $data, $data['list']);
        return response() -> json($result);
    }

    /**
     *
     * @param
     * @return array
     * @author 郭庆
     */
    public function destroy($id)
    {

    }

    /**
     * 返回活动发布视图
     * @return view
     * @author 郭庆
     */
    public function actionAdd()
    {
        $group = self::$pictureStore->getGroup();
        if (!empty($group)){
            return view('admin.action.add', ['StatusCode' => '200', 'ResultData' => $group]);
        }else{
            if ($group == []){
                return view('admin.action.add', ['StatusCode' => '204', 'ResultData' => '暂时没有合作机构或投资机构，请添加后再进行发布']);
            }else{
                return view('admin.action.add', ['StatusCode' => '500', 'ResultData' => '服务器忙，请稍后重试']);
            }
        }
    }
    /**
     * 返回活动修改视图
     * @param $id 活动id
     * @return view
     * @author 郭庆
     */
    public function actionChange($id, $list)
    {
        //旧信息
        $result = self::$actionServer -> getData($id,$list);
        $result['list'] = (int)$list;

        $group = self::$pictureStore->getGroup();
        $result['group'] = $group;
        return view('admin.action.edit', $result);
    }
    /**
     * 返回报名列表管理视图
     * @param $id 活动id
     * @return view
     * @author 郭庆
     */
    public function actionOrder($id)
    {
        return view('admin.action.order');
    }

    /**
     * 获取组织机构列表
     * @param
     * @return array
     * @author 郭庆
     */
    public function getGroup()
    {
        return $this->validatesRequestErrorBag;
    }
}
