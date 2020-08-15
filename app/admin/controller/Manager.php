<?php


namespace app\admin\controller;

use app\admin\model\Manager as ManagerModel;
use app\common\controller\Admin;
use think\Request;
use think\Response;


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
    /**
     * @var bool
     */
    private $isEach;
    /**
     * @var string
     */
    private $filed;

    public function __construct()
    {
        // 实例化模型对象
        $this->model = new ManagerModel;
        // 提示信息
        $this->msg = '路径';
        // 是否遍历查询
        $this->isEach = true;
        // 匹配字段
        $this->filed = '';
    }

    /**
     * 显示资源列表
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request  $request)
    {
        return $this->adminIndex($this->model, $this->msg, $request, $this->filed, $this->isEach);

    }
}