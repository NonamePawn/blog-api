<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\common\controller\Admin;
use app\middleware\AdminCheck;
use think\Request;
use app\admin\model\User as UserModel;


class Login extends Admin
{
    // 只允许访问save方法
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
     * @param \think\Request $request
     * @return \think\Response
     * @throws \think\db\exception\DbException
     */
    public function save(Request $request)
    {
        // 获取数据
        $username = $request->param('username');
        $password = md5($request->param('password'));
        // 查询用户
        $user = UserModel::where(['username'=>$username, 'password'=>$password])->field(['id', 'power'])->findOrEmpty();
        // 验证用户
        if ($user->isEmpty())
        {
            return $this->create($user,204, '用户不存在');
        }
        else if ($user->getData('power') == '普通用户')
        {
            return $this->create($user,204, '权限不足');
        }
        else
        {
            // 更新登录信息
            $status = UserModel::where('id',$user->getData('id'))->update([
                'login_times'   =>  (new \think\DbManager)->raw('login_times+1'),
                'last_login_IP' =>  $request->ip()
            ]);
            if ($status)
            {
                //生成令牌
                $token = $this->signToken($user->getData('id'));
                $data = [
                    "token" => $token
                ];
                return $this->create($data, 200, '验证成功');
            }else
            {
                $data = [];
                return $this->create($data, 500, '获取令牌失败');
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
