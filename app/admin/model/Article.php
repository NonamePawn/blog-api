<?php


namespace app\admin\model;


use app\admin\model\Category as CategoryModel;
use app\admin\model\Comment as CommentModel;
use think\Model;

class Article extends Model
{
    // 一对一关联
    public function category()
    {
        return $this->hasOne(CategoryModel::class, 'id', 'c_id')->bind(['name']);
    }

    // 一对多关联
    public function comment()
    {
       return $this->hasMany(CommentModel::class, 'a_id', 'id');
    }

}