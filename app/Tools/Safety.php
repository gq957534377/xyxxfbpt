<?php
/**
 * Created by PhpStorm.
 * User: wangt
 * Date: 2016/12/13
 * Time: 21:48
 */

namespace App\Tools;

use App\Redis\BaseRedis;
use Faker\Provider\Base;
use Illuminate\Support\Facades\Log;

class Safety
{

    /**
     * 请求数量，以及通过sessionID验证
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function session_number ($tmp)
    {
        if (md5(session()->getId()) != substr($tmp, 0, 32)) {
            return true;
        }
        return false;

    }

    /**
     * 通过IP请求数量验证
     * @param $ip
     * @return bool
     * @author 王通
     */
    public static function number ($ip, $num, $name = '接口名')
    {

        $k = BaseRedis::incrRedis($ip . date('Y-m-d'));

        if ($k > $num) {
            BaseRedis::setRedis(config('safety.BLACKLIST') . $ip, time());
            Log::warning('!!!' . $name . '来自于'. $ip .'请求次数达到警戒线，'. $num  . '次！！');
            return true;
        } else {
            return false;
        }
    }

    /**
     * 检查IP有没有被加入黑名单
     * @param $ip
     * @return bool
     * @author 王通
     */
    public static function checkIpBlackList ($ip)
    {
        if (empty(BaseRedis::getRedis($ip))) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 把IP加入黑名单
     * @param $ip
     * @return bool
     * @author 王通
     */
    public static function addIpBlackList ($ip)
    {
        if (empty(BaseRedis::getRedis($ip))) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 防止快速刷新
     * @param $ip
     * @return bool
     * @author 王通
     */
    public static function PreventFastRefresh ($ip)
    {
        $key = config('safety.PREVEN_TFAST_REFRESH') . $ip;
        // 当前时间
        $time = time();
        // 存储当前时间参数
        $time_key = config('safety.PREVEN_TFAST_REFRESH_TIME') . $key;
        // 持续时间
        $time_n =  config('safety.PREVEN_TFAST_REFRESH_HOLD_TIME');
        $num_n =  config('safety.PREVEN_TFAST_REFRESH_HOLD_NUM');
        // 二十秒之内，访问次数超过二十次的话，让他进入本地回环
        if (!BaseRedis::existsRedis($key)) {

            // 这是累加键，判断访问次数
            BaseRedis::setexRedis($key, 1, $time_n);
            // 设置存储时间键值，顺便设置超时时间。
            BaseRedis::setexRedis($time_key, time(), $time_n);

        } else {
            $num = BaseRedis::incrRedis($key);
            if ((BaseRedis::getRedis($time_key) + $num_n) < (BaseRedis::getRedis($time_key) + $num)) {
                Log::warning('!!! 在'.$time_n . '秒内，来自于' . $ip .'请求次数达到超过警戒线，'. $num_n .'，'. $num  . '次！！');
                header(sprintf('Location:%s', 'http://127.0.0.1'));
                exit('Access Denied');
            }
        }

        return false;
    }

    /**
     * 检查手机验证码请求是否合法
     * @param $ip
     * @param $code
     * @return bool
     * @author 王通
     */
    public static function checkIpSMSCode ($ip, $code)
    {
        $SMSVal = config('safety.PREVEN_TFAST_REFRESH_SMS_VAL') . $ip;
        $SMSNum = config('safety.PREVEN_TFAST_REFRESH_SMS_NUM') . $ip;
        $overtime = config('safety.SMS_OVERTIME');
        $reqTime = config('safety.SMS_REQUEST_TIME');
        $smsLimitNum =config('safety.SMS_LIMIT_NUM');

        // 判断固定IP指定时间段内，请求次数有没有达到限制
        // 如果没有开始累计，则把验证码存到Redis里
        if (!BaseRedis::existsRedis($SMSNum)) {
            // 当前验证码
            BaseRedis::setexRedis($SMSVal, $code, $overtime);
            // 这是累加键，判断访问次数
            BaseRedis::setexRedis($SMSNum, 1, $reqTime);
            return false;
        } else {
            // 判断一分钟之内，有没有请求过验证码
            if (BaseRedis::existsRedis($SMSVal)) {
                Log::warning('!!! 在'.$overtime . '秒内，来自于' . $ip .'请求次数超过两次，疑似被攻击。');
                return true;
            }
            // 判断指定时间段，请求次数有没有超过三次
            if (BaseRedis::getRedis($SMSNum) < $smsLimitNum) {
                // 当前验证码
                BaseRedis::setexRedis($SMSVal, $code, $overtime);

                BaseRedis::incrRedis($SMSNum);
                return false;
            } else {
                Log::warning('!!! 在'.$reqTime . '秒内，来自于' . $ip .'请求次数达到超过警戒线，'. $smsLimitNum .'次！！');
                return true;
            }

        }
    }
}