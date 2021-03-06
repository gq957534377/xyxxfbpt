<?php

namespace App\Tools;

use Intervention\Image\Facades\Image as Image;


class Avatar{

    /**
     * 上传用户头像
     * @param $data
     * @return array|\Illuminate\Http\JsonResponse
     * @author 郭庆
     */
    public static function avatar($data)
    {

        //判断上传文件是否存在
        if (!$data->hasFile('avatar_file'))  return response()->json(['state' => 400,'result' => '上传文件为空!']);
        $file = $data->file('avatar_file');

        // 获取用户对文件进行处理的数据
        $avatarInfo  = json_decode($data->all()['avatar_data']);
        $cropX = floor($avatarInfo->x);
        $cropY = floor($avatarInfo->y);
        $cropW = floor($avatarInfo->width);
        $cropH = floor($avatarInfo->height);
        $rotate = $avatarInfo->rotate;

        //提取上传后的临时存放地址
        $tmpFile = $file->getRealPath();
        //拼装新的文件名
        $extension = $file->getClientOriginalExtension();
        $newFilename = date('YmdHis').str_random(3).'.'.$extension;
        $path = public_path().'/uploads/avatars/';

        if (!file_exists($path)) {
            mkdir($path,0755,true);
        }

        //打开一张图片
        $img = Image::make($tmpFile)
            ->rotate(-$rotate)
            ->crop($cropW,$cropH,$cropX,$cropY)
            ->save($path .$newFilename);

        if(!$img) return ['status' => '400','msg' => '图片保存失败'];

        $info = Common::QiniuUpload($path .$newFilename,$newFilename);

        if(!$info['status']) {
            unlink($path .$newFilename);
            return ['status' => '400','msg' => '存储失败!'];
        }
//        成功删除本地图片
        unlink($path .$newFilename);

        return ['status' => '200','msg' => $info['url']];

    }

    /**
     * 上传轮播图
     * @param $data
     * @return array|\Illuminate\Http\JsonResponse
     */
    public static function carousel($data, $width, $height)
    {

        //判断上传文件是否存在
        if (!$data->hasFile('avatar_file'))  return response()->json(['state' => 400,'result' => '上传文件为空!']);
        $file = $data->file('avatar_file');

        // 获取用户对文件进行处理的数据
        $avatarInfo  = json_decode($data->all()['avatar_data']);
        $cropX = floor($avatarInfo->x);
        $cropY = floor($avatarInfo->y);
        $cropW = floor($avatarInfo->width);
        $cropH = floor($avatarInfo->height);
        $rotate = $avatarInfo->rotate;

        //提取上传后的临时存放地址
        $tmpFile = $file->getRealPath();
        //拼装新的文件名
        $extension = $file->getClientOriginalExtension();
        $newFilename = date('YmdHis').str_random(3).'.'.$extension;
        $path = public_path('uploads/avatars/');

        if (!file_exists($path)) {
            mkdir($path,0755,true);
        }

        //打开一张图片
        $img = Image::make($tmpFile)
            ->rotate(-$rotate)
            ->crop($cropW,$cropH,$cropX,$cropY)
            ->resize($width, $height)
            ->save($path .$newFilename);

        if( !$img) return ['status' => '400','msg' => '图片保存失败'];

        $info = Common::QiniuUpload($path .$newFilename,$newFilename);

        if(!$info['status']) return ['status' => '400','msg' => '存储失败!'];
        //成功删除本地图片
        unlink($path .$newFilename);

        return ['status' => '200','msg' => $info['url']];
    }
}
