<?php
/**
 * Created by PhpStorm.
 * User: wangt
 * Date: 2016/12/7
 * Time: 15:05
 */

namespace App\Services;

use App\Store\PictureStore;
use App\Tools\Avatar;

class PictureService
{
    protected static $picturestore;
    protected static $avatar;
    /** 单例引入
     *
     * @param WebAdminService $webAdminService
     * @author 王通
     */
    public function __construct(PictureStore $picturestore)
    {
        self::$picturestore = $picturestore;
    }
    /**
     * 保存轮播图
     * @param $arr
     * @return array
     * @author 王通
     */
    public function saveCarousel ($data)
    {
        $res = Avatar::carousel($data);
        if ($res['status'] == '200') {

        }
        return [];
    }
}