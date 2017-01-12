<?php
/**
 * 用户中心 redis 缓存仓库
 * @author 刘峻廷
 */
namespace App\Redis;

use App\Store\HomeStore;
use App\TaoBaoSdk\Top\ResultSet;
use App\Tools\CustomPage;
use Illuminate\Support\Facades\Redis;

class UserAccountCache extends MasterCache
{

    private static $lkey = LIST_USER_ACCOUNT;      //用户列表key
    private static $hkey = HASH_USER_ACCOUNT_;     //用户hash表key

    private static $homeStore;

    public function __construct(HomeStore $homeStore)
    {
        self::$homeStore = $homeStore;
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

        // 获取list 长度,队列的长度和获取到的数据长度是否一致，不一致清空队列，重新生成队列

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
            Redis::rpush(self::$lkey, $v['tel']);

            // 再次往hash里存入数据,有数据的跳过
            if (!$this->exists(self::$lkey.$v['tel'])) {

                $index = self::$hkey.$v['tel'];
                Redis::hMset($index, $v);
                // 设置生命周期
                $this->setTime($index);
            }
        }
    }

    /**
     * 写入一条hash 账户信息
     * @param $data
     * @return bool
     * @author 刘峻廷
     */
    public function setOneAccount($data)
    {
        if (empty($data)) return false;
        return Redis::hMset(self::$hkey.$data['tel'], $data);
    }

    /**
     * 获取指定账号信息
     * @param $where
     * @return bool
     * @author 刘峻廷
     */
    public function getOneAccount($tel)
    {
        if (empty($tel)) return false;
        // 获取指定账号信息
        $index = self::$hkey.$tel;
        $data = Redis::hGetall($index);

        // 没有获取到，hash生命周期可能到了
        if (empty($data)) {
            //读取mysql，重新写入redis
            $result = self::$homeStore->getOneData(['tel' => $tel]);

            if (!$result) return false;
            $data = CustomPage::objectToArray($result);

            $this->setOneAccount($data);
        }
        // 重新设置生命周期
        $this->setTime($index);

        return CustomPage::arrayToObject($data);
    }

    /**
     * 添加一条新记录
     * @param $data
     * @return bool
     * @author 刘峻廷
     */
    public function insertOneAccount($data)
    {
        if (empty($data)) return false;

        // 先往队列增加一条
        $list = Redis::lpush(self::$lkey, $data['tel']);

        if ($list) {
            $index = self::$hkey.$data['tel'];

            Redis::hMset($index, $data);
            $this->setTime($index);
        } else {
            \Log::info('新注册用户:'.$data['tel'].'写入redis缓存失败！');
        }
    }

    /**
     * 删除指定一条队列数据
     * @param string $tel
     * @return bool
     * @author 刘峻廷
     */
    public function delOneList($tel)
    {
        if (empty($tel)) return false;

        // 判断队列中是否存在
        if ($this->exists()) {
            Redis::lRem(self::$lkey, $tel, 0);
        }
    }

    /**
     * 删除指定的hash
     * @param $key
     * @return bool
     * @author 刘峻廷
     */
    public function delHash($key)
    {
        if (empty($key)) return false;
        return Redis::del(self::$hkey . $key);

    }

    /**
     * 获取list长度
     * @param $type
     * @return bool
     * @author 刘峻廷
     */
    public function getListLength($type)
    {
        if ($this->exists(self::$lkey))
        {
            // 返回长度
            return Redis::llen(self::$lkey);
        }

        return false;
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