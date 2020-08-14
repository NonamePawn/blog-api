<?php
/**
 * Created by PhpStorm.
 * User: 11353
 * Date: 2020/8/8
 * Time: 17:31
 */

namespace app\common\controller;

use app\middleware\AdminCheck;
use think\Model;
use think\Request;

class Admin extends Base
{
//    protected $middleware = [AdminCheck::class];


    /**
     * 显示资源列表
     * @param \think\Model $model
     * @param string $msg
     * @param \think\Request $request
     * @param string $filed
     * @param array $comment
     * @return \think\Response
     */
    public function adminIndex(Model $model, string $msg, Request $request, string $filed)
    {
        $params = null;
        foreach ($request->param() as $key => $value)
        {
            $params[$key] = $value;
        }
        // 分页查询
        if ($params)
        {
            $data['data'] = $model->page($params['pageNum'],$params['pageSize'])->whereLike($filed, '%'.$params['query'].'%')->select();
            $data['total'] = $model->select()->count();
            return $this->create($data, 200, '获取'.$msg.'列表成功');

        }
        // 查询所有
        else
        {
            $data['data'] = $model->select();
            $data['total'] = $model->select()->count();
            return $this->create($data, 200, '获取'.$msg.'列表成功');
        }
    }


    /**
     * 遍历显示资源列表
     * @param \think\Model $model
     * @param string $msg
     * @return \think\Response
     */
    public function adminEach(Model $model, string $msg)
    {
        $data = null;
        $children = null;
        // 获取第一级数据
        $data = $model->where('p_id', '0')->select();
        // 遍历子级
        $data = $this->children($model,$data, 1);
        return $this->create($data, 200, '获取'.$msg.'列表成功');
    }

    /**
     * 遍历子级方法
     * @param \think\Model $model
     * @param $parent
     * @param $level
     * @return \think\Response
     */
    public function children(Model $model, $parent, $level)
    {
        foreach ($parent as $key => $value)
        {
            // 查询是否有子级
            $children = $model->where('p_id', $value['id'])->select();
            // 设置等级水平
            $parent[$key]['level'] = $level;
            // 没有子级
            if ($children->isEmpty())
            {
                // 跳过本次循环
                continue;
            }else
            {
                // 继续遍历子级
                $this->children($model, $children, $level + 1);
            }
            // 绑定数据
            $parent[$key]['children'] = $children;
        }
        // 返回数据
        return $parent;
    }


    /**
     * 保存新建的资源
     * @param  \think\Model  $model
     * @param  \think\Request  $request
     * @param  string $msg
     * @return \think\Response
     */
    public function adminSave(Model $model,Request $request, string $msg)
    {
        foreach ($request->param() as $key => $value)
        {
            $model->$key = $value;
        }
        if ($model->save())
        {
            return $this->create(1, 201, ''.$msg.'创建成功');
        }
        else
        {
            return $this->create(0, 500, ''.$msg.'创建失败');
        }

    }


    /**
     * 显示指定的资源
     * @param  \think\Model  $model
     * @param  int  $id
     * @param  string $msg
     * @return \think\Response
     */
    public function adminRead(Model $model, $id, string $msg)
    {
        $row = $model->find($id);
        if ($row)
        {
            return $this->create($row,200,'查询'.$msg.'成功');
        }else
        {
            return $this->create([],204,'查询'.$msg.'失败');
        }
    }


    /**
     * 保存更新的资源
     * @param  \think\Model  $model
     * @param  \think\Request  $request
     * @param  int  $id
     * @param  string $msg
     * @return \think\Response
     */
    public function adminUpdate(Model $model ,Request $request, $id, string $msg)
    {
        $row = $model->find($id);
        foreach ($request->param() as $key => $value)
        {
            $row->$key = $value;
        }
        if ($row->save())
        {
            return $this->create(1,200, '更新'.$msg.'信息成功');
        }else
        {
            return $this->create(0, 204, '更新'.$msg.'信息失败');
        }

    }


    /**
     * 删除指定资源
     * @param  \think\Model  $model
     * @param  int  $id
     * @param  string $msg
     * @return \think\Response
     */
    public function adminDelete(Model $model, $id, string $msg)
    {
        $row = $model->find($id);
        if ($row)
        {
            $row->delete();
            return $this->create(null, 200, '删除'.$msg.'成功');
        }else
        {
            return $this->create(null, 200, ''.$msg.'不存在');

        }
    }
}