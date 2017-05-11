-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        10.1.13-MariaDB - mariadb.org binary distribution
-- 服务器操作系统:                      Win32
-- HeidiSQL 版本:                  9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- 导出 blog 的数据库结构
CREATE DATABASE IF NOT EXISTS `blog` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `blog`;

-- 导出  表 blog.activity 结构
CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` int(11) NOT NULL DEFAULT '0' COMMENT '权重',
  `uid` int(11) NOT NULL COMMENT '操作员uid',
  `slogan` varchar(255) DEFAULT NULL COMMENT '广告或活动标语',
  `comment` varchar(255) NOT NULL COMMENT '描述',
  `linkurl` varchar(255) NOT NULL COMMENT '活动页面链接',
  `filepath` varchar(255) NOT NULL COMMENT 'banner图文件路径',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `is_valid` char(1) NOT NULL COMMENT '是否有效，y有效，n无效',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='广告，活动列表';

-- 正在导出表  blog.activity 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `activity` DISABLE KEYS */;
INSERT INTO `activity` (`id`, `priority`, `uid`, `slogan`, `comment`, `linkurl`, `filepath`, `createtime`, `is_valid`) VALUES
	(1, 1, 15, '123', '123', 'http://www.baidu.com', '/Public/upload/Ad/123456789_15.jpg', 12345678, 'n'),
	(2, 1234546, 15, 'CNBULE', '124346  ', '12345', '/Public/upload/Activity/20170222/thumb1487776333_15.jpg', 1487491095, 'y'),
	(37, 1, 15, '1', '1', '1', '/Public/upload/Activity/20170221/thumb1487690043_15.jpg', 1487690051, 'y'),
	(38, 10, 15, 'CNBLUE', 'CNblue', '', '/Public/upload/Activity/20170312/thumb1489326453_15.jpg', 1489326483, 'y');
/*!40000 ALTER TABLE `activity` ENABLE KEYS */;

-- 导出  表 blog.admin_auth_group 结构
CREATE TABLE IF NOT EXISTS `admin_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '' COMMENT '组别名称',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_manage` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1需要验证权限 2 不需要验证权限',
  `rules` varchar(255) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id， 多个规则',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

-- 正在导出表  blog.admin_auth_group 的数据：2 rows
/*!40000 ALTER TABLE `admin_auth_group` DISABLE KEYS */;
INSERT INTO `admin_auth_group` (`id`, `title`, `status`, `is_manage`, `rules`) VALUES
	(27, '超级管理员', 1, 1, '2,36,14,21,24,25,26,27,22,28,29,30,31,23,32,33,34,35,37,56,57,58,59,54,55,63,64,65,66,38,39,40,41,42,43,44,45,60,61,62,67,46,47,48,49,50,52,53'),
	(28, '编辑', 1, 1, '14,23,32,33,37');
/*!40000 ALTER TABLE `admin_auth_group` ENABLE KEYS */;

-- 导出  表 blog.admin_auth_group_access 结构
CREATE TABLE IF NOT EXISTS `admin_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- 正在导出表  blog.admin_auth_group_access 的数据：2 rows
/*!40000 ALTER TABLE `admin_auth_group_access` DISABLE KEYS */;
INSERT INTO `admin_auth_group_access` (`uid`, `group_id`) VALUES
	(15, 27),
	(16, 28);
/*!40000 ALTER TABLE `admin_auth_group_access` ENABLE KEYS */;

