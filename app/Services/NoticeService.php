<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/17
 * Time: 13:51
 * @author:郭庆
 */

namespace App\Services;

use App\Redis\BaseRedis;
use App\Store\NoticeStore;
use App\Store\CommentStore;
use App\Store\LikeStore;
use App\Tools\Common;
use App\Services\UserService as UserServer;
use App\Tools\CustomPage;
use Log;

class NoticeService
{
    /**
     * 引入通知数据仓储层
     */
    protected static $noticeStore;
    protected static $commentStore;
    protected static $common;
    protected static $likeStore;
    protected static $userServer;
    protected static $noticeCache;

    public function __construct(
        NoticeStore $noticeStore,
        CommentStore $commentStore,
        LikeStore $likeStore,
        UserServer $userServer
    )
    {
        self::$noticeStore = $noticeStore;
        self::$commentStore = $commentStore;
        self::$likeStore = $likeStore;
        self::$noticeStore = $noticeStore;
        self::$userServer = $userServer;
    }

    /**
     * 查询对应通知类型的所有通知数据
     * @param $type 通知类型
     * @return array
     * @author 郭庆
     * @modify 杨志宇
     */
    public static function selectByType($type)
    {
        $data = self::$noticeStore->getData(['type' => $type, 'status' => 1]);

        if ($data) return ['StatusCode' => '200', 'ResultData' => $data, 'type' => $type];
        return ['StatusCode' => '201', 'ResultData' => '暂时没有本通知信息'];

    }

    /**
     * 发布通知
     * @param $data
     * @return array
     * author 郭庆
     */
    public function insertData($data)
    {
        $data["guid"] = Common::getUuid();
        $data["addtime"] = time();

        $result = self::$noticeStore->insertData($data);

        //判断插入是否成功，并返回结果
        if (isset($result)) {
            return ['StatusCode' => '200', 'ResultData' => '发布成功'];
        }
        return ['StatusCode' => '500', 'ResultData' => '通知发布失败'];
    }

