<?php
/**
 * Created by PhpStorm.
 * Users: 11353
 * Date: 2020/8/7
 * Time: 21:06
 */

namespace app\common\controller;


use Firebase\JWT\JWT;
use think\Exception;
use think\facade\Request;
use think\Response;

class Base
{
    //生成标准API
    protected function create($data, $status=200, $msg='', $type='json')
    {

        $result = [
          //数据
          "data" => $data,
          //元数据
          "meta" => [
              //消息
              "msg"     => $msg,
              //状态码
              "status"  => $status
          ]
        ];
        //返回API接口
        return Response::create($result, $type);
    }


    //生成验签
    function signToken($uid){
        $key='!@#$%*&';         //这里是自定义的一个随机字串，应该写在config文件中的，解密时也会用，相当    于加密中常用的 盐  salt
        $token=array(
            "iss"=>$key,        //签发者 可以为空
            "aud"=>'',          //面象的用户，可以为空
            "iat"=>time(),      //签发时间
            "nbf"=>time()+3,    //在什么时候jwt开始生效  （这里表示生成3秒后才生效）
            "exp"=> time()+3600, //token 过期时间
            "data"=>[           //记录的userid的信息，这里是自已添加上去的，如果有其它信息，可以再添加数组的键值对
                'uid'=>$uid,
            ]
        );
        //  print_r($token);
        $jwt = JWT::encode($token, $key, "HS256");  //根据参数生成了 token
        return $jwt;
    }

    //获取token
    function getToken()
    {
        $info = Request::header();
        try
        {
            $token = $info['authorization'];
            return $token;
        }catch (Exception $exception)
        {
            return false;
        }

    }

    //验证token
    function checkToken($token){
        $key='!@#$%*&';
        $status=array("code"=>0);
        try {
            JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($token, $key, array('HS256')); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            $res['code']=1;
            $res['data']=$arr['data'];
            return $res;

        } catch(\Firebase\JWT\SignatureInvalidException $e) { //签名不正确
            $status['msg']="签名不正确";
            return $status;
        }catch(\Firebase\JWT\BeforeValidException $e) { // 签名在某个时间点之后才能用
            $status['msg']="token失效";
            return $status;
        }catch(\Firebase\JWT\ExpiredException $e) { // token过期
            $status['msg']="token失效";
            return $status;
        }catch(\Exception $exception) { //其他错误
            $status['msg']="未知错误";
            return $status;
        }
    }
}