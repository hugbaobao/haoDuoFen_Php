<?php

namespace app\controller;

use app\BaseController;

class Error extends BaseController
{
    // 定义一个miss界面
    public function miss()
    {
        return '404 页面不存在！';
    }
}
