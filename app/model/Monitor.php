<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;

class Monitor extends model
{
    // 设置库
<<<<<<< HEAD
    protected $connection = 'monitor';
    // 设置表
    protected $table = 'edition_one';
    // 设置表名
    protected $name = 'edition';
=======
    protected $connection = 'conversion';
    // 设置表
    protected $table = 'cvsmsg_one';
    // 设置表名
    protected $name = 'monitor';
>>>>>>> 618b839 (更新部分接口)
    // 设置主键
    protected $id = 'id';

    // 保存json字段
    protected $json = ['city'];
<<<<<<< HEAD

    // 定义全局的查询范围 搭配下面的声明查询条件函数
    // protected $globalScope = ['status'];

    // 可以设置初始化代码，使用static静态方法
    /* protected static function init()
    {
        echo '初始化phptable模型！';
    } */

    //  模型的字段设置   在模型端把数据整理好
    /* public function getUserName($id)
    {
        $obj = $this->find($id);
        return $obj->getAttr('name');
    } */

    // 模型获取器
    public function getEnableAttr($value)
    {
        $enable  = [-1 => '删除', 0 => '禁用', 1 => '启用', 2 => '待审核'];
        return $enable[$value];
    }

    // 模型修改器  新增更新时触发
    /* public function setEmailAttr($value)
    {
        return strtoupper($value);
    } */

    // 模型搜索器    模糊查询
    /*  public function searchNameAttr($query, $value, $data)
    {
        $query->where('name', 'like', '%' . $value . '%');
    }
    public function searchCreateTimeAttr($query, $value, $data)
    {
        $query->whereBetweenTime('create_time', $value[0], $value[1]);
    } */

    // 模型的查询范围
    /* public function scopeTest($query, $value)
    {
        $query->where('id', '>', 5)->page($value['pages'], $value['limit']);
    } */
    // 声明查询条件函数
    /* public function scopeStatus($query)
    {
        $query->where('status', 1);
    } */
=======
>>>>>>> 618b839 (更新部分接口)
}
