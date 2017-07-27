# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 118.190.88.3 (MySQL 5.5.56-log)
# Database: lixuan
# Generation Time: 2017-07-26 15:23:30 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


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
	(6,4,'文件存储','','fa fa-hdd-o','admin/config/file','','_self',30,0,0,'2016-05-06 14:39:43'),
	(9,20,'操作日志','','glyphicon glyphicon-console','admin/log/index','','_self',50,1,0,'2017-03-24 15:49:31'),
	(19,20,'权限管理','','fa fa-user-secret','admin/auth/index','','_self',20,1,0,'2015-11-17 13:18:12'),
	(20,2,'系统权限','','','#','','_self',200,1,0,'2016-03-14 18:11:41'),
	(21,20,'系统菜单','','glyphicon glyphicon-menu-hamburger','admin/menu/index','','_self',30,0,0,'2015-11-16 19:16:16'),
	(22,20,'节点管理','','fa fa-ellipsis-v','admin/node/index','','_self',10,0,0,'2015-11-16 19:16:16'),
	(29,20,'系统用户','','fa fa-users','admin/user/index','','_self',40,1,0,'2016-10-31 14:31:40'),
	(61,0,'微信管理','','','#','','_self',2000,0,0,'2017-03-29 11:00:21'),
	(62,61,'微信对接配置','','','#','','_self',0,0,0,'2017-03-29 11:03:38'),
	(63,62,'微信接口配置\r\n','','fa fa-usb','wechat/config/index','','_self',0,0,0,'2017-03-29 11:04:44'),
	(64,62,'微信支付配置','','fa fa-paypal','wechat/config/pay','','_self',0,0,0,'2017-03-29 11:05:29'),
	(65,61,'微信粉丝管理','','','#','','_self',0,0,0,'2017-03-29 11:08:32'),
	(66,65,'粉丝标签','','fa fa-tags','wechat/tags/index','','_self',0,0,0,'2017-03-29 11:09:41'),
	(67,65,'已关注粉丝','','fa fa-wechat','wechat/fans/index','','_self',0,0,0,'2017-03-29 11:10:07'),
	(68,61,'微信订制','','','#','','_self',0,0,0,'2017-03-29 11:10:39'),
	(69,68,'微信菜单定制','','glyphicon glyphicon-phone','wechat/menu/index','','_self',0,0,0,'2017-03-29 11:11:08'),
	(70,68,'关键字管理','','fa fa-paw','wechat/keys/index','','_self',0,0,0,'2017-03-29 11:11:49'),
	(71,68,'关注自动回复','','fa fa-commenting-o','wechat/keys/subscribe','','_self',0,0,0,'2017-03-29 11:12:32'),
	(81,68,'无配置默认回复','','fa fa-commenting-o','wechat/keys/defaults','','_self',0,0,0,'2017-04-21 14:48:25'),
	(82,61,'素材资源管理','','','#','','_self',0,0,0,'2017-04-24 11:23:18'),
	(83,82,'添加图文','','fa fa-folder-open-o','wechat/news/add?id=1','','_self',0,0,0,'2017-04-24 11:23:40'),
	(85,82,'图文列表','','fa fa-file-pdf-o','wechat/news/index','','_self',0,0,0,'2017-04-24 11:25:45'),
	(86,65,'粉丝黑名单','','fa fa-reddit-alien','wechat/fans/back','','_self',0,0,0,'2017-05-05 16:17:03'),
	(87,0,'励轩','','','#','','_self',3000,1,0,'2017-06-14 23:28:24'),
	(88,87,'产品管理','','','#','','_self',0,1,0,'2017-06-14 23:40:35'),
	(89,88,'产品列表','','fa fa-cubes','lixuan/products/index','','_self',0,1,0,'2017-06-14 23:42:19'),
	(90,87,'代理管理','','','#','','_self',0,1,0,'2017-06-22 14:36:59'),
	(91,90,'代理列表','','fa fa-cubes','lixuan/agents/index','','_self',0,1,0,'2017-06-22 14:38:52'),
	(92,90,'审核列表','','fa fa-cubes','lixuan/audit/index','','_self',0,1,0,'2017-06-27 11:56:31'),
	(93,87,'首页轮播管理','','','','','_self',0,1,0,'2017-07-23 10:46:12'),
	(94,93,'轮播管理','','fa fa-cubes','lixuan/banner/index','','_self',0,1,0,'2017-07-23 10:46:55');

/*!40000 ALTER TABLE `system_menu` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
