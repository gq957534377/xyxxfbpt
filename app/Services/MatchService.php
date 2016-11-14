<?php
/**
 * Match 后台业务服务层
 * User: maolin
 * Date: 2016/11/8
 * Time: 22:22
 */
namespace App\Services;

use App\Store\MatchStore;
use App\Tools\Common;
use Illuminate\Support\Facades\Session;

class MatchService
{
    protected static $matchStore = null;

    public function __construct(MatchStore $matchStore)
    {
        self::$matchStore = $matchStore;
    }
    /**
     * 查询项目大赛向前台
     * @return array
     * @author 茂林
     */
     public function getAll()
     {
        //
        $info = self::$matchStore->getAllData();
     }
    /**
     * 插入数据
     * @param array
     * @return bool
     * @author maolin
     */
     public function insert($array)
     {
        //
         $start_time = $array['start_time'];
         $end_time   = $array['end_time'];
         $deadline   = $array['deadline'];
         $array['start_time'] = strtotime($start_time);
         $array['end_time']   = strtotime($end_time);
         $array['deadline']   = strtotime($deadline);
         // Insert the time
         $array['ist_time']   = time();
         // Update time
         $array['up_time']   = time();
         $array['guid'] = Common::getUuid();

         $state = self::$matchStore->addData($array);
         // Return status
         if($state==0) return ['status'=> true,'msg'=>'插入失败'];
         return ['status'=> false,'msg'=>'插入成功'];
     }
    /**
     * @param string
     * @return bool
     * @author maolin
     */
     public function deleteOne($id)
     {
         return $id;
         $state = self::$matchStore->deleteOne($id);
         if($state==0) return ['status'=> true,'msg'=>'删除失败'];
         return ['status'=> false,'msg'=>'删除成功'];
     }

    /**
     * @param $id
     * @return bool
     * 放弃使用
     */
     public function getOntData($id)
     {
         $result = self::$matchStore->getOntData($id);
         $result->start_time = date('Y-m-d\TH:i:s', $result->start_time);
         $result->end_time = date('Y-m-d\TH:i:s', $result->end_time);
         $result->deadline = date('Y-m-d\TH:i:s', $result->deadline);
         return $result;
     }

    /**
     * @param $where
     * @return mixed
     * @author maolin
     *
     */
    public function getPageData($where)
    {
        //
        $result = self::$matchStore->getPageData($where);
        return $result;
    }
}
