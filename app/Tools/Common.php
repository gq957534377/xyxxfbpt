<?php
/**
 * Created by PhpStorm.
 * User: Twitch
 * Date: 2016/11/4
 * Time: 10:03
 */
namespace App\Tools;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Gregwar\Captcha\CaptchaBuilder;
//随机生成短语，自定义的多元化！
use Gregwar\Captcha\PhraseBuilder;
use Ramsey\Uuid\Uuid;
// 阿里大于 短信
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;



/**
 * Class Common
 * 常用工具类
 * @package App\Tools
 */
class Common {

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
    public static function cryptString($email,$pass,$str='twitch',$position=5)
    {
        // 拼接字符串
        $newStr = substr(Crypt::encrypt($email.$str) ,0,$position);
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
    public static function captcha($tmp,$model)
    {
        $phrase = new PhraseBuilder();
        // 设置验证码位数,
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code,$phrase);
        //设置背景颜色
        $builder->setBackgroundColor(205, 233, 192);
        //设置文本字体颜色
        $builder->setTextColor(46,105,59);
        // 设置前置干扰线
        $builder->setMaxFrontLines(2);
        //设置后置干扰线
        $builder->setMaxBehindLines(2);
        //设置倾斜角度
        $builder->setMaxAngle(20);
        //设置图片的宽高及字体
        $builder->build($width = 118 ,$height = 36,$font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // $model 模式，1：后台验证码图 2：前台验证码图 3：短信验证码
        switch ($model){
            case 1:
                Session::put('code',$phrase);
                //生成图片，设置头文件的格式
                header("Cache-Control: no-cache,must-revalidate");
                header("Content-Type:image/jpeg");
                // 将图片输出
                $builder->output();
                break;
            case 2:
                Session::put('homeCode',$phrase);
                //生成图片，设置头文件的格式
                header("Cache-Control: no-cache,must-revalidate");
                header("Content-Type:image/jpeg");
                // 将图片输出
                $builder->output();
                break;
            case 3:
                return $phrase;
                break;
        }
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

}
