/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : resume

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2017-08-14 16:04:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cv_member
-- ----------------------------
DROP TABLE IF EXISTS `cv_member`;
CREATE TABLE `cv_member` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `nick_name` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称全拼用于加密',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员基础表';

-- ----------------------------
-- Records of cv_member
-- ----------------------------
INSERT INTO `cv_member` VALUES ('1', '501986411@qq.com', '噢，我想多了', '2a73071fffec0ea79d2659bcdf2c81e8', 'chenhailong');

-- ----------------------------
-- Table structure for cv_resume_module
-- ----------------------------
DROP TABLE IF EXISTS `cv_resume_module`;
CREATE TABLE `cv_resume_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '模块名称',
  `status` tinyint(11) NOT NULL DEFAULT '1' COMMENT '1启用，0：停用',
  `is_must` tinyint(11) NOT NULL DEFAULT '0' COMMENT '0：选填，1.必填',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='简历内容没款配置';

-- ----------------------------
-- Records of cv_resume_module
-- ----------------------------
