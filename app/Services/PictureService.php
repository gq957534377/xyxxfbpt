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
        $res = Avatar::carousel($data, 1920, 600);
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
     * 保存合作机构所有信息
     * @param $data
     * @return array
     * @author 王通
     */
    public function saveCooper ($data)
    {
        $res = Avatar::carousel($data, 224, 153);
        // 判断是否上传成功
        if ($res['status'] == '200') {
            // 判断图片信息是否保存成功
            if (self::$picturestore->savePicture([
                'url' => $res['msg'],
                'status' => 3,
                'pointurl' => $data['url'],
                'name' => $data['name']
            ])) {
                return ['StatusCode' => '200', 'ResultData' => '合作机构保存成功'];
            }
        }
        return ['StatusCode' => '400', 'ResultData' => '合作机构保存失败'];
    }

    /**
     * 保存投资机构所有信息
     * @param $data
     * @return array
     * @author 王通
     */
    public function saveInvest ($data)
    {
        $res = Avatar::carousel($data, 224, 153);
        // 判断是否上传成功
        if ($res['status'] == '200') {
            // 判断图片信息是否保存成功
            if (self::$picturestore->savePicture([
                'url' => $res['msg'],
                'status' => 5,
                'pointurl' => $data['url'],
                'name' => $data['name']
            ])) {
                return ['StatusCode' => '200', 'ResultData' => '合作机构保存成功'];
            }
        }
        return ['StatusCode' => '400', 'ResultData' => '合作机构保存失败'];
    }

    /**
     * 得到所有指定类型图片
     * @author 王通
     */
    public function getPicture ($val)
    {
        $res = self::$picturestore->getPicture(['status' => $val]);
        // 判断有没有请求道数据
        if (empty($res)) {
            return ['StatusCode' => '201', 'ResultData' => '没有数据'];
        } else {
            return ['StatusCode' => '200', 'ResultData' => $res];
        }
    }

    /**
     * 得到所有图片
     * @author 王通
     */
    public function getPictureAll ()
    {
        $res = self::$picturestore->getPictureAll();
        // 判断有没有请求道数据
        if (empty($res)) {
            return ['StatusCode' => '201', 'ResultData' => '没有数据'];
        } else {
            return ['StatusCode' => '200', 'ResultData' => $res];
        }
    }

    /**
     * 删除指定ID的图片
     * @param $id
     * @author 王通
     */
    public function delPicture ($id)
    {
        $res = self::$picturestore->updatePic(['id' => $id], ['status' => 4]);
        if ($res) {
            return ['StatusCode' => '200', 'ResultData' => '删除成功'];
        } else {
            return ['StatusCode' => '400', 'ResultData' => '删除失败'];
        }
    }

    /**
     * 更新指定ID的图片
     * @param $id
     * @author 王通
     */
    public function updatePicture ($id, $data)
    {
        $res = self::$picturestore->updatePic(['id' => $id], ['name' => $data['name'], 'pointurl' => $data['url']]);
        if ($res) {
            return ['StatusCode' => '200', 'ResultData' => '更新成功'];
        } else {
            return ['StatusCode' => '400', 'ResultData' => '更新失败'];
        }
    }
}