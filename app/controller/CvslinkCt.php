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
        $target = $sql->where('uid', '=', $req['uid'])->find();
        if (isset($target) && $target->type == $req['type']) {
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
            $where[] = ['uid', '=', $filter['group']];
        }
        if ($filter['words']) {
            $where[] = ['url', 'like', '%' . $filter['words'] . '%'];
        }
        $page = isset($req['currentpage']) ? $req['currentpage'] : 1;
        $limit = isset($req['singlepage']) ? $req['singlepage'] : 10;

        $result = Cvslink::hasWhere('landing', function ($query) use ($where) {
            $query->where($where);
        })->with(['landing' => function ($query) {
            $query->field('id,url,uid')->with(['Group' => function ($query) {
                $query->field('id,group');
            }]);
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

    public function getcvsrate()
    {
        $req = request()->param();
        $filter = $req['condition'];
        $where = [];
        $map = [];
        if ($filter['group']) {
            $where[] = ['uid', '=', $filter['group']];
        }
        if ($filter['url']) {
            $where[] = ['id', '=', $filter['url']];
        }
        if ($filter['words']) {
            $where[] = ['url', 'like', '%' . $filter['words'] . '%'];
        }
        if ($filter['date1']) {
            $where[] = ['neardate', '>=',  $filter['date1']];
        }
        if ($filter['date2']) {
            $where[] = ['neardate', '<=',  $filter['date2']];
        }
        if ($filter['cvstype']) {
            $map[] = ['cvstype', '=', $filter['cvstype']];
        }
        $page = isset($req['currentpage']) ? $req['currentpage'] : 1;
        $limit = isset($req['singlepage']) ? $req['singlepage'] : 10;

        $result = Cvslink::hasWhere('Landing', function ($query) use ($where) {
            $query->where($where);
        })->where($map)
            ->with(['Landing' => function ($query) {
                $query->field('id,uid,url,neardate,cvscount,total')->with(['Group' => function ($query) {
                    $query->field('id,group');
                }]);
            }])
            ->field('cvstype')
            ->page($page, $limit)
            ->select();
        $count = Cvslink::hasWhere('Landing', function ($query) use ($where) {
            $query->where($where);
        })->where($map)->count();

        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $result,
            'count'    =>     $count
        ]);
    }

    // 落地页查询
    public function forlandingget()
    {
        $req = request()->param();
        return json($req);
        $where = [];
        if ($req['words']) {
            $where[] = ['url', 'like', '%' . $req['words'] . '%'];
        }
        // $where[] = ['url', 'like', '%www.888.com%'];
        $where[] = ['enable', '=', 1];

        $result = Cvslink::hasWhere('landing', function ($query) use ($where) {
            $query->where($where);
        })->with([
            'landing' => function ($query) {
                $query->field('id,gid')->with(['Wxgroup' => function ($query) {
                    $query->field('id')->with(['Weixin' => function ($query) {
                        $query->field('id,uid,wxh,erweima,wxname,online,level')->where('online', '=', 1);
                    }]);
                }]);
            }
        ])->find();
        return $result;
    }
}
