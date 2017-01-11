<?php
/**
 * Created by PhpStorm.
 * User: 郭庆
 * Date: 2017/01/11
 * Time: 15:51
 * @author:郭庆
 */
namespace App\Redis;

use Illuminate\Support\Facades\Redis;

class MasterCache
{
    /**
     * 判断listkey或者hashkey是否存在(默认判断list是否存在)
     * @param $list bool list为真查询listkey,否则查询hashkey
     * @param $index string   唯一识别码 guid
     * @return bool
     */
    public function exists($key, $list=true)
    {
        if($list){
            return Redis::exists($key);  //查询listkey是否存在
        }else{
            return Redis::exists($key);   //查询拼接guid对应的hashkey是否存在
        }
    }

    /**
     * 获取redis缓存里某一个list中的指定页的所有元素
     * @param $key string list的key
     * @param  $nums int  每页显示条数
     * @param  $nowPage int  当前页数
     * @return array
     */
    public function getPageLists($key, $nums, $nowPage)
    {
        //起始偏移量
        $offset = $nums * ($nowPage-1);

        //获取条数
        $totals = $offset + $nums - 1;

        //获取缓存的列表索引并返回
        return $this->getBetweenList($key, $offset, $totals);

    }

    /**
     * 获取指定范围内的list数据
     * @param
     * @return array
     * @author 郭庆
     */
    public function getBetweenList($key, $start, $end)
    {
        return Redis::lrange($key, $start, $end);
    }

    /**
     * 获取hash的指定几个字段的数据
     * @param $key string hash的key
     * @param $key array hash的指定几个字段 array('field1', 'field2')
     * @author 郭庆
     */
    public function getHash($key)
    {
        $data = Redis::hGetAll($key);
        if (!$data) return false;
        //设置生命周期
        $this->setTime($key);
        return $data;
    }

    /**
     * 获取hash的指定几个字段的数据
     * @param $key string hash的key
     * @param $key array hash的指定几个字段 array('field1', 'field2')
     * @return array
     * @author 郭庆
     */
    public function getHashFileds($key, $fields)
    {
        $i = 0;
        $values = Redis::hMGet($key, $fields);
        $data = [];
        foreach ($fields as $field){
            $data[$field] = $values[$i++];
        }
        return $data;
    }

    /**
     * 将一条记录写入hash
     * @param $key string hash的key
     * @param $data array 存入hash的具体字段和值
     * @author 郭庆
     */
    public function addHash($key, $data)
    {
        if (empty($key) || empty($data)) return false;

        if (!$this->exists($key, false)) {
            //写入hash
            Redis::hMset($key, $data);
        }
        //设置生命周期
        $this->setTime($key);
        return true;
    }

    /**
     * 创建新的list并且插入所有list
     * @param $lists [guid1,guid2]
     * @author 郭庆
     */
    public static function addLists($key, $lists)
    {
        if (empty($key) || empty($lists)) return false;

        foreach ($lists as $v){
            //执行写list操作
            if (!Redis::rpush($key, $v)) return false;
        }

        return true;
    }

    public function addList($key, $guid)
    {
        return Redis::lpush($key, $guid);
    }
    /**
     * 设置hash缓存的生命周期
     * @param $key  string  需要设置的key
     */
    public function setTime($key)
    {
        Redis::expire($key, REDIS_LIVE_TIME);
    }

    /**
     * 获取 现有list 的长度
     * @param $key string list的key
     * @return int
     */
    public function getLength($key)
    {
        return Redis::llen($key);
    }

    /**
     * 修改一条hash记录
     * @param $key string hash的key
     * @param $data array 所要修改的键值对
     * @author 郭庆
     */
    public function changeOneHash($key, $data)
    {
        //写入hash
        $result = Redis::hMset($key, $data);
        if (!$result) return false;
        //设置生命周期
        $this->setTime($key);
        return true;
    }

    /**
     * 删除一条list记录
     * @param
     * @author 郭庆
     */
    public function delList($key, $guid)
    {
        if ($this->exists($key)) return Redis::lrem($key, 0, $guid);
        return true;
    }
}