<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;

require __DIR__ . '/../vendor/autoload.php';

// 执行HTTP应用并响应
$http = (new App())->http;

$response = $http->run();

$response->send();

$http->end($response);

// 处理 OPTIONS 请求
/* if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){

    header("'Access-Control-Allow-Credentials: true");

    header("Access-Control-Allow-Origin: *");

    header("Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-CSRF-TOKEN, X-Requested-With, X-Token");

    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, PATCH');

    exit; // 直接退出，不走后序流程

} */
