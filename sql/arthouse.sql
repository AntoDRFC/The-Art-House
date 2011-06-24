/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Version : 50149
 Source Host           : localhost
 Source Database       : arthouse

 Target Server Version : 50149
 File Encoding         : utf-8

 Date: 05/28/2011 13:15:09 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `blogcomments`
-- ----------------------------
DROP TABLE IF EXISTS `blogcomments`;
CREATE TABLE `blogcomments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `approved` char(1) NOT NULL DEFAULT 'N',
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `blogcomments`
-- ----------------------------
BEGIN;
INSERT INTO `blogcomments` VALUES ('1', '1', 'Anto', '', 'anto@antodev.com', 'This content isnt even english! I think that if your going to post stuff at least make it multilingual!', 'Y', '2011-01-27 00:29:58');
COMMIT;

-- ----------------------------
--  Table structure for `blogposts`
-- ----------------------------
DROP TABLE IF EXISTS `blogposts`;
CREATE TABLE `blogposts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_image` varchar(255) NOT NULL,
  `post_imagelocation` enum('left','right') NOT NULL DEFAULT 'left',
  `post_summary` text NOT NULL,
  `post_content` text NOT NULL,
  `published` char(1) NOT NULL DEFAULT 'N',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `blogposts`
-- ----------------------------
BEGIN;
INSERT INTO `blogposts` VALUES ('1', '1', 'Test Blog Post', 'FOR_BLOG_PH.jpg', 'left', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam dolor erat, porttitor id congue cursus, posuere id dolor. Quisque et lectus lacus. Fusce sit amet tortor nibh. Mauris vitae ligula id magna scelerisque gravida. Proin consequat tempor lobortis.', '<p>\r\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam dolor erat, porttitor id congue cursus, posuere id dolor. Quisque et lectus lacus. Fusce sit amet tortor nibh. Mauris vitae ligula id magna scelerisque gravida. Proin consequat tempor lobortis. Curabitur est turpis, molestie in sollicitudin vel, vestibulum in quam. Vestibulum imperdiet metus at tellus fringilla hendrerit. Maecenas tempus, libero vitae lacinia tincidunt, augue lacus ultricies erat, vel euismod nulla tellus a nulla. Nam erat diam, cursus vitae rhoncus nec, vehicula ac metus. Aliquam egestas luctus gravida. Suspendisse eu mauris tellus, in bibendum neque. Praesent ut adipiscing quam. Aliquam sed neque eros, id venenatis eros. Donec volutpat pulvinar lacus, semper egestas est viverra in. Proin vel metus eget risus scelerisque semper. Maecenas nec leo ut velit aliquet porttitor.</p>\r\n', 'Y', '2011-02-11 00:02:36'), ('6', '1', 'Test Blog Post 2', 'FOR_BLOG_PH.jpg', 'left', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam dolor erat, porttitor id congue cursus, posuere id dolor. Quisque et lectus lacus. Fusce sit amet tortor nibh. Mauris vitae ligula id magna scelerisque gravida. Proin consequat tempor lobortis. Curabitur est turpis, molestie in sollicitudin vel, vestibulum in quam. Vestibulum imperdiet metus at tellus fringilla hendrerit.', '<p>\r\n	<span>Lorem</span> <span>ipsum</span> dolor sit <span>amet</span>, <span>consectetur</span> <span>adipiscing</span> <span>elit</span>. Nam dolor <span>erat</span>, <span>porttitor</span> id <span>congue</span> <span>cursus</span>, <span>posuere</span> id dolor. <span>Quisque</span> et <span>lectus</span> <span>lacus</span>. <span>Fusce</span> sit <span>amet</span> <span>tortor</span> <span>nibh</span>. <span>Mauris</span> vitae <span>ligula</span> id magna <span>scelerisque</span> gravida. Proin consequat tempor lobortis. Curabitur est turpis, molestie in sollicitudin vel, vestibulum in quam. Vestibulum imperdiet metus at tellus fringilla hendrerit. Maecenas tempus, libero vitae lacinia tincidunt, augue <span>lacus</span> ultricies <span>erat</span>, vel euismod nulla tellus a nulla. Nam <span>erat</span> diam, <span>cursus</span> vitae rhoncus nec, vehicula ac metus. Aliquam egestas luctus gravida. Suspendisse eu mauris tellus, in bibendum neque. Praesent ut <span>adipiscing</span> quam. Aliquam sed neque eros, id venenatis eros. Donec volutpat pulvinar <span>lacus</span>, semper egestas est viverra in. Proin vel metus eget risus <span>scelerisque</span> semper. Maecenas nec leo ut velit aliquet <span>porttitor</span>.</p>\r\n', 'Y', '2011-05-03 19:09:16');
COMMIT;

-- ----------------------------
--  Table structure for `blogs`
-- ----------------------------
DROP TABLE IF EXISTS `blogs`;
CREATE TABLE `blogs` (
  `blog_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_title` varchar(255) NOT NULL,
  `template` varchar(255) NOT NULL,
  PRIMARY KEY (`blog_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `blogs`
