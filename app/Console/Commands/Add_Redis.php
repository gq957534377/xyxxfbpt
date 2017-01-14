<?php

namespace App\Console\Commands;

use App\Redis\ActionCache;
use App\Redis\CollegeCache;
use App\Services\ArticleService;
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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ActionCache $actionCache, CollegeCache $collegeCache, ArticleService $articleService)
    {
        parent::__construct();
        self::$actionCache = $actionCache;
        self::$collegeCache = $collegeCache;
        self::$articleService = $articleService;
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
//        self::$articleService->selectArticle(['type'=>1, 'status'=>1], 1, 5, '', false);
//        self::$articleService->selectArticle(['type'=>2, 'status'=>1], 1, 5, '', false);

    }
}
