<?php
/******** 前端缓存隔离 redis key定义**********/
/* redis 全局失效时间配置 */
define('REDIS_LIVE_TIME', 600);



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



/**
 * 活动信息列表索引
 * 作者：郭庆
 * 作用：用于存储：某一类型的活动，某一状态的活动的所有id
 * KEY = LIST:ACTION:[活动类型]:[活动状态]
 * VALUE = data_action_info表中满足条件的所有活动id [guid1, guid2, ......]
 * 说明：
 *      LIST:ACTION:-:[某一个状态]  -> 存储制定状态的所有活动guid
 *      LIST:ACTION:[活动类型]:[活动状态]  -> 存储指定类型和指定活动状态的所有活动guid
 *      LIST:ACTION:[活动类型]  -> 存储指定类型的所有活动guid
 */
define('LIST_ACTION_GUID_','LIST:ACTION:GUID:');



/**
 * 活动信息记录
 * 作者：郭庆
 * 作用：用于存储：指定guid的活动所有字段信息
 * KEY = HASH:ACTION:INFO:[活动guid]
 * VALUE = data_action_info表中所有字段（数组类型）['guid' => '....', 'addtime' => '13244545', ......]
 * 注意：
 *      数据库存储的addtime, status, type .....都是int类型，在从redis中取出来使用时要转换为int在进行正常使用
 */
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
