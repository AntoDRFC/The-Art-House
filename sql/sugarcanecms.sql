/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Version : 50149
 Source Host           : localhost
 Source Database       : sugarcanecms

 Target Server Version : 50149
 File Encoding         : utf-8

 Date: 05/28/2011 12:51:01 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `blogposts`
-- ----------------------------
BEGIN;
INSERT INTO `blogposts` VALUES ('1', '1', 'Homemade - New Website for Manchester based Catering Business', 'NEW_PORTFOLIO_HOMEMADE.jpg', 'left', 'Homemade have a passion for food. They pride themselves on providing quality food at reasonable prices. They have been established in Swinton since November 2000 and have developed the business from a Bakery and shop to what you see now which is a Bakery Coffee shop and outside catering facility. A creative but affordable website was required to reflect warmth and homeliness.', '<h4>\r\n	<a href=\"http://www.homemade127.co.uk\" style=\"color: rgb(84, 80, 66);\" target=\"_blank\">Visit the Homemade Website</a></h4>\r\n<h3>\r\n	The Client...</h3>\r\n<p>\r\n	Homemade have a passion for food. They pride themselves on providing quality food at reasonable prices. They have been established in Swinton since November 2000 and have developed the business from a Bakery and shop to what you see now which is a Bakery Coffee shop and outside catering facility.</p>\r\n<h3>\r\n	The Website...</h3>\r\n<p>\r\n	<span><img alt=\"affordable website design for Sheffield and Doncaster based Homemade\" src=\"/upload/image/homemade_screen.jpg\" style=\"width: 301px; height: 188px; float: right; margin: 10px;\" /></span>A creative but affordable website was required to reflect warmth and homeliness, the homemade ethos. Through really getting to know the clients requirements, and having our own ideas on the direction, we achieved a creative and effective website that the client, and ourselves, are very proud of. The site also features content management which has proven to be more than useful to a client who has ever changing menus.</p>\r\n<h3>\r\n	&quot;We needed an affordable website that portrayed the homely feel we were looking for. The result we got far exceeded our expectations and has been a valuable tool for us&quot;<span style=\"font-size: 14px;\"> - Gregg O&#39;Neil, Homemade</span></h3>\r\n<h4>\r\n	<a href=\"http://www.homemade127.co.uk/\" style=\"color: rgb(84, 80, 66);\" target=\"_blank\">Visit the Homemade Website</a></h4>\r\n', 'Y', '2011-03-07 19:50:41');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `blogs`
-- ----------------------------
BEGIN;
INSERT INTO `blogs` VALUES ('1', 'Initial Blog', 'portfolio.phtml');
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
INSERT INTO `cms_settings` VALUES ('1', 'meta_title', 'Default Title'), ('2', 'meta_keywords', 'Default Keywords'), ('3', 'meta_description', 'Default Description');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

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
INSERT INTO `news` VALUES ('1', 'First News Item', '', 'This is dummy preview text for a news article.', 'This is dummy full text for the much longer version of the test news article', '2011-02-16', '1', '2011-02-16 00:19:12');
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
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `pages`
-- ----------------------------
BEGIN;
INSERT INTO `pages` VALUES ('1', 'Welcome to a fresh CMS setup', 'Home', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse ut enim sed enim viverra auctor non at neque. Nam iaculis pellentesque nunc eu bibendum. Aenean nisl leo, scelerisque in luctus ac, mollis ut metus. Donec neque ipsum, tincidunt eu tristique a, suscipit vitae nibh. Phasellus eu libero vel nulla egestas mattis a quis mi. Fusce id lectus est. Aliquam venenatis ornare tempus. Aliquam laoreet quam nec nisi tincidunt non hendrerit est cursus. Morbi eget sagittis nisl. Etiam facilisis, eros nec porttitor cursus, libero augue laoreet magna, vel volutpat sapien eros a ante.</p>\n<p>Suspendisse gravida eleifend elit et varius. Ut libero tellus, scelerisque sit amet convallis sit amet, vulputate ac nisl. Nulla vitae ante sed leo fringilla adipiscing sed non purus. Phasellus porttitor, purus non laoreet ultrices, orci leo semper elit, eget porttitor arcu dui a neque. Etiam gravida dolor eu orci ultricies adipiscing. Suspendisse rutrum adipiscing aliquam. Nulla in dapibus tortor. Nunc vehicula, arcu id dignissim dapibus, nunc quam auctor velit, in vehicula metus nibh vitae neque. In hac habitasse platea dictumst. Maecenas ut sem eu felis tincidunt auctor. Pellentesque venenatis ligula vitae mi semper rutrum. Nulla facilisi. Praesent sed mi felis. Suspendisse nisi nisl, suscipit eu bibendum at, mollis sed nisi. Cras ullamcorper diam in felis pulvinar gravida. Donec velit massa, blandit a aliquet sit amet, porttitor non ipsum. Quisque molestie feugiat massa, eget suscipit tellus porta a. Etiam ultrices nibh dignissim purus commodo convallis.</p>', 'index', 'page', 'homepage.phtml', '1', '1', '0', '2011-05-28 04:39:37'), ('2', 'Another page', 'Page Two', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse ut enim sed enim viverra auctor non at neque. Nam iaculis pellentesque nunc eu bibendum. Aenean nisl leo, scelerisque in luctus ac, mollis ut metus. Donec neque ipsum, tincidunt eu tristique a, suscipit vitae nibh. Phasellus eu libero vel nulla egestas mattis a quis mi. Fusce id lectus est. Aliquam venenatis ornare tempus. Aliquam laoreet quam nec nisi tincidunt non hendrerit est cursus. Morbi eget sagittis nisl. Etiam facilisis, eros nec porttitor cursus, libero augue laoreet magna, vel volutpat sapien eros a ante.</p>\n<p>Suspendisse gravida eleifend elit et varius. Ut libero tellus, scelerisque sit amet convallis sit amet, vulputate ac nisl. Nulla vitae ante sed leo fringilla adipiscing sed non purus. Phasellus porttitor, purus non laoreet ultrices, orci leo semper elit, eget porttitor arcu dui a neque. Etiam gravida dolor eu orci ultricies adipiscing. Suspendisse rutrum adipiscing aliquam. Nulla in dapibus tortor. Nunc vehicula, arcu id dignissim dapibus, nunc quam auctor velit, in vehicula metus nibh vitae neque. In hac habitasse platea dictumst. Maecenas ut sem eu felis tincidunt auctor. Pellentesque venenatis ligula vitae mi semper rutrum. Nulla facilisi. Praesent sed mi felis. Suspendisse nisi nisl, suscipit eu bibendum at, mollis sed nisi. Cras ullamcorper diam in felis pulvinar gravida. Donec velit massa, blandit a aliquet sit amet, porttitor non ipsum. Quisque molestie feugiat massa, eget suscipit tellus porta a. Etiam ultrices nibh dignissim purus commodo convallis.</p>', 'page-two', 'page', 'main.phtml', '1', '2', '0', '2011-05-28 04:40:30'), ('3', 'Subpage', 'Sub of Page Two', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse ut enim sed enim viverra auctor non at neque. Nam iaculis pellentesque nunc eu bibendum. Aenean nisl leo, scelerisque in luctus ac, mollis ut metus. Donec neque ipsum, tincidunt eu tristique a, suscipit vitae nibh. Phasellus eu libero vel nulla egestas mattis a quis mi. Fusce id lectus est. Aliquam venenatis ornare tempus. Aliquam laoreet quam nec nisi tincidunt non hendrerit est cursus. Morbi eget sagittis nisl. Etiam facilisis, eros nec porttitor cursus, libero augue laoreet magna, vel volutpat sapien eros a ante.</p>\n<p>Suspendisse gravida eleifend elit et varius. Ut libero tellus, scelerisque sit amet convallis sit amet, vulputate ac nisl. Nulla vitae ante sed leo fringilla adipiscing sed non purus. Phasellus porttitor, purus non laoreet ultrices, orci leo semper elit, eget porttitor arcu dui a neque. Etiam gravida dolor eu orci ultricies adipiscing. Suspendisse rutrum adipiscing aliquam. Nulla in dapibus tortor. Nunc vehicula, arcu id dignissim dapibus, nunc quam auctor velit, in vehicula metus nibh vitae neque. In hac habitasse platea dictumst. Maecenas ut sem eu felis tincidunt auctor. Pellentesque venenatis ligula vitae mi semper rutrum. Nulla facilisi. Praesent sed mi felis. Suspendisse nisi nisl, suscipit eu bibendum at, mollis sed nisi. Cras ullamcorper diam in felis pulvinar gravida. Donec velit massa, blandit a aliquet sit amet, porttitor non ipsum. Quisque molestie feugiat massa, eget suscipit tellus porta a. Etiam ultrices nibh dignissim purus commodo convallis.</p>', 'sub-page-two', 'page', 'main.phtml', '1', '1', '2', '2011-05-28 04:44:27');
COMMIT;

