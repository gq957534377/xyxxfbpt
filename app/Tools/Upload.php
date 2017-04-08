<?php
/**
 * Created by PhpStorm.
 * User: Twitch
 * Date: 2016/12/23
 * Time: 10:09
 */

namespace App\Tools;

use Intervention\Image\Facades\Image as Image;

class Upload{

    public static function UploadFile($file)
    {
        // 验证文件真实性
        $check = self::checkFile($file);

        if (!$check['status']) {
            return ['StatusCode' => '400', 'ResultData' => $check['msg']];
        }

        //提取上传后的临时存放地址
        $tmpFile = $file->getRealPath();
        // 新地址
        $path = self::path($file);
        // 新文件名
        $newName = self::reName($file);

        // 存储文件到本地
        $img = Image::make($tmpFile)->save($path.$newName);

        if (!$img) ['StatusCode' => '400', 'ResultData' => '图片保存失败'];

        // 本地上传文件到七牛
        $info = Common::QiniuUpload($path .$newName,$newName);

        if(!$info['status']) {
            unlink($path .$newName);
            return ['StatusCode' => '400','ResultData' => '存储失败!'];
        }
//        成功删除本地图片
        unlink($path .$newName);

        return ['StatusCode' => '200','ResultData' => $info['url']];

    }

    /**
     * 验证文件
     * @param $file
     * @return array
     * @author 郭庆
     */
    private static function checkFile($file)
    {
        if (!$file->isValid())
        {
            return ['status' => false, 'msg' => '文件上传失败'];
        }

        if ($file->getClientSize() > $file->getMaxFilesize()) {
            return ['status' => false, 'msg' => '上传文件过大'];
        }

        return ['status' => true];
    }

    /**
     * 文件重新命名
     * @author 郭庆
     */
    private static function reName($file)
    {
        // 文件后缀
        $extentsion =  $file->getClientOriginalExtension();

        return date('YmdHis').str_random(3).'.'.$extentsion;
    }

    /**
     * 文件存储位置
     * @param $type
     * @author 郭庆
     */
    private static function path()
    {
        $path = public_path().'/uploads/cards/';

        // 判断存储文件夹是否存在
        if (!file_exists($path)) {
            mkdir($path,0755,true);
        }

        return $path;
    }

}