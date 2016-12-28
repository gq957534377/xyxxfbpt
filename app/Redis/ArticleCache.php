<?php
namespace App\Redis;


use App\Tools\CustomPage;
use Illuminate\Support\Facades\Redis;

class ArticleCache
{

    private static $lkey = LIST_PROJECT_INFO;      //项目列表key
    private static $hkey = HASH_PROJECT_INFO_;     //项目hash表key

    /**
     * 判断listkey是否存在
     * @return mixed
     */
    public function exists()
    {
        return Redis::exists(self::$lkey);
    }

    /**
     * 列表信息写入缓存
     * @param $data
     */
    public function setArticleList($data)
    {
        foreach ($data as $v){
            Redis::rpush(self::$lkey,$v['guid']);
            Redis::hMset(self::$hkey.$v['guid'],$v);
        }

    }

    /**
     * 获取redis缓存里的文章列表数据
     * @return array
     */
    public function getArticleList($nums,$pages)
    {
        //起始偏移量
        $offset = $nums * $pages;

        //获取条数
        $totals = $offset+$nums - 1;

        //获取缓存的列表索引
        $list = Redis::lrange(self::$lkey, $offset,$totals);

        $data = [];

        foreach ($list as $v) {
            $data[] = Redis::hGetall(self::$hkey.$v);
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