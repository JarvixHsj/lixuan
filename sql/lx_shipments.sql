/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : thinkadmin

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2017-08-18 17:05:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for lx_shipments
-- ----------------------------
DROP TABLE IF EXISTS `lx_shipments`;
CREATE TABLE `lx_shipments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `take_user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `serial_sn` varchar(120) DEFAULT NULL COMMENT '流水号',
  `picking_type` varchar(45) DEFAULT '0' COMMENT '提货方式0=自提，1=快递',
  `express_sn` varchar(120) DEFAULT NULL COMMENT '快递单号',
  `express_company` varchar(45) DEFAULT NULL COMMENT '快递公司\n',
  `num` smallint(5) DEFAULT '1' COMMENT '发货数量',
  `product_name` varchar(45) DEFAULT NULL COMMENT '产品名称',
  `remark` varchar(120) DEFAULT NULL COMMENT '备注',
  `order_sn` varchar(60) DEFAULT NULL COMMENT '系统订单号',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态',
  `send_user_id` int(11) DEFAULT NULL COMMENT '发货人id',
  `send_user_level` tinyint(1) DEFAULT NULL COMMENT '发货人等级',
  `take_user_level` tinyint(1) DEFAULT NULL COMMENT '收货人等级',
  `take_username` varchar(45) DEFAULT NULL COMMENT '收货人姓名',
  `take_wechat_no` varchar(45) DEFAULT NULL,
  `take_mobile` varchar(45) DEFAULT NULL,
  `send_username` varchar(45) DEFAULT NULL,
  `send_wechat_no` varchar(45) DEFAULT NULL,
  `send_time` datetime DEFAULT NULL COMMENT '发货时间',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lx_shipments
