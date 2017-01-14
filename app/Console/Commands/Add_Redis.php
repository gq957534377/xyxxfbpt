<?php

namespace App\Console\Commands;

use App\Redis\ActionCache;
use App\Redis\CollegeCache;
use App\Redis\ProjectCache;
use App\Services\ArticleService;
use App\Services\PictureService;
use App\Services\WebAdminService;
use Illuminate\Console\Command;

class Add_Redis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Add_Redis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '一键加缓存';
    protected static $actionCache;
    protected static $collegeCache;
    protected static $articleService;
    protected static $projectCache;
    protected static $pictureService;
    protected static $webAdminService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        ActionCache $actionCache,
        CollegeCache $collegeCache,
        ArticleService $articleService,
        ProjectCache $projectCache,
        PictureService $pictureService,
        WebAdminService $webAdminService
    )
    {
        parent::__construct();
        self::$actionCache = $actionCache;
        self::$collegeCache = $collegeCache;
        self::$articleService = $articleService;
        self::$projectCache = $projectCache;
        self::$pictureService = $pictureService;
        self::$webAdminService = $webAdminService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        self::$actionCache->reloadCache();
        self::$collegeCache->reloadCache();
        self::$projectCache->getPageData(1, 8, ['status'=>1]);
        self::$projectCache->getPageData(1, 8, ['status'=>1, 'financing_stage'=>1]);
        self::$projectCache->getPageData(1, 8, ['status'=>1, 'financing_stage'=>2]);
        self::$projectCache->getPageData(1, 8, ['status'=>1, 'financing_stage'=>3]);
        self::$projectCache->getPageData(1, 8, ['status'=>1, 'financing_stage'=>4]);
        self::$projectCache->getPageData(1, 8, ['status'=>1, 'financing_stage'=>5]);
        self::$projectCache->getPageData(1, 8, ['status'=>1, 'financing_stage'=>6]);
        self::$projectCache->getPageData(1, 8, ['status'=>1, 'financing_stage'=>7]);
        self::$projectCache->getPageData(1, 8, ['status'=>1, 'financing_stage'=>8]);
        self::$projectCache->getPageData(1, 8, ['status'=>1, 'financing_stage'=>9]);
        self::$projectCache->getPageData(1, 8, ['status'=>1, 'financing_stage'=>10]);
        self::$pictureService->getPictureIn ([3, 5]);
        self::$pictureService->getRollingPicture();
        self::$webAdminService->getWebInfo ();
//        self::$articleService->selectArticle(['type'=>1, 'status'=>1], 1, 5, '', false);
//        self::$articleService->selectArticle(['type'=>2, 'status'=>1], 1, 5, '', false);

    }
}
