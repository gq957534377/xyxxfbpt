<?php

namespace App\Http\Controllers\Admin;

use App\Services\UserService;
use App\Store\ActionOrderStore;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Services\ActionService as ActionServer;

class ActionOrderController extends Controller
{
    protected  static $actionServer;
    protected  static $userServer;
    protected  static $actionOrderStore;
    public function __construct(
        ActionServer $actionServer,
        UserService $userServer,
        ActionOrderStore $actionOrderStore
    )
    {
        self::$actionServer = $actionServer;
        self::$userServer = $userServer;
        self::$actionOrderStore = $actionOrderStore;
    }

    /**
     * 报名列表页
     * @param $request
     * @return [] 活动详情
     * @author 郭庆
     */
    public function index(Request $request)
    {
        $id = $request->get('id');
        $list = (int)$request->get('list');

        $result = self::$actionServer -> getData($id);
        return view('admin.action.actionOrder',$result);
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
        $users = self::$actionOrderStore->getSomeField(['action_id' => $data['action_id']], 'user_id');
        if (!$users){
            if ($users == []){
                return response() -> json(['StatusCode' => '204', 'ResultData' => '没有用户报名该活动']);
            }else{
                return response() -> json(['StatusCode' => '500', 'ResultData' => '服务器出错,获取报名的用户失败']);
            }
        }

        $nowPage = isset($data["nowPage"]) ? (int)$data["nowPage"]:1;//获取当前页
        $forPages = 10;//一页的数据条数
        $where = [];

        if(isset($data["status"])){
            $where["status"] = (int)$data["status"];
        }
        if (isset($data['action_id'])){
            $where["action_id"] = $data['action_id'];
        }

        $result = self::$userServer->getUsers($users, $nowPage, $forPages, 'action_order/create');
        return response() -> json($result);
    }

    /**
     *
     * @param
     * @return array
     * @author 郭庆
     */
    public function store(Request $request)
    {

    }

    /**
     *
     * @param
     * @return array
     * @author 郭庆
     */
    public function show($id)
    {

    }

    /**
     *
     * @param
     * @return array
     * @author 郭庆
     */
    public function edit(Request $request, $id)
    {

    }

    /**
     *
     * @param
     * @return array
     * @author 郭庆
     */
    public function update(Request $request, $id)
    {

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


}
