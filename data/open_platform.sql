/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : open_platform

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-07-27 15:03:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `op_admin`
-- ----------------------------
DROP TABLE IF EXISTS `op_admin`;
CREATE TABLE `op_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '账户状态 1：正常 2：锁定',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of op_admin
-- ----------------------------

-- ----------------------------
-- Table structure for `op_api`
-- ----------------------------
DROP TABLE IF EXISTS `op_api`;
CREATE TABLE `op_api` (
  `id` int(11) NOT NULL,
  `api_name` varchar(50) NOT NULL COMMENT '接口名称',
  `api_url` varchar(255) NOT NULL COMMENT '接口地址',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '接口类型  1：微信',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '接口状态 1：启用  2停用',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='接口表';

-- ----------------------------
-- Records of op_api
-- ----------------------------

-- ----------------------------
-- Table structure for `op_api_apply`
-- ----------------------------
DROP TABLE IF EXISTS `op_api_apply`;
CREATE TABLE `op_api_apply` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '使用人id',
  `aid` int(11) NOT NULL COMMENT '接口id',
  `rate` tinyint(4) NOT NULL DEFAULT '1' COMMENT '调用速率 1: 10/mins 2: 30/mins 3:50/mins',
  `is_agree` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否同意 0：待审核 1：通过 2：不通过',
  `created_at` int(11) NOT NULL COMMENT '申请时间',
  `agree_time` int(11) DEFAULT NULL COMMENT '通过时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='api申请表';

-- ----------------------------
-- Records of op_api_apply
-- ----------------------------

-- ----------------------------
-- Table structure for `op_key`
-- ----------------------------
DROP TABLE IF EXISTS `op_key`;
CREATE TABLE `op_key` (
  `id` int(11) NOT NULL,
  `apply_id` int(11) NOT NULL COMMENT '申请记录id',
  `key` varchar(255) NOT NULL COMMENT 'key',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='密钥表';

-- ----------------------------
-- Records of op_key
-- ----------------------------

-- ----------------------------
-- Table structure for `op_user`
-- ----------------------------
DROP TABLE IF EXISTS `op_user`;
CREATE TABLE `op_user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL COMMENT '用户名(手机号)',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `project` varchar(50) DEFAULT NULL COMMENT '项目',
  `department` varchar(50) DEFAULT NULL COMMENT '部门',
  `qq` varchar(15) DEFAULT NULL COMMENT 'qq',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of op_user
-- ----------------------------
