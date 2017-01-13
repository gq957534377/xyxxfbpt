<?php
/**
 * Created by PhpStorm.
 * User: wangt
 * Date: 2017/1/3
 * Time: 19:02
 */

namespace App\Redis;

use Log;
use Redis;

use App\Tools\CustomPage;
use App\Store\WebAdminStore;

class WebAdminCache extends MasterCache
{
    protected static $lkey = LIST_WEBADMIN_INFO;
    protected static $hkey = HASH_WEBADMIN_INFO_;
    protected static $webAdminStore;

    public function __construct(WebAdminStore $webAdminStore)
    {
        self::$webAdminStore = $webAdminStore;
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
                Log::error('网页基本信息写入redis   List失败！！');
                $this->delKey(self::$lkey);
                return false;
            }
            if (!$this->exists(self::$hkey . $datum['id'])) {
                if(!Redis::hMset(self::$hkey . $datum['id'], $datum)) {
                    Log::info('页面基本信息，写入redis失败!!');
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
            $result = Redis::hGetall(self::$hkey . $datum);
            if (empty($result)) {
                //Log::info('Redis出错，请设置网页基本信息的值。或者清理redis');
                // 如果redis哈希中不存在，则去数据库中查找，并且取出数据放到redis中
                $res = self::$webAdminStore->getOneWebInfo(['id' => $datum]);

                if (!empty($res)) {
                    $res = CustomPage::objectToArray($res);
                    Redis::hMset(self::$hkey . $datum, $res);
                    $arr[] = $res;
                } else {
                    $this->delList(self::$lkey, $datum);
                    Log::info('Redis出错，网页基本信息，LIST  KEY 在数据库中不存在。请选择，是否清理redis');
                }

            } else {
                $arr[] = $result;
            }
        }
        $data = CustomPage::arrayToObject($arr);
        return $data;
    }

}

