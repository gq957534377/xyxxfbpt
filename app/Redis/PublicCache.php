<?php
/**
 * Created by PhpStorm.
 * User: 郭庆
 * Date: 2017/01/11
 * Time: 15:51
 * @author:郭庆
 */
namespace App\Redis;

use Illuminate\Support\Facades\Redis;

class PublicCache
{
    /**
     * 判断listkey或者hashkey是否存在
     * @param $list bool list为真查询listkey,否则查询hashkey
     * @param $index string   唯一识别码 guid
     * @return bool
     */
    public function exists($index, $list=true)
    {
        if($list){
            return Redis::exists(self::$lkey.$index);  //查询listkey是否存在
        }else{
            return Redis::exists(self::$hkey.$index);   //查询拼接guid对应的hashkey是否存在
        }
    }

}