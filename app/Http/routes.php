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
        Route::resource('/action_add','ActionController@actionAdd');
        Route::resource('/action_change/{id}/{list}/','ActionController@actionChange');
        //活动报名管理
        Route::resource('/action_order','ActionOrderController');
        //内容管理
        Route::resource('/article', 'ArticleController');
        Route::resource('/banner','ArticleController@bannerpic');
        // 网站管理
        Route::resource('/web_admins/uploadorganizpic', 'WebAdminstrationController@uploadOrganizPic');
        Route::resource('/web_admins', 'WebAdminstrationController');

        // 用户管理bate
        Route::resource('/user_management','UserManagementController');
        // 角色申请管理
        Route::resource('/role_management','RoleManagementController');

        // 意见管理
        Route::resource('/feedback', 'FeedbackController');


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
    Route::resource('/register/checkphoto', 'RegisterController@checkPhoto');
    Route::resource('/register', 'RegisterController');
    //众筹
    Route::resource('/crowd_funding', 'CrowdFundingController');
    //活动内容页
    Route::resource('/action', 'ActionController');
    //七牛TokenToken
    Route::get('/getQiniuToken','ProjectController@getToken');
    // 点赞
    Route::resource('/article/like', 'ArticleController@like');
    //文章内容页 创业政策 市场咨询
    Route::resource('/article', 'ArticleController');

    //写评论
    Route::resource('/article/setcomment', 'ArticleController@setComment');
    //显示评论详情页
    Route::resource('/comment', 'ArticleController@commentShow');
    //学院内容页
    Route::resource('/school', 'SchoolController');
    //发布项目
    Route::resource('/project', 'ProjectController');
    //项目列表ajax请求
    Route::post('/project/list','ProjectController@lists')->name('projectList');
    // openIM 阿里云旺
    Route::resource('/openim', 'OpenIMController');

    //中间件，检验是否登录
    Route::group(['middleware'=>'HomeMiddleware'],function(){
        //获取角色信息
        Route::get('/roleinfo/{id}','UserController@roleInfo');
        // 用户角色
        Route::resource('/cardpic','RoleController@cardpic');
        Route::resource('/identity','RoleController');
        // 修改头像
        Route::resource('/headpic','UserController@headpic');
        Route::resource('/uploadcard','UserController@uploadCard');
        // 修改账号绑定信息
        Route::resource('/user/sendsms','UserController@sendSms');
        Route::resource('/user/sendemail','UserController@sendEmail');
        Route::resource('/user/change/email','UserController@changeEmail');
        Route::resource('/user/change/phone','UserController@changeTel');
        Route::resource('/user/change/password','UserController@changePassword');
        // 个人中心页
        // 评论和赞
        Route::get('/user/commentandlike','UserController@commentAndLike')->name('commentlike');
        Route::post('/user/commentandlike','UserController@getLike')->name('getLike');
        //我的项目
        Route::get('/user/myProject','UserController@myProject');
        Route::resource('/user','UserController');
        // 前台登出
        Route::get('/logout','LoginController@logout');
        //众筹用户投钱
        Route::get("/investment/{project_id}","CrowdFundingController@investment");

        Route::resource('/project_user','ProjectUsersController');

        //活动管理
        Route::resource('/activity', 'ActivityController');
        //活动报名管理
        Route::resource('/action_order','ActionOrderController');
        //投稿管理
        Route::resource('/send/get_article_info', 'SendController@getArticleInfo');
        Route::resource('/send', 'SendController');

        Route::resource('/upload','ActionController@upload');
    });


});

//redis缓存隔离demo路由
Route::resource('/test','TestController');






