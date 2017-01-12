<?php

define('PAGENUM', 5);//评论页数据

define('SET_FEEDBACK_IP', 'SET:FEEDBACK:IPLIST:');
define('STRING_FEEDBACK_COUNT', 'STRING:FEEDBACK:COUNT');
define('HASH_FEED_BACK', 'HASH:FEED:BACK');
define('LIST_FEED_BACK_INDEX', 'LIST:FEED:BACK:INDEX');

// Redis超时事件   如果这里写一天，代表redis保存两天
define('REDIS_FEEDBACK_LIFE_TIME', 3599 * 24);
// 警戒线
define('REDIS_FEEDBACK_WARNING', 200);
// 写文件的限制
define('REDIS_FEEDBACK_WARNING_FILE', 500);

// 等级签名key
define('REGISTER_SIGNATURE', 'luanqibazaodezifuchuan');

// 验证cookie 的生命周期
define('COOKIE_LIFETIME', 1800);

// 每小时登录错误N次之后，输入验证码才可以登录
define('LOGIN_ERROR_NUM', 5);
// 检测错误时间区间
define('LOGIN_ERROR_NUM_TIME', 3600);
// Redis Hash 超时时间
define('HASH_OVERTIME', 600);
// 首页显示字符数常量
define('STR_LIMIT', 20);