-- ----------------------------
INSERT INTO `lx_shipments` VALUES ('1', '25', '3', null, '0', null, null, '1', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', null, '0', '0', null, null, 'HONG第二级', 'hailong', '13692762399', '公司总部', null, '2017-08-10 23:12:12', '2017-08-10 23:12:12');
INSERT INTO `lx_shipments` VALUES ('2', '25', '3', null, '0', null, null, '1', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', null, '0', '0', null, null, 'HONG第二级', 'hailong', '13692762399', '公司总部', null, '2017-08-10 23:14:24', '2017-08-10 23:14:24');
INSERT INTO `lx_shipments` VALUES ('3', '25', '3', null, '0', null, null, '1', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', null, '0', '0', null, null, 'HONG第二级', 'hailong', '13692762399', '公司总部', null, '2017-08-10 23:14:41', '2017-08-10 23:14:41');
INSERT INTO `lx_shipments` VALUES ('4', '26', '3', null, '0', null, null, '1', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', null, '0', '0', null, null, 'HONG第三极', 'Three', '13692763388', '公司总部', null, '2017-08-10 23:15:51', '2017-08-10 23:15:51');
INSERT INTO `lx_shipments` VALUES ('5', '26', '3', null, '0', null, null, '1', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', null, '0', '0', null, null, 'HONG第三极', 'Three', '13692763388', '公司总部', null, '2017-08-10 23:16:57', '2017-08-10 23:16:57');
INSERT INTO `lx_shipments` VALUES ('6', '26', '3', null, '0', null, null, '1', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', null, '0', '0', null, null, 'HONG第三极', 'Three', '13692763388', '公司总部', null, '2017-08-10 23:17:17', '2017-08-10 23:17:17');
INSERT INTO `lx_shipments` VALUES ('7', '26', '3', null, '0', null, null, '1', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', null, '0', '0', null, null, 'HONG第三极', 'Three', '13692763388', '公司总部', null, '2017-08-10 23:17:56', '2017-08-10 23:17:56');
INSERT INTO `lx_shipments` VALUES ('8', '26', '3', null, '0', null, null, '1', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', null, '0', '0', null, null, 'HONG第三极', 'Three', '13692763388', '公司总部', null, '2017-08-10 23:18:24', '2017-08-10 23:18:24');
INSERT INTO `lx_shipments` VALUES ('9', '26', '3', null, '0', null, null, '1', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', null, '0', '0', null, null, 'HONG第三极', 'Three', '13692763388', '公司总部', null, '2017-08-10 23:18:28', '2017-08-10 23:18:28');
INSERT INTO `lx_shipments` VALUES ('10', '26', '3', null, '0', null, null, '1', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', null, '0', '0', null, null, 'HONG第三极', 'Three', '13692763388', '公司总部', null, '2017-08-10 23:19:22', '2017-08-10 23:19:22');
INSERT INTO `lx_shipments` VALUES ('11', '27', '3', null, '0', null, null, '1', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', null, '0', '0', null, null, 'HONG第四级', 'Four', '13692763377', '公司总部', null, '2017-08-10 23:19:42', '2017-08-10 23:19:42');
INSERT INTO `lx_shipments` VALUES ('12', '25', '3', null, '0', null, null, '1', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', null, '0', '0', null, null, 'HONG第二级', 'hailong', '13692762399', '公司总部', null, '2017-08-10 23:20:00', '2017-08-10 23:20:00');
INSERT INTO `lx_shipments` VALUES ('13', '11', '3', null, '0', null, null, '48', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', '2017081197494948', '0', '0', null, null, 'HONG', 'Jarvix', '13414707510', '公司总部', null, '2017-08-11 22:54:18', '2017-08-11 22:54:18');
INSERT INTO `lx_shipments` VALUES ('14', '11', '3', null, '0', null, null, '1', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', '2017081198994953', '0', '0', null, null, 'HONG', 'Jarvix', '13414707510', '公司总部', null, '2017-08-11 22:54:35', '2017-08-11 22:54:35');
INSERT INTO `lx_shipments` VALUES ('15', '11', '3', null, '0', null, null, '1', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', '2017081199571005', '0', '0', null, null, 'HONG', 'Jarvix', '13414707510', '公司总部', null, '2017-08-11 23:36:28', '2017-08-11 23:36:28');
INSERT INTO `lx_shipments` VALUES ('16', '11', '3', null, '0', null, null, '48', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', '2017081210251575', '0', '0', null, null, 'HONG', 'Jarvix', '13414707510', '公司总部', null, '2017-08-12 15:13:03', '2017-08-12 15:13:03');
INSERT INTO `lx_shipments` VALUES ('17', '11', '3', null, '0', null, null, '1', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', '2017081210297569', '0', '0', null, null, 'HONG', 'Jarvix', '13414707510', '公司总部', null, '2017-08-12 15:47:27', '2017-08-12 15:47:27');
INSERT INTO `lx_shipments` VALUES ('18', '11', '3', null, '0', null, null, '48', '测试产品图片数据库屋恩替', '总后台管理员给代理分配防伪码', '2017081210256985', '0', '0', null, null, 'HONG', 'Jarvix', '13414707510', '公司总部', null, '2017-08-12 15:49:51', '2017-08-12 15:49:51');
INSERT INTO `lx_shipments` VALUES ('19', '25', '3', null, '0', null, null, '4', null, '给代理分配防伪码', '2017081897519797', '0', '11', null, '17', 'HONG第二级', 'hailong', '13692762399', 'HONG', 'Jarvix', '2017-08-18 10:03:00', '2015-03-02 18:34:00');
INSERT INTO `lx_shipments` VALUES ('20', '25', '3', null, '0', null, null, '1', '产品名称', '备注', '2017081810056505', '0', '11', null, '17', 'HONG第二级', 'hailong', '13692762399', 'HONG', 'Jarvix', '2017-08-18 10:08:00', '0000-00-00 00:00:00');
INSERT INTO `lx_shipments` VALUES ('21', '25', '3', null, '0', null, null, '3', '1234', '1244', '2017081852535148', '0', '11', null, '17', 'HONG第二级', 'hailong', '13692762399', 'HONG', 'Jarvix', '2017-08-18 10:48:00', '0000-00-00 00:00:00');
