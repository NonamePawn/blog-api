<?php


namespace app\admin\model;


use think\Model;
use app\admin\model\Article as ArticleModel;

class Category extends Model
{
    // 一对多关联
    public function article()
    {
        return $this->hasMany(ArticleModel::class, 'c_id', 'id');
    }
}