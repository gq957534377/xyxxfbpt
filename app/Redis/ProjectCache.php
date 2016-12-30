<?php
/**
<<<<<<< HEAD
 * Project redis 缓存仓库
 * @author 张洵之
=======
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/29
 * Time: 17:02
>>>>>>> origin/wangtong
 */

namespace App\Redis;


use Illuminate\Support\Facades\Redis;
class ProjectCache
{
    private static $lkey = LIST_PROJECT_INFO;      //项目list表key
    private static $hkey = HASH_PROJECT_INFO_;     //项目hash表key

}