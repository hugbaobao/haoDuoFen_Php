<?php

namespace app\middleware;

use Exception;
use \Firebase\JWT\JWT;

class compareToken
{
    public function handle($request, \Closure $next)
    {
        // 如果没问题，就执行下一步接口函数操作
        return $next($request);

        // 获取请求头header中的authorization（token值）
        $token = request()->header('authorization');
        // 去除token值中的bearer+空格标识
        $token = str_replace('Bearer ', '', $token);
        // return response($token);
        if ($token === "undefined") {
            // 这里是自定义的
            // return ressend(401, '登陆状态失效，请重新登录！');

            // abort终止操作，返回结果
            abort(json(['message' => '登陆状态失效，请重新登录', 'code' => 401], $httpCode = 401));
            // return response($code);
        }
        // key必须与生成token值得字符串相同
        $key = 'aslfjhasgjgja';
        try {
            JWT::$leeway = 60; //当前时间减去60，把时间留点余地用于后面的操作
            $decoded = JWT::decode($token, $key, array('HS256')); //HS256方式，这里要和签发的时候对应
            // 解析过程中如果出现不对的情况就利用下方catch方法，利用jwt解析问题返回错误信息

        } catch (\Firebase\JWT\SignatureInvalidException $e) { // token不正确
            abort(json(['message' => '登陆状态失效，请重新登录', 'code' => 401], $httpCode = 401));
        } catch (\Firebase\JWT\BeforeValidException $e) { // token过了之前设置的两天期限
            abort(json(['message' => '登陆状态失效，请重新登录', 'code' => 401], $httpCode = 401));
        } catch (\Firebase\JWT\ExpiredException $e) { // token过期
            abort(json(['message' => '登陆状态失效，请重新登录', 'code' => 401], $httpCode = 401));
        } catch (Exception $e) { //其他错误
            abort(json(['message' => '登陆状态失效，请重新登录', 'code' => 401], $httpCode = 401));
        }
    }
}
