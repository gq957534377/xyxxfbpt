<?php
/**
 * Created by PhpStorm.
 * User: wangt
 * Date: 2017/1/3
 * Time: 19:02
 */

namespace App\Redis;

use Log;
//use Redis;
use Illuminate\Support\Facades\Redis;

use App\Tools\CustomPage;
use App\Store\RollingPictureStore;


class RollingPictureCache extends MasterCache

{
    protected static $lkey = LIST_ROLLINGPICTURE_INFO;
    protected static $hkey = HASH_ROLLINGPICTURE_INFO_;
    protected static $rollingPictureStore;

    /** 单例引入
     *
     * @param WebAdminService $webAdminService
     * @author 王通
     */
    public function __construct(RollingPictureStore $rollingPictureStore)
    {
        self::$rollingPictureStore = $rollingPictureStore;
    }



    /**
     * 把数据保存到redis
     * @param $data    存储的是从数据库取出来的，数据对象
     * @return bool
     */
    public function saveRedisList($data)
    {
        $data = CustomPage::objectToArray($data);
        foreach ($data as $datum) {
            if (!Redis::rpush(self::$lkey, $datum['id'])) {
                Log::error('首页轮播图  写入redis   List失败！！');
                $this->delKey(self::$lkey);
                return false;
            }
            if (!$this->exists(self::$hkey)) {
                if(!Redis::hMset(self::$hkey . $datum['id'], $datum)) {
                    Log::info('首页轮播图，写入哈希失败!!');
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
        $data = Redis::lRange(self::$lkey, 0, -1);
        $arr = [];
        foreach ($data as $datum) {
            $result = Redis::hGetall(self::$hkey . $datum);
            if (empty($result)) {
                // 如果redis哈希中不存在，则去数据库中查找，并且取出数据放到redis中
                $res = self::$rollingPictureStore->getOneData($datum);
                if (!empty($res)) {
                    $res = CustomPage::objectToArray($res);
                    Redis::hMset(self::$hkey . $datum, $res);
                    $arr[] = CustomPage::arrayToObject($res);
                } else {
                    $this->delList(self::$lkey, $datum);
                }
            } else {
                Log::info('Redis出错，轮播图LIST  KEY 未找到。请选择是否清理redis');
                $arr[] = CustomPage::arrayToObject($result);
            }
        }

        return $arr;
    }

}

