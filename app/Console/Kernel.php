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
        '\App\Console\Commands\Chage_Action_Status',
        '\App\Console\Commands\Save_Feedback',
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
        $schedule->command('chageAction:status')->everyMinute();


        $schedule->command('save:feedback')->dailyAt('23:00');;
    }
}
