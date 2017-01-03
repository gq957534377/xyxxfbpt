<?php
/**
 * Project redis 缓存仓库
 * @author 张洵之
 */

namespace App\Redis;


use Illuminate\Support\Facades\Redis;
class ProjectCache
{
    private static $lkey = LIST_PROJECT_INFO;      //项目list表key
    private static $hkey = HASH_PROJECT_INFO_;     //项目hash表key

}