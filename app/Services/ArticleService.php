<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/17
 * Time: 13:51
 * @author:郭庆
 */

namespace App\Services;
use App\Store\ArticleStore;
use App\Store\CommentStore;
use App\Store\LikeStore;
use App\Tools\Common;
use App\Services\UserService as UserServer;
use App\Tools\CustomPage;

class ArticleService
{
    /**
     * 引入文章数据仓储层
     */
    protected static $articleStore;
    protected static $commentStore;
    protected static $common;
    protected static $likeStore;
    protected static $userServer;

    public function __construct(
        ArticleStore $articleStore,
        CommentStore $commentStore,
        LikeStore $likeStore,
        UserServer $userServer
    ){
        self::$articleStore = $articleStore;
        self::$commentStore = $commentStore;
        self::$likeStore = $likeStore;
        self::$articleStore = $articleStore;
        self::$userServer = $userServer;
    }

    /**
     * 查询对应文章类型的所有文章数据
     * @param $type 文章类型
     * @return array
     * @author 郭庆
     * @modify 王通
     */
    public static function selectByType($type)
    {
        $data = self::$articleStore->getData(['type' => $type, 'status' => 1]);

        if($data) return ['StatusCode' => '200', 'ResultData' => $data];
        return ['StatusCode' => '201', 'ResultData' => '暂时没有本文章信息'];

    }

    /**
     * 发布文章
     * @param $data
     * @return array
     * author 郭庆
     */
    public function insertData($data)
    {
        $data["guid"] = Common::getUuid();
        $data["addtime"] = time();

        $result = self::$articleStore->insertData($data);

        //判断插入是否成功，并返回结果
        if(isset($result)) return ['StatusCode' => '200', 'ResultData' => '发布成功'];
        return ['StatusCode' => '500', 'ResultData' => '文章发布失败'];
    }

