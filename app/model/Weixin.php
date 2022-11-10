<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;

class Weixin extends model
{
    // 设置库
    protected $connection = 'weixin';
    // 设置表
    protected $table = 'manage_wxnumber';
    // 设置表名
    protected $name = 'Weixin';
    // 设置主键
    protected $id = 'id';

    // 一对多关联
    public function Wxgroup()
    {
        return $this->belongsTo(Wxgroup::class, 'uid');
    }
}
