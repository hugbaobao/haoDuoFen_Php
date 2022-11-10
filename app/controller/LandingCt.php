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
<<<<<<< HEAD
        $exist = Landing::wherelike('url', '%' . $req['url'] . '%')->find();
=======
        $exist = Landing::wherelike('url', '%' . $req['landingurl'] . '%')->find();
>>>>>>> 618b839 (更新部分接口)
        if (isset($exist)) {
            return ressend(201, '该落地页链接已存在！');
        } else {
            $sql = new Landing();
            $data = [
                'url'         =>   $req['landingurl'],
                'group'       =>   $req['group'],
                'remarks'     =>   $req['remarks'],
                'delivery'    =>   $req['delivery'],
                'track'       =>   $req['track'],
                'enable'      =>   $req['open'],
            ];
            $sql->save($data);
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
        return $result;
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
<<<<<<< HEAD
    public function gettotal()
    {
        $result = Landing::select()->count();
        return $result;
    }
=======
>>>>>>> 618b839 (更新部分接口)
    public function getlanding()
    {
        $req = request()->param();
        $filter = $req['condition'];
        $where = [];
        if ($filter['group']) {
<<<<<<< HEAD
            $where['group'] = $filter['group'];
        }
        if ($filter['enable']) {
            $where['enable'] = $filter['enable'];
        }
        if ($filter['words']) {
            $where['url'] = ['like', '%' . $filter['words'] . '%'];
        }
        return $where;
        $page = isset($req['currentpage']) ? $req['currentpage'] : 1;
        $limit = isset($req['singlepage']) ? $req['singlepage'] : 10;
        $sql = Landing::page($page, $limit)->withoutField('total,neardate,cvscount')->where($where)->select();
        return json([
            'code'     =>     200,
            'msg'      =>     '获取第' . $page . '页' . $limit . '条',
            'data'     =>     $sql
        ]);
    }

    // 分组

=======
            $where[] = ['group', '=',  $filter['group']];
        }
        if ($filter['enable'] !== '') {
            $where[] = ['enable', '=',  $filter['enable']];
        }
        if ($filter['words']) {
            $where[] = ['url', 'like', '%' . $filter['words'] . '%'];
        }
        // return $where;
        $page = isset($req['currentpage']) ? $req['currentpage'] : 1;
        $limit = isset($req['singlepage']) ? $req['singlepage'] : 10;
        $sql = Landing::page($page, $limit)->withoutField('total,neardate,cvscount')->where($where)->select();
        $count = Landing::withoutField('total,neardate,cvscount')->where($where)->count();
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

    // 分组
>>>>>>> 618b839 (更新部分接口)
    public function modelinsert()
    {
        $my = new Landing();

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

        $my = Landing::create([
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

        Landing::destroy(function ($query) {
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
        return Landing::update([
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

        foreach (Landing::cursor() as $user) {
            echo $user->name;
            echo '<br />';
        }
    }

    // 模糊搜索 第一个数组参数，限定搜索器的字段，第二个则是表达式值
    /*   public function withsearch() {
        $result = Phptable::withsearch(['name','create_time'],[
            'name'       =>  '次',
            'create_time'=>  ['2000-1-1','2024-1-1']
            ])->select();
         return $result;
    } */
}
