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
Route::group(['domain' => ADMIN_URL, 'namespace' => 'Admin'], function () {
    //补充资源控制器
    Route::get('/code/captcha/{tmp}', 'LoginController@captcha');
    // 后台登录页
    Route::resource('/login', 'LoginController');
    // 后台登出
    Route::get('/logout', 'LoginController@logout');
    // 后台注册页
    // Route::resource('/register','RegisterController');
    // 后台,中间件检验是否登录
    Route::group(['middleware' => 'AdminMiddleware'], function () {
        // 后台首页
        Route::resource('/', 'AdminController');
        //校园通知管理
        Route::resource('/notice', 'NoticeController');
        //校园活动管理
        Route::resource('/action', 'ActionController');
        Route::resource('/action_add', 'ActionController@actionAdd');
        Route::resource('/action_change/{id}/{list}/', 'ActionController@actionChange');
        //活动报名管理
        Route::resource('/action_order', 'ActionOrderController');
        //校园文章管理
        Route::resource('/article', 'ArticleController');
        Route::resource('/banner', 'ArticleController@bannerpic');
        // 网站管理
        Route::resource('/web_admins/uploadorganizpic', 'WebAdminstrationController@uploadOrganizPic');
        Route::resource('/web_admins', 'WebAdminstrationController');

        // 用户管理bate
        Route::resource('/user_management', 'UserManagementController');
    });
});

/**
 * 前台入口
 */

Route::group(['domain' => HOME_URL, 'namespace' => 'Home'], function () {
    //公共类
    Route::get('errors/{status}', 'CommonController@errors');
    // 前台首页
    Route::resource('/', 'HomeController@index');
    // 关于我们
    Route::get('/about', 'HomeController@aboutWe');
    // 验证码
    Route::get('/getCaptcha/{mun}/{page}', 'RegisterController@getCaptcha');
    // 前台登录页
    Route::resource('/login', 'LoginController');
    // 前台计算机等级考试成绩查询
    Route::resource('/jisuanji', 'JisuanjiController');
    // 前台手机端校园学习
    Route::resource('/study', 'StudyController');
    // 获取修改密码的验证码
    Route::resource('/changepwd/code', 'LoginController@sendSms');
    // 前台注册页
    Route::resource('/register/checkphoto', 'RegisterController@checkPhoto');
    Route::resource('/register', 'RegisterController');
    //活动内容页
    Route::resource('/action', 'ActionController');
    //七牛TokenToken
    Route::get('/getQiniuToken', 'ProjectController@getToken');
    Route::get('/commentForPage', 'ProjectController@commentForPage');
    //文章内容页
    Route::resource('/article', 'ArticleController');
    // 校园通知
    Route::resource('/notice', 'NoticeController');
    //写评论
    Route::resource('/article/setcomment', 'ArticleController@setComment');
    //显示评论详情页
    Route::resource('/comment', 'ArticleController@commentShow');

    Route::resource('/news', 'NewsController');
    Route::resource('/goods', 'GoodsController');

    //中间件，检验是否登录
    Route::group(['middleware' => 'HomeMiddleware'], function () {
        //获取角色信息
        Route::get('/roleinfo/{id}', 'UserController@roleInfo');
        // 用户角色
        Route::resource('/cardpic', 'RoleController@cardpic');
        Route::resource('/identity', 'RoleController');
        // 修改头像
        Route::resource('/headpic', 'UserController@headpic');
        Route::resource('/uploadcard', 'UserController@uploadCard');
        // 修改账号绑定信息
        Route::resource('/user/sendsms', 'UserController@sendSms');
        Route::resource('/user/sendemail', 'UserController@sendEmail');
        Route::resource('/user/change/email', 'UserController@changeEmail');
        Route::resource('/user/change/phone', 'UserController@changeTel');
        Route::resource('/user/change/password', 'UserController@changePassword');
        // 个人中心页
        // 评论和赞
        Route::get('/user/commentandlike', 'UserController@commentAndLike')->name('commentlike');
        Route::post('/user/commentandlike', 'UserController@getLike')->name('getLike');
        Route::get('/user/realname/{guid}', 'UserController@getRealName');
        Route::resource('/user', 'UserController');
        // 前台登出
        Route::get('/logout', 'LoginController@logout');

        //活动报名管理
        Route::resource('/action_order', 'ActionOrderController');
        //投稿管理
        Route::resource('/send/get_article_info', 'SendController@getArticleInfo');
        Route::resource('/send', 'SendController');
        Route::resource('userGoods', 'userGoodsController');

        Route::resource('/upload', 'ActionController@upload');
    });


});

//redis缓存隔离demo路由
//Route::resource('/test','TestController');
