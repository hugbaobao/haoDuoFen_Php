<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;

class Cvslink extends model
{
    // 设置库
    protected $connection = 'monitor';
    // 设置表
    protected $table = 'cvsmsg_link';
    // 设置表名
    protected $name = 'Cvslink';
    // 设置主键
    protected $id = 'id';

    // 一对一相对关联
    public function Landing()
    {
        return $this->belongsTo(Landing::class, 'uid', 'id');
    }


    // 模型获取器
    /* public function getTypeAttr($value)
    {
        $type  = [1 => '点击', 2 => '长按识别', 3 => '微信复制按钮点击', 4 => '微信打开按钮点击', 5 => '咨询按钮点击', 6 => '下载按钮点击', 7 => '购买按钮点击', 8 => '注册按钮点击', 9 => '登录按钮点击', 10 => '拨打电话按钮点击', 11 => '短信按钮点击', 12 => '加入购物车按钮点击', 13 => '地图按钮点击', 14 => 'QQ咨询按钮点击', 15 => '抽奖按钮点击', 16 => '投票按钮点击', 17 => '表单确认提交按钮点击',];
        return $type[$value];
    } */
    public function getCvstypeAttr($value)
    {
        $Cvstype  = [1 => '点击', 2 => '长按', null => ''];
        return $Cvstype[$value];
    }
    /* public function getCvscountAttr($value)
    {
        $Cvscount  = [0 => '多次触发计多次', 1 => '多次触发计一次', null => ''];
        return $Cvscount[$value];
    } */
    public function getcvsmodeAttr($value)
    {
        $cvsmode  = [0 => '模糊匹配', 1 => '精确匹配', null => ''];
        return $cvsmode[$value];
    }
}