-- 导出  表 blog.admin_auth_rule 结构
CREATE TABLE IF NOT EXISTS `admin_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(100) DEFAULT '' COMMENT '图标',
  `menu_name` varchar(100) NOT NULL DEFAULT '' COMMENT '规则唯一标识Controller/action',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `pid` tinyint(5) NOT NULL DEFAULT '0' COMMENT '菜单ID ',
  `is_menu` tinyint(1) DEFAULT '1' COMMENT '1:是主菜单 2 否',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4;

-- 正在导出表  blog.admin_auth_rule 的数据：61 rows
/*!40000 ALTER TABLE `admin_auth_rule` DISABLE KEYS */;
INSERT INTO `admin_auth_rule` (`id`, `icon`, `menu_name`, `title`, `pid`, `is_menu`, `type`, `status`, `condition`) VALUES
	(2, '', '', '站点统计', 0, 1, 1, 1, ''),
	(4, '&amp;#xe613;', 'User/index', '用户管理', 2, 1, 1, 2, ''),
	(7, 'asdasd', 'asd/asdasd', '三级菜单', 4, 2, 1, 2, ''),
	(14, '', '', '权限管理', 0, 1, 1, 1, ''),
	(9, 'qwe', 'qwe/qweq', 'qwe', 2, 1, 1, 2, ''),
	(10, 'dfgdf', 'dfgdfg/dfgdfg', 'gdfg', 2, 1, 1, 2, ''),
	(11, 'ghjg', 'ghjghj/ghjghjghj', 'hjghj', 0, 1, 1, 2, ''),
	(12, 'sa', 'as/as', 'as', 0, 1, 1, 2, ''),
	(13, '权限管理', '阿萨打算的/阿萨打算的', '阿斯顿', 0, 1, 1, 2, ''),
	(15, '阿斯顿', 'constrolls/constrolls', '名称吗', 4, 2, 1, 2, ''),
	(16, '按时大大', '大阿斯顿阿斯顿/阿斯顿阿斯顿按时', '阿萨打算的', 2, 1, 1, 2, ''),
	(17, '阿斯顿', '阿斯顿阿斯顿asd/阿萨打算的', '阿萨打算的asd', 16, 2, 1, 2, ''),
	(18, '阿斯顿', '阿萨打算的/阿萨打算的', '阿斯顿a', 16, 2, 1, 2, ''),
	(19, '', '', '阿萨打算的', 0, 1, 1, 2, ''),
	(20, 'asd', 'User/addUser', '添加用户', 4, 2, 1, 2, ''),
	(21, '&amp;#xe624;', 'Menu/index', '菜单管理', 14, 1, 1, 1, ''),
	(22, '&amp;#xe612;', 'AuthGroup/authGroupList', '角色管理', 14, 1, 1, 1, ''),
	(23, '&amp;#xe613;', 'User/index', '用户管理', 14, 1, 1, 1, ''),
	(24, '13', 'Menu/addMenu', '添加菜单', 21, 2, 1, 1, ''),
	(25, '213', 'Menu/editMenu', '编辑菜单', 21, 2, 1, 1, ''),
	(26, '435', 'Menu/deleteMenu', '删除菜单', 21, 2, 1, 1, ''),
	(27, '13', 'Menu/viewOpt', '查看三级菜单', 21, 2, 1, 1, ''),
	(28, '123', 'AuthGroup/addGroup', '添加角色', 22, 2, 1, 1, ''),
	(29, '35', 'AuthGroup/editGroup', '编辑角色', 22, 2, 1, 1, ''),
	(30, '345', 'AuthGroup/deleteGroup', '删除角色', 22, 2, 1, 1, ''),
	(31, 'asd', 'AuthGroup/ruleGroup', '分配权限', 22, 2, 1, 1, ''),
	(32, '13', 'User/addUser', '添加用户', 23, 2, 1, 1, ''),
	(33, '324', 'User/editUser', '编辑用户', 23, 2, 1, 1, ''),
	(34, '435', 'User/deleterUser', '删除用户', 23, 2, 1, 1, ''),
	(35, '234', 'AuthGroup/giveRole', '分配角色', 23, 2, 1, 1, ''),
	(36, '&amp;#xe600;', 'Other/guestHistory', '网站详情', 2, 1, 1, 1, ''),
	(37, '', '', '博客管理', 0, 1, 1, 1, ''),
	(38, '', '', '其它管理', 0, 1, 1, 1, ''),
	(39, '&amp;#xe64a;', 'Other/index', '活动管理', 38, 1, 1, 1, ''),
	(40, '&amp;#xe634;', 'Other/releaseAd', '添加活动', 39, 2, 1, 1, ''),
	(41, '&amp;#xe60d;', 'Other/saveImage', '保存图片', 39, 2, 1, 1, ''),
	(42, '&amp;#xe640;', 'Other/delAd', '删除广告', 39, 2, 1, 1, ''),
	(43, '&amp;#xe605;', 'Other/changeStatus', '发布活动', 39, 2, 1, 1, ''),
	(44, '&amp;#xe642;', 'Other/editAd', '编辑活动', 39, 2, 1, 1, ''),
	(45, '&amp;#xe64c;', 'Other/links', '友情链接管理', 38, 1, 1, 1, ''),
	(46, '', 'Category/index', '文章分类管理', 0, 2, 1, 1, ''),
	(47, '&amp;#xe613;', 'Category/life', '生活', 46, 2, 1, 1, ''),
	(48, '&amp;#xe64e;', 'Category/study', '学习', 46, 2, 1, 1, ''),
	(49, '&amp;#xe60c;', 'Category/php', 'PHP', 48, 2, 1, 1, ''),
	(50, '&amp;#xe650;', 'Category/basketball', '运动', 46, 2, 1, 1, ''),
	(56, '&amp;#xe62a;', 'Blog/tag', '标签云管理', 37, 1, 1, 1, ''),
	(52, '&amp;#xe60c;', 'Category/startup', '创业', 46, 2, 1, 1, ''),
	(53, '&amp;#xe64b;', 'Category/internet', '互联网行业', 46, 2, 1, 1, ''),
	(54, '&amp;#xe63c;', 'Blog/index', '文章列表', 37, 1, 1, 1, ''),
	(55, '&amp;#xe654;', 'Blog/addArticle', '添加文章', 54, 2, 1, 1, ''),
	(57, '&amp;#xe608;', 'Blog/addTag', '添加标签', 56, 2, 1, 1, ''),
	(58, '&amp;#xe642;', 'Blog/editTag', '修改标签', 56, 2, 1, 1, ''),
	(59, '&amp;#xe640;', 'Blog/delTag', '删除标签', 56, 2, 1, 1, ''),
	(60, '&amp;#xe654;', 'Other/addLinks', '添加友链', 45, 2, 1, 1, ''),
	(61, '&amp;#xe642;', 'Other/editLinks', '修改友链', 45, 2, 1, 1, ''),
	(62, '&amp;#xe640;', 'Other/delLinks', '删除友链', 45, 2, 1, 1, ''),
	(63, '&amp;#xe654;', 'Blog/saveImage', '添加封面图', 54, 2, 1, 1, ''),
	(64, '&amp;#xe60c;', 'Blog/changeStatus', '文章发布', 54, 2, 1, 1, ''),
	(65, '&amp;#xe640;', 'Blog/delArticle', '删除文章', 54, 2, 1, 1, ''),
	(66, '&amp;#xe642;', 'Blog/editArticle', '修改文章', 54, 2, 1, 1, ''),
	(67, '&amp;#xe60a;', 'Other/showMessage', '留言管理', 38, 1, 1, 1, '');
/*!40000 ALTER TABLE `admin_auth_rule` ENABLE KEYS */;

-- 导出  表 blog.admin_user 结构
CREATE TABLE IF NOT EXISTS `admin_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '数据编号',
  `user_name` varchar(20) NOT NULL COMMENT '登录名',
  `nick_name` varchar(255) NOT NULL COMMENT '用户昵称',
  `password` varchar(32) NOT NULL COMMENT '登录密码',
  `lastlogin_time` int(11) unsigned DEFAULT NULL COMMENT '最后一次登录时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许用户登录(1是  2否)',
  `sex` char(50) NOT NULL DEFAULT '1' COMMENT '性别',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='后台用户表';

