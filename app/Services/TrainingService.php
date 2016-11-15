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
        if(!$info) {
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
//        $date=strtotime($data['start_time']);
//        if($date < time()) return ['status' => false,'msg' => '培训发布时间不合法'];
//        $date=strtotime($data['stop_time']);
//        if($date < time()) return ['status' => false,'msg' => '培训结束时间不合法'];
//        $date=strtotime($data['deadline']);
//        if($date < time()) return ['status' => false,'msg' => '报名截止时间不合法'];
        // 服务器端数据设置
        $data['training_guid']   = Common::getUuid();
        $data['start_time'] = strtotime($data['start_time']);
        $data['stop_time'] = strtotime($data['stop_time']);
        $data['deadline'] = strtotime($data['deadline']);
        $result = self::$trainingStore->addData($data);
        if (!$result) return ['status' => false, 'msg' => '发布培训失败'];
        return ['status'=>true,'msg'=>"发布成功"];
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