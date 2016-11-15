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
    Route::group(['middleware'=> 'AdminMiddleware'],function() {
        // 后台首页
        Route::resource('/', 'AdminController');
        //创业技术培训
        Route::resource('/training', 'TrainingController');
        Route::resource('/training_info_page', 'TrainingController@getInfoPage');
        Route::resource('/training_show_one', 'TrainingController@getOneTraining');
        Route::resource('/training_change_status', 'TrainingController@updateStatus');
        // 创业大赛->发布信息入口
        Route::resource('/match', 'VentureContestController');
        Route::get('paging','VentureContestController@paging');
        // 路演活动
        Route::resource('/road','RoadController');
        Route::resource('/road_info_page','RoadController@getInfoPage');
        Route::any('/upload','RoadController@upload');
        // 用户管理
        Route::resource('/users', 'UserController');
        Route::get('/users_data', 'UserController@getUserData');
        Route::get('/users_page', 'UserController@getUserData');
        Route::put('/users_data', 'UserController@updateData');
        Route::delete('/users_data', 'UserController@deleteData');
        Route::get('/users_one_data', 'UserController@getOneData');
        //众筹
        Route::resource('/project_approval', 'CrowdFundingController');
        //发布项目
        Route::resource('/project', 'ProjectController');
        Route::get('/jacklin', 'ProjectController@test');
        //众筹管理
        Route::resource('/project_approval', 'CrowdFundingController');
        //分页
        Route::get("/crowd_forpage",'CrowdFundingController@forPage');
        //众筹修改内容
        Route::post("/crowdfunding_revise",'CrowdFundingController@revise');
        //查看可发布的中筹项目
        Route::get("//select_publish",'CrowdFundingController@selectPublish');
    });
});

/**
 * 前台入口
 */
Route::group(['domian'=>'www.hero.app' ,'namespace' => 'Home'],function() {
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
    //发布项目
    Route::resource('/project', 'ProjectController');
    Route::get('/getuptoken', 'ProjectController@getUptoken');
    //中间件，检验是否登录
    Route::group(['middleware'=>'HomeMiddleware'],function(){
        // 修改头像
        Route::post('/headpic','UserController@headpic');
        // 申请成为创业者
        Route::post('/apply','UserController@applyRole');
        // 个人中心页
        Route::resource('/user','UserController');
        // 前台登出
        Route::get('/logout','LoginController@logout');

    });
});
