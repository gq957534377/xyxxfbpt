<?php
/**
 * Project redis 缓存仓库
 * @author 张洵之
 */

namespace App\Redis;

use App\Tools\CustomPage;
use App\Store\ProjectStore;

class ProjectCache extends MasterCache
{
    private static $lkey = LIST_PROJECT_INFO_;      //项目list表key
    private static $hkey = HASH_PROJECT_INFO_;     //项目hash表key

    private static $project_store;

    public function __construct(ProjectStore $projectStore)
    {
        self::$project_store = $projectStore;
    }


    /**
     * 创建listKey
     * @param int $type list索引
     * @return bool
     * author 张洵之
     */
    public function createList($type)
    {
        //type : 11 为全部在线项目；1-10为其他融资阶段的项目
        if($type == 11) {
            $temp = self::$project_store->getList(['status' => 1], 'guid');
        }else{
            $temp = self::$project_store->getList(['status' => 1, 'financing_stage' => $type], 'guid');
        }

        if ($temp){
            $this ->rPushLists(self::$lkey.$type, $temp);
            return true;//有数据返回true
        }else{
            return false;//无数据返回false
        }
    }

    /**
     * 创建hash
     * @param object|array $data
     * @return bool
     * author 张洵之
     */
    public function createHash($data)
    {
        if(!$data) return false;

        $temp = CustomPage::objectToArray($data);
        foreach ($temp as $value) {
            $index = self::$hkey . $value['guid'];
            $this->addHash($index, $value);
        }
    }

    /**
     * 拿取项目缓存
     * @param $indexArray
     * @return array
     * author 张洵之
     */
    public function getProjectHash($indexArray)
    {
        $data = array();
        foreach ($indexArray as $value) {
            $index = self::$hkey . $value;

            if ($this->exists($index)) {
                $data[] = CustomPage::arrayToObject($this->getHash($index));
            } else {
                $temp[0] = self::$project_store->getOneData(['guid' => $value]);
                $this->createHash($temp);
                $data[] = $temp[0];
            }

        }
        return $data;
    }

    /**
     * 返回分页后的数据
     * author 张洵之
     * @param int $nowPage
     * @param int $pageNum
     * @param array $where
     * @return array|null
     * author 张洵之
     */
    public function   getPageData($nowPage, $pageNum, $where)
    {
        //格式化索引
        if(empty($where['financing_stage'])) {
            $type = 11;
        }else {
            $type = (int)$where['financing_stage'];
        }
        //检查索引的listKey是否存在
        if(!$this->exists(self::$lkey.$type)) {
            //创建索引(这里判断的是数据库是否有数据)
            if(!$this->createList($type)) return false;

            $data = self::$project_store->getPage($nowPage, $pageNum, $where);

            if(!$data) return false;

            $this->createHash($data);//将查出的数据做hash存储

        }else{
            $indexData = $this->getPageLists(self::$lkey.$type, $pageNum, $nowPage);
            $data = $this->getProjectHash($indexData);
        }

        return $data;
    }
}