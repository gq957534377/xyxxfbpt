<?php
/**
 * Created by PhpStorm.
 * User: 郭庆
 * Date: 2017-04-22
 * Time: 11:58
 */

namespace App\Services;

use App\Store\GoodsStore;
use App\Tools\CustomPage;

class GoodsService
{
    protected static $goodsStore;
    public function __construct(GoodsStore $goodsStore)
    {
        self::$goodsStore = $goodsStore;
    }

    /**
     * 说明: 获取分页数据
     *
     * @param $where
     * @param $nowPage
     * @param $forPages
     * @param $url
     * @return array
     * @author 郭庆
     */
    public function selectData($where, $nowPage, $forPages, $url)
    {
        //获取符合条件的数据的总量
        $count = self::$goodsStore->getCount($where);
        if (!$count) return ['StatusCode' => '204', 'ResultData' => "暂无二手商品"];

        //获取对应页的数据
        $result['data'] = self::$goodsStore->forPage($nowPage, $forPages, $where);

        //计算总页数
        $totalPage = ceil($count / $forPages);

        if ($result['data']) {
            if ($totalPage > 1) {
                //创建分页样式
                $creatPage = CustomPage::getSelfPageView($nowPage, $totalPage, $url, null);

                if ($creatPage) {
                    $result["pages"] = $creatPage;
                } else {
                    return ['StatusCode' => '500', 'ResultData' => '生成分页样式发生错误'];
                }

            } else {
                $result['totalPage'] = $totalPage;
                $result["pages"] = '';
            }
            return ['StatusCode' => '200', 'ResultData' => $result];
        } else {
            return ['StatusCode' => '500', 'ResultData' => '获取分页数据失败！'];
        }
    }
}