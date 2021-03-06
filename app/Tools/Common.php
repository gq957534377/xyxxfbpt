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
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;



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
     * @author 郭庆
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
     * @author 郭庆
     */
    public static function captcha()
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
//        return $phrase;

    }

    /**
     * 返回静态验证码图片
     * @return string
     * @author 杨志宇
     */
    public static function captchaStatus()
    {
        $image = response(file_get_contents(asset('/home/images/yzm/'. mt_rand(0, 99) .'.jpeg')), 200);  //假设当前文件夹已有图片001.jpg
        $content=addslashes($image);
        //生成图片，设置头文件的格式
        header("Cache-Control: no-cache,must-revalidate");
        header("Content-Type:image/jpeg");
        return $content;
    }
    /**
     * 发送短信验证码
     * @param $phone
     * @setSmsParam             模板内容
     * @param $smsFreeSignName  兄弟会
     * @param $tmeplateCode     SMS_25700502
     * @return false|object
     * @author 郭庆
     */
    public static function sendSms($phone,$setSmsParam)
    {
        // 配置信息
        $config = [
            'app_key'       => SMS_APP_KEY,
            'app_secret'    => SMS_APP_SECRET,
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
            ->setSmsFreeSignName(SMS_FREE_SIGN_NAME)
            ->setSmsTemplateCode(SMS_TEMPLATE_REGISTER_CODE);
        // 返回发送成功信息
        $info = $client->execute($req);
        if(property_exists($info,'result')){
            return $info->result->success;
        }
    }

    /**
     * new获取分页URL
     * @param  object $data 把$request传进来
     * @param  string $table 把表名传进来
     * @param  string $url 把主URL传进来
     * @param  int $n 一页的数据条数
     * @param  (string|null) $filed 要做集合查询的字段
     * @param  array $where 被查询的集合||查询条件
     * @return mixed(array | false)
     * @author 杨志宇
     */
    public static function  getPageUrls($data, $table, $url, $n,$filed,$where)
    {
        if(empty($table) || empty($url)) return false;

        $nowPage   = isset($data['nowPage']) ? ($data['nowPage'] + 0) : 1;

        if($filed) {
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
            'totalPage'=> (int)$totalPage,
            'pages'   => CustomPage::getSelfPageView($nowPage, $totalPage, $baseUrl,null),
        ];

    }


    /**
     * 返回七牛upToken
     * @return mixed
     * @author guoqing
     */
    public static function getToken()
    {
        // 需要填写你的 Access Key 和 Secret Key
//        $accessKey = 'c_M1yo7k90djYAgDst93NM3hLOz1XqYIKYhaNJZ4';
//        $secretKey = 'Gb2K_HZbepbu-A45y646sP1NNZF3AqzY_w680d5h';

        // 构建鉴权对象
        $auth = new Auth(QINIU_ACCESS_KEY, QINIU_SECRET_KEY);

        // 要上传的空间
        $bucket = QINIU_BUCKET;

        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        return $token;
    }

    /**
     * 七牛云服务器上传接口
     * @param $filePath
     * @param $key
     * @return array
     * @author guoqing
     */
    public static function QiniuUpload($filePath,$key)
    {
        //获得token
        $token = self::getToken();

        // 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        $res = ['status' => true, 'url'=> QINIU_URL.$key];

        if (!$err==null) return ['status' => false, 'msg' => $err];

        return $res;
    }

    /**
     * 产生cookie
     *
     * @return string
     *
     * @author 郭庆
     */
    public static function generateCookie($key)
    {
        // 检查传过来的key是否为空
        if (empty($key)) return false;

        // 对cookie进行加密
        $value = md5(REGISTER_SIGNATURE . $key);
        return cookie($key, $value, COOKIE_LIFETIME);
    }

    /**
     * 判断cookie是否正确,如果错误,再生成cookie再返回回去
     *
     * @param $key
     *
     * @author 杨志宇
     */
    public static function checkCookie($key, $msg)
    {
        // 获取cookie
        $cookie = Cookie::get($key);

        // 进行cookie比较
        if($cookie != md5(REGISTER_SIGNATURE . $key)) {
            $cookie = Common::generateCookie($key);
            return response()
                ->json(['StatusCode' => '400', 'ResultData' => $msg . '失败,请重试!'])
                ->withCookie($cookie);
        }

        return true;
    }

    /**
     * 写入文件内容
     *
     * @param $content
     * @param string $type
     * @return bool
     *
     * @author 杨志宇
     */

    public static function writeFile($content, $type = '')
    {
        // 判断是否有内容
        if (empty($content)) return false;

        // 如果是数组或对象,转成json
        if (is_object($content) || is_array($content)) {
            $content = json_encode($content);
        }

        // 判断是否增加时间戳前缀
        if (empty($type)) {
            $content = '[紧急] ' . date('H:i:s', $_SERVER['REQUEST_TIME']) . $content . "\n";
        }

        // 文件名
        $date = date('Ymd', $_SERVER['REQUEST_TIME']);
        // 追加写文件
        return Storage::disk('local')->append($date . '.txt', $content);
    }

    /**
     * 返回静态图片的验证码
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @author 郭庆
     * @author 郭庆
     */
    public static function CaptchaImg()
    {
        // 获取0-99的文件名
        $fileName = mt_rand(0, 99);
        // 定义七牛上验证码的路由
        $path = 'http://' . QINIU_BUCKET_YZM . '/';
        //拼接url
        $file = $path . $fileName . '.jpeg';
        //返回图片
        return response(file_get_contents($file), 200);
    }
}
