<?php

namespace App\Services;

use App\Store\ProjectStore;
use App\Redis\ProjectCache;
use App\Redis\UserInfoCache;
use App\Store\UserStore;
use App\Tools\Common;
use Log;

class ProjectService
{
    protected static $projectStore = null;
    protected static $userStore = null;
    protected static $projectCache = null;
    protected static $userInfoCache = null;
    // 日期时间业务辅助层
    protected static $dateService = null;

    /**
     * 构造函数注入
     * ProjectService constructor.
     *
     */
    public function __construct(
        ProjectStore $projectStore,
        UserStore $userStore,
        ProjectCache $projectCache,
        UserInfoCache $userInfoCache,
        DateService $dateService
    )
    {
        self::$projectStore = $projectStore;
        self::$userStore = $userStore;
        self::$projectCache = $projectCache;
        self::$userInfoCache = $userInfoCache;
        self::$dateService = $dateService;
    }

    /**
     * 获取指定条件的数据
     * @param $where
     * @return array
     * @author guoqing
     * @modify 张洵之
     */
    public function getData($nowPage, $pageNum, $where)
    {
        //判断请求来自前台还是用户中心
        if (empty($where['user_guid'])) {
            $data = self::$projectCache->getPageData($nowPage, $pageNum, $where);
        } else {
            $data = self::$projectStore->getPage($nowPage, $pageNum, $where);
        }

        if (!$data) return ['StatusCode' => '400', 'ResultData' => '暂无数据'];

        return ['StatusCode' => '200', 'ResultData' => $data];
    }


    /**
     * 随机拿取指定条数 数据
     * @param int $number 默认3条
     * @return array
     * @author 刘峻廷
     * @modify 张洵之
     */
    public function takeData($number = 3)
    {
        $data = self::$projectCache->takeData($number);

        if ($data) {
            return ['StatusCode' => '200', 'ResultData' => $data];
        } else {
            return ['StatusCode' => '400', 'ResultData' => '暂无数据'];
        }


    }

    /**
     * 修改项目状态
     * @param $data
     * @return array
     * @author guoqing
     * @modify 张洵之
     */
    public function changeStatus($data)
    {

        $updateData = array();

        if (isset($data['remark'])) $updateData = ['remark' => $data['remark']];

        //整理参数
        $param = ['guid' => $data['id']];
        //根据传入参数指定状态值
        $updateData['status'] = $data['status'];
        //修改日期
        $updateData['changetime'] = time();
        //更新状态值
        $res = self::$projectStore->update($param, $updateData);

        if ($res == 0) return ['StatusCode' => '400', 'ResultData' => '修改数据失败'];

        $this->changeCache($data['id'], (int)$data['status']);//更新缓存
        return ['StatusCode' => '200', 'ResultData' => '修改成功'];
    }

    /**
     * 指定当前页、单页数据量、和项目状态获取数据(后台方法)
     * @param $nowpage
     * @param $num
     * @param $status
     * @return array
     * @author guoqing
     * @modify 张洵之
     */
    public function getPage($nowpage, $num, $status)
    {
        $where = ['status' => $status];

        $res = self::$projectStore->getPage($nowpage, $num, $where);

        if (!$res) return ['StatusCode' => '400', 'ResultData' => '未获取到数据'];

        return ['StatusCode' => '200', 'ResultData' => $res];
    }


    /**
     * 取出详情数据
     * @param string $id 项目guid
     * @return array
     * author 张洵之
     */
    public function getProject($id)
    {
        if (empty($id)) ['StatusCode' => '400', 'ResultData' => '参数为空'];

        $projectInfoData = self::$projectCache->getProjectHash([$id]);

        if (empty($projectInfoData)) return ['StatusCode' => '400', 'ResultData' => '暂无数据'];

        $projectInfoData = $projectInfoData[0];
        $userInfo = self::$userInfoCache->getOneUserCache($projectInfoData->user_guid);
        if (empty($userInfo)) {
            Log::info('项目详情页：' . $id . ', 未找到发布用户数据');
            return ['StatusCode' => '400', 'ResultData' => '未找到发布用户数据'];
        }

        $projectInfoData->project_experience = $this->openData(
            $projectInfoData->project_experience,
            '*zxz*',
            ':::'
        );
        $projectInfoData->team_member = $this->openData(
            $projectInfoData->team_member,
            '*zxz*',
            '!,/'
        );
        $projectInfoData->userInfo = $userInfo;

        return ['StatusCode' => '200', 'ResultData' => $projectInfoData];
    }

