<?php

define('PAGENUM', 5);//评论页数据


/**
 * 用户建议  Redis超时事件   如果这里写一天，代表redis保存两天
 * 说明：因为redis超时设置的原理是，设置昨天的key超时时间，今天一天，加上昨天大约保存两天时间
 * 作用： 限制指定可以超时
 *
 * VALUE =  INT  代表时间秒数
 * @author 杨志宇
 */
define('REDIS_FEEDBACK_LIFE_TIME', 3599 * 24);
/**
 * 警戒线
 * 说明：如果当天评论数超过警戒线，则任务调度时，不再写入数据库
 * 作用： 限制写入数据库的数量
 *
 * VALUE =  NUM   代表条数
 * @author 杨志宇
 */
define('REDIS_FEEDBACK_WARNING', 200);
/**
 * 写文件的限制
 * 说明：如果当天评论数超过限制，则用户提交建议是，不再写入缓存，将直接写入文件存储
 * 作用： 限制写入数据库的数量
 *
 * VALUE =  NUM   代表条数
 * @author 杨志宇
 */
define('REDIS_FEEDBACK_WARNING_FILE', 500);

// 等级签名key
define('REGISTER_SIGNATURE', 'luanqibazaodezifuchuan');

// 验证cookie 的生命周期
define('COOKIE_LIFETIME', 1800);

// 每小时登录错误N次之后，输入验证码才可以登录
define('LOGIN_ERROR_NUM', 3);
// 检测错误时间区间
define('LOGIN_ERROR_NUM_TIME', 3600);
// Redis Hash 超时时间
define('HASH_OVERTIME', 600);
// Redis String 超时时间
define('STRING_OVERTIME', 600);

// 首页显示字符数常量
define('STR_LIMIT', 20);
// 短信接口相关配置
define('SMS_APP_KEY', '23623270');                              // 应用 APP KEY
define('SMS_APP_SECRET', 'e95ddca21fa444e64ed4c143b2da1157');   // 应用 APP Secret
define('SMS_FREE_SIGN_NAME', '校园信息发布平台');                  // 短信签名
define('SMS_TEMPLATE_REGISTER_CODE', 'SMS_44455707');           // 注册短信模板ID
define('SMS_TEMPLATE_CHANGERPASSWORD_CODE', 'SMS_44410546');    // 修改密码短信模板ID
// 七牛云存储接口相关配置
define('QINIU_ACCESS_KEY', 'Z6fxJAffaB5yK9VpW_85SUWVBosEr_yXSCsODjmm'); // 七牛访问KEY
define('QINIU_SECRET_KEY', 'VKyfWX4e7TdHwXbkss6m9gwE9-uGMfsjSvYGUvqS'); // 七牛访问秘钥
define('QINIU_BUCKET', 'guoqing2');                                 // 七牛存储空间
define('QINIU_URL', 'http://ol0fkmsij.bkt.clouddn.com/');               // 七牛访问url
//前台域名配置
define('HOME_URL', 'www.gq1994.top');
//后台域名配置
define('ADMIN_URL', 'admin.gq1994.top');


// 首页合作机构，投资机构。轮播图，网页页脚信息，过期时间
define('WEB_PIC_TIME', 60 * 60 * 24 * 30);

// 真实用户标识
define('REAL_USER', 'real_user');
// 登陆错误统计失效时间30分钟
define('LOGIN_COUNT_KET_TIME', 1800);
// 静态验证码存储空间
define('QINIU_BUCKET_YZM', 'olt6kf7lb.bkt.clouddn.com');





