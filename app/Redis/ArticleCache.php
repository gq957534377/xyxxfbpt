<?php
/**
 * article redis 缓存仓库
 * @author lw  beta
 */
namespace App\Redis;

use App\Tools\CustomPage;
use App\Store\ArticleStore;
use Log;

class ArticleCache extends MasterCache
{

    private static $lkey = LIST_ARTICLE_INFO_;      //项目列表key
    private static $hkey = HASH_ARTICLE_INFO_;     //项目hash表key

    private static $article_store;

    public function __construct(ArticleStore $articleStore)
    {
        self::$article_store = $articleStore;
    }

    /**
     * 获取符合条件的数据总条数
     * @param $where []
     * @author 郭庆
     */
    public function getCount($where)
    {
        //拼接list key
        $key = self::$lkey. $where['type'];
        if (!$key) return false;

        //计算总数
        if (!$this->exists($key)){
            $count = self::$article_store->getCount($where);
        }else{
            $count = $this->getLength($key);
        }
        return $count;
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
        $key = LIST_ARTICLE_INFO_.$where['type'];
        $where['status'] = 1;
        if (!$key) return false;
        //如果list不存在，从数据库取出所有guid并存入redis
        if (!$this->exists($key)){
            $result = $this->mysqlToList($where, $key);
            if (!$result) return false;
            if (is_array($result)){
                //起始偏移量
                $offset = $nums * ($nowPage-1);

                //获取条数
                $totals = $offset + $nums;

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
            $result = $this->getOneArticle($guid);
            //将获取的数据转对象存入数组和数据库一个样子
            if (!empty($result)){
                $result = CustomPage::arrayToObject($result);
                $data[] = $result;
            }else{
                return false;
            }
        }
        return $data;
    }
    /**
     * 将mysql获取的列表信息写入redis缓存
     * @param $data  array   mysql 获取的信息
     */
    public function setArticleList($data, $type)
    {
        //获取原始信息长度
        $count = count($data);

        //执行写操作
        $this->rPushLists(self::$lkey.$type, $data);
        //获取存入的list缓存长度
        $length = $this->getLength(self::$lkey . $type);
        if($length != $count){
            Log::error('文章模块存储redis异常！！！应存list长度'.$count.'实存长度'.$length);
        }
        return true;

    }


    /**
     * 从左边写入redis
     * @param $data
     * @return bool
     * @author 王通
     */
    public function insertLeftCache($data)
    {
        if (empty($data)) return false;
        $data = CustomPage::objectToArray($data);
        foreach ($data as $v){
            //执行写list操作
            if (!$this->lPushLists(self::$lkey . $v['type'], $v['guid'])) {
                Log::error('文章信息写入redis   List失败！！');
            };

        }
        return true;
    }

    /**
     * 获取一条hash所有字段详情
     * @param $guid
     * @author 郭庆
     */
    public function getOneArticle($guid)
    {
        if (empty($guid)) return false;
        if ($this->exists(self::$hkey.$guid)){
            $data = $this->getHash(self::$hkey.$guid);
        }else{
            $datas = self::$article_store->getOneData(['guid' => $guid]);
            if (!$datas) return false;
            $data = CustomPage::objectToArray($datas);
            $result = $this->addHash(self::$hkey.$guid, $data);
            if (!$result) Log::error('写入一条文章hash失败，id为'.$guid);
        }
        return $data;
    }

    /**
     * 获取redis缓存里的文章列表数据
     * @param $nums int  一次获取的条数
     * @param  $pages int  当前页数
     * @return array
     */
    public function getArticleList($nums, $pages, $type)
    {
        //起始偏移量
        $offset = $nums * ($pages - 1);

        //获取条数
        $totals = $offset + $nums - 1;

        //获取缓存的列表索引
        $list = $this->getBetweenList(self::$lkey . $type, $offset, $totals);

        $data = [];

        //根据获取的list元素 取hash里的集合
        foreach ($list as $v) {
            //获取一条hash
            if($this->exists(self::$hkey . $v)){
                $content = $this->getHash(self::$hkey . $v);
                $content = CustomPage::arrayToObject($content);
                $data[] = $content;
            }else{
                //如果对应的hash key为空，说明生命周期结束，就再次去数据库取一条存入缓存
                $info = self::$article_store->getOneDatas(['guid' => $v]);
                // 判断数据库中数据是否存在
                if (!empty($info)) {
                    $res = CustomPage::objectToArray($info);
                    //将取出的mysql 文章详情写入redis
                    $this->addHash(self::$hkey . $v, $res);
                    $res = CustomPage::arrayToObject($res);
                    $data[] = $res;

                    // 如果数据库中数据不存在，怎删除LIST的键值，并且打印错误日志
                } else {
                    $this->delList(self::$lkey, $v);
                    Log::info('Redis出错，文章信息，LIST  KEY 在数据库中不存在。请选择，是否清理redis');
                }

            }

        }

        return $data;
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
        $guids = self::$article_store->getAllGuid($where);
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
    public function checkList($key, $type)
    {
        $sqlLength = self::$article_store->getCount(['type' => $type, 'status' => '1']);
        if (!$this->exists($key)) return true;
        $listLength = count(array_unique($this->getBetweenList($key, 0, -1)));

        if ($sqlLength != $listLength) {
            if (!$this->delKey($key)) return false;
            return $this->mysqlToList(['type' => $type, 'status' => '1'], $key);
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
        if (!$this->checkList(self::$lkey.'1', 1)) Log::warning('任务调度，检测到list异常，未成功解决'.self::$lkey.'1');
        if (!$this->checkList(self::$lkey.'2', 2)) Log::warning('任务调度，检测到list异常，未成功解决'.self::$lkey.'2');
    }




}