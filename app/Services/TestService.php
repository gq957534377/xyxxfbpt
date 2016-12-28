<?php
/**
 * article 缓存服务
 * @author lw  beta
 */
namespace App\Services;

use App\Tools\CustomPage;
use App\Redis\ArticleCache;
use App\Store\ArticleStore;
use Mockery\Exception;


class TestService
{
    private static $article_cache;      //文章缓存仓库
    private static $article_store;      //文章数据仓库

    public function __construct(ArticleCache $articleCache, ArticleStore $articleStore)
    {
        self::$article_cache = $articleCache;
        self::$article_store = $articleStore;
    }

    /**
     * 获取所有文章列表
     * @return mixed
     */
    public function getArticleList($nums,$pages)
    {

        //判断article缓存是否存在
        if(!self::$article_cache->exists()){
            //获取数据库里的所有文章列表,并且转对象为数组
            $article_list = CustomPage::objectToArray(self::$article_store->getAllArticle());

            //存入redis缓存
            if(count($article_list)){
                self::$article_cache->setArticleList($article_list);
            }

        }

        //直接读取缓存数据,并把数组转换为对象
        $list = CustomPage::arrayToObject(self::$article_cache->getArticleList($nums,$pages));


        return $list;

    }

    /**
     * 根据list页传递的文章guid获取一条文章
     * @param $guid  文章guid
     * @return array
     */
    public function getOneArticle($guid)
    {
        if(!self::$article_cache->exists('',$guid)){
            //读取数据库
            $content = CustomPage::objectToArray(self::$article_store->getOneDatas(['guid'=>$guid]));

            //写入hash缓存
            if ($content){
                self::$article_cache->setOneArticle($content);
            }
        }

        return CustomPage::arrayToObject(self::$article_cache->getOneArticle($guid));
    }
}