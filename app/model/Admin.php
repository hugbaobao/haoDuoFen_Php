<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;

class Admin extends model
{
    // 设置库
    protected $connection = 'monitor';
    // 设置表
    protected $table = 'user_admin';
    // 设置表名
    protected $name = 'admin';
    // 设置主键
    protected $id = 'id';
}
