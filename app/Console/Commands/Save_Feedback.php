<?php

namespace App\Console\Commands;

use Faker\Provider\Uuid;
use Illuminate\Console\Command;
use App\Services\SafetyService;
use App\Redis\MasterCache;
use App\Redis\BaseRedis;

class Save_Feedback extends Command
{
    protected static $safetyService = null;
    protected static $masterCache;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save:feedback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SafetyService $safetyService, MasterCache $masterCache)
    {
        parent::__construct();
        self::$masterCache = $masterCache;
        self::$safetyService = $safetyService;
    }

    /**
     * 定时任务，每天凌晨把意见写入数据库
     *
     * @return mixed
     * @author 杨志宇
     */
    public function handle()
    {
        $count = self::$safetyService->getString(STRING_FEEDBACK_COUNT_ . date('Y-m-d', time()));
        self::$masterCache->setTime(STRING_FEEDBACK_COUNT_ . date("Y-m-d",strtotime("-1 day")), REDIS_FEEDBACK_LIFE_TIME);
        self::$masterCache->setTime(LIST_FEED_BACK_INDEX_ . date("Y-m-d",strtotime("-1 day")), REDIS_FEEDBACK_LIFE_TIME);
        self::$masterCache->setTime(HASH_FEED_BACK_ . date("Y-m-d",strtotime("-1 day")), REDIS_FEEDBACK_LIFE_TIME);
        self::$masterCache->setTime(SET_FEEDBACK_IP_ . date("Y-m-d",strtotime("-1 day")), REDIS_FEEDBACK_LIFE_TIME);
        // 判断总记录数有没有超过限定写入文件的警戒线
        if ($count >= REDIS_FEEDBACK_WARNING_FILE) {
            \Log::info(date('Y-m-d', time()) .'意见数过多，请去指定文件检查是否有异常！');
            return ;
        } else {
            // 如果记录数超过警告界限，log日志打印警告
            if ($count >= REDIS_FEEDBACK_WARNING) \Log::info(date('Y-m-d', time()) .'超过设定警戒线'. REDIS_FEEDBACK_WARNING .'，请管理员查看是否异常！');
            $arr = [];
            // 循环得到哈希中的所有数据
            for ($i = 0; $i < $count; $i++) {
                $guid = BaseRedis::getListInIndex(LIST_FEED_BACK_INDEX_ . date('Y-m-d', time()), $i);
                $str = BaseRedis::getHMGet(HASH_FEED_BACK_ . date('Y-m-d', time()), $guid);

                $obj = json_decode($str[0]);
                if (empty($obj)) return;
                $guid1 = Uuid::uuid();
                $arr[] = ['guid' => $guid1, 'email' => $obj->fb_email, 'feedback' => $obj->description, 'ip' => $obj->ip, 'addtime' => time()];
            }
            \DB::table('data_feedback_info')->insert($arr);
        }

    }
}
