<?php
/**
 * 用户中心 redis 缓存仓库
 * @author 郭庆
 */
namespace App\Redis;

use App\Store\HomeStore;
use App\Tools\CustomPage;
use Illuminate\Support\Facades\Log;

class UserAccountCache extends MasterCache
{

    private static $skey = String_USER_ACCOUNT_;     //用户string表key

    private static $homeStore;

    public function __construct(HomeStore $homeStore)
    {
        self::$homeStore = $homeStore;
    }

//    /**
//     * 用户账号写入List缓存
//     * @param $data
//     * @author 郭庆
//     */
//    public function setUserAccountList()
//    {
//        //  获取用户账户数据
//        $phone_numbers = self::$homeStore->getAccounts();
//
//        if (!$phone_numbers) return false;
//
//        //塞入list
//        $accountList = $this->rPushLists(self::$lkey, $phone_numbers);
//        if (!$accountList) \Log::info('用户账号数据写入list失败');
//
//    }
//
//    /**
//     * 用户账号写入Hash缓存
//     * @param $phone_number
//     * @author 郭庆
//     */
//    public function userAccountHash($phone_number)
//    {
//        if (empty($phone_number)) return false;
//
//        $index = self::$hkey.$phone_number;
//        // 判断当前hash是否存在，不存在根据phone_number，重新将数据添加
//        if (!$this->exists($index)) {
//            $data = self::$homeStore->getOneData(['phone_number' => $phone_number]);
//            if (!$data) return false;
//            //写入hash
//            $result = $this->addHash($index, CustomPage::objectToArray($data));
//            if (!$result) \Log::error('写入用户账号hash失败，账号：'.$phone_number);
//
//        } else {
//            $result = $this->getHash($index, 3600*24);
//            $data = CustomPage::arrayToObject($result);
//        }
//
//        return $data;
//    }
//
//    /**
//     * 获取指定账号信息
//     * @param $where
//     * @author 郭庆
//     */
//    public function getOneAccount($phone_number)
//    {
//        if (empty($phone_number)) return false;
//        // 先判断list队里 是否存在
//        if (!$this->exists(self::$lkey)) {
//            // 不存在，创建list
//            $this->setUserAccountList();
//        }
//        // 提取hash
//        $data = $this->userAccountHash($phone_number);
//
//        return $data;
//    }
//
//    /**
//     * 写入一条hash 账户信息
//     * @param $data
//     * @return bool
//     * @author 郭庆
//     */
//    public function setOneAccount($data)
//    {
//        if (empty($data)) return false;
//        return $this->changeOneHash(self::$hkey.$data['phone_number'], $data);
//    }
//
//    /**
//     * 添加一条新记录
//     * @param $data
//     * @return bool
//     * @author 郭庆
//     */
//    public function insertOneAccount($data)
//    {
//        if (empty($data)) return false;
//
//        // 先往队列增加一条
//        $list = $this->lPushLists(self::$lkey, $data['phone_number']);
//
//        if ($list) {
//            $this->addHash(self::$hkey.$data['phone_number'], $data);
//        } else {
//            \Log::info('新注册用户:'.$data['phone_number'].'写入redis缓存失败！');
//        }
//    }
//
//
//    /**
//     * 账号修改绑定，更新list和hash
//     * @param $oldTel
//     * @param $data
//     * @return bool
//     * @author 郭庆
//     */
//    public function changeOneAccount($oldTel, $data)
//    {
//        if (empty($oldTel) || empty($data)) return false;
//
//        // 修改绑定手机，需要将之前的list删除再添加
//        $this->delList(self::$lkey, 0, $oldTel);
//        // 添加新的list
//        $this->rPushLists(self::$lkey, $data['phone_number']);
//        // 更新修改后的hash
//        $this->addHash(self::$hkey.$data['phone_number'], $data);
//    }

/*******************************************************************
 **   测试
 ****************/

    /**
     * String类型缓存账号 测试
     * @param string $phone_number
     * @author 郭庆
     */
    public function stringAccount($phone_number)
    {
        if (empty($phone_number)) return false;

        // 判断String缓存 是否存在
        if ($this->exists(self::$skey.$phone_number)) {
            $data = json_decode($this->getString(self::$skey.$phone_number));
        } else {
            // 不存在，查询mysql，抛出并写入缓存
            $data = self::$homeStore->getOneData(['phone_number' => $phone_number]);

            $result = $this->addString(self::$skey.$phone_number, json_encode($data), 3600*24);
            if (!$result) Log::info('添加用户账号String类型缓存失败，账号为：'.$phone_number);
        }

        return $data;
    }

    /**
     * 添加新的用户账号
     * @param $data
     * @return bool
     * @author 郭庆
     */
    public function addNewAccount($data)
    {
        if (empty($data)) return false;

        $result = $this->addString(self::$skey.$data['phone_number'], json_encode($data), 3600*24);

        if (!$result) {
            Log::info('添加用户账号String类型缓存失败，账号为：'.$data['phone_number']);
        }
    }

    /**
     * 账号绑定修改，更新String
     * @param $oldTel
     * @param $data
     * @return bool
     * @author 郭庆
     */
    public function changeOneString($oldTel, $data)
    {
        if (empty($oldTel) || empty($data)) return false;
        // 判断旧账号的缓存是否存在
        if ($this->exists(self::$skey.$oldTel)) {
            // 移除旧，添加新
            $result = $this->delKey(self::$skey.$oldTel);

            if (!$result) Log::info('删除指定String类型缓存失败，账号为：' . $oldTel);
        }
        // 添加新缓存
        $result = $this->addString(self::$skey.$data['phone_number'], json_encode($data));

        if (!$result) Log::info('添加用户账号String类型缓存失败，账号为：'.$data['phone_number']);

    }

}