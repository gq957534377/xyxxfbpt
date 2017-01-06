<?php
/**
 * college redis 缓存仓库
 * @author lw  beta
 */
namespace App\Redis;

use App\Tools\CustomPage;
use App\Store\CollegeStore;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\Facades\Redis;

class CollegeCache
{

    private static $lkey = LIST_COLLEGE_;      //项目列表key
    private static $hkey = HASH_COLLEGE_INFO_;     //项目hash表key

    private static $college_store;

    public function __construct(CollegeStore $collegeStore)
    {
        self::$college_store = $collegeStore;
    }

    /**
     * 判断listkey或者hashkey是否存在
     * @param $list bool list为真查询listkey,否则查询hashkey
     * @param $index string   唯一识别码 guid
     * @return bool
     */
    public function exists($index, $list=true)
    {
        if($list){
            return Redis::exists(self::$lkey.$index);  //查询listkey是否存在
        }else{
            return Redis::exists(self::$hkey.$index);   //查询拼接guid对应的hashkey是否存在
        }
    }

    /**
     * 添加一条新的记录
     * @param
     * @return array
     * @author 郭庆
     */
    public function insertOneCollege($data)
    {
        $list = Redis::lpush(self::$lkey.$data['type'].':1', $data['guid']);
        $list1 = Redis::lpush(self::$lkey.$data['type'], $data['guid']);
        $list2 = Redis::lpush(self::$lkey.'-'.':1', $data['guid']);
        if ($list && $list1 && $list2){
            //如果hash存在则不执行写操作
            if(!$this->exists($data['guid'], false)){
                $index = self::$hkey.$data['guid'];
                //写入hash
                Redis::hMset($index, $data);
                //设置生命周期
                $this->setTime($index);
            }
        }else{
            Log::info('发布学院活动存入redis失败'.$data['guid']);
        }
    }

    /**
     * 修改一条记录
     * @param
     * @return array
     * @author 郭庆
     */
    public function changeOneCollege($guid, $data)
    {
        //如果hash存在则修改
        if ($this->exists($guid, false)) {
            $index = self::$hkey . $guid;
            //写入hash
            Redis::hMset($index, $data);
            //设置生命周期
            $this->setTime($index);
        }
    }

    /**
     * 将mysql获取的列表信息写入redis缓存
     * @param $data  array   mysql 获取的信息
     */
    public function setCollegeList($where, $data)
    {
        //执行写操作
        $this->insertCache($where, $data);
    }

    /**
     * 写入redis
     * @param $data
     * @return bool
     */
    protected function insertCache($where, $data)
    {
        if (empty($data)) return false;
        if (!empty($where['type'])){
            if (!empty($where['status'])){
                foreach ($data as $v){
                    //执行写list操作
                    Redis::rpush(self::$lkey.$where['type'].':'.$where['status'], $v['guid']);

                    //如果hash存在则不执行写操作
                    if(!$this->exists($v['guid'], false)){
                        $index = self::$hkey.$v['guid'];
                        //写入hash
                        Redis::hMset($index, $v);
                        //设置生命周期
                        $this->setTime($index);
                    }
                }
            }else{
                foreach ($data as $v){
                    //执行写list操作
                    Redis::rpush(self::$lkey.$where['type'], $v['guid']);

                    //如果hash存在则不执行写操作
                    if(!$this->exists($v['guid'], false)){
                        $index = self::$hkey.$v['guid'];
                        //写入hash
                        Redis::hMset($index, $v);
                        //设置生命周期
                        $this->setTime($index);
                    }
                }
            }
        }else{
            foreach ($data as $v){
                //执行写list操作
                Redis::rpush(self::$lkey.'-'.':'.$where['status'], $v['guid']);

                //如果hash存在则不执行写操作
                if(!$this->exists($v['guid'], false)){
                    $index = self::$hkey.$v['guid'];
                    //写入hash
                    Redis::hMset($index, $v);
                    //设置生命周期
                    $this->setTime($index);
                }
            }
        }


    }

    /**
     * 写入一条hash 文章详情
     * @param $data
     * @return bool
     */
    public function setOneCollege($data)
    {
        if(empty($data)) return false;
        return Redis::hMset(self::$hkey.$data['guid'], $data);
    }

    /**
     * 获取一条文章详情
     * @param $guid
     */
    public function getOneCollege($guid)
    {
        if(!$guid) return false;

        $index = self::$hkey.$guid;
        //获取一条详情
        $data = Redis::hGetall($index);
        //重设生命周期 1800秒
        $this->setTime($index);
        return $data;
    }

    /**
     * 获取redis缓存里的文章列表数据
     * @param $nums int  一次获取的条数
     * @param  $pages int  当前页数
     * @return array
     */
    public function getCollegeList($where, $nums, $pages)
    {
        //起始偏移量
        $offset = $nums * ($pages-1);

        //获取条数
        $totals = $offset + $nums - 1;

        if (!empty($where['type'])){
            if (!empty($where['status'])){
                //获取缓存的列表索引
                $list = Redis::lrange(self::$lkey.$where['type'].':'.$where['status'], $offset,$totals);
            }else{
                $list = Redis::lrange(self::$lkey.$where['type'], $offset,$totals);
            }
        }else{
            $list = Redis::lrange(self::$lkey.'-'.':'.$where['status'], $offset,$totals);
        }

        $data = [];

        //根据获取的list元素 取hash里的集合
        foreach ($list as $v) {
            //获取一条hash
            if($this->exists('',$v)){
                $content = Redis::hGetall(self::$hkey.$v);
                //给对应的Hash文章增加生命周期
                $this->setTime(self::$hkey.$v);
                $data[] = $content;
            }else{
                //如果对应的hash key为空，说明生命周期结束，就再次去数据库取一条存入缓存
                $res = CustomPage::objectToArray(self::$college_store->getOneData(['guid'=>$v]));
                //将取出的mysql 文章详情写入redis
                $this->setOneCollege($res);
                $data[] = $res;
            }

        }

        return $data;
    }

    /**
     * 获取 现有list 的长度
     * @return bool
     */
    public function getLength($where)
    {
        if (empty($where['type'])){
            return Redis::llen(self::$lkey.'-'.":".$where['status']);
        }
        if (!empty($where['status'])){
            return Redis::llen(self::$lkey.$where['type'].":".$where['status']);
        }else{
            return Redis::llen(self::$lkey.$where['type']);
        }
    }

    /**
     * 设置hash缓存的生命周期
     * @param $key  string  需要设置的key
     * @param int $time  设置的时间 默认半个小时
     */
    public function setTime($key, $time = 1800)
    {
        Redis::expire($key, $time);
    }

    /**
     * 返回队列key
     * @return string
     */
    public function listKey()
    {
        return self::$lkey;
    }

    /**
     * 返回hash索引key前缀
     * @return string
     */
    public function hashKey()
    {
        return self::$hkey;
    }

}