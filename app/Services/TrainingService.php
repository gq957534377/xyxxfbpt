<?php
/**
 * Created by PhpStorm.
 * User: 王拓
 * Date: 2016/11/11
 * Time: 9:08
 */

namespace App\Services;

use App\Tools\Common;
use Illuminate\Support\Facades\Log;
use App\Store\TrainingStore;

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

    public function addTraining($data)
    {
        //纯净数据
        unset($data['_token']);
        //写入数据
        $data['training_guid'] = Common::getUuid();
        $data['start_time'] = strtotime($data['start_time']);
        $data['stop_time'] = strtotime($data['stop_time']);
        $data['deadline'] = strtotime($data['deadline']);
//        dd($data);
        $info = self::$trainingStore->addData($data);
        //写入失败
        if (!$info) return 'error';
        //写入成功
        return 'yes';
    }

    public function changeStatus($id)
    {
        $where = ['training_guid' => $id];
        $data = ['status' => 1];
        return self::$trainingStore->updateData($where, $data);
    }

    public function getAllTraining()
    {
        $data = self::$trainingStore->getAllData();
        if ($data) {
            //用户订单为空
            if ([] == $data) return ['status' => 200, 'msg' => $data];
            //获取失败
            Log::error('创业项目培训内容获取失败', $data);
            return ['status' => '500', 'msg' => $data];
        }
        //获取成功
        return ['status' => 200, 'msg' => $data];
    }

    /**
     * @param $where
     * @return array
     */
    public function getOneTraining($where)
    {
        $data = self::$trainingStore->getOneData($where);
        if (!$data) {
            //获取失败
//            Log::errer('培训内容获取失败', $data);
            return ['status' => 500, 'msg' => '培训内容获取失败'];
        }
        //获取成功
        return ['status' => 200, 'msg' => $data];
    }
}