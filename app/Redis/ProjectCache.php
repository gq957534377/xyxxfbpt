<?php
/**
 * Project redis 缓存仓库
 * @author 张洵之
 */

namespace App\Redis;

use App\Tools\CustomPage;
use App\Store\ProjectStore;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\Facades\Redis;

class ProjectCache
{
    private static $lkey = LIST_PROJECT_INFO;      //项目list表key
    private static $hkey = HASH_PROJECT_INFO_;     //项目hash表key

    private static $project_store;

    public function __construct(ProjectStore $projectStore)
    {
        self::$project_store = $projectStore;
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
     * 插入缓存索引
     * @param array $data
     * @return bool
     * author 张洵之
     */
    public function insertCache($data)
    {
        if(empty($data)) return false;
        $temp = CustomPage::objectToArray($data);
        //建立redis索引
        if (!Redis::rpush(self::$lkey . $temp['financing_stage'], $temp['guid'])) {
            Log::error('项目分类信息写入redis   List失败！！');
        };

        if (!Redis::rpush(self::$lkey , $temp['guid'])) {
            Log::error('项目默认信息写入redis   List失败！！');
        };

        $this->createCache($temp);
        return true;
    }

    /**
     * 创建缓存
     * @param array $data
     * @return bool
     * author 张洵之
     */
    public function createCache($data)
    {
        if(empty($data)) return false;

            if(!$this->exists($type = '', $data['guid'])){

                $index = self::$hkey . $data['guid'];
                //写入hash
                Redis::hMset($index, $data);
                //设置生命周期
                $this->setTime($index);
            }
        return true;
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
     * 移出缓存索引
     * @param $data
     * @return bool
     * author 张洵之
     */
    public function deletCache($data) {

        if(!Redis::lRem(self::$lkey, 0, $data->guid)) {
//            Log::error('redis移出默认项目分类信息   List失败！！');
            return false;
        }

        if(!Redis::lRem(self::$lkey.$data->financing_stage, 0, $data->guid)) {
//            Log::error('redis移出项目分类信息   List失败！！');
            return false;
        }

        return true;
    }

    /**
     * 返回分页后的数据
     * @param int $nowPage
     * @param int $pageNum
     * @param array $where
     * author 张洵之
     */
    public function getPageData($nowPage, $pageNum, $where)
    {

        $start = ($nowPage - 1)*$pageNum;
        $stop = $nowPage*$pageNum-1;
        if (empty($where['financing_stage'])){
            $indexData = Redis::lRange(self::$lkey, $start, $stop);
        }else{
            $indexData = Redis::lRange(self::$lkey.$where['financing_stage'], $start, $stop);
        }

        $data = CustomPage::arrayToObject($this->getHashData($indexData));
        return (array)$data;
    }

    /**
     * 返回hash缓存数据
     * @param $array
     * @return array
     * author 张洵之
     */
    public function getHashData($array)
    {
        $data =array();
        foreach ($array as $value) {

            if($this->exists('hash', $value)) {

                $data[] = Redis::hGetall(self::$hkey .$value);
            }else{
                $temp = CustomPage::objectToArray(self::$project_store->getOneData(['guid' => $value]));
                $this->createCache($temp);
                $data[] = Redis::hGetall(self::$hkey .$value);
            }

        }
        return $data;
    }

    public function getOneData($guid)
    {
        if($this->exists('hash', $guid)) {
            $data = Redis::hGetall(self::$hkey .$guid);
        }else{
            $temp = CustomPage::objectToArray(self::$project_store->getOneData(['guid' => $guid]));
            $this->createCache($temp);
            $data = Redis::hGetall(self::$hkey .$guid);
        }

        return CustomPage::arrayToObject($data);
    }
}