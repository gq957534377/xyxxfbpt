<?php
/**
 * Created by PhpStorm.
 * User: wangt
 * Date: 2017/1/3
 * Time: 19:02
 */

namespace App\Redis;

use Illuminate\Contracts\Logging\Log;
use Redis;
use App\Tools\CustomPage;

class WebAdminCache
{
    protected static $lkey = LIST_WEBADMIN_INFO;
    protected static $hkey = HASH_WEBADMIN_INFO_;

    /**
     * 检查list是否存在
     * @return bool
     * @author 王通
     */
    public function checkList()
    {
        return Redis::exists(self::$lkey);
    }

    /**
     * 检查哈希是否存在
     * @param $id
     * @return bool
     * @author 王通
     */
    public function checkHash()
    {
        return Redis::exists(self::$hkey);
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
            }
            if (!$this->checkHash(self::$hkey)) {
                if(!Redis::hMset(self::$hkey . $datum['id'], $datum)) {
                    Log::info('页面基本信息，写入redis失败!!');
                    return false;
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
                //Log::info('Redis出错，请设置网页基本信息的值。或者清理redis');
            } else {
                $arr[] = $result;
            }
        }
        $data = CustomPage::arrayToObject($arr);
        return $data;
    }

    /**
     * 删除哈希字段
     * @param $key
     * @return bool
     * @author 王通
     */
    public function delHash($key)
    {
        if (empty($key)) return false;
        return Redis::del(self::$hkey . $key);

    }

    /**
     * 删除list字段
     * @return int
     * @author 王通
     */
    public function delList()
    {
        return Redis::del(self::$lkey);
    }
}

