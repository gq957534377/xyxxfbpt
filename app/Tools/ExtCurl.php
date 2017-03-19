<?php

namespace App\Tools;

/**
 * Class Curl
 *
 * @package App\Tools
 * @author 左霄红
 */
class ExtCurl
{
    /**
     * 伪装浏览器
     * @param $url
     * @param $type GET/POST
     * @param null $data POST参数
     * @param bool $cookie
     * @param string $cookieFileName
     * @param null $header
     * @param null $referer
     * @return array|mixed
     */
    public static function request(
        $url,
        $type,
        $data = null,
        $cookie = false,
        $cookieFileName = '',
        $header = null,
        $referer = null
    ){
        header("Content-type: text/html; charset=utf-8");

        //初始化
        $ch = curl_init();

        //设置URL地址
        curl_setopt($ch, CURLOPT_URL, $url);
        //设置响应结果不直接显示，返回到变量中
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //设置请求方式
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
        //设置USER-agent
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        //记录referer
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);

        //SSL设置
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //PUT|DELETE|POST设置
        if(strtolower($type) != 'get'){
            curl_setopt($ch, CURLOPT_POST, true);//post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        //cookie设置
        if ($cookie) {
            // 时区设置：重点
            date_default_timezone_set('PRC');
            curl_setopt($ch, CURLOPT_COOKIESESSION, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFileName);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFileName);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        }

        //设置信息
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        //设置referer
        if ($referer) {
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        }

        //执行
        $result = curl_exec($ch);

        //错误判断
        if (curl_errno($ch)) {
            return '请求失败';
        }

        //关闭
        curl_close($ch);

        return $result;
    }

}
