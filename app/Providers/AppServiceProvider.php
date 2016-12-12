<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WebAdminService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(WebAdminService $webadmin)
    {
        $res = $webadmin->getWebInfo();

        if (!empty($res) && $res['StatusCode'] = '200') {
            view()->share($res['ResultData'][0]->name, $res['ResultData'][0]->value);
            view()->share($res['ResultData'][1]->name, $res['ResultData'][1]->value);
            view()->share($res['ResultData'][2]->name, $res['ResultData'][2]->value);
            view()->share($res['ResultData'][3]->name, $res['ResultData'][3]->value);
        } else {
            view()->share('email', '*****@***');
            view()->share('time', '*********');
            view()->share('tel', '***********');
            view()->share('record', '***********');
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
