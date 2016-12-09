<?php
namespace App\TaoBaoSdk;

use App\TaoBaoSdk\Top\Request\OpenimUsersAddRequest;
use App\TaoBaoSdk\Top\Request\OpenimUsersGetRequest;
use App\TaoBaoSdk\Top\Domains\Userinfos;
use App\TaoBaoSdk\Top\TopClient;

class fileTest
{
    public function __construct()
    {
        include __DIR__ . "/TopSdk.php";
        date_default_timezone_set('Asia/Shanghai');

        $c = new TopClient;
        $c->appkey = '23560564';
        $c->secretKey = '46c48f104f5a2a516e2b5e0ae2a3cac8';
        // $req = new TradeVoucherUploadRequest;
        // $req->setFileName("example");
        // $req->setFileData("@/Users/xt/Downloads/1.jpg");
        // $req->setSellerNick("奥利奥官方旗舰店");
        // $req->setBuyerNick("101NufynDYcbjf2cFQDd62j8M/mjtyz6RoxQ2OL1c0e/Bc=");
        // var_dump($c->execute($req));

//        $req = new OpenimUsersGetRequest;
//        $req->setUserids("imuser123");
//        $resp = $c->execute($req);
//        dd($resp);
        $req = new OpenimUsersAddRequest;
        $userinfos = new Userinfos;

        $userinfos->nick="king";
        $userinfos->icon_url="http://xxx.com/xxx";
        $userinfos->email="uid@taobao.com";
        $userinfos->mobile="18600000000";
        $userinfos->taobaoid="tbnick123";
        $userinfos->userid="1234567";
        $userinfos->password="1111111";

        $req->setUserinfos(json_encode($userinfos));
        $resp = $c->execute($req);
        dd($resp);
    }
}