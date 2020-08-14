<?php

namespace app\admin\model;


use think\Model;

class User extends Model
{

    // 定义获取器
    public function getStatusAttr($value)
    {
        $status = [ 1 => true, 0 => false];
        return $status[$value];
    }

    public function getPowerAttr($value)
    {
        return $value;
    }

    public function getIdAttr($value)
    {
        return $value;
    }

    // 定义修改器
    public function setStatusAttr($value)
    {
        if ($value)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
}