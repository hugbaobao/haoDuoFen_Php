<?php

namespace app\controller;

use app\BaseController;
use app\model\Cvslink;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;

class CvslinkCt extends BaseController
{
    public function index()
    {
        return 'index';
    }

    // 新增
    public function append()
    {
        $req = request()->param('data');
        $sql = new Cvslink();
        $target = $sql->find($req['uid']);
        if (isset($target)) {
            return ressend(201, '该统计链接已存在！请编辑');
        } else {
            $data = [
                'uid'         =>   $req['uid'],
                'type'        =>   $req['type'],
                'cvstype'     =>   $req['cvstype'],
                'cvscount'    =>   $req['cvscount'],
                'cvsmode'     =>   $req['cvsmode'],
                'code'        =>   $req['code'],
            ];
            $sql->save($data);
            return ressend(200, '添加成功！');
        }
    }

    // 删除
    public function delcvs()
    {
        $req = request()->param();
        $result = Cvslink::destroy($req);
        return ressend(200, '删除成功', $result);
    }

    // 改
    public function updatecvs()
    {
        $req = request()->param('data');
        $sql = Cvslink::find($req['id']);
        $sql->cvstype    =     $req['cvstype'];
        $sql->cvscount   =     $req['cvscount'];
        $sql->cvsmode    =     $req['cvsmode'];
        $sql->type       =     $req['type'];
        $sql->code       =     $req['code'];
        $sql->save();
        return ressend(200, '修改成功！');
    }
    // 转化时长
    public function minsecond()
    {
        $req = request()->param('data');
        $sql = Cvslink::find($req['id']);
        $sql->second    =     $req['second'];
        $sql->save();
        return ressend(200, '修改成功！');
    }

    // 查
    public function getbelongs()
    {
        $req = request()->param();
        $filter = $req['condition'];
        $where = [];
        if ($filter['group']) {
            $where[] = ['group', '=', $filter['group']];
        }
        if ($filter['words']) {
            $where[] = ['url', 'like', '%' . $filter['words'] . '%'];
        }
        // return $where;
        $page = isset($req['currentpage']) ? $req['currentpage'] : 1;
        $limit = isset($req['singlepage']) ? $req['singlepage'] : 10;

        $result = Cvslink::hasWhere('landing', function ($query) use ($where) {
            $query->where($where);
        })->with(['landing' => function ($query) {
            $query->field('id,url,group');
        }])->page($page, $limit)->select();

        $count = Cvslink::hasWhere('landing', function ($query) use ($where) {
            $query->where($where);
        })->count();

        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $result,
            'count'    =>     $count
        ]);
    }

    // 转化率
    public function getcvsrate()
    {
        $req = request()->param();
        $filter = $req['condition'];
        $where = [];
        $map = [];
        if ($filter['group']) {
            $where[] = ['group', '=', $filter['group']];
        }
        if ($filter['url']) {
            $where[] = ['id', '=', $filter['url']];
        }
        if ($filter['words']) {
            $where[] = ['url', 'like', '%' . $filter['words'] . '%'];
        }
        if ($filter['cvstype']) {
            $map[] = ['cvstype', '=', $filter['cvstype']];
        }
        if ($filter['date1']) {
            $map[] = ['newtime', '>=',  $filter['date1']];
        }
        if ($filter['date2']) {
            $map[] = ['newtime', '<=',  $filter['date2']];
        }
        $page = isset($req['currentpage']) ? $req['currentpage'] : 1;
        $limit = isset($req['singlepage']) ? $req['singlepage'] : 10;

        $result = Cvslink::hasWhere('landing', function ($query) use ($where) {
            $query->where($where);
        })->with(['landing' => function ($query) {
            $query->field('id,url,group');
        }])->where($map)->page($page, $limit)->select();

        $count = Cvslink::hasWhere('landing', function ($query) use ($where) {
            $query->where($where);
        })->where($map)->count();

        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $result,
            'count'    =>     $count
        ]);
    }

    public function getbelongss()
    {
        $filter = request()->param();
        $where = [];
        if ($filter['group']) {
            $where[] = ['group', '=', $filter['group']];
        }
        if ($filter['words']) {
            $where[] = ['url', 'like', '%' . $filter['words'] . '%'];
        }
        // return json($where);
        $sql = Cvslink::hasWhere('landing', function ($query) use ($where) {
            $query->where($where);
        })->with(['landing' => function ($query) {
            $query->field('id,url,group');
        }])->select();

        /* $sql = Cvslink::hasWhere('landing', function ($query) use ($filter) {
            $query->where('group', '=', $filter['group']);
        })->with('landing')->select(); */
        return $sql;
    }
}
