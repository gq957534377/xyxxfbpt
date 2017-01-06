<?php
/**
 * 用户中心 redis 缓存仓库
 * @author 刘峻廷
 */
namespace App\Redis;

use App\Store\UserStore;
use Illuminate\Support\Facades\Redis;

class UserCache
{

    private static $lkey = LIST_USER_INFO;      //用户列表key
    private static $hkey = HASH_USER_INFO_;     //用户hash表key

    private static $userStore;

    public function __construct(UserStore $userStore)
    {
        self::$userStore = $userStore;
    }

    /**
     * 判断listkey和haskey是否存在
     * @param string $type
     * @param string $index
     * @return mixed
     * @author 刘峻廷
     */
    public function exists($type = 'list', $index = '')
    {
        if ($type == 'list') {
            // 查询listkey 是否存在
            return Redis::exists(self::$lkey);
        } else {
            // 查询拼接guid对应的hashkey是否存在
            return Redis::exists(self::$hkey.$index);
        }
    }

    public function setUserList($data)
    {


    }

    /**
     * 写入Redis
     * @param $data
     * @return bool
     * @author 刘峻廷
     */
    public function insertCache($data)
    {
        if (empty($data)) return false;

        foreach ($data as $v) {
            // 写入list队列，从右向左压入，存入的是查询hash所需的键
            Redis::rpush(self::$lkey, $v['guid']);

            // 再次往hash里存入数据,有数据的跳过
            if (!$this->exists($type = '', $v['guid'])) {

                $index = self::$hkey.$v['guid'];
                Redis::hMset($index, $v);
                // 设置生命周期
                $this->setTime($index);
            }
        }
    }

    protected function setTime($key, $time = '')
    {

    }

}