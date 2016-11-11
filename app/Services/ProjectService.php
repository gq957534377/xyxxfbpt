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



}