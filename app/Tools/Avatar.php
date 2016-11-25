<?php

namespace App\Tools;


use App\Http\Requests\Request;

class Avatar{

    public function avatar()
    {

    }

    // 接收头像
    protected function postAvatar(Request $request,$filename,$realPath='uploads/avatars/')
    {
        //判断上传文件是否存在
        if (!$request->hasFile($filename)) return ['status' => '400','msg' =>'上传文件为空!' ];

        //获取上传文件信息
        $file = $request->file($filename);

        //判断文件上传过程中是否出错
        if (!$file->isValid()) return ['status' => '400','msg' => '上传文件失败'];
        //获取客户端上传文件名
        $clientName = $file->getClientOriginalName();
        //获取临时存放文件名
        $tmpName = $file->getFilename();
        //目标存放地址
        $realPath = $file->getRealPath(public_path($realPath));
        //获取文件类型
        $extension = $file->getClientOriginalExtension();
        //获取文件扩展类型
        $mimeType = $file->getMimeType();
        //存放后新文件名
        $newName = date('YmdHis').'origin'.$clientName.'.'.$extension;

        //将上传的图片移入到指定目录
        if (!$file->move($realPath,$newName)) return ['status' => '400','msg' => '文件保存失败!'];

        

    }


}
