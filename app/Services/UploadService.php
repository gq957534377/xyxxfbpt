<?php
/**
 * Created by PhpStorm.
 * User: 张洵之
 * Date: 2016/11/2
 * Time: 10:59
 */

namespace App\Services;


class UploadService
{

    /**
     * 上传接口
     *
     * $param  object $userStore
     * @return array
     * @author 张洵之
     */
     public function uploadFile($file)
    {
        $check = $this->checkFile($file);
        // 验证
        if(!$check['status']){
            return response()->json(['ServerNo' => '400','ResultData' => $check['msg']]);
        }
        // 文件存储路径
        $path = $this->path($file->getClientMimeType());
        // 重命名
        $fileName = $this->reName($file->getClientOriginalExtension());
        // 移动
        if(!$file->move($path,$fileName)){
            return response()->json(['ServerNo' => '400','ResultData' => '文件保存失败']);
        }
        return response()->json(['ServerNo' => '200','ResultData' => $fileName]);
    }

    /**
     * 判断上传文件是否可以上传
     *
     * @return bool
     * @ auther 张洵之
     */
    private function checkFile($file)
    {
        if (!$file->isValid()) {
            return ['status' => false, 'msg' => '文件上传失败'];
        }

        if ($file->getClientSize() > $file->getMaxFilesize()) {
            return ['status' => false, 'msg' => '上传文件过大'];
        }

        return ['status' => true];
    }

    /**
     * 文件重命名
     *
     * @return string
     * @auther 张洵之
     */
    private function reName($endname)
    {
        return md5($_SERVER['REQUEST_TIME'].mt_rand(0,9999999)).'.'.$endname;
    }


    /**文件存储位置
     *
     * @param $type
     * @return string
     */
    private function path($type)
    {
        $type = explode('/',$type);
        $path = public_path('uploads/'.$type[0]);

        return $path;
    }
}