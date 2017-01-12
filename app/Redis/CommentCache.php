<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/9
 * Time: 14:56
 */

namespace App\Redis;

use App\Tools\CustomPage;
use App\Store\CommentStore;
use App\Store\UserStore;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\Facades\Redis;

class CommentCache extends MasterCache
{
    private static $lkey = LIST_COMMENT_INFO_;      //项目list表key
    private static $hkey = HASH_COMMENT_INFO_;     //项目hash表key
    private static $strkey = STRING_COMMENT_NUM_;
    protected static $comment_store;
    protected static $user_store;

    public function __construct(CommentStore $comment_store, UserStore $user_store)
    {
        self::$comment_store = $comment_store;
        self::$user_store = $user_store;
    }

    /**
     * 返回某条内容下的评论数量
     * @param  string $contentId 内容ID
     * @return bool|string
     * author 张洵之
     */
    public function getCommentNum($contentId)
    {
        $index = self::$strkey.$contentId;

        if($this->exists($index)) {
            $num = $this->getString($index);
        }else{
            $num = self::$comment_store->getCount(['action_id' => $contentId, 'status' => 1]);
            $this->addString($index, $num);
        }

        return $num;
    }

    /**
     * 获取分页评论索引
     * @param int $nowPage
     * @param string $contentId
     * @return array|null
     * author 张洵之
     */
    public function getCacheIndex($nowPage, $contentId)
    {
        $index = self::$lkey.$contentId;

        if(!$this->exists($index)) return false;

        $indexData = $this->getPageLists($index, PAGENUM, $nowPage);

        return $indexData;
    }
    /**
     * 创建缓存索引
     * @param string $contentId 详情页guid
     * @return bool
     * author 张洵之
     */
    public function createIndex($contentId)
    {
        $temp = self::$comment_store->getLists(['action_id' => $contentId, 'status' => 1], 'id');

        if(!$temp) return false;

        $data = CustomPage::objectToArray($temp);
        $this->rPushLists(self::$lkey.$contentId, $data);

    }

    /**
     * 创建评论详情的hash缓存
     * @param object $data
     * @return bool
     * author 张洵之
     */
    public function createCache($data)
    {
        if(!$data) return false;

        $temp = CustomPage::objectToArray($data);
        foreach ($temp as $value) {
            $this->addHash(self::$hkey.$value['id'], $value);
        }
    }

    public function getCommentData($id)
    {
        $data = self::$comment_store->getOneData(['id' => $id]);

        if(!$data) return false;

        $userData = self::$user_store->getOneData(['guid' => $data->user_id ]);

        if(!$userData) return false;

        $data->userImg = $userData->headpic;//添加用户头像
        $data->nikename = $userData->nickname;//添加用户昵称
        return $data;
    }

    /**
     * @param array $data 索引数组
     * @return array|bool
     * author 张洵之
     */
    public function getCache($data)
    {
        if (!is_array($data)) return false;

        $cache = [];
        foreach($data as $value) {
            $temp = $this->getHash(self::$hkey.$value);

            if($temp) {
                $cache[] = $temp;
            }else {

                $commentData = $this->getCommentData($value);//从数据库拿取评论数据；

                if(!$commentData) break;//逻辑错误需打印日志

                $cache[] = $commentData;
                $this->addHash(self::$hkey.$value, CustomPage::objectToArray($commentData));
            }
        }
        $commentCache = CustomPage::arrayToObject($cache);

        return (array)$commentCache;
    }

    /**
     * 增加评论缓存数据
     * @param $id
     * @param $contentId
     * author 张洵之
     */
    public function insertIndex($id, $contentId)
    {
        $index = self::$lkey.$contentId;

        if($this->lPushLists($index, $id)){
            $this->incre($index);
        }
    }
}