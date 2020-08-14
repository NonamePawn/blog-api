<?php


namespace app\admin\controller;

use app\admin\model\Manager as ManagerModel;
use app\common\controller\Admin;


class Manager extends Admin
{

    /**
     * @var ManagerModel
     */
    private $model;
    /**
     * @var string
     */
    private $msg;

    public function __construct()
    {
        // 实例化模型对象
        $this->model = new ManagerModel;
        // 提示信息
        $this->msg = '路径';
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
       return $this->adminEach($this->model, $this->msg);
    }
}