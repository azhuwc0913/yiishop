/*
Navicat MySQL Data Transfer

Source Server         : lawrence
Source Server Version : 50538
Source Host           : localhost:3306
Source Database       : yii-shop

Target Server Type    : MYSQL
Target Server Version : 50538
File Encoding         : 65001

Date: 2016-08-05 21:23:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
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
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin11', 'BRsSNd8dp6U', '$2y$13$TLsdsv6cvgFVp0wmnPjZf.OUzbpWcQB6v.u.8DjiXXx1hfT3xipEy', null, 'admin@123.com', '10', '1469698521', '1469698521', 'admin');
INSERT INTO `admin` VALUES ('2', 'admin', 'vx_21H3At8kAsswIt34Kt1N3M8Cl-uvq', '$2y$13$yKjR73g6NY3c5etmS0BWO.S92ZCIbqYwcmx5fwiARDONy3iTvq4lm', null, 'admin@admin.com', '10', '1469931963', '1469931977', '超级管理员');

-- ----------------------------
-- Table structure for `attribute`
-- ----------------------------
DROP TABLE IF EXISTS `attribute`;
CREATE TABLE `attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(120) NOT NULL DEFAULT '',
  `attr_type` tinyint(10) NOT NULL COMMENT '属性类型,0代表唯一,1代表可选',
  `attr_value` varchar(120) NOT NULL COMMENT '属性的可选值',
  `type_id` int(11) NOT NULL COMMENT '属性所属的类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='属性表';

-- ----------------------------
-- Records of attribute
-- ----------------------------
INSERT INTO `attribute` VALUES ('1', '尺寸', '1', '4.7,5.5,6.5', '1');
INSERT INTO `attribute` VALUES ('2', '内存容量', '0', '32G,64G,128G', '1');
INSERT INTO `attribute` VALUES ('3', '颜色', '1', '玫瑰金,深邃黑,月光白', '1');
INSERT INTO `attribute` VALUES ('4', '外观样式', '1', '翻盖,直板,折叠', '1');
INSERT INTO `attribute` VALUES ('5', '操作系统', '0', '', '1');

-- ----------------------------
-- Table structure for `auth_assignment`
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
-- Records of auth_assignment
-- ----------------------------
INSERT INTO `auth_assignment` VALUES ('超级管理员', '2', '1469931977');

-- ----------------------------
-- Table structure for `auth_item`
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
-- Records of auth_item
-- ----------------------------
INSERT INTO `auth_item` VALUES ('[admin/create]', '2', '创建管理员', null, null, '1469799394', '1469799394');
INSERT INTO `auth_item` VALUES ('[admin/index]', '2', '创建[[admin/index]]权限', null, null, '1469775012', '1469775012');
INSERT INTO `auth_item` VALUES ('[admin/update]', '2', '后台管理员的更新操作', null, null, '1469778974', '1469778974');
INSERT INTO `auth_item` VALUES ('[item/all]', '2', '创建[[item/all]]权限', null, null, '1469778992', '1469778992');
INSERT INTO `auth_item` VALUES ('管理员管理1', '1', '管理员管理1', null, null, '1469781852', '1469799459');
INSERT INTO `auth_item` VALUES ('超级管理员', '1', '拥有后台所有的权限', null, null, '1469931839', '1469931839');

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
INSERT INTO `auth_item_child` VALUES ('超级管理员', '[admin/create]');
INSERT INTO `auth_item_child` VALUES ('管理员管理1', '[admin/index]');
INSERT INTO `auth_item_child` VALUES ('超级管理员', '[admin/index]');
INSERT INTO `auth_item_child` VALUES ('管理员管理1', '[admin/update]');
INSERT INTO `auth_item_child` VALUES ('超级管理员', '[admin/update]');
INSERT INTO `auth_item_child` VALUES ('超级管理员', '[item/all]');

-- ----------------------------
-- Table structure for `auth_rule`
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
-- Records of auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for `category`
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
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', '手机', '0');
INSERT INTO `category` VALUES ('2', '手机配件', '0');
INSERT INTO `category` VALUES ('3', '家电', '0');
INSERT INTO `category` VALUES ('7', 'GSM手机', '1');
INSERT INTO `category` VALUES ('8', 'GSM单卡单待', '7');
INSERT INTO `category` VALUES ('9', '4g手机', '1');

-- ----------------------------
-- Table structure for `goods`
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
-- Records of goods
-- ----------------------------
INSERT INTO `goods` VALUES ('1', 'iphone 6s', '7', '5188', '5288', '0', null, null, null, '0', '1', '1', '0', '1', '1', 'uploads/20160805/14703659248238.jpg', 'uploads/20160805/thumb_014703659248238.jpg', '1470365924', '<p><img src=\"/ueditor/php/upload/image/20160805/1470365844331602.jpg\" title=\"1470365844331602.jpg\" alt=\"下载 (1).jpg\"/><img src=\"/ueditor/php/upload/image/20160805/1470365848818808.jpg\" title=\"1470365848818808.jpg\" alt=\"下载.jpg\"/><strong>wqqeeqwwewewe</strong></p>');
INSERT INTO `goods` VALUES ('2', 'oppo', '7', '1899', '1999', '1', '1800', '1470412800', '1470585600', '0', '1', '1', '0', '1', '1', 'uploads/20160805/14703660564130.jpg', 'uploads/20160805/thumb_014703660564130.jpg', '1470366056', '<p><strong>23e3ee322222222222222222222222222222222222e</strong></p>');
INSERT INTO `goods` VALUES ('3', '红咪', '7', '899', '999', '1', '810', '1470326400', '1471190400', '0', '1', '1', '0', '1', '1', 'uploads/20160805/14703661693863.jpg', 'uploads/20160805/thumb_014703661693863.jpg', '1470366169', '<p>围鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅</p>');
INSERT INTO `goods` VALUES ('4', '华为p8', '1', '2500', '2599', '0', null, null, null, '0', '1', '0', '1', '1', '1', 'uploads/20160805/14703662808584.jpg', 'uploads/20160805/thumb_014703662808584.jpg', '1470366280', '<p><strong>weedddddddddddddddddddddddddddddddddddddddddddddddddw</strong></p>');
INSERT INTO `goods` VALUES ('5', '三星note5', '7', '5688', '5888', '0', null, null, null, '0', '1', '0', '1', '1', '1', 'uploads/20160805/14703663999927.jpg', 'uploads/20160805/thumb_014703663999927.jpg', '1470366399', '<p><strong>wddddddddddddddddddddddddddddd</strong></p>');
INSERT INTO `goods` VALUES ('6', '锤子手机', '7', '1999', '2199', '1', '1900', '1470412800', '1470672000', '0', '1', '1', '1', '0', '1', 'uploads/20160805/14703664898705.jpg', 'uploads/20160805/thumb_014703664898705.jpg', '1470366489', '<p><em>带我去去去去去去去去去去去去去去去去去去去去去去去</em></p>');
INSERT INTO `goods` VALUES ('7', '黑莓', '7', '3500', '3680', '0', null, null, null, '0', '1', '0', '1', '1', '1', 'uploads/20160805/14703666081510.jpg', 'uploads/20160805/thumb_014703666081510.jpg', '1470366608', '<p><strong>围鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅鹅</strong></p>');
INSERT INTO `goods` VALUES ('8', '索尼', '7', '4800', '4900', '0', null, null, null, '0', '1', '1', '0', '1', '1', 'uploads/20160805/14703983945543.jpg', 'uploads/20160805/thumb_014703983945543.jpg', '1470398394', '<p>到我的的决定我的&nbsp;<img src=\"/ueditor/php/upload/image/20160805/1470398346875094.jpg\" title=\"1470398346875094.jpg\" alt=\"images (9).jpg\"/></p>');

-- ----------------------------
-- Table structure for `goods_attr`
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
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COMMENT='商品属性关联表';

-- ----------------------------
-- Records of goods_attr
-- ----------------------------
INSERT INTO `goods_attr` VALUES ('1', '1', '1', '4.7', '10');
INSERT INTO `goods_attr` VALUES ('2', '1', '1', '5.5', '20');
INSERT INTO `goods_attr` VALUES ('3', '1', '2', '32G', '0');
INSERT INTO `goods_attr` VALUES ('4', '1', '3', '玫瑰金', '30');
INSERT INTO `goods_attr` VALUES ('5', '1', '3', '深邃黑', '40');
INSERT INTO `goods_attr` VALUES ('6', '1', '3', '月光白', '50');
INSERT INTO `goods_attr` VALUES ('7', '1', '4', '翻盖', '60');
INSERT INTO `goods_attr` VALUES ('8', '1', '4', '直板', '70');
INSERT INTO `goods_attr` VALUES ('9', '1', '5', 'IOS', '0');
INSERT INTO `goods_attr` VALUES ('10', '2', '1', '5.5', '10');
INSERT INTO `goods_attr` VALUES ('11', '2', '1', '6.5', '20');
INSERT INTO `goods_attr` VALUES ('12', '2', '3', '玫瑰金', '30');
INSERT INTO `goods_attr` VALUES ('13', '2', '3', '深邃黑', '40');
INSERT INTO `goods_attr` VALUES ('14', '2', '3', '月光白', '50');
INSERT INTO `goods_attr` VALUES ('15', '2', '4', '直板', '60');
INSERT INTO `goods_attr` VALUES ('16', '2', '5', 'Andriod', '0');
INSERT INTO `goods_attr` VALUES ('17', '3', '1', '4.7', '10');
INSERT INTO `goods_attr` VALUES ('18', '3', '1', '5.5', '20');
INSERT INTO `goods_attr` VALUES ('19', '3', '2', '64G', '0');
INSERT INTO `goods_attr` VALUES ('20', '3', '3', '深邃黑', '30');
INSERT INTO `goods_attr` VALUES ('21', '3', '3', '玫瑰金', '40');
INSERT INTO `goods_attr` VALUES ('22', '3', '3', '月光白', '50');
INSERT INTO `goods_attr` VALUES ('23', '3', '4', '翻盖', '60');
INSERT INTO `goods_attr` VALUES ('24', '3', '4', '直板', '70');
INSERT INTO `goods_attr` VALUES ('25', '3', '5', 'Andirod', '0');
INSERT INTO `goods_attr` VALUES ('26', '4', '1', '4.7', '10');
INSERT INTO `goods_attr` VALUES ('27', '4', '1', '5.5', '20');
INSERT INTO `goods_attr` VALUES ('28', '4', '1', '6.5', '30');
INSERT INTO `goods_attr` VALUES ('29', '4', '2', '64G', '0');
INSERT INTO `goods_attr` VALUES ('30', '4', '3', '玫瑰金', '40');
INSERT INTO `goods_attr` VALUES ('31', '4', '3', '深邃黑', '50');
INSERT INTO `goods_attr` VALUES ('32', '4', '4', '直板', '60');
INSERT INTO `goods_attr` VALUES ('33', '4', '5', 'Andirod', '0');
INSERT INTO `goods_attr` VALUES ('34', '5', '1', '4.7', '10');
INSERT INTO `goods_attr` VALUES ('35', '5', '1', '5.5', '20');
INSERT INTO `goods_attr` VALUES ('36', '5', '1', '6.5', '30');
INSERT INTO `goods_attr` VALUES ('37', '5', '2', '64G', '0');
INSERT INTO `goods_attr` VALUES ('38', '5', '3', '玫瑰金', '40');
INSERT INTO `goods_attr` VALUES ('39', '5', '3', '深邃黑', '50');
INSERT INTO `goods_attr` VALUES ('40', '5', '3', '月光白', '60');
INSERT INTO `goods_attr` VALUES ('41', '5', '4', '翻盖', '70');
INSERT INTO `goods_attr` VALUES ('42', '5', '4', '直板', '80');
INSERT INTO `goods_attr` VALUES ('43', '5', '4', '折叠', '90');
INSERT INTO `goods_attr` VALUES ('44', '5', '5', 'Andirod', '0');
INSERT INTO `goods_attr` VALUES ('45', '6', '1', '4.7', '10');
INSERT INTO `goods_attr` VALUES ('46', '6', '1', '5.5', '20');
INSERT INTO `goods_attr` VALUES ('47', '6', '2', '64G', '0');
INSERT INTO `goods_attr` VALUES ('48', '6', '3', '深邃黑', '30');
INSERT INTO `goods_attr` VALUES ('49', '6', '3', '月光白', '40');
INSERT INTO `goods_attr` VALUES ('50', '6', '4', '直板', '50');
INSERT INTO `goods_attr` VALUES ('51', '6', '5', 'Andirod', '0');
INSERT INTO `goods_attr` VALUES ('52', '7', '1', '4.7', '10');
INSERT INTO `goods_attr` VALUES ('53', '7', '1', '5.5', '20');
INSERT INTO `goods_attr` VALUES ('54', '7', '2', '64G', '0');
INSERT INTO `goods_attr` VALUES ('55', '7', '3', '玫瑰金', '30');
INSERT INTO `goods_attr` VALUES ('56', '7', '3', '深邃黑', '40');
INSERT INTO `goods_attr` VALUES ('57', '7', '4', '翻盖', '50');
INSERT INTO `goods_attr` VALUES ('58', '7', '4', '折叠', '60');
INSERT INTO `goods_attr` VALUES ('59', '7', '4', '直板', '70');
INSERT INTO `goods_attr` VALUES ('60', '7', '5', 'Andirod', '0');
INSERT INTO `goods_attr` VALUES ('61', '8', '1', '4.7', '10');
INSERT INTO `goods_attr` VALUES ('62', '8', '1', '5.5', '20');
INSERT INTO `goods_attr` VALUES ('63', '8', '2', '64G', '0');
INSERT INTO `goods_attr` VALUES ('64', '8', '3', '深邃黑', '30');
INSERT INTO `goods_attr` VALUES ('65', '8', '3', '月光白', '40');
INSERT INTO `goods_attr` VALUES ('66', '8', '4', '翻盖', '50');
INSERT INTO `goods_attr` VALUES ('67', '8', '5', 'Andriod', '0');

-- ----------------------------
-- Table structure for `goods_pics`
-- ----------------------------
DROP TABLE IF EXISTS `goods_pics`;
CREATE TABLE `goods_pics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pic` varchar(120) DEFAULT NULL,
  `sm_pic` varchar(120) DEFAULT NULL,
  `goods_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='商品图片表';

-- ----------------------------
-- Records of goods_pics
-- ----------------------------
INSERT INTO `goods_pics` VALUES ('1', 'uploads/20160805/14703659253300.jpg', 'uploads/20160805/thumb_014703659253300.jpg', '1');
INSERT INTO `goods_pics` VALUES ('2', 'uploads/20160805/14703659256920.jpg', 'uploads/20160805/thumb_014703659256920.jpg', '1');
INSERT INTO `goods_pics` VALUES ('3', 'uploads/20160805/14703660568477.jpg', 'uploads/20160805/thumb_014703660568477.jpg', '2');
INSERT INTO `goods_pics` VALUES ('4', 'uploads/20160805/14703660562546.jpg', 'uploads/20160805/thumb_014703660562546.jpg', '2');
INSERT INTO `goods_pics` VALUES ('5', 'uploads/20160805/14703660564861.jpg', 'uploads/20160805/thumb_014703660564861.jpg', '2');
INSERT INTO `goods_pics` VALUES ('6', 'uploads/20160805/14703661702621.jpg', 'uploads/20160805/thumb_014703661702621.jpg', '3');
INSERT INTO `goods_pics` VALUES ('7', 'uploads/20160805/14703661701063.jpg', 'uploads/20160805/thumb_014703661701063.jpg', '3');
INSERT INTO `goods_pics` VALUES ('8', 'uploads/20160805/14703661703533.jpg', 'uploads/20160805/thumb_014703661703533.jpg', '3');
INSERT INTO `goods_pics` VALUES ('9', 'uploads/20160805/14703662811546.jpg', 'uploads/20160805/thumb_014703662811546.jpg', '4');
INSERT INTO `goods_pics` VALUES ('10', 'uploads/20160805/14703662812502.jpg', 'uploads/20160805/thumb_014703662812502.jpg', '4');
INSERT INTO `goods_pics` VALUES ('11', 'uploads/20160805/14703664007614.jpg', 'uploads/20160805/thumb_014703664007614.jpg', '5');
INSERT INTO `goods_pics` VALUES ('12', 'uploads/20160805/14703664009979.jpg', 'uploads/20160805/thumb_014703664009979.jpg', '5');
INSERT INTO `goods_pics` VALUES ('13', 'uploads/20160805/14703664002763.jpg', 'uploads/20160805/thumb_014703664002763.jpg', '5');
INSERT INTO `goods_pics` VALUES ('14', 'uploads/20160805/14703664893593.jpg', 'uploads/20160805/thumb_014703664893593.jpg', '6');
INSERT INTO `goods_pics` VALUES ('15', 'uploads/20160805/14703664896076.jpg', 'uploads/20160805/thumb_014703664896076.jpg', '6');
INSERT INTO `goods_pics` VALUES ('16', 'uploads/20160805/14703666087454.jpg', 'uploads/20160805/thumb_014703666087454.jpg', '7');
INSERT INTO `goods_pics` VALUES ('17', 'uploads/20160805/14703666083091.jpg', 'uploads/20160805/thumb_014703666083091.jpg', '7');
INSERT INTO `goods_pics` VALUES ('18', 'uploads/20160805/14703666083818.jpg', 'uploads/20160805/thumb_014703666083818.jpg', '7');
INSERT INTO `goods_pics` VALUES ('19', 'uploads/20160805/14703983956240.jpg', 'uploads/20160805/thumb_014703983956240.jpg', '8');
INSERT INTO `goods_pics` VALUES ('20', 'uploads/20160805/14703983955600.jpg', 'uploads/20160805/thumb_014703983955600.jpg', '8');

-- ----------------------------
-- Table structure for `member_level`
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
-- Records of member_level
-- ----------------------------
INSERT INTO `member_level` VALUES ('1', '初级会员', '0', '1000', '100');
INSERT INTO `member_level` VALUES ('2', '中级会员', '1001', '2000', '98');
INSERT INTO `member_level` VALUES ('3', '高级会员', '2001', '3001', '92');

-- ----------------------------
-- Table structure for `member_price`
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
-- Records of member_price
-- ----------------------------
INSERT INTO `member_price` VALUES ('1', '1', '1', '5180');
INSERT INTO `member_price` VALUES ('2', '1', '2', '5160');
INSERT INTO `member_price` VALUES ('3', '1', '3', '5200');
INSERT INTO `member_price` VALUES ('4', '2', '1', '-1');
INSERT INTO `member_price` VALUES ('5', '2', '2', '-1');
INSERT INTO `member_price` VALUES ('6', '2', '3', '-1');
INSERT INTO `member_price` VALUES ('7', '3', '1', '890');
INSERT INTO `member_price` VALUES ('8', '3', '2', '880');
INSERT INTO `member_price` VALUES ('9', '3', '3', '850');
INSERT INTO `member_price` VALUES ('10', '4', '1', '2480');
INSERT INTO `member_price` VALUES ('11', '4', '2', '2460');
INSERT INTO `member_price` VALUES ('12', '4', '3', '2400');
INSERT INTO `member_price` VALUES ('13', '5', '1', '5680');
INSERT INTO `member_price` VALUES ('14', '5', '2', '5660');
INSERT INTO `member_price` VALUES ('15', '5', '3', '5600');
INSERT INTO `member_price` VALUES ('16', '6', '1', '1990');
INSERT INTO `member_price` VALUES ('17', '6', '2', '1970');
INSERT INTO `member_price` VALUES ('18', '6', '3', '1900');
INSERT INTO `member_price` VALUES ('19', '7', '1', '-1');
INSERT INTO `member_price` VALUES ('20', '7', '2', '-1');
INSERT INTO `member_price` VALUES ('21', '7', '3', '-1');
INSERT INTO `member_price` VALUES ('22', '8', '1', '-1');
INSERT INTO `member_price` VALUES ('23', '8', '2', '-1');
INSERT INTO `member_price` VALUES ('24', '8', '3', '-1');

-- ----------------------------
-- Table structure for `migration`
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', '1469697406');
INSERT INTO `migration` VALUES ('m130524_201442_init', '1469697413');

-- ----------------------------
-- Table structure for `type`
-- ----------------------------
DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='商品类型表';

-- ----------------------------
-- Records of type
-- ----------------------------
INSERT INTO `type` VALUES ('1', '手机');
INSERT INTO `type` VALUES ('2', '电脑');
INSERT INTO `type` VALUES ('3', '书');
INSERT INTO `type` VALUES ('4', '美妆');

-- ----------------------------
-- Table structure for `user`
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
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', 'ZeuOmVsQYU5aiCvSOwA5-BRsSNd8dp6U', '$2y$13$TLsdsv6cvgFVp0wmnPjZf.OUzbpWcQB6v.u.8DjiXXx1hfT3xipEy', null, 'admin@123.com', '10', '1469698521', '1469698521');
