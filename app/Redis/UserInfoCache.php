<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/9
 * Time: 18:03
 */

namespace App\Redis;

use App\Tools\CustomPage;
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
     * 取得一条用户缓存
     * @param string $userId 用户guid
     * @return array|bool
     * author 张洵之
     */
    public function getOneUserCache($userId)
    {
        $index = self::$hkey.$userId;//hash Key

        if($this->exists($index)) {
            $data = CustomPage::arrayToObject($this->getHashFileds($index, ['nickname', 'realname', 'headpic' , 'role']));
            return $data;
        }else{
            $temp = self::$user_store->getOneData(['guid' => $userId]);

            if(!$temp) return false;

            $value = CustomPage::objectToArray($temp);
            $this->addHash($index, $value);
            return $temp;
        }
    }

}