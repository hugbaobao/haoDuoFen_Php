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
    public function landing()
    {
        return $this->belongsTo(Landing::class, 'uid');
    }

    // 模型获取器
    public function getTypeAttr($value)
    {
        $type  = [1 => '点击', 2 => '长按识别'];
        return $type[$value];
    }
    public function getCvstypeAttr($value)
    {
        $Cvstype  = [1 => '点击', 2 => '长按'];
        return $Cvstype[$value];
    }
    public function getCvscountAttr($value)
    {
        $Cvscount  = [0 => '多次触发计多次', 1 => '多次触发计一次'];
        return $Cvscount[$value];
    }
    public function getcvsmodeAttr($value)
    {
        $cvsmode  = [0 => '模糊匹配', 1 => '精确匹配'];
        return $cvsmode[$value];
    }
}
