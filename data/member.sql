/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : member

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2016-05-04 16:13:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tp_cart`
-- ----------------------------
DROP TABLE IF EXISTS `tp_cart`;
CREATE TABLE `tp_cart` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL COMMENT '会员ID',
  `sid` text COMMENT '会员卡ID',
  `username` text COMMENT '会员帐号',
  `startime` text NOT NULL,
  `endtime` text NOT NULL,
  `createtime` text NOT NULL,
  `erweima` text,
  `jihuotime` text,
  `lock` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_cart
-- ----------------------------
INSERT INTO `tp_cart` VALUES ('50', '12', '07772863391', '880', '', '', '1462096479', 'Public/Images/twoCode/201605011754391139.png', null, '1');

-- ----------------------------
-- Table structure for `tp_log`
-- ----------------------------
DROP TABLE IF EXISTS `tp_log`;
CREATE TABLE `tp_log` (
  `aid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL,
  `sid` text COMMENT '订单编号',
  `pid` int(10) DEFAULT NULL,
  `xftype` int(11) DEFAULT NULL,
  `username` text,
  `usercname` text,
  `zhekou` float DEFAULT NULL,
  `xftime` text,
  `xfaddress` text,
  `logtime` text,
  `price` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `pay` text,
  `num` int(11) DEFAULT NULL,
  `danwei` text,
  `shopname` text,
  `paystatus` int(11) DEFAULT NULL,
  `cprice` int(11) DEFAULT NULL,
  `shop_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_log
-- ----------------------------
INSERT INTO `tp_log` VALUES ('12', '12', '20160430104858724188', '12', '1', '8801', '八寨沟', null, '1461984538', null, '1461984538', '0', '1', '会员卡', '1', '次', '三娘湾景区', '1', '0', '0');

-- ----------------------------
-- Table structure for `tp_news`
-- ----------------------------
DROP TABLE IF EXISTS `tp_news`;
CREATE TABLE `tp_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `pic` text,
  `sub_user` text,
  `content` text,
  `createtime` text,
  `px` int(11) DEFAULT NULL,
  `falg` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_news
-- ----------------------------
INSERT INTO `tp_news` VALUES ('1', 'Hello World!', null, null, 'What Are You Doing!', null, null, '1');
INSERT INTO `tp_news` VALUES ('2', 'How Are You', null, null, 'Am F Thank You', null, null, '1');
INSERT INTO `tp_news` VALUES ('3', '测试测试', null, null, '<img style=\'max-width:60%;\' src=\'/Uploads/20160422/201604221058394068.jpg\' /><br />', '1461295905', null, null);
INSERT INTO `tp_news` VALUES ('4', '春天里', '/Uploads', null, '如果有一天我悄然离去。', '1461296089', null, null);
INSERT INTO `tp_news` VALUES ('6', 'Fmpic', '/Uploads', null, '哈哈<br /><img style=\'max-width:60%;\' src=\'/Uploads/20160422/201604221139199986.jpg\' /><br />What The Fuck.', '1461296405', null, null);

-- ----------------------------
-- Table structure for `tp_product`
-- ----------------------------
DROP TABLE IF EXISTS `tp_product`;
CREATE TABLE `tp_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `product` text NOT NULL,
  `url` text NOT NULL,
  `yuanjia` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `kucun` int(11) DEFAULT NULL,
  `danwei` text NOT NULL,
  `times` text NOT NULL,
  `sjtype` text NOT NULL,
  `guige` text,
  `body` text,
  `shopCName` text,
  `shopAddress` text,
  `runTime` text,
  `maxNum` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_product
-- ----------------------------
INSERT INTO `tp_product` VALUES ('1', '7', '三娘湾门票', '/public/images/default.jpg', '998', '40', '-1', '张', '123456789', '门票', null, '扁担弯扁担长，扁担想绑在板凳上，扁担宽，扁担长，板凳骗骗不让扁担绑在板凳上', '三娘湾景区', '钦州市钦南区建安街6号4楼', '每天8：00 ~ 17：30', '10');

-- ----------------------------
-- Table structure for `tp_type`
-- ----------------------------
DROP TABLE IF EXISTS `tp_type`;
CREATE TABLE `tp_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typename` text NOT NULL,
  `px` int(10) unsigned zerofill NOT NULL,
  `url` text,
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_type
-- ----------------------------
INSERT INTO `tp_type` VALUES ('1', '商家管理', '0000000000', '/index.php/home/index/lists', '10');
INSERT INTO `tp_type` VALUES ('2', '会员卡管理', '0000000000', '/index.php/home/vip/viplists', '10');
INSERT INTO `tp_type` VALUES ('3', '消费管理', '0000000000', '/index.php/home/index/loglists', '10');
INSERT INTO `tp_type` VALUES ('4', '菜单管理', '0000000000', '/index.php/home/index/menulists', '10');
INSERT INTO `tp_type` VALUES ('5', '会员卡注册', '0000000000', '/index.php/home/vip/vipregister', '5');


-- ----------------------------
-- Table structure for `tp_user`
-- ----------------------------
DROP TABLE IF EXISTS `tp_user`;
CREATE TABLE `tp_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `cid` int(11) DEFAULT NULL,
  `jifen` int(10) unsigned DEFAULT '0',
  `password` text NOT NULL,
  `level` int(2) DEFAULT NULL,
  `zhekou` float(5,2) DEFAULT NULL,
  `address` text,
  `jiesuan` int(11) DEFAULT NULL,
  `card` text,
  `tel` text,
  `pic` text,
  `email` text,
  `regtime` text NOT NULL,
  `status` int(10) unsigned zerofill DEFAULT NULL,
  `yuanjia` int(11) unsigned DEFAULT NULL,
  `zhekoujia` int(11) DEFAULT NULL,
  `usercname` text,
  `avatar` text,
  `cartstatus` int(10) unsigned zerofill DEFAULT NULL,
  `about` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_user
-- ----------------------------
INSERT INTO `tp_user` VALUES ('11', 'admin', null, '0', '21232f297a57a5a743894a0e4a801fc3', '10', null, null, null, null, '', null, null, '', '0000000001', null, null, null, null, '0000000000', null);
INSERT INTO `tp_user` VALUES ('12', '880', '1', '0', 'f350340d1bcc455729232fb995070ac6', '5', '5.00', '三娘湾景区', '30', '', '13307771522', '/Public/images/3.jpg', '', '1461635667', '0000000000', '12', '10', '三娘湾景区', null, '0000000001', null);
INSERT INTO `tp_user` VALUES ('13', '8801', '1', '0', 'f350340d1bcc455729232fb995070ac6', '5', '0.00', '八寨沟', '30', null, '13307771522', '/Public/images/3.jpg', '', '1461635746', '0000000001', '50', '40', '八寨沟', null, '0000000000', null);
INSERT INTO `tp_user` VALUES ('14', '8802', null, '0', 'f350340d1bcc455729232fb995070ac6', '0', '8.80', '111', '30', null, '13307771522', null, null, '1461636036', '0000000001', null, null, '测试用户', null, '0000000000', null);
INSERT INTO `tp_user` VALUES ('15', '8803', '1', '0', '', '0', null, null, null, '450', '123', null, null, '1462006315', '0000000001', null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `tp_verify`
-- ----------------------------
DROP TABLE IF EXISTS `tp_verify`;
CREATE TABLE `tp_verify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rand` int(11) NOT NULL,
  `datetime` text NOT NULL,
  `call` text NOT NULL,
  `subtime` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_verify
-- ----------------------------