-- 正在导出表  blog.admin_user 的数据：~3 rows (大约)
/*!40000 ALTER TABLE `admin_user` DISABLE KEYS */;
INSERT INTO `admin_user` (`id`, `user_name`, `nick_name`, `password`, `lastlogin_time`, `status`, `sex`) VALUES
	(11, 'admin', '', 'e10adc3949ba59abbe56e057f20f883e', 1480572245, 2, '1'),
	(15, 'admin', '青椒白饭', 'e10adc3949ba59abbe56e057f20f883e', 1494513270, 1, 'male'),
	(16, 'test', '', 'e10adc3949ba59abbe56e057f20f883e', 1494316520, 1, 'male');
/*!40000 ALTER TABLE `admin_user` ENABLE KEYS */;

-- 导出  表 blog.article 结构
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '发布人id',
  `cid` int(11) NOT NULL COMMENT '分类id',
  `title` varchar(255) NOT NULL COMMENT '文章标题',
  `described` varchar(255) NOT NULL COMMENT '文章描述',
  `content` text NOT NULL COMMENT '文章内容',
  `isrecommend` char(1) NOT NULL COMMENT '是否推荐，y表示是，n表示否',
  `istop` char(1) NOT NULL COMMENT '是否置顶，y表示是，n表示否',
  `artpicture` varchar(255) NOT NULL COMMENT '标题图片',
  `is_valid` char(1) NOT NULL COMMENT '是否有效，发布是y，删除是n',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `readcounts` int(11) NOT NULL COMMENT '阅读量',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- 正在导出表  blog.article 的数据：~6 rows (大约)
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` (`id`, `uid`, `cid`, `title`, `described`, `content`, `isrecommend`, `istop`, `artpicture`, `is_valid`, `createtime`, `readcounts`) VALUES
	(30, 15, 47, '一次就好啦啦啦', '啦啦啦啦啦', '&lt;p&gt;测试啦啦啦法法&lt;/p&gt;', 'y', 'y', '/Public/upload/Article/20170501/1493651651_15.jpg', 'y', 1493628587, 3),
	(31, 15, 52, '其实很简单', '我想你是爱我的', '&lt;p&gt;放假啊路口监控了首付款了撒富兰克林积分分开了跟家里了&lt;/p&gt;', 'n', 'y', '/Public/upload/Article/20170503/1493824823_15.jpg', 'y', 1493824855, 2),
	(32, 15, 49, 'test', '1315643123', '&lt;p&gt;拉拉裤房间爱思考了房间卡福建高速&lt;/p&gt;', 'n', 'n', '/Public/upload/Article/20170506/1494081466_15.jpg', 'y', 1494081491, 8),
	(34, 15, 49, 'test', '1315643123', '&lt;p&gt;拉拉裤房间爱思考了房间卡福建高速&lt;/p&gt;', 'n', 'n', '/Public/upload/Article/20170506/1494081466_15.jpg', 'y', 1494081491, 0),
	(35, 15, 49, 'test', '1315643123', '&lt;p&gt;拉拉裤房间爱思考了房间卡福建高速&lt;/p&gt;', 'n', 'n', '/Public/upload/Article/20170506/1494081466_15.jpg', 'y', 1494081491, 2),
	(36, 15, 49, 'test', '1315643123', '&lt;p&gt;拉拉裤房间爱思考了房间卡福建高速&lt;/p&gt;', 'n', 'n', '/Public/upload/Article/20170506/1494081466_15.jpg', 'y', 1494081491, 0),
	(37, 15, 49, 'test', '1315643123', '&lt;p&gt;拉拉裤房间爱思考了房间卡福建高速&lt;/p&gt;', 'n', 'n', '/Public/upload/Article/20170506/1494081466_15.jpg', 'y', 1494081491, 0);
/*!40000 ALTER TABLE `article` ENABLE KEYS */;

-- 导出  表 blog.article_tag_relate 结构
CREATE TABLE IF NOT EXISTS `article_tag_relate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL COMMENT '文章id',
  `tid` int(11) NOT NULL COMMENT '标签id',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `is_valid` char(1) NOT NULL COMMENT '是否有效',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  KEY `tid` (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 COMMENT='文章标签关联表';

-- 正在导出表  blog.article_tag_relate 的数据：~8 rows (大约)
/*!40000 ALTER TABLE `article_tag_relate` DISABLE KEYS */;
INSERT INTO `article_tag_relate` (`id`, `aid`, `tid`, `createtime`, `is_valid`) VALUES
	(21, 30, 2, 1493628587, 'y'),
	(22, 30, 3, 1493628587, 'y'),
	(23, 31, 4, 1493824855, 'y'),
	(24, 31, 3, 1493824855, 'y'),
	(25, 32, 5, 1494081491, 'y'),
	(26, 32, 4, 1494081491, 'y'),
	(27, 32, 3, 1494081491, 'y'),
	(28, 32, 2, 1494081491, 'y');
/*!40000 ALTER TABLE `article_tag_relate` ENABLE KEYS */;

-- 导出  表 blog.guest 结构
CREATE TABLE IF NOT EXISTS `guest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL COMMENT 'IP地址',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `record_id` int(11) NOT NULL COMMENT '文章id，0表示为访问首页',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=708 DEFAULT CHARSET=latin1 COMMENT='访客记录表';

-- 正在导出表  blog.guest 的数据：~575 rows (大约)
/*!40000 ALTER TABLE `guest` DISABLE KEYS */;
INSERT INTO `guest` (`id`, `ip_address`, `addtime`, `record_id`) VALUES
	(1, '::1', 1489308232, 0),
	(2, '::1', 1489325957, 0),
	(3, '::1', 1489590015, 0),
	(4, '::1', 1489590083, 0),
	(5, '::1', 1489590401, 0),
	(6, '::1', 1489590463, 0),
	(7, '::1', 1489591414, 0),
	(8, '::1', 1489591434, 0),
	(9, '::1', 1489591711, 0),
	(10, '::1', 1489591754, 0),
	(11, '::1', 1489591772, 0),
	(12, '::1', 1489591951, 0),
	(13, '::1', 1489592030, 0),
	(14, '::1', 1489592049, 0),
	(15, '::1', 1489592093, 0),
	(16, '::1', 1489592103, 0),
	(17, '::1', 1489592122, 0),
	(18, '::1', 1489592136, 0),
	(19, '::1', 1489592157, 0),
	(20, '::1', 1489592158, 0),
	(21, '::1', 1489592188, 0),
	(22, '::1', 1489592188, 0),
	(23, '::1', 1489592189, 0),
	(24, '::1', 1489592190, 0),
	(25, '::1', 1489592211, 0),
	(26, '::1', 1489592211, 0),
	(27, '::1', 1489592357, 0),
	(28, '::1', 1489592357, 0),
	(29, '::1', 1489592472, 0),
	(30, '::1', 1489592504, 0),
	(31, '::1', 1489592505, 0),
	(32, '::1', 1489592605, 0),
	(33, '::1', 1489592605, 0),
	(34, '::1', 1489592639, 0),
	(35, '::1', 1489592639, 0),
	(36, '::1', 1489592668, 0),
	(37, '::1', 1489592668, 0),
	(38, '::1', 1489592747, 0),
	(39, '::1', 1489592748, 0),
	(40, '::1', 1489592750, 0),
	(41, '::1', 1489592751, 0),
	(42, '::1', 1489592755, 0),
	(43, '::1', 1489592755, 0),
	(44, '::1', 1489592882, 0),
	(45, '::1', 1489592882, 0),
	(46, '::1', 1489593202, 0),
	(47, '::1', 1489593202, 0),
	(48, '::1', 1489593255, 0),
	(49, '::1', 1489593255, 0),
	(50, '::1', 1489593328, 0),
	(51, '::1', 1489593329, 0),
	(52, '::1', 1489593363, 0),
	(53, '::1', 1489593364, 0),
	(54, '::1', 1489593428, 0),
	(55, '::1', 1489593429, 0),
	(56, '::1', 1489673673, 0),
	(57, '::1', 1489673678, 0),
	(58, '::1', 1489675711, 0),
	(59, '::1', 1489675739, 0),
	(60, '::1', 1489675778, 0),
	(61, '::1', 1489675829, 0),
	(62, '::1', 1489675882, 0),
	(63, '::1', 1489675915, 0),
	(64, '::1', 1489675928, 0),
	(65, '::1', 1489675936, 0),
	(66, '::1', 1489675974, 0),
	(67, '::1', 1489676025, 0),
	(68, '::1', 1489676045, 0),
	(69, '::1', 1489676069, 0),
	(70, '::1', 1489676110, 0),
	(71, '::1', 1489676140, 0),
	(72, '::1', 1489676145, 0),
	(73, '::1', 1489676163, 0),
	(74, '::1', 1489676355, 0),
	(75, '::1', 1489676385, 0),
	(76, '::1', 1489676385, 0),
	(77, '::1', 1489676386, 0),
	(78, '::1', 1489676386, 0),
	(79, '::1', 1489676390, 0),
	(80, '::1', 1489676403, 0),
	(81, '::1', 1489676562, 0),
	(82, '::1', 1489676637, 0),
	(83, '::1', 1489676646, 0),
	(84, '::1', 1489676698, 0),
	(85, '::1', 1489676713, 0),
	(86, '::1', 1489676828, 0),
	(87, '::1', 1489676830, 0),
	(88, '::1', 1489676843, 0),
	(89, '::1', 1489676844, 0),
	(90, '::1', 1489676859, 0),
	(91, '::1', 1489676861, 0),
	(92, '::1', 1489676887, 0),
	(93, '::1', 1489676908, 0),
	(94, '::1', 1489676912, 0),
	(95, '::1', 1489676920, 0),
	(96, '::1', 1489676921, 0),
	(97, '::1', 1489676926, 0),
	(98, '::1', 1489676934, 0),
	(99, '::1', 1489677037, 0),
	(100, '::1', 1489677067, 0);
	
/*!40000 ALTER TABLE `guest` ENABLE KEYS */;

-- 导出  表 blog.links 结构
CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '添加人',
  `linkname` varchar(255) NOT NULL COMMENT '链接名称',
  `linkurl` varchar(255) NOT NULL COMMENT '链接地址',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `is_valid` char(1) NOT NULL COMMENT '是否有效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='友情链接表';

-- 正在导出表  blog.links 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `links` DISABLE KEYS */;
INSERT INTO `links` (`id`, `uid`, `linkname`, `linkurl`, `createtime`, `is_valid`) VALUES
	(1, 15, 'dadas', 'http://www.sina.cn', 1488644651, 'n'),
	(2, 15, '百度', 'http://www.baidu.com', 1488644738, 'y'),
	(3, 15, 'test', 'http://www.google.com', 1488724062, 'n'),
	(4, 15, 'ThinkPHP', 'http://www.thinkphp.cn', 1488726086, 'y'),
	(5, 15, '腾讯', 'http://www.qq.com', 1488726271, 'y');
/*!40000 ALTER TABLE `links` ENABLE KEYS */;

-- 导出  表 blog.message 结构
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact` varchar(50) NOT NULL COMMENT '联系方式',
  `content` varchar(255) NOT NULL COMMENT '留言内容',
  `addtime` int(11) NOT NULL COMMENT '留言时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COMMENT='留言板';

-- 正在导出表  blog.message 的数据：~8 rows (大约)
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` (`id`, `contact`, `content`, `addtime`) VALUES
	(1, '15622127355', 'hello', 1489977150),
	(2, '776080531@qq.com', 'lalaalla', 1489977200),
	(3, '776080531@qq.com', '12356465', 1494170099),
	(4, '776080531@qq.com', '12356465', 1494170112),
	(5, '1246546', '1321654      ', 1494170957),
	(6, '1246546', '1321654      ', 1494170977),
	(7, '1246546', '1321654      ', 1494171113),
	(8, '1246546', '1321654      ', 1494171139),
	(9, '776080531', '12345132465      ', 1494171241),
	(10, 'SAY SOMETHING', '1234656', 1494171293),
	(11, '13750595514', '123456\n      ', 1494513725);
/*!40000 ALTER TABLE `message` ENABLE KEYS */;

-- 导出  表 blog.tag 结构
CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `tagname` varchar(50) NOT NULL COMMENT '标签名称',
  `createtime` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='标签云管理';

-- 正在导出表  blog.tag 的数据：~5 rows (大约)
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` (`id`, `uid`, `tagname`, `createtime`) VALUES
	(2, 15, '测试', 1488554493),
	(3, 15, '学习', 1488554731),
	(4, 15, 'PHP', 1488556851),
	(5, 15, '互联网', 1491312363),
	(6, 15, '测试啦', 1494151732);
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
