<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\common\controller\admin;
use think\Request;
use app\admin\model\User as UserModel;

class Users extends admin
{

    public function __construct()
    {
        $this->user = new UserModel;
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return $this->create(UserModel::select(), '200', '获取用户列表成功');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = [
            'username' => $request->param('username'),
            'password' => md5($request->param('password')),
            'email' => $request->param('email'),
            'last_login_IP' =>  $request->ip()
        ];
        try
        {
            $status = $this->user->save($data);
        }catch (\Exception $exception)
        {
            return $this->create(0, 204, '用户已存在');
        }

        if ($status)
        {
            return $this->create($status, 201, '用户创建成功');
        }
        else
        {
            return $this->create($status, 500, '用户创建失败');
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
        $user = UserModel::find($id);
        if ($user)
        {
            return $this->create($user,200,'查询用户成功');
        }else
        {
            return $this->create([],204,'查询用户失败');
        }
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
        foreach (array_reverse($request->param()) as $key => $value)
        {
            if ($key == 'id')
            {
                $user = UserModel::find($value);
            }
            if ($key == 'password')
            {
                $user->$key = md5($value);
            }else
            {
                $user->$key = $value;
            }
        }
        if ($user->save())
        {
            return $this->create(1,200, '更新用户信息成功');
        }else
        {
            return $this->create(0, 204, '更新用户信息失败');
        }

    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $user = UserModel::find($id);
        if ($user)
        {
            $user->delete();
            return $this->create(null, 200, '删除用户成功');
        }else
        {
            return $this->create(null, 200, '用户不存在');

        }
    }
}
