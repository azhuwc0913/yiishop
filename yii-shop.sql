/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50629
 Source Host           : localhost
 Source Database       : yii-shop

 Target Server Type    : MySQL
 Target Server Version : 50629
 File Encoding         : utf-8

 Date: 08/11/2016 20:22:41 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `role` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `admin`
-- ----------------------------
BEGIN;
INSERT INTO `admin` VALUES ('1', 'admin11', 'BRsSNd8dp6U', '$2y$13$TLsdsv6cvgFVp0wmnPjZf.OUzbpWcQB6v.u.8DjiXXx1hfT3xipEy', null, 'admin@123.com', '10', '1469698521', '1469698521', 'admin'), ('2', 'admin', 'vx_21H3At8kAsswIt34Kt1N3M8Cl-uvq', '$2y$13$yKjR73g6NY3c5etmS0BWO.S92ZCIbqYwcmx5fwiARDONy3iTvq4lm', null, 'admin@admin.com', '10', '1469931963', '1469931977', '超级管理员');
COMMIT;

-- ----------------------------
--  Table structure for `attribute`
-- ----------------------------
DROP TABLE IF EXISTS `attribute`;
CREATE TABLE `attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(120) NOT NULL DEFAULT '',
  `attr_type` tinyint(10) NOT NULL COMMENT '属性类型,0代表唯一,1代表可选',
  `attr_value` varchar(120) NOT NULL COMMENT '属性的可选值',
  `type_id` int(11) NOT NULL COMMENT '属性所属的类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='属性表';

-- ----------------------------
--  Records of `attribute`
-- ----------------------------
BEGIN;
INSERT INTO `attribute` VALUES ('1', '尺寸', '1', '4.7,5.5,6.5', '1'), ('2', '内存容量', '0', '32G,64G,128G', '1'), ('3', '颜色', '1', '玫瑰金,深邃黑,月光白', '1'), ('4', '外观样式', '1', '翻盖,直板,折叠', '1'), ('5', '操作系统', '0', '', '1'), ('6', 'cup', '1', '4核,8核,16核', '1');
COMMIT;

-- ----------------------------
--  Table structure for `auth_assignment`
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `auth_assignment`
-- ----------------------------
BEGIN;
INSERT INTO `auth_assignment` VALUES ('超级管理员', '2', '1469931977');
COMMIT;

-- ----------------------------
--  Table structure for `auth_item`
-- ----------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `auth_item`
-- ----------------------------
BEGIN;
INSERT INTO `auth_item` VALUES ('[admin/create]', '2', '创建管理员', null, null, '1469799394', '1469799394'), ('[admin/index]', '2', '创建[[admin/index]]权限', null, null, '1469775012', '1469775012'), ('[admin/update]', '2', '后台管理员的更新操作', null, null, '1469778974', '1469778974'), ('[item/all]', '2', '创建[[item/all]]权限', null, null, '1469778992', '1469778992'), ('管理员管理1', '1', '管理员管理1', null, null, '1469781852', '1469799459'), ('超级管理员', '1', '拥有后台所有的权限', null, null, '1469931839', '1469931839');
COMMIT;

-- ----------------------------
--  Table structure for `auth_item_child`
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
--  Records of `auth_item_child`
-- ----------------------------
BEGIN;
INSERT INTO `auth_item_child` VALUES ('管理员管理1', '[admin/create]'), ('超级管理员', '[admin/create]'), ('管理员管理1', '[admin/index]'), ('超级管理员', '[admin/index]'), ('管理员管理1', '[admin/update]'), ('超级管理员', '[admin/update]'), ('超级管理员', '[item/all]');
COMMIT;

-- ----------------------------
--  Table structure for `auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `category`
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(30) NOT NULL,
  `p_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_name` (`cat_name`),
  KEY `p_id` (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='类型表';

-- ----------------------------
--  Records of `category`
-- ----------------------------
BEGIN;
INSERT INTO `category` VALUES ('1', '手机', '0'), ('2', '手机配件', '0'), ('3', '家电', '0'), ('7', 'GSM手机', '1'), ('8', 'GSM单卡单待', '7'), ('9', '4g手机', '1');
COMMIT;

-- ----------------------------
--  Table structure for `goods`
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(20) NOT NULL,
  `cat_id` int(11) unsigned NOT NULL COMMENT '类别id',
  `shop_price` decimal(10,0) NOT NULL,
  `market_price` decimal(10,0) NOT NULL,
  `is_promote` tinyint(4) NOT NULL DEFAULT '0',
  `promote_price` decimal(10,0) DEFAULT NULL,
  `promote_start_time` int(100) DEFAULT NULL,
  `promote_end_time` int(100) DEFAULT NULL,
  `is_delete` tinyint(10) DEFAULT '0',
  `is_on_sale` tinyint(10) DEFAULT '1',
  `is_hot` tinyint(10) DEFAULT '0',
  `is_new` tinyint(10) DEFAULT '0',
  `is_best` tinyint(10) DEFAULT '0',
  `type_id` int(10) DEFAULT NULL COMMENT '类型id',
  `logo` varchar(100) NOT NULL,
  `sm_logo` varchar(100) NOT NULL,
  `addtime` int(100) NOT NULL,
  `goods_desc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `goods`
-- ----------------------------
BEGIN;
INSERT INTO `goods` VALUES ('1', 'iphone 6s', '7', '5188', '5288', '0', null, null, null, '0', '1', '1', '0', '1', '1', 'uploads/20160805/14703659248238.jpg', 'uploads/20160805/thumb_014703659248238.jpg', '1470365924', '<p><img src=\"/ueditor/php/upload/image/20160805/1470365844331602.jpg\" title=\"1470365844331602.jpg\" alt=\"下载 (1).jpg\"/><img src=\"/ueditor/php/upload/image/20160805/1470365848818808.jpg\" title=\"1470365848818808.jpg\" alt=\"下载.jpg\"/><strong>wqqeeqwwewewe</strong></p>'), ('2', 'oppo', '7', '1899', '1999', '1', '1800', '1470412800', '1470585600', '0', '1', '1', '0', '1', '1', 'uploads/20160805/14703660564130.jpg', 'uploads/20160805/thumb_014703660564130.jpg', '1470366056', '<p><strong>23e3ee322222222222222222222222222222222222e</strong></p>'), ('3', '红咪', '7', '899', '999', '1', '810', '1470326400', '1471190400', '0', '1', '1', '0', '1', '1', 'uploads/20160805/14703661693863.jpg', 'uploads/20160805/thumb_014703661693863.jpg', '1470366169', '<p>围鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅</p>'), ('4', '华为p8', '1', '2500', '2599', '0', null, null, null, '0', '1', '0', '1', '1', '1', 'uploads/20160805/14703662808584.jpg', 'uploads/20160805/thumb_014703662808584.jpg', '1470366280', '<p><strong>weedddddddddddddddddddddddddddddddddddddddddddddddddw</strong></p>'), ('5', '三星note5', '7', '5688', '5888', '0', null, null, null, '0', '1', '0', '1', '1', '1', 'uploads/20160805/14703663999927.jpg', 'uploads/20160805/thumb_014703663999927.jpg', '1470366399', '<p><strong>wddddddddddddddddddddddddddddd</strong></p>'), ('6', '锤子手机', '7', '1999', '2199', '1', '1900', '1470412800', '1471449600', '0', '1', '1', '1', '0', '1', '', 'uploads/20160805/thumb_014703664898705.jpg', '1470366489', '<p><em>带我去去去去去去去去去去去去去去去去去去去去去去去</em></p>'), ('7', '黑莓', '7', '3500', '3680', '0', null, null, null, '0', '1', '0', '1', '1', '1', 'uploads/20160805/14703666081510.jpg', 'uploads/20160805/thumb_014703666081510.jpg', '1470366608', '<p><strong>围鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅</strong></p>'), ('8', '索尼X系列', '7', '4800', '4900', '1', '4500', '1470412800', '1470758400', '0', '1', '1', '0', '1', '1', '', 'uploads/20160805/thumb_014703983945543.jpg', '1470398394', '<p>到我的的决定我的&nbsp;<img src=\"/ueditor/php/upload/image/20160805/1470398346875094.jpg\" title=\"1470398346875094.jpg\" alt=\"images (9).jpg\"/></p>');
COMMIT;

-- ----------------------------
--  Table structure for `goods_attr`
-- ----------------------------
DROP TABLE IF EXISTS `goods_attr`;
CREATE TABLE `goods_attr` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) NOT NULL,
  `attr_id` int(10) NOT NULL,
  `attr_value` varchar(20) NOT NULL,
  `attr_price` decimal(10,0) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COMMENT='商品属性关联表';

-- ----------------------------
--  Records of `goods_attr`
-- ----------------------------
BEGIN;
INSERT INTO `goods_attr` VALUES ('1', '1', '1', '4.7', '100'), ('2', '1', '1', '5.5', '201'), ('3', '1', '2', '32G', '0'), ('4', '1', '3', '玫瑰金', '301'), ('5', '1', '3', '深邃黑', '401'), ('6', '1', '3', '月光白', '501'), ('7', '1', '4', '翻盖', '601'), ('8', '1', '4', '直板', '701'), ('9', '1', '5', 'IOS', '0'), ('10', '2', '1', '5.5', '10'), ('11', '2', '1', '6.5', '20'), ('12', '2', '3', '玫瑰金', '30'), ('13', '2', '3', '深邃黑', '40'), ('14', '2', '3', '月光白', '50'), ('15', '2', '4', '直板', '60'), ('16', '2', '5', 'Andriod', '0'), ('17', '3', '1', '4.7', '10'), ('18', '3', '1', '5.5', '20'), ('19', '3', '2', '64G', '0'), ('20', '3', '3', '深邃黑', '30'), ('21', '3', '3', '玫瑰金', '40'), ('22', '3', '3', '月光白', '50'), ('23', '3', '4', '翻盖', '60'), ('24', '3', '4', '直板', '70'), ('25', '3', '5', 'Andirod', '0'), ('26', '4', '1', '4.7', '10'), ('27', '4', '1', '5.5', '20'), ('28', '4', '1', '6.5', '30'), ('29', '4', '2', '64G', '0'), ('30', '4', '3', '玫瑰金', '40'), ('31', '4', '3', '深邃黑', '50'), ('32', '4', '4', '直板', '60'), ('33', '4', '5', 'Andirod', '0'), ('34', '5', '1', '4.7', '10'), ('35', '5', '1', '5.5', '20'), ('36', '5', '1', '6.5', '30'), ('37', '5', '2', '64G', '0'), ('38', '5', '3', '玫瑰金', '40'), ('39', '5', '3', '深邃黑', '50'), ('40', '5', '3', '月光白', '60'), ('41', '5', '4', '翻盖', '70'), ('42', '5', '4', '直板', '80'), ('43', '5', '4', '折叠', '90'), ('44', '5', '5', 'Andirod', '0'), ('45', '6', '1', '4.7', '10'), ('46', '6', '1', '5.5', '20'), ('47', '6', '2', '64G', '0'), ('48', '6', '3', '深邃黑', '30'), ('49', '6', '3', '月光白', '40'), ('50', '6', '4', '直板', '50'), ('51', '6', '5', 'Andirod', '0'), ('52', '7', '1', '4.7', '10'), ('53', '7', '1', '5.5', '20'), ('54', '7', '2', '64G', '0'), ('55', '7', '3', '玫瑰金', '30'), ('56', '7', '3', '深邃黑', '40'), ('57', '7', '4', '翻盖', '50'), ('58', '7', '4', '折叠', '60'), ('59', '7', '4', '直板', '70'), ('60', '7', '5', 'Andirod', '0'), ('61', '8', '1', '4.7', '100'), ('62', '8', '1', '5.5', '20'), ('63', '8', '2', '128G', '0'), ('64', '8', '3', '深邃黑', '30'), ('65', '8', '3', '月光白', '40'), ('66', '8', '4', '翻盖', '50'), ('67', '8', '5', 'Andriod1', '0'), ('69', '8', '6', '4核', '100'), ('70', '8', '6', '16核', '200'), ('73', '8', '3', '玫瑰金', '300');
COMMIT;

-- ----------------------------
--  Table structure for `goods_number`
-- ----------------------------
DROP TABLE IF EXISTS `goods_number`;
CREATE TABLE `goods_number` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) unsigned NOT NULL,
  `goods_attr_id` varchar(120) NOT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `goods_number`
-- ----------------------------
BEGIN;
INSERT INTO `goods_number` VALUES ('21', '7', '52,55,57', '20'), ('20', '8', '62,64,66', '122'), ('19', '8', '62,65,66', '2'), ('18', '8', '61,64,66', '13'), ('22', '7', '53,55,58', '20'), ('23', '7', '52,56,58', '20');
COMMIT;

-- ----------------------------
--  Table structure for `goods_pics`
-- ----------------------------
DROP TABLE IF EXISTS `goods_pics`;
CREATE TABLE `goods_pics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pic` varchar(120) DEFAULT NULL,
  `sm_pic` varchar(120) DEFAULT NULL,
  `goods_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='商品图片表';

-- ----------------------------
--  Records of `goods_pics`
-- ----------------------------
BEGIN;
INSERT INTO `goods_pics` VALUES ('1', 'uploads/20160805/14703659253300.jpg', 'uploads/20160805/thumb_014703659253300.jpg', '1'), ('2', 'uploads/20160805/14703659256920.jpg', 'uploads/20160805/thumb_014703659256920.jpg', '1'), ('3', 'uploads/20160805/14703660568477.jpg', 'uploads/20160805/thumb_014703660568477.jpg', '2'), ('4', 'uploads/20160805/14703660562546.jpg', 'uploads/20160805/thumb_014703660562546.jpg', '2'), ('5', 'uploads/20160805/14703660564861.jpg', 'uploads/20160805/thumb_014703660564861.jpg', '2'), ('6', 'uploads/20160805/14703661702621.jpg', 'uploads/20160805/thumb_014703661702621.jpg', '3'), ('7', 'uploads/20160805/14703661701063.jpg', 'uploads/20160805/thumb_014703661701063.jpg', '3'), ('8', 'uploads/20160805/14703661703533.jpg', 'uploads/20160805/thumb_014703661703533.jpg', '3'), ('9', 'uploads/20160805/14703662811546.jpg', 'uploads/20160805/thumb_014703662811546.jpg', '4'), ('10', 'uploads/20160805/14703662812502.jpg', 'uploads/20160805/thumb_014703662812502.jpg', '4'), ('11', 'uploads/20160805/14703664007614.jpg', 'uploads/20160805/thumb_014703664007614.jpg', '5'), ('12', 'uploads/20160805/14703664009979.jpg', 'uploads/20160805/thumb_014703664009979.jpg', '5'), ('13', 'uploads/20160805/14703664002763.jpg', 'uploads/20160805/thumb_014703664002763.jpg', '5'), ('14', 'uploads/20160805/14703664893593.jpg', 'uploads/20160805/thumb_014703664893593.jpg', '6'), ('15', 'uploads/20160805/14703664896076.jpg', 'uploads/20160805/thumb_014703664896076.jpg', '6'), ('16', 'uploads/20160805/14703666087454.jpg', 'uploads/20160805/thumb_014703666087454.jpg', '7'), ('17', 'uploads/20160805/14703666083091.jpg', 'uploads/20160805/thumb_014703666083091.jpg', '7'), ('18', 'uploads/20160805/14703666083818.jpg', 'uploads/20160805/thumb_014703666083818.jpg', '7'), ('21', 'uploads/20160807/14705499484199.jpg', 'uploads/20160807/thumb_014705499484199.jpg', '8'), ('24', 'uploads/20160808/14706711034186.jpg', 'uploads/20160808/thumb_014706711034186.jpg', '8'), ('25', 'uploads/20160808/14706711037433.jpg', 'uploads/20160808/thumb_014706711037433.jpg', '8');
COMMIT;

-- ----------------------------
--  Table structure for `member_level`
-- ----------------------------
DROP TABLE IF EXISTS `member_level`;
CREATE TABLE `member_level` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level_name` varchar(20) NOT NULL COMMENT '会员名称',
  `bottom_num` int(10) NOT NULL,
  `top_num` int(10) NOT NULL,
  `rate` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `member_level`
-- ----------------------------
BEGIN;
INSERT INTO `member_level` VALUES ('1', '初级会员', '0', '1000', '100'), ('2', '中级会员', '1001', '2000', '98'), ('3', '高级会员', '2001', '3001', '92');
COMMIT;

-- ----------------------------
--  Table structure for `member_price`
-- ----------------------------
DROP TABLE IF EXISTS `member_price`;
CREATE TABLE `member_price` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) unsigned NOT NULL,
  `level_id` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `member_price`
-- ----------------------------
BEGIN;
INSERT INTO `member_price` VALUES ('1', '1', '1', '5180'), ('2', '1', '2', '5160'), ('3', '1', '3', '5200'), ('4', '2', '1', '-1'), ('5', '2', '2', '-1'), ('6', '2', '3', '-1'), ('7', '3', '1', '890'), ('8', '3', '2', '880'), ('9', '3', '3', '850'), ('10', '4', '1', '2480'), ('11', '4', '2', '2460'), ('12', '4', '3', '2400'), ('13', '5', '1', '5680'), ('14', '5', '2', '5660'), ('15', '5', '3', '5600'), ('16', '6', '1', '1990'), ('17', '6', '2', '1970'), ('18', '6', '3', '1900'), ('19', '7', '1', '-1'), ('20', '7', '2', '-1'), ('21', '7', '3', '-1'), ('22', '8', '1', '-1'), ('23', '8', '2', '-1'), ('24', '8', '3', '-1');
COMMIT;

-- ----------------------------
--  Table structure for `migration`
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `migration`
-- ----------------------------
BEGIN;
INSERT INTO `migration` VALUES ('m000000_000000_base', '1469697406'), ('m130524_201442_init', '1469697413');
COMMIT;

-- ----------------------------
--  Table structure for `type`
-- ----------------------------
DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='商品类型表';

-- ----------------------------
--  Records of `type`
-- ----------------------------
BEGIN;
INSERT INTO `type` VALUES ('1', '手机'), ('2', '电脑'), ('3', '书'), ('4', '美妆');
COMMIT;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `user`
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES ('1', 'admin', 'ZeuOmVsQYU5aiCvSOwA5-BRsSNd8dp6U', '$2y$13$TLsdsv6cvgFVp0wmnPjZf.OUzbpWcQB6v.u.8DjiXXx1hfT3xipEy', null, 'admin@123.com', '10', '1469698521', '1469698521');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
