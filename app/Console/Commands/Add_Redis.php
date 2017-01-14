<?php

namespace App\Console\Commands;

use App\Redis\ActionCache;
use App\Redis\CollegeCache;
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
        self::$actionCache->reloadCache();
        self::$collegeCache->reloadCache();
    }
}
