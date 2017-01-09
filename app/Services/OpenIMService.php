<?php
/**
 * Created by PhpStorm.
 * User: wangt
 * Date: 2016/12/9
 * Time: 15:37
 */

namespace App\Services;

use App\Redis\BaseRedis;
use App\Store\OpenIMStore;
use App\TaoBaoSdk\Top\Request\OpenimUsersAddRequest;
use App\TaoBaoSdk\Top\Request\OpenimUsersGetRequest;
use App\TaoBaoSdk\Top\Domains\Userinfos;
use App\TaoBaoSdk\Top\TopClient;


class OpenIMService
{
    protected static $openim;
    protected $userinfos = [];

    /**
     * 单例引入
     * OpenIMService constructor.
     * @param OpenIMStore $openim
     */
    public function __construct(OpenIMStore $openim)
    {
        self::$openim = $openim;
        $this->userinfos['touid'] = '测试账号935';
        $this->userinfos['appkey'] = '23560564';
    }

    /**
     * 保存IM信息
     * @return array
     * @author 王通
     */
    public function saveIM()
    {

    }

    /**
     * 获取指定ID用户的IM信息
     * @param $id
     * @return array
     * @author 王通
     */
    public function getOpenIM($uid, $nick, $icon_url, $mobile)
    {

        $res = self::$openim->getInfo(['user' => md5($uid)]);


        // 判断数据是否存在
        if (!empty($res)) {
            $this->userinfos['uid'] = $res->user;
            $this->userinfos['pwd'] = $res->password;
            return ['StatusCode' => '200', 'ResultData' => $this->userinfos];
        } else {
            // 如果数据不存在则插入数据
            $userid = md5($uid);
            $pwd = md5($uid);
            $this->userinfos['uid'] = $userid;
            $this->userinfos['pwd'] = $pwd;
            $res = self::$openim->insertInfo([
                'user' => $userid,
                'password' => $pwd,
                'addtime' => time()
            ]);
            // 判断是否插入成功
            if (!empty($res)) {
                $rest = $this->userToIM($userid, $pwd, $nick, $icon_url, $mobile);
                // 判断是否写入IM服务器成功
                if (!empty($rest->code)) {
                    return ['StatusCode' => '400', 'ResultData' =>$rest->sub_msg];
                }

            }
            return ['StatusCode' => '200', 'ResultData' => $this->userinfos];
        }

    }

    /**
     * 把用户信息写入到IMservice
     *
     *
     * @author 王通
     */
    public function userToIM($userid, $password, $nick, $icon_url, $mobile)
    {
        $c = new TopClient;
        $c->appkey = '23560564';
        $c->secretKey = '46c48f104f5a2a516e2b5e0ae2a3cac8';
        $req = new OpenimUsersAddRequest;
        $userinfos = new Userinfos;
        $userinfos->nick = $nick;
        $userinfos->icon_url = $icon_url;
        $userinfos->mobile = $mobile;

        $userinfos->userid = $userid;
        $userinfos->password = $password;

        $req->setUserinfos(json_encode($userinfos));
        $resp = $c->execute($req);
        return $resp;
    }


}