    /**
     * 更新项目数据
     * @param $data
     * @param $where
     * @return array
     * @author guoqing
     */
    public function updateData($data, $where)
    {
        if (empty($data) || empty($where)) return ['StatusCode' => '400', 'ResultData' => '参数不全'];
        //重新提交后，将status改为0
        $data['status'] = 0;
        $data['changetime'] = time();
        $res = self::$projectStore->update($where, $data);

        if ($res == 0) return ['StatusCode' => '400', 'ResultData' => '更新失败'];

        return ['StatusCode' => '200', 'ResultData' => '更新成功'];
    }

    /**
     * 软删除某个项目
     * @param $where
     * @param $data
     * @return array
     * @author 张洵之
     */
    public function deletProject($where)
    {
        if (empty($where)) return ['StatusCode' => '400', 'ResultData' => '删除失败'];

        $data['status'] = 3;
        $data['changetime'] = time();
        $res = self::$projectStore->update($where, $data);

        if ($res == 0) return ['StatusCode' => '400', 'ResultData' => '删除失败'];

        return ['StatusCode' => '200', 'ResultData' => '删除成功'];
    }

    /**
     * 向项目信息表添加数据
     * @param $data
     * @return array
     * author 张洵之
     */
    public function addProjects($data)
    {
        if (empty($data) || !is_array($data)) return ['StatusCode' => '400', 'ResultData' => '项目添加失败'];

        $data['user_guid'] = session('user')->guid;
        $data['guid'] = Common::getUuid();
        $data['addtime'] = time();
        $data['changetime'] = time();
        $result = self::$projectStore->addData($data);

        if ($result) return ['StatusCode' => '200', 'ResultData' => '添加成功'];

        return ['StatusCode' => '400', 'ResultData' => '项目添加失败'];
    }

    /**
     * 将格式化字符串转数组
     * @param string $str 要转的字符串
     * @param string $tab1 一级分隔符
     * @param string $tab2 二级分隔符
     * @return array
     * author 张洵之
     */
    private function openData($str, $tab1, $tab2)
    {
        if(empty($str)) return [];

        $arr = explode($tab1, $str);
        $num = count($arr) - 1;
        unset($arr[$num]);
        for ($i = 0; $i < $num; $i++) {
            $arr[$i] = explode($tab2, $arr[$i]);
        }
        return $arr;
    }

    /**
     * 返回条件下的项目数量
     * @param $where
     * @return mixed
     * author 张洵之
     */
    public function getCount($where)
    {
        if (empty($where)) ['StatusCode' => '400', 'ResultData' => '参数有误'];

        $result = self::$projectStore->getCount($where);

        return ['StatusCode' => '200', 'ResultData' => $result];
    }

    /**
     * 返回一条数据(用于用户项目的修改)
     * @param $where
     * @return array
     * author 张洵之
     */
    public function getOneData($where)
    {
        if (empty($where)) return ['StatusCode' => '400', 'ResultData' => '参数为空'];;
        $result = self::$projectStore->getOneData($where);

        if (empty($result)) return ['StatusCode' => '400', 'ResultData' => '暂无数据'];

        $result->ex = $this->openData(
            $result->project_experience,
            '*zxz*',
            ':::'
        );
        $result->person = $this->openData(
            $result->team_member,
            '*zxz*',
            '!,/'
        );

        return ['StatusCode' => '200', 'ResultData' => $result];
    }

    /**
     * 更改缓存
     * @param $guid
     * @param $status
     * @return mixed
     * author 张洵之
     */
    public function changeCache($guid, $status)
    {

        switch ($status) {
            case 1 :
                return $this->createCache($guid);
                break;

            case 2 :
                return $this->deleltCache($guid);
                break;
        }
    }

    /**
     * 创建缓存
     * @param $guid
     * @return bool
     * author 张洵之
     */
    public function createCache($guid)
    {
        $data = self::$projectStore->getOneData(['guid' => $guid]);

        if (empty($data)) return false;

        $result = self::$projectCache->insertCache($data);
        return $result;
    }

