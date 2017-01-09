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




