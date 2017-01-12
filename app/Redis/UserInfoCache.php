<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/9
 * Time: 18:03
 */

namespace App\Redis;

use App\Tools\CustomPage;
use Illuminate\Support\Facades\Redis;
use App\Store\UserStore;

class UserInfoCache extends MasterCache
{
    private static $hkey = HASH_USERINFO_INFO_;     //项目hash表key
    private static $user_store;

    public function __construct(UserStore $userStore)
    {
        self::$user_store = $userStore;
    }

    /**
     * 判断key是否存在
     * @param $type string list为查询listkey,否则查询hashkey
     * @param $index string   唯一识别码 guid
     * @return bool
     */
    public function exists($key)
    {
        return Redis::exists($key);

    }

    /**
     * 设置缓存生命周期
     * @param $key
     * @param int $time
     * author 张洵之
     */
    public function setTime($key, $time = HASH_OVERTIME)
    {
        Redis::expire($key, $time);
    }

    /**
     * 取得一条用户缓存
     * @param string $userId 用户guid
     * @return array|bool
     * author 张洵之
     */
    public function getOneUserCache($userId)
    {
        $index = self::$hkey.$userId;

        if($this->exists($index)) {
            $data = CustomPage::arrayToObject(Redis::hGetall($index));
            return $data;
        }else{
            $temp = self::$user_store->getOneData(['guid' => $userId]);

            if(!$temp) return false;

            $value = CustomPage::objectToArray($temp);
            Redis::hMset($index, $value);
            //设置生命周期
            $this->setTime($index);
            return $temp;
        }
    }

}