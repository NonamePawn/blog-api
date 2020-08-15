<?php

namespace app\common\controller;

use app\middleware\AdminCheck;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\Model;
use think\Request;
use think\Response;

class Admin extends Base
{
//    protected $middleware = [AdminCheck::class];


    /**
     * 显示资源列表
     * @param Model $model
     * @param string $msg
     * @param Request $request
     * @param string $filed
     * @param bool $isEach
     * @param array $associated
     * @return Response
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function adminIndex(Model $model, string $msg, Request $request, string $filed='', bool $isEach=false, array $associated=[])
    {
        $params = null;
        foreach ($request->param() as $key => $value)
        {
            $params[$key] = $value;
        }
        if ($isEach)
        {
            //遍历查询(适用于父子级关系列表)
            return $this->each($params,  $model, $msg, $filed, $associated);
        }else
        {
            //列表查询
            return $this->list($params, $model, $msg, $filed, $associated);
        }

    }

    /**
     * 遍历查询
     * @param $params
     * @param Model $model
     * @param string $msg
     * @param string $filed
     * @param array $associated
     * @return Response
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function each($params, $model, $msg, $filed, $associated)
    {
        // 分页查询
        if ($params)
        {
            $data['data'] = $model->with($associated)
                                  ->page($params['pageNum'],$params['pageSize'])
                                  ->where('p_id', '0')
                                  ->whereLike($filed, '%'.$params['query'].'%')
                                  ->select();
            $data['total'] = $model->where('p_id', '0')
                                   ->whereLike($filed, '%'.$params['query'].'%')
                                   ->select()
                                   ->count();
        }
        // 查询所有
        else
        {
            $data['data'] = $model->with($associated)->where('p_id', '0')->select();
            $data['total'] = $model->where('p_id', '0')->select()->count();
        }
        $data['data'] = $this->children($model, $data['data'], 1, $associated);
        return $this->create($data, 200, '获取'.$msg.'列表成功');
    }

    /**
     * 列表查询
     * @param $params
     * @param Model $model
     * @param string $msg
     * @param string $filed
     * @param array $associated
     * @return Response
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function list($params, $model, $msg, $filed, $associated)
    {
        // 分页查询
        if ($params)
        {
            $data['data'] = $model->with($associated)
                                  ->page($params['pageNum'],$params['pageSize'])
                                  ->whereLike($filed, '%'.$params['query'].'%')
                                  ->select();
            $data['total'] = $model->whereLike($filed, '%'.$params['query'].'%')
                                   ->select()
                                   ->count();
        }
        // 查询所有
        else
        {
            $data['data'] = $model->with($associated)->select();
            $data['total'] = $model->select()->count();
        }
        return $this->create($data, 200, '获取'.$msg.'列表成功');
    }


    /**
     * 遍历子级方法
     * @param Model $model
     * @param $parent
     * @param $level
     * @param $associated
     * @return Response
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function children(Model $model, $parent, $level, $associated)
    {
        foreach ($parent as $key => $value)
        {
            // 查询是否有子级
            $children = $model->with($associated)->where('p_id', $value['id'])->select();
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
                $this->children($model, $children, $level + 1, $associated);
            }
            // 绑定数据
            $parent[$key]['children'] = $children;
        }
        // 返回数据
        return $parent;
    }


    /**
     * 保存新建的资源
     * @param Model $model
     * @param Request $request
     * @param  string $msg
     * @return Response
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
     * @param Model $model
     * @param  int  $id
     * @param  string $msg
     * @return Response
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
     * @param Model $model
     * @param Request $request
     * @param  int  $id
     * @param  string $msg
     * @return Response
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
     * @param Model $model
     * @param  int  $id
     * @param  string $msg
     * @return Response
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

    /**
     * 删除指定资源并且删除其关联资源
     * @param Model $model
     * @param int $id
     * @param string $msg
     * @return Response
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function adminDeleteEach(Model $model, $id, string $msg)
    {
        return $this->deleteChildren($model, $model->where('id', $id)->find(), $msg);
    }


    /**
     * 遍历删除子级方法
     * @param Model $model
     * @param $parent
     * @param $msg
     * @return Response
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function deleteChildren($model, $parent, $msg)
    {
        $children = $model->where('p_id', $parent->id)->select();
        if ($children->isEmpty())
        {
            return $this->adminDelete($model, $parent->id, $msg);
        }
        forEach ($children as $key => $value)
        {
            // 查询是否有子级
            $grandchildren = $model->where('p_id', $value['id'])->select();
            if ($grandchildren->isEmpty())
            {
                $this->adminDelete($model, $value['id'], $msg);
                continue;
            }else
            {
                $this->deleteChildren($model, $value, $msg);
            }
        }
        return $this->adminDelete($model, $parent->id, $msg);
    }
}