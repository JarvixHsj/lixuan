# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.7.11)
# Database: thinkadmin
# Generation Time: 2017-06-26 01:01:47 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table lx_agent
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lx_agent`;

CREATE TABLE `lx_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL COMMENT '商品id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `super_id` int(11) NOT NULL COMMENT '上级id\n',
  `super_level` int(11) DEFAULT NULL COMMENT '上级代理等级',
  `level` int(11) NOT NULL COMMENT '代理级别（首席CEO，核心总监，总代，一级，特约，）',
  `empower_sn` varchar(45) DEFAULT NULL COMMENT '授权号',
  `status` varchar(45) DEFAULT '1' COMMENT '状态',
  `image` varchar(45) DEFAULT NULL COMMENT '授权图\n',
  `created_at` int(12) DEFAULT NULL COMMENT '授权时间',
  `invitation` tinyint(1) DEFAULT '1' COMMENT '1=邀请，2=后台授权添加',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='代理产品关系表';

LOCK TABLES `lx_agent` WRITE;
/*!40000 ALTER TABLE `lx_agent` DISABLE KEYS */;

INSERT INTO `lx_agent` (`id`, `product_id`, `user_id`, `super_id`, `super_level`, `level`, `empower_sn`, `status`, `image`, `created_at`, `invitation`)
VALUES
	(1,3,1,0,NULL,1,'A0020','1',NULL,1498234705,2),
	(2,3,11,0,NULL,1,'A0021','1',NULL,1498234750,2),
	(3,2,11,0,NULL,2,'B0001','1',NULL,1498235526,2),
	(4,3,13,0,NULL,3,'C0001','1',NULL,1498235554,2),
	(5,3,14,0,NULL,3,'C0002','1',NULL,1498235660,2),
	(6,2,15,0,NULL,4,'D0001','1',NULL,1498236214,2),
	(7,3,16,0,NULL,3,'C0003','1',NULL,1498236282,2),
	(8,2,17,0,NULL,1,'A0022','1',NULL,1498236346,2),
	(9,3,18,0,NULL,3,'C0004','1',NULL,1498236793,2),
	(10,2,19,0,NULL,2,'B0002','1',NULL,1498236972,2);

/*!40000 ALTER TABLE `lx_agent` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table lx_product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lx_product`;

CREATE TABLE `lx_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '商品名称',
  `intro` varchar(255) NOT NULL,
  `image` varchar(120) DEFAULT NULL COMMENT '产品表',
  `change_at` int(12) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `is_delete` tinyint(1) DEFAULT '1' COMMENT '0=删除，1=正常使用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品表';

LOCK TABLES `lx_product` WRITE;
/*!40000 ALTER TABLE `lx_product` DISABLE KEYS */;

INSERT INTO `lx_product` (`id`, `name`, `intro`, `image`, `change_at`, `status`, `is_delete`)
VALUES
	(2,'我是第二个','直接诶时收到皮肤这。。。这是第二个描述','/static/upload/5fc9a2a78274ef88/4f5f06bd751a63d9.png',1497882748,1,1),
	(3,'测试产品图片数据库屋恩替','违法建设路口附近类似款大幅 ','/static/admin/image/product/2017-06-19-22-49-08t.png',1497883748,1,1);

/*!40000 ALTER TABLE `lx_product` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table lx_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lx_user`;

CREATE TABLE `lx_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `mobile` varchar(45) NOT NULL,
  `idcard` varchar(32) DEFAULT NULL COMMENT '身份证',
  `wechat_openid` varchar(45) DEFAULT NULL,
  `wechat_no` varchar(30) DEFAULT NULL COMMENT '微信号',
  `wechat_nickname` varchar(45) DEFAULT NULL,
  `wechat_avatar` varchar(100) DEFAULT NULL,
  `wechat_province` varchar(15) DEFAULT NULL,
  `wechat_city` varchar(15) DEFAULT NULL,
  `reg_at` int(12) DEFAULT NULL COMMENT '注册时间',
  `reg_ip` varchar(45) DEFAULT NULL COMMENT '注册ip',
  `sex` tinyint(1) DEFAULT NULL COMMENT '性别0男，1女',
  `detail_address` varchar(120) DEFAULT NULL COMMENT '详细地址',
  `status` tinyint(1) DEFAULT NULL COMMENT '用户状态0冻结  1正常',
  `birthday` int(12) DEFAULT NULL,
  `login_at` int(12) DEFAULT NULL,
  `login_num` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='代理用户表';

LOCK TABLES `lx_user` WRITE;
/*!40000 ALTER TABLE `lx_user` DISABLE KEYS */;

INSERT INTO `lx_user` (`id`, `username`, `password`, `mobile`, `idcard`, `wechat_openid`, `wechat_no`, `wechat_nickname`, `wechat_avatar`, `wechat_province`, `wechat_city`, `reg_at`, `reg_ip`, `sex`, `detail_address`, `status`, `birthday`, `login_at`, `login_num`)
VALUES
	(1,'智恒','e10adc3949ba59abbe56e057f20f883e','13692763394',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),
	(11,'HONG','e10adc3949ba59abbe56e057f20f883e','13414707510',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1498234750,NULL,NULL,NULL,NULL,NULL,NULL,0),
	(12,'测试','e10adc3949ba59abbe56e057f20f883e','13411749395',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1498235526,NULL,NULL,NULL,NULL,NULL,NULL,0),
	(13,'测试2','e10adc3949ba59abbe56e057f20f883e','13450003015',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1498235554,NULL,NULL,NULL,NULL,NULL,NULL,0),
	(14,'ceshiweq','e10adc3949ba59abbe56e057f20f883e','13416416373',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1498235660,NULL,NULL,NULL,NULL,NULL,NULL,0),
	(15,'测试特约代理','e10adc3949ba59abbe56e057f20f883e','13411749394',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1498236214,NULL,NULL,NULL,NULL,NULL,NULL,0),
	(16,'代理一级','e10adc3949ba59abbe56e057f20f883e','13286956951',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1498236282,NULL,NULL,NULL,NULL,NULL,NULL,0),
	(17,'核心总监代理','e10adc3949ba59abbe56e057f20f883e','13416416371',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1498236346,NULL,NULL,NULL,NULL,NULL,NULL,0),
	(18,'测试添加成功跳转','e10adc3949ba59abbe56e057f20f883e','13450003014',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1498236793,NULL,NULL,NULL,NULL,NULL,NULL,0),
	(19,'ceshiweq','e10adc3949ba59abbe56e057f20f883e','13450003013',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1498236972,NULL,NULL,NULL,NULL,NULL,NULL,0);

