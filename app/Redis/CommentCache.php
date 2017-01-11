<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/9
 * Time: 14:56
 */

namespace App\Redis;

use App\Tools\CustomPage;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\Facades\Redis;

class CommentCache
{
    private static $lkey = LIST_COMMENT_INFO_;      //项目list表key
    private static $hkey = HASH_COMMENT_INFO_;     //项目hash表key
    private static $strkey = STRING_COMMENT_NUM_;

    /**
     * 判断listkey和hashkey是否存在
     * @param $type string list为查询listkey,否则查询hashkey
     * @param $index string   唯一识别码 guid
     * @return bool
     */
    public function exists($key)
    {
        return Redis::exists($key);

    }

    /**
     * 为评论添加缓存索引
     * @param int $id 评论自增id
     * @param $contentId 内容guid
     * author 张洵之
     */
    public function insertIndex($id, $contentId)
    {
        if(!Redis::lPush(self::$lkey . $contentId, $id)){
            Log::error('ID:'.$id.' 评论信息写入redis   List失败！！');
        }

        if(Redis::exists(self::$lkey.$contentId.':Num' )){
            Redis::Incr(self::$lkey.$contentId.':Num');
        }else{
            $this->setCommentNum($contentId, 1);
        }
    }

    /**
     * 创建hash缓存
     * @param object $data
     * author 张洵之
     */
    public function createCache($data)
    {
        if(!$this->exists($type = 'list', $data[0]->action_id)){
            foreach ($data as $value) {
                Redis::rpush(self::$lkey.$value->action_id, $value->id);
            }
        }

        $temp = CustomPage::objectToArray($data);
        foreach ($temp as $value){

            if(!$this->exists($type = 'hash', $value['id'])){

                $index = self::$hkey . $value['id'];
                //写入hash
                Redis::hMset($index, $value);
                //设置生命周期
                $this->setTime($index);
            }

        }

    }

    /**
     * 设置缓存生命周期
     * @param $key
     * @param int $time
     * author 张洵之
     */
    public function setTime($key, $time = 1800)
    {
        Redis::expire($key, $time);
    }

    /**
     * 获取分页评论数据
     * @param int $nowPage
     * @param string $contentId
     * @return array|null
     * author 张洵之
     */
    public function getPageData($nowPage, $contentId)
    {

        if(!$this->exists(self::$lkey.$contentId)) return false;

        $start = ($nowPage - 1)*PAGENUM;
        $stop = $nowPage*PAGENUM-1;
        $indexData = Redis::lRange(self::$lkey.$contentId, $start, $stop);

        if($indexData) {
            $temp = $this->getHashData($indexData);
        }
    }

    /**
     * 获取hash中的评论数据
     * @param array $indexData 评论索引
     * @return array|null
     * author 张洵之
     */
    public function getHashData($indexData)
    {
        $data = array();
        foreach ($indexData as $value){
            if($this->exists('hash', $value)) {
                $data[] = Redis::hGetall(self::$hkey .$value);
            }else{
                return false;
            }
        }
        return $data;
    }

    /**
     * 返回某条内容下的评论数量
     * @param  string $contentId 内容ID
     * @return bool|string
     * author 张洵之
     */
    public function getCommentNum($contentId)
    {

        if($this->exists(self::$strkey.$contentId)){
            $result = Redis::Get (self::$strkey.$contentId);
            return ['num' => $result];
        }else{
            return false;
        }
    }

    /**
     * 设置评论某条内容下的评论数量
     * @param $contentId
     * @param $num
     * author 张洵之
     */
    public function setCommentNum($contentId, $num)
    {
        Redis::Set(self::$strkey.$contentId, $num);
    }
}