<?php

namespace app\controller;

use app\BaseController;
use app\model\Landing;
use think\facade\Db;

class LandingCt extends BaseController
{
    public function index()
    {
        return 'index';
    }

    // 新增 落地页
    public function append()
    {
        $req = request()->param('data');
        $exist = Landing::wherelike('url', '%' . $req['landingurl'] . '%')->find();
        if (isset($exist)) {
            return ressend(201, '该落地页链接已存在！');
        } else {
            $sql = new Landing();
            // $gourps = $sql->Group()->find($req['group']);
            $data = [
                'url'         =>   $req['landingurl'],
                'uid'         =>   $req['group'],
                'remarks'     =>   $req['remarks'],
                'delivery'    =>   $req['delivery'],
                'track'       =>   $req['track'],
                'enable'      =>   $req['open'],
            ];
            $sql->save($data);
            // $gourps->inc('total')->update();
            return ressend(200, '添加成功！');
        }
    }

    // 删除落地页
    public function dellanding()
    {
        $req = request()->param('id');
        $result = Landing::destroy($req);
        return ressend(200, '删除成功', $result);
    }
    public function dellandings()
    {
        $req = request()->param('arr');
        $result = Landing::destroy($req);
        return ressend(200, '删除成功', $result);
    }

    // 修改落地页
    public function updatelanding()
    {
        $req = request()->param('data');
        $exist = Landing::wherelike('url', '%' . $req['url'] . '%')
            ->where('id', '<>', $req['id'])
            ->find();
        if (isset($exist)) {
            return ressend(201, '该落地页链接已存在！');
        } else {
            $sql = Landing::find($req['id']);
            $sql->url        =     $req['url'];
            $sql->group      =     $req['group'];
            $sql->remarks    =     $req['remarks'];
            $sql->delivery   =     $req['delivery'];
            $sql->track      =     $req['track'];
            $sql->enable     =     $req['enable'];
            $sql->save();
            return ressend(200, '修改成功！');
        }
    }

