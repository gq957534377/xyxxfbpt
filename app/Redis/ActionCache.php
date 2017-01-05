<?php
/**
 * action redis 缓存仓库
 * @author lw  beta
 */
namespace App\Redis;

use App\Tools\CustomPage;
use App\Store\ArticleStore;
use Illuminate\Support\Facades\Redis;

class ArticleCache
{

    private static $lkey = LIST_ACTION_INFO;      //项目列表key
    private static $hkey = HASH_ACTION_INFO_;     //项目hash表key

    private static $action_store;

    public function __construct(ArticleStore $actionStore)
    {
        self::$action_store = $actionStore;
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
     * 将mysql获取的列表信息写入redis缓存
     * @param $data  array   mysql 获取的信息
     */
    public function setArticleList($data)
    {
        //获取原始信息长度
        $count = count($data);

        //执行写操作
        $this->insertCache($data);

        //获取存入的list缓存长度
        $length = $this->getLength();

        if($length < $count){

        }

    }

    /**
     * 写入redis
     * @param $data
     * @return bool
     */
    protected function insertCache($data)
    {
        if (empty($data)) return false;
        foreach ($data as $v){
            //执行写list操作
            Redis::rpush(self::$lkey, $v['guid']);

            //如果hash存在则不执行写操作
            if(!$this->exists($type = '', $v['guid'])){

                $index = self::$hkey.$v['guid'];
                //写入hash
                Redis::hMset($index, $v);
                //设置生命周期
                $this->setTime($index);
            }

        }
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
    public function getArticleList($nums,$pages)
    {
        //起始偏移量
        $offset = $nums * ($pages-1);

        //获取条数
        $totals = $offset + $nums - 1;

        //获取缓存的列表索引
        $list = Redis::lrange(self::$lkey, $offset,$totals);

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
                $res = CustomPage::objectToArray(self::$action_store->getOneDatas(['guid'=>$v]));
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
    protected function getLength()
    {
        if($this->exists('list')){
            return Redis::llen(self::$lkey);
        }
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