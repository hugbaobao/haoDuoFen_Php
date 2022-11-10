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

    // 模型搜索器    模糊查询
    public function searchUrlAttr($query, $value, $data)
    {
        $query->where('url', 'like', '%' . $value . '%');
    }

    public function searchCreateTimeAttr($query, $value, $data)
    {
        $query->whereBetweenTime('create_time', $value[0], $value[1]);
    }

    // 模型的查询范围
    /*  public function scopePages($query, $page, $limit)
    {
        $query->page($page, 1)->limit($limit, 5);
    } */
}
