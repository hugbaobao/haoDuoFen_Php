<?php

namespace app\controller;

use app\BaseController;
use app\model\Admin;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;
use \Firebase\JWT\JWT;

class AdminCt extends BaseController
{
    public function index()
    {
        return 'user_Admin';
    }

    function setToken($password)
    {
        $key = "aslfjhasgjgja";
        $token = array(
            "iss" => $key,        //签发者 可以为空
            "aud" => '',          //面象的用户，可以为空
            "iat" => time(),      //签发时间
            "nbf" => time(),    //在什么时候jwt开始生效  （这里表示签发后立即生效）
            "exp" => time() + 1 * 60 * 60 * 48, //token 过期时间两天
            "data" => [           //加入password，后期同样使用password进行比对
                'password' => $password,
            ]
        );

        $jwt = JWT::encode($token, $key, "HS256");  //根据参数生成了 token
        return $jwt;
    }


    // 注册
    public function register()
    {
        $user = request()->param('form');
        $exist = Admin::where('username', $user['username'])->find();
        if (isset($exist)) {
            return ressend(201, '该用户名已被占用！');
        }
        // 密码加密
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
        $data = [
            'username'     =>    $user['username'],
            'password'     =>    $user['password'],
            'header'       =>    $user['imageUrl'],
            'power'        =>    $user['power']
        ];
        $sql = new Admin();
        $sql->save($data);
        return ressend(200, '成功');
    }

    // 登录
    public function Login()
    {
        $user = request()->param('form');
        $exist = Admin::where('username', $user['username'])->find();
        if ($exist == null) {
            return ressend(201, '账号不存在！');
        }
        if (password_verify($user['password'], $exist['password'])) {
            $Token = $this->setToken($exist['id']);
            return json([
                'code'     =>     200,
                'msg'      =>     '获取成功！',
                'Token'    =>     $Token,
                'IDcode'   =>     $exist['id']
            ]);
        }
        return ressend(202, '密码错误！');
    }

    //改密
    public function changepassword()
    {
        $user = request()->param('form');
        $exist = Admin::where('username', $user['username'])->where('id', '<>', $user['id'])->find();
        if (isset($exist)) {
            return ressend(201, '该用户名已被占用！');
        }
        $sql = Admin::find($user['id']);
        // 密码加密
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
        $sql->username     =    $user['username'];
        $sql->password     =    $user['password'];
        $sql->header       =    $user['imageUrl'];
        $sql->power        =    $user['power'];

        $sql->save();
        return ressend(200, '成功');
    }

    // 查
    public function getuser()
    {
        $req = request()->param('id');
        $user = Admin::find($req);
        return ressend(200, '密码错误！', $user);
    }
}
