<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;

class Landing extends model
{
    // 设置库
    protected $connection = 'monitor';
    // 设置表
    protected $table = 'edition_landing';
    // 设置表名
    protected $name = 'landing';
    // 设置主键
    protected $id = 'id';

<<<<<<< HEAD
    // 模型获取器
    public function getEnableAttr($value)
    {
        $enable  = [-1 => '删除', 0 => false, 1 => true, 2 => '待审核'];
=======
    // 设置字段类型
    protected $type = [
        'delivery'    =>    'boolean',
        'track'       =>    'boolean',
        'enable'      =>    'boolean',
    ];

    // 关联模型->统计链接管理
    public function cvslink()
    {
        return $this->hasOne(Cvslink::class, 'uid');
    }

    // 模型获取器
    public function getEnableAttr($value)
    {
        $enable  = [0 => false, 1 => true];
>>>>>>> 618b839 (更新部分接口)
        return $enable[$value];
    }
    public function getDeliveryAttr($value)
    {
<<<<<<< HEAD
        $delivery  = [-1 => '删除', 0 => false, 1 => true, 2 => '待审核'];
=======
        $delivery  = [0 => false, 1 => true];
>>>>>>> 618b839 (更新部分接口)
        return $delivery[$value];
    }
    public function getTrackAttr($value)
    {
<<<<<<< HEAD
        $track  = [-1 => '删除', 0 => false, 1 => true, 2 => '待审核'];
=======
        $track  = [0 => false, 1 => true];
>>>>>>> 618b839 (更新部分接口)
        return $track[$value];
    }

    // 模型修改器  新增更新时触发
<<<<<<< HEAD
    /* public function setEmailAttr($value)
    {
        return strtoupper($value);
=======
    /*  public function setEnableAttr($value)
    {

>>>>>>> 618b839 (更新部分接口)
    } */

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
