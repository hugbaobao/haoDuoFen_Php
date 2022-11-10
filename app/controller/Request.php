<?php
namespace app\controller;

use app\BaseController;
use app\model\Phptable;

class Request extends BaseController {
    public function index () {
        return 'index';
    }

    public function rely () {
       $uid = request()->param('id');
      //  可以设置查询不到参数时的默认值
       $uid = request()->param('id',5);
  
      $user = Phptable::find($uid);
      return json($user);
    }

    public function check () {
      $uid = request()->param();
      // var_dump($uid) ;
      // return $uid['id'];
      return request()->method();

    /*  $bl = input('?get.name');
     var_dump($bl); */
    }       
}