    /**
     * 分页查询
     * @param array $where 查询条件
     * @param int $nowPage 当前页
     * @param int $forPages 一页获取的数量
     * @param string $url 请求的路由url
     * @param boolean $disPlay 是否需要分页样式
     * @return array
     * author 郭庆
     */
    public function selectDatas($where, $nowPage, $forPages, $url, $disPlay = true)
    {
        //获取符合条件的数据的总量
        $count = self::$noticeStore->getCount($where);
        if (!$count) return ['StatusCode' => '204', 'ResultData' => "暂无数据"];
        //获取对应页的数据
        $result['data'] = self::$noticeStore->forPage($nowPage, $forPages, $where);
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
     * 查询相关通知信息
     * @param $guid
     * @return array  通知的信息，数组格式
     * author 郭庆
     * @modify 杨志宇
     */
    public function getData($guid)
    {
        $data = self::$noticeStore->getOneData(['guid' => $guid]);
        // 判断有没有取到数据
        if (!empty($data)) {
//            // 如果登录，则判断点赞记录
//            if (!empty(session('user'))) {
//                $res = $this->getLike(session('user')->guid, $guid);
//                if (!empty($res['msg']->support) && $res['msg']->support == 1) {
//                    $data->like = true;
//                } else {
//                    $data->like = false;
//                }
//            } else {
//                $data->like = false;
//            }
            return ['StatusCode' => '200', 'ResultData' => $data];

        }
        return ['StatusCode' => '201', 'ResultData' => "没有该通知信息！"];
    }

    /**
     * 修改通知状态
     * @param $guidAll array，['guid1', 'guid2', ***]
     * @param $status
     * @param $user
     * @return array
     * author 郭庆
     * @modify 杨志宇
     */
    public function changeStatus($guidAll, $status, $user = 1)
    {
        if ($user == 1) {
            $Data = self::$noticeStore->upload(["guid" => $guidAll['id']], ["status" => $status]);
        } else {
            $result = self::$noticeStore->getDataUserId($guidAll['id']);

            if (empty($result) || !is_array($result) || (count($result) != 1) || ($result[0]->user_id != session('user')->guid)) {
                return ['StatusCode' => '400', 'ResultData' => "没有权限"];
            } else {
                $Data = self::$noticeStore->updataAll($guidAll['id'], ["status" => $status]);
            }
        }
        //判断修改结果并返回
        if (!empty($Data)) {
            return ['StatusCode' => '200', 'ResultData' => "修改状态成功"];
        }
        return ['StatusCode' => '500', 'ResultData' => "服务器忙，修改失败"];
    }

    /**
     * 修改通知内容
     * @param $where
     * @param $data
     * @return array
     * author 郭庆
     */
    public function upDta($where, $data)
    {
        $data["addtime"] = time();
        $Data = self::$noticeStore->upload($where, $data);
        if ($Data) {
            return ['StatusCode' => '200', 'ResultData' => "修改成功"];
        } else {
            if ($Data == 0) return ['StatusCode' => '204', 'ResultData' => '未作任何更改'];
            return ['StatusCode' => '400', 'ResultData' => "服务器忙,修改失败"];
        }
    }


    /**
     * 获取评论表+like表中某一个通知的评论
     * @param $id
     * @return array
     * @author 郭庆
     */
    public static function getComment($id, $limit)
    {
        $comment = self::$commentStore->getSomeData(['action_id' => $id], $limit);

        if (!$comment) return ['StatusCode' => '201', 'ResultData' => '暂无评论'];

        foreach ($comment as $v) {
            $res = self::$userServer->userInfo(['guid' => $v->user_id]);
            if ($res['StatusCode'] == '200') {
                $v->user_name = $res['ResultData']->nickname;
                $v->headpic = $res['ResultData']->headpic;
            } else {
                $v->user_name = '无名英雄';
                $v->headpic = '';
            }
        }

        return ['StatusCode' => '200', 'ResultData' => $comment];
    }

    /**
     * 获取点赞记录用于检测是否点赞
     * @param $user_id
     * @param $notice_id
     * @return array
     * @author 郭庆
     */
    public static function getLike($user_id, $notice_id)
    {
        $result = self::$likeStore->getOneData(['action_id' => $notice_id, 'user_id' => $user_id]);
        if (!$result) return ['status' => false, 'msg' => '还未点赞'];
        return ['status' => true, 'msg' => $result];
    }

    /**
     * 添加点赞记录.
     * @param $data
     * @return array
     * @author 郭庆
     */
    public static function setLike($data)
    {
        $result = self::$likeStore->addData($data);
        if (!$result) return ['status' => false, 'msg' => '点赞失败'];
        return ['status' => true, 'msg' => $result];
    }

    /**
     * 获取点赞数量
     * @param $id
     * @return array
     * @author 郭庆
     */
    public static function getLikeNum($id)
    {
        $like = self::$likeStore->getSupportNum($id);//点赞数量
        $no_like = self::$likeStore->getNoSupportNum($id);//不支持数量

        //判断获取结果并返回
        if (isset($like) && isset($no_like)) return ['status' => true, 'msg' => [$like, $no_like]];
        return ['status' => false, 'msg' => '获取点赞数量失败'];
    }

    /**
     * 修改点赞/不支持
     * @param $user_id
     * @param $notice_id
     * @param $data
     * @return array
     * @author 郭庆
     */
    public static function chargeLike($user_id, $notice_id, $data)
    {
        $result = self::$likeStore->updateData(['user_id' => $user_id, 'action_id' => $notice_id], $data);
        if ($result) return ['status' => true, 'msg' => $result];
        return ['status' => false, 'msg' => '操作失败'];
    }

    /**
     * 分页查询 得到指定类型的数据
     * @param array $data 条件数组  主要['user_id' => 用户的GUID]
     * @return array
     * @author 杨志宇
     */
    public function selectTypeDataNum($data)
    {

        // 得到已发表的数量
        $result['trailNum'] = self::$noticeStore->getCount(['status' => 1, 'user_id' => $data['user_id']]);
        // 得到审核中的数量
        $result['releaseNum'] = self::$noticeStore->getCount(['status' => 2, 'user_id' => $data['user_id']]);
        // 得到已退稿的数量
        $result['notNum'] = self::$noticeStore->getCount(['status' => 3, 'user_id' => $data['user_id']]);
        // 得到草稿箱的数量
        $result['draftNum'] = self::$noticeStore->getCount(['status' => 4, 'user_id' => $data['user_id']]);

        // 判断有没有分页数据
        return ['StatusCode' => '200', 'ResultData' => $result];

    }

    /**
     * 得到该用户上次评论同通知的时间
     * @param $acricle_id   通知ID
     * @param $user_id  用户ID
     * @return $time  时间戳
     */
    public static function getUserCommentTime($acricle_id, $user_id)
    {
        $res = self::$commentStore->getCommentTime($acricle_id, $user_id);
        if (empty($res)) {
            return 0;
        } else {
            return strtotime($res[0]->time);
        }
    }

    /**
     * 点赞
     * @return array
     * @author 杨志宇
     */
    public function like($user_id, $id)
    {
        //判断是否点赞了
        $isHas = self::getLike($user_id, $id);

        if ($isHas['status']) {
            // 如果已经点赞，则修改状态为取消，如果是取消点赞，则修改为点赞
            if ($isHas['msg']->support == 1) {
                $setLike = self::chargeLike($user_id, $id, ['support' => 2]);
            } else {
                $setLike = self::chargeLike($user_id, $id, ['support' => 1]);
            }

            if ($setLike) return ['StatusCode' => '200', 'ResultData' => self::getLikeNum($id)['msg']];
            return ['StatusCode' => '400', 'ResultData' => '点赞失败'];
        } else {

            //没有点赞则加一条新记录
            $result = self::setLike(['support' => 1, 'action_id' => $id, 'user_id' => $user_id]);
            if ($result['status']) return ['StatusCode' => '200', 'ResultData' => self::getLikeNum($id)['msg']];
            return ['StatusCode' => '400', 'ResultData' => '点赞失败'];
        }
    }

    /**
     * 获取四条随机通知，根据给定条件
     * @param int $type 通知类型
     * @param int $take 随机通知的数量
     * @param int $status 通知状态
     * @return array
     * @author 杨志宇
     */
    public function getRandomNotices($type, $take = 4, $status = 1)
    {
        if (empty($type)) return ['StatusCode' => '400', 'ResultData' => '数据参数有误'];
        $result = self::$noticeStore->getData(['status' => $status,'type'=>$type], $take);
        return ['StatusCode' => '200', 'ResultData' => $result];
    }
}