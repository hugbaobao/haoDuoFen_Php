<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;

class Wxgroup extends model
{
    // 设置库
    protected $connection = 'weixin';
    // 设置表
    protected $table = 'manage_wxgroup';
    // 设置表名
    protected $name = 'Wxgroup';
    // 设置主键
    protected $id = 'id';

    // 一对多关联
    public function Weixin()
    {
        return $this->hasMany(Weixin::class, 'uid', 'id');
    }

    public function Landing()
    {
        return $this->hasMany(Landing::class, 'gid', 'id');
    }
}
