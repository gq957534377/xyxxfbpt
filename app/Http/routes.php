<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * 后台入口
 */
//路由组中指定域名，命名空间
Route::group(['domain' => 'admin.hero.app','namespace' => 'Admin'],function(){
    //补充资源控制器
    Route::get('/code/captcha/{tmp}','LoginController@captcha');
    // 后台登录页
    Route::resource('/login','LoginController');
    // 后台登出
    Route::get('/logout', 'LoginController@logout');
    // 后台注册页
    Route::resource('/register','RegisterController');

    // 后台,中间件检验是否登录
    Route::group(['middleware'=> 'AdminMiddleware'],function(){
        // 后台首页
        Route::resource('/','AdminController');
        //创业技术培训
        Route::resource('/training','TrainingController');
        // 创业大赛->发布信息入口
        Route::resource('/match','VentureContestController');
        // 路演活动
        Route::resource('/roald','RoaldController');
        // 用户管理
        Route::resource('/users', 'UserController');
        // 路演活动
        Route::resource('/roald','RoaldController');
        //项目比赛
        Route::resource('/items','VentureContestController');
        // 路演活动
        Route::resource('/roald','RoaldController');
        //众筹
        Route::resource('/project_approval', 'CrowdFundingController');
    });

});

/**
 * 前台入口
 */
Route::group(['namespace' => 'Home'],function() {
    // 前台首页
    Route::resource('/', 'HomeController@index');
    // 验证码
    Route::get('/code/captcha/{tmp}', 'LoginController@captcha');
    // 前台登录页
    Route::resource('/login', 'LoginController');
    // 发送验证码
    Route::post('/sms','RegisterController@sendSms');
    // 前台注册页
    Route::resource('/register', 'RegisterController');
    //众筹首页
    Route::resource('/crowd_funding', 'CrowdFundingController');
    //众筹首页ajax请求
    Route::get('index_ajax',"CrowdFundingController@indexAjax");
    //查询某类项目可分页数
    Route::get("crow_funding_page/{id}","CrowdFundingController@endPage");
    //查询某类项目某页内容
    Route::post("crow_funding_page","CrowdFundingController@pageContent");
    //前台路演页面
    Route::resource('/roald','RoaldController');
    //创业技术培训
    Route::resource('/training', 'TrainingListController');
    // 创业大赛->团队报名入口
    Route::resource('/items','VentureContestController');
    //中间件，检验是否登录
    Route::group(['middleware'=>'HomeMiddleware'],function(){
        // 个人中心页
        Route::get('/userinfo','UserController@getUserInfo');
        Route::resource('/user','UserController');
        // 前台登出
        Route::get('/logout','LoginController@logout');

    });

});

