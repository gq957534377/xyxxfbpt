<?php
/**
 * 用户中心 redis 缓存仓库
 * @author 刘峻廷
 */
namespace App\Redis;

use App\Store\HomeStore;
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
     * 用户账号写入缓存
     * @param $data
     * @author 刘峻廷
     */
    public function setUserAccountList()
    {
        //  获取用户账户数据
        $tels = self::$homeStore->getAccounts();

        if (!$tels) return false;

        //塞入list
        $accountList = $this->rPushLists(self::$lkey, $tels);
        if (!$accountList) \Log::info('用户账号数据写入list失败');

        // 同步更新hash
        foreach ($tels as $v) {

            // 判断当前hash是否存在，不存在根据tel，重新将数据添加
            if (!$this->exists(self::$hkey.$v)) {
                $data = self::$homeStore->getOneData(['tel' => $v]);
                //写入hash
                $this->addHash(self::$hkey.$v, CustomPage::objectToArray($data));
            }
        }

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

        // 先判断list队里 是否存在
        if ($this->exists(self::$lkey)) {
            // 存在
            $data = $this->getHash(self::$hkey.$tel);
            // hash 生命周期可能到了
            if (!$data) {
                $result = self::$homeStore->getOneData(['tel' => $tel]);

                if (!$result) return false;
                $account = CustomPage::objectToArray($result);
                // 写入hash
                $result = $this->addHash(self::$hkey.$tel, $account);
                if (!$result) \Log::error('写入用户账号hash失败，账号：'.$tel);
            }
        } else {
            // 不存在，创建list,更新hash
            $this->setUserAccountList();
            $data = $this->getHash(self::$hkey.$tel);
        }

        return CustomPage::arrayToObject($data);
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
        return $this->addHash(self::$hkey.$data['tel'], $data);
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
        $list = $this->lPushLists(self::$lkey, $data['tel']);

        if ($list) {
            $this->addHash(self::$hkey.$data['tel'], $data);
        } else {
            \Log::info('新注册用户:'.$data['tel'].'写入redis缓存失败！');
        }
    }


}