<?php
/**
 * action redis 缓存仓库
 * @author lw  beta
 */
namespace App\Redis;

use App\Tools\CustomPage;
use App\Store\ActionStore;
use Illuminate\Support\Facades\Log;

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
     * @param $where []
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
     * 将指定条件查询到的所有guid加入redis list中
     * @param $where [] 查询条件
     * @param $key string list KEY
     * @author 郭庆
     */
    public function mysqlToList($where, $key)
    {
        //从数据库获取所有的guid
        $guids = self::$action_store->getGuids($where);

        if (!$guids) return false;
        //将获取到的所有guid存入redis
        $redisList = $this->rPushLists($key, $guids);
        if (!$redisList) {
            Log::error("将数据库数据写入list失败,list为：".$key);
            return $guids;
        }else{
            return true;
        }
    }

    /**
     * 根据制定条件获取指定list范围内的数据
     * @param $where array ['status'=>1]
     * @param $start int 0-count
     * @param $end int 0-count
     * @author 郭庆
     */
    public function getBetweenActions($where, $start, $end)
    {
        //拼接list key
        $key = $this -> getlistKey($where);

        //如果list不存在，从数据库取出所有guid并存入redis
        if (!$this->exists($key)){
            $result = $this->mysqlToList($where, $key);
            if (!$result) return false;
            if (is_array($result)){
                $lists = array_slice($result, $start, $end);
            }else{
                //获取制定key的所有活动guid
                $lists = $this->getBetweenList($key, $start, $end);
            }
        }else{
            $lists = $this->getBetweenList($key, $start, $end);
        }

        return $this->getDataByList($lists);
    }

    /**
     * 通过获取到的list索引来获取详细信息数组
     * @param $lists array [$guid1,$guid2,$guid3]
     * @author 郭庆
     */
    public function getDataByList($lists)
    {
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
     * @author 郭庆
     */
    public function delAction($type, $status, $guid)
    {
        $result = true;
        $result = $this->delList(self::$lkey . $type . ':' . $status, $guid);
        $result = $this->delList(self::$lkey . '-' . ':' . $status, $guid);
        $result = $this->delList(self::$lkey.$type, $guid);
        if (!$result) Log::error('redis删除一条活动list记录失败，活动id：'.$guid);
        return $result;
    }


    /**
     * 添加一条新的list记录
     * @param 将要添加记录的类型，状态，guid
     * @author 郭庆
     */
    public function addActionList($type, $status, $guid)
    {
        if (empty($guid)) return false;
        $list = $this->lPushLists(self::$lkey.$type.':'.$status, $guid);
        if ($status != 4){
            $list1 = $this->lPushLists(self::$lkey.$type, $guid);
        }else{
            $list1 = true;
        }
        $list2 = $this->lPushLists(self::$lkey.'-'.':'.$status, $guid);
        if ($list && $list1 && $list2) return true;
        Log::error('redis添加新的活动list记录失败,活动id：'.$guid);
        return false;
    }

    /**
     * 获取某一页的数据
     * @param $where []
     * @param $nums int 每页显示的条数
     * @param $nowPage int 当前页数
     * @author 郭庆
     */
    public function getPageDatas($where, $nums, $nowPage)
    {
        //拼接list key
        $key = $this -> getlistKey($where);
        if (!$key) return false;

        //如果list不存在，从数据库取出所有guid并存入redis
        if (!$this->exists($key)){
            $result = $this->mysqlToList($where, $key);
            if (!$result) return false;
            if (is_array($result)){
                //起始偏移量
                $offset = $nums * ($nowPage-1);

                //获取条数
                $totals = $offset + $nums - 1;

                $lists = array_slice($result, $offset, $totals);
            }else{
                //获取制定key的所有活动guid
                $lists = $this->getPageLists($key, $nums, $nowPage);
            }
        }else{
            //获取制定key的所有活动guid
            $lists = $this->getPageLists($key, $nums, $nowPage);
        }

        if (!$lists) return false;

        return $this->getDataByList($lists);
    }

    /**
     * 修改一条hash记录
     * @param $guid string 所要修改记录的guid
     * @param $data array 所要修改字段的键值对
     * @author 郭庆
     */
    public function changeOneAction($guid, $data)
    {
        if (empty($data) || empty($guid) || !is_array($data)) return false;
        $key = self::$hkey.$guid;
        //修改hash
        $result = $this->changeOneHash($key, $data);
        if (!$result) \Log::error('redis修改hash出错，key为：'.$key);
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
     * @param $data array 活动信息
     * @return array
     * @author 郭庆
     */
    public function insertOneAction($data)
    {
        $list = $this->addActionList($data['type'], $data['status'], $data['guid']);
        if ($list){
            $this->addHash(self::$hkey.$data['guid'], $data);
        }else{
            Log::error('后台发布活动存入redis列表失败'.$data['guid']);
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
        $this->changeOneAction($guid, ['status' => $status, 'addtime' => time()]);
        //删除旧的索引记录
        $this->delAction($oldType, $oldStatus, $guid);
        //根据新的状态添加新的索引list记录
        $this->addActionList($oldType, $status, $guid);
    }

}