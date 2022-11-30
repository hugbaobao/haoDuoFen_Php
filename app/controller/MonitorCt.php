<?php

namespace app\controller;

use app\BaseController;
use app\model\Monitor;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;

class MonitorCt extends BaseController
{
    public function index()
    {
        return 'index';
    }

    // 新增
    public function append()
    {
        $req = request()->param();
        $sql = new Monitor();
        $data = [
            'uid'         =>   $req['url'],
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
        $sql->save($data);
        $sql->Landing()->where('id', '=', $req['url'])->inc('total', 1)->inc('cvscount', 1)->update();
        $sql->Weixin()->where('wxh', '=', $req['wx'])->inc('visits')->inc('copy')->update();
    }

    public function inctotal()
    {
        $req = request()->param();
        $sql = new Monitor();
        $sql->Landing()->where('id', '=', $req['url'])->inc('total', 1)->update();
        $sql->Weixin()->where('wxh', '=', $req['wx'])->inc('visits')->update();
    }

    /*  public function test()
    {
        $req = request()->param();
        $sql = new Monitor();
        $sql->Landing()->where('id', '=', $req['url'])->inc('total', 1)->update();
        $result = $sql->Weixin()->where('wxh', '=', $req['wx'])->inc('visits')->inc('copy', 1)->update();
        return $result;
    } */

    // 查
    public function getmonitor()
    {
        $req = request()->param();
        $filter = $req['condition'];
        $where = [];
        $wheredate = [];
        $map = [];
        if ($filter['url']) {
            $where[] = ['cvsmsg_one.uid', '=', $filter['url']];
        }
        if ($filter['date1']) {
            $where[] = ['cvsdate', '>=', $filter['date1']];
        }
        if ($filter['date2']) {
            $where[] = ['cvsdate', '<=', $filter['date2']];
        }
        if ($filter['state']) {
            $where[] = ['report', '=',  $filter['state']];
        }
        if ($filter['words']) {
            $map[] = ['url', 'like', '%' . $filter['words'] . '%'];
        }
        if ($filter['group']) {
            $map[] = ['gid', '=',  $filter['group']];
        }
        // order,source,state等部分字段未启用
        $page = isset($req['currentpage']) ? $req['currentpage'] : 1;
        $limit = isset($req['singlepage']) ? $req['singlepage'] : 10;

        $sql = Monitor::hasWhere('Landing', function ($query) use ($map) {
            $query->where($map);
        })->where($where)->with(['Landing' => function ($query) {
            $query->field('id,uid,url,remarks')
                ->with(['Group' => function ($query) {
                    $query->field('id,group');
                }]);
        }])
            ->page($page, $limit)
            ->order('cvsdate', 'desc')
            ->select();

        $count = Monitor::hasWhere('Landing', function ($query) use ($map) {
            $query->where($map);
        })->where($where)
            ->count();
        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $sql,
            'count'    =>     $count
        ]);
    }

    // 首页渲染
    public function monitorhome()
    {
        $arr = $this->get_weeks();
        $data = [];
        foreach ($arr as $day) {
            $pvs = Monitor::wherelike('cvsdate', $day . '%')->count();
            $uvs = Monitor::wherelike('cvsdate', $day . '%')->count('distinct city->cip');
            $counts = Monitor::wherelike('cvsdate', $day . '%')->where('cvstime', '<>', '')->count('distinct city->cip');
            $data[] = [$day, [
                'pv'    =>   $pvs,
                'uv'    =>   $uvs,
                'count' =>   $counts
            ]];
        }
        return ressend(200, '获取成功！', $data);
    }

    /**
     * 获取最近七天所有日期
     */
    function get_weeks($time = '', $format = 'Y-m-d')
    {
        $time = $time != '' ? $time : time();
        //组合数据
        $date = [];
        for ($i = 0; $i <= 6; $i++) {
            $date[$i] = date($format, strtotime('+' . $i - 7 . ' days', $time));
        }
        return $date;
    }
}
