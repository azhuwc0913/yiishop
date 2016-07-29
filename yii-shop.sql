git/*
Navicat MySQL Data Transfer

Source Server         : lawrence
Source Server Version : 50538
Source Host           : localhost:3306
Source Database       : yii-shop

Target Server Type    : MYSQL
Target Server Version : 50538
File Encoding         : 65001

Date: 2016-07-29 21:53:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `auth_item_child`
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_item_child
-- ----------------------------
INSERT INTO `auth_item_child` VALUES ('管理员管理1', '[admin/create]');
INSERT INTO `auth_item_child` VALUES ('管理员管理1', '[admin/index]');
INSERT INTO `auth_item_child` VALUES ('管理员管理1', '[admin/update]');
