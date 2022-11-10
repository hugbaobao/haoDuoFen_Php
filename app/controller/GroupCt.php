<?php

namespace app\controller;

use app\BaseController;
use app\model\Group;
use think\facade\Db;

class GroupCt extends BaseController
{
    public function index()
    {
        return 'index';
    }

    // 新增
    public function append()
    {
        $req = request()->param('forms');
        $exist = Group::where('group', 'like', '%' . $req['group'] . '%')->find();
        if (isset($exist)) {
            return ressend(201, '该分组名称已存在！');
        } else {
            $sql = new Group();
            $data = [
                'group'      =>   $req['group'],
                'remarks'    =>   $req['remarks'],
            ];
            $sql->save($data);
            return ressend(200, '添加成功！');
        }
    }

    // 删除
    public function delgroup()
    {
        $req = request()->param('id');
        $result = Group::destroy($req);
        return ressend(200, '删除成功！', $result);
    }

    // 改
    public function update()
    {
        $req = request()->param('forms');
        $result = Group::find($req['id']);
        $result->group    =  $req['group'];
        $result->remarks  =  $req['remarks'];
        $res = $result->save();
        return ressend(200, '修改成功', $res);
    }

    // 获取
<<<<<<< HEAD
    public function gettotal()
    {
        $result = Group::select()->count();
        return ressend(200, '成功', $result);
    }
=======
>>>>>>> 618b839 (更新部分接口)
    public function getgroup()
    {
        $req = request()->param();
        $page = isset($req['currentpage']) ? $req['currentpage'] : 1;
        $limit = isset($req['singlepage']) ? $req['singlepage'] : 10;
        $sql = Group::page($page, $limit)->select();
<<<<<<< HEAD
        return ressend(200, '成功', $sql);
    }
    // 获取所有用于渲染表单
=======
        $count = Group::count();
        return ressend(200, '成功', [
            'data'  =>   $sql,
            'count'  =>   $count
        ]);
    }
    // 获取单独分组列表所有用于渲染表单
>>>>>>> 618b839 (更新部分接口)
    public function getgroupall()
    {
        $sql = Group::withoutField('remarks,total')->select();
        return ressend(200, '成功', $sql);
    }
<<<<<<< HEAD
=======

    // 搜索的分组
    public function groupsearch()
    {
        $req = request()->param('words');
        $page = isset($req['currentpage']) ? $req['currentpage'] : 1;
        $limit = isset($req['singlepage']) ? $req['singlepage'] : 10;
        $sql = Group::wherelike('group', '%' . $req . '%')
            ->page($page, $limit)
            ->withoutField('remarks,total')
            ->select();
        $count = Group::wherelike('group', '%' . $req . '%')
            ->withoutField('remarks,total')
            ->count();
        return ressend(200, '成功', [
            'data'  =>   $sql,
            'count'  =>   $count
        ]);
    }
>>>>>>> 618b839 (更新部分接口)
}
