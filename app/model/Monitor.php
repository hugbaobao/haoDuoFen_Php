<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;

class Monitor extends model
{
    // 设置库
    protected $connection = 'conversion';
    // 设置表
    protected $table = 'cvsmsg_one';
    // 设置表名
    protected $name = 'monitor';
    // 设置主键
    protected $id = 'id';

    // 保存json字段
    protected $json = ['city'];
}
