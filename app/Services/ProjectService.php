<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Store\ProjectStore;
use App\Tools\Common;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProjectService {
    protected static $projectStore = null;

    /**
     * 构造函数注入
     * ProjectService constructor.
     *
     */
    public function __construct(ProjectStore $projectStore)
    {
        self::$projectStore = $projectStore;
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


        //事务控制
        DB::transaction(function () use ($data){

            //project_info数据插入
            $res = self::$projectStore->addData($data);
        });

        $res = self::$projectStore->addData($data);
        if($res==0) return ['status'=> true,'msg'=>'插入失败'];
        return ['status'=> false,'msg'=>'插入成功'];
    }

    /**
     * 获取指定条件的数据
     * @param $data
     * @return array
     * @author 贾济林
     */
    public function getData($data)
    {
        $data = self::$projectStore->getData($data);
        if (!$data) return ['status'=> true,'msg'=> '查询失败'];
        return ['status'=>true,'data'=>$data];
    }

    /**
     * 修改项目状态
     * @param $data
     * @return array
     * @author 贾济林
     */
    public function changeStatus($data)
    {
        //整理参数
        $param = ['project_id'=>$data['id']];
        $updateData = [];

        //根据传入参数指定状态值
        if ($data['status']=='yes') $updateData['status']='3';
        if ($data['status']=='no') $updateData['status']='2';

        $updateData['changetime'] = date("Y-m-d H:i:s", time());

        //拼装需要插入crowd_funding_data的数据
        //project_id,title,status=2,user_id,addtime  需要从数据库查找指定id的一条信息
        //$data_crowd = array(['project_id'=>$data['id'],'title'=>'',''=>'',''=>'']);

        //事务控制
        DB::transaction(function () use ($param){
            //更新状态值
            $res = self::$projectStore->update($param,$updateData);
            //插入crowd_funding_data
        });


        if ($res =0) return ['status'=>false,'msg'=>'修改失败'];
        return ['status'=>true,'msg'=>'修改成功'];
    }

    /**
     * 获取首页数据
     * @param $num
     * @param $status
     * @return array
     * @author 贾济林
     */
    public function getFrstPage($num, $status)
    {
        $res = self::$projectStore->getPage('1',$num,$status);
        if (!$res) return ['status'=>false,'msg'=>'获取失败'];
        return ['status'=>true,'data'=>$res];
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

}