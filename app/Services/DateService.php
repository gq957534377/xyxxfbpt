<?php
/*后台用户管理service*/
namespace App\Services;

use App\Store\UserStore;
use App\Store\ApplySybStore;
use App\Store\ApplyInvestorStore;
use App\Store\ApplyMemberStore;
use App\Store\HomeStore;
use App\Store\CompanyStore;

use App\Tools\CustomPage;
use DB;

class DateService
{

    /**
     *  获取本月第一天和最后一天
     * @param $date
     * @return array
     * @author 崔小龙
     */
    public  function getMonth($date)
    {
        if(!is_int($date)){
            return ["status"=>false,"msg"=>"参数错误"];
        }
        $firstDay = 1;
        $firstTime = mktime(0,0,0,$date,$firstDay,date("Y"));
        $nextMonthFirstTime=mktime(0,0,0,$date+1,$firstDay,date("Y"));
        $lastDay = ($nextMonthFirstTime-$firstTime)/(24*3600);
        $lastTime = mktime(23,59,59,$date,$lastDay,date("Y"));
        return ["startTime"=>$firstTime-1,"endTime"=>$lastTime];
    }


    /**
     *  获取上个月第一天和最后一天
     * @param $date
     * @return array
     */
    public  function getlastMonthDays($date)
    {
        $timestamp=strtotime($date);
        $firstday=date('Y-m-01',strtotime(date('Y',$timestamp).'-'.(date('m',$timestamp)-1).'-01'));
        $lastday=date('Y-m-d',strtotime("$firstday +1 month -1 day"));
        return array($firstday,$lastday);
    }


    /**
     *  获取下个月第一天和最后一天
     * @param $date
     * @return array
     */
    public  function getNextMonthDays($date)
    {
        $timestamp=strtotime($date);
        $arr=getdate($timestamp);
        if($arr['mon'] == 12){
            $year=$arr['year'] +1;
            $month=$arr['mon'] -11;
            $firstday=$year.'-0'.$month.'-01';
            $lastday=date('Y-m-d',strtotime("$firstday +1 month -1 day"));
        }else{
            $firstday=date('Y-m-01',strtotime(date('Y',$timestamp).'-'.(date('m',$timestamp)+1).'-01'));
            $lastday=date('Y-m-d',strtotime("$firstday +1 month -1 day"));
        }
        return array($firstday,$lastday);
    }
    /**
     *  获取本周第$date天起点与终点时间戳
     * @param int $date
     * @return array
     * @author 张洵之
     */
    public function getWeek($date)
    {
        if(!is_int($date)){
            return ["status"=>false,"msg"=>"参数错误"];
        }
        $dayTime = 3600*24;//一天的秒数
        $temp = ($date-1)*$dayTime;
        //mktime(hour,minute,second,month,day,year,is_dst);
        //date(format,timestamp)
        $weekFirstTime = mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"));//本周周一的零点时间戳
        return ["startTime"=>$weekFirstTime+$temp,"endTime"=>$weekFirstTime+$temp+$dayTime-1];
    }
    /**
     *  获取本月第$date天起点与终点时间戳
     * @param int $date
     * @return array
     * @author 张洵之
     */
    public function getMonthSomeoneDay($date)
    {
        if(!is_int($date)){
            return ["status"=>false,"msg"=>"参数错误"];
        }
        $dayTime = 3600*24;//一天的秒数
        $MonthSomeTime=mktime(0,0,0,date("m"),$date,date("Y"));//本月某天的零点时间戳
        return ["startTime"=>$MonthSomeTime,"endTime"=>$MonthSomeTime+$dayTime-1];
    }

    /**
     * 获取当天0点时间戳
     * @param $time
     * @return array|int
     * @author 郭鹏超
     */
    public function getZeroTimeStamp($time)
    {
        if(empty($time)) return ['status' => false, 'msg' => '没有时间戳'];

        $time = mktime(0,0,0,date("m", $time),date("d", $time),date("Y", $time));
        return ['status' => true, 'msg' => $time];
    }


}