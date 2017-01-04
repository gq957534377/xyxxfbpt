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
     * 获取指定条件的数据
     * @param $where
     * @return array
     * @author 贾济林
     * @modify 张洵之
     */
    public function getData($nowPage,$pageNum, $where)
    {
        $data = self::$projectStore->getPage($nowPage, $pageNum, $where);

        if (!$data) return ['StatusCode' => '400', 'ResultData' => '暂无数据'];

        return ['StatusCode' => '200', 'ResultData' => $data];
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
     * @modify 张洵之
     */
    public function changeStatus($data)
    {
        $updateData = array();
        if (isset($data['remark'])) $updateData = ['remark' => $data['remark']];

        //整理参数
        $param = ['guid'=>$data['id']];

        //根据传入参数指定状态值
        $updateData['status'] = $data['status'];

        $updateData['changetime'] = time();


        //更新状态值
        $res = self::$projectStore->update($param,$updateData);
        if ($res==0) return ['StatusCode' => '400', 'ResultData' => '修改数据失败'];
        return ['StatusCode' => '400','ResultData'=>'修改成功'];
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
        $where = ['status' => $status];

        $res = self::$projectStore->getPage('1',$num,$where);

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
     * @modify 张洵之
     */
    public function getPage($nowpage, $num, $status)
    {
        $where = ['status' => $status];

        $res = self::$projectStore->getPage($nowpage,$num,$where);

        if (!$res) return ['StatusCode' => '400', 'ResultData' => '未获取到数据'];

        return ['StatusCode' => '200', 'ResultData' => $res];
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
     * @param string $id 项目guid
     * @return array
     * author 张洵之
     */
    public function getProject($id)
    {
        $projectInfoData = self::$projectStore->getOneData(['guid' => $id]);

        if(empty($projectInfoData)) return ['StatusCode' => '400', 'ResultData' => '暂无数据'];

        $userInfo = self::$userStore->getOneData(['guid' => $projectInfoData->user_guid]);

        if(empty($userInfo)) return ['StatusCode' => '400', 'ResultData' => '未找到发布用户数据'];

        $projectInfoData->project_experience = $this->openData(
            $projectInfoData->project_experience,
            '*zxz*',
            ':::'
        );
        $projectInfoData->team_member = $this->openData(
            $projectInfoData->team_member,
            '*zxz*',
            '!,/'
        );
        $projectInfoData->userInfo = $userInfo;

        return ['StatusCode' => '200', 'ResultData' => $projectInfoData];
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

        return ['StatusCode' => '400', 'ResultData' => '项目添加失败'];
    }

    /**
     * 将格式化字符串转数组
     * @param string $str 要转的字符串
     * @param string $tab1 一级分隔符
     * @param string $tab2 二级分隔符
     * @return array
     * author 张洵之
     */
    public function openData($str, $tab1, $tab2)
    {
        $arr = explode($tab1,$str);
        $num = count($arr)-1;
        unset($arr[$num]);
        for ($i = 0; $i < $num; $i++){
            $arr[$i] = explode($tab2, $arr[$i]);
        }
        return $arr;
    }

    /**
     * 返回条件下的项目数量
     * @param $where
     * @return mixed
     * author 张洵之
     */
    public function getCount($where)
    {
        $result = self::$projectStore->getCount($where);

        return $result;
    }

    /**
     * 返回一条数据
     * @param $where
     * @return array
     * author 张洵之
     */
    public function getOneData($where)
    {
        $result = self::$projectStore->getOneData($where);

        if(empty($result)) return ['StatusCode' => '400', 'ResultData' => '暂无数据'];

        return ['StatusCode' => '200', 'ResultData' => $result];
    }
}