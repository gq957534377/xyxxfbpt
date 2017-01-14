<?php

namespace App\Console\Commands;

use App\Redis\MasterCache;
use Illuminate\Console\Command;

class Clear_Redis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Clear_Redis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '一键清空缓存';
    protected static $masterCache;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MasterCache $masterCache)
    {
        parent::__construct();
        self::$masterCache = $masterCache;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        self::$masterCache->destroy();
    }
}
