<?php


namespace app\admin\controller;


use app\common\controller\Admin;
use think\Request;
use app\admin\model\Donate as DonateModel;

class Donate extends Admin
{
    /**
     * @var DonateModel
     */
    private $model;
    /**
     * @var string
     */
    private $msg;

    public function __construct()
    {
        // 实例化模型对象
        $this->model = new DonateModel;
        // 提示信息
        $this->msg = '赞助人';
    }

    /**
     * 显示资源列表
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function index(Request $request)
    {
        return $this->adminIndex($this->model, $this->msg, $request, 'name');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        return $this->adminSave($this->model, $request, $this->msg);
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        return $this->adminRead($this->model, $id, $this->msg);
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
        return $this->adminUpdate($this->model, $request, $id, $this->msg);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        return $this->adminDelete($this->model, $id, $this->msg);
    }
}