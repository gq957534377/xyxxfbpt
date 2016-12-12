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
        // 用户管理
        Route::resource('/user', 'UserController');
        Route::resource('/user_role', 'UserRoleController');
        //众筹
        Route::resource('/project_approval', 'CrowdFundingController');
        //众筹修改内容
        Route::post("/crowdfunding_revise",'CrowdFundingController@revise');
        //发布项目
        Route::resource('/project', 'ProjectController');
        //众筹管理
        Route::resource('/project_approval', 'CrowdFundingController');
        //分页
        Route::get("/crowd_forpage",'CrowdFundingController@forPage');
        //查看可发布的中筹项目
        Route::get("/select_publish",'CrowdFundingController@selectPublish');
        //活动管理
        Route::resource('/action', 'ActionController');
        Route::resource('/upload','ActionController@upload');
        //内容管理
        Route::resource('/article', 'ArticleController');

        // 网站管理
        Route::resource('/web_admins/uploadlogo', 'WebAdminstrationController@uploadLogo');
        Route::resource('/web_admins/uploadqrcode', 'WebAdminstrationController@uploadQRcode');
        Route::resource('/web_admins', 'WebAdminstrationController');


        // 合作机构管理
        Route::resource('/web_cooper_organiz', 'WebCooperOrganizController');

        // 投资机构管理
        Route::resource('/web_invest_organiz', 'WebInvestOrganizController');

        // 用户管理bate
        Route::resource('/test','TestController');

        // 图片内容管理
        Route::resource('/picture/carousel', 'PictureOrganizController@carousel');






        // 轮播图管理

        Route::resource('/picture/carouselajax', 'PictureOrganizController@carouselAjax');

        Route::resource('/picture/uploadcarousel', 'PictureOrganizController@uploadCarousel');
        Route::resource('/picture', 'PictureOrganizController');


    });
});

/**
 * 前台入口
 */

Route::group(['domain'=>'www.hero.app' ,'namespace' => 'Home'],function() {
    // 前台首页
    Route::resource('/', 'HomeController@index');
    // 验证码
    Route::get('/code/captcha/{tmp}', 'LoginController@captcha');
    // 前台登录页
    Route::resource('/login', 'LoginController');
    // 前台注册页
    Route::resource('/register', 'RegisterController');
    //众筹
    Route::resource('/crowd_funding', 'CrowdFundingController');
    //活动内容页
    Route::resource('/action', 'ActionController');
    //文章内容页
    Route::resource('/article', 'ArticleController');
    //学院内容页
    Route::resource('/school', 'SchoolController');
    // 市场咨询
    Route::resource('/market', 'MarketController');
    // 创业政策
    Route::resource('/policy', 'PolicyController');

    // openIM 阿里云旺
    Route::resource('/openim', 'OpenIMController');

    //中间件，检验是否登录
    Route::group(['middleware'=>'HomeMiddleware'],function(){
        //获取角色信息
        Route::get('/roleinfo/{id}','UserController@roleInfo');
        // 用户角色
        Route::resource('/identity','RoleController');
        // 申请角色视图
        Route::get('/user/apply/{param}','UserController@apply');
        // 修改头像
        Route::resource('/headpic','UserController@headpic');
        // 申请投资者
        Route::resource('/user/apply','UserController@applyRole');
        // 申请英雄会会员
        Route::resource('/user/apply/memeber','UserController@applyHeroMemeber');
        // 修改账号绑定信息
        Route::resource('/user/change/email','UserController@changeEmail');
        Route::resource('/user/change/phone','UserController@changeTel');
        // 个人中心页
        Route::resource('/user','UserController');
        // 前台登出
        Route::get('/logout','LoginController@logout');
        //众筹用户投钱
        Route::get("/investment/{project_id}","CrowdFundingController@investment");
        //发布项目
        Route::resource('/project', 'ProjectController');
        Route::resource('/project_user','ProjectUsersController');
        //活动管理
        Route::resource('/activity', 'ActivityController');
        //投稿管理
        Route::resource('/send', 'SendController');
        Route::resource('/upload','ActionController@upload');




    });





});






