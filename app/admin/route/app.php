<?php
use think\facade\Route;

//后台用户登录模块
Route::resource('login', 'Login')->only(['save']);

//后台路径管理模块
Route::resource('Manager', 'Manager')->only(['index']);

//后台用户管理模块
Route::resource('users', 'Users');

//后台赞助管理模块
Route::resource('donate', 'Donate');

//后台分类管理模块
Route::resource('category', 'Category');

//后台评论管理模块
Route::resource('comment', 'Comment');

//后台关于管理模块
Route::resource('about', 'About');

//后台文章管理模块
Route::resource('article', 'Article');
