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
    public function append()
    {
        $req = request()->param('data');
        $sql = new Weixin();
        $exist = Weixin::where('wxh', $req['wxh'])->find();
        if (isset($exist)) {
            return ressend(201, '该微信号已存在！');
        }
        $data = [
            'wxh'         =>   $req['wxh'],
            'wxname'      =>   $req['wxname'],
            'erweima'     =>   $req['erweima'],
            'sex'         =>   $req['sex'],
            'uid'         =>   $req['wxgroup'],
            'online'      =>   $req['online'],
            'control'     =>   $req['auto'],
            'level'       =>   $req['level'],
            'remarks'     =>   $req['remarks'],
        ];
        $result = $sql->save($data);
        return ressend(200, '成功', $result);
    }

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

    // 改二维码
    public function updateQR()
    {
        $req = request()->param('data');
        $sql = Weixin::find($req['id']);
        $sql->erweima   =   $req['sendimg'];
        $sql->save();
        return ressend(200, '成功');
    }
    // 删除二维码
    public function deleteQR()
    {
        $req = request()->param('id');
        $sql = Weixin::find($req);
        $sql->erweima   =   '';
        $sql->save();
        return ressend(200, '成功');
    }

    // 改
    public function updateweixin()
    {
        $req = request()->param('data');
        // return $req;
        $result = Weixin::find($req['id']);
        $result->wxh     =  $req['wxh'];
        $result->wxname  =  $req['wxname'];
        $result->erweima =  $req['erweima'];
        $result->sex     =  $req['sex'];
        $result->uid     =  $req['wxgroup'];
        $result->online  =  $req['online'];
        $result->control =  $req['auto'];
        $result->level   =  $req['level'];
        $result->remarks =  $req['remarks'];
        $res = $result->save();
        return ressend(200, '修改成功', $res);
    }

    // 删除微信
    public function delweixin()
    {
        $req = request()->param('arr');
        Weixin::destroy($req);
        return ressend(200, '删除成功');
    }

    // 改在线状态
    public function changeonline()
    {
        $req = request()->param();
        $sql = Weixin::find($req['id']);
        $sql->online   =   $req['online'];
        $sql->save();
        return ressend(200, '成功');
    }

    // 改权重
    public function changelevel()
    {
        $req = request()->param();
        $sql = Weixin::find($req['id']);
        $sql->level   =   $req['level'];
        $sql->save();
        return ressend(200, '成功');
    }
}
