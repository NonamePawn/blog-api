# 1. 博客管理后台API接口文档

## 1.1 API接口说明

- 接口基准地址：http://127.0.0.1:8000/admin
- API认证统一使用Token认证
- 需要授权的API，必须在请求头里使用**Authorization**字段提供**token**令牌
- 使用HTTP Status Code 标识状态
- 数据返回格式统一使用JSON

### 1.1.1 支持的请求方法

- GET（SELECT）：从服务器取出资源（一项或多项）。
- POST（CREATE）：在服务器新建一个资源。
- PUT（UPDATE）：在服务器更新资源（客户端提供改变后的完整资源）。
- PATCH（UPDATE）：在服务器更新资源（客户端提供改变的属性）。
- DELETE（DELETE）：从服务器删除资源。
- HEAD：获取资源的元数据。
- OPTIONS：获取信息，关于资源的哪些属性是客户端可以改变的。

###  1.1.2. 通用返回状态说明

| *状态码* | *含义*                | *说明*                                              |
| -------- | --------------------- | --------------------------------------------------- |
| 200      | OK                    | 请求成功                                            |
| 201      | CREATED               | 创建成功                                            |
| 204      | DELETED               | 删除成功                                            |
| 400      | BAD REQUEST           | 请求的地址不存在或者包含不支持的参数                |
| 401      | UNAUTHORIZED          | 未授权                                              |
| 403      | FORBIDDEN             | 被禁止访问                                          |
| 404      | NOT FOUND             | 请求的资源不存在                                    |
| 422      | Unprocesable entity   | [POST/PUT/PATCH] 当创建一个对象时，发生一个验证错误 |
| 500      | INTERNAL SERVER ERROR | 内部错误                                            |



## 1.2 登录

### 1.2.1登录接口验证

- 请求路径：login
- 请求方法：post
- 请求参数

| 参数名   | 参数说明 | 备注     |
| -------- | -------- | -------- |
| username | 用户名   | 不能为空 |
| password | 密码     | 不能为空 |

- 响应参数

| 参数名 | 参数说明 |
| ------ | -------- |
| token  | 令牌     |

- 响应数据

```json
{
    "data": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiIhQCMkJSomIiwiYXVkIjoiIiwiaWF0IjoxNTk2ODEwMDc2LCJuYmYiOjE1OTY4MTAwNzksImV4cCI6MTU5NjgxMDI3NiwiZGF0YSI6eyJ1aWQiOnsicG93ZXIiOiJcdTdiYTFcdTc0MDZcdTU0NTgifX19.xs0jHRiXknMfz81ZjnttjKD9ECSWR36yC5JW05VhKSc"
    },
    "meta": {
        "msg": "验证成功",
        "status": "200"
    }
}
```



##  1.3. 用户管理

### 1.3.1. 用户数据列表

- 请求路径：users
- 请求方法：get
- 请求参数

| 参数名   | 参数说明     | 备注     |
| -------- | ------------ | -------- |
| query    | 查询参数     | 可以为空 |
| pagenum  | 当前页码     | 不能为空 |
| pagesize | 每页显示条数 | 不能为空 |

- 响应参数

| 参数名    | 参数说明     | 备注 |
| --------- | ------------ | ---- |
| totalpage | 总记录数     |      |
| pagenum   | 当前页码     |      |
| users     | 用户数据集合 |      |



###  1.3.2. 添加用户

- 请求路径：users
- 请求方法：post
- 请求参数

| 参数名   | 参数说明 | 备注     |
| -------- | -------- | -------- |
| username | 用户名称 | 不能为空 |
| password | 用户密码 | 不能为空 |
| email    | 邮箱     | 不能为空 |

- 响应数据

```json
{
    "data": true,
    "meta": {
        "msg": "用户创建成功",
        "status": 201
    }
}
```



###  1.3.3. 根据 ID 查询用户信息

- 请求路径：users/:id
- 请求方法：get
- 请求参数

| 参数名 | 参数说明 | 备注                  |
| ------ | -------- | --------------------- |
| id     | 用户 ID  | 不能为空`携带在url中` |

- 响应数据

```json
{
    "data": {
        "id": 1,
        "username": "NonamePawn",
        "password": "f36148615a1d5393770febff60615b1d",
        "email": "www.1135386358@qq.com",
        "register_time": "2020-08-07 17:25:24",
        "last_login_time": "2020-08-08 21:03:43",
        "login_times": 16,
        "last_login_IP": "127.0.0.1",
        "power": "管理员"
    },
    "meta": {
        "msg": "查询用户成功",
        "status": 200
    }
}
```



### 编辑用户提交

- 请求路径：users/:id
- 请求方法：put
- 请求参数

| 参数名   | 参数说明 | 备注                        |
| -------- | -------- | --------------------------- |
| id       | 用户 id  | 不能为空 `参数是url参数:id` |
| email    | 邮箱     | 可以为空                    |
| username | 用户名   | 可以为空                    |
| password | 密码     | 可以为空                    |

- 响应数据

```json
{
    "data": 1,
    "meta": {
        "msg": "更新用户信息成功",
        "status": 200
    }
}
```



###  1.3.6. 删除单个用户

- 请求路径：users/:id
- 请求方法：delete
- 请求参数

| 参数名 | 参数说明 | 备注                       |
| ------ | -------- | -------------------------- |
| id     | 用户 id  | 不能为空`参数是url参数:id` |

- 响应参数
- 响应数据

```json
{
    "data": null,
    "meta": {
        "msg": "删除用户成功",
        "status": 200
    }
}
```