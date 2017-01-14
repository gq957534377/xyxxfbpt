<?php

namespace App\Console\Commands;

use App\Redis\ActionCache;
use App\Redis\CollegeCache;
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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ActionCache $actionCache, CollegeCache $collegeCache)
    {
        parent::__construct();
        self::$actionCache = $actionCache;
        self::$collegeCache = $collegeCache;
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
    }
}
