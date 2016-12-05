<?php
/**
 * Created by PhpStorm.
 * User: wangt
 * Date: 2016/12/5
 * Time: 16:57
 */

namespace App\Services;

use App\Store\WebAdminStore;

class WebAdminService
{
    protected static $webAdminStore;
    function __construct(WebAdminStore $webAdminStore)
    {
        self::$webAdminStore = $webAdminStore;
    }

    /**
     * 管理页面文字信息
     * @param $data
     * @return array
     * @autnor 王通
     */
    public function saveWebText($data)
    {
        self::$webAdminStore->saveWebAdmin($data);
        return [];
    }
}