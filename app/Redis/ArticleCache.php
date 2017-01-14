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
     * 获取一条文章详情
     * @param $guid
     * @return array
     */
    public function getOneArticle($guid)
    {
        if(!$guid) return false;

        $index = self::$hkey . $guid;
        //获取一条详情
        $data = $this->getHash($index);
        if (empty($data)) {
            //如果对应的hash key为空，说明生命周期结束，就再次去数据库取一条存入缓存
            $result = self::$article_store->getOneDatas(['guid' => $guid]);
            if ($result == '') return false;
            $data = CustomPage::objectToArray($result);
            //将取出的mysql 文章详情写入redis
            $this->addHash(self::$hkey.$data['guid'], $data);
        }
        return CustomPage::arrayToObject($data);
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
        if (!$this->checkList(self::$lkey.'1:1', ['type' => 1, 'status' => 1])) Log::waring('任务调度，检测到list异常，未成功解决'.self::$lkey.'1:1');
        if (!$this->checkList(self::$lkey.'2:1', ['type' => 2, 'status' => 1])) Log::waring('任务调度，检测到list异常，未成功解决'.self::$lkey.'2:1');
    }




}