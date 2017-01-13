<?php
/**
 * college redis 缓存仓库
 * @author 郭庆
 */
namespace App\Redis;

use App\Store\ActionOrderStore;
use App\Tools\CustomPage;
use App\Store\CollegeStore;
use Illuminate\Support\Facades\Log;

class CollegeCache extends MasterCache
{

    private static $lkey = LIST_COLLEGE_;      //列表key
    private static $hkey = HASH_COLLEGE_INFO_;     //hash表key
    private static $orderKey = LIST_COLLEGE_ORDER_;     //hash表key

    private static $college_store;
    private static $actionOrderStore;

    public function __construct(CollegeStore $collegeStore, ActionOrderStore $actionOrderStore)
    {
        self::$college_store = $collegeStore;
        self::$actionOrderStore = $actionOrderStore;
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
            $count = self::$college_store->getCount($where);
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
        $guids = self::$college_store->getGuids($where);

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
    public function getBetweenColleges($where, $start, $end)
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
                //获取制定key的所有学院活动guid
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
            $result = $this->getOneCollege($guid);
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
    public function delCollege($type, $status, $guid)
    {
        if (!$this->delList(self::$lkey . $type . ':' . $status, $guid)) Log::error("删除list（".self::$lkey . $type . ':' . $status."）元素(".$guid.")失败");
        if (!$this->delList(self::$lkey . '-' . ':' . $status, $guid)) Log::error("删除list（".self::$lkey . '-' . ':' . $status."）元素(".$guid.")失败");
        if (!$this->delList(self::$lkey.$type, $guid)) Log::error("删除list（".self::$lkey.$type."）元素(".$guid.")失败");
    }


    /**
     * 添加一条新的list记录
     * @param 将要添加记录的类型，状态，guid
     * @author 郭庆
     */
    public function addCollegeList($type, $status, $guid)
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
        Log::error('redis添加新的学院活动list记录失败,学院活动id：'.$guid);
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
                //获取制定key的所有学院活动guid
                $lists = $this->getPageLists($key, $nums, $nowPage);
            }
        }else{
            //获取制定key的所有学院活动guid
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
    public function changeOneCollege($guid, $data)
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
    public function getOneCollege($guid)
    {
        if (empty($guid)) return false;
        if ($this->exists(self::$hkey.$guid)){
            $data = $this->getHash(self::$hkey.$guid);
        }else{
            $datas = self::$college_store->getOneData(['guid' => $guid]);
            if (!$datas) return false;
            $data = CustomPage::objectToArray($datas);
            $result = $this->addHash(self::$hkey.$guid, $data);
            if (!$result) Log::error('写入一条学院活动hash失败，id为'.$guid);
        }
        return $data;
    }

    /**
     * 后台发布学院活动添加一条新的记录
     * @param $data array 学院活动信息
     * @return array
     * @author 郭庆
     */
    public function insertOneCollege($data)
    {
        $list = $this->addCollegeList($data['type'], $data['status'], $data['guid']);
        if ($list){
            $this->addHash(self::$hkey.$data['guid'], $data);
        }else{
            Log::error('后台发布学院活动存入redis列表失败'.$data['guid']);
        }
    }

    /**
     * 修改一条学院活动的状态
     * @param
     * @return array
     * @author 郭庆
     */
    public function changeStatusCollege($guid, $status)
    {
        $data = $this->getOneCollege($guid);
        $oldStatus = $data['status'];
        $oldType = $data['type'];

        //修改hash中的状态字段
        $this->changeOneCollege($guid, ['status' => $status, 'addtime' => time()]);
        //删除旧的索引记录
        $this->delCollege($oldType, $oldStatus, $guid);
        //根据新的状态添加新的索引list记录
        $this->addCollegeList($oldType, $status, $guid);
    }

    public function getOrderColleges($userid)
    {
        $key = self::$orderKey.$userid;
        if ($this->exists($key)){
            return $this->getBetweenList($key, 0, -1);
        }else{
            $actions = self::$actionOrderStore->getSomeField(['user_id'=>session('user')->guid], 'action_id');
            if ($actions){
                if ($this->rPushLists($key, $actions)) Log::error('redis写入报名记录失败，key为：'.$key);
                return $actions;
            }else{
                if ($actions == []) return [];
            }
        }
    }
}