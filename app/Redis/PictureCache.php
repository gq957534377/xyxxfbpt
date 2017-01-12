<?php
/**
 * Created by PhpStorm.
 * User: wangt
 * Date: 2017/1/3
 * Time: 19:02
 */

namespace App\Redis;

use Log;
use Illuminate\Support\Facades\Redis;
use App\Tools\CustomPage;
use App\Store\PictureStore;

class PictureCache extends MasterCache
{
    protected static $lkey = LIST_PICTURE_INFO;
    protected static $hkey = HASH_PICTURE_INFO_;
    protected static $pictureStore;

    public function __construct(PictureStore $pictureStore)
    {
        self::$pictureStore = $pictureStore;
    }


    /**
     * 把数据保存到redis
     * @param $data  object   存储的是从数据库取出来的，数据对象
     * @return bool
     */
    public function saveRedisList($data)
    {
        $data = CustomPage::objectToArray($data);
        foreach ($data as $datum) {
            if (!$this->rPushLists(self::$lkey, $datum['id'])) {
                Log::error('投资合作机构写入 redis    List失败！！');
                $this->delKey(self::$lkey);
                return false;
            }
            if (!$this->exists(HASH_PICTURE_INFO_ . $datum['id'])) {
                if(!Redis::hMset(self::$hkey . $datum['id'], $datum)) {
                    Log::info('投资合作机构，写入哈希失败!!');
                }
            }
        }
        return true;
    }

    /**
     * 取出哈希中的值
     * @return array
     * @author 王通
     */
    public function selRedisInfo()
    {
        $data = $this->getBetweenList(self::$lkey, 0, -1);
        $arr = [];
        foreach ($data as $datum) {
            $result = $this->getHash(self::$hkey . $datum, WEB_PIC_TIME);
            if (empty($result)) {
                // 如果redis哈希中不存在，则去数据库中查找，并且取出数据放到redis中
                $res = self::$pictureStore->getOnePicture(['id' => $datum]);
                // 判断数据有没有查询成功
                if (!empty($res)) {
                    $arr[] = $res;
                    $res = CustomPage::objectToArray($res);

                    $this->addHash(self::$hkey . $datum, $res, WEB_PIC_TIME);
                } else {
                    $this->delList(self::$lkey, $datum);
                    Log::info('Redis出错，合作机构，LIST  KEY 在数据库中不存在。请选择，是否清理redis');
                }
            } else {
                $arr[] = CustomPage::arrayToObject($result);
            }
        }

        return $arr;
    }

    /**
     * 取出哈希中的一个值
     * @return array
     * @author 郭庆
     */
    public function getOnePicture($id)
    {
        if ($this->exists(HASH_PICTURE_INFO_.$id)){
            $data = CustomPage::arrayToObject($this->getHash(self::$hkey . $id, WEB_PIC_TIME));
        }else{
            $data = self::$pictureStore->getOnePicture(['id'=>(int)$id]);
            $this->addHash(self::$hkey . $id, CustomPage::objectToArray($data), WEB_PIC_TIME);
        }
        return $data;
    }

    /**
     * 取出所有的合作机构，以及投资机构
     * @param $val
     * @return array|bool
     * @author 王通
     */
    public function getRedisPicture($val)
    {
        // 判断redis中存在不存在，不存在则添加到redis
        if (empty($this->exists(LIST_PICTURE_INFO))) {
            $obj = self::$pictureStore->getPictureIn($val);
            $this->saveRedisList($obj);
        } else {
            $obj = $this->selRedisInfo();
        }
        return $obj;
    }
}

