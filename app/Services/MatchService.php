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
     * @author maolin
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
        // 插入时间
        $array['ist_time']   = time();
        // 更新时间
        $array['up_time']   = time();
        $array['guid'] = Common::getUuid();
        $state = self::$matchStore->addData($array);
        // 返回bool
        switch ($state) {
            case !0:
                return 1;
            default:
                return 0;
        }
        return $state;
     }
    /**
     * @param string
     * @return bool
     * @author maolin
     */
     public function deleteOne($id)
     {
         $state = self::$matchStore->deleteOne($id);
         switch ($state) {
             case !0:
                 return 1;
             default:
                 return 0;
         }
     }

     public function getOntData($id)
     {
         $result = self::$matchStore->getOntData($id);
         $result->start_time = date("Y-m-d\TH:i:s", $result->start_time);
         $result->end_time = date('Y-m-d\TH:i:s', $result->end_time);
         $result->deadline = date('Y-m-d\TH:i:s', $result->deadline);
         return $result;
     }
}
