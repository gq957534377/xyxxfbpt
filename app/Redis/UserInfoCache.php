<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/9
 * Time: 18:03
 */

namespace App\Redis;

use App\Tools\CustomPage;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\Facades\Redis;

class UserInfoCache
{
    private static $lkey = LIST_USERINFO_INFO_;      //项目list表key
    private static $hkey = HASH_USERINFO_INFO_;     //项目hash表key

    /**
     * 判断listkey和hashkey是否存在
     * @param $type string list为查询listkey,否则查询hashkey
     * @param $index string   唯一识别码 guid
     * @return bool
     */
    public function exists($type = 'list', $index = '')
    {
        if($type == 'list'){
            return Redis::exists(self::$lkey.$index);  //查询listkey是否存在
        }else{
            return Redis::exists(self::$hkey.$index);   //查询拼接guid对应的hashkey是否存在
        }

    }

    /**
     * @param object $data 要做缓存的用户信息数据
     * author 张洵之
     */
    public function createCache($data)
    {
        $temp = CustomPage::objectToArray($data);

        if(!$this->exists($type = 'hash', $temp['guid'])){

            $index = self::$hkey . $temp['guid'];
            //写入hash
            Redis::hMset($index, $temp);
            //设置生命周期
            $this->setTime($index);
        }
    }

    /**
     * 设置缓存生命周期
     * @param $key
     * @param int $time
     * author 张洵之
     */
    public function setTime($key, $time = 1800)
    {
        Redis::expire($key, $time);
    }

    /**
     * 返回用户信息缓存中的数据
     * @param string $guid 用户guid
     * @return array|null
     * author 张洵之
     */
    public function getCache($guid)
    {
        if($this->exists('hash', $guid)) {
            return CustomPage::arrayToObject(Redis::hGetall(self::$hkey .$guid)) ;
        }else{
            return null;
        }
    }
}