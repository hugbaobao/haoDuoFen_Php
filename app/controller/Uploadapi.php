<?php
header("content-type:text/html;charset=utf-8");
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:HEAD,POST,GET,PUT,DELETE,OPTIONS");
header('Access-Control-Allow-Headers:x-requested-with,content-type');
$wx=$_POST['wx'];
/**
 * 获取access_token
 * $appid:开发者ID(AppID)
 * $appsecret：开发者密码(AppSecret)
 *
 * 返回access_token、有效时间
 */
function wx_xcx_code($appid, $appsecret){
    $access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
    $access_info = json_decode(file_get_contents($access_url),true);
    return $access_info;
}


/**
 * 拼接接口及请求参数  调用POST请求 返回结果
 */
function  getUrlScheme(){
    $access_token = wx_xcx_code("wx9e20c0856c0eeeb2", "521f690e656875c03ca27f286ffeafd9");
    $access_token = $access_token['access_token']; // 加个判断，是否获取成功
    $url = "https://api.weixin.qq.com/wxa/generatescheme?access_token=" . $access_token;
    $path = '/pages/index/index';

    //query  跳转传递的参数
    $scene = 'id=19';
        $post_data = [
            'jump_wxa' => [
                'path' => $path,
                'query' => $scene
            ],
            'is_expire' => true,
            'expire_time' => 1656777600
        ];
    $post_data = json_encode($post_data);
    $result = api_notice_increment($url, $post_data);
    $openlink=json_decode($result,true);
    return $openlink['openlink'];
    // print_r($openlink['openlink']);
}

/**
 * 发起 POST 请求微信接口
 * https://api.weixin.qq.com/wxa/generatescheme?access_token=ACCESS_TOKEN
 *
 * 返回结果
 */
function api_notice_increment($url, $data){
    $ch = curl_init();
    $header = ["Accept-Charset" => "utf-8"];
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $tmpInfo = curl_exec($ch);
    // var_dump($tmpInfo);
    if (curl_errno($ch)) {
        return false;
    } else {
        // var_dump($tmpInfo);
        return $tmpInfo;
    }
}


// 调用 打印结果
$ok = getUrlScheme();
echo $ok;
// print_r($ok);
?>