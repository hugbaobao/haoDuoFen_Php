<?php

namespace app\controller;

use app\BaseController;

class Tencent extends BaseController
{
   public function index()
   {
      return 'index';
   }

   //  get上报
   public function tfeedback()
   {
      $req = request()->param();
      $clickid = $req['clickid'];
      $actiontime = $req['cvstime'];
      $actiontype = 'ACTIVATE_APP';
      $link = urlencode($req['link']);
      $UrlSb = "http://tracking.e.qq.com/conv/web?clickid=" . $clickid . "&action_time=" . $actiontime . "&action_type=" . $actiontype . "&link=" . $link;

      // 点击监测链接
      /* $UrlSb = "http://tracking.e.qq.com/conv/web?clickid=".$req['click_id']."&account_id=".$req['account_id']."&callback=".$req['callback']."&click_time=".$req['click_time']."&device_os_type=".$req['device_os_type']."&promoted_object_id=".$req['promoted_object_id']."&qz_gdt=".$req['qz_gdt']."&action_time=".$actiontime."&action_type=".$actiontype."&link=".$encode; */

      $result = $this->https_request($UrlSb);
      return $result;
   }

   // 自归因上报
   // 填写了点击转发链接，上报cb
   public function tfeedbacks()
   {
      $req = request()->param();
      // $decode = urldecode($req['callback']);
      $decode = 'YWRzX3NlcnZpY2UsMTU4NDUxMDI3OSwyNjg5MzNhMzc5MTM0YzBjMDQ4ZGZjMGQyNGYzMTk0NWYzMzJiOWNi&conv_id=10001';
      $actiontime = 1492998081;
      $actiontype = 'ACTIVATE_APP';
      $UrlSb = "http://tracking.e.qq.com/conv?cb=" . $decode;
      $data = [
         'actions'     =>     [
            "action_time"     =>     $actiontime,
            "action_type"     =>     $actiontype,
            "action_param"    =>    [
               'clickid'       =>      $req['click_id'],
               'click_time'    =>      $req['click_time'],
               'account_id'    =>      $req['account_id'],
               'device_os_type' =>      $req['device_os_type'],
               'promoted_object_id' => $req['promoted_object_id'],
               'qz_gdt'        =>      $req['qz_gdt']
            ]
         ]
      ];
      $results = postrequest('POST', $UrlSb, $data);
      return json($results);

      // $UrlSb = "/test/index";
   }

   // 未填写点击转发链接，上报clickid
   /* public function tfeedbackn(){
   $req = request()->param();
   $actiontime = 1492998081;
   $actiontype = 'ACTIVATE_APP';
   $UrlSb = "http://tracking.e.qq.com/conv/web?clickid=".$req['clickId'];
   $data = [
      'actions'     =>     [
         "action_time"     =>     $actiontime,
         "action_type"     =>     $actiontype,
         "action_param"    =>    [
            'clickid'       =>      $req['click_id'],
            'click_time'    =>      $req['click_time'],
            'account_id'    =>      $req['account_id'],
            'device_os_type'=>      $req['device_os_type'],
            'promoted_object_id' => $req['promoted_object_id'],
            'qz_gdt'        =>      $req['qz_gdt']
         ]
      ]
         ];
         $results = postrequest('POST',$UrlSb,$data);
         return $results;

   // $UrlSb = "/test/index";
} */


   /*  public function tfeedback(){
    $req = request()->param();
    $data = [
      'click_id'       =>       $req['click_id'],
      'click_time'     =>       $req['click_time'],
      'account_id'     =>       $req['account_id'],
      'device_os_type' =>       $req['device_os_type'],
      'promoted_object_id' =>   $req['promoted_object_id'],
      'callback'       =>       $req['callback'],
      'qz_gdt'         =>       $req['qz_gdt']
    ];
   //  return json($req);
   //  return json($data);
    $callback = [
      'actions'        =>        [
         "outer_action_id"  =>  "outer_action_identity", //客户唯一行为id
         "action_time"      =>     1492998081,
      ],
      "action_type"    =>        "ACTIVATE_APP", // 必填 行为类型
      "url"            =>        "www.my.com", // Web必填 网页域名。
      'actions'        =>        [
         "click_id"    =>        "abc" // 必填请将点击id/曝光id填充在 click_id字段上报。企业微信选填
      ],
      "action_param"        =>    $data,
      "string_example"      =>    "123",
      'string_array_example'=>    [
         "123",
         "234",
         "abc"
      ],
    ];

    return  json($callback);
 } */
   function https_request($url, $data = null)
   {
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
      if (!empty($data)) {
         curl_setopt($curl, CURLOPT_POST, 1);
         curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      }
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($curl);
      curl_close($curl);
      return $output;
   }
}
