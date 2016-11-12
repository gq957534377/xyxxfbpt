<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Store\ProjectStore;
use App\Tools\Common;
use Illuminate\Support\Facades\Session;

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
        unset($data['_token']);
        $data['status']='1';
        session(['guid'=>'testguid']);
        $data['guid']=session('guid');

        //插入数据
        $res = self::$projectStore->addData($data);
        if($res==0) return ['status'=> true,'msg'=>'插入失败'];
        return ['status'=> false,'msg'=>'插入成功'];
    }

    public function getData($data)
    {
        $data = self::$projectStore->getData($data);
        if (!$data) return ['status'=> true,'msg'=> '查询失败'];
        return ['status'=>true,'data'=>$data];
    }

    public function changeStatus($data)
    {
        $param = ['project_id'=>$data['id']];
        $updateData = [];
        if ($data['status']=='yes') $updateData['status']='3';
        if ($data['status']=='no') $updateData['status']='2';

        $res = self::$projectStore->update($param,$updateData);
        if ($res =0) return ['status'=>false,'msg'=>'修改失败'];
        return ['status'=>true,'msg'=>'修改成功'];
    }

    public function getFrstPage($num, $status)
    {
        $res = self::$projectStore->getPage('1',$num,$status);
        if (!$res) return ['status'=>false,'msg'=>'获取失败'];
        return ['status'=>true,'data'=>$res];
    }

    public function getPage($nowpage, $num, $status)
    {
        $res = self::$projectStore->getPage($nowpage,$num,$status);
        if (!$res) return ['status'=>false,'msg'=>'获取失败'];
        return ['status'=>true,'data'=>$res];
    }



}