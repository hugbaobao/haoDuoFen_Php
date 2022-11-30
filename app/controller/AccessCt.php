<?php

namespace app\controller;

use app\BaseController;
use app\model\Access;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;
use \Firebase\JWT\JWT;


// 获取微信接口调用凭证，需添加计划任务刷新数据库
class AccessCt extends BaseController
{
    public function index()
    {
        return 'user_Admin';
    }

    // 获取借口调用凭证access_token
    function getToken()
    {
        $APPID = "wx275cf0f7d73ad216";
        $APPSECRET = "0868d2d03031e48a4ea8fd37e2b76a59";

        $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $APPID . "&secret=" . $APPSECRET;

        $json = file_get_contents($TOKEN_URL);
        $result = json_decode($json);

        $ACC_TOKEN = $result->access_token;

        return $ACC_TOKEN;
    }

    // 注册
    public function register()
    {
        $user = Access::find(1);
        $token = $this->getToken();

        $data = [
            'access'     =>    $token,
        ];
        $user->save($data);
        return ressend(200, '成功');
    }

    // 查
    public function getuser()
    {
        $user = Access::find(1);
        return json($user->access);
        // return ressend(200, '密码错误！', $user);
    }
}
