<?php
/**
 * Created by PhpStorm.
 * User: wangt
 * Date: 2017/1/3
 * Time: 19:02
 */

namespace App\Redis;

use Log;
use App\Tools\CustomPage;
use App\Store\WebAdminStore;

class WebAdminCache extends MasterCache
{
    protected static $lkey = LIST_WEBADMIN_INFO;
    protected static $hkey = HASH_WEBADMIN_INFO_;
    protected static $webAdminStore;

    public function __construct(WebAdminStore $webAdminStore)
    {
        self::$webAdminStore = $webAdminStore;
    }


    /**
     * 把数据保存到redis
     * @param $data  object   存储的是从数据库取出来的，数据对象
     * @return bool
     */
    public function saveRedisList($data)
    {
        $data = CustomPage::objectToArray($data);
        foreach ($data as $datum) {
            if (!$this->rPushLists(self::$lkey, $datum['id'])) {
                Log::error('网页基本信息写入redis   List失败！！');
                $this->delKey(self::$lkey);
                return false;
            }
            if (!$this->exists(self::$hkey . $datum['id'])) {
                if(!$this->addHash(self::$hkey . $datum['id'], $datum, WEB_PIC_TIME)) {
                    Log::info('页面基本信息，写入redis失败!!');
                }
            }
        }
        return true;
    }

    /**
     * 取出哈希中的值
     * @return  $data array  把数据转换成常用操作模式，[object]
     * @author 杨志宇
     */
    public function selRedisInfo()
    {
        $data = $this->getBetweenList(self::$lkey, 0, -1);
        $arr = [];
        foreach ($data as $datum) {
            $result = $this->getHash(self::$hkey . $datum, WEB_PIC_TIME);
            if (empty($result)) {
                //Log::info('Redis出错，请设置网页基本信息的值。或者清理redis');
                // 如果redis哈希中不存在，则去数据库中查找，并且取出数据放到redis中
                $res = self::$webAdminStore->getOneWebInfo(['id' => $datum]);

                if (!empty($res)) {
                    $res = CustomPage::objectToArray($res);
                    $this->addHash(self::$hkey . $datum, $res, WEB_PIC_TIME);
                    $arr[] = $res;
                } else {
                    $this->delList(self::$lkey, $datum);
                    Log::info('Redis出错，网页基本信息，LIST  KEY 在数据库中不存在。请选择，是否清理redis');
                }

            } else {
                $arr[] = $result;
            }
        }
        $data = CustomPage::arrayToObject($arr);
        return $data;
    }


    /**
     * 取出所有的网页基本信息
     * @return array|mixed
     * @author 杨志宇
     */
    public function getWebInfo()
    {
        // 判断list是否存在
        if (empty($this->exists(LIST_WEBADMIN_INFO))) {
            $obj = self::$webAdminStore->getWebInfo();
            $this->saveRedisList($obj);
        } else {
            $obj = $this->selRedisInfo();
        }
        return $obj;
    }

    /**
     * 将指定条件查询到的所有guid加入redis list中
     * @param $where [] 查询条件
     * @param $key string list KEY
     * @author 郭庆
     */
    public function mysqlToList($where, $key)
    {
        if ($this->exists($key)) return $this->getBetweenList($key, 0, -1);

        //从数据库获取所有的guid
        $guids = self::$webAdminStore->getList($where, 'id');

        if (!$guids) return [];
        //将获取到的所有guid存入redis
        $redisList = $this->rPushLists($key, $guids);
        if (!$redisList) {
            Log::error("将数据库数据写入list失败,list为：".$key);
            return $guids;
        }else{
            return $guids;
        }
    }

    /**
     * 检测list
     * @param
     * @return bool
     * @author 郭庆
     */
    public function checkList($key)
    {
        $sqlLength = self::$webAdminStore->getCount(['status' => 1]);
        if (!$this->exists($key)) return true;
        $listLength = count(array_unique($this->getBetweenList($key, 0, -1)));

        if ($sqlLength != $listLength) {
            if (!$this->delKey($key)) return false;
            return $this->mysqlToList(['status' => 1], $key);
        }else{
            return true;
        }
    }

    /**
     * 任务调度查list异常
     * @param
     * @return array
     * @author 郭庆
     */
    public function check()
    {
        if (!$this->checkList(self::$lkey)) Log::warning('任务调度，检测到list异常，未成功解决'.self::$lkey);
    }
}

