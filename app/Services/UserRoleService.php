<?php

namespace App\Services;

use App\Http\Requests\Request;
use App\Store\HomeStore;
use App\Store\UserStore;
use App\Store\RoleStore;
use App\Services\UploadService as UploadServer;
use App\Tools\Common;
use App\Tools\CustomPage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserRoleService {
    protected static $homeStore = null;
    protected static $userStore = null;
    protected static $roleStore = null;
    protected static $uploadServer = null;


    /**
     * UserService constructor.
     * @param HomeStore $homeStore
     * @param UserStore $userStore
     * @param RoleStore $roleStore
     */
    public function __construct(HomeStore $homeStore ,UserStore $userStore,  RoleStore $roleStore,UploadServer $uploadServer)
    {
        self::$homeStore = $homeStore;
        self::$userStore = $userStore;
        self::$roleStore = $roleStore;
        self::$uploadServer = $uploadServer;
    }

    /**
     * 获取角色表用户信息
     * @param $where
     * @return array
     * @author 刘峻廷
     */
    public function userInfo($where)
    {
//        $result = self::$userStore->getOneData(['guid'=>$where]);

        $result = self::$roleStore->getRole($where);
        //返回错误状态信息
        if(!$result) return ['status'=>false,'msg'=>'没有找到'];
        //返回数据
        return  ['status'=>true,'msg'=>$result];
    }

    /**
     * 获取符合请求的所有用户记录
     * @param $data
     * @return array|bool
     * @author wang fei long
     */
    public function getData($data)
    {
        if (isset($data['name']))
            return self::getOneData($data);

        if(!isset($data['role']) || !isset($data['status']))
            return ['status' => false, 'data' => '请求参数错误'];
        if(!in_array($data['role'], ['4', '5']))
            return ['status' => false, 'data' => '请求参数错误'];

        $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;

        $userData = self::$roleStore
            ->getUsersData($nowPage, ['role' => ($data['role'] - 2), 'status' => $data['status']]);
        if ($userData === false)
            return ['status' => false, 'data' => '缺少分页信息，数据获取失败'];
        if ($userData === [])
            return ['status' => 'empty', 'data' => '没有查询到数据'];

        $userPage = self::getPage($data, 'user_role/create');
        if (!$userPage)
            return ['status' => false, 'data' => '分页获取失败'];

        //拼装数据，返回所需格式
        $result = array_merge(['data'=> $userData], $userPage['data']);
        if (!$result)
            return ['status' => false, 'data' => '系统错误'];

        return ['status' => true, 'data' => $result];
    }

    /**
     * 获取分页
     * @param $data
     * @param $url
     * @return array
     * @author wang fei long
     */
    private static function getPage($data, $url)
    {
        $nowPage = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;
        $count = self::$roleStore
            ->getUsersNumber(['role' => ($data['role'] - 2), 'status' => $data['status']]);
        $totalPage = ceil($count / PAGENUM);
        $baseUrl   = url($url);

        if($nowPage <= 0)
            $nowPage = 1;
        if($nowPage > $totalPage)
            $nowPage = $totalPage;

        return [
            'status' => true,
            'data' => [
                'nowPage' => $nowPage,
                'pages'   => CustomPage::getSelfPageView($nowPage, $totalPage, $baseUrl,null)
            ]
        ];
    }

    /**
     * 获取一条用户信息，后台
     * @param $data
     * @return array
     * @Author wang fei long
     */
    public function getOneData($data)
    {
        $result = self::$roleStore
            ->getOneData(['guid' => $data['name']]);

        if (!$result)
            return ['status' => false, 'data' => '系统错误'];

        return ['status' => true, 'data' => $result];
    }

    /**
     * 修改用户信息
     * @param $where
     * @param $data
     * @return array
     * @author 刘峻廷
     */
    public function updataUserInfo($where,$data)
    {
        // 检验条件
       if (empty($where) || empty($data)) return ['status'=>400,'msg'=>'缺少数据'];
        // 提交数据给store层
        $info = self::$roleStore->updateUserInfo($where,$data);
        if(!$info) return ['status'=>400,'msg'=>'修改失败！'];
        return ['status'=>200,'msg'=>'修改成功！'];
    }

    /**
     * @param $where
     * @param $data
     * @return array
     * @author wang fei long
     */
    public function updataUserRoleInfo($where,$data)
    {
        // 检验条件
        if (empty($where) || empty($data)) return ['status' => false, 'data' => '请求参数错误'];
        // 提交数据给store层
        $info = self::$roleStore->updateUserInfo($where,$data);
        if(!$info) return ['status'=>false,'data'=>'修改失败！'];
        return ['status'=>true,'data'=>'修改成功！'];
    }

    /**
     * 修改user_info中的角色值
     * @param $where
     * @param $data
     * @return array
     * @author 贾济林
     */
    public function userRoleChange($where,$data)
    {
        // 检验条件
        if (empty($where) || empty($data)) return ['status' => false, 'data' => '请求参数错误'];
        // 提交数据给store层
        $info = self::$userStore->updateUserInfo($where,$data);
        if(!$info) return ['status'=>false,'data'=>'修改失败！'];
        return ['status'=>true,'data'=>'修改成功！'];
    }

    /**
     * 用户审核，修改角色
     * @param $where
     * @param $data
     * @return array
     * @modify 刘峻廷
     */
    public function userCheck($where, $data)
    {
        if (isset($data['memeber'])) {

                // 开启事务，英雄会会员修改状态
                DB::transaction(function () use ($where, $data){

                    //同时修改用户表中的会员值和会员表中的状态值
                    $res_role = self::updataUserInfo($where, $data);

                    //获取角色表中的角色值
                    $roleData = self::$roleStore->getRole($where);
                    $memeber = $roleData->memeber;
                    $userData = ['memeber' => $memeber];

                    $res_user = self::userRoleChange($where, $userData);
                });

        } else {
            //如果不通过，直接修改角色表中状态
            if ($data['status']==3) $res_role = self::updataUserInfo($where, $data);

            //如果通过，开启事务，同时操作角色表和用户表
            if ($data['status']==2) {
                DB::transaction(function () use ($where, $data){

                    //获取角色表中的角色值
                    $roleData = self::$roleStore->getRole($where);
                    $role = $roleData->role;
                    $userData = ['role' => $role];

                    //同时修改用户表中的角色值和角色表中的状态值
                    $res_role = self::updataUserInfo($where, $data);
                    $res_user = self::userRoleChange($where, $userData);
                });

            }
        }


        if(isset($res_role)&&$res_role['status']==400) return ['status'=>400,'msg'=>'修改失败！'];
        return ['status'=>200,'msg'=>'修改成功！'];
    }
    
    /**
     * 获得指定条件的数据
     * @param $where
     * @return array
     * @author 贾济林
     */
    public function getList($where)
    {
        $res = self::$roleStore->getList($where);
        if ($res==0) return ['status' => '500', 'msg' => '未找到数据'];
        return ['status' => '200', 'data' => $res];
    }

}