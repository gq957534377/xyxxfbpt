<?php
/**
 * action redis 缓存仓库
 * @author lw  beta
 */
namespace App\Redis;

use App\Store\ActionOrderStore;
use App\Tools\CustomPage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ActionOrderCache
{

    private static $lkey = LIST_ACTIONORDER_;      //项目列表key
    private static $hkey = HASH_ACTION_INFO_;     //项目hash表key

    private static $actionOrderStore;

    public function __construct(ActionOrderStore $actionOrderStore)
    {
        self::$actionOrderStore = $actionOrderStore;
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
     * 删除一条记录
     * @param 将要删除记录的类型，状态，guid
     * @return array
     * @author 郭庆
     */
    public function delList($user_id, $action_id)
    {
        if ($this->exists($user_id)){
            Redis::lrem(self::$lkey.$user_id, 0, $action_id);
        }
    }

    /**
     * 添加一条新的list记录
     * @param 将要添加记录的类型，状态，guid
     * @author 郭庆
     */
    public function addList($user_id, $action_id)
    {
        $list = Redis::lpush(self::$lkey.$user_id, $action_id);
        if ($list) return true;
        return false;
    }

    /**
     * 将一条记录写入hash
     * @param
     * @return array
     * @author 郭庆
     */
    public function addHash($data)
    {
        $index = self::$hkey . $data['guid'];
        if (!$this->exists($data['guid'], false)) {
            //写入hash
            Redis::hMset($index, $data);
        }
        //设置生命周期
        $this->setTime($index);
    }

    /**
     * 修改一条hash记录
     * @param
     * @return array
     * @author 郭庆
     */
    public function changeOneHash($guid, $data)
    {
        $index = self::$hkey . $guid;
        //写入hash
        Redis::hMset($index, $data);
        //设置生命周期
        $this->setTime($index);
    }

    /**
     * 获取一条文章详情
     * @param $guid
     */
    public function getOneAction($guid)
    {
        if(!$guid) return false;
        $index = self::$hkey.$guid;
        if ($this->exists($guid, false)){
            $data = Redis::hGetall($index);
            //重设生命周期 1800秒
            $this->setTime($index);
        }else{
            $data = CustomPage::objectToArray(self::$action_store->getOneData(['guid'=>$guid]));
            $this->addHash($data);
        }
        return $data;
    }

    /**
     * 后台发布活动添加一条新的记录
     * @param
     * @return array
     * @author 郭庆
     */
    public function insertOneAction($data)
    {
        $list = $this->addList($data['type'], $data['status'], $data['guid']);
        if ($list){
            $this->addHash($data);
        }else{
            Log::warning('后台发布活动存入redis列表失败'.$data['guid']);
        }
    }

    /**
     * 将数据库查询到的数据写入redis
     * 写入redis
     * @param $data
     * @return bool
     */
    public function insertCache($where, $data)
    {
        if (empty($data)) return false;
        if (!empty($where['type'])){
            if (!empty($where['status'])){
                foreach ($data as $v){
                    //执行写list操作
                    Redis::rpush(self::$lkey.$where['type'].':'.$where['status'], $v['guid']);

                    //如果hash存在则不执行写操作
                    $this->addHash($v);
                }
            }else{
                foreach ($data as $v){
                    //执行写list操作
                    Redis::rpush(self::$lkey.$where['type'], $v['guid']);
                    //如果hash存在则不执行写操作
                    $this->addHash($v);
                }
            }
        }else{
            foreach ($data as $v){
                //执行写list操作
                Redis::rpush(self::$lkey.'-'.':'.$where['status'], $v['guid']);

                //如果hash存在则不执行写操作
                $this->addHash($v);
            }
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
        $this->changeOneHash($guid, ['status'=>$status]);
        //删除旧的索引记录
        $this->delList($oldType, $oldStatus, $guid);
        //根据新的状态添加新的索引list记录
        $this->addList($oldType, $status, $guid);
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
                $list = Redis::lrange(self::$lkey.$where['type'], $offset, $totals);
            }
        }else{
            $list = Redis::lrange(self::$lkey.'-'.':'.$where['status'], $offset,$totals);
        }

        $data = [];

        //根据获取的list元素 取hash里的集合
        foreach ($list as $v) {
            //获取一条hash
            $data[] = $this->getOneAction($v);
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