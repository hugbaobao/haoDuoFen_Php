<?php


namespace app\middleware;

use think\middleware\AllowCrossDomain;



class AllowCrossDomainMiddleware extends AllowCrossDomain

{

    // 加入自定义请求头参数 X-Token

    protected $header = [

        'Access-Control-Allow-Credentials' => 'true',

        'Access-Control-Max-Age'           => 1800,

        'Access-Control-Allow-Methods'     => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',

        'Access-Control-Allow-Headers'     => 'Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-CSRF-TOKEN, X-Requested-With, X-Token',

    ];

}