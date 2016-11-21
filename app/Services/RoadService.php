<?php
/**
 * road 后台业务服务层
 * User: 郭庆
 * Date: 2016/11/08
 * Time: 16：34
 */
namespace App\Services;

use App\Store\roadStore;
use App\Tools\Common;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class RoadService {
    protected static $roadStore = null;

    public function __construct(RoadStore $roadStore)
    {
        self::$roadStore = $roadStore;
    }
    /**
     * 查询一条路演信息
     * @return array    路演管理信息
     * @author 郭庆
     */
    public function getOneRoad($where)
    {
        $info = self::$roadStore->getOneData($where);
        if($info) return ['status' => true, 'msg' => $info];
            Log::error('路演活动获取失败', $info);
            return ['status' => false, 'msg' => '获取路演活动失败'];
    }

    /**获取指定页的数据
     * @return 某一页的数据|null
     * @author 郭庆
     */
    public static function getRoadList($nowPage,$type)
    {
        if(empty($nowPage)) return ['status'=>false,'msg'=>'没有此页'];
        $info = self::$roadStore->getPageData($nowPage,['status'=>$type]);
        if(!$info)return ['status'=>false,'msg'=>'数据获取失败'];
        return ['status'=>true,'msg'=>$info];
    }

    /**
     * 获取最新的路演活动信息
     * @return roadStore|null
     * author 郭庆
     */
    public static function getNewRoad()
    {
        $where = ['status'=>1];
        $info  =  self::$roadStore->getSomeData($where);
        if(!$info)return ['status'=>false,'msg'=>'数据获取失败'];
        return ['status'=>true,'msg'=>$info];
    }

    /**
     * 获取过期/禁用的路演活动
     * @return \Illuminate\Http\Response
     * @author 郭庆
     */
    public static function getHistoryRoad()
    {
        $where = ['status'=>3];
        return self::$roadStore->getSomeData($where);
    }

    /**
     * 查询路演信息进行显示, 当用户登陆后, 请求路演管理页面时
     * @return array    路演管理信息
     * @author 郭庆
     */
    public function getAllroad()
    {
        $info = self::$roadStore->getAllData();
        if(!$info) {
            // 路演活动为空
            if ([] == $info) return ['status' => true, 'msg' => $info];
            // 获取失败
            Log::error('路演活动获取失败', $info);
            return ['status' => false, 'msg' => '获取路演活动失败'];
        }
        // 获取成功且路演活动不为空
        return ['status' => true, 'msg' => $info];
    }
    /**修改路演信息+后端验证
     * @data @where
     * @return true | false
     * @author 郭庆
     */
    public static function updateRoad($data,$where)
    {
        $date=strtotime($data['start_time']);
        if($date < time()) return ['status' => false,'msg' => '路演开始时间不能为当前时间之前'];
        // 服务器端数据设置
        $data['start_time'] = $date;
        $data['time']       = time();
        return self::$roadStore->updateData($where,$data);
    }

    /**修改路演活动状态
     * @request $request
     * @return true | false
     * @author 郭庆
     */
    public static function updateRoadStatus($data)
    {
        $status = isset($data['status']) ? $data['status'] : 0;
        $guid = isset($data['name']) ? $data['name'] : '';
        if (empty($guid) && !in_array($status, [1, 3])) return ['status' => false, 'msg' => '数据来源异常'];
        switch ($status)
        {
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
        $result = self::$roadStore->updateData(['roadShow_id' => $guid], ['status' => $status]);
        if (empty($result))return ['status' => false, 'msg' => '数据修改失败'];
        return ['status' => true, 'msg' => $result];
    }

    /**发布路演+后端验证
     * @request $request
     * @return true | false
     * @author 郭庆
     */
    public function CheckAddRoad($request)
    {
        $data = $request->all();
        $date=strtotime($data['start_time']);
        if($date < time()) return ['status' => false,'msg' => '路演开始时间不能为当前时间之前'];
        // 服务器端数据设置
        $data['start_time'] = $date;
        $data['roadShow_id']   = Common::getUuid();
        $data['time']          = time();
        $result = self::$roadStore->addData($data);
        if (!$result) return ['status' => false, 'msg' => '发布路演失败'];
        return ['status'=>true,'msg'=>$result];
    }
}