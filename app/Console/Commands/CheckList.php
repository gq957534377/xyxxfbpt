<?php

namespace App\Console\Commands;

use App\Redis\ActionCache;
use App\Redis\ArticleCache;
use App\Redis\CollegeCache;
use App\Redis\PictureCache;
use App\Redis\ProjectCache;
use App\Redis\RollingPictureCache;
use App\Redis\WebAdminCache;
use Illuminate\Console\Command;

class CheckList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CheckList';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检测list是否与数据库一致';
    protected static $actionCache;
    protected static $collegeCache;
    protected static $articleCache;
    protected static $projectCache;
    protected static $pictureCache;
    protected static $rollingPictureCache;
    protected static $webAdminCache;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        ActionCache $actionCache,
        CollegeCache $collegeCache,
        ArticleCache $articleCache,
        ProjectCache $projectCache,
        PictureCache $pictureCache,
        RollingPictureCache $rollingPictureCache,
        WebAdminCache $webAdminCache
    )
    {
        parent::__construct();
        self::$actionCache = $actionCache;
        self::$collegeCache = $collegeCache;
        self::$articleCache = $articleCache;
        self::$projectCache = $projectCache;
        self::$pictureCache = $pictureCache;
        self::$rollingPictureCache = $rollingPictureCache;
        self::$webAdminCache = $webAdminCache;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //检测活动list是否正常
        self::$actionCache->check();
        //检测学院活动list是否正常
        self::$collegeCache->check();
        //文章list检查
        self::$articleCache->check();
        //项目list检查
        self::$projectCache->check();
        //机构list检查
        self::$pictureCache->check();
        //检查首页轮播图list
        self::$rollingPictureCache->check();
        //检查网站底部配置信息list
        self::$webAdminCache->check();
    }
}