-- ----------------------------
BEGIN;
INSERT INTO `blogs` VALUES ('1', 'Blog', 'general.phtml');
COMMIT;

-- ----------------------------
--  Table structure for `cms_settings`
-- ----------------------------
DROP TABLE IF EXISTS `cms_settings`;
CREATE TABLE `cms_settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_title` varchar(255) NOT NULL,
  `setting_value` text NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `cms_settings`
-- ----------------------------
BEGIN;
INSERT INTO `cms_settings` VALUES ('1', 'meta_title', 'The Art House'), ('2', 'meta_keywords', 'Default Keywords'), ('3', 'meta_description', 'Default Description');
COMMIT;

-- ----------------------------
--  Table structure for `cms_users`
-- ----------------------------
DROP TABLE IF EXISTS `cms_users`;
CREATE TABLE `cms_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `cms_users`
-- ----------------------------
BEGIN;
INSERT INTO `cms_users` VALUES ('1', 'sugarcaneweb', '7350a285e3184a7d771119efbcff99c3', 'Paul', 'Winterman', 'paul@sugarcaneweb.co.uk', '1');
COMMIT;

-- ----------------------------
--  Table structure for `metadata`
-- ----------------------------
DROP TABLE IF EXISTS `metadata`;
CREATE TABLE `metadata` (
  `meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` text,
  `meta_description` text,
  PRIMARY KEY (`meta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `news_image` varchar(255) DEFAULT NULL,
  `preview` text NOT NULL,
  `content` text NOT NULL,
  `newsdate` date NOT NULL,
  `published` int(1) NOT NULL DEFAULT '0',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `news`
-- ----------------------------
BEGIN;
INSERT INTO `news` VALUES ('2', 'Test News Title', '', 'This is dummy preview text for a news article.', 'This is dummy full text for the much longer version of the test news article', '2011-02-16', '1', '2011-02-16 00:19:12');
COMMIT;

-- ----------------------------
--  Table structure for `pages`
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) DEFAULT NULL,
  `menu_text` varchar(255) NOT NULL,
  `page_content` longtext NOT NULL,
  `permalink` varchar(255) DEFAULT NULL,
  `type` enum('page','link') NOT NULL DEFAULT 'page',
  `template` varchar(255) NOT NULL DEFAULT 'main.phtml',
  `published` int(1) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '1',
  `parent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `pages`
-- ----------------------------
BEGIN;
INSERT INTO `pages` VALUES ('1', 'Home', 'Home', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut convallis viverra arcu, a bibendum nulla scelerisque nec. Aenean ornare, sapien a bibendum aliquet, dui lacus luctus lectus, in blandit libero dui sit amet diam. Vestibulum at felis quis lectus eleifend lacinia. Nam purus enim, gravida non gravida id, eleifend at urna. Duis placerat pulvinar nibh, gravida viverra diam hendrerit mattis. Phasellus sollicitudin quam sit amet dui tincidunt vehicula. Donec at turpis a nisl cursus sagittis sed dignissim leo.</p>', 'index', 'page', 'homepage.phtml', '1', '1', '0'), ('11', 'About', 'About', '<p>\r\n	About</p>\r\n', 'about', 'page', 'main.phtml', '1', '2', '0'), ('12', 'Get Involved', 'Get Involved', '<p>\r\n	Get Involved</p>\r\n', 'get-involved', 'page', 'main.phtml', '1', '3', '0'), ('13', 'Equality &amp; Quality', 'Equality &amp; Quality', '<p>\r\n	Equality &amp; Quality</p>\r\n', 'equality-quality', 'page', 'main.phtml', '1', '4', '0'), ('14', 'For Artists', 'For Artists', '<p>\r\n	For Artists</p>\r\n', 'for-artists', 'page', 'main.phtml', '1', '5', '0'), ('15', 'Find an Artist', 'Find an Artist', '<p>\r\n	Find an Artist</p>\r\n', 'find-an-artist', 'page', 'main.phtml', '1', '6', '0'), ('16', 'Space for Hire', 'Space for Hire', '<p>\r\n	Space for Hire</p>\r\n', 'space-for-hire', 'page', 'main.phtml', '1', '7', '0'), ('17', 'What\'s On', 'What\'s On', '<p>\r\n	What&#39;s On</p>\r\n', 'whats-on', 'page', 'main.phtml', '1', '8', '0'), ('18', null, 'Blog', '', '/blog/1', 'link', 'main.phtml', '1', '9', '0'), ('19', 'Links', 'Links', '<p>\r\n	Links</p>\r\n', 'links', 'page', 'main.phtml', '1', '10', '0'), ('20', 'Contact', 'Contact', '<p>\r\n	Contact</p>\r\n', 'contact', 'page', 'contact.phtml', '1', '11', '0');
COMMIT;
