<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;

class Group extends model
{
    // 设置库
    protected $connection = 'monitor';
    // 设置表
    protected $table = 'edition_group';
    // 设置表名
    protected $name = 'group';
    // 设置主键
    protected $id = 'id';

    // 一对多关联
    public function Landing()
    {
        return $this->hasMany(Landing::class, 'uid', 'id');
    }

    //远程一对多关联
    public function cvslink()
    {
        return $this->hasManyThrough(Cvslink::class, Landing::class, 'uid', 'uid', 'id', 'id');
    }

    //远程一对多关联
    public function Monitor()
    {
        return $this->hasManyThrough(Monitor::class, Landing::class, 'uid', 'uid', 'id', 'id');
    }
}
