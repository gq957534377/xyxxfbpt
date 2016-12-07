<?php
/**
 * Created by PhpStorm.
 * User: wangt
 * Date: 2016/12/7
 * Time: 15:05
 */

namespace App\Services;

use App\Store\PictureStore;
use App\Tools\Avatar;

class PictureService
{
    protected static $picturestore;
    protected static $avatar;
    /** 单例引入
     *
     * @param WebAdminService $webAdminService
     * @author 王通
     */
    public function __construct(PictureStore $picturestore)
    {
        self::$picturestore = $picturestore;
    }
    /**
     * 保存轮播图
     * @param $data
     * @return array
     * @author 王通
     */
    public function saveCarousel ($data)
    {
        $res = Avatar::carousel($data);
        // 判断是否上传成功
        if ($res['status'] == '200') {
            // 判断图片信息是否保存成功
            if (self::$picturestore->savePicture(['url' => $res['msg'], 'state' => 2])) {
                return ['StatusCode' => '200', 'ResultData' => '图片保存成功'];
            }
        }
            return ['StatusCode' => '400', 'ResultData' => '图片保存失败'];
    }

    /**
     * 得到所有轮播图
     * @author 王通
     */
    public function getCarousel ()
    {
        $res = self::$picturestore->getPicture(['state' => 2]);
        if (empty($res)) {
            return ['StatusCode' => '201', 'ResultData' => '没有数据'];
        } else {
            return ['StatusCode' => '200', 'ResultData' => $res];
        }
    }
}