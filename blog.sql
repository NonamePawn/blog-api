-- 创建捐助表
CREATE TABLE `donate`(
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '捐助人ID',
  name varchar(20) NOT NULL COMMENT '捐助人昵称',
  amount decimal(10,2) NOT NULL COMMENT '捐助金额',
  time DATETIME DEFAULT now() COMMENT '捐助时间',
  remarks VARCHAR(100) DEFAULT '无' COMMENT '备注'
);

-- 创建关于表
CREATE TABLE `about`(
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '关于ID',
  options VARCHAR(20) NOT NULL COMMENT'选项',
  content text,
  update_time TIMESTAMP COMMENT '最后修改时间'
);

-- 创建管理表
CREATE TABLE `manager`(
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '管理ID',
  name VARCHAR(20) NOT NULL COMMENT '管理名称',
  path VARCHAR(20) NOT NULL COMMENT '路径',
  p_id INT default 0 COMMENT '父级管理ID'
);

-- 创建分类表
CREATE TABLE `category`(
  id INT PRIMARY KEY AUTO_INCREMENT COMMENT '分类ID',
  name VARCHAR(15) NOT NULL UNIQUE KEY COMMENT '分类名',
  create_time DATETIME DEFAULT now() COMMENT '创建时间',
  p_id SMALLINT default 0 COMMENT '父级分类ID'
) engine=INNODB;

-- 创建用户表
CREATE TABLE `user` (
  id INT PRIMARY KEY AUTO_INCREMENT COMMENT '用户ID',
  username VARCHAR(20) NOT NULL COMMENT '用户名不为空',
  password CHAR(32)  NOT NULL COMMENT '密码加密',
  email VARCHAR(32) NOT NULL COMMENT '邮箱',
  register_time DATETIME DEFAULT now() COMMENT '注册时间',
  last_login_time TIMESTAMP COMMENT '上次登录时间',
  login_times INT DEFAULT 1 COMMENT '登录总次数',
  last_login_IP VARCHAR(15) COMMENT '上次登录的IP地址',
  power ENUM('管理员','普通用户') DEFAULT '普通用户' NOT NULL COMMENT '用户权限',
  status INT DEFAULT 1 COMMENT '状态'
) engine=INNODB;


-- 创建文章表
CREATE TABLE `article`(
  id INT PRIMARY KEY AUTO_INCREMENT COMMENT '文章ID',
  title VARCHAR(15) NOT NULL COMMENT '标题',
  introduce VARCHAR(100) NOT NULL COMMENT '介绍',
  content text NOT NULL COMMENT '内容',
  create_time DATETIME DEFAULT now() COMMENT '创建时间',
  update_time TIMESTAMP COMMENT '最后修改时间',
  readings INT DEFAULT 0 COMMENT '浏览数',
  likes INT DEFAULT 0 COMMENT '点赞数',
  c_id INT NOT NULL COMMENT '所属分类ID'
) engine=INNODB;

-- 创建评论表
CREATE TABLE `comment`(
  id INT PRIMARY KEY AUTO_INCREMENT COMMENT '评论ID',
  content VARCHAR(200) NOT NULL COMMENT '评论内容',
  time DATETIME DEFAULT now() COMMENT '评论时间',
  status INT DEFAULT 1 COMMENT '状态',
  p_id INT DEFAULT 0 COMMENT '父级评论ID',
  a_id INT NOT NULL COMMENT '所属文章ID',
  u_id INT NOT NULL COMMENT '所属用户ID'
) engine=INNODB;





-- 插入模拟数据
INSERT INTO `about`
(options,content) VALUES
('blog','博客博客博客博客博客博客博客博客博客博客博客博客博客博客博客博客博客博客博客博客博客');
INSERT INTO `about`
(options,content) VALUES
('blogger','博主博主博主博主博主博主博主博主博主博主博主博主博主博主博主博主博主博主博主博主博主');
INSERT INTO `about`
(options,content) VALUES
('theme','主题主题主题主题主题主题主题主题主题主题主题主题主题主题主题主题主题主题主题主题主题');
INSERT INTO `about`
(options,content) VALUES
('donate','投食投食投食投食投食投食投食投食投食投食投食投食投食投食投食投食投食投食投食投食投食');
INSERT INTO `donate`
(name,amount) VALUES
('NonamePawn',10);
INSERT INTO `user`
(username,password,email,register_time,last_login_IP,power)  VALUES
('NonamePawn','f36148615a1d5393770febff60615b1d','www.1135386358@qq.com',now(),'127.0.0.1',1);
INSERT INTO `user`
(username,password,email,register_time,last_login_IP,power)  VALUES
('zhansan','f36148615a1d5393770febff60615b1d','www.147948645@126.com',now(),'127.0.0.1',2);
INSERT INTO `user`
(username,password,email,register_time,last_login_IP,power,status)  VALUES
('lisi','f36148615a1d5393770febff60615b1d','www.18135415@126.com',now(),'127.0.0.1',2,0);