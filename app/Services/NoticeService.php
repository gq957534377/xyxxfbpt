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
use App\Redis\ArticleCache;
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
    protected static $articleCache;

    public function __construct(
        NoticeStore $noticeStore,
        CommentStore $commentStore,
        LikeStore $likeStore,
        UserServer $userServer,
        ArticleCache $articleCache
    )
    {
        self::$noticeStore = $noticeStore;
        self::$commentStore = $commentStore;
        self::$likeStore = $likeStore;
        self::$noticeStore = $noticeStore;
        self::$userServer = $userServer;
        self::$articleCache = $articleCache;
    }

    /**
     * 查询对应通知类型的所有通知数据
     * @param $type 通知类型
     * @return array
     * @author 郭庆
     * @modify 王通
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
            self::$articleCache->insertLeftCache([$data]);
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
     * 说明:
     *
     * @param $where
     * @param $nowPage
     * @param $forPages
     * @param $url
     * @param bool $disPlay
     * @return array
     * @author 郭庆
     */
    public function selectData($where, $nowPage, $forPages, $url, $disPlay = true)
    {
        //获取符合条件的数据的总量
        $count = self::$articleCache->getCount($where);
        if (!$count) return ['StatusCode' => '204', 'ResultData' => "暂无数据"];
        //获取对应页的数据
        $result['data'] = self::$articleCache->getPageDatas($where, $forPages, $nowPage);
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
     * 分页查询 判断是否查redis
     * @param array $where 查询条件
     * @param int $nowPage 当前页
     * @param int $forPages 一页获取的数量
     * @param string $url 请求的路由url
     * @param boolean $disPlay 是否需要分页样式
     * @return array
     * author 王通
     */
    public function selectArticle($where, $nowPage, $forPages, $url, $disPlay = true)
    {
        // 判断article缓存是否存在
        if (!self::$articleCache->exists(LIST_ARTICLE_INFO_ . $where['type'])) {
            // 判断guid有没有取失败
            $guidArr = self::$noticeStore->getAllGuid($where);
            if (!empty($guidArr)) {
                // 获取数据库里的所有通知列表,并且转对象为数组
                $article_list = CustomPage::objectToArray($guidArr);
            } else {
                return ['StatusCode' => '500', 'ResultData' => '获取失败'];
            }

            $result = $this->selectData($where, $nowPage, $forPages, $url, $disPlay);
            // 存入redis缓存
            if ($result['StatusCode'] == '200') {
                if (count($article_list)) {
                    // 把数据保存进HASH
                    foreach ($result['ResultData']['data'] as $item) {
                        $info = CustomPage::objectToArray($item);
                        self::$articleCache->addHash(HASH_ARTICLE_INFO_ . $info['guid'], $info);
                    }
                    self::$articleCache->setArticleList($article_list, $where['type']);
                }
            }

        } else {
            // 直接读取缓存数据,并把数组转换为对象
            $result = $this->selectArticleRedis($forPages, $nowPage, $where['type']);
        }

        return $result;
    }

    /**
     * 读取redis数据，并且把得到的数据转换成对象
     * @param $forPages  int   一页获取的数量
     * @param $nowPage  int   当前页
     * @param $type   数据的类型
     * @return array
     * @author 王通
     */
    public function selectArticleRedis($forPages, $nowPage, $type)
    {
        // 读取list长度
        $count = self::$articleCache->getLength(LIST_ARTICLE_INFO_ . $type);
        // 分页页数
        $totalPage = ceil($count / $forPages);
        $result['data'] = self::$articleCache->getArticleList($forPages, $nowPage, $type);
        $result['totalPage'] = $totalPage;
        return ['StatusCode' => '200', 'ResultData' => $result];

    }

    /**
     * 查询相关通知信息
     * @param $guid
     * @return array  通知的信息，数组格式
     * author 郭庆
     * @modify 王通
     */
    public function getData($guid)
    {
        $data = self::$articleCache->getOneArticle($guid);
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
     * @param $guidAll 数组，['guid1', 'guid2', ***]
     * @param $status
     * @param $user
     * @return array
     * author 郭庆
     * @modify 王通
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
            if (!empty($data['status'])) {
                // 更新redis
                $dataInfo = self::$noticeStore->getOneData(['guid' => $where['guid']]);
                if ($data['status'] == 5 || $data['status'] == 3) {
                    $res = self::$articleCache->delList(LIST_ARTICLE_INFO_ . $dataInfo->type, $dataInfo->guid);
                }
            }
            // 删除哈希值
            self::$articleCache->delKey(HASH_ARTICLE_INFO_ . $where['guid']);
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
     * @param $article_id
     * @return array
     * @author 郭庆
     */
    public static function getLike($user_id, $article_id)
    {
        $result = self::$likeStore->getOneData(['action_id' => $article_id, 'user_id' => $user_id]);
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
     * @param $article_id
     * @param $data
     * @return array
     * @author 郭庆
     */
    public static function chargeLike($user_id, $article_id, $data)
    {
        $result = self::$likeStore->updateData(['user_id' => $user_id, 'action_id' => $article_id], $data);
        if ($result) return ['status' => true, 'msg' => $result];
        return ['status' => false, 'msg' => '操作失败'];
    }

    /**
     * 分页查询 得到指定类型的数据
     * @param array $data 条件数组  主要['user_id' => 用户的GUID]
     * @return array
     * @author 王通
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
     * 用户发布文稿
     * @param $data
     * @return array
     * @author 郭庆
     */
    public function addArticle($data)
    {
        unset($data['verif_code']);
        // 判断是否为修改文稿内容
        if (!empty($data['write'])) {
            $guid = $data['write'];
            unset($data['write']);
            $this->upDta(['guid' => $guid], ['status' => 5]);
        }
        unset($data['write']);
        $data["guid"] = Common::getUuid();
        $data["addtime"] = time();
        $data['user'] = 2;
        // 判断是否是预览
        if ($data['status'] == 0) {
            $md5Guid = md5(session('user')->guid);
            // 预览内容写入redis，
            if (BaseRedis::setexRedis($md5Guid, json_encode($data), 1800)) {
                return ['StatusCode' => '200.1', 'ResultData' => $md5Guid];
            };
            return ['StatusCode' => '400', 'ResultData' => '预览出错，请联系管理员！'];
        }
        if ($data['status'] != '2' && $data['status'] != '4') {
            $data['status'] = '4';
        }
        $result = self::$noticeStore->insertData($data);
        //判断插入是否成功，如果成功则写入redis并返回结果

        if (isset($result)) {
            session(['code' => '']);
            return ['StatusCode' => '200', 'ResultData' => '保存成功'];
        }
        return ['StatusCode' => '400', 'ResultData' => '存储数据发生错误'];
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
     * @author 王通
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
     * 把预览数据从缓存中取出
     * @param string $id GUID标识
     * @return array
     * @author 王通
     */
    public function getCacheContribution($id)
    {
        $data = BaseRedis::getRedis($id);
        if (!empty($data)) {
            $result = json_decode($data);
            return ['StatusCode' => '200', 'ResultData' => $result];
        } else {
            return ['StatusCode' => '400', 'ResultData' => '查询失败'];
        }

    }

    /**
     * 获取八条通知，根据给定条件
     * @param int $type 通知类型
     * @param int $take 通知条数
     * @param int $status 通知状态
     * @return array
     * @author 刘峻廷
     * @modify 王通
     */
    public function getTakeArticles($type, $take = 8, $status = 1)
    {
        // 判断article缓存是否存在
        if (!self::$articleCache->exists(LIST_ARTICLE_INFO_ . $type)) {
            // 获取数据库里的所有通知列表,并且转对象为数组
            // 判断guid有没有取失败
            $guidArr = self::$noticeStore->getAllGuid(['type' => $type, 'status' => $status]);
            if (!empty($guidArr)) {
                // 获取数据库里的所有通知列表,并且转对象为数组
                $article_list = CustomPage::objectToArray($guidArr);
            }
            $result = $this->selectData(['type' => $type], 1, $take, 'aaa', false);
            // 存入redis缓存
            // 判断返回值是否正确
            if ($result['StatusCode'] == '200') {
                if (count($article_list)) {
                    // 把数据保存进HASH
                    foreach ($result['ResultData']['data'] as $item) {
                        $info = CustomPage::objectToArray($item);
                        self::$articleCache->addHash(HASH_ARTICLE_INFO_ . $info['guid'], $info);
                    }
                    self::$articleCache->setArticleList($article_list, $type);
                }
                $result = $result['ResultData']['data'];
            }


        } else {
            // 直接读取缓存数据,并把数组转换为对象
            $result = $this->selectArticleRedis($take, 1, $type);
            $result = $result['ResultData']['data'];

        }


//        if (empty($type)) return ['StatusCode' => '400', 'ResultData' => '请求参数缺失'];
//
//        // 获取通知数据
//        $result = self::$noticeStore->takeArticles(['type' => '1', 'status' => $status], $take);
//        dd($result);
//        if (!$result) return ['StatusCode' => '400', 'ResultData' => '暂无数据'];

        return ['StatusCode' => '200', 'ResultData' => $result];
    }

    /**
     * 获取四条随机通知，根据给定条件
     * @param int $type 通知类型
     * @param int $take 随机通知的数量
     * @param int $status 通知状态
     * @return array
     * @author 王通
     */
    public function getRandomArticles($type, $take = 4, $status = 1)
    {
        if (!self::$articleCache->exists(LIST_ARTICLE_INFO_ . $type)) {
            if (empty($type)) return ['StatusCode' => '400', 'ResultData' => '请求参数缺失'];
            $start = self::$noticeStore->getCount(['type' => $type, 'status' => $status]);
            // 获取通知数据
            $result = self::$noticeStore->RandomArticles(['type' => $type, 'status' => $status], $take, rand(1, $start - $take));
            if (!$result) return ['StatusCode' => '400', 'ResultData' => '暂无数据'];
        } else {
            $result = $this->getRandomRedisArticle($type, $take);
        };
        return ['StatusCode' => '200', 'ResultData' => $result];
    }

    /**
     * 随机获取前四条数据的具体方法
     * @param $type  string  '1'  or  '2'  获取数据的类型
     * @param $num   int   数量
     * @return mixed
     * @author 王通
     */
    protected function getRandomRedisArticle($type, $num)
    {
        // 得到list的长度
        $count = self::$articleCache->getLength(LIST_ARTICLE_INFO_ . $type);
        // 随机获取四个数字
        $numArr = range(0, $count - 1);
        shuffle($numArr);
        $nowPageArr = array_slice($numArr, 0, $num);

        // 根据随机数，通过索引得到想要的数据
        for ($i = 0; $i < $num; $i++) {
            $res = self::$articleCache->getArticleList(1, $nowPageArr[$i], $type);
            if (!empty($res)) {
                $data[$i] = $res[0];
            }

        }
        $result = $data;
        return $result;
    }














    //暂时不用的方法--------------------------------------------------------------------------------------------------------------
    /**
     * 发表评论
     * @param $data  数组，['action_id' => '通知ID', 'user_id' => '用户ID', 'count '评论内容']
     * @return array
     * @author 郭庆
     * @modify 王通
     */
    public static function comment($data)
    {
        $data["time"] = date("Y-m-d H:i:s", time());


        // 判断两次评论之间的时间间隔
        $oldTime = self::getUserCommentTime($data['action_id'], session('user')->guid);
        if (($oldTime + config('safety.COMMENT_TIME')) > time()) {
            return ['StatusCode' => '400', 'ResultData' => '两次评论间隔过短，请稍后重试'];
        };

        $result = self::$commentStore->addData($data);
        if ($result) {
            // 获取评论信息
            $comment = self::getComment($data['action_id'], 1);
            return ['StatusCode' => '200', 'ResultData' => $comment['ResultData'][0]];
        }

        return ['StatusCode' => '400', 'ResultData' => '存储数据发生错误'];

    }

    /**
     * 获取指定用户所发表的所有通知
     * @param $id
     * @param $status
     * @return array
     * @author 郭庆
     * @modify 王通
     */
    public static function getArticleByUser($id, $status)
    {
        $result = self::$noticeStore->getData(['user_id' => $id, 'status' => $status]);
        if ($result) {
            return ['StatusCode' => '200', 'ResultData' => $result];
        } else {
            return ['StatusCode' => '201', 'ResultData' => '没有数据'];
        }

    }
}