/*!40000 ALTER TABLE `lx_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table lx_user_audit
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lx_user_audit`;

CREATE TABLE `lx_user_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_invite_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '邀请人id',
  `product_id` int(11) DEFAULT NULL,
  `wechat_no` varchar(45) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `idcard` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '审核状态：0=待审核  1=已审核',
  `is_through` tinyint(1) DEFAULT '0' COMMENT '是否通过：0=待审核，1=已通过，2=未通过。',
  `address` varchar(100) DEFAULT NULL,
  `share_no` char(32) DEFAULT NULL,
  `invite_level` tinyint(1) DEFAULT NULL COMMENT '邀请等级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='代理审核表';

LOCK TABLES `lx_user_audit` WRITE;
/*!40000 ALTER TABLE `lx_user_audit` DISABLE KEYS */;

INSERT INTO `lx_user_audit` (`id`, `user_invite_id`, `user_id`, `product_id`, `wechat_no`, `mobile`, `idcard`, `password`, `status`, `is_through`, `address`, `share_no`, `invite_level`)
VALUES
	(1,7,11,2,'123','13692763394','441324199612142319','e10adc3949ba59abbe56e057f20f883e',0,0,'123456','3ea24b4830ac45f6fb3e95ad7e060394',5);

/*!40000 ALTER TABLE `lx_user_audit` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table lx_user_invite
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lx_user_invite`;

CREATE TABLE `lx_user_invite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(45) DEFAULT NULL,
  `level` tinyint(1) NOT NULL COMMENT '授权等级',
  `start_at` int(12) DEFAULT NULL COMMENT '开始时间',
  `end_in` int(12) DEFAULT NULL COMMENT '结束时间',
  `click_num` int(11) DEFAULT '0' COMMENT '分享打开次数',
  `share_no` char(32) NOT NULL COMMENT '分享唯一号',
  `share_url` varchar(255) DEFAULT NULL COMMENT '分享组成的连接',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='代理用户邀请记录表';

LOCK TABLES `lx_user_invite` WRITE;
/*!40000 ALTER TABLE `lx_user_invite` DISABLE KEYS */;

INSERT INTO `lx_user_invite` (`id`, `user_id`, `product_id`, `product_name`, `level`, `start_at`, `end_in`, `click_num`, `share_no`, `share_url`)
VALUES
	(1,11,3,'测试产品图片数据库屋恩替',3,1498316432,1498320032,0,'73ade95d1e969be7bc7b4f1b3bd78f74',NULL),
	(2,11,2,'我是第二个',3,1498318361,1498321961,0,'8d6eae5f9625d614a1cc6144d8a4bbab',NULL),
	(3,11,2,'我是第二个',4,1498318464,1498322064,0,'0e1a5bb17f0fc918703c3fa0c7f902c4',NULL),
	(4,11,3,'测试产品图片数据库屋恩替',5,1498318731,1498322331,0,'62f0bcd1ac4470f4e9aafc16c8dba288',NULL),
	(5,11,3,'测试产品图片数据库屋恩替',2,1498318903,1498322503,0,'e7582bf7177d061e0ad91ad9482836e1',NULL),
	(6,11,3,'测试产品图片数据库屋恩替',4,1498318920,1498322520,0,'01d964fb4cd6dadd71864b5798b81fc7',NULL),
	(7,11,2,'我是第二个',5,1498319777,1498323377,19,'3ea24b4830ac45f6fb3e95ad7e060394',NULL);

/*!40000 ALTER TABLE `lx_user_invite` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table system_auth
# ------------------------------------------------------------

DROP TABLE IF EXISTS `system_auth`;

CREATE TABLE `system_auth` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL COMMENT '权限名称',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '状态(1:禁用,2:启用)',
  `sort` smallint(6) unsigned DEFAULT '0' COMMENT '排序权重',
  `desc` varchar(255) DEFAULT NULL COMMENT '备注说明',
  `create_by` bigint(11) unsigned DEFAULT '0' COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_system_auth_title` (`title`) USING BTREE,
  KEY `index_system_auth_status` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统权限表';

LOCK TABLES `system_auth` WRITE;
/*!40000 ALTER TABLE `system_auth` DISABLE KEYS */;

INSERT INTO `system_auth` (`id`, `title`, `status`, `sort`, `desc`, `create_by`, `create_at`)
VALUES
	(51,'普通用户（测试）',1,0,'测试（第一个权限）',0,'2017-06-11 22:57:57');

/*!40000 ALTER TABLE `system_auth` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table system_auth_node
# ------------------------------------------------------------

DROP TABLE IF EXISTS `system_auth_node`;

CREATE TABLE `system_auth_node` (
  `auth` bigint(20) unsigned DEFAULT NULL COMMENT '角色ID',
  `node` varchar(200) DEFAULT NULL COMMENT '节点路径',
  KEY `index_system_auth_auth` (`auth`) USING BTREE,
  KEY `index_system_auth_node` (`node`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色与节点关系表';

LOCK TABLES `system_auth_node` WRITE;
/*!40000 ALTER TABLE `system_auth_node` DISABLE KEYS */;

INSERT INTO `system_auth_node` (`auth`, `node`)
VALUES
	(51,'admin'),
	(51,'admin/node'),
	(51,'admin/node/index'),
	(51,'admin/user'),
	(51,'admin/user/index'),
	(51,'admin/user/add');

/*!40000 ALTER TABLE `system_auth_node` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table system_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `system_config`;

CREATE TABLE `system_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '配置编码',
  `value` varchar(500) DEFAULT NULL COMMENT '配置值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

LOCK TABLES `system_config` WRITE;
/*!40000 ALTER TABLE `system_config` DISABLE KEYS */;

INSERT INTO `system_config` (`id`, `name`, `value`)
VALUES
	(148,'site_name','Think.Admin Demo'),
	(149,'site_copy','广州楚才信息科技有限公司 © 2014~2017'),
	(164,'storage_type','local'),
	(165,'storage_qiniu_is_https','1'),
	(166,'storage_qiniu_bucket','static'),
	(167,'storage_qiniu_domain','static.ctolog.com'),
	(168,'storage_qiniu_access_key',''),
	(169,'storage_qiniu_secret_key',''),
	(170,'storage_qiniu_region','华东'),
	(173,'app_name','Think.Admin'),
	(174,'app_version','1.00 dev'),
	(176,'browser_icon','https://think.ctolog.com/static/upload/f47b8fe06e38ae99/08e8398da45583b9.png'),
	(184,'wechat_appid',''),
	(185,'wechat_appsecret',''),
	(186,'wechat_token',''),
	(187,'wechat_encodingaeskey',''),
	(188,'wechat_mch_id',''),
	(189,'wechat_partnerkey',''),
	(194,'wechat_cert_key',''),
	(196,'wechat_cert_cert',''),
	(197,'tongji_baidu_key','aa2f9869e9b578122e4692de2bd9f80f'),
	(198,'tongji_cnzz_key','1261854404'),
	(199,'storage_oss_bucket',''),
	(200,'storage_oss_keyid',''),
	(201,'storage_oss_secret',''),
	(202,'storage_oss_domain',''),
	(203,'storage_oss_is_https','1'),
	(204,'lixuan_level_a','23'),
	(205,'lixuan_level_b','3'),
	(206,'lixuan_level_c','5'),
	(207,'lixuan_level_d','2');

/*!40000 ALTER TABLE `system_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table system_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `system_log`;

CREATE TABLE `system_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '操作者IP地址',
  `node` char(200) NOT NULL DEFAULT '' COMMENT '当前操作节点',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '操作人用户名',
  `action` varchar(200) NOT NULL DEFAULT '' COMMENT '操作行为',
  `content` text NOT NULL COMMENT '操作内容描述',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统操作日志表';

LOCK TABLES `system_log` WRITE;
/*!40000 ALTER TABLE `system_log` DISABLE KEYS */;

INSERT INTO `system_log` (`id`, `ip`, `node`, `username`, `action`, `content`, `create_at`)
VALUES
	(5128,'127.0.0.1','admin/login/index','admin','系统管理','用户登录系统成功','2017-06-11 21:51:28'),
	(5129,'127.0.0.1','admin/login/index','ceshi1（普通用户--测试1权限）','系统管理','用户登录系统成功','2017-06-11 23:09:36'),
	(5130,'127.0.0.1','admin/login/index','admin','系统管理','用户登录系统成功','2017-06-14 22:14:34'),
	(5131,'127.0.0.1','wechat/tags/sync','admin','微信管理','同步全部微信粉丝标签成功','2017-06-18 19:32:41'),
	(5132,'127.0.0.1','html/login/index','','代理用户管理','用户13692763394登录系统成功','2017-06-21 22:42:35'),
	(5133,'127.0.0.1','html/login/index','','代理用户管理','用户13692763394登录系统成功','2017-06-21 23:00:13'),
	(5134,'127.0.0.1','html/login/index','','代理用户管理','用户13692763394登录系统成功','2017-06-21 23:00:35'),
	(5135,'127.0.0.1','html/login/index','','代理用户管理','用户13692763394登录系统成功','2017-06-21 23:01:18'),
	(5136,'127.0.0.1','admin/login/index','admin','系统管理','用户登录系统成功','2017-06-21 23:43:08'),
	(5137,'127.0.0.1','html/login/index','','代理用户管理','用户13692763394登录系统成功','2017-06-22 11:34:29'),
	(5138,'127.0.0.1','wechat/tags/sync','admin','微信管理','同步全部微信粉丝标签成功','2017-06-22 13:58:47'),
	(5139,'127.0.0.1','html/login/index','admin','代理用户管理','用户13414707510登录系统成功','2017-06-24 09:36:51'),
	(5140,'127.0.0.1','html/login/index','','代理用户管理','用户13414707510登录系统成功','2017-06-25 23:05:17');

/*!40000 ALTER TABLE `system_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table system_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `system_menu`;

CREATE TABLE `system_menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `node` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '节点代码',
  `icon` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单图标',
  `url` varchar(400) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '链接',
  `params` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '链接参数',
  `target` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '_self' COMMENT '链接打开方式',
  `sort` int(11) unsigned DEFAULT '0' COMMENT '菜单排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
  `create_by` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `index_system_menu_node` (`node`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统菜单表';

LOCK TABLES `system_menu` WRITE;
/*!40000 ALTER TABLE `system_menu` DISABLE KEYS */;

INSERT INTO `system_menu` (`id`, `pid`, `title`, `node`, `icon`, `url`, `params`, `target`, `sort`, `status`, `create_by`, `create_at`)
VALUES
	(2,0,'系统管理','','','#','','_self',1000,1,0,'2015-11-16 19:15:38'),
	(3,4,'后台首页','','fa fa-fw fa-tachometer','admin/index/main','','_self',10,1,0,'2015-11-17 13:27:25'),
	(4,2,'系统配置','','','#','','_self',100,1,0,'2016-03-14 18:12:55'),
	(5,4,'网站参数','','fa fa-apple','admin/config/index','','_self',20,1,0,'2016-05-06 14:36:49'),
	(6,4,'文件存储','','fa fa-hdd-o','admin/config/file','','_self',30,1,0,'2016-05-06 14:39:43'),
	(9,20,'操作日志','','glyphicon glyphicon-console','admin/log/index','','_self',50,1,0,'2017-03-24 15:49:31'),
	(19,20,'权限管理','','fa fa-user-secret','admin/auth/index','','_self',20,1,0,'2015-11-17 13:18:12'),
	(20,2,'系统权限','','','#','','_self',200,1,0,'2016-03-14 18:11:41'),
	(21,20,'系统菜单','','glyphicon glyphicon-menu-hamburger','admin/menu/index','','_self',30,1,0,'2015-11-16 19:16:16'),
	(22,20,'节点管理','','fa fa-ellipsis-v','admin/node/index','','_self',10,1,0,'2015-11-16 19:16:16'),
	(29,20,'系统用户','','fa fa-users','admin/user/index','','_self',40,1,0,'2016-10-31 14:31:40'),
	(61,0,'微信管理','','','#','','_self',2000,1,0,'2017-03-29 11:00:21'),
	(62,61,'微信对接配置','','','#','','_self',0,1,0,'2017-03-29 11:03:38'),
	(63,62,'微信接口配置\r\n','','fa fa-usb','wechat/config/index','','_self',0,1,0,'2017-03-29 11:04:44'),
	(64,62,'微信支付配置','','fa fa-paypal','wechat/config/pay','','_self',0,1,0,'2017-03-29 11:05:29'),
	(65,61,'微信粉丝管理','','','#','','_self',0,1,0,'2017-03-29 11:08:32'),
	(66,65,'粉丝标签','','fa fa-tags','wechat/tags/index','','_self',0,1,0,'2017-03-29 11:09:41'),
	(67,65,'已关注粉丝','','fa fa-wechat','wechat/fans/index','','_self',0,1,0,'2017-03-29 11:10:07'),
	(68,61,'微信订制','','','#','','_self',0,1,0,'2017-03-29 11:10:39'),
	(69,68,'微信菜单定制','','glyphicon glyphicon-phone','wechat/menu/index','','_self',0,1,0,'2017-03-29 11:11:08'),
	(70,68,'关键字管理','','fa fa-paw','wechat/keys/index','','_self',0,1,0,'2017-03-29 11:11:49'),
	(71,68,'关注自动回复','','fa fa-commenting-o','wechat/keys/subscribe','','_self',0,1,0,'2017-03-29 11:12:32'),
	(81,68,'无配置默认回复','','fa fa-commenting-o','wechat/keys/defaults','','_self',0,1,0,'2017-04-21 14:48:25'),
	(82,61,'素材资源管理','','','#','','_self',0,1,0,'2017-04-24 11:23:18'),
	(83,82,'添加图文','','fa fa-folder-open-o','wechat/news/add?id=1','','_self',0,1,0,'2017-04-24 11:23:40'),
	(85,82,'图文列表','','fa fa-file-pdf-o','wechat/news/index','','_self',0,1,0,'2017-04-24 11:25:45'),
	(86,65,'粉丝黑名单','','fa fa-reddit-alien','wechat/fans/back','','_self',0,1,0,'2017-05-05 16:17:03'),
	(87,0,'励轩','','','#','','_self',3000,1,0,'2017-06-14 23:28:24'),
	(88,87,'产品管理','','','#','','_self',0,1,0,'2017-06-14 23:40:35'),
	(89,88,'产品列表','','fa fa-cubes','lixuan/products/index','','_self',0,1,0,'2017-06-14 23:42:19'),
	(90,87,'代理管理','','','#','','_self',0,1,0,'2017-06-22 14:36:59'),
	(91,90,'代理列表','','fa fa-cubes','lixuan/agents/index','','_self',0,1,0,'2017-06-22 14:38:52');

/*!40000 ALTER TABLE `system_menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table system_node
# ------------------------------------------------------------

DROP TABLE IF EXISTS `system_node`;

CREATE TABLE `system_node` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `node` varchar(100) DEFAULT NULL COMMENT '节点代码',
  `title` varchar(500) DEFAULT NULL COMMENT '节点标题',
  `is_menu` tinyint(1) unsigned DEFAULT '0' COMMENT '是否可设置为菜单',
  `is_auth` tinyint(1) unsigned DEFAULT '1' COMMENT '是启启动RBAC权限控制',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `index_system_node_node` (`node`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统节点表';

LOCK TABLES `system_node` WRITE;
/*!40000 ALTER TABLE `system_node` DISABLE KEYS */;

INSERT INTO `system_node` (`id`, `node`, `title`, `is_menu`, `is_auth`, `create_at`)
VALUES
	(3,'admin','系统管理',0,1,'2017-03-10 15:31:29'),
	(4,'admin/menu/add','添加菜单',0,1,'2017-03-10 15:32:21'),
	(5,'admin/config','系统配置',0,1,'2017-03-10 15:32:56'),
	(6,'admin/config/index','网站配置',1,1,'2017-03-10 15:32:58'),
	(7,'admin/config/file','文件配置',1,1,'2017-03-10 15:33:02'),
	(8,'admin/config/mail','邮件配置',0,0,'2017-03-10 15:36:42'),
	(9,'admin/config/sms','短信配置',0,0,'2017-03-10 15:36:43'),
	(10,'admin/menu/index','菜单列表',1,1,'2017-03-10 15:36:50'),
	(11,'admin/node/index','节点列表',1,1,'2017-03-10 15:36:59'),
	(12,'admin/node/save','节点更新',0,1,'2017-03-10 15:36:59'),
	(13,'store/menu/index','菜单列表',1,1,'2017-03-10 15:37:22'),
	(14,'store/menu/add','添加菜单',0,1,'2017-03-10 15:37:23'),
	(15,'store/menu/edit','编辑菜单',0,1,'2017-03-10 15:37:24'),
	(16,'store/menu/del','删除菜单',0,1,'2017-03-10 15:37:24'),
	(17,'admin/index/index','',1,1,'2017-03-10 15:39:23'),
	(18,'admin/index/main','',0,1,'2017-03-14 16:21:54'),
	(19,'admin/index/pass',NULL,0,1,'2017-03-14 16:25:56'),
	(20,'admin/index/info',NULL,0,1,'2017-03-14 16:25:57'),
	(21,'store/menu/tagmove','移动标签',0,1,'2017-03-14 17:07:12'),
	(22,'store/menu/tagedit','编辑标签',0,1,'2017-03-14 17:07:13'),
	(23,'store/menu/tagdel','删除标签',0,1,'2017-03-14 17:07:13'),
	(24,'store/menu/resume','启用菜单',0,1,'2017-03-14 17:07:14'),
	(25,'store/menu/forbid','禁用菜单',0,1,'2017-03-14 17:07:15'),
	(26,'store/menu/tagadd','添加标签',0,1,'2017-03-14 17:07:15'),
	(27,'store/menu/hot','设置热卖',0,1,'2017-03-14 17:07:18'),
	(28,'admin/index','',0,1,'2017-03-14 17:27:00'),
	(29,'store/order/index','订单列表',1,1,'2017-03-14 17:52:51'),
	(30,'store/index/qrcimg','店铺二维码',0,1,'2017-03-14 17:52:52'),
	(31,'store/index/edit','编辑店铺',0,1,'2017-03-14 17:52:55'),
	(32,'store/index/qrc','二维码列表',0,1,'2017-03-14 17:52:56'),
	(33,'store/index/add','添加店铺',0,1,'2017-03-14 17:52:56'),
	(34,'store/index/index','我的店铺',1,1,'2017-03-14 17:52:57'),
	(35,'store/api/delcache',NULL,0,1,'2017-03-14 17:52:59'),
	(36,'store/api/getcache',NULL,0,1,'2017-03-14 17:53:00'),
	(37,'store/api/setcache',NULL,0,1,'2017-03-14 17:53:01'),
	(38,'store/api/response',NULL,0,1,'2017-03-14 17:53:01'),
	(39,'store/api/auth',NULL,0,1,'2017-03-14 17:53:02'),
	(40,'admin/user/resume','启用用户',1,1,'2017-03-14 17:53:03'),
	(41,'admin/user/forbid','禁用用户',1,1,'2017-03-14 17:53:03'),
	(42,'admin/user/del','删除用户',0,1,'2017-03-14 17:53:04'),
	(43,'admin/user/pass','密码修改',0,1,'2017-03-14 17:53:04'),
	(44,'admin/user/edit','编辑用户',1,1,'2017-03-14 17:53:05'),
	(45,'admin/user/index','用户列表',1,1,'2017-03-14 17:53:07'),
	(46,'admin/user/auth','用户授权',1,1,'2017-03-14 17:53:08'),
	(47,'admin/user/add','新增用户',1,1,'2017-03-14 17:53:09'),
	(48,'admin/plugs/icon',NULL,0,1,'2017-03-14 17:53:09'),
	(49,'admin/plugs/upload',NULL,0,1,'2017-03-14 17:53:10'),
	(50,'admin/plugs/upfile',NULL,0,1,'2017-03-14 17:53:11'),
	(51,'admin/plugs/upstate',NULL,0,1,'2017-03-14 17:53:11'),
	(52,'admin/menu/resume','菜单启用',0,1,'2017-03-14 17:53:14'),
	(53,'admin/menu/forbid','菜单禁用',1,1,'2017-03-14 17:53:15'),
	(54,'admin/login/index',NULL,0,1,'2017-03-14 17:53:17'),
	(55,'admin/login/out','',0,1,'2017-03-14 17:53:18'),
	(56,'admin/menu/edit','编辑菜单',0,0,'2017-03-14 17:53:20'),
	(57,'admin/menu/del','菜单删除',0,1,'2017-03-14 17:53:21'),
	(58,'store/menu','菜谱管理',0,1,'2017-03-14 17:57:47'),
	(59,'store/index','店铺管理',0,1,'2017-03-14 17:58:28'),
	(60,'store','店铺管理',0,1,'2017-03-14 17:58:29'),
	(61,'store/order','订单管理',0,1,'2017-03-14 17:58:56'),
	(62,'admin/user','用户管理',0,1,'2017-03-14 17:59:39'),
	(63,'admin/node','节点管理',0,1,'2017-03-14 17:59:53'),
	(64,'admin/menu','菜单管理',0,1,'2017-03-14 18:00:31'),
	(65,'admin/auth','权限管理',0,1,'2017-03-17 14:37:05'),
	(66,'admin/auth/index','权限列表',1,1,'2017-03-17 14:37:14'),
	(67,'admin/auth/apply','权限节点',1,1,'2017-03-17 14:37:29'),
	(68,'admin/auth/add','添加权',0,1,'2017-03-17 14:37:32'),
	(69,'admin/auth/edit','编辑权限',0,1,'2017-03-17 14:37:36'),
	(70,'admin/auth/forbid','禁用权限',0,1,'2017-03-17 14:37:38'),
	(71,'admin/auth/resume','启用权限',0,1,'2017-03-17 14:37:41'),
	(72,'admin/auth/del','删除权限',0,1,'2017-03-17 14:37:47'),
	(73,'admin/log/index','日志列表',1,1,'2017-03-25 09:54:57'),
	(74,'admin/log/del','删除日志',1,1,'2017-03-25 09:54:59'),
	(75,'admin/log','系统日志',0,1,'2017-03-25 10:56:53'),
	(76,'wechat','微信管理',0,1,'2017-04-05 10:52:31'),
	(77,'wechat/article','微信文章',0,1,'2017-04-05 10:52:47'),
	(78,'wechat/article/index','文章列表',1,1,'2017-04-05 10:52:54'),
	(79,'wechat/config','微信配置',0,1,'2017-04-05 10:53:02'),
	(80,'wechat/config/index','微信接口配置',1,1,'2017-04-05 10:53:16'),
	(81,'wechat/config/pay','微信支付配置',1,1,'2017-04-05 10:53:18'),
	(82,'wechat/fans','微信粉丝',0,1,'2017-04-05 10:53:34'),
	(83,'wechat/fans/index','粉丝列表',1,1,'2017-04-05 10:53:39'),
	(84,'wechat/index','微信主页',0,1,'2017-04-05 10:53:49'),
	(85,'wechat/index/index','微信主页',1,1,'2017-04-05 10:53:49'),
	(86,'wechat/keys','微信关键字',0,1,'2017-04-05 10:54:00'),
	(87,'wechat/keys/index','关键字列表',1,1,'2017-04-05 10:54:14'),
	(88,'wechat/keys/subscribe','关键自动回复',1,1,'2017-04-05 10:54:23'),
	(89,'wechat/keys/defaults','默认自动回复',1,1,'2017-04-05 10:54:29'),
	(90,'wechat/menu','微信菜单管理',0,1,'2017-04-05 10:54:34'),
	(91,'wechat/menu/index','微信菜单',1,1,'2017-04-05 10:54:41'),
	(92,'wechat/news','微信图文管理',0,1,'2017-04-05 10:54:51'),
	(93,'wechat/news/index','图文列表',1,1,'2017-04-05 10:54:59'),
	(94,'wechat/notify/index','',0,0,'2017-04-05 17:59:20'),
	(95,'wechat/api/index','',1,1,'2017-04-06 09:30:28'),
	(96,'wechat/api','',0,1,'2017-04-06 10:11:23'),
	(97,'wechat/notify','',0,1,'2017-04-10 10:37:33'),
	(98,'wechat/fans/sync','同步粉丝',0,1,'2017-04-13 16:30:29'),
	(99,'wechat/menu/edit','编辑微信菜单',0,1,'2017-04-19 23:36:52'),
	(100,'wechat/menu/cancel','取消微信菜单',0,1,'2017-04-19 23:36:54'),
	(101,'wechat/keys/edit','编辑关键字',0,1,'2017-04-21 10:24:09'),
	(102,'wechat/keys/add','添加关键字',0,1,'2017-04-21 10:24:09'),
	(103,'wechat/review/index',NULL,0,1,'2017-04-21 10:24:11'),
	(104,'wechat/review','',0,1,'2017-04-21 10:24:18'),
	(105,'wechat/keys/del','删除关键字',0,1,'2017-04-21 14:22:31'),
	(106,'wechat/news/add','添加图文',0,1,'2017-04-22 22:17:29'),
	(107,'wechat/news/select','图文选择器',1,1,'2017-04-22 22:17:31'),
	(108,'wechat/keys/resume','启用关键字',0,1,'2017-04-25 11:03:52'),
	(109,'wechat/news/edit','编辑图文',0,1,'2017-04-25 16:15:23'),
	(110,'wechat/news/push','推送图文',0,1,'2017-04-25 22:32:08'),
	(111,'wechat/news/del','删除图文',0,1,'2017-04-26 10:48:24'),
	(112,'wechat/keys/forbid','禁用关键字',0,1,'2017-04-26 10:48:28'),
	(113,'wechat/tags/index','标签列表',1,1,'2017-05-04 16:03:37'),
	(114,'wechat/tags/add','添加标签',0,1,'2017-05-05 12:48:28'),
	(115,'wechat/tags/edit','编辑标签',0,1,'2017-05-05 12:48:29'),
	(116,'wechat/tags/sync','同步标签',0,1,'2017-05-05 12:48:30'),
	(117,'wechat/tags','粉丝标签管理',0,1,'2017-05-05 13:17:12'),
	(118,'wechat/fans/backdel','移除粉丝黑名单',0,1,'2017-05-05 16:56:23'),
	(119,'wechat/fans/backadd','移入粉丝黑名单',0,1,'2017-05-05 16:56:30'),
	(120,'wechat/fans/back','粉丝黑名单列表',1,1,'2017-05-05 16:56:38'),
	(121,'wechat/fans/tagadd','添加粉丝标签',0,1,'2017-05-08 14:46:13'),
	(122,'wechat/fans/tagdel','删除粉丝标签',0,1,'2017-05-08 14:46:20');

/*!40000 ALTER TABLE `system_node` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table system_sequence
# ------------------------------------------------------------

DROP TABLE IF EXISTS `system_sequence`;

CREATE TABLE `system_sequence` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) DEFAULT NULL COMMENT '序号类型',
  `sequence` char(50) NOT NULL COMMENT '序号值',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_system_sequence_unique` (`type`,`sequence`) USING BTREE,
  KEY `index_system_sequence_type` (`type`),
  KEY `index_system_sequence_number` (`sequence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统序号表';



# Dump of table system_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `system_user`;

CREATE TABLE `system_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户登录名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '用户登录密码',
  `qq` varchar(16) DEFAULT NULL COMMENT '联系QQ',
  `mail` varchar(32) DEFAULT NULL COMMENT '联系邮箱',
  `phone` varchar(16) DEFAULT NULL COMMENT '联系手机号',
  `desc` varchar(255) DEFAULT '' COMMENT '备注说明',
  `login_num` bigint(20) unsigned DEFAULT '0' COMMENT '登录次数',
  `login_at` datetime DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
  `authorize` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) unsigned DEFAULT '0' COMMENT '删除状态(1:删除,0:未删)',
  `create_by` bigint(20) unsigned DEFAULT NULL COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_system_user_username` (`username`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统用户表';

LOCK TABLES `system_user` WRITE;
/*!40000 ALTER TABLE `system_user` DISABLE KEYS */;

INSERT INTO `system_user` (`id`, `username`, `password`, `qq`, `mail`, `phone`, `desc`, `login_num`, `login_at`, `status`, `authorize`, `is_deleted`, `create_by`, `create_at`)
VALUES
	(10000,'admin','21232f297a57a5a743894a0e4a801fc3','22222222','11111@qq.com','13823822233','<script>alert(\"a\")</script>',12602,'2017-06-21 23:43:08',1,'47,49',0,NULL,'2015-11-13 15:14:22'),
	(10145,'ceshi1（普通用户--测试1权限）','9464c3798239e316379036767f0ff7d1',NULL,'','13692763394','第一个测试用户（普通用户）',1,'2017-06-11 23:09:36',1,'51',0,NULL,'2017-06-11 23:04:03');

/*!40000 ALTER TABLE `system_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wechat_fans
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wechat_fans`;

CREATE TABLE `wechat_fans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '粉丝表ID',
  `appid` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '公众号Appid',
  `groupid` bigint(20) unsigned DEFAULT NULL COMMENT '分组ID',
  `tagid_list` varchar(100) CHARACTER SET utf8 DEFAULT '' COMMENT '标签id',
  `is_back` tinyint(1) unsigned DEFAULT '0' COMMENT '是否为黑名单用户',
  `subscribe` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户是否订阅该公众号,0：未关注,1：已关注',
  `openid` char(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '用户的标识,对当前公众号唯一',
  `spread_openid` char(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '推荐人OPENID',
  `spread_at` datetime DEFAULT NULL,
  `nickname` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '用户的昵称',
  `sex` tinyint(1) unsigned DEFAULT NULL COMMENT '用户的性别,值为1时是男性,值为2时是女性,值为0时是未知',
  `country` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '用户所在国家',
  `province` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '用户所在省份',
  `city` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '用户所在城市',
  `language` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '用户的语言,简体中文为zh_CN',
  `headimgurl` varchar(500) CHARACTER SET utf8 DEFAULT NULL COMMENT '用户头像',
  `subscribe_time` bigint(20) unsigned DEFAULT NULL COMMENT '用户关注时间',
  `subscribe_at` datetime DEFAULT NULL COMMENT '关注时间',
  `unionid` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'unionid',
  `remark` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '备注',
  `expires_in` bigint(20) unsigned DEFAULT '0' COMMENT '有效时间',
  `refresh_token` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '刷新token',
  `access_token` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '访问token',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `index_wechat_fans_spread_openid` (`spread_openid`) USING BTREE,
  KEY `index_wechat_fans_openid` (`openid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=sjis COMMENT='微信粉丝';

LOCK TABLES `wechat_fans` WRITE;
/*!40000 ALTER TABLE `wechat_fans` DISABLE KEYS */;

INSERT INTO `wechat_fans` (`id`, `appid`, `groupid`, `tagid_list`, `is_back`, `subscribe`, `openid`, `spread_openid`, `spread_at`, `nickname`, `sex`, `country`, `province`, `city`, `language`, `headimgurl`, `subscribe_time`, `subscribe_at`, `unionid`, `remark`, `expires_in`, `refresh_token`, `access_token`, `create_at`)
VALUES
	(9427,'123',123,'1',0,0,'','123',NULL,'123',1,'sdf ','sadf ','sdf ','',NULL,NULL,NULL,'weweawer','12312312',0,'123','qw','2017-06-18 19:33:57');

/*!40000 ALTER TABLE `wechat_fans` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wechat_fans_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wechat_fans_tags`;

CREATE TABLE `wechat_fans_tags` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '标签ID',
  `appid` char(50) DEFAULT NULL COMMENT '公众号APPID',
  `name` varchar(35) DEFAULT NULL COMMENT '标签名称',
  `count` int(11) unsigned DEFAULT NULL COMMENT '总数',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  KEY `index_wechat_fans_tags_id` (`id`) USING BTREE,
  KEY `index_wechat_fans_tags_appid` (`appid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信会员标签';



# Dump of table wechat_keys
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wechat_keys`;

CREATE TABLE `wechat_keys` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `appid` char(50) DEFAULT NULL COMMENT '公众号APPID',
  `type` varchar(20) DEFAULT NULL COMMENT '类型,text 文件消息,image 图片消息,news 图文消息',
  `keys` varchar(100) DEFAULT NULL COMMENT '关键字',
  `content` text COMMENT '文本内容',
  `image_url` varchar(255) DEFAULT NULL COMMENT '图片链接',
  `voice_url` varchar(255) DEFAULT NULL COMMENT '语音链接',
  `music_title` varchar(100) DEFAULT NULL COMMENT '音乐标题',
  `music_url` varchar(255) DEFAULT NULL COMMENT '音乐链接',
  `music_image` varchar(255) DEFAULT NULL COMMENT '音乐缩略图链接',
  `music_desc` varchar(255) DEFAULT NULL COMMENT '音乐描述',
  `video_title` varchar(100) DEFAULT NULL COMMENT '视频标题',
  `video_url` varchar(255) DEFAULT NULL COMMENT '视频URL',
  `video_desc` varchar(255) DEFAULT NULL COMMENT '视频描述',
  `news_id` bigint(20) unsigned DEFAULT NULL COMMENT '图文ID',
  `sort` bigint(20) unsigned DEFAULT '0' COMMENT '排序字段',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '0 禁用,1 启用',
  `create_by` bigint(20) unsigned DEFAULT NULL COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT=' 微信关键字';

LOCK TABLES `wechat_keys` WRITE;
/*!40000 ALTER TABLE `wechat_keys` DISABLE KEYS */;

INSERT INTO `wechat_keys` (`id`, `appid`, `type`, `keys`, `content`, `image_url`, `voice_url`, `music_title`, `music_url`, `music_image`, `music_desc`, `video_title`, `video_url`, `video_desc`, `news_id`, `sort`, `status`, `create_by`, `create_at`)
VALUES
	(28,NULL,'text','subscribe','说点什么吧','http://www.think5admin.dev/static/theme/default/img/image.png','','音乐标题','','http://www.think5admin.dev/static/theme/default/img/image.png','音乐描述','视频标题','','视频描述',0,0,1,NULL,'2017-06-13 23:36:52');

/*!40000 ALTER TABLE `wechat_keys` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wechat_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wechat_menu`;

CREATE TABLE `wechat_menu` (
  `id` bigint(16) unsigned NOT NULL AUTO_INCREMENT,
  `index` bigint(20) DEFAULT NULL,
  `pindex` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `type` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单类型 null主菜单 link链接 keys关键字',
  `name` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '文字内容',
  `sort` bigint(20) unsigned DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '状态(0禁用1启用)',
  `create_by` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建人',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `wechat_menu_pid` (`pindex`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wechat_menu` WRITE;
/*!40000 ALTER TABLE `wechat_menu` DISABLE KEYS */;

INSERT INTO `wechat_menu` (`id`, `index`, `pindex`, `type`, `name`, `content`, `sort`, `status`, `create_by`, `create_at`)
VALUES
	(1502,1,0,'text','关键字','2234123413',0,1,0,'2017-04-27 14:49:14'),
	(1503,11,1,'keys','图片','图片',0,1,0,'2017-04-27 14:49:14'),
	(1504,12,1,'keys','音乐','音乐',1,1,0,'2017-04-27 14:49:14'),
	(1505,2,0,'event','事件类','pic_weixin',1,1,0,'2017-04-27 14:49:14'),
	(1506,3,0,'view','微信支付','index/wap/payjs',2,1,0,'2017-04-27 14:49:14');

/*!40000 ALTER TABLE `wechat_menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wechat_news
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wechat_news`;

CREATE TABLE `wechat_news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `media_id` varchar(100) DEFAULT NULL COMMENT '永久素材MediaID',
  `local_url` varchar(300) DEFAULT NULL COMMENT '永久素材显示URL',
  `article_id` varchar(60) DEFAULT NULL COMMENT '关联图文ID,用,号做分割',
  `is_deleted` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_by` bigint(20) DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`),
  KEY `index_wechat_new_artcle_id` (`article_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信图文表';

LOCK TABLES `wechat_news` WRITE;
/*!40000 ALTER TABLE `wechat_news` DISABLE KEYS */;

INSERT INTO `wechat_news` (`id`, `media_id`, `local_url`, `article_id`, `is_deleted`, `create_at`, `create_by`)
VALUES
	(37,NULL,NULL,'96',0,'2017-06-13 23:38:02',10000);

/*!40000 ALTER TABLE `wechat_news` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wechat_news_article
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wechat_news_article`;

CREATE TABLE `wechat_news_article` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '素材标题',
  `local_url` varchar(300) DEFAULT NULL COMMENT '永久素材显示URL',
  `show_cover_pic` tinyint(4) unsigned DEFAULT '0' COMMENT '是否显示封面 0不显示,1 显示',
  `author` varchar(20) DEFAULT NULL COMMENT '作者',
  `digest` varchar(300) DEFAULT NULL COMMENT '摘要内容',
  `content` longtext COMMENT '图文内容',
  `content_source_url` varchar(200) DEFAULT NULL COMMENT '图文消息原文地址',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `create_by` bigint(20) DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信素材表';

LOCK TABLES `wechat_news_article` WRITE;
/*!40000 ALTER TABLE `wechat_news_article` DISABLE KEYS */;

INSERT INTO `wechat_news_article` (`id`, `title`, `local_url`, `show_cover_pic`, `author`, `digest`, `content`, `content_source_url`, `create_at`, `create_by`)
VALUES
	(96,'123','http://www.think5admin.dev/static/upload/2bf4878726f77519/83ed3a31e5c7a9dd.jpg',1,'456','1234','<p>文章内容不能留空，请输入内容！</p>',NULL,'2017-06-13 23:38:02',10000);

/*!40000 ALTER TABLE `wechat_news_article` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wechat_news_image
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wechat_news_image`;

CREATE TABLE `wechat_news_image` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `appid` varchar(200) DEFAULT NULL COMMENT '公众号ID',
  `md5` varchar(32) DEFAULT NULL COMMENT '文件md5',
  `media_id` varchar(100) DEFAULT NULL COMMENT '永久素材MediaID',
  `local_url` varchar(300) DEFAULT NULL COMMENT '本地文件链接',
  `media_url` varchar(300) DEFAULT NULL COMMENT '远程图片链接',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信服务器图片';



# Dump of table wechat_news_media
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wechat_news_media`;

CREATE TABLE `wechat_news_media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `appid` varchar(200) DEFAULT NULL COMMENT '公众号ID',
  `md5` varchar(32) DEFAULT NULL COMMENT '文件md5',
  `type` varchar(20) DEFAULT NULL COMMENT '媒体类型',
  `media_id` varchar(100) DEFAULT NULL COMMENT '永久素材MediaID',
  `local_url` varchar(300) DEFAULT NULL COMMENT '本地文件链接',
  `media_url` varchar(300) DEFAULT NULL COMMENT '远程图片链接',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信素材表';



# Dump of table wechat_pay_notify
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wechat_pay_notify`;

CREATE TABLE `wechat_pay_notify` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `appid` varchar(50) DEFAULT NULL COMMENT '公众号Appid',
  `bank_type` varchar(50) DEFAULT NULL COMMENT '银行类型',
  `cash_fee` bigint(20) DEFAULT NULL COMMENT '现金价',
  `fee_type` char(20) DEFAULT NULL COMMENT '币种,1人民币',
  `is_subscribe` char(1) DEFAULT 'N' COMMENT '是否关注,Y为关注,N为未关注',
  `mch_id` varchar(50) DEFAULT NULL COMMENT '商户MCH_ID',
  `nonce_str` varchar(32) DEFAULT NULL COMMENT '随机串',
  `openid` varchar(50) DEFAULT NULL COMMENT '微信用户openid',
  `out_trade_no` varchar(50) DEFAULT NULL COMMENT '支付平台退款交易号',
  `sign` varchar(100) DEFAULT NULL COMMENT '签名',
  `time_end` datetime DEFAULT NULL COMMENT '结束时间',
  `result_code` varchar(10) DEFAULT NULL,
  `return_code` varchar(10) DEFAULT NULL,
  `total_fee` varchar(11) DEFAULT NULL COMMENT '支付总金额,单位为分',
  `trade_type` varchar(20) DEFAULT NULL COMMENT '支付方式',
  `transaction_id` varchar(64) DEFAULT NULL COMMENT '订单号',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '本地系统时间',
  PRIMARY KEY (`id`),
  KEY `index_wechat_pay_notify_openid` (`openid`) USING BTREE,
  KEY `index_wechat_pay_notify_out_trade_no` (`out_trade_no`) USING BTREE,
  KEY `index_wechat_pay_notify_transaction_id` (`transaction_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='支付日志表';



# Dump of table wechat_pay_prepayid
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wechat_pay_prepayid`;

CREATE TABLE `wechat_pay_prepayid` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `appid` char(50) DEFAULT NULL COMMENT '公众号APPID',
  `from` char(32) DEFAULT 'shop' COMMENT '支付来源',
  `fee` bigint(20) unsigned DEFAULT NULL COMMENT '支付费用(分)',
  `trade_type` varchar(20) DEFAULT NULL COMMENT '订单类型',
  `order_no` varchar(50) DEFAULT NULL COMMENT '内部订单号',
  `out_trade_no` varchar(50) DEFAULT NULL COMMENT '外部订单号',
  `prepayid` varchar(500) DEFAULT NULL COMMENT '预支付码',
  `expires_in` bigint(20) unsigned DEFAULT NULL COMMENT '有效时间',
  `transaction_id` varchar(64) DEFAULT NULL COMMENT '微信平台订单号',
  `is_pay` tinyint(1) unsigned DEFAULT '0' COMMENT '1已支付,0未支退款',
  `pay_at` datetime DEFAULT NULL COMMENT '支付时间',
  `is_refund` tinyint(1) unsigned DEFAULT '0' COMMENT '是否退款,退款单号(T+原来订单)',
  `refund_at` datetime DEFAULT NULL COMMENT '退款时间',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '本地系统时间',
  PRIMARY KEY (`id`),
  KEY `index_wechat_pay_prepayid_outer_no` (`out_trade_no`) USING BTREE,
  KEY `index_wechat_pay_prepayid_order_no` (`order_no`) USING BTREE,
  KEY `index_wechat_pay_is_pay` (`is_pay`) USING BTREE,
  KEY `index_wechat_pay_is_refund` (`is_refund`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付订单号对应表';




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