    // 获取落地页
    public function getlanding()
    {
        $req = request()->param();
        $filter = $req['condition'];
        $where = [];
        if ($filter['group']) {
            $where[] = ['group', '=',  $filter['group']];
        }
        if ($filter['enable'] !== '') {
            $where[] = ['enable', '=',  $filter['enable']];
        }
        if ($filter['words']) {
            $where[] = ['url', 'like', '%' . $filter['words'] . '%'];
        }
        $page = isset($req['currentpage']) ? $req['currentpage'] : 1;
        $limit = isset($req['singlepage']) ? $req['singlepage'] : 10;
        $sql = Landing::page($page, $limit)->withoutField('total,neardate,cvscount')->where($where)->with(['Group' => function ($query) {
            $query->field('id,group');
        }])->select();
        $count = Landing::where($where)->count();
        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $sql,
            'count'    =>     $count
        ]);
    }
    // 单独url列表用于渲染菜单
    public function getlandingall()
    {
        $sql = Landing::field('id,url')->select();
        return ressend(200, '成功', $sql);
    }
    // url与列表的集合
    public function landingandgroup()
    {
        $sql = Landing::with(['cvslink' => function ($query) {
            $query->field('uid,visites');
        }])->select();
        return json($sql);
        $result = $sql->cvslink;
        return json($result);
    }

    // 单条落地页开启状态
    public function togglelanding()
    {
        $req = request()->param();
        Landing::update([
            'id'     =>    $req['id'],
            'enable' =>    $req['enable']
        ]);
        return ressend(200, '修改成功！');
    }

    // 获取落地页带分组附表
    public function landingwithgroup()
    {
        $req = request()->param();
        $filter = $req['condition'];
        $where = [];
        if ($filter['group']) {
            $where[] = ['group', '=',  $filter['group']];
        }
        if ($filter['words']) {
            $where[] = ['url', 'like',  '%' . $filter['words'] . '%'];
        }

        $page = isset($req['currentpage']) ? $req['currentpage'] : 1;
        $limit = isset($req['singlepage']) ? $req['singlepage'] : 10;
        $sql = Landing::page($page, $limit)->withoutField('total,neardate,cvscount,delivery,track,enable')->where($where)->with(['wxgroup' => function ($query) {
            $query->field('id,name');
        }])->select();
        $count = Landing::withoutField('total,neardate,cvscount')->where($where)->count();
        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $sql,
            'count'    =>     $count
        ]);
    }

    // 删除落地页绑定微信号
    public function unbinding()
    {
        $req = request()->param('id');
        $sql = Landing::find($req);
        $sql->gid     =   '';
        $sql->same    =   '';
        $sql->share   =   '';
        $sql->mclick  =   '';
        $sql->mtouch  =   '';
        $sql->pclick  =   '';
        $sql->pselect =   '';
        $sql->from    =   '';
        $sql->show    =   '';
        $sql->save();
        return ressend(200, '修改成功！');
    }

    // 批量删除
    public function unbindinglot()
    {
        $req = request()->param('arr');
        $sql = Landing::whereIn('id', $req)->save([
            'gid'     =>   '',
            'same'    =>   '',
            'share'   =>   '',
            'mclick'  =>   '',
            'mtouch'  =>   '',
            'pclick'  =>   '',
            'pselect' =>   '',
            'from'    =>   '',
            'show'    =>   ''
        ]);
        return ressend(200, '修改成功！', $sql);
    }

    // 修改落地页微信号信息
    public function changeweixin()
    {
        $req = request()->param('data');
        $sql = Landing::find($req['id']);

        $sql->erweima   =     $req['erweima'];
        $sql->from      =     $req['from'];
        $sql->gid       =     $req['group'];
        $sql->same      =     $req['same'];
        $sql->weixin    =     $req['weixin'];
        $sql->mclick    =     $req['mclick'];
        $sql->mtouch    =     $req['mtouch'];
        $sql->pclick    =     $req['pclick'];
        $sql->pselect   =     $req['pselect'];
        $sql->show      =     $req['show1'] || $req['show2'];
        $sql->share     =     $req['share'];
        $sql->save();
        return ressend(200, '修改成功！');
    }

    // 批量修改落地页微信号信息
    public function changelot()
    {
        $req = request()->param('arr');
        $data = request()->param('form');
        Landing::whereIn('id', $req)->save([
            'erweima'     =>   $data['erweima'],
            'from'        =>   $data['from'],
            'gid'         =>   $data['group'],
            'same'        =>   $data['same'],
            'weixin'      =>   $data['weixin'],
            'mclick'      =>   $data['mclick'],
            'mtouch'      =>   $data['mtouch'],
            'pclick'      =>   $data['pclick'],
            'pselect'     =>   $data['pselect'],
            'share'       =>   $data['share'],
            'show'        =>   $data['show1'] ? $data['show1'] : $data['show2']
        ]);
        return ressend(200, '修改成功！');
    }

    // 落地页排行
    public function landingrank()
    {
        $req = request()->param();
        $filter = $req['condition'];
        $where = [];
        $order = '';
        if ($filter['group']) {
            $where[] = ['uid', '=',  $filter['group']];
        }
        if ($filter['url']) {
            $where[] = ['url', 'like', '%' . $filter['url'] . '%'];
        }
        if ($filter['date1']) {
            $where[] = ['neardate', '>=',  $filter['date1']];
        }
        if ($filter['date2']) {
            $where[] = ['neardate', '<=',  $filter['date2']];
        }
        if ($filter['order']) {
            $order = $filter['order'];
        }
        $page = isset($req['currentpage']) ? $req['currentpage'] : 1;
        $limit = isset($req['singlepage']) ? $req['singlepage'] : 10;
        $sql = Landing::page($page, $limit)
            ->where($where)
            ->order($order, 'desc')
            ->with(['Group' => function ($query) {
                $query->field('id,group');
            }])
            ->Field('id,url,remarks,total,cvscount,fans,uid')
            ->select();
        $count = Landing::where($where)->count();
        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $sql,
            'count'    =>     $count
        ]);
    }


    // test
    public function gettest()
    {
        $map = ['cvstype', '=', '1'];
        $count = Landing::hasWhere('Cvslink', function ($query) use ($map) {
            $query->where('cvstype', '=', '1');
        })->count();

        return $count;
    }
}
