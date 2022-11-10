<?php

namespace app\controller;

use app\BaseController;
use app\model\Wxgroup;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;

class WxgroupCt extends BaseController
{
    public function index()
    {
        return 'index';
    }

    // 新增
    public function append()
    {
        $req = request()->param('data');
        $exist = Wxgroup::where('name', $req['group'])->find();
        if (isset($exist)) {
            return ressend(201, '该分组名称已存在！');
        } else {
            $sql = new Wxgroup();
            $data = [
                'name'         =>   $req['group'],
                'remarks'      =>   $req['remark'],
            ];
            $sql->save($data);
            return ressend(200, '添加成功！');
        }
    }

    // 删
    public function delgroup()
    {
        $req = request()->param('id');
        $result = Wxgroup::destroy($req);
        return ressend(200, '删除成功！', $result);
    }

    // 改
    public function update()
    {
        $req = request()->param('forms');
        $exist = Wxgroup::wherelike('name', '%' . $req['group'] . '%')
            ->where('id', '<>', $req['id'])
            ->find();
        if (isset($exist)) {
            return ressend(201, '该分组名称已存在！');
        } else {
            $result = Wxgroup::find($req['id']);
            $result->name    =  $req['group'];
            $result->remarks  =  $req['remark'];
            $res = $result->save();
            return ressend(200, '修改成功', $res);
        }
    }

    // 查
    public function get_wxgroup()
    {
        $req = request()->param();
        $filter = $req['condition'];
        $where = [];
        if ($filter) {
            $where[] = ['name', 'like', '%' . $filter . '%'];
        }
        $page = isset($req['currentpage']) ? $req['currentpage'] : 1;
        $limit = isset($req['singlepage']) ? $req['singlepage'] : 10;
        $sql = Wxgroup::page($page, $limit)
            ->where($where)
            ->select();
        $count = Wxgroup::where($where)
            ->count();
        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $sql,
            'count'    =>     $count
        ]);
    }

    // 获取单独分组列表所有用于渲染表单
    public function get_grouplist()
    {
        $sql = Wxgroup::withoutField('count,remarks')->select();
        return ressend(200, '成功', $sql);
    }
}
