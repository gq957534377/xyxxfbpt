<?php
/**
 * action redis 缓存仓库
 * @author lw  beta
 */
namespace App\Redis;

use App\Tools\CustomPage;
use App\Store\ActionStore;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ActionCache
{

    private static $lkey = LIST_ACTION_;      //项目列表key
    private static $hkey = HASH_ACTION_INFO_;     //项目hash表key

    private static $action_store;

    public function __construct(ActionStore $actionStore)
    {
        self::$action_store = $actionStore;
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
     * 将mysql获取的列表信息写入redis缓存
     * @param $data  array   mysql 获取的信息
     */
    public function setActionList($where, $data)
    {
        //获取原始信息长度
        $count = count($data);

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

    }

    /**
     * 写入一条hash 文章详情
     * @param $data
     * @return bool
     */
    public function setOneAction($data)
    {
        if(empty($data)) return false;
        return Redis::hMset(self::$hkey.$data['guid'], $data);
    }

    /**
     * 获取一条文章详情
     * @param $guid
     */
    public function getOneAction($guid)
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
     * 添加一条新的记录
     * @param
     * @return array
     * @author 郭庆
     */
    public function insertOneAction($data)
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
            Log::info('发布活动存入redis失败'.$data['guid']);
        }
    }

    /**
     * 修改一条记录
     * @param
     * @return array
     * @author 郭庆
     */
    public function changeOneAction($guid, $data)
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
     * 修改一条活动的状态
     * @param
     * @return array
     * @author 郭庆
     */
    public function changeStatusAction($guid, $status)
    {
        $data = $this->getOneAction($guid);
        $oldStatus = $data['status'];
        $oldType = $data['type'];
        //修改hash中的状态字段
        $this->changeOneAction($guid, ['status'=>$status]);
        //删除旧的索引记录
        $this->delList($oldType, $oldStatus, $guid);
        //根据新的状态添加新的索引list记录
        $this->addList($oldType, $status, $guid);
    }

    /**
     * 删除一条记录
     * @param 多要删除记录的类型，状态，guid
     * @return array
     * @author 郭庆
     */
    public function delList($type, $status, $guid)
    {
        if ($this->exists($type.':'.$status)){
            Log::info('进入删除1');
            Log::info(self::$lkey.$type.':'.$status);
            Redis::lrem(self::$lkey.$type.':'.$status, 0, $guid);
        }
        if ($this->exists('-'.':'.$status)){
            Log::info('进入删除2');
            Redis::lrem(self::$lkey.'-'.':'.$status, 0, $guid);
        }
        if ($this->exists($type)){
            Log::info('进入删除3');
            Redis::lrem(self::$lkey.$type, 0, $guid);
        }
    }

    /**
     * 添加一条新的list记录
     * @param 多要删除记录的类型，状态，guid
     * @return array
     * @author 郭庆
     */
    public function addList($type, $status, $guid)
    {
        $list = Redis::lpush(self::$lkey.$type.':'.$status, $guid);
        $list1 = Redis::lpush(self::$lkey.$type, $guid);
        $list2 = Redis::lpush(self::$lkey.'-'.':'.$status, $guid);
    }

    /**
     * 获取redis缓存里的文章列表数据
     * @param $nums int  一次获取的条数
     * @param  $pages int  当前页数
     * @return array
     */
    public function getActionList($where, $nums, $pages)
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
            return [];
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
                $res = CustomPage::objectToArray(self::$action_store->getOneData(['guid'=>$v]));
                //将取出的mysql 文章详情写入redis
                $this->setOneAction($res);
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