<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;

class Weixin extends model
{
    // 设置库
    protected $connection = 'weixin';
    // 设置表
    protected $table = 'manage_wxnumber';
    // 设置表名
    protected $name = 'Weixin';
    // 设置主键
    protected $id = 'id';

    // 一对多关联
    public function Wxgroup()
    {
        return $this->belongsTo(Wxgroup::class, 'uid');
    }

    // 模型获取器
    public function getOnlineAttr($value)
    {
        $online  = [0 => false, 1 => true];
        return $online[$value];
    }
    public function getControlAttr($value)
    {
        $control  = [0 => '关闭', 1 => '按复制次数', 2 => '按时间段', 3 => '按上报到粉数', 4 => '按二维码长按识别数', 5 => '按数据上报成功'];
        return $control[$value];
    }
}
