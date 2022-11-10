<?php
// 应用公共文件
use GuzzleHttp\Client;

//   发起 GET 请求
function getrequest($methods, $UrlSb)
{

    $client = new Client([
        // 'base_uri'  =>  '47.96.27.188:8886',
        'timeout' => 2
    ]);

    $response = $client->request($methods, $UrlSb);
    $code = $response->getStatusCode(); // 接口状态码200
    $reason  =  $response->getReasonPhrase(); //原因短语
    /*  $response -> getHeaderLine ( 'content-type' ); // '应用程序/json; charset=utf8'  */
    $body = $response->getBody(); // 获取接口内容
    $content = $body->getContents();
    return json([
        'code'     =>   $code,
        'reason'   =>   $reason,
        'body'     =>   $content
    ]);
}

//   发起 POST 请求
function postrequest($methods, $UrlSb, $data)
{

    $client = new Client([
        // 'base_uri'  =>  '47.96.27.188:8886',
        'timeout' => 2
    ]);

    $response = $client->request($methods, $UrlSb, $data);
    $code = $response->getStatusCode(); // 接口状态码200
    $reason  =  $response->getReasonPhrase(); //原因短语
    /*  $response -> getHeaderLine ( 'content-type' ); // '应用程序/json; charset=utf8'  */
    $body = $response->getBody(); // 获取接口内容
    $content = $body->getContents();
    return json([
        'code'     =>   $code,
        'reason'   =>   $reason,
        'body'     =>   $content
    ]);
}

// 定义api返回的数据格式
function ressend($status, $message = 'error', $data = [], $httpStatus = 200)
{
    $result = [
        "code" => $status,
        "message" => $message,
        "data" => $data
    ];
    return json($result, $httpStatus);
}