    /**
     * 删除缓存
     * @param $guid
     * @return bool
     * author 张洵之
     */
    public function deleltCache($guid)
    {
        $data = self::$projectStore->getOneData(['guid' => $guid]);

        if ($data->status == 0) return false;//待审核的项目

        $result = self::$projectCache->deletCache($data);
        return $result;
    }

    /**
     * 根据条件返回相应用户的数量
     *
     * @param  array() $req
     * @return array
     *
     * @author 崔小龙
     */
    public function tradeProjectCount($req)
    {
        if (empty($req)) return '';

        switch ($req['time']) {
            case 'week':
                $data = $this->weekCount($req['status']);
                return ['status' => $data['status'], 'time' => 'week', 'data' => $data['data']];
            case 'month':
                $data = $this->monthCount($req['status']);
                return ['status' => $data['status'], 'time' => 'month', 'data' => $data['data']];
            case 'year':
                $data = $this->yearCount($req['status']);
                return ['status' => $data['status'], 'time' => 'year', 'data' => $data['data']];
            case 'hours':
                $data = $this->hoursCount($req['status']);
                return ['status' => $data['status'], 'time' => 'hours', 'data' => $data['data']];
        }
    }

    /**
     * 返回本周用户数量（私有）
     *
     * @param string $status
     * @return array | false
     *
     * @author 崔小龙
     */
    private function weekCount($status)
    {
        $data = [];
        for ($i = 1; $i <= 7; $i++) {
            $timeArr = self::$dateService->getWeek($i);
            $where = [$timeArr['startTime'], $timeArr['endTime']];

            $tempNum = self::$projectStore->getTimeNum($where, $status);

            $data[$i - 1] = $tempNum;
        }
        return ['status' => $status, 'data' => $data];
    }

    /**
     * 返回本月订单数量 （私有）
     *
     * @param string $status
     * @return array
     *
     * @author 崔小龙
     */
    private function monthCount($status)
    {
        $today = (int)date("d");
        $data = [];
        for ($i = 1; $i <= $today; $i++) {
            $timeArr = self::$dateService->getMonthSomeoneDay($i);
            $where = [$timeArr['startTime'], $timeArr['endTime']];

            $tempNum = self::$projectStore->getTimeNum($where, $status);

            $data[$i - 1] = $tempNum;
        }
        return ['status' => $status, 'data' => $data];
    }

    /**
     * 返回本年度订单数量 （私有）
     *
     * @param string $status
     * @return array
     *
     * @author 崔小龙
     */
    private function yearCount($status)
    {
        $toMonth = (int)date("m");
        $data = [];
        for ($i = 1; $i <= $toMonth; $i++) {
            $timeArr = self::$dateService->getMonth($i);
            $where = [$timeArr["startTime"], $timeArr["endTime"]];

            $tempNum = self::$projectStore->getTimeNum($where, $status);

            $data[$i - 1] = $tempNum;
        }
        return ['status' => $status, 'data' => $data];
    }


    public function wechatData($data)
    {
        if (empty($data) || !is_array($data)) {
            return ['StatusCode' => '400', 'ResultData' => '参数不正确！'];
        }
        // 所属行业置换数组
        $swetchArr1 = [
            'TMT' => 1,
            '医疗健康' => 2,
            '文化与创意' => 3,
            '智能硬件' => 4,
            '教育' => 5,
            '电商' => 6,
            '旅游'=> 7,
            '新农业' => 8,
            '互联网金融' => 9,
            '游戏' => 10,
            '汽车后市场' => 11,
            '企业级服务' => 12,
            '数据服务' => 13,
            '其他' => 14
        ];
        // 投资轮次置换数组
        $swetchArr2 = [
            '种子轮' => 1,
            '天使轮' => 2,
            'Pre-A轮' => 3,
            'A轮' => 4,
            'B轮' => 5,
            'C轮' => 6,
            'D轮'=> 7,
            'E轮' => 8,
            'F轮已上市' => 9,
            '其他' => 10
        ];

        $data['industry'] = $swetchArr1[$data['industry']];
        $data['financing_stage'] = $swetchArr2[$data['financing_stage']];
        $data['content'] = $data['brief_content'];
        $data['content'] = $data['brief_content'];
        $data['banner_img'] = $data['logo_img'];

        return $this->addProjects($data);

    }
}