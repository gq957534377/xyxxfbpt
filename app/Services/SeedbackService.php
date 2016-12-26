<?php
/**
 * Created by PhpStorm.
 * User: wangt
 * Date: 2016/12/9
 * Time: 15:37
 */

namespace App\Services;

use App\Redis\BaseRedis;
use App\Tools\CustomPage;


class SeedbackService
{

    protected static $baseRedis;
    protected static $dataFeedback = 'DATA_FEED_BACK';
    protected static $indexFeedback = 'INDEX_FEED_BACK_List';
    function __construct(BaseRedis $baseRedis)
    {
        self::$baseRedis = $baseRedis;
    }

    /**
     * 保存反馈信息
     * @param $data
     * @return array
     * @author 王通
     */
    public function saveSeedback($ip, $data)
    {
        $hashKey = $ip . ':' . rand(100,999);
        if (self::$baseRedis->hSet(self::$dataFeedback, $hashKey, json_encode($data))) {
            if (self::$baseRedis->addRpush(self::$indexFeedback, $hashKey)) {
                return ['StatusCode' => '200', 'ResultData' => '保存成功'];
            }
            self::$baseRedis->hDel(self::$dataFeedback, $hashKey);
            return ['StatusCode' => '400', 'ResultData' => '保存失败'];
        } else {
            return ['StatusCode' => '400', 'ResultData' => '保存失败'];
        }

    }

    /**
     * 得到意见列表
     * @param $nowPage
     * @param $forPages
     * @param $url
     * @return array
     * @author 王通
     */
    public function getSeedbackList($nowPage, $forPages, $url)
    {
        $data = [];
        // 起始索引
        $newPage = ($nowPage - 1) * $forPages;
        // end索引 因为起始为0 所以减一
        $nextPage = $nowPage * $forPages - 1;
        // 索引记录。
        $list = self::$baseRedis->selRpush(self::$indexFeedback, $newPage, $nextPage);
        // 内容记录
        $result = self::$baseRedis->selHMGet(self::$dataFeedback, $list);
        // 总记录数
        $count = self::$baseRedis->getHLenCount(self::$indexFeedback);
        // 总页数
        $totalPage = $totalPage = ceil($count / $forPages);
        $data[0] = $list;
        $data[1] = $result;
        // 得到分页列表
        $data[2] = CustomPage::getSelfPageView($nowPage, $totalPage, $url, null);
        if (empty($result)) {
            return ['StatusCode' => '400', 'ResultData' => '查询失败'];
        } else {
            return ['StatusCode' => '200', 'ResultData' => $data];
        }
    }

    /**
     * 删除多条意见
     * @param $key
     * @return array
     * @author 王通
     */
    public function delSeedback($keyArr)
    {

        $result = self::$baseRedis->delPipeline($keyArr, self::$indexFeedback, self::$dataFeedback);
        if (!empty($result[0]) && !empty($result[1])) {
            return ['StatusCode' => '200', 'ResultData' => '删除成功'];
        } else {
            return ['StatusCode' => '400', 'ResultData' => '删除失败'];
        }



    }
}