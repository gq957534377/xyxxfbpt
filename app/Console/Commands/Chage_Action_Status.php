<?php

namespace App\Console\Commands;

use Log;
use App\Services\ActionService;
use Illuminate\Console\Command;

class Chage_Action_Status extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chageAction:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '任务调度（01：00）根据活动开始，结束，截至报名时间进行修改活动状态（php artisan chageAction:status）';

    /**
     * @var 活动服务
     */
    protected static $actionServer;

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct(ActionService $actionServer)
    {
        parent::__construct();
        self::$actionServer = $actionServer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info('--------------------------------修改活动状态任务调度开始----------------------------------');
        $this->chageActionStatus();
        $this->chageCollegeStatus();
        \Log::info('--------------------------------修改活动状态list任务调度结束----------------------------------');
    }

    /**
     * 任务调度 更改活动状态
     * @param
     * @return array
     * @author 郭庆
     */
    public static function chageActionStatus()
    {
        $result = self::$actionServer->getAllAction();
        if ($result["status"]) {
            foreach ($result['msg'] as $v) {
                $status = self::$actionServer->setStatusByTime($v);
                if ($status['status'] && !is_string($status['msg'])) {
                    $chage = self::$actionServer->changeStatus($v->guid, $status['msg'], 1);
                    if ($chage['StatusCode'] != '200') {
                        Log::error("任务调度请求更改活动状态失败" . $v->guid . ':' . $chage['ResultData']);
                    } else {
                        Log::info("任务调度请求更改\"" . $v->guid . "\"活动状态成功!" . ':' . $chage['ResultData']);
                    }
                }
            }
        } else {
            \Log::info("任务调度更改活动状态——获取活动列表失败" . ':' . $result['msg']);
        }
    }

    /**
     * 任务调度 更改学院活动状态
     * @param
     * @return array
     * @author 郭庆
     */
    public static function chageCollegeStatus()
    {
        $result = self::$actionServer->getAllAction();
        if ($result["status"]) {
            foreach ($result['msg'] as $v) {
                $status = self::$actionServer->setStatusByTime($v);
                if ($status['status'] && !is_string($status['msg'])) {
                    $chage = self::$actionServer->changeStatus($v->guid, $status['msg'], 3);
                    if ($chage['StatusCode'] != '200') {
                        Log::error("任务调度请求更改学院活动状态失败" . $v->guid . ':' . $chage['ResultData']);
                    } else {
                        Log::info("任务调度请求更改\"" . $v->guid . "\"学院活动状态成功!" . ':' . $chage['ResultData']);
                    }
                }
            }
        } else {
            \Log::info("任务调度更改学院活动状态——获取学院活动列表失败" . ':' . $result['msg']);
        }
    }
}
