<?php
/**
 * article redis 缓存仓库
 * @author lw  beta
 */
namespace App\Redis;

use App\Tools\CustomPage;
use App\Store\ArticleStore;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\Facades\Redis;

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
            \Log::error('文章模块存储redis异常！！！应存list长度'.$count.'实存长度'.$length);
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
                //\Log::error('文章信息写入redis   List失败！！');
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
                $res = CustomPage::objectToArray(self::$article_store->getOneDatas(['guid' => $v]));
                //将取出的mysql 文章详情写入redis
                $this->addHash(self::$hkey . $v, $res);
                $res = CustomPage::arrayToObject($res);
                $data[] = $res;
            }

        }

        return $data;
    }






}