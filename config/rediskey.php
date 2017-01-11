<?php
/******** 前端缓存隔离 redis key定义**********/

//articcle 文章 redis key
define('LIST_ARTICLE_INFO','LIST:ARTICLE:INFO:');
define('HASH_ARTICLE_INFO_','HASH:ARTICLE:INFO:');
//project 项目 redis key
define('LIST_PROJECT_INFO','LIST:PROJECT:INFO:');
define('HASH_PROJECT_INFO_','HASH:PROJECT:INFO:');
//action 活动 redis key
define('LIST_ACTION_','LIST:ACTION:');
define('LIST_ACTIONORDER_','LIST:ACTIONORDER:');
define('HASH_ACTION_INFO_','HASH:ACTION:INFO:');

/**
 * 用户账号列表 -- 存储所有用户的账号
 *
 * KEY   = LIST:USER:ACCOUNT:[手机号] or LIST:USER:ACCOUNT:[邮箱] (二期可能加上邮箱登录)
 * VALUE = data_user_login 表中所有用户的手机号（邮箱）
 */
define('LIST_USER_ACCOUNT', 'LIST:USER:ACCOUNT');
/**
 * 用户账号信息表 -- 存储所有用户账号相关信息
 *
 * KEY   = HASH:USER:ACCOUNT:[手机号or邮箱]
 * VALUE = data_user_login 表中用户账户相关所有数据
 */
define('HASH_USER_ACCOUNT_', 'HASH:USER:ACCOUNT:');
//英雄学院
define('LIST_COLLEGE_','LIST:COLLEGE:');
define('HASH_COLLEGE_INFO_','HASH:COLLEGE:INFO:');

//articcle 网站基本信息 redis key
define('LIST_WEBADMIN_INFO','LIST:WEBADMIN:INFO');
define('HASH_WEBADMIN_INFO_','HASH:WEBADMIN:INFO:');
//合作机构，投资机构， redis key
define('LIST_PICTURE_INFO','LIST:PICTURE:INFO');
define('HASH_PICTURE_INFO_','HASH:PICTURE:INFO:');
//轮播图， redis key
define('LIST_ROLLINGPICTURE_INFO','LIST:ROLLINGPICTURE:INFO');
define('HASH_ROLLINGPICTURE_INFO_','HASH:ROLLINGPICTURE:INFO:');
//comment评论 redis key
define('LIST_COMMENT_INFO','LIST:COMMENT:INFO:');
define('HASH_COMMENT_INFO_','HASH:COMMENT:INFO:');
//userinfo用户信息 redis key
define('LIST_USERINFO_INFO','LIST:USERINFO:INFO:');
define('HASH_USERINFO_INFO_','HASH:USERINFO:INFO:');
