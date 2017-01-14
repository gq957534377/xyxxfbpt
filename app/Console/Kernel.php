<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
        '\App\Console\Commands\Chage_Action_Status',//根据活动开始，结束，截至报名时间进行修改活动状态（php artisan chageAction:status 用户名 密码）
        '\App\Console\Commands\Save_Feedback',
        '\App\Console\Commands\Clear_Redis',//一键清缓存
        '\App\Console\Commands\Add_Redis',//一键加缓存
        '\App\Console\Commands\CheckList',//一键加缓存
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
        //活动状态更新每天一点凌晨
        $schedule->command('chageAction:status')->dailyAt('1:00');
        //检查list
        $schedule->command('CheckList')->everyMinute();

        $schedule->command('save:feedback')->dailyAt('23:00');
    }
}
