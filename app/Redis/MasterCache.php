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
        return Redis::lrange($key, $offset, $totals);

    }

    /**
     * 获取hash的指定几个字段的数据
     * @param $key string hash的key
     * @param $key array hash的指定几个字段 array('field1', 'field2')
     * @return array
     * @author 郭庆
     */
    public function getHash($key)
    {
        Redis::hGetAll($key);
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



}