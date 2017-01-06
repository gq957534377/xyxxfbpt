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
        if(!Redis::lRem(self::$lkey, $data->guid, 0)) {
            Log::error('redis移出默认项目分类信息   List失败！！');
            return false;
        }

        if(Redis::lRem(self::$lkey.$data->financing_stage, $data->guid, 0)) {
            Log::error('redis移出项目分类信息   List失败！！');
            return false;
        }

        return true;
    }
}