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
    }

    // 查
    public function getmonitor()
    {
        $req = request()->param();
        $filter = $req['condition'];
        $where = [];
        $map = [];
        if ($filter['class']) {
            $where[] = ['type', '=',  $filter['class']];
        }
        if ($filter['group']) {
            $where[] = ['group', '=',  $filter['group']];
        }
        if ($filter['date1']) {
            $where[] = ['cvsdate', '>',  $filter['date1']];
        }
        if ($filter['date2']) {
            $where[] = ['cvsdate', '<',  $filter['date2']];
        }
        if ($filter['url']) {
            $where[] = ['url', '=', $filter['url']];
        }
        if ($filter['words']) {
            $map[] = ['url', 'like', '%' . $filter['words'] . '%'];
            $map[] = ['wx', 'like', '%' . $filter['words'] . '%'];
        }
        // return $map;
        // order,source,state字段未启用
        $page = isset($req['currentpage']) ? $req['currentpage'] : 1;
        $limit = isset($req['singlepage']) ? $req['singlepage'] : 10;
        $sql = Monitor::page($page, $limit)
            ->where($where)
            ->where(function ($query) use ($map) {
                $query->whereOr($map);
            })
            ->select();
        $count = Monitor::where($where)
            ->where(function ($query) use ($map) {
                $query->whereOr($map);
            })
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
