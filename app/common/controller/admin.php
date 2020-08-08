<?php
/**
 * Created by PhpStorm.
 * User: 11353
 * Date: 2020/8/8
 * Time: 17:31
 */

namespace app\common\controller;

use app\middleware\AdminCheck;

class admin extends Base
{
    protected $middleware = [AdminCheck::class];
}