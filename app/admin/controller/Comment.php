<?php


namespace app\admin\controller;


use app\common\controller\Admin;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\Request;
use app\admin\model\Comment as CommentModel;
use think\Response;

class Comment extends Admin
{
    /**
     * @var CommentModel
     */
    private $model;
    /**
     * @var string
     */
    private $msg;
    /**
     * @var bool
     */
    private $isEach;
    /**
     * @var string
     */
    private $filed;
    /**
     * @var string[]
     */
    private $associated;

    public function __construct()
    {
        // 实例化模型对象
        $this->model = new CommentModel;
        // 提示信息
        $this->msg = '评论';
        // 是否遍历查询
        $this->isEach = true;
        // 匹配字段
        $this->filed = 'a_id';
        // 关联模型
        $this->associated = ['user', 'article'];
    }

    /**
     * 显示资源列表
     * @param Request $request
     * @return Response
     */
    public function index(Request  $request)
    {
        return $this->adminIndex($this->model, $this->msg, $request, $this->filed, $this->isEach, $this->associated);
    }


    /**
     * 保存新建的资源
     *
     * @param Request $request
     * @return Response
     */
    public function save(Request $request)
    {
        return $this->adminSave($this->model, $request, $this->msg);
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
        return $this->adminUpdate($this->model, $request, $id, $this->msg);
    }

    /**
     * 删除指定资源
     *
     * @param int $id
     * @return Response
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function delete($id)
    {
        return $this->adminDeleteEach($this->model, $id, $this->msg);
    }
}