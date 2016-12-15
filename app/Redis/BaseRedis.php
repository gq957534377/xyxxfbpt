<?php
/**
 * Created by PhpStorm.
 * User: wangt
 * Date: 2016/12/13
 * Time: 20:40
 */
namespace App\Redis;

use Illuminate\Support\Facades\Redis;
class BaseRedis
{
    /**
     * 设置单字符redis
     * @param $key
     * @param $val
     * @param int $time
     * $author 王通
     */
    public static function setRedis ($key, $val)
    {
        if (!empty($key) && !empty($val)) {
            return Redis::set($key, $val);
        } else {
            return false;
        }

    }
    /**
     * 设置单字符redis 有超时时间
     * @param $key
     * @param $val
     * @param int $time
     * $author 王通
     */
    public static function setexRedis ($key, $val, $time)
    {
        if (!empty($key) && !empty($val)) {
            return Redis::setex($key, $time, $val);
        } else {
            return false;
        }

    }

    /**
     * 得到单字符redis
     * @param $key
     * @param $val
     * @param int $time
     * $author 王通
     */
    public static function getRedis ($key)
    {
        if (!empty($key)) {
            return Redis::get($key);
        } else {
            return false;
        }

    }


    /**
     * 制定键累加，并且返回当前累加的值
     * @param $key
     * @return int
     * @author 王通
     */
    public static function incrRedis ($key)
    {
        return Redis::incr($key);
    }

    /**
     * 验证指定KEY是否存在
     * @param $key
     * @return bool
     * @author 王通
     */
    public static function existsRedis ($key)
    {
        return Redis::Exists($key);
    }

    /**
     * 设置超时时间
     * @param $key
     * @return bool
     * @author 王通
     */
    public static function expireRedis ($key, $time)
    {
        return Redis::Expire($key, $time);
    }

    /**
     * 添加集合
     * @param $key 集合的键值
     * @param $value  集合的值
     * @return mixed 返回0，表示失败，1表示成功
     * @author 王通
     */
    public static function addSet ($key, $value)
    {
        return Redis::Sadd($key, $value);
    }

    public static function checkSet ($key, $value)
    {
        return Redis::SISMEMBER($key, $value);
    }
}