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
use App\Store\RollingPictureStore;
use App\Redis\PictureCache;
use App\Redis\RollingPictureCache;

class PictureService
{
    protected static $picturestore;
    protected static $avatar;
    protected static $rollingPictureStore;
    protected static $pictureCache;
    protected static $rollingPictureCache;
    /** 单例引入
     *
     * @param WebAdminService $webAdminService
     * @author 王通
     */
    public function __construct(
        PictureStore $picturestore,
        RollingPictureStore $rollingPictureStore,
        PictureCache $pictureCache,
        RollingPictureCache $rollingPictureCache
    ) {
        self::$picturestore = $picturestore;
        self::$rollingPictureStore = $rollingPictureStore;
        self::$pictureCache = $pictureCache;
        self::$rollingPictureCache = $rollingPictureCache;
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
            $id = self::$rollingPictureStore->savePicture([
                'url' => $res['msg'],
                'addtime' => time()]);
            // 判断是否保存成功
            if (!empty($id)) {
                $data1 = [
                    'id' => $id,
                    'url' => $res['msg'],
                    'addtime' => time(),
                ];
                self::$rollingPictureCache->saveRedisList([$data1]);
                return ['StatusCode' => '200', 'ResultData' => '图片保存成功'];
            }
        }
            return ['StatusCode' => '400', 'ResultData' => '图片保存失败'];
    }

    /**
     * 保存合作机构,投资机构所有信息
     * @param $data
     * @return array
     * @author 王通
     */
    public function saveCooper ($data, $type)
    {

        $res = Avatar::carousel($data, 224, 153);
        // 判断是否上传成功
        if ($res['status'] == '200') {
            // 判断图片信息是否保存成功
            $id = self::$picturestore->savePicture([
                'url' => $res['msg'],
                'type' => $type,
                'pointurl' => $data['url'],
                'name' => $data['name'],
                'addtime' => time(),
            ]);
            if (!empty($id)) {
                $data1 = [
                    'id' => $id,
                    'url' => $res['msg'],
                    'type' => $type,
                    'pointurl' => $data['url'],
                    'name' => $data['name'],
                    'addtime' => time(),
                ];
                self::$pictureCache->saveRedisList([$data1]);
                return ['StatusCode' => '200', 'ResultData' => '合作机构保存成功'];
            }
        }
        return ['StatusCode' => '400', 'ResultData' => '合作机构保存失败'];
    }

    /**
     * 得到所有指定类型图片
     * @param $val  int  3 标识投资机构，5 表示合作机构
     * @author 王通
     */
    public function getPicture ($val)
    {
        $res = self::$picturestore->getPicture(['type' => $val]);
        // 判断有没有请求道数据
        if (empty($res)) {
            return ['StatusCode' => '201', 'ResultData' => '没有数据'];
        } else {
            return ['StatusCode' => '200', 'ResultData' => $res];
        }
    }

    /**
     * 得到所有指定类型图片
     * @param $val array  数组，示例[3, 5] 代表合作机构投资机构都要
     * @author 王通
     */
    public function getPictureIn ($val)
    {

        $obj = self::$pictureCache->getRedisPicture($val);
        // 判断有没有请求道数据
        if (empty($obj)) {
            return ['StatusCode' => '201', 'ResultData' => '没有数据'];
        } else {
            return ['StatusCode' => '200', 'ResultData' => $obj];
        }
    }

    /**
     * 得到轮播图
     * @author 王通
     */
    public function getRollingPicture()
    {
        $res = self::$rollingPictureCache->getRollingPictureRedis();
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
    public function delPicture ($id, $type)
    {
        if ($type == 'rolling') {
            $res = self::$rollingPictureStore->updataRolling(['id' => $id], ['status' => 4]);
            if (!empty($res)) {
                self::$rollingPictureCache->delList(LIST_ROLLINGPICTURE_INFO, $id);
                self::$rollingPictureCache->delKey(HASH_ROLLINGPICTURE_INFO_.$id);
            }
        } else {
            $res = self::$picturestore->updatePic(['id' => $id], ['status' => 4]);
            if (!empty($res)) {
                self::$pictureCache->delList(LIST_PICTURE_INFO , $id);
                self::$pictureCache->delKey(HASH_PICTURE_INFO_.$id);
            }
        }


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
            self::$pictureCache->delKey(HASH_PICTURE_INFO_.$id);
            return ['StatusCode' => '200', 'ResultData' => '更新成功'];
        } else {
            return ['StatusCode' => '400', 'ResultData' => '更新失败'];
        }
    }

}