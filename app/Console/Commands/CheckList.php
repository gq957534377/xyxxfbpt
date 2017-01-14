<?php

namespace App\Console\Commands;

use App\Redis\ActionCache;
use App\Redis\ArticleCache;
use App\Redis\CollegeCache;
use App\Redis\PictureCache;
use App\Redis\ProjectCache;
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
        PictureCache $pictureCache
    )
    {
        parent::__construct();
        self::$actionCache = $actionCache;
        self::$collegeCache = $collegeCache;
        self::$articleCache = $articleCache;
        self::$projectCache = $projectCache;
        self::$pictureCache = $pictureCache;
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
    }
}
