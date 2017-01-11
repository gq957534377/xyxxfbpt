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

class ActionCache extends MasterCache
{

    private static $lkey = LIST_ACTION_GUID_;      //项目列表key
    private static $hkey = HASH_ACTION_INFO_;     //项目hash表key

    private static $action_store;

    public function __construct(ActionStore $actionStore)
    {
        self::$action_store = $actionStore;
    }

    /**
     * 根据where条件确定key
     * @param $where array ['type' => 1, 'status' => 2]
     * @author 郭庆
     */
    public function getlistKey($where)
    {
        $key = '';
        if (empty($where['type']) && !empty($where['status'])){
            $key = self::$lkey.'-'.':'.$where['status'];
        }elseif (!empty($where['type']) && !empty($where['status'])){
            $key = self::$lkey.$where['type'].':'.$where['status'];
        }elseif (!empty($where['type']) && empty($where['status'])){
            $key = self::$lkey.$where['type'];
        }else{
            return false;
        }
        return $key;
    }

    /**
     * 获取符合条件的数据总条数
     * @param
     * @author 郭庆
     */
    public function getCount($where)
    {
        //拼接list key
        $key = $this -> getlistKey($where);
        if (!$key) return false;

        //计算总数
        if (!$this->exists($key)){
            $count = self::$action_store->getCount($where);
        }else{
            $count = $this->getLength($key);
        }
        return $count;
    }

    /**
     * 获取某一页的数据
     * @param
     * @author 郭庆
     */
    public function getPageDatas($where, $nums, $nowPage)
    {
        //拼接list key
        $key = $this -> getlistKey($where);
        if (!$key) return false;

        //如果list不存在，从数据库去除所有guid并存入redis
        if (!$this->exists($key)){
            //从数据库获取所有的guid
            $guids = self::$action_store->getGuids($where);

            if (!$guids) return false;
            //将获取到的所有guid存入redis
            $redisList = $this->addLists($key, $guids);
            if (!$redisList) Log::error("将数据库数据写入list失败");
        }

        //获取制定key的所有活动guid
        $lists = $this->getPageLists($key, $nums, $nowPage);
        if (!$lists) return false;

        $data = [];
        //获取所有的data数据
        foreach ($lists as $guid){
            //获取到一条数据
            $result = $this->getOneAction($guid);
            //将获取的数据转对象存入数组和数据库一个样子
            if (!empty($result)){
                $data[] = CustomPage::arrayToObject($result);
            }else{
                return false;
            }
        }
        return $data;
    }

    /**
     * 删除一条记录
     * @param 将要删除记录的类型，状态，guid
     * @return array
     * @author 郭庆
     */
    public function delList($type, $status, $guid)
    {
        if ($this->exists(self::$lkey.$type.':'.$status)){
            Redis::lrem(self::$lkey.$type.':'.$status, 0, $guid);
        }
        if ($this->exists(self::$lkey.'-'.':'.$status)){
            Redis::lrem(self::$lkey.'-'.':'.$status, 0, $guid);
        }
        if ($this->exists(self::$lkey.$type)){
            Redis::lrem(self::$lkey.$type, 0, $guid);
        }
    }


    /**
     * 添加一条新的list记录
     * @param 将要添加记录的类型，状态，guid
     * @author 郭庆
     */
    public function addList($type, $status, $guid)
    {
        if (empty($guid)) return false;
        $list = Redis::lpush(self::$lkey.$type.':'.$status, $guid);
        if ($status != 4){
            $list1 = Redis::lpush(self::$lkey.$type, $guid);
        }else{
            $list1 = true;
        }
        $list2 = Redis::lpush(self::$lkey.'-'.':'.$status, $guid);
        if ($list && $list1 && $list2) return true;
        return false;
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
     * 获取一条hash所有字段详情
     * @param $guid
     * @author 郭庆
     */
    public function getOneAction($guid)
    {
        if (empty($guid)) return false;
        if ($this->exists(self::$hkey.$guid)){
            $data = $this->getHash(self::$hkey.$guid);
        }else{
            $datas = self::$action_store->getOneData(['guid' => $guid]);
            if (!$datas) return false;
            $data = CustomPage::objectToArray($datas);
            $result = $this->addHash(self::$hkey.$guid, $data);
            if (!$result) Log::error('写入一条活动hash失败，id为'.$guid);
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