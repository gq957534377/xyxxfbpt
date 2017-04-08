<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/17
 * Time: 13:51
 * @author:郭庆
 */

namespace App\Services;

use App\Redis\ActionCache;
use App\Redis\CollegeCache;
use App\Redis\PictureCache;
use App\Store\ActionStore;
use App\Store\ActionOrderStore;
use App\Store\CommentStore;
use App\Store\LikeStore;
use App\Store\CollegeStore;
use App\Tools\Common;
use App\Tools\CustomPage;
use Illuminate\Support\Facades\DB;

class ActionService
{
    /**
     * 引入活动数据仓储层
     */
    protected static $actionStore;
    protected static $commentStore;
    protected static $actionOrderStore;
    protected static $likeStore;
    protected static $actionCache;
    protected static $pictureCache;

    public function __construct(
        ActionStore $actionStore,
        ActionOrderStore $actionOrderStore,
        CommentStore $commentStore,
        LikeStore $likeStore,
        ActionCache $actionCache,
        PictureCache $pictureCache
    )
    {
        self::$actionStore = $actionStore;
        self::$commentStore = $commentStore;
        self::$actionOrderStore = $actionOrderStore;
        self::$likeStore = $likeStore;
        self::$actionCache = $actionCache;
        self::$pictureCache = $pictureCache;
    }

    /**
     * 报名活动
     * @param array $data 报名具体信息记录
     * @return array
     * @author 郭庆
     */
    public function actionOrder($data)
    {
        //判断是否已经报名
        $isHas = self::$actionCache->getOrderActions($data['user_id'], $data['action_id']);

        if ($isHas) return ['StatusCode' => '400', 'ResultData' => "已经报名参加"];

        //添加新的报名记录
        $data['addtime'] = time();
        DB::beginTransaction();
        try {
            //插入报名记录
            $result = self::$actionOrderStore->addData($data);

            //给活动信息表参与人数字段加1

            $res = self::$actionStore->incrementData(['guid' => $data['action_id']], 'people', 1);

            //上述俩个操作全部成功则返回成功
            if ($res && $result) {
                DB::commit();

                self::$actionCache->addOrder($data['user_id'], $data['action_id'], 1, true);
                return ['StatusCode' => '200', 'ResultData' => "报名成功"];
            } else {
                return ['StatusCode' => '500', 'ResultData' => "存储有误，报名失败"];
            }
        } catch (Exception $e) {
            //上述操作有一个失败就报错，数据库手动回滚
            \Log::error('报名失败', [$data]);
            DB::rollback();
            return ['StatusCode' => '500', 'ResultData' => "服务器繁忙,报名失败"];
        }
    }

    /**
     * 发布活动
     * @param array $data 活动信息记录
     * @return array
     * author 郭庆
     */
    public function insertData($data)
    {
        $data["guid"] = Common::getUuid();
        $data["status"] = 1;
        $data["people"] = 0;
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        $data['deadline'] = strtotime($data['deadline']);
        $data["addtime"] = time();

        //检测时间是否符合标准
        $temp = $this->checkTime($data);
        if ($temp["status"]) {
            unset($data['list']);
            $result = self::$actionStore->insertData($data);
            self::$actionCache->insertOneAction($data);
        } else {
            return ['StatusCode' => '400', 'ResultData' => $temp['msg']];
        }

        //判断插入是否成功，并返回结果
        if ($result) return ['StatusCode' => '200', 'ResultData' => "发布活动成功"];
        \Log::info('发布活动失败', $data, $result);
        return ['StatusCode' => '500', 'ResultData' => "服务器忙，发布失败"];
    }

    /**
     * 检查日期是否合乎逻辑
     *
     * @author 杨志宇
     */
    public function checkTime($data)
    {
        //转为时间戳
        $endtime = $data["end_time"];
        $deadline = $data["deadline"];
        $starttime = $data["start_time"];

        //检测开始：报名截止时间 < 活动开始时间 < 活动结束时间
        if ($endtime > $starttime && $starttime > $deadline && $deadline > time()) {
            return ['status' => true];
        } elseif ($endtime < $starttime) {
            return ['status' => false, "msg" => "结束日期不可早于开始日期"];
        } elseif ($endtime < $deadline) {
            return ['status' => false, "msg" => "结束日期不可早于报名截止日期"];
        } elseif ($deadline < time()) {
            return ['status' => false, "msg" => "报名截止日期不可早于当前日期"];
        } else {
            return ['status' => false, "msg" => "开始日期不可早于报名截止日期"];
        }
    }

