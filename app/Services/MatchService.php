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
     * @param $array
     * @return array
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
         $result = self::$matchStore->deleteOne($id);
         if($result==0) return ['status'=> true,'msg'=>'删除失败'];
         return ['status'=> false,'msg'=>'删除成功'];
     }

    /**
     * 获取修改数据
     * @param $id
     * @return array|bool
     * @author maolin
     */
     public function getOntData($id)
     {
         $result = self::$matchStore->getOntData($id);
         if($result==0) return ['status'=> true,'msg'=>'删除失败'];
         // return $result;
         $result[0]->start_time = date('Y-m-d\TH:i:s', $result[0]->start_time);
         $result[0]->end_time = date('Y-m-d\TH:i:s', $result[0]->end_time);
         $result[0]->deadline = date('Y-m-d\TH:i:s', $result[0]->deadline);
         $result[0]->up_time = date('Y-m-d\TH:i:s', $result[0]->up_time);
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

    /**
     * 更新数据
     * @param $id
     * @param $data
     * @return array
     */
    public function updateData($id,$array)
    {
        // Update time
        $array['up_time']   = time();
        $result = self::$matchStore->updateData($id,$array);

        if($result==0) return ['status'=> true,'msg'=>'修改失败'];
        return ['status'=> false,'msg'=>'修改成功'];
    }
}
