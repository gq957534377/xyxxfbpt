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
use Illuminate\Support\Facades\Log;

class ActionService
{
    /**
     * 引入活动数据仓储层
     */
    protected static $actionStore;
    protected static $collegeStore;
    protected static $commentStore;
    protected static $actionOrderStore;
    protected static $likeStore;
    protected static $actionCache;
    protected static $collegeCache;
    protected static $pictureCache;

    public function __construct(
        ActionStore $actionStore,
        CollegeStore $collegeStore,
        ActionOrderStore $actionOrderStore,
        CommentStore $commentStore,
        LikeStore $likeStore,
        ActionCache $actionCache,
        CollegeCache $collegeCache,
        PictureCache $pictureCache
    )
    {
        self::$actionStore      = $actionStore;
        self::$commentStore     = $commentStore;
        self::$actionOrderStore = $actionOrderStore;
        self::$likeStore        = $likeStore;
        self::$collegeStore     = $collegeStore;
        self::$actionCache      = $actionCache;
        self::$collegeCache     = $collegeCache;
        self::$pictureCache     = $pictureCache;
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
        $action = self::$actionOrderStore->getSomeField(['user_id' => $data['user_id']], 'action_id');
        $isHas = in_array($data['action_id'], $action);
        if($isHas) return ['StatusCode' => '400', 'ResultData' => "已经报名参加"];

        //添加新的报名记录
        $data['addtime'] = time();
        DB::beginTransaction();
        try{
            //插入报名记录
            $result = self::$actionOrderStore->addData($data);

            //给活动信息表参与人数字段加1
            if ((int)$data['list'] == 3){
                $res = self::$collegeStore->incrementData(['guid' => $data['action_id']], 'people',1);
            }else{
                $res = self::$actionStore->incrementData(['guid' => $data['action_id']], 'people',1);
            }

            //上述俩个操作全部成功则返回成功
            if($res && $result){
                DB::commit();
                return ['StatusCode' => '200', 'ResultData' => "报名成功"];
            }else{
                return ['StatusCode' => '500', 'ResultData' => "存储有误，报名失败"];
            }
        }catch (Exception $e){
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
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        $data['deadline'] = strtotime($data['deadline']);
        $data["addtime"] = time();

        //检测时间是否符合标准
        $temp = $this->checkTime($data);
        if($temp["status"]){
            if ($data['list'] == 3){
                unset($data['list']);
                $result = self::$collegeStore->insertData($data);
                self::$collegeCache->insertOneCollege($data);
            }else{
                unset($data['list']);
                $result = self::$actionStore->insertData($data);
                self::$actionCache->insertOneAction($data);
            }

        }else{
            return ['StatusCode' => '400', 'ResultData' => $temp['msg']];
        }

        //判断插入是否成功，并返回结果
        if(!empty($result)) return ['StatusCode' => '200', 'ResultData' => "发布活动成功"];
        \Log::info('发布活动失败', $data, $result);
        return ['StatusCode' => '500', 'ResultData' => "服务器忙，发布失败"];
    }

    /**
     * 检查日期是否合乎逻辑
     *
     *  @author 张洵之
     */
    public function checkTime($data)
    {
        //转为时间戳
        $endtime = $data["end_time"];
        $deadline = $data["deadline"];
        $starttime = $data["start_time"];

        //检测开始：报名截止时间 < 活动开始时间 < 活动结束时间
        if($endtime > $starttime && $starttime > $deadline && $deadline > time()){
            return ['status' => true];
        }elseif($endtime < $starttime){
            return ['status' => false, "msg" => "结束日期不可早于开始日期"];
        }elseif($endtime < $deadline){
            return ['status' => false, "msg" => "结束日期不可早于报名截止日期"];
        }elseif($deadline<time()){
            return ['status' => false, "msg" => "报名截止日期不可早于当前日期"];
        }else{
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
        if ($old == 4){
            return ['status' => true, "msg" => "无需更改"];
        }else{
            //判断时间设置状态
            if ($time < $deadline){
                $status = 1;
            }elseif ($time > $startTime && $time < $endTime){
                $status = 2;
            }elseif ($time > $endTime){
                $status = 3;
            }elseif ($time > $deadline && $time < $startTime){
                $status = 5;
            }else{
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
     * @param int $nowPage  当前页
     * @param int $forPages 一页获取的数量
     * @param string $url 请求的路由url
     * @param boolean $disPlay 是否需要分页样式
     * @return array
     * author 郭庆
     */
    public function selectData($where, $nowPage, $forPages, $url, $list, $disPlay=true)
    {
        //判断action缓存是否存在
        if (!$list){
            $exist = !empty($where['status']) ? self::$actionCache->exists($where['type'].':'.$where['status']) : self::$actionCache->exists($where['type']);
        }else{
            if (empty($where['type'])){
                $exist = self::$collegeCache->exists('-'.':'.$where['status']);
            }else{
                $exist = !empty($where['status']) ? self::$collegeCache->exists($where['type'].':'.$where['status']) : self::$collegeCache->exists($where['type']);
            }
        }

        //如果不存在则去数据库查询并写入redis
        if(!$exist){
            Log::info('到数据库里');
            //获取数据库里的所有文章列表,并且转对象为数组
            if(!$list){
                $count = self::$actionStore->getCount($where);
            }else{
                $count = self::$collegeStore->getCount($where);
            }

            //如果没有数据返回204
            if (!$count) {
                //如果没有数据直接返回204空数组，函数结束
                if ($count == 0) return ['StatusCode' => '204', 'ResultData' => "暂无数据"];
                return ['StatusCode' => '400', 'ResultData' => '数据参数有误'];
            }

            //获取对应页的数据
            if ($list){
                $result['data'] = self::$collegeStore->forPage($nowPage, $forPages, $where);

                //获取所有数据存入redis缓存
                //从数据库取出所有数据
                $redis_list = CustomPage::objectToArray(self::$collegeStore->getData($where));
                //写入redis
                self::$collegeCache->insertCache($where, $redis_list);
            }else{
                $result['data'] = self::$actionStore->forPage($nowPage, $forPages, $where);
                //存入redis缓存
                $redis_list = CustomPage::objectToArray(self::$actionStore->getData($where));
                self::$actionCache->insertCache($where, $redis_list);
            }

        }else{//list存在查找list
            Log::info('到redis里');
            if ($list){
                $count = self::$collegeCache->getLength($where);
            }else{
                $count = self::$actionCache->getLength($where);
            }

            //查询总记录数
            if (!$count) {
                //如果没有数据直接返回204空数组，函数结束
                if ($count == 0) return ['StatusCode' => '204', 'ResultData' => []];
                return ['StatusCode' => '400', 'ResultData' => '数据参数有误'];
            }

            if(!$list){
                $result['data'] = \Qiniu\json_decode(json_encode(self::$actionCache->getActionList($where, $forPages, $nowPage)));
            }else{
                $result['data'] = \Qiniu\json_decode(json_encode(self::$collegeCache->getCollegeList($where, $forPages, $nowPage)));
            }
        }

        //计算总页数
        $totalPage = ceil($count / $forPages);

        if($result['data']){
            if ($disPlay && $totalPage > 1) {
                //创建分页样式
                $creatPage = CustomPage::getSelfPageView($nowPage, $totalPage, $url, null);

                if($creatPage){
                    $result["pages"] = $creatPage;
                }else{
                    return ['StatusCode' => '500','ResultData' => '生成分页样式发生错误'];
                }

            }else{
                $result['totalPage'] = $totalPage;
                $result["pages"] = '';
            }
            return ['StatusCode' => '200','ResultData' => $result];
        }else{
            return ['StatusCode' => '500','ResultData' => '获取分页数据失败！'];
        }
    }

    /**
     * 获取所有活动数据
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
     * @return array
     * author 郭庆
     */
    public function getData($guid, $list)
    {
        if(!$guid){
            return ['StatusCode'=> '400','ResultData' => "数据参数有误"];
        }
        //查询一条数据活动信息
        if ($list == 3){
            $data = CustomPage::arrayToObject(self::$collegeCache->getOneCollege($guid));
        }else{
            $data = CustomPage::arrayToObject(self::$actionCache->getOneAction($guid));
        }

        if($data) {
            $data->addtime = date("Y-m-d H:i:s", $data->addtime) ;
//            $group = self::$pictureCache->getOnePicture(['id'=>(int)$data->group]);
            $group = [];
            if (empty($group)){
                if ($group == []){
                    $group = '个人';
                }else{
                    \Log::info('获取'.$guid.'活动详情的组织机构失败:'.$group);
                    return ['StatusCode'=> '500','ResultData' => "获取活动信息失败"];
                }
            }
            $data->group = $group;
            return ['StatusCode'=> '200','ResultData' => $data];
        }else{
            \Log::info('获取'.$guid.'活动详情出错:'.$data);
            return ['StatusCode'=> '500','ResultData' => "获取活动信息失败"];
        }
    }

    /**
     * 修改活动状态
     * @param $guid 所要修改的id
     * @param $status 改为的状态
     * @return array
     * author 郭庆
     */
    public function changeStatus($guid, $status, $list)
    {
        if (!(!empty($guid) && !empty($status))) {
            return ['StatusCode' => '400', 'ResultData' => "参数有误"];
        }

        if ($list == 3) {
            $Data = self::$collegeStore->upload(["guid" => $guid], ["status" => $status]);
        } else {
            $Data = self::$actionStore->upload(["guid" => $guid], ["status" => $status]);
        }

        //判断修改结果并返回
        if ($Data) {
            if ($list == 3){
                self::$collegeCache->changeStatusCollege($guid, $status);
            }else{
                self::$actionCache->changeStatusAction($guid, $status);
            }
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
    public function upDta($where, $data, $list)
    {
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        $data['deadline'] = strtotime($data['deadline']);
        unset($data['list']);

        if ($list == 3) {
            $Data = self::$collegeStore->upload($where, $data);
        } else {
            $Data = self::$actionStore->upload($where, $data);
        }

        if($Data){
            if ($list == 3){
                self::$collegeCache->changeOneHash($where['guid'], $data);
            }else{
                self::$actionCache->changeOneHash($where['guid'], $data);
            }
            return ['StatusCode'=> '200','ResultData' => "修改成功"];
        }else{
            if($Data == 0) return ['StatusCode'=> '204','ResultData' => "未作任何更改"];
            \Log::info('修改'.$where['guid'].'活动出错:'.$Data);
            return ['StatusCode'=> '500','ResultData' => "服务器忙,修改失败"];
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
        if($comment) {
            return ['status' => true, 'msg' => $comment];
        }else{
            if (!is_array($comment)) \Log::info('获取'.$id.'活动的评论出错:'.$comment);
            return ['status' => false, 'msg' => '获取评论信息失败'];
        }
    }

    /**
     * 拿取三条活动数据
     * @param $type
     * @param int $number
     * @return array
     * @author 刘峻廷
     */
    public function takeActions($type,$number = 3)
    {

        if (!!empty($type)) return ['StatusCode' => '401', 'ResultData' => '缺少参数'];

        $where = ['type' => $type];

        $result = CustomPage::arrayToObject(self::$actionCache->getActionList($where, $number, 1));

        if ($result) return ['StatusCode' => '200', 'ResultData' => $result];

        Log::error('拿取三条活动数据失败', $result);

        return ['StatusCode' => '204', 'ResultData' => '暂无数据'];
    }

    /**
     * 字符限制，添加省略号
     * @param $words
     * @param $limit
     * @return string
     * @author 刘峻廷
     */
    public function wordLimit($words, $filed,$limit)
    {
        foreach($words as $word){
            $content = trim($word->$filed);
            $content = mb_substr($content, 0, $limit, 'utf-8').' ...';
            $word->$filed = $content;
        }

    }

    /**
     * 获取指定用户所报名参加的满足限制条件的活动信息
     * @param [] $actions 活动actions数组
     * @return array
     * @author 郭庆
     */
    public function getOrderActions($where, $actions, $nowPage, $forPages, $url, $list, $disPlay=true)
    {
        if ($list == 3){
            $count = self::$collegeStore->getActionsCount($where, 'guid', $actions);
        }else{
            $count = self::$actionStore->getActionsCount($where, 'guid', $actions);
        }

        if (!$count) {
            //如果没有数据直接返回201空数组，函数结束
            if ($count == 0) return ['StatusCode' => '204', 'ResultData' => ['list'=>$list,'data' => "你还未报名参加任何活动"]];
            return ['StatusCode' => '400', 'ResultData' => ['list'=>$list,'data' => '数据参数有误']];
        }

        //计算总页数
        $totalPage = ceil($count / $forPages);
        //获取所有数据
        if ($list == 3){
            $result['data'] = self::$collegeStore->getActionsPage($where, 'guid', $actions, $nowPage, $forPages);
        }else{
            $result['data'] = self::$actionStore->getActionsPage($where, 'guid', $actions, $nowPage, $forPages);
        }
        if($result['data']){
            if ($disPlay && $totalPage > 1) {
                //创建分页样式
                $creatPage = CustomPage::getSelfPageView($nowPage, $totalPage, $url, null);

                if($creatPage){
                    $result["pages"] = $creatPage;
                }else{
                    return ['StatusCode' => '500','ResultData' => ['list'=>$list,'data' => '生成分页样式发生错误']];
                }
            }else{
                $result['totalPage'] = $totalPage;
                $result["pages"] = '';
            }
            $result['list'] = $list;
            return ['StatusCode' => '200','ResultData' => $result];
        }else{
            return ['StatusCode' => '500','ResultData' => ['list'=>$list,'data' => '获取报名分页数据失败！']];
        }
    }

    /**
     * 根据条件拿取，学院培训数据
     * @param $number
     * @return array
     * @author 刘峻廷
     */
    public function takeSchoolData($number)
    {
        if (empty($number)) return ['StatusCode' => '400', 'ResultData' => '请求缺少参数'];

        $result = self::$collegeStore->takeSchoolData($number);

        if (!$result) return['StatusCode' => '400', 'ResultData' => '暂无数据'];

        return ['StatusCode' => '200', 'ResultData' => $result];
    }

    /**
     * 获取四条随机活动，根据给定条件
     * @param $type
     * @param int $take
     * @param int $status
     * @return array
     * @author 郭庆
     */
    public function getRandomActions($list, $take = 4, $status = 1)
    {
        //判断action缓存是否存在
        if ($list){
            $exist = self::$actionCache->exists('-'.':'.$status);
        }else{
            $exist = self::$collegeCache->exists('-'.':'.$status);
        }
        if (!$exist){
            if ($list){
                // 获取数据
                $all = self::$actionStore->getData([]);
                if ($all == []) return ['StatusCode' => '204', 'ResultData' => "暂无数据"];
                self::$actionCache->insertCache(['status'=>$status], CustomPage::objectToArray($all));
            }else{
                // 获取数据
                $all = self::$collegeStore->getData([]);
                if ($all == []) return ['StatusCode' => '204', 'ResultData' => "暂无数据"];
                self::$collegeCache->insertCache(['status'=>$status], CustomPage::objectToArray($all));
            }
            $result = array_slice($all,-3,-1);
        }else{
            if (!$list){
                $count = self::$collegeCache->getLength(['status'=>1]);
            }else{
                $count = self::$actionCache->getLength(['status'=>1]);
            }

            //查询总记录数
            if (!$count) {
                //如果没有数据直接返回204空数组，函数结束
                if ($count == 0) return ['StatusCode' => '204', 'ResultData' => "暂无数据"];
                return ['StatusCode' => '400', 'ResultData' => '数据参数有误'];
            }

            if($list){
                $result = array_slice (\Qiniu\json_decode(json_encode(self::$actionCache->getActionList(['status'=>1], $count, 1))), -5,-1);
            }else{
                $result = array_slice (\Qiniu\json_decode(json_encode(self::$collegeCache->getCollegeList(['status'=>1], $count, 1))), -5, -1);
            }
        }

//        if (!$result) return ['StatusCode' => '400', 'ResultData' => '获取失败'];
        return ['StatusCode' => '200', 'ResultData' => $result];
    }
























//暂时没用的方法-------------------------------------------------------------------------------------------------------

    /**
     * 获取某一类型活动某一短时间的活动列表
     * @param int $type 活动类型
     * @param [] $between 时间范围
     * @return array
     * @author 郭庆
     */
    public static function getActionByTime($type, $between)
    {
        $res = self::$actionStore->dateBetween($between);
        if (!$res) return ['StatusCode' => '204', 'ResultData' => '暂无数据'];
    }

    /**
     * 发表评论
     * @param $data ：评论表字段对应的数据['用户id','活动id','评论内容']
     * @return array
     * @author 郭庆
     */
    public static function comment($data)
    {
        $data["time"] = date("Y-m-d H:i:s", time());
        $result = self::$commentStore->addData($data);
        if ($result) return ['status' => true, 'msg' => $result];
        \Log::info('发表评论' . $data['action_id'] . '失败：' . $result);
        return ['status' => false, 'msg' => '存储数据发生错误'];
    }

    /**
     * 得到指定条件的所有活动id
     * @param $where
     * @return array
     * @author 贾济林
     */
    public function getActivityId($where)
    {
        $action = self::$actionOrderStore->getActivityId($where, 'action_id');
        if (empty($action)) return ['status' => false, 'msg' => '查询失败'];
        return ['status' => true, 'data' => $action];
    }

    /**
     * 获取点赞记录用于检测是否点赞
     * @param $user_id : 用户id
     * @param $action_id : 活动id
     * @return array
     * @author 郭庆
     */
    public static function getLike($user_id, $action_id)
    {
        $result = self::$likeStore->getOneData(['action_id' => $action_id, 'user_id' => $user_id]);
        if ($result) return ['status' => true, 'msg' => $result];
        \Log::info($action_id.'人'.'获取'.$action_id.'活动的点赞记录出错:'.$result);
        return ['status' => false, 'msg' => '还未点赞'];
    }

    /**
     * 添加点赞记录.
     * @param $data ：点赞表对应的数据
     * @return array
     * @author 郭庆
     */
    public static function setLike($data)
    {
        $result = self::$likeStore->addData($data);
        if($result) return ['status' => true, 'msg' => $result];
        \Log::info($data['user_id'].'人点赞失败：'.$result);
        return ['status' => false, 'msg' => '点赞失败'];
    }

    /**
     * 获取点赞数量
     * @param $id：活动id
     * @return array : ['点赞数量','点不支持数量']
     * @author 郭庆
     */
    public static function getLikeNum($id)
    {
        $like = self::$likeStore->getSupportNum($id);//点赞数量
        $no_like = self::$likeStore->getNoSupportNum($id);//不支持数量

        //判断获取结果并返回
        if (!empty($like) && !empty($no_like)) return ['status' => true, 'msg' => [$like,$no_like]];
        \Log::info('获取'.$id.'活动点赞记录失败：支持-'.$like.'不支持'.$no_like);
        return ['status' => false, 'msg' => '获取点赞数量失败'];
    }

    /**
     * 修改点赞/不支持
     * @param $user_id ：用户id
     * @param $action_id : 活动id
     * @param $data : 数据
     * @return array
     * @author 郭庆
     */
    public static function chargeLike($user_id, $action_id, $data)
    {
        $result = self::$likeStore->updateData(['user_id' => $user_id, 'action_id' => $action_id], $data);
        if ($result) return ['status' => true, 'msg' => $result];
        \Log::info('修改'.$action_id.'点赞失败：'.$result);
        return ['status' => false, 'msg' => '操作失败'];
    }
    /**
     * 查询获取某一类型的所有活动
     * @param int $type 活动类型
     * @return array 对应类型的所有活动组成的数组
     * @author 郭庆
     * @modify 刘峻廷
     */
    public function actionTypeData($type)
    {
        $data = self::$actionStore->getListData($type);

        if (empty($data)) return ['StatusCode' => '400', 'ResultData' => '暂时没有本活动信息'];
        return ['StatusCode' => '200', 'ResultData' => $data];
    }

    /**
     * 获取报名信息
     * @param $guid
     * @return array
     * @author 郭庆
     */
    public function getOrderInfo($where, $nowPage, $forPages, $url, $disPlay=true)
    {
        $count = self::$actionOrderStore->getCount($where);
        if (!$count) {
            //如果没有数据直接返回201空数组，函数结束
            if ($count == 0) return ['StatusCode' => '204', 'ResultData' => []];
            return ['StatusCode' => '400', 'ResultData' => '数据参数有误'];
        }
        //计算总页数
        $totalPage = ceil($count / $forPages);
        //获取所有数据
        $result['data'] = self::$actionOrderStore->forPage($nowPage, $forPages, $where);

        if($result['data']){
            if ($disPlay && $totalPage > 1) {
                //创建分页样式
                $creatPage = CustomPage::getSelfPageView($nowPage, $totalPage, $url, null);

                if($creatPage){
                    $result["pages"] = $creatPage;
                }else{
                    return ['StatusCode' => '500','ResultData' => '生成分页样式发生错误'];
                }
            }else{
                $result['totalPage'] = $totalPage;
                $result["pages"] = '';
            }
            return ['StatusCode' => '200','ResultData' => $result];
        }else{
            return ['StatusCode' => '500','ResultData' => '获取报名分页数据失败！'];
        }
    }

    /**
     * 修改活动报名状态
     * @param $guid ：活动id
     * @param $status : 当前状态
     * @return array
     * @author 郭庆
     */
    public function switchStatus($guid, $status)
    {
        $res = self::$actionOrderStore->updateData(['action_id' => $guid], ['status' => $status]);
        if ($res==0) return ['status' => false, 'msg' => '修改失败'];
        return ['status' => true, 'msg' => '修改成功'];
    }
}
