<?php
/**
 * 用户中心 redis 缓存仓库
 * @author 刘峻廷
 */
namespace App\Redis;

use App\Store\UserStore;
use Illuminate\Support\Facades\Redis;

class UserAccountCache
{

    private static $lkey = LIST_USER_ACCOUNT;      //用户列表key
    private static $hkey = HASH_USER_ACCOUNT_;     //用户hash表key

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

    /**
     * 设置用户账户
     * @param $data
     * @author 刘峻廷
     */
    public function setUserAccountList($data)
    {
        // 获取原始数据长度
        $count = count($data);

        // 执行写操作
        $this->insertCache($data);

        // 获取list 长度

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

    /**
     * @author 刘峻廷
     */
    public function getListLength($type)
    {
        if ($this->exists())
        {
            // 返回长度
            return Redis::llen(self::$lkey);
        }

        return false;
    }

    /**
     * 设置hash缓存生命周期
     * @param $key
     * @param int $time
     * @author 刘峻廷
     */
    protected function setTime($key, $time = 1800)
    {
         Redis::expire($key, $time);
    }

    /**
     * 返回队列key
     * @return string
     * @author 刘峻廷
     */
    public function listKey()
    {
        return self::$lkey;
    }

    /**
     * 返回hash索引key前缀
     * @return string
     * @author 刘峻廷
     */
    public function hashKey()
    {
        return self::$hkey;
    }
}