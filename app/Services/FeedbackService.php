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
use App\Tools\Common;
use App\Store\FeedbackStore;


class FeedbackService
{

    protected static $baseRedis;
    protected static $safetyService;
    protected static $feedbackStore;
    function __construct(
        BaseRedis $baseRedis,
        SafetyService $safetyService,
        FeedbackStore $feedbackStore
    ) {
        self::$baseRedis = $baseRedis;
        self::$safetyService = $safetyService;
        self::$feedbackStore = $feedbackStore;
    }

    /**
     * 保存反馈信息
     * @param $data
     * @return array
     * @author 杨志宇
     */
    public function saveFeedback($data)
    {
        $time = date('Y-m-d', time());
        $guid = Common::getUuid();

        // 数据总数
        $count = self::$safetyService->getString(STRING_FEEDBACK_COUNT_ . $time);

        // 给日志打警告线
        if (($count >= REDIS_FEEDBACK_WARNING) && (($count % 100) == 0)) {
            // 记录日志
            \Log::info('意见反馈超过警戒线' . $count );
        }


        // 大于规定条数时写入文件
        $fileCount = REDIS_FEEDBACK_WARNING_FILE;
        // 判断是否达到警戒线
        if ($count >= $fileCount) {
            // 当等于规定条数时,将前面的数据全部写到文件,以当前时间命名文件
            if ($count == $fileCount) {
                $data = self::$baseRedis->selHGetAll(HASH_FEED_BACK_ . $time);
            }
            Common::writeFile($data);
            self::$safetyService->saveIpInSet(SET_FEEDBACK_IP_ . $time, $data['ip']);
        } else {
            // 小于500条写入redis(以下失效时间均为2天)
            self::$baseRedis->hSet(HASH_FEED_BACK_ . $time, $guid, json_encode($data));
            self::$baseRedis->addRpush(LIST_FEED_BACK_INDEX_ . $time, $guid);
            self::$safetyService->saveIpInSet(SET_FEEDBACK_IP_ . $time, $data['ip']);

        }
        // 不管写文件还是redis,都在自增
        self::$safetyService->getCount(STRING_FEEDBACK_COUNT_ . $time);

        return ['StatusCode' => '200', 'ResultData' => '感谢您的参与'];

    }

    /**
     * 得到意见列表
     * @param $nowPage
     * @param $forPages
     * @param $url
     * @return array
     * @author 杨志宇
     */
    public function getFeedbackList($where, $nowPage, $forPages, $url, $disPlay = true)
    {
        //查询总记录数
        $count = self::$feedbackStore->getCount($where);
        if (!$count) {
            //如果没有数据直接返回201空数组，函数结束
            if ($count == 0) return ['StatusCode' => '204', 'ResultData' => []];
            return ['StatusCode' => '400', 'ResultData' => '数据参数有误'];
        }
        //计算总页数
        $totalPage = ceil($count / $forPages);

        //获取对应页的数据
        $result['data'] = self::$feedbackStore->forPage($nowPage, $forPages, $where);
        if($result['data']){
            if ($disPlay && $totalPage>1) {
                //创建分页样式
                $creatPage = CustomPage::getSelfPageView($nowPage, $totalPage, $url, null);

                if($creatPage){
                    $result["pages"] = $creatPage;
                }else{
                    return ['StatusCode' => '500','ResultData' => '生成分页样式发生错误'];
                }
            }else{
                $result["pages"] = '';
            }
            return ['StatusCode' => '200','ResultData' => $result];
        }else{
            return ['StatusCode' => '500','ResultData' => '获取分页数据失败！'];
        }
    }

    /**
     * 得到意见列表
     * @param $nowPage
     * @param $forPages
     * @param $url
     * @return array
     * @author 杨志宇
     */
    public function getFeedbackListOld($nowPage, $forPages, $url)
    {
        $time = date('Y-m-d', time());
        $data = [];
        // 起始索引
        $newPage = ($nowPage - 1) * $forPages;
        // end索引 因为起始为0 所以减一
        $nextPage = $nowPage * $forPages - 1;
        // 索引记录。
        $list = self::$baseRedis->selRpush(LIST_FEED_BACK_INDEX_ . $time, $newPage, $nextPage);
        // 内容记录
        $result = self::$baseRedis->selHMGet(HASH_FEED_BACK_ . $time, $list);
        // 总记录数
        $count = self::$baseRedis->getHLenCount(LIST_FEED_BACK_INDEX_ . $time);
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
     * @author 杨志宇
     */
    public function delFeedback($keyArr)
    {
        $result = self::$feedbackStore->delFeedback($keyArr);
        if ($result) {
            return ['StatusCode' => '200', 'ResultData' => '删除成功'];
        } else {
            return ['StatusCode' => '400', 'ResultData' => '删除失败'];
        }
    }
}