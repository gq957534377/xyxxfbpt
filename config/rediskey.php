<?php
/******** 前端缓存隔离 redis key定义**********/

//articcle 文章 redis key
define('LIST_ARTICLE_INFO','LIST:ARTICLE:INFO:');
define('HASH_ARTICLE_INFO_','HASH:ARTICLE:INFO:');

/**
 * 作者：张洵之
 * 项目融资阶段分类list
 * 作用：项目列表信息分类;
 * key = LIST:PROJECT:INFO:[（1--11）];
 * value = data_project_info表中的项目guid;
 *说明：[（1--11）]所填添数字分别对应：1-种子轮 ; 2-天使轮 ; 3-Pre-A轮 ; 4-A轮 ; 5-B轮 ; 6-C轮 ; 7-D轮 ; 8-E轮 ; 9-F轮已上市 ; 10-其他 11-全部在线的项目;
 */
define('LIST_PROJECT_INFO_','LIST:PROJECT:INFO:');

/**
 * 作者：张洵之
 * 项目详情hash
 * 作用：data_project_info表中一条项目记录的Hash缓存
 * key= HASH:PROJECT:INFO:[guid]
 * value = data_project_info表中一条项目记录
 * 说明:filed与data_project_info中一条记录的字段一一对应
 */
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
define('LIST_WEBADMIN_INFO','LIST:WEBADMIN:INFO');
define('HASH_WEBADMIN_INFO_','HASH:WEBADMIN:INFO:');
//合作机构，投资机构， redis key
define('LIST_PICTURE_INFO','LIST:PICTURE:INFO');
define('HASH_PICTURE_INFO_','HASH:PICTURE:INFO:');
//轮播图， redis key
define('LIST_ROLLINGPICTURE_INFO','LIST:ROLLINGPICTURE:INFO');
define('HASH_ROLLINGPICTURE_INFO_','HASH:ROLLINGPICTURE:INFO:');

/**
 * 作者：张洵之
 * 评论string
 * 作用：存取一个详情页下的所有评论数量;
 * key = STRING:COMMENT:NUM:[内容guid];
 * value = 详情页下的所有评论数量;
 */
define('STRING_COMMENT_NUM_','STRING:COMMENT:NUM:');

/**
 * 作者：张洵之
 * 评论list
 * 作用：用于评论索引;
 * key = LIST:COMMENT:INFO:[内容guid];
 * value = data_comment_info表中的主键id;
 */
define('LIST_COMMENT_INFO_','LIST:COMMENT:INFO:');
/**
 * 作者：张洵之
 * 评论hash
 * 作用：用于存取一条评论的所有信息;
 * key = HASH:COMMENT:INFO:[评论主键id];
 * value = 一条评论的所有信息;
 */
define('HASH_COMMENT_INFO_','HASH:COMMENT:INFO:');

/**
 * 作者：张洵之
 * 用户信息list
 * 作用：用于用户信息的索引;
 * key = LIST:USERINFO:INFO:[用户guid];
 * value = data_user_info表中的主键id;
 */
define('LIST_USERINFO_INFO_','LIST:USERINFO:INFO:');
/**
 * 作者：张洵之
 * 用户信息hash
 * 作用：用于存取一条用户信息;
 * key = HASH:USERINFO:INFO:[用户guid];
 * value = data_user_info表中的主键id;
 */
define('HASH_USERINFO_INFO_','HASH:USERINFO:INFO:');
