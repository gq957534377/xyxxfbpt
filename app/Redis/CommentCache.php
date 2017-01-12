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
use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\Facades\Redis;

class CommentCache extends MasterCache
{
    private static $lkey = LIST_COMMENT_INFO_;      //项目list表key
    private static $hkey = HASH_COMMENT_INFO_;     //项目hash表key
    private static $strkey = STRING_COMMENT_NUM_;
    protected static $comment_store;

    public function __construct(CommentStore $comment_store)
    {
        self::$comment_store = $comment_store;
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
            $num = Redis::Get ($index);
        }else{
            $num = self::$comment_store->getCount(['action_id' => $contentId, 'status' => 1]);
            $this ->setCommentNum($contentId, $num);
        }

        return $num;
    }

    /**
     * 设置评论某条内容下的评论数量
     * @param string $contentId
     * @param int $num
     * author 张洵之
     */
    public function setCommentNum($contentId, $num)
    {
        Redis::Set(self::$strkey.$contentId, $num);
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

        if($temp) return false;

        $data = CustomPage::objectToArray($temp);
        $this->rPushLists(self::$lkey.$contentId, $data);

    }

    public function createCache($data)
    {

    }
}