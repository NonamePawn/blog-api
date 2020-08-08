<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\common\controller\admin;
use think\facade\Db;
use think\Request;
use app\admin\model\User as UserModel;


class Login extends admin
{

    protected $middleware = [
        AdminCheck::class => ['except' => ['save'] ],
    ];

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {

        $username = $request->param('username');
        $password = md5($request->param('password'));
        $user = UserModel::where(['username'=>$username, 'password'=>$password])->field(['id', 'power'])->findOrEmpty();
        if ($user->isEmpty())
        {
            return $this->create($user,204, '用户不存在');
        }
        else if ($user->power == '普通用户')
        {
            return $this->create($user,204, '权限不足');
        }
        else
        {
            $IP = $request->ip();
            $status = UserModel::where('id', $user->id)->update([
                'login_times'   =>  Db::raw('login_times+1'),
                'last_login_IP' =>  $IP
            ]);
            if ($status)
            {
                //生成令牌
                $token = $this->signToken($user->id);
                $data = [
                    "token" => $token
                ];
                return $this->create($data, 200, '验证成功');
            }else
            {
                $data = [];
                return $this->create($data, 204, '获取令牌失败');
            }


        }

    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
