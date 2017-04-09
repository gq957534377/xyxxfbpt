<?php

namespace App\Console\Commands;

use App\Services\AdminService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

/**
 * 注册超级管理员命令
 *
 * Class CreateAdministrator
 * @package App\Console\Commands
 * @author scort
 */
class CreateAdministrator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'administrator:create {--u} {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建后台超级管理员 eg: administrator:create --u guoqing';

    // 管理员业务辅助
    protected static $adminService = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AdminService $adminService)
    {
        parent::__construct();
        self::$adminService = $adminService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 创建管理员
        self::create();
    }

    /**
     * 创建管理员
     *
     * @return void
     * @author 郭庆
     */
    private function create()
    {
        $password = $this->secret('请输入密码：');

        if (!($this->argument('user') == env('ROOT_USERNAME') && $password == env('ROOT_PASSWORD'))){
            $this->error('用户名或密码有误！');
            return ;
        }
        $this->info('登陆成功！');
        $email = $this->ask('请输入邮箱：');
        $password = $this->ask('请输入密码：');
        $this->info('邮箱：'.$email);
        $this->info('密码：'.$password);
        if ($this->confirm('你确认注册吗?')) {
            //确定
            $this->info('正在注册...');
            $data = [
                'email' => $email,
                'password' => $password
            ];
            // 参数验证
            $validator = Validator::make($data, [
                'email' => 'required|email',
                'password' => 'required|min:6|max:128',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $this->table(['错误'], (array) $errors->toArray());
                self::create();
                return ;
            }

            $res = self::$adminService->addAdministrator($data);
            if ($res['status'] == 200) {
                $this->info($res['msg']);
            } else {
                $this->error($res['msg']);
                self::create();
            }
        } else {
            $this->info('取消注册');
        }

    }
}
