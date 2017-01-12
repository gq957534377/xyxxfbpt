<?php
/**
 * redis底层公共类
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
     * 判断key是否存在
     * @param $key string redis的key
     * @return bool
     * @example
     * <pre>
     * $redis->set('key', 'value');
     * $redis->exists('key');               //  TRUE
     * $redis->exists('NonExistingKey');    // FALSE
     * </pre>
     */
    public function exists($key)
    {
        return Redis::exists($key);  //查询key是否存在
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
     * @example
     * <pre>
     * $redis->rPush('key1', 'A');
     * $redis->rPush('key1', 'B');
     * $redis->rPush('key1', 'C');
     * $redis->lRange('key1', 0, -1); // array('A', 'B', 'C')
     * </pre>
     * @author 郭庆
     */
    public function getBetweenList($key, $start, $end)
    {
        return Redis::lrange($key, $start, $end);
    }

    /**
     * 获取hash的全部字段数据
     * @param $key string hash的key
     * @return [] 成功： array 全部字段的键值对 失败：bool false
     * @example
     * <pre>
     * $redis->delete('h');
     * $redis->hSet('h', 'a', 'x');
     * $redis->hSet('h', 'b', 'y');
     * $redis->hSet('h', 'c', 'z');
     * $redis->hSet('h', 'd', 't');
     * var_dump($redis->hGetAll('h'));
     *
     * // Output:
     * // array(4) {
     * //   ["a"]=>
     * //   string(1) "x"
     * //   ["b"]=>
     * //   string(1) "y"
     * //   ["c"]=>
     * //   string(1) "z"
     * //   ["d"]=>
     * //   string(1) "t"
     * // }
     * // The order is random and corresponds to redis' own internal representation of the set structure.
     * </pre>
     * @author 郭庆
     */
    public function getHash($key, $time = HASH_OVERTIME)
    {
        $data = Redis::hGetAll($key);
        if (!$data) return false;
        //设置生命周期
        $this->setTime($key, $time);
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
    public function addHash($key, $data, $time = HASH_OVERTIME)
    {
        if (empty($key) || empty($data)) return false;

        $result = true;
        if (!$this->exists($key)) {
            //写入hash
            $result = Redis::hMset($key, $data);
        }
        if (!$result) {
            \Log::error('写入hash出错'.$key);
            return false;
        }else{
            //设置生命周期
            return $this->setTime($key, $time);
        }
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
     * 删除指定的 keys.
     *
     * @param   int|array   $key1 An array of keys, or an undefined number of parameters, each a key: key1 key2 key3 ... keyN
     * @param   string      $key2 ...
     * @param   string      $key3 ...
     * @return int Number of keys deleted.
     * @example
     * <pre>
     * $redis->set('key1', 'val1');
     * $redis->set('key2', 'val2');
     * $redis->set('key3', 'val3');
     * $redis->set('key4', 'val4');
     * $redis->delete('key1', 'key2');          // return 2
     * $redis->delete(array('key3', 'key4'));   // return 2
     * </pre>
     */
    public function delKey($key)
    {
        if (empty($key)) return false;
        return Redis::del($key);
    }

    /**
     * 对list进行左推（推一个/多个）
     * @param $key string listkey
     * @param $lists array [guid1,guid2] / $lists string 一次推入一个list
     * @author 郭庆
     */
    public function rPushLists($key, $lists)
    {
        if (empty($key) || empty($lists)) return false;

        //执行写list操作
        if (!Redis::rpush($key, $lists)) return false;

        return true;
    }

    /**
     * 对list进行右推（可以推一个也可以多个）
     * @param $key string listkey
     * @param $lists array [guid1,guid2] / $lists string 一次推入一个list
     * @author 郭庆
     */
    public function lPushLists($key, $lists)
    {
        if (empty($key) || empty($lists)) return false;

        //执行写list操作
        if (!Redis::lpush($key, $lists)) return false;

        return true;
    }
    /**
     * 设置hash缓存的生命周期
     * @param $key  string  需要设置的key
     * @return bool 设置成功true 否则false
     */
    public function setTime($key, $time = HASH_OVERTIME)
    {
        return Redis::expire($key, $time);
    }

    /**
     * 获取 现有list 的长度
     * @param $key string list的key
     * @return int 对应key的list长度
     */
    public function getLength($key)
    {
        return Redis::llen($key);
    }

    /**
     * 删除一条list记录
     * @param $key string list的key
     * @param $guid string 所要删除的list元素
     * @author 郭庆
     */
    public function delList($key, $guid)
    {
        if ($this->exists($key)) return Redis::lrem($key, 0, $guid);
        return true;
    }

    /**
     * 添加一个新的长存的string redis
     * @param
     * @return bool
     * @author 郭庆
     */
    public function addForeverString($key, $value)
    {
        if (empty($key) || empty($value)) return false;
        return Redis::Set($key, $value);
    }

    /**
     * 添加一个新的长存的短存的string redis
     * @param
     * @return bool
     * @author 郭庆
     */
    public function addString($key, $value)
    {
        if (empty($key) || empty($value)) return false;
        return Redis::set($key, $value);
    }

    /**
     * 将 string key 中储存的数字值增一
     *
     * @param   string $key
     * @return  int    the new value
     * @link    http://redis.io/commands/incr
     * @example
     * <pre>
     * $redis->incr('key1'); // key1 didn't exists, set to 0 before the increment and now has the value 1
     * $redis->incr('key1'); // 2
     * $redis->incr('key1'); // 3
     * $redis->incr('key1'); // 4
     * </pre>
     */
    public function incre($key)
    {
        if (empty($key)) return false;
        return Redis::incr($key);
    }

    /**
     * Get the value related to the specified key
     *
     * @param   string  $key
     * @return  string|bool: If key didn't exist, FALSE is returned. Otherwise, the value related to this key is returned.
     * @link    http://redis.io/commands/get
     * @example $redis->get('key');
     */
    public function getString($key)
    {
        if (empty($key)) return false;
        return Redis::get($key);
    }

}