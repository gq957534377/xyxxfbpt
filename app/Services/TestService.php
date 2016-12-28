<?php

namespace App\Services;

use App\Tools\CustomPage;
use App\Redis\ArticleCache;
use App\Store\ArticleStore;




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
            self::$article_cache->setArticleList($article_list);
        }

        //直接读取缓存数据,并把数组转换为对象
        $list = CustomPage::arrayToObject(self::$article_cache->getArticleList($nums,$pages));


        return $list;
    }
}