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
use App\Store\RollingPictureStore;


class RollingPictureCache extends MasterCache

{
    protected static $lkey = LIST_ROLLINGPICTURE_INFO;
    protected static $hkey = HASH_ROLLINGPICTURE_INFO_;
    protected static $rollingPictureStore;

    /** 单例引入
     *
     * @param WebAdminService $webAdminService
     * @author 杨志宇
     */
    public function __construct(RollingPictureStore $rollingPictureStore)
    {
        self::$rollingPictureStore = $rollingPictureStore;
    }



    /**
     * 把数据保存到redis
     * @param $data    存储的是从数据库取出来的，数据对象
     * @return bool
     */
    public function saveRedisList($data)
    {
        $data = CustomPage::objectToArray($data);
        foreach ($data as $datum) {
            if (!$this->rPushLists(self::$lkey, $datum['id'])) {
                Log::error('首页轮播图  写入redis   List失败！！');
                $this->delKey(self::$lkey);
                return false;
            }
            // 判断哈希键是否存在
            if (!$this->exists(self::$hkey . $datum['id'])) {
                if(!$this->addHash(self::$hkey . $datum['id'], $datum, WEB_PIC_TIME)) {
                    Log::info('首页轮播图，写入哈希失败!!');
                }
            }
        }
        return true;
    }

    /**
     * 取出哈希中的值
     * @return array
     * @author 杨志宇
     */
    public function selRedisInfo()
    {
        // 取出list中的所有数据
        $data = $this->getBetweenList(self::$lkey, 0, -1);
        $arr = [];
        // 取出哈西中的所有的轮播图，
        foreach ($data as $datum) {
            $result = $this->getHash(self::$hkey . $datum, WEB_PIC_TIME);
            // 判断哈希中数据
            if (empty($result)) {
                // 如果redis哈希中不存在，则去数据库中查找，并且取出数据放到redis中
                $res = self::$rollingPictureStore->getOneData($datum);
                // 如果数据库中数据不存在，则删除listKEY
                if (!empty($res)) {
                    $res = CustomPage::objectToArray($res);
                    $this->addHash(self::$hkey . $datum, $res, WEB_PIC_TIME);
                    $arr[] = CustomPage::arrayToObject($res);
                } else {
                    Log::info('Redis出错，轮播图LIST  KEY 未找到。请选择是否清理redis');
                    $this->delList(self::$lkey, $datum);
                }
            } else {
                $arr[] = CustomPage::arrayToObject($result);
            }
        }

        return $arr;
    }

    /**
     * 取出轮播图数据
     * @return array
     * @author 杨志宇
     */
    public function getRollingPictureRedis()
    {
        // 判断redis中存在不存在，不存在则添加到redis
        if (empty($this->exists(LIST_ROLLINGPICTURE_INFO))) {
            $res = self::$rollingPictureStore->getAllPic();
            $this->saveRedisList($res);
        } else {
            $res = $this->selRedisInfo();
            // 如果redis中没有数据，则把KEY删掉并且删掉list键
            if (empty($res)) {
                $res = self::$rollingPictureStore->getAllPic();
                self::delKey(LIST_ROLLINGPICTURE_INFO);
            }
        }
        return $res;
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
        $guids = self::$rollingPictureStore->getList($where, 'id');

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
        $sqlLength = self::$rollingPictureStore->getCount(['status' => 1]);
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

