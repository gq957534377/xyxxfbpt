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
        view()->composer('home/public/footer', function ($view) use ($webadmin) {
            $res = $webadmin->getWebInfo();

            if (!empty($res) && $res['StatusCode'] == '200') {
                foreach ($res['ResultData'] as $val) {
                    switch ($val->type) {
                        case 1:
                            $view->with('email', $val->value);
                            break;
                        case 2:
                            $view->with('time', $val->value);
                            break;
                        case 3:
                            $view->with('tel', $val->value);
                            break;
                        case 4:
                            $view->with('record', $val->value);
                            break;
                    }
                }
            } else {
                view()->share('email', '*****@***');
                view()->share('time', '*********');
                view()->share('tel', '***********');
                view()->share('record', '***********');
            }
        });
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
