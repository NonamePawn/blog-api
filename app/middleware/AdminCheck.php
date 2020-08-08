<?php
declare (strict_types = 1);

namespace app\middleware;

use app\common\controller\Base;

class AdminCheck extends Base
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        $token = $this->getToken();
        //没有token
        if (!$token)
        {
            return $this->create(null, 401, '没有令牌');
        }
        //验证token
        $res = $this->checkToken($token);
        if ($res['code'])
        {
            return $next($request);
        }else {
            return $this->create(null, 401, $res['msg']);
        }
    }
}
