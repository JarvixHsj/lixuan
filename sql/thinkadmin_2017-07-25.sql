# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.7.11)
# Database: thinkadmin
# Generation Time: 2017-07-25 13:14:11 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table lx_word
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lx_word`;

CREATE TABLE `lx_word` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `key` varchar(15) DEFAULT NULL,
  `value` text,
  `status` tinyint(1) DEFAULT '1',
  `change_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文档管理表（关于我们，合作协议等）';

LOCK TABLES `lx_word` WRITE;
/*!40000 ALTER TABLE `lx_word` DISABLE KEYS */;

INSERT INTO `lx_word` (`id`, `name`, `key`, `value`, `status`, `change_at`)
VALUES
	(1,'关于我们','about','<p><img src=\"http://www.lixuan.dev/static/upload/b265eaf1b17ee594/519911f7d1379ccb.jpeg\" width=\"312\" height=\"185\" style=\"width: 312px; height: 185px;\"/></p><p><br/></p><p>这里是关于我们</p>',1,'2017-07-25 21:06:04'),
	(2,'合作协议','protocols','<p>（一）合作人的权利：</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1、参加合伙人会议，并对合伙事务执行进行监督；<br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2、是大家覅撒娇地方；连接啥大路口附近说的；发；<br/></p>',1,'2017-07-25 21:11:11');

/*!40000 ALTER TABLE `lx_word` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
