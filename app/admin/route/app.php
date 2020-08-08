<?php
use think\facade\Route;
//后台用户登录模块
Route::resource('login', 'Login')->only(['save']);
//后台用户管理模块
Route::resource('users', 'Users');