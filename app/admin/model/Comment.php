<?php


namespace app\admin\model;


use think\Model;
use app\admin\model\User as UserModel;
use app\admin\model\Article as ArticleModel;

class Comment extends Model
{
    // 一对一关联
    public function user()
    {
        return $this->hasOne(UserModel::class, 'id', 'u_id')->bind(['username']);
    }

    public function article()
    {
        return $this->hasOne(ArticleModel::class, 'id', 'a_id')->bind(['title']);
    }

    // 定义获取器
    public function getStatusAttr($value)
    {
        $status = [ 1 => true, 0 => false];
        return $status[$value];
    }

}