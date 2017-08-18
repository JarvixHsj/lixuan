/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : thinkadmin

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2017-08-18 17:05:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for lx_shipment_details
-- ----------------------------
DROP TABLE IF EXISTS `lx_shipment_details`;
CREATE TABLE `lx_shipment_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ship_id` int(11) DEFAULT NULL,
  `anti_id` int(11) DEFAULT NULL,
  `anti_code` varchar(20) DEFAULT NULL,
  `anti_qrcode` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8 COMMENT='发货详情表';

-- ----------------------------
-- Records of lx_shipment_details
-- ----------------------------
INSERT INTO `lx_shipment_details` VALUES ('1', '13', '55', '80010020101', null);
INSERT INTO `lx_shipment_details` VALUES ('2', '13', '56', '80010020102', null);
INSERT INTO `lx_shipment_details` VALUES ('3', '13', '57', '80010020103', null);
INSERT INTO `lx_shipment_details` VALUES ('4', '13', '58', '80010020104', null);
INSERT INTO `lx_shipment_details` VALUES ('5', '13', '59', '80010020105', null);
INSERT INTO `lx_shipment_details` VALUES ('6', '13', '60', '80010020106', null);
INSERT INTO `lx_shipment_details` VALUES ('7', '13', '61', '80010020107', null);
INSERT INTO `lx_shipment_details` VALUES ('8', '13', '62', '80010020108', null);
INSERT INTO `lx_shipment_details` VALUES ('9', '13', '63', '80010020109', null);
INSERT INTO `lx_shipment_details` VALUES ('10', '13', '64', '80010020110', null);
INSERT INTO `lx_shipment_details` VALUES ('11', '13', '65', '80010020111', null);
INSERT INTO `lx_shipment_details` VALUES ('12', '13', '66', '80010020112', null);
INSERT INTO `lx_shipment_details` VALUES ('13', '13', '67', '80010020113', null);
INSERT INTO `lx_shipment_details` VALUES ('14', '13', '68', '80010020114', null);
INSERT INTO `lx_shipment_details` VALUES ('15', '13', '69', '80010020115', null);
INSERT INTO `lx_shipment_details` VALUES ('16', '13', '70', '80010020116', null);
INSERT INTO `lx_shipment_details` VALUES ('17', '13', '71', '80010020117', null);
INSERT INTO `lx_shipment_details` VALUES ('18', '13', '72', '80010020118', null);
INSERT INTO `lx_shipment_details` VALUES ('19', '13', '73', '80010020201', null);
INSERT INTO `lx_shipment_details` VALUES ('20', '13', '74', '80010020202', null);
INSERT INTO `lx_shipment_details` VALUES ('21', '13', '75', '80010020203', null);
INSERT INTO `lx_shipment_details` VALUES ('22', '13', '76', '80010020204', null);
INSERT INTO `lx_shipment_details` VALUES ('23', '13', '77', '80010020205', null);
INSERT INTO `lx_shipment_details` VALUES ('24', '13', '78', '80010020206', null);
INSERT INTO `lx_shipment_details` VALUES ('25', '13', '79', '80010020207', null);
INSERT INTO `lx_shipment_details` VALUES ('26', '13', '80', '80010020208', null);
INSERT INTO `lx_shipment_details` VALUES ('27', '13', '81', '80010020209', null);
INSERT INTO `lx_shipment_details` VALUES ('28', '13', '82', '80010020210', null);
INSERT INTO `lx_shipment_details` VALUES ('29', '13', '83', '80010020211', null);
INSERT INTO `lx_shipment_details` VALUES ('30', '13', '84', '80010020212', null);
INSERT INTO `lx_shipment_details` VALUES ('31', '13', '85', '80010020213', null);
INSERT INTO `lx_shipment_details` VALUES ('32', '13', '86', '80010020214', null);
INSERT INTO `lx_shipment_details` VALUES ('33', '13', '87', '80010020215', null);
INSERT INTO `lx_shipment_details` VALUES ('34', '13', '88', '80010020216', null);
INSERT INTO `lx_shipment_details` VALUES ('35', '13', '89', '80010020217', null);
INSERT INTO `lx_shipment_details` VALUES ('36', '13', '90', '80010020218', null);
INSERT INTO `lx_shipment_details` VALUES ('37', '13', '91', '80010020301', null);
INSERT INTO `lx_shipment_details` VALUES ('38', '13', '92', '80010020302', null);
INSERT INTO `lx_shipment_details` VALUES ('39', '13', '93', '80010020303', null);
INSERT INTO `lx_shipment_details` VALUES ('40', '13', '94', '80010020304', null);
INSERT INTO `lx_shipment_details` VALUES ('41', '13', '95', '80010020305', null);
INSERT INTO `lx_shipment_details` VALUES ('42', '13', '96', '80010020306', null);
INSERT INTO `lx_shipment_details` VALUES ('43', '13', '97', '80010020307', null);
INSERT INTO `lx_shipment_details` VALUES ('44', '13', '98', '80010020308', null);
INSERT INTO `lx_shipment_details` VALUES ('45', '13', '99', '80010020309', null);
INSERT INTO `lx_shipment_details` VALUES ('46', '13', '100', '80010020310', null);
INSERT INTO `lx_shipment_details` VALUES ('47', '13', '101', '80010020311', null);
INSERT INTO `lx_shipment_details` VALUES ('48', '13', '102', '80010020312', null);
INSERT INTO `lx_shipment_details` VALUES ('64', '14', '5', '80010010105', null);
INSERT INTO `lx_shipment_details` VALUES ('65', '15', '6', '80010010106', null);
INSERT INTO `lx_shipment_details` VALUES ('66', '16', '163', '80010040101', null);
INSERT INTO `lx_shipment_details` VALUES ('67', '16', '164', '80010040102', null);
INSERT INTO `lx_shipment_details` VALUES ('68', '16', '165', '80010040103', null);
INSERT INTO `lx_shipment_details` VALUES ('69', '16', '166', '80010040104', null);
INSERT INTO `lx_shipment_details` VALUES ('70', '16', '167', '80010040105', null);
INSERT INTO `lx_shipment_details` VALUES ('71', '16', '168', '80010040106', null);
INSERT INTO `lx_shipment_details` VALUES ('72', '16', '169', '80010040107', null);
INSERT INTO `lx_shipment_details` VALUES ('73', '16', '170', '80010040108', null);
INSERT INTO `lx_shipment_details` VALUES ('74', '16', '171', '80010040109', null);
INSERT INTO `lx_shipment_details` VALUES ('75', '16', '172', '80010040110', null);
INSERT INTO `lx_shipment_details` VALUES ('76', '16', '173', '80010040111', null);
INSERT INTO `lx_shipment_details` VALUES ('77', '16', '174', '80010040112', null);
INSERT INTO `lx_shipment_details` VALUES ('78', '16', '175', '80010040113', null);
INSERT INTO `lx_shipment_details` VALUES ('79', '16', '176', '80010040114', null);
INSERT INTO `lx_shipment_details` VALUES ('80', '16', '177', '80010040115', null);
INSERT INTO `lx_shipment_details` VALUES ('81', '16', '178', '80010040116', null);
INSERT INTO `lx_shipment_details` VALUES ('82', '16', '179', '80010040117', null);
INSERT INTO `lx_shipment_details` VALUES ('83', '16', '180', '80010040118', null);
INSERT INTO `lx_shipment_details` VALUES ('84', '16', '181', '80010040201', null);
INSERT INTO `lx_shipment_details` VALUES ('85', '16', '182', '80010040202', null);
INSERT INTO `lx_shipment_details` VALUES ('86', '16', '183', '80010040203', null);
INSERT INTO `lx_shipment_details` VALUES ('87', '16', '184', '80010040204', null);
INSERT INTO `lx_shipment_details` VALUES ('88', '16', '185', '80010040205', null);
INSERT INTO `lx_shipment_details` VALUES ('89', '16', '186', '80010040206', null);
INSERT INTO `lx_shipment_details` VALUES ('90', '16', '187', '80010040207', null);
INSERT INTO `lx_shipment_details` VALUES ('91', '16', '188', '80010040208', null);
INSERT INTO `lx_shipment_details` VALUES ('92', '16', '189', '80010040209', null);
INSERT INTO `lx_shipment_details` VALUES ('93', '16', '190', '80010040210', null);
INSERT INTO `lx_shipment_details` VALUES ('94', '16', '191', '80010040211', null);
INSERT INTO `lx_shipment_details` VALUES ('95', '16', '192', '80010040212', null);
INSERT INTO `lx_shipment_details` VALUES ('96', '16', '193', '80010040213', null);
INSERT INTO `lx_shipment_details` VALUES ('97', '16', '194', '80010040214', null);
INSERT INTO `lx_shipment_details` VALUES ('98', '16', '195', '80010040215', null);
INSERT INTO `lx_shipment_details` VALUES ('99', '16', '196', '80010040216', null);
INSERT INTO `lx_shipment_details` VALUES ('100', '16', '197', '80010040217', null);
INSERT INTO `lx_shipment_details` VALUES ('101', '16', '198', '80010040218', null);
INSERT INTO `lx_shipment_details` VALUES ('102', '16', '199', '80010040301', null);
INSERT INTO `lx_shipment_details` VALUES ('103', '16', '200', '80010040302', null);
INSERT INTO `lx_shipment_details` VALUES ('104', '16', '201', '80010040303', null);
INSERT INTO `lx_shipment_details` VALUES ('105', '16', '202', '80010040304', null);
INSERT INTO `lx_shipment_details` VALUES ('106', '16', '203', '80010040305', null);
INSERT INTO `lx_shipment_details` VALUES ('107', '16', '204', '80010040306', null);
INSERT INTO `lx_shipment_details` VALUES ('108', '16', '205', '80010040307', null);
INSERT INTO `lx_shipment_details` VALUES ('109', '16', '206', '80010040308', null);
INSERT INTO `lx_shipment_details` VALUES ('110', '16', '207', '80010040309', null);
INSERT INTO `lx_shipment_details` VALUES ('111', '16', '208', '80010040310', null);
INSERT INTO `lx_shipment_details` VALUES ('112', '16', '209', '80010040311', null);
INSERT INTO `lx_shipment_details` VALUES ('113', '16', '210', '80010040312', null);
INSERT INTO `lx_shipment_details` VALUES ('114', '1', '217', '80010050101', null);
INSERT INTO `lx_shipment_details` VALUES ('115', '18', '217', '80010050101', null);
INSERT INTO `lx_shipment_details` VALUES ('116', '18', '218', '80010050102', null);
INSERT INTO `lx_shipment_details` VALUES ('117', '18', '219', '80010050103', null);
INSERT INTO `lx_shipment_details` VALUES ('118', '18', '220', '80010050104', null);
INSERT INTO `lx_shipment_details` VALUES ('119', '18', '221', '80010050105', null);
INSERT INTO `lx_shipment_details` VALUES ('120', '18', '222', '80010050106', null);
INSERT INTO `lx_shipment_details` VALUES ('121', '18', '223', '80010050107', null);
INSERT INTO `lx_shipment_details` VALUES ('122', '18', '224', '80010050108', null);
INSERT INTO `lx_shipment_details` VALUES ('123', '18', '225', '80010050109', null);
INSERT INTO `lx_shipment_details` VALUES ('124', '18', '226', '80010050110', null);
INSERT INTO `lx_shipment_details` VALUES ('125', '18', '227', '80010050111', null);
INSERT INTO `lx_shipment_details` VALUES ('126', '18', '228', '80010050112', null);
INSERT INTO `lx_shipment_details` VALUES ('127', '18', '229', '80010050113', null);
INSERT INTO `lx_shipment_details` VALUES ('128', '18', '230', '80010050114', null);
INSERT INTO `lx_shipment_details` VALUES ('129', '18', '231', '80010050115', null);
INSERT INTO `lx_shipment_details` VALUES ('130', '18', '232', '80010050116', null);
INSERT INTO `lx_shipment_details` VALUES ('131', '18', '233', '80010050117', null);
INSERT INTO `lx_shipment_details` VALUES ('132', '18', '234', '80010050118', null);
INSERT INTO `lx_shipment_details` VALUES ('133', '18', '235', '80010050201', null);
INSERT INTO `lx_shipment_details` VALUES ('134', '18', '236', '80010050202', null);
INSERT INTO `lx_shipment_details` VALUES ('135', '18', '237', '80010050203', null);
INSERT INTO `lx_shipment_details` VALUES ('136', '18', '238', '80010050204', null);
INSERT INTO `lx_shipment_details` VALUES ('137', '18', '239', '80010050205', null);
INSERT INTO `lx_shipment_details` VALUES ('138', '18', '240', '80010050206', null);
INSERT INTO `lx_shipment_details` VALUES ('139', '18', '241', '80010050207', null);
INSERT INTO `lx_shipment_details` VALUES ('140', '18', '242', '80010050208', null);
INSERT INTO `lx_shipment_details` VALUES ('141', '18', '243', '80010050209', null);
INSERT INTO `lx_shipment_details` VALUES ('142', '18', '244', '80010050210', null);
INSERT INTO `lx_shipment_details` VALUES ('143', '18', '245', '80010050211', null);
INSERT INTO `lx_shipment_details` VALUES ('144', '18', '246', '80010050212', null);
INSERT INTO `lx_shipment_details` VALUES ('145', '18', '247', '80010050213', null);
INSERT INTO `lx_shipment_details` VALUES ('146', '18', '248', '80010050214', null);
INSERT INTO `lx_shipment_details` VALUES ('147', '18', '249', '80010050215', null);
INSERT INTO `lx_shipment_details` VALUES ('148', '18', '250', '80010050216', null);
INSERT INTO `lx_shipment_details` VALUES ('149', '18', '251', '80010050217', null);
INSERT INTO `lx_shipment_details` VALUES ('150', '18', '252', '80010050218', null);
INSERT INTO `lx_shipment_details` VALUES ('151', '18', '253', '80010050301', null);
INSERT INTO `lx_shipment_details` VALUES ('152', '18', '254', '80010050302', null);
INSERT INTO `lx_shipment_details` VALUES ('153', '18', '255', '80010050303', null);
INSERT INTO `lx_shipment_details` VALUES ('154', '18', '256', '80010050304', null);
INSERT INTO `lx_shipment_details` VALUES ('155', '18', '257', '80010050305', null);
INSERT INTO `lx_shipment_details` VALUES ('156', '18', '258', '80010050306', null);
INSERT INTO `lx_shipment_details` VALUES ('157', '18', '259', '80010050307', null);
INSERT INTO `lx_shipment_details` VALUES ('158', '18', '260', '80010050308', null);
INSERT INTO `lx_shipment_details` VALUES ('159', '18', '261', '80010050309', null);
INSERT INTO `lx_shipment_details` VALUES ('160', '18', '262', '80010050310', null);
INSERT INTO `lx_shipment_details` VALUES ('161', '18', '263', '80010050311', null);
INSERT INTO `lx_shipment_details` VALUES ('162', '18', '264', '80010050312', null);