    /**
     * 每次加载页面更新活动状态
     * @param $data
     * @return array
     * @author 郭庆
     */
    public static function setStatusByTime($data)
    {
        //目前的状态
        $old = $data->status;
        //转为时间戳
        $endTime = $data->end_time;
        $deadline = $data->deadline;
        $startTime = $data->start_time;
        $time = time();

        //设置状态
        if ($old == 4) {
            return ['status' => true, "msg" => "无需更改"];
        } else {
            //判断时间设置状态
            if ($time < $deadline) {
                $status = 1;
            } elseif ($time > $startTime && $time < $endTime) {
                $status = 2;
            } elseif ($time > $endTime) {
                $status = 3;
            } elseif ($time > $deadline && $time < $startTime) {
                $status = 5;
            } else {
                return ['status' => false, "msg" => "数据有误"];
            }
        }

        //返回所需要更改的状态
        if ($old == $status) return ['status' => false, "msg" => '无需更改'];
        return ['status' => true, "msg" => $status];
    }

    /**
     * 分页查询
     * @param array $where 查询条件
     * @param int $nowPage 当前页
     * @param int $forPages 一页获取的数量
     * @param string $url 请求的路由url
     * @param boolean $disPlay 是否需要分页样式
     * author 郭庆
     */
    public function selectData($where, $nowPage, $forPages, $url, $disPlay = true)
    {
        //获取符合条件的数据的总量
        $count = self::$actionCache->getCount($where);

        if (!$count) return ['StatusCode' => '204', 'ResultData' => "暂无数据"];
        //获取对应页的数据
        $result['data'] = self::$actionCache->getPageDatas($where, $forPages, $nowPage);
        //计算总页数
        $totalPage = ceil($count / $forPages);

        if ($result['data']) {
            if ($disPlay && $totalPage > 1) {
                //创建分页样式
                $creatPage = CustomPage::getSelfPageView($nowPage, $totalPage, $url, null);

                if ($creatPage) {
                    $result["pages"] = $creatPage;
                } else {
                    return ['StatusCode' => '500', 'ResultData' => '生成分页样式发生错误'];
                }

            } else {
                $result['totalPage'] = $totalPage;
                $result["pages"] = '';
            }
            return ['StatusCode' => '200', 'ResultData' => $result];
        } else {
            return ['StatusCode' => '500', 'ResultData' => '获取分页数据失败！'];
        }
    }

    /**
     * 获取所有活动数据(用于任务调度)
     * @param
     * @return array
     * @author 郭庆
     */
    public static function getAllAction()
    {
        $data = self::$actionStore->getData([]);
        if ($data) return ['status' => true, 'msg' => $data];
        return ['status' => false, 'msg' => "获取所有活动失败"];
    }

    /**
     * 查询相关活动信息
     * @param $guid
     * author 郭庆
     */
    public function getData($guid)
    {
        if (!$guid) {
            return ['StatusCode' => '400', 'ResultData' => "数据参数有误"];
        }
        //查询一条数据活动信息
        $data = self::$actionCache->getOneAction($guid);

        if ($data) {
            $data = CustomPage::arrayToObject($data);
            $data->addtime = date("Y-m-d H:i:s", $data->addtime);
            $group = self::$pictureCache->getOnePicture($data->group);
            if (empty($group)) {
                if ($group == []) {
                    $group = '个人';
                } else {
                    \Log::info('获取' . $guid . '活动详情的组织机构失败:' . $group);
                    return ['StatusCode' => '500', 'ResultData' => "获取组织机构信息失败"];
                }
            }
            $data->group = $group;
            return ['StatusCode' => '200', 'ResultData' => $data];
        } else {
            \Log::info('获取' . $guid . '活动详情出错:');
            return ['StatusCode' => '404', 'ResultData' => "获取活动信息失败"];
        }
    }

