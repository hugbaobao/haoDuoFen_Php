<?php
namespace app\controller;

use app\BaseController;
use think\facade\Db;
use app\model\Phptable;
use app\validate\User;
use think\exception\ValidateException;

class Rules extends BaseController 
{
    public function index () {
         $users = request()->param();
                 // var_dump($users);
        try{
            validate(User::class)->scene('edit')->check($users);
            echo '验证通过';
        } catch (ValidateException $e) {
            //   dump($e->getError());
            return dump([
                'status' => 1,
                'msg'    => $e->getError()
            ]);
        }

    }
}