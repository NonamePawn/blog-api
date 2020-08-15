<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\common\controller\Admin;
use think\Request;
use app\admin\model\User as UserModel;
use think\Response;

class Users extends Admin
{

    /**
     * @var UserModel
     */
    // user表
    private $model;
    /**
     * @var string
     */
    private $msg;
    /**
     * @var string
     */
    private $filed;

    public function __construct()
    {
        // 实例化模型对象
        $this->model = new UserModel;
        // 提示信息
        $this->msg = '用户';
        // 匹配字段
        $this->filed = 'username';
    }

    /**
     * 显示资源列表
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->adminIndex($this->model, $this->msg, $request, $this->filed);
    }

    /**
     * 保存新建的资源
     *
     * @param Request $request
     * @return Response
     */
    public function save(Request $request)
    {
        $data = [
            'username' => $request->param('username'),
            'password' => md5($request->param('password')),
            'email' => $request->param('email'),
            'last_login_IP' =>  $request->ip()
        ];
        $status = $this->model->save($data);
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
     * @return Response
     */
    public function read($id)
    {
        return $this->adminRead($this->model, $id, $this->msg);
    }

    /**
     * 保存更新的资源
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->model->find($id);
        foreach ($request->param() as $key => $value)
        {
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
     * @return Response
     */
    public function delete($id)
    {
        return $this->adminDelete($this->model, $id, $this->msg);
    }

}
