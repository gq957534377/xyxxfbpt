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
    protected $signature = 'Add_Redis {--u} {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '一键加缓存 eg:php artisan Add_Redis --u guoqing';
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
        $password = $this->secret('请输入密码：');

        if (!($this->argument('user') == env('ROOT_USERNAME') && $password == env('ROOT_PASSWORD'))){
            $this->error('用户名或密码有误！');
            return ;
        }

        if ($this->confirm('确定执行一键加缓存吗? [y|N]')) {

            $this->line('添加活动缓存中....');
            self::$actionCache->reloadCache();
            $this->info('活动添加成功!');

            $this->line('添加学院缓存中....');
            self::$collegeCache->reloadCache();
            $this->info('学院活动添加成功!');

            $this->line('添加项目缓存中....');
            self::$projectCache->getPageData(1, 8, ['status' => 1]);
            $this->info('默认项目添加成功!');

            $this->line('添加十种项目类型缓存中....');
            self::$projectCache->getPageData(1, 8, ['status' => 1, 'financing_stage' => 1]);
            self::$projectCache->getPageData(1, 8, ['status' => 1, 'financing_stage' => 2]);
            self::$projectCache->getPageData(1, 8, ['status' => 1, 'financing_stage' => 3]);
            self::$projectCache->getPageData(1, 8, ['status' => 1, 'financing_stage' => 4]);
            self::$projectCache->getPageData(1, 8, ['status' => 1, 'financing_stage' => 5]);
            self::$projectCache->getPageData(1, 8, ['status' => 1, 'financing_stage' => 6]);
            self::$projectCache->getPageData(1, 8, ['status' => 1, 'financing_stage' => 7]);
            self::$projectCache->getPageData(1, 8, ['status' => 1, 'financing_stage' => 8]);
            self::$projectCache->getPageData(1, 8, ['status' => 1, 'financing_stage' => 9]);
            self::$projectCache->getPageData(1, 8, ['status' => 1, 'financing_stage' => 10]);
            $this->info('十种项目类型添加成功!');

            $this->line('添加机构缓存中....');
            self::$pictureService->getPictureIn([3, 5]);
            $this->info('添加机构缓存成功！');

            $this->line('添加首页轮播图缓存中....');
            self::$pictureService->getRollingPicture();
            $this->line('添加首页轮播图缓存成功！');

            $this->line('添加网站底部信息缓存中....');
            self::$webAdminService->getWebInfo();
            $this->line('添加网站底部信息缓存成功！');

            $this->line('添加创业政策文章缓存中....');
            self::$articleService->getTakeArticles(1);
            $this->line('添加创业政策文章缓存成功！');

            $this->line('添加市场资讯文章缓存中....');
            self::$articleService->getTakeArticles(2);
            $this->line('添加市场资讯文章缓存成功！');

            $this->info('一键缓存成功！');
        }else{
            $this->info('取消成功！');
        }
    }
}