    /**
     * 分页查询
     * @param array $where 查询条件
     * @param int $nowPage  当前页
     * @param int $forPages 一页获取的数量
     * @param string $url 请求的路由url
     * @param boolean $disPlay 是否需要分页样式
     * @return array
     * author 郭庆
     */
    public function selectData($where, $nowPage, $forPages, $url, $disPlay=true)
    {
        //查询总记录数
        $count = self::$articleStore->getCount($where);
        if (!$count) {
            //如果没有数据直接返回201空数组，函数结束
            if ($count == 0) return ['StatusCode' => '204', 'ResultData' => []];
            return ['StatusCode' => '400', 'ResultData' => '数据参数有误'];
        }
        //计算总页数
        $totalPage = ceil($count / $forPages);

        //获取对应页的数据
        $result['data'] = self::$articleStore->forPage($nowPage, $forPages, $where);
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
     * 查询相关文章信息
     * @param $guid
     * @return array  文章的信息，数组格式
     * author 郭庆
     * @modify 王通
     */
    public function getData($guid)
    {
        $data = self::$articleStore->getOneData(["guid" => $guid]);
        // 判断有没有取到数据
        if ($data) {
            // 如果登录，则判断点赞记录
            if (!empty(session('user'))) {
                $res = $this->getLike(session('user')->guid, $guid);
                if (!empty($res['msg']->support) && $res['msg']->support == 1) {
                    $data->like = true;
                } else {
                    $data->like = false;
                }
            } else {
                $data->like = false;
            }
            return ['StatusCode' => '200', 'ResultData' => $data];

        }
        //查询一条数据文章信息
        $data = self::$articleStore->getOneData(["guid" => $guid]);
        if($data) return ['StatusCode' => true, 'ResultData' => $data];
        return ['StatusCode' => '201', 'ResultData' => "没有该文章信息！"];
    }

    /**
     * 修改文章状态
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
            $Data = self::$articleStore->upload(["guid" => $guidAll['id']], ["status" => $status]);
        } else {
            $result = self::$articleStore->getDataUserId($guidAll['id']);

            if (empty($result) || !is_array($result) || (count($result) != 1) || ($result[0]->user_id != session('user')->guid)) {
                return ['StatusCode'=> '400', 'ResultData' => "没有权限"];
            } else {

                $Data = self::$articleStore->updataAll($guidAll['id'], ["status" => $status]);

            }
        }

        //判断修改结果并返回
        if(!empty($Data)) return ['StatusCode'=> '200', 'ResultData' => "修改状态成功"];
        return ['StatusCode'=> '500', 'ResultData' => "服务器忙，修改失败"];
    }


    /**
     * 修改文章内容
     * @param $where
     * @param $data
     * @return array
     * author 郭庆
     */
    public function upDta($where, $data)
    {
        $data["addtime"] = time();
        $Data = self::$articleStore->upload($where, $data);
        if($Data){
            return ['StatusCode'=> 200,'ResultData' => "修改成功"];
        }else{
            return ['StatusCode'=> 400,'ResultData' => "服务器忙,修改失败"];
        }
    }

    /**
     * 获取评论表+like表中某一个文章的评论
     * @param $id
     * @return array
     * @author 郭庆
     */
    public static function getComment($id, $limit)
    {
        $comment = self::$commentStore->getSomeData(['action_id' => $id], $limit);

        if(!$comment) return ['StatusCode' => '201', 'ResultData' => '暂无评论'];

            foreach ($comment as $v)
            {
                $res = self::$userServer->userInfo(['guid' => $v->user_id]);
                if($res['StatusCode'] == '200'){
                    $v->user_name = $res['ResultData']->nickname;
                    $v->headpic = $res['ResultData']->headpic;
                }else{
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
        if(!$result) return ['status' => false, 'msg' => '点赞失败'];
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
        if (isset($like) && isset($no_like)) return ['status' => true, 'msg' => [$like,$no_like]];
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
     * 发表评论
     * @param $data  数组，['action_id' => '文章ID', 'user_id' => '用户ID', 'count '评论内容']
     * @return array
     * @author 郭庆
     * @modify 王通
     */
    public static function comment($data)
    {
        $data["time"] = date("Y-m-d H:i:s", time());


        // 判断两次评论之间的时间间隔
        $oldTime = self::getUserCommentTime ($data['action_id'], session('user')->guid);
        if (($oldTime + config('safety.COMMENT_TIME')) > time()) {
            return ['StatusCode' => '400', 'ResultData' => '两次评论间隔过短，请稍后重试'];
        };

        $result = self::$commentStore->addData($data);
        if($result) {
            // 获取评论信息
            $comment = self::getComment($data['action_id'], 1);
            return ['StatusCode' => '200', 'ResultData' => $comment['ResultData'][0]];
        }

        return ['StatusCode' => '400', 'ResultData' => '存储数据发生错误'];

    }

    /**
     * 分页查询 得到指定类型的数据
     * @param $request
     * @return array
     * @author 王通
     */
    public function selectTypeData($data)
    {


        $forPages = 10;          // 每页数据数
        $where = $data;
        $nowPage = isset($data["nowPage"]) ? (int)$data["nowPage"]:1;//获取当前页
        unset($where['nowPage']);
        unset($where['totalPage']);

        $creatPage = Common::getPageUrls($data, "data_article_info", "/send", $forPages, null, $where);

        if(isset($creatPage)){
            $result["pages"] = $creatPage['pages'];
        }else{
            return ['StatusCode' => '403', 'ResultData' => '生成分页样式发生错误'];
        }
        // 得到分页数据
        $Data = self::$articleStore->forPage($nowPage, $forPages, $where);
        // 得到已发表的数量
        $result['trailNum'] = self::$articleStore->getCount(['status' => 1,'user_id' => $data['user_id']]);
        // 得到审核中的数量
        $result['releaseNum'] = self::$articleStore->getCount(['status' => 2,'user_id' => $data['user_id']]);
        // 得到已退稿的数量
        $result['notNum'] = self::$articleStore->getCount(['status' => 3,'user_id' => $data['user_id']]);
        // 得到草稿箱的数量
        $result['draftNum'] = self::$articleStore->getCount(['status' => 4,'user_id' => $data['user_id']]);

        // 判断有没有分页数据
        if(!empty($Data)){
            $result["data"] = $Data;
            return ['StatusCode' => '200', 'ResultData' => $result];
        }else{
            return ['StatusCode' => '200', 'ResultData' => $result];
        }
    }

    /**
     * 获取指定用户所发表的所有文章
     * @param $id
     * @param $status
     * @return array
     * @author 郭庆
     * @modify 王通
     */
    public static function getArticleByUser($id, $status)
    {
        $result = self::$articleStore->getData(['user_id' => $id, 'status' => $status]);
        if($result) {
            return ['StatusCode' => '200', 'ResultData' => $result];
        } else {
            return ['StatusCode' => '201', 'ResultData' => '没有数据'];
        }

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
        if (!empty($data['write'])) {
            $guid = $data['write'];
            unset($data['write']);
            $this->upDta(['guid' => $guid], ['status' => 5]);
        }

        $data["guid"] = Common::getUuid();
        $data["addtime"] = time();
        $data['user'] = 2;
        if ($data['status'] != '2' && $data['status'] != '4') {
            $data['status'] = '4';
        }
        $result = self::$articleStore->insertData($data);

        //判断插入是否成功，并返回结果
        if(isset($result)) return ['StatusCode' => '200', 'ResultData' => $result];
        return ['StatusCode' => '400', 'ResultData' => '存储数据发生错误'];
    }

    /**
     * 得到该用户上次评论同文章的时间
     * @param $acricle_id   文章ID
     * @param $user_id  用户ID
     * @return $time  时间戳
     */
    public static function getUserCommentTime ($acricle_id, $user_id)
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

        if($isHas['status']) {
            // 如果已经点赞，则修改状态为取消，如果是取消点赞，则修改为点赞
            if ($isHas['msg']->support == 1) {
                $setLike = self::chargeLike($user_id, $id, ['support' => 2]);
            } else {
                $setLike = self::chargeLike($user_id, $id, ['support' => 1]);
            }

            if ($setLike) return ['StatusCode' => '200',  'ResultData' => self::getLikeNum($id)['msg']];
            return ['StatusCode' => '400',  'ResultData' => '点赞失败'];
        }else{

            //没有点赞则加一条新记录
            $result = self::setLike(['support' => 1, 'action_id' => $id, 'user_id' => $user_id]);
            if($result['status']) return ['StatusCode' => '200',  'ResultData' => self::getLikeNum($id)['msg']];
            return ['StatusCode' => '400', 'ResultData' => '点赞失败'];
        }
    }
}