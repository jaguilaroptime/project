/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50711
Source Host           : localhost:3306
Source Database       : symfony

Target Server Type    : MYSQL
Target Server Version : 50711
File Encoding         : 65001

Date: 2017-03-05 19:57:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `trademark` varchar(100) NOT NULL,
  `category` int(11) NOT NULL,
  `price` float(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `NameUnique` (`name`),
  UNIQUE KEY `CodeUnique` (`code`),
  KEY `fk_category` (`category`),
  CONSTRAINT `fk_category` FOREIGN KEY (`category`) REFERENCES `product_category` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('5', '4561234', 'HP Envy x360', '360 o endless versatility', 'HP', '2', '1456897.00');
INSERT INTO `product` VALUES ('6', '1234567', 'Smartphone g33', 'Muy rápidoo', 'Motorolaa', '2', '123456.00');
INSERT INTO `product` VALUES ('7', 'dads3213', 'Portatíl', 'dasdASD', 'dasd', '1', '213.00');
INSERT INTO `product` VALUES ('8', '3123123', 'Billetera de cuero', 'Puro Cuero', 'Velez', '3', '129999.99');
INSERT INTO `product` VALUES ('12', '233ftg', 'Portatil MAC', 'dasd', 'dasd', '3', '123.00');
INSERT INTO `product` VALUES ('13', 'Jeenson123', 'Telefono', 'Telefono Fijjo', 'Grandstream', '2', '123.12');
INSERT INTO `product` VALUES ('14', 'AB123', 'ABCDEF', 'ABCDE', 'AB', '1', '123456.00');
INSERT INTO `product` VALUES ('16', '23123765', 'Lapicero', 'Para escribir', 'Bic', '3', '152346.00');
INSERT INTO `product` VALUES ('17', '45675', 'Cuaderno', 'Cuadrernos de apuntes importantes', 'Amarillo', '3', '1258.34');

-- ----------------------------
-- Table structure for product_category
-- ----------------------------
DROP TABLE IF EXISTS `product_category`;
CREATE TABLE `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `is_premiun` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_category
-- ----------------------------
INSERT INTO `product_category` VALUES ('1', 'Notebook', '1', '1');
INSERT INTO `product_category` VALUES ('2', 'Desktop', '0', '1');
INSERT INTO `product_category` VALUES ('3', 'Printing', '1', '0');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'jeenson', 'dq6SPE3jat99/bRAHX0Gjn0kSOS1k5MXZoTclakk1egDEwghP18yeeHu6G2nEzvqEsOimhzQre+ZE10f8nE0ww==', 'Hgh3h/KNr+mkJfENpgvcwI08k/ycM8btBMRkvf3+', 'ROLE_USER');
INSERT INTO `user` VALUES ('2', 'admin', 'LXOaND93jNMgXG92ceU9uxIh/7taZrtWTIsxASFcioC9Off45AsPUtnBlypJlYFDWBIUt0kURMBqGCidq+IdOw==', 'Hgh3h/KNr+mkJfENpgvcwI08k/ycM8btBMRkvf3+', 'ROLE_ADMIN');
