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

class ArticleCache
{

    private static $lkey = LIST_ARTICLE_INFO;      //项目列表key
    private static $hkey = HASH_ARTICLE_INFO_;     //项目hash表key

    private static $article_store;

    public function __construct(ArticleStore $articleStore)
    {
        self::$article_store = $articleStore;
    }

    /**
     * 判断listkey和hashkey是否存在
     * @param $type string list为查询listkey,否则查询hashkey
     * @param $index string   唯一识别码 guid
     * @return bool
     */
    public function exists($type = 'list', $index = '')
    {
        if($type == 'list'){
            return Redis::exists(self::$lkey);  //查询listkey是否存在
        }else{
            return Redis::exists(self::$hkey.$index);   //查询拼接guid对应的hashkey是否存在
        }

    }
    /**
     * 判断listkey是否存在 指定类型的redis
     * @param $type string list为查询listkey,否则查询hashkey
     * @param $index string   唯一识别码 guid
     * @return bool
     */
    public function existsArticleList($type = '1')
    {
        return Redis::exists(self::$lkey . $type);  //查询listkey是否存在

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
        $this->insertCache($data);
        //获取存入的list缓存长度
        $length = $this->getLength($type);
        if($length != $count){
            \Log::error('文章模块存储redis异常！！！');
        }
        return true;

    }

    /**
     * 写入redis
     * @param $data
     * @return bool
     */
    public function insertCache($data)
    {
        if (empty($data)) return false;
        $data = CustomPage::objectToArray($data);
        foreach ($data as $v){
            //执行写list操作
            if (!Redis::rpush(self::$lkey . $v['type'], $v['guid'])) {
                Log::error('文章信息写入redis   List失败！！');
            };

            //如果hash存在则不执行写操作
            if(!$this->exists($type = '', $v['guid'])){

                $index = self::$hkey . $v['guid'];
                //写入hash
                Redis::hMset($index, $v);
                //设置生命周期
                $this->setTime($index);
            }

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
            if (!Redis::lPush(self::$lkey . $v['type'], $v['guid'])) {
                Log::error('文章信息写入redis   List失败！！');
            };

            //如果hash存在则不执行写操作
            if(!$this->exists($type = '', $v['guid'])){

                $index = self::$hkey . $v['guid'];
                //写入hash
                Redis::hMset($index, $v);
                //设置生命周期
                $this->setTime($index);
            }

        }
        return true;
    }

    /**
     * 写入一条hash 文章详情
     * @param $data
     * @return bool
     */
    public function setOneArticle($data)
    {
        if(empty($data)) return false;
        return Redis::hMset(self::$hkey.$data['guid'], $data);
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
        $data = Redis::hGetall($index);
        if (empty($data)) {
            //如果对应的hash key为空，说明生命周期结束，就再次去数据库取一条存入缓存
            $result = self::$article_store->getOneDatas(['guid' => $guid]);
            if ($result == '') return false;
            $data = CustomPage::objectToArray($result);
            //将取出的mysql 文章详情写入redis
            $this->setOneArticle($data);
        }
        //重设生命周期 1800秒
        $this->setTime($index);
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
        $list = Redis::lrange(self::$lkey . $type, $offset, $totals);

        $data = [];

        //根据获取的list元素 取hash里的集合
        foreach ($list as $v) {
            //获取一条hash
            if($this->exists('', $v)){
                $content = Redis::hGetall(self::$hkey . $v);
                //给对应的Hash文章增加生命周期
                $this->setTime(self::$hkey.$v);
                $data[] = $content;
            }else{
                //如果对应的hash key为空，说明生命周期结束，就再次去数据库取一条存入缓存
                $res = CustomPage::objectToArray(self::$article_store->getOneDatas(['guid' => $v]));
                //将取出的mysql 文章详情写入redis
                $this->setOneArticle($res);
                $data[] = $res;
            }

        }

        return $data;
    }

    /**
     * 获取 现有list 的长度
     * @return bool
     */
    public function getLength($type)
    {
        if($this->existsArticleList($type)){
            return Redis::llen(self::$lkey . $type);
        }
        return false;
    }

    /**
     * 删除指定list的值
     * @param $type
     * @param $guid
     * @return bool|int
     * @author 王通
     */
    public function delListKey($type, $guid)
    {
        if (empty($guid)) return false;
        //dd($type, $guid, self::$lkey);
        return Redis::lRem(self::$lkey . $type, 1, $guid);
    }

    /**
     * 删除哈希
     * @param $guid
     * @return mixed
     * @author 王通
     */
    public function delHashKey($guid)
    {
        if (empty($guid)) return false;
        return Redis::del(self::$lkey . $guid);
    }
    /**
     * 在list左边插入数据
     * @param $data
     * @return bool
     * @author 王通
     */
    public function setLeftList($data)
    {
        if (Redis::lPush(self::$lkey . $data['type'], $v['guid'])) {
            Log::error('文章信息写入redis   List失败！！');
        };
        return false;
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