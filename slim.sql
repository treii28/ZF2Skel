/*
Navicat MySQL Data Transfer

Source Server         : root@localhost
Source Server Version : 50540
Source Host           : 127.0.0.1:3306
Source Database       : slim

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2014-12-18 17:58:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `Addresses`
-- ----------------------------
DROP TABLE IF EXISTS `Addresses`;
CREATE TABLE `Addresses` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `address1` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`address_id`),
  KEY `IDX_ED3BF7B5A76ED395` (`user_id`),
  CONSTRAINT `FK_ED3BF7B5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of Addresses
-- ----------------------------
INSERT INTO `Addresses` VALUES ('1', '1', 'treii28@yahoo.com', 'Scott', 'Webster', 'Wood', '6046 S Miami St', 'Apt B', 'Ypsilanti', 'MI', 'USA', '48197', '7349680917');
INSERT INTO `Addresses` VALUES ('2', '1', 'scottw@finaoonline.com', 'Scott', 'Webster', 'Wood', '200 W Bennett St', 'Attn: IT', 'Saline', 'MI', 'USA', '48176', '734-944-2528');

-- ----------------------------
-- Table structure for `Users`
-- ----------------------------
DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of Users
-- ----------------------------
INSERT INTO `Users` VALUES ('1', 'treii28@yahoo.com', 'Scott', 'Webster', 'Wood', '7349680917');
INSERT INTO `Users` VALUES ('2', 'klynntg@hotmail.com', 'Catherine', 'Lynn', 'Smith', '3135551212');
