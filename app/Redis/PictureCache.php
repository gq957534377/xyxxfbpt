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
use DB;

class PictureCache
{
    protected static $lkey = LIST_PICTURE_INFO;
    protected static $hkey = HASH_PICTURE_INFO_;
    protected static $table = 'data_picture_info';

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
    public function checkHash($id)
    {
        return Redis::exists(self::$hkey . $id);
    }


    /**
     * 把数据保存到redis
     * @param $data    存储的是从数据库取出来的，数据对象
     * @return bool
     */
    public function saveRedisList($data)
    {
        $data = CustomPage::objectToArray($data);
//        dd($data);
        foreach ($data as $datum) {
            if (!Redis::rpush(self::$lkey, $datum['id'])) {
                Log::error('网页基本信息写入redis   List失败！！');
                Redis::del(self::$lkey);
                return false;
            }
            if (!$this->checkHash($datum['id'])) {
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
                // 如果redis哈希中不存在，则去数据库中查找，并且取出数据放到redis中
                $res = DB::table(self::$table)->where(['id' => $datum])->first();
                $res = CustomPage::objectToArray($res);

                Redis::hMset(self::$hkey . $datum, $res);

                $arr[] = CustomPage::arrayToObject($res);
            } else {
                $arr[] = CustomPage::arrayToObject($result);
            }
        }

        return $arr;
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

    /**
     * 删除list中的指定值
     * @param $val
     * @return bool|int
     * @author 王通
     */
    public function delListKey($val)
    {
        if (empty($val)) return false;
        return Redis::lRem(self::$lkey,0 , $val);
    }
}

