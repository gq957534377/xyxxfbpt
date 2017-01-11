<?php
/******** 前端缓存隔离 redis key定义**********/

//articcle 文章 redis key
/**
 * 文章列表 存储有效的文章GUID 有序集合
 * 作用:  存储文章列表，实现缓存分页。
 *
 * KEY = LIST:ARTICLE:INFO:[类型]     类型：1 表示市场咨询，2，表示创业政策。
 * VALUE =  data_article_info  中的 每个文章的GUID，用来查询对应哈希中的数据
 */
define('LIST_ARTICLE_INFO_', 'LIST:ARTICLE:INFO:');
/**
 * 文章哈希表   存储未过期的文章详情
 * 作用： 存储具体文章详细信息。实现数据隔离
 *
 * KEY = HASH:ARTICLE:INFO:[GUID]     GUID 为指定文章的唯一标示。
 * VALUE =  data_article_info  表中每个文章的详细信息。
 */
define('HASH_ARTICLE_INFO_', 'HASH:ARTICLE:INFO:');
//project 项目 redis key
define('LIST_PROJECT_INFO','LIST:PROJECT:INFO:');
define('HASH_PROJECT_INFO_','HASH:PROJECT:INFO:');
//action 活动 redis key
define('LIST_ACTION_','LIST:ACTION:');
define('LIST_ACTIONORDER_','LIST:ACTIONORDER:');
define('HASH_ACTION_INFO_','HASH:ACTION:INFO:');
//user 用户登录 redis key
define('LIST_USER_ACCOUNT', 'LIST:USER:ACCOUNT');
define('HASH_USER_ACCOUNT_', 'HASH:USER:ACCOUNT:');
//英雄学院
define('LIST_COLLEGE_','LIST:COLLEGE:');
define('HASH_COLLEGE_INFO_','HASH:COLLEGE:INFO:');

//articcle 网站基本信息 redis key
/**
 * 网站基本信息列表
 * 作用： 存储网站基本信息的列表。
 *
 * KEY = LIST:WEBADMIN:INFO
 * VALUE = data_web_info 表的ID
 */
define('LIST_WEBADMIN_INFO', 'LIST:WEBADMIN:INFO');

/**
 * 网站基本信息内容
 * 作用： 存储网站基本信息的列表。
 *
 * KEY = HASH:WEBADMIN:INFO:[ID]      ID   是信息的索引ID。
 * VALUE = data_web_info 表的未删除信息记录。
 */

define('HASH_WEBADMIN_INFO_', 'HASH:WEBADMIN:INFO:');
//合作机构，投资机构， redis key
/**
 * 存储合作，投资机构的索引ID
 * 作用： 存储机构列表的索引。  注意，分类为首页展示时，判断字段值
 *
 * KEY = LIST:PICTURE:INFO
 * VALUE = data_picture_info 表的未删除索引记录。
 */
define('LIST_PICTURE_INFO', 'LIST:PICTURE:INFO');

/**
 * 存储合作，投资机构的详细信息
 * 作用： 存储机构列表的索引。
 *
 * KEY = HASH:PICTURE:INFO:[ID]   ID 为机构的索引ID
 * VALUE = data_picture_info 表的未删除记录详情。
 */
define('HASH_PICTURE_INFO_', 'HASH:PICTURE:INFO:');
//轮播图， redis key
/**
 * 存储轮播图索引ID
 * 作用： 首页轮播图缓存。
 *
 * KEY = LIST:ROLLINGPICTURE:INFO
 * VALUE = data_rollingpicture_info   轮播图的相信信息
 */
define('LIST_ROLLINGPICTURE_INFO', 'LIST:ROLLINGPICTURE:INFO');
/**
 * 存储轮播图信息
 * 作用： 首页轮播图缓存，实现数据隔离。
 *
 * KEY = HASH:ROLLINGPICTURE:INFO:[ID]    ID为轮播图的索引ID
 * VALUE = data_rollingpicture_info   轮播图的相信信息
 */
define('HASH_ROLLINGPICTURE_INFO_', 'HASH:ROLLINGPICTURE:INFO:');
//comment评论 redis key
define('LIST_COMMENT_INFO','LIST:COMMENT:INFO:');
define('HASH_COMMENT_INFO_','HASH:COMMENT:INFO:');
//userinfo用户信息 redis key
define('LIST_USERINFO_INFO','LIST:USERINFO:INFO:');
define('HASH_USERINFO_INFO_','HASH:USERINFO:INFO:');