    /**
     * 修改活动状态
     * @param $guid string 所要修改的id
     * @param $status int 改为的状态
     * @return array
     * author 郭庆
     */
    public function changeStatus($guid, $status)
    {
        if (!(!empty($guid) && !empty($status))) {
            return ['StatusCode' => '400', 'ResultData' => "参数有误"];
        }

        $old = self::$actionStore->getOneData(['guid' => $guid]);
        if (!empty($old)) {
            $oldStatus = $old->status;
            $oldType = $old->type;
            $Data = self::$actionStore->upload(["guid" => $guid], ["status" => $status, 'addtime' => time()]);
        } else {
            return ['StatusCode' => '400', 'ResultData' => "没有这条记录"];
        }

        //判断修改结果并返回
        if ($Data) {
            self::$actionCache->changeStatusAction($guid, $status, $oldStatus, $oldType);
            return ['StatusCode' => '200', 'ResultData' => "修改成功"];
        } else {
            if ($Data != 0) \Log::info('修改' . $guid . '活动/报名状态出错:' . $Data);
            return ['StatusCode' => '500', 'ResultData' => "修改失败"];
        }
    }

    /**
     * 修改活动内容
     * @param $where
     * @param $data
     * @return array
     * author 郭庆
     */
    public function upDta($where, $data)
    {
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        $data['deadline'] = strtotime($data['deadline']);
        $data['addtime'] = time();
        unset($data['list']);

        $Data = self::$actionStore->upload($where, $data);

        if ($Data) {
            self::$actionCache->changeOneAction($where['guid'], $data);
            return ['StatusCode' => '200', 'ResultData' => "修改成功"];
        } else {
            if ($Data == 0) return ['StatusCode' => '204', 'ResultData' => "未作任何更改"];
            \Log::info('修改' . $where['guid'] . '活动出错:' . $Data);
            return ['StatusCode' => '500', 'ResultData' => "服务器忙,修改失败"];
        }
    }

    /**
     * 获取评论表+like表中某一个活动的评论
     * @param $id
     * @return array
     * @author 郭庆
     */
    public static function getComment($id)
    {
        $comment = self::$commentStore->getSomeData(['action_id' => $id]);
        if ($comment) {
            return ['status' => true, 'msg' => $comment];
        } else {
            if (!is_array($comment)) \Log::info('获取' . $id . '活动的评论出错:' . $comment);
            return ['status' => false, 'msg' => '获取评论信息失败'];
        }
    }

    /**
     * 获取指定用户所报名参加的满足限制条件的活动信息
     * @param [] $actions 活动actions数组
     * @return array
     * @author 郭庆
     */
    public function getOrderActions($where, $actions, $nowPage, $forPages, $url, $disPlay = true)
    {

        $count = self::$actionStore->getActionsCount($where, 'guid', $actions);

        if (!$count) {
            //如果没有数据直接返回201空数组，函数结束
            if ($count == 0) return ['StatusCode' => '204', 'ResultData' => ['list' => 1, 'data' => "你还未报名参加任何活动"]];
            return ['StatusCode' => '400', 'ResultData' => ['list' => 1, 'data' => '数据参数有误']];
        }

        //计算总页数
        $totalPage = ceil($count / $forPages);
        //获取所有数据

        $result['data'] = self::$actionStore->getActionsPage($where, 'guid', $actions, $nowPage, $forPages);
        if ($result['data']) {
            if ($disPlay && $totalPage > 1) {
                //创建分页样式
                $creatPage = CustomPage::getSelfPageView($nowPage, $totalPage, $url, null);

                if ($creatPage) {
                    $result["pages"] = $creatPage;
                } else {
                    return ['StatusCode' => '500', 'ResultData' => ['list' => 1, 'data' => '生成分页样式发生错误']];
                }
            } else {
                $result['totalPage'] = $totalPage;
                $result["pages"] = '';
            }
            $result['list'] = 1;
            return ['StatusCode' => '200', 'ResultData' => $result];
        } else {
            return ['StatusCode' => '500', 'ResultData' => ['list' => 1, 'data' => '获取报名分页数据失败！']];
        }
    }

    /**
     * 获取四条随机活动，根据给定条件
     * @param $type
     * @param int $take
     * @param int $status
     * @return array
     * @author 郭庆
     */
    public function getRandomActions($take = 4, $status = 1)
    {
        $count = self::$actionCache->getCount(['status' => 1]);
        if (!$count) return ['StatusCode' => '204', 'ResultData' => "没有数据"];

        $end = (($count > $take)) ? ($count - $take) : $count;
        $start = (($count > $take)) ? random_int(0, $end) : 0;

        $result = self::$actionCache->getBetweenActions(['status' => $status], $start, $start + $take);

        if (!$result) return ['StatusCode' => '400', 'ResultData' => '获取失败'];
        return ['StatusCode' => '200', 'ResultData' => $result];
    }
}