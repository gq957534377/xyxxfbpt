<?php
/**
 * Created by PhpStorm.
 * User: Twitch
 * Date: 2016/11/4
 * Time: 10:03
 */
namespace App\Tools;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Gregwar\Captcha\CaptchaBuilder;
//随机生成短语，自定义的多元化！
use Gregwar\Captcha\PhraseBuilder;
use Ramsey\Uuid\Uuid;
// 阿里大于 短信
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;



/**
 * Class Common
 * 常用工具类
 * @package App\Tools
 */
class Common {

    /**
     * 获取uuid
     * @return string
     */
    public static function getUuid()
    {
        $uuid1 = Uuid::uuid1();
        return $uuid1->getHex();//返回16进制值
    }
    /**
     * 加密算法
     * @param $email 邮箱
     * @param $pass 密码
     * @param string $str 自定义string
     * @param int $position 截取位置
     * @return string
     * @author 刘峻廷
     */
    public static function cryptString($tel, $pass, $str = 'twitch', $position = 5)
    {
        // 拼接字符串
        $newStr = substr(Crypt::encrypt($tel.$str) , 0, $position);
        // 密码MD5 进行加密
        $cryptPass = md5($pass);
        return md5(md5($newStr.$cryptPass));
    }

    /**
     * 生成验证码
     * @param $tmp
     * @param $model
     * @return PhraseBuilder|null|string
     * @author 刘峻廷
     */
    public static function captcha($tmp)
    {
        $phrase = new PhraseBuilder();
        // 设置验证码位数,
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code,$phrase);
        //设置背景颜色
        $builder->setBackgroundColor(255, 255, 255);
        //设置文本字体颜色
        $builder->setTextColor(46,105,59);
        // 设置前置干扰线
        $builder->setMaxFrontLines(0);
        //设置后置干扰线
        $builder->setMaxBehindLines(0);
        //设置倾斜角度
        $builder->setMaxAngle(0);
        //设置图片的宽高及字体
        $builder->build($width = 118 ,$height = 44,$font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // 验证码存入session
        Session::put('code',$phrase);
        //生成图片，设置头文件的格式
        header("Cache-Control: no-cache,must-revalidate");
        header("Content-Type:image/jpeg");
        // 将图片输出
        $builder->output();


    }

    /**
     * 发送短信验证码
     * @param $phone
     * @setSmsParam             模板内容
     * @param $smsFreeSignName  兄弟会
     * @param $tmeplateCode     SMS_25700502
     * @return false|object
     * @author 刘峻廷
     */
    public static function sendSms($phone,$setSmsParam,$smsFreeSignName,$tmeplateCode)
    {
        $app_key = '23436923';
        $app_secret = '8b837e3a344b8cc324de88926426a30a';
        // 配置信息
        $config = [
            'app_key'       => $app_key,
            'app_secret'    => $app_secret,
            // 'sandbox'    => true,  // 是否为沙箱环境，默认false
        ];
        // 使用方法一
        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;
        // setRecNum -> 手机号
        // setSmsParam -> 验证码
        // setSmsFreeSignName -> 短信签名
        // setSmsTemplateCode -> 短信模板ID
        $req->setRecNum($phone)
            ->setSmsParam($setSmsParam)
            ->setSmsFreeSignName($smsFreeSignName)
            ->setSmsTemplateCode($tmeplateCode);
        // 返回发送成功信息
        $info = $client->execute($req);
        if(property_exists($info,'result')){
            return $info->result->success;
        }
    }
    /**
     * 获取分页URL
     * @param  object $data 把传进来
     * @param  string $table 把表名传进来
     * @param  string $url 把主URL传进来
     * @return mixed(array | false)
     * @author 郭庆
     */

    public static function getPageUrl($data, $table, $url, $n, $where)
    {
        if (empty($table) || empty($url)) return false;
        $nowPage   = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;
        $count     = DB::table($table)->where($where)->count();
        $totalPage = ceil($count / $n);
        $baseUrl   = url($url);
        if($nowPage <= 0) $nowPage = 1;
        if($nowPage > $totalPage) $nowPage = $totalPage;
        return [
            'nowPage' => $nowPage,
            'pages'   => CustomPage::getSelfPageView($nowPage, $totalPage, $baseUrl, null),
        ];
    }
    /**
     * new获取分页URL
     * @param  object $data 把$request传进来
     * @param  string $table 把表名传进来
     * @param  string $url 把主URL传进来
     * @return mixed(array | false)
     * @author 张洵之
     */
    public static function  getPageUrls($data, $table, $url, $n,$filed,$where)
    {
        if(empty($table) || empty($url)) return false;
        $nowPage   = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;
        if($filed){
            $count = DB::table($table)->whereIn($filed,$where)->count();
        }else{
            $count = DB::table($table)->where($where)->count();
        }
        $totalPage = ceil($count / $n);
        $baseUrl   = url($url);
        if($nowPage <= 0) $nowPage = 1;
        if($nowPage > $totalPage) $nowPage = $totalPage;
        return [
            'nowPage' => $nowPage,
            'pages'   => CustomPage::getSelfPageView($nowPage, $totalPage, $baseUrl,null),
        ];

    }

    /**
     * new获取分页URL 不包括页码
     * @param  object $data 把$request传进来
     * @param  string $table 把表名传进来
     * @param  string $url 把主URL传进来
     * @return mixed(array | false)
     * @author 张洵之
     */
    public static function  getPageUrlsUN($data, $table, $url, $n,$filed,$where)
    {
        if(empty($table) || empty($url)) return false;
        $nowPage   = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;
        if($filed){
            $count = DB::table($table)->whereIn($filed,$where)->count();
        }else{
            $count = DB::table($table)->where($where)->count();
        }
        $totalPage = ceil($count / $n);
        $baseUrl   = url($url);
        if($nowPage <= 0) $nowPage = 1;
        if($nowPage > $totalPage) $nowPage = $totalPage;
        return [
            'nowPage' => $nowPage,
            'pages'   => CustomPage::getSelfPageViewUN($nowPage, $totalPage, $baseUrl,null),
        ];

    }

    /**
     * 返回七牛upToken
     * @return mixed
     * @author 贾济林
     */
    public static function getToken()
    {
        // 需要填写你的 Access Key 和 Secret Key
        $accessKey = 'VsAP-hK_hVPKiq5CQcoxWNhBT9ZpZ1Ii4z3O_W51';
        $secretKey = '5dqfmvL15DFoAK1QzaVF2TwVzwJllOF8K4Puf1Po';

        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);

        // 要上传的空间
        $bucket = 'jacklin';

        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        return $token;
    }

    /**
     * 七牛云服务器上传接口
     * @param $filePath
     * @param $key
     * @return array
     * @author 贾济林
     */
    public static function QiniuUpload($filePath,$key)
    {
        //获得token
        $token = self::getToken();

        // 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        $res = ['status' => true, 'url'=> 'http://ogd29n56i.bkt.clouddn.com/'.$key];

        if (!$err==null) return ['status' => false, 'msg' => $err];

        return $res;
    }

    /**
     * 字符限制，添加省略号
     * @param $words
     * @param $limit
     * @return string
     * @author 刘峻廷
     */
    public static function wordLimit($words, $filed,$limit)
    {
        foreach($words as $word){
            $content = trim($word->$filed);
            $content = mb_substr($content, 0, $limit, 'utf-8').' ...';;
            $word->$filed = $content;
        }

    }
}
