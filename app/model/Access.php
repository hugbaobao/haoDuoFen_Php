<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;

class Access extends model
{
    // 设置库
    protected $connection = 'wx';
    // 设置表
    protected $table = 'access_token';
    // 设置表名
    protected $name = 'access';
    // 设置主键
    protected $id = 'id';
}
