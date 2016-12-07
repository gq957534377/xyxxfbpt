<?php

namespace App\Tools;


use App\Http\Requests\Request;
use Intervention\Image\Facades\Image as Image;
use Faker\Provider\Uuid;

class Avatar{

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
        $newFilename = Uuid::uuid().'.'.$extension;
        $path = public_path('uploads/avatars/');

        if (!file_exists($path)) {
            mkdir($path,0755,true);
        }

        //打开一张图片
        $img = Image::make($tmpFile)
            ->rotate(-$rotate)
            ->crop($cropW,$cropH,$cropX,$cropY)
            ->save($path .$newFilename);

        if( !$img) return ['status' => '400','msg' => '图片保存失败'];

        $info = Common::QiniuUpload($path .$newFilename,$newFilename);

        if(!$info['status']) return ['status' => '400','msg' => '存储失败!'];
        //成功删除本地图片
        unlink($path .$newFilename);

        return ['status' => '200','msg' => $info['url']];
    }

}
