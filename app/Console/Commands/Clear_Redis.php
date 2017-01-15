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
    protected $signature = 'Clear_Redis {--u} {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '一键清空缓存 eg: php artisan Clear_Redis --u guoqing';
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
        $password = $this->secret('请输入密码：');

        if (!($this->argument('user') == env('ROOT_USERNAME') && $password == env('ROOT_PASSWORD'))){
            $this->error('用户名或密码有误！');
            return ;
        }

        if ($this->confirm('确定要清空缓存吗，此操作将无法恢复? [y|N]')) {
            if (self::$masterCache->destroy()){
                $this->info('清空redis成功!');
            }else{
                $this->error('清空redis失败');
            }
        }else{
            $this->info('取消成功！');
        }


    }
}
