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

<<<<<<< HEAD
    public function modelinsert()
    {
        $my = new Monitor();

        /* $data = [
            'name' => '张三',
            'phone' => '1777546',
            'status' => '1',
        ];
        $my->save($data); */

        /*  $my ->name = '张三';
        $my ->phone = '111111111';
        $my ->status = '0';
        $my ->save(); */

        /* $my->replace()->save([
            'id' => 17,
            'name' => '王二麻子',
            'phone' => '333333333',
            'status' => '1',
        ]); */

        /* $my->allowField(['name','phone'])
           ->save([
            'name' => '李四',
            'phone' => '222222222',
            'status' => '1',
        ]); */

        $my = Monitor::create([
            'name' => '银时',
            'phone' => '444444444',
            'status' => '2',
        ], ['name', 'phone', 'status'], false);
    }

    public function modeldel()
    {
        /*   $user = Phptable::find('19');
        $user->delete(); */

        // Phptable::destroy('20');
        // Phptable::destroy(['20']);

        // Phptable::where('id','=',21)->delete();

        Monitor::destroy(function ($query) {
            $query->where('id', '=', 23);
        });
    }

    // 模型的数据更新
    public function modelupdate()
    {
        /*     $user = Phptable::find(24);
        $user->name = '金木';
        $user->save(); */

        /* $user = Phptable::where('name', '=' , '张三')->find();
        $user->allowField(['name'])->save([
            'name' => '鸣人',
        ]); */

        /* $list = [
            ['id'=>3, 'name'=>'雏田', 'status'=>0],
            ['id'=>5, 'name'=>'李白', 'status'=>1],
            ['id'=>8, 'name'=>'曹操', 'status'=>2]
            ];
            $user =new Phptable();
            dump($user->saveAll($list)); */

        /* return Phptable::update([
                  'id'=>9,
                  'name'=>'宁次',
                  'status'=>0
            ]); */
        return Monitor::update([
            'name' => '宁次次',
            'status' => 1
        ], ['id' => 9], ['name']);
    }

    // 模型的数据查询
    public function modelselect()
    {
        /* $user = Phptable::find(5);
        return json($user); */

        /* $user = Phptable::find(999);
        return json($user); */

        /* $user = Phptable::findOrEmpty(999);
        if($user->isEmpty()){
            echo '数据为空！';
        }else{
            return json($user);
        } */

        /* $user = Phptable::where('name','=','鸣人')->find();
        return json($user); */

        /* $user = Phptable::select([1,3,5,7,9]);
        foreach($user as $key => $data){
            echo $data->id.'<br />';
                } */

        /*$user = Phptable::where('status = 1 AND id >3')->limit(5)->order('id','desc')->select();
        return json($user); */

        // return Phptable::where('name','鸣人')->value('id');
        /* $user = Phptable::whereIn('name',['曹操','鸣人'])->column('id','status');
        return json($user); */

        // return Phptable::getByName('宁次次');

        // 分批处理数据
        /*  Phptable::chunk(3,function($query){
            foreach($query as $query){
                echo $query->name;
            }
            echo '<br />';
        }); */

        foreach (Monitor::cursor() as $user) {
            echo $user->name;
            echo '<br />';
        }
    }

    // 模型的字段设置
    /*  public function schema () {
        $user = new Phptable();
    //   return $user->getUsername(5);

        echo $user->name;

    } */

    // 模型获取器
    /*  public function testAttr() {
        $user = Phptable::find(5);
        return $user->status;
    } */

    // 模糊搜索 第一个数组参数，限定搜索器的字段，第二个则是表达式值
    /*   public function withsearch() {
        $result = Phptable::withsearch(['name','create_time'],[
            'name'       =>  '次',
            'create_time'=>  ['2000-1-1','2024-1-1']
            ])->select();
         return $result;
    } */

    // 模型的查询范围
    /*  public function scope () {
        $sql = Phptable::scope('test',[
                               'pages'  => 2,
                               'limit' => 5])
                               ->select();
        return $sql;
    } */
    // 取消全局查询条件
    //取消所有全局查询
    // UserModel::withoutGlobalScope()
    // 取消这个查询的部分全局查询
    // UserModel::withoutGlobalScope(['status'])
=======
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
>>>>>>> 618b839 (更新部分接口)
}
