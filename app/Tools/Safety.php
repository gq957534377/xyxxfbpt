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
        if (session()->getId() != substr($tmp, 0, 32)) {
            return false;
        }
        return true;

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
            return false;
        } else {
            return true;
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
     * 防止快速刷新
     * @param $ip
     * @return bool
     * @author 王通
     */
    public static function PreventFastRefresh ($key)
    {
        $time = time();
        // 二十秒之内，访问次数超过二十次的话，让他进入本地回环
        if (!BaseRedis::existsRedis($key)) {
            BaseRedis::incrRedis($key);
            BaseRedis::setexRedis(config('safety.PREVEN_TFAST_REFRESH_TIME') . $key, time(), config('safety.PREVEN_TFAST_REFRESH_HOLD_TIME'));
            BaseRedis::expireRedis($key, config('safety.PREVEN_TFAST_REFRESH_HOLD_TIME'));
        } else {
            $num = BaseRedis::incrRedis($key);
            if ($time < (BaseRedis::getRedis(config('safety.PREVEN_TFAST_REFRESH_TIME') . $key) + $num)) {
                header(sprintf('Location:%s', 'http://127.0.0.1'));
                exit('Access Denied');
            }
        }

        return false;
    }
}