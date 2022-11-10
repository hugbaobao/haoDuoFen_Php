<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

/* Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello'); */

// 设置全局变量规则；
/* Route::pattern([
    'id' => '\d+',
    'uid' => '\d+'
    ]); */
// 也可以用-》设置单独变量规则
// Route::rule('details/:id','/Address/details')->Pattern(['id' => '\d+']);

// 跨域
// Route::domain();

// 基本用法
/* Route::rule('details/:id', 'Address/details')->allowCrossDomain(); */

<<<<<<< HEAD



=======
>>>>>>> 618b839 (更新部分接口)
// 强制所有 URL 后缀为.html
// Route::rule('details/:id', 'Address/details')->ext('html');

// 请求方法可以限制，不限制就是通用any(GET、POST、DELETE、PUT、PATCH)
// Route::rule('details/:id', 'Address/xxx', 'GET|POST');

// 快捷方式，就是直接用 Route::get、Route::post 等方式即可，无须第三参数
// Route::get('xxx', 'xxx');

// 多种地址的配置规则
/* Route::rule('ad/:id', 'Address/details');
Route::rule('ad', 'Address/index'); */

// 定义标识
// Route::rule('details/:id', 'Address/details')->name('det');

// 路由分组
/* Route::group(function(){
    Route::rule('newtest', 'test/newtest')->validate([
        'name|用户名'      =>      'require',
        'id'        =>      'number'
    ]);
    Route::rule('gd', 'test/getDemoUser');
})->allowCrossDomain(); */

Route::group('test', function () {
    Route::rule('index', 'test/index');
    Route::rule('newtest', 'test/newtest');
    Route::rule('gd', 'test/getDemoUser');
})->validate(\app\validate\User::class, 'route')->allowCrossDomain();


Route::group(function () {
    Route::rule('r_index', 'rules/index');
})->allowCrossDomain();

// 定义一个miss界面
// Route::miss('error/miss');

/*
Route::rule('thello', 'test/hello');
Route::redirect('/', '/thello?name=cuf&id=111', 302); */

// 上传图片测试
Route::group('demo', function () {
    Route::rule('ds', 'demo/deselect');
    Route::rule('du', 'demo/deupdate');
    Route::rule('dm', 'demo/dmupdate');
})->allowCrossDomain();

<<<<<<< HEAD

=======
>>>>>>> 618b839 (更新部分接口)
// 测试api上报
Route::group('tencent', function () {
    Route::rule('tfeed', 'tencent/tfeedback');
    Route::rule('tfeeds', 'tencent/tfeedbacks');
})->allowCrossDomain();

// 以下为新加入
<<<<<<< HEAD
// 监测
Route::group('monitor', function () {
    Route::rule('index', 'Monitorct/index');
    Route::rule('append', 'Monitorct/append');
})->allowCrossDomain();

=======
>>>>>>> 618b839 (更新部分接口)
// 落地页
Route::group('landing', function () {
    Route::rule('append', 'landingct/append');
    Route::rule('del', 'landingct/dellanding');
    Route::rule('dellot', 'landingct/dellandings');
    Route::rule('update', 'landingct/updatelanding');
<<<<<<< HEAD
    Route::rule('gtc', 'landingct/gettotal');
    Route::rule('gtlanding', 'landingct/getlanding');
=======
    Route::rule('gtlanding', 'landingct/getlanding');
    Route::rule('gtl', 'landingct/getlandingall');
    Route::rule('tgl', 'landingct/togglelanding');
    // 关联查询部分
    Route::rule('lag', 'landingct/landingandgroup');
>>>>>>> 618b839 (更新部分接口)
})->allowCrossDomain();

// 分组
Route::group('group', function () {
    Route::rule('append', 'groupct/append');
    Route::rule('del', 'groupct/delgroup');
    Route::rule('update', 'groupct/update');
<<<<<<< HEAD
    Route::rule('gtc', 'groupct/gettotal');
    Route::rule('gtgroup', 'groupct/getgroup');
    Route::rule('gta', 'groupct/getgroupall');
=======
    Route::rule('gtgroup', 'groupct/getgroup');
    Route::rule('gta', 'groupct/getgroupall');
    Route::rule('gts', 'groupct/groupsearch');
})->allowCrossDomain();

// 监测
Route::group('monitor', function () {
    Route::rule('append', 'Monitorct/append');
    Route::rule('gtmonitor', 'Monitorct/getmonitor');
})->allowCrossDomain();

// 微信号管理统计
Route::group('weixin', function () {
    // 转化微信号统计
    Route::rule('getwx', 'weixinct/getweixin');
    //微信号管理
    Route::rule('ctwx', 'weixinct/cotrweixin');
})->allowCrossDomain();

// 微信号分组
Route::group('wxgroup', function () {
    Route::rule('append', 'WxgroupCt/append');
    Route::rule('del', 'WxgroupCt/delgroup');
    Route::rule('update', 'WxgroupCt/update');
    Route::rule('gtg', 'WxgroupCt/get_wxgroup');
    Route::rule('ggl', 'WxgroupCt/get_grouplist');
})->allowCrossDomain();

// 统计链接管理
Route::group('cvslink', function () {
    // 测试预留
    Route::rule('gbls', 'cvslinkct/getbelongss');
    // 正式
    Route::rule('append', 'cvslinkct/append');
    Route::rule('del', 'cvslinkct/delcvs');
    Route::rule('update', 'cvslinkct/updatecvs');
    Route::rule('min', 'cvslinkct/minsecond');
    Route::rule('gbl', 'cvslinkct/getbelongs');
    Route::rule('gtr', 'cvslinkct/getcvsrate');
>>>>>>> 618b839 (更新部分接口)
})->allowCrossDomain();
