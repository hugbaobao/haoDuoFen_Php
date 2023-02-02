<?php

namespace app\controller;

use app\BaseController;
use app\model\Cvstype;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;

class CvstypeCt extends BaseController
{
    public function index()
    {
        return 'index';
    }

    // 新增
    public function append()
    {
        $req = request()->param('data');
        $sql = new Cvstype();
        $exist = $sql->where('typeint', '=', $req['int'])->find();
        if ($exist) {
            return ressend(201, '该埋点已存在！请编辑');
        } else {
            $data = [
                'typename'       =>   $req['type'],
                'typeint'        =>   $req['int'],
            ];
            $sql->save($data);
            return ressend(200, '添加成功！');
        }
    }

    // 删除
    public function delcvstype()
    {
        $req = request()->param('id');
        $result = Cvstype::destroy($req);
        return ressend(200, '删除成功', $result);
    }

    // 改
    public function updatename()
    {
        $req = request()->param();
        $sql = Cvstype::find($req['id']);
        $sql->typename    =     $req['typename'];
        $sql->save();
        return ressend(200, '修改成功！');
    }

    // 查
    public function gettypelist()
    {
        $result = Cvstype::select();

        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $result,
        ]);
    }

    public function typelist()
    {
        $result = Cvstype::field('typename,typeint')->select();

        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $result,
        ]);
    }
}
