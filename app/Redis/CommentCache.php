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
use Illuminate\Support\Facades\Log;

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
     * author 杨志宇
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
     * author 杨志宇
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
     * author 杨志宇
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
     * author 杨志宇
     */
    public function createCache($data)
    {
        if(!$data) return false;

        $temp = CustomPage::objectToArray($data);
        foreach ($temp as $value) {
            $this->addHash(self::$hkey.$value['id'], $value);
        }
    }

    /**
     * 拼装一条评论数据
     * @param int $id 评论id
     * @return \App\Store\one|bool
     * author 杨志宇
     */
    public function getCommentData($id)
    {
        $data = self::$comment_store->getOneData(['id' => $id]);

        if(!$data) {
            Log::info('评论缓存索引ID为'.$id.'的数据库数据不存在');
            return false;
        }

        $userData = self::$user_store->getOneData(['guid' => $data->user_id ]);

        if(!$userData) {
            Log::info('用户ID为'.$data->user_id.'的用户信息查询失败，导致该用户有关评论数据无法添加至缓存');
            return false;
        }
        $data->userImg = $userData->headpic;//添加用户头像
        $data->nikename = $userData->username;//添加用户昵称
        return $data;
    }

    /**
     * 拿取评论数据
     * @param array $data 索引数组
     * @return array|bool
     * author 杨志宇
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

                if(!$commentData) break;

                $temps = CustomPage::objectToArray($commentData);
                $this->addHash(self::$hkey.$value, $temps);
                $cache[] = $temps;
            }
        }

        $commentCache = CustomPage::arrayToObject($cache);
        return (array)$commentCache;
    }

    /**
     * 增加评论缓存索引数据
     * @param int $id 评论id
     * @param string $contentId 内容guid
     * author 杨志宇
     */
    public function insertIndex($id, $contentId)
    {
        $index = self::$lkey.$contentId;
        $NumIndex = self::$strkey.$contentId;

        if($this->lPushLists($index, $id)){
            $this->incre($NumIndex);
        }
    }
}