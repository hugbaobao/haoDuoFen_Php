<?php

namespace app\controller;

use app\BaseController;
use app\model\Weixin;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;

class WeixinCt extends BaseController
{
    public function index()
    {
        return 'index';
    }

    // 新增
    /* public function append()
    {
        $req = request()->param();
        $sql = new Monitor();
        $data = [
            'url'         =>   $req['url'],
            'cvsdate'     =>   $req['cvsdate'],
            'cvstime'     =>   $req['cvstime'],
            'stay'        =>   $req['stay'],
            'type'        =>   $req['type'],
            'target'      =>   $req['targetelement'],
            'city'        =>   $req['city'] = '' ? [] : $req['city'],
            'equipment'   =>   $req['equipment'],
            'rate'        =>   $req['rate'],
            'wx'          =>   $req['wx'],
            'search'      =>   $req['search'],
            'total'       =>   $req['total'],
        ];
        $result = $sql->save($data);
        return json($result);
    } */

    // 查(行为转化统计页)
    public function getweixin()
    {
        $req = request()->param();
        $filter = $req['condition'];
        $where = [];
        if ($filter['url']) {
            $where[] = ['url', '=', $filter['url']];
        }
        if ($filter['date1']) {
            $where[] = ['cvsdate', '>=',  $filter['date1']];
        }
        if ($filter['date2']) {
            $where[] = ['cvsdate', '<=',  $filter['date2']];
        }
        if ($filter['words']) {
            $where[] = ['url', 'like', $filter['words']];
        }
        $page = isset($req['currentpage']) ? $req['currentpage'] : 1;
        $limit = isset($req['singlepage']) ? $req['singlepage'] : 10;
        $sql = Weixin::page($page, $limit)
            ->where($where)
            ->Field('wxh,visits,copy,report')
            ->select();
        $count = Weixin::where($where)
            ->count();
        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $sql,
            'count'    =>     $count
        ]);
    }

    // 查(微信在线管理页)
    public function cotrweixin()
    {
        $req = request()->param();
        $filter = $req['condition'];
        $order = '';
        $where = [];
        $map = [];
        if ($filter['group1']) {
            $order = $filter['group1'];
        }
        if ($filter['group2']) {
            $where[] = ['name', '=', $filter['group2']];
        }
        if ($filter['words']) {
            $map[] = ['wxh', 'like', '%' . $filter['words'] . '%'];
        }
        switch ($filter['group3']) {
            case '0':
                $map[] = ['online', '=', 0];
                break;
            case '1':
                $map[] = ['online', '=', 1];
                break;
            case '2':
                $map[] = ['erweima', '=', null];
                break;
            case '3':
                $map[] = ['erweima', '<>', ''];
                break;
            default:
                break;
        }

        $page = isset($req['currentpage']) ? $req['currentpage'] : 1;
        $limit = isset($req['singlepage']) ? $req['singlepage'] : 10;

        $result = Weixin::hasWhere('Wxgroup', function ($query) use ($where) {
            $query->where($where);
        })->where($map)->with(['Wxgroup' => function ($query) {
            $query->field('id,name');
        }])->order($order, 'desc')
            ->page($page, $limit)
            ->select();

        $count = Weixin::hasWhere('Wxgroup', function ($query) use ($where) {
            $query->where($where);
        })->where($map)->count();

        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $result,
            'count'    =>     $count
        ]);
    }
}
