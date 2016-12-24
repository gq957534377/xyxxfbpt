<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Store\ProjectStore;
use App\Store\RoleStore;
use App\Store\UserStore;
use App\Tools\Common;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProjectService {
    protected static $projectStore = null;
    protected static $userStore = null;
    protected static $roleStore = null;

    /**
     * 构造函数注入
     * ProjectService constructor.
     *
     */
    public function __construct(ProjectStore $projectStore, UserStore $userStore, RoleStore $roleStore)
    {
        self::$projectStore = $projectStore;
        self::$userStore    = $userStore;
        self::$roleStore    = $roleStore;
    }

    /**
     * 提交项目
     * @param $request
     * @return array
     * @author 贾济林
     */
    public function addProject($request)
    {
        //拼装需要插入project_info的数据
        $data = $request->all();
        $data['status']='1';
        $guid =session('user')->guid;
        $data['guid']=$guid;

        $data['addtime'] = date("Y-m-d H:i:s", time());
        $data['changetime'] = date("Y-m-d H:i:s", time());

        $res = self::$projectStore->addData($data);
        if($res==0) return ['status'=> true,'msg'=>'插入失败'];
        return ['status'=> false,'msg'=>'插入成功'];
    }

    /**
     * 获取指定条件的数据
     * @param $where
     * @return array
     * @author 贾济林
     * @modify 张洵之
     */
    public function getData($where)
    {
        $data = self::$projectStore->getData($where);

        if (!$data) return ['StatusCode' => '400', 'ResultData' => '暂无数据'];

        return ['StatusCode' => '200', 'ResultData' => $data];
    }

    public function getAllData()
    {
        $data = self::$projectStore->getAllData();
        if (!$data) return ['status'=>false,'msg'=>'查询失败'];
        return ['status'=>true,'data'=>$data];
    }

    /**
     * 随机拿取指定条数 数据
     * @param int $number 默认3条
     * @return array
     * @author 刘峻廷
     */
    public function takeData($number = 3)
    {
        $data = self::$projectStore->takeData($number);

        if (!$data) return ['StatusCode' => '204', 'ResultData' => '暂无无数据'];

        return ['StatusCode' => '200', 'ResultData' => $data];
    }

    /**
     * 修改项目状态
     * @param $data
     * @return array
     * @author 贾济林
     */
    public function changeStatus($data)
    {
        $updateData = array();
        if (isset($data['remark'])) $updateData = ['remark' => $data['remark']];

        //整理参数
        $param = ['project_id'=>$data['id']];

        //根据传入参数指定状态值
        $updateData['status'] = $data['status'];

        $updateData['changetime'] = date("Y-m-d H:i:s", time());


        //更新状态值
        $res = self::$projectStore->update($param,$updateData);
        if ($res==0) return ['status'=>false,'msg'=>'修改失败'];
        return ['status'=>true,'msg'=>'修改成功'];
    }

    /**
     * 获取首页数据
     * @param $num
     * @param $status
     * @return array
     * @author 贾济林
     * @modify 张洵之
     */
    public function getFrstPage($num, $status)
    {
        $res = self::$projectStore->getPage('1',$num,$status);

        if (!$res) return ['StatusCode' => '400', 'ResultData' => '未获取到数据'];

        return ['StatusCode' => '200', 'ResultData' => $res];
    }

    /**
     * 指定当前页、单页数据量、和项目状态获取数据
     * @param $nowpage
     * @param $num
     * @param $status
     * @return array
     * @author 贾济林
     */
    public function getPage($nowpage, $num, $status)
    {
        $res = self::$projectStore->getPage($nowpage,$num,$status);
        if (!$res) return ['status'=>false,'msg'=>'获取失败'];
        return ['status'=>true,'data'=>$res];
    }


    /**
     * 获得某个用户的角色值
     * @param $guid
     * @return array
     * @anthor 贾济林
     */
    public function getRole($guid)
    {
        $param = ['guid'=>$guid];
        $data = self::$roleStore->getRole($param);
        if (!$data) return ['status'=>false,'msg'=>'查询失败'];
        $role = $data->role;
        return ['status'=>true,'data'=>$role];
    }

    /**
     * 得到单个用户的所有发布项目
     * @return array
     * @author 贾济林
     */
    public function getProject()
    {
        $guid = session('user')->guid;
        $where = ['guid'=>$guid];
        $res = self::$projectStore->getData($where);
        if (!$res) return ['status'=>false,'msg'=>'查询失败'];
        return ['status'=>true,'data'=>$res];
    }

    /**
     * 更新项目数据
     * @param $data
     * @param $where
     * @return array
     * @author 贾济林
     */
    public function updateData($data,$where)
    {
        //重新提交后，将status改为1
        $data['status'] = 1;

        $res = self::$projectStore->update($where,$data);
        if ($res==0) return ['status'=>false,'msg'=>'更新失败'];
        return ['status'=>true,'msg'=>'更新成功'];
    }

    /**
     * 修改个人项目启用禁用
     * @param $where
     * @param $data
     * @return array
     */
    public function changeAble($where,$data)
    {
        $res = self::$projectStore->update($where,$data);
        if ($res==0) return ['status'=>false,'msg'=>'修改失败'];
        return ['status'=>true,'msg'=>'修改成功'];
    }

    public function ajaxForClass($type)
    {
        $where = ['disable'=>'0','status'=>'3'];

        switch ($type) {
            case 0 :
                $result = $this->getData($where);
                break;
//            case 1 :
//                $result = $this->getDatas();
        }

        if(is_array($result)) return ['StatusCode' => '200', 'ResultData' => $result];

        return ['StatusCode' => '500', 'ResultData' => "服务器端出错"];
    }

    /**
     * 向项目信息表添加数据
     * @param $data
     * @return array
     * author 张洵之
     */
    public function addProjects($data)
    {
        $data['user_guid'] = session('user')->guid;
        $data['guid'] = Common::getUuid();
        $data['addtime'] = time();
        $data['changetime'] = time();
        $result = self::$projectStore ->addData($data);

        if($result) return ['StatusCode' => '200', 'ResultData' => '添加成功'];

        ['StatusCode' => '400', 'ResultData' => '项目添加失败'];
    }
}