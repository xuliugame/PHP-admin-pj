/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : events

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2020-10-03 23:37:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for attendee
-- ----------------------------
DROP TABLE IF EXISTS `attendee`;
CREATE TABLE `attendee` (
  `idattendee` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` int(11) DEFAULT NULL,
  PRIMARY KEY (`idattendee`),
  KEY `role_idx` (`role`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of attendee
-- ----------------------------
INSERT INTO `attendee` VALUES ('1', 'admin', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '1');
INSERT INTO `attendee` VALUES ('2', 'tom', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '1');
INSERT INTO `attendee` VALUES ('3', 'jack', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2');
INSERT INTO `attendee` VALUES ('4', 'rose', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '3');
INSERT INTO `attendee` VALUES ('5', 'william', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2');
INSERT INTO `attendee` VALUES ('6', 'jam', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '3');

-- ----------------------------
-- Table structure for attendee_event
-- ----------------------------
DROP TABLE IF EXISTS `attendee_event`;
CREATE TABLE `attendee_event` (
  `event` int(11) NOT NULL,
  `attendee` int(11) NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event`,`attendee`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of attendee_event
-- ----------------------------
INSERT INTO `attendee_event` VALUES ('101', '4', '20');
INSERT INTO `attendee_event` VALUES ('101', '6', '20');
INSERT INTO `attendee_event` VALUES ('102', '4', '30');
INSERT INTO `attendee_event` VALUES ('103', '6', '40');

-- ----------------------------
-- Table structure for attendee_session
-- ----------------------------
DROP TABLE IF EXISTS `attendee_session`;
CREATE TABLE `attendee_session` (
  `session` int(11) NOT NULL,
  `attendee` int(11) NOT NULL,
  PRIMARY KEY (`session`,`attendee`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of attendee_session
-- ----------------------------
INSERT INTO `attendee_session` VALUES ('1', '4');
INSERT INTO `attendee_session` VALUES ('1', '6');
INSERT INTO `attendee_session` VALUES ('2', '4');
INSERT INTO `attendee_session` VALUES ('3', '6');

-- ----------------------------
-- Table structure for event
-- ----------------------------
DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `idevent` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `datestart` datetime NOT NULL,
  `dateend` datetime NOT NULL,
  `numberallowed` int(11) NOT NULL,
  `venue` int(11) NOT NULL,
  PRIMARY KEY (`idevent`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `venue_fk_idx` (`venue`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of event
-- ----------------------------
INSERT INTO `event` VALUES ('101', 'Event101', '2020-09-26 11:24:24', '2020-09-30 11:24:29', '80', '1');
INSERT INTO `event` VALUES ('102', 'Event102', '2020-10-02 11:24:24', '2020-10-14 11:24:29', '60', '2');
INSERT INTO `event` VALUES ('103', 'Event103', '2020-10-13 11:24:24', '2020-10-29 11:24:29', '40', '3');
INSERT INTO `event` VALUES ('105', '1', '2020-10-01 10:00:00', '2020-10-09 12:00:00', '50', '11');

-- ----------------------------
-- Table structure for manager_event
-- ----------------------------
DROP TABLE IF EXISTS `manager_event`;
CREATE TABLE `manager_event` (
  `event` int(11) NOT NULL,
  `manager` int(11) NOT NULL,
  PRIMARY KEY (`event`,`manager`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of manager_event
-- ----------------------------
INSERT INTO `manager_event` VALUES ('101', '2');
INSERT INTO `manager_event` VALUES ('101', '3');
INSERT INTO `manager_event` VALUES ('102', '2');
INSERT INTO `manager_event` VALUES ('102', '3');
INSERT INTO `manager_event` VALUES ('103', '2');
INSERT INTO `manager_event` VALUES ('103', '5');

-- ----------------------------
-- Table structure for registration
-- ----------------------------
DROP TABLE IF EXISTS `registration`;
CREATE TABLE `registration` (
  `idregistration` int(11) NOT NULL AUTO_INCREMENT,
  `attendee` int(11) NOT NULL,
  `accept` tinyint(1) NOT NULL DEFAULT '0',
  `session` int(11) DEFAULT NULL,
  PRIMARY KEY (`idregistration`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of registration
-- ----------------------------
INSERT INTO `registration` VALUES ('1', '5', '1', '2');

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `idrole` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`idrole`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', 'admin');
INSERT INTO `role` VALUES ('2', 'event manager');
INSERT INTO `role` VALUES ('3', 'attendee');

-- ----------------------------
-- Table structure for session
-- ----------------------------
DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `idsession` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `numberallowed` int(11) NOT NULL,
  `event` int(11) NOT NULL,
  `startdate` datetime NOT NULL,
  `enddate` datetime NOT NULL,
  PRIMARY KEY (`idsession`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of session
-- ----------------------------
INSERT INTO `session` VALUES ('1', 'session for event101', '30', '101', '2020-09-26 14:34:47', '2020-09-28 14:34:53');
INSERT INTO `session` VALUES ('2', 'session for event102', '20', '102', '2020-10-04 14:34:47', '2020-10-06 14:34:53');
INSERT INTO `session` VALUES ('3', 'session for event103', '35', '103', '2020-10-21 14:34:47', '2020-10-26 14:34:53');

-- ----------------------------
-- Table structure for venue
-- ----------------------------
DROP TABLE IF EXISTS `venue`;
CREATE TABLE `venue` (
  `idvenue` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  PRIMARY KEY (`idvenue`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of venue
-- ----------------------------
INSERT INTO `venue` VALUES ('1', 'B101', '100');
INSERT INTO `venue` VALUES ('2', 'H201', '80');
INSERT INTO `venue` VALUES ('3', 'H102', '60');
