<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;

class Cvstype extends model
{
    // 设置库
    protected $connection = 'monitor';
    // 设置表
    protected $table = 'cvsmsg_type';
    // 设置表名
    protected $name = 'Cvstype';
    // 设置主键
    protected $id = 'id';
}
