<?php
/**
 * Created by PhpStorm.
 * User: 王拓
 * Date: 2016/11/11
 * Time: 9:08
 */

namespace App\Services;

use App\Tools\Common;
use App\Store\TrainingStore;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TrainingService
{
    protected static $trainingStore = null;

    /**
     * TrainingService constructor.
     * @param TrainingStore $trainingStore
     * @author 王拓
     */
    public function __construct(TrainingStore $trainingStore)
    {
        self::$trainingStore = $trainingStore;
    }

    /**
     * 查询一条培训信息
     * @param $where
     * @return array
     * @author 王拓
     */
    public function getOneTraining($where)
    {
        $info = self::$trainingStore->getOneData($where);
        if ($info) return ['status' => true, 'msg' => $info];
        Log::error('技术培训内容获取失败', $info);
        return ['status' => false, 'msg' => '技术培训内容活动失败'];
    }

    /**
     * 获取用培训信息分页后的数据
     * @param $nowPage
     * @return array
     * @author 王拓
     */
    public function getTrainingList($nowPage)
    {
        if (empty($nowPage)) return ['status' => false, 'msg' => '没有此页'];
        $info = self::$trainingStore->getPageData($nowPage);
        if (!$info) return ['status' => false, 'msg' => '数据获取失败'];
        return ['status' => true, 'msg' => $info];
    }

    public function getAllData()
    {
        $info = self::$trainingStore->getAllData();
        if (!$info) {
            // 用户订单为空
            if ([] == $info) return ['status' => true, 'msg' => $info];
            // 获取失败
            Log::error('技术培训内容获取失败', $info);
            return ['status' => false, 'msg' => '技术培训内容活动失败'];
        }
        // 获取成功且用户订单不为空
        return ['status' => true, 'msg' => $info];
    }

    /**
     * 添加技术培训
     * @param $request
     * @return array
     * @author 王拓
     */
    public function addTraining($request)
    {
        $data = $request->all();
        $current_time = time();//当前时间戳
        $start_time = strtotime($data['start_time']);
        $stop_time = strtotime($data['stop_time']);
        $deadline = strtotime($data['deadline']);
        //检测培训时间是否合法
        if ($deadline >= $start_time || $deadline >= $stop_time) {
            return ['status' => false,'msg' => '报名截止时间不合法(报名截止时间不能先于培训开始时间或培训结束时间！)'];
        }elseif ($start_time >= $stop_time){
            return ['status' => false,'msg' => '培训开始时间不合法(培训开始时间不能先于培训结束时间！)'];
        }
        //判断培训状态
        switch ($current_time) {
            case $current_time < $deadline:
                //0 表示培训正在报名中
                $data['status'] = 0;
                break;
            case $current_time >= $deadline && $current_time < $start_time:
                //1 表示培训报名截止，处于活动准备阶段
                $data['status'] = 1;
                break;
            case $current_time >= $start_time && $current_time < $stop_time:
                //2 表示培训开始
                $data['status'] = 2;
                break;
            case $current_time >= $current_time:
                //3 表示活动结束，已过期
                $data['status'] = 3;
                break;
        }
        // 服务器端数据设置
        $data['training_guid'] = Common::getUuid();
        $data['start_time'] = strtotime($data['start_time']);
        $data['stop_time'] = strtotime($data['stop_time']);
        $data['deadline'] = strtotime($data['deadline']);
        $result = self::$trainingStore->addData($data);
        if (!$result) return ['status' => false, 'msg' => '发布培训失败'];
        return ['status' => true, 'msg' => "发布成功"];
    }

    /**
     * 修改培训状态
     * @param $id
     * @return bool
     * @author 王拓
     */
    public function changeStatus($id)
    {
        $where = ['training_guid' => $id];
        $data = ['status' => 1];
        return self::$trainingStore->updateData($where, $data);
    }

    /**
     * 修改活动状态
     * @param $data
     * @return array
     * @author 王拓
     */
    public static function updateTrainingStatus($data)
    {
        $status = isset($data['status']) ? $data['status'] : 0;
        $guid = isset($data['name']) ? $data['name'] : '';
        if (empty($guid) && !in_array($status, [1, 3])) return ['status' => false, 'msg' => '数据异常'];
        switch ($status) {
            case 1:
                $status = 3;
                break;
            case 2:
                $status = 3;
                break;
            case 3:
                $status = 1;
                break;
            default:
                break;
        }
        $result = self::$trainingStore->updateData(['training_guid' => training_guid], ['status' => $status]);
        if (empty($result)) return ['status' => false, 'msg' => '数据修改失败'];
        return ['status' => true, 'msg' => $result];
    }
}