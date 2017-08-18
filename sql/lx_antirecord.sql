/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : thinkadmin

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2017-08-18 16:48:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for lx_antirecord
-- ----------------------------
DROP TABLE IF EXISTS `lx_antirecord`;
CREATE TABLE `lx_antirecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anti_id` int(11) DEFAULT NULL,
  `anti_code` varchar(20) DEFAULT NULL COMMENT '防伪码',
  `type` tinyint(1) DEFAULT NULL COMMENT '操作类型：1=发货跟踪，2=后台操作，3=',
  `take_user_id` int(11) DEFAULT '0' COMMENT '收货人代理ID',
  `send_user_id` int(11) DEFAULT '0' COMMENT '发货人代理id',
  `agent_id` int(11) DEFAULT '0' COMMENT '代理授权id',
  `ip` varchar(20) DEFAULT '0.0.0.0' COMMENT '查询时记录ip',
  `content` varchar(50) DEFAULT '' COMMENT '内容，组合内容',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='防伪码操作记录表';

-- ----------------------------
-- Records of lx_antirecord
-- ----------------------------
INSERT INTO `lx_antirecord` VALUES ('1', '2', '80010010102', '2', '25', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081099565457，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('2', '2', '80010010102', '2', '25', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081056555097，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('3', '2', '80010010102', '2', '25', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081048495454，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('4', '2', '80010010102', '2', '25', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081049575348，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('5', '2', '80010010102', '2', '26', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081055974810，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('6', '2', '80010010102', '2', '26', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081057561009，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('7', '2', '80010010102', '2', '26', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081010051494，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('8', '2', '80010010102', '2', '26', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081052569755，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('9', '2', '80010010102', '2', '26', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081048515248，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('10', '2', '80010010102', '2', '26', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081052985253，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('11', '2', '80010010102', '2', '26', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081097544853，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('12', '3', '80010010103', '2', '27', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081010149571，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('13', '4', '80010010104', '2', '25', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081048491015，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('14', '108', '80010020318', '2', '11', '0', '0', '0.0.0.0', '公司总部给你发了一箱产品，订单号为：2017081197494948，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('15', '5', '80010010105', '2', '11', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081198994953，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('16', '6', '80010010106', '2', '11', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081199571005，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('17', '216', '80010040318', '2', '11', '0', '0', '0.0.0.0', '公司总部给你发了一箱产品，订单号为：2017081210251575，请注意查收~', null);
INSERT INTO `lx_antirecord` VALUES ('18', '109', '80010030101', '2', '11', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081249545649，请注意查收~', '2017-08-12 15:20:17');
INSERT INTO `lx_antirecord` VALUES ('19', '109', '80010030101', '2', '11', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081255534950，请注意查收~', '2017-08-12 15:20:39');
INSERT INTO `lx_antirecord` VALUES ('20', '217', '80010050101', '2', '11', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081250521001，请注意查收~', '2017-08-12 15:28:02');
INSERT INTO `lx_antirecord` VALUES ('21', '217', '80010050101', '2', '11', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081299975399，请注意查收~', '2017-08-12 15:45:32');
INSERT INTO `lx_antirecord` VALUES ('22', '217', '80010050101', '2', '11', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081249574857，请注意查收~', '2017-08-12 15:45:37');
INSERT INTO `lx_antirecord` VALUES ('23', '217', '80010050101', '2', '11', '0', '0', '0.0.0.0', '公司总部给你发了一盒产品，订单号为：2017081210297569，请注意查收~', '2017-08-12 15:47:27');
INSERT INTO `lx_antirecord` VALUES ('24', '270', '80010050318', '2', '11', '0', '0', '0.0.0.0', '公司总部给你发了一箱产品，订单号为：2017081210256985，请注意查收~', '2017-08-12 15:49:51');
INSERT INTO `lx_antirecord` VALUES ('25', '110', '80010030102', null, '25', '11', '17', '0.0.0.0', '', null);
INSERT INTO `lx_antirecord` VALUES ('26', '152', '80010030308', null, '25', '11', '17', '0.0.0.0', '', null);
INSERT INTO `lx_antirecord` VALUES ('27', '157', '80010030313', null, '25', '11', '17', '0.0.0.0', '', null);
INSERT INTO `lx_antirecord` VALUES ('28', '215', '80010040317', null, '25', '11', '17', '0.0.0.0', '', null);
INSERT INTO `lx_antirecord` VALUES ('32', '30', '80010010212', null, '25', '11', '17', '0.0.0.0', '', null);
INSERT INTO `lx_antirecord` VALUES ('33', '44', '80010010308', null, '25', '11', '17', '0.0.0.0', '', null);
INSERT INTO `lx_antirecord` VALUES ('34', '126', '80010030118', null, '25', '11', '17', '0.0.0.0', '', null);
INSERT INTO `lx_antirecord` VALUES ('35', '127', '80010030201', null, '25', '11', '17', '0.0.0.0', '', null);
