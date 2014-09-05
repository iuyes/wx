-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 05, 2014 at 04:41 PM
-- Server version: 5.5.38-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zealand`
--

-- --------------------------------------------------------

--
-- Table structure for table `z_menu`
--

CREATE TABLE IF NOT EXISTS `z_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` int(11) unsigned DEFAULT '0' COMMENT '父ID',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `type` varchar(50) NOT NULL COMMENT '类型',
  `value` varchar(255) NOT NULL COMMENT '值',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `z_route`
--

CREATE TABLE IF NOT EXISTS `z_route` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `obj_id` int(11) unsigned NOT NULL COMMENT '对象ID',
  `obj_type` varchar(50) NOT NULL COMMENT '对象类型',
  `keyword` varchar(50) NOT NULL COMMENT '关键字',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='路由表' AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `z_text`
--

CREATE TABLE IF NOT EXISTS `z_text` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `content` varchar(255) NOT NULL COMMENT '文本恢复内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文本回复表' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `z_txp`
--

CREATE TABLE IF NOT EXISTS `z_txp` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `fid` int(11) unsigned NOT NULL COMMENT '首条消息ID',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `pic` varchar(200) NOT NULL COMMENT '图片',
  `content` varchar(255) NOT NULL COMMENT '内容',
  `url` varchar(200) NOT NULL COMMENT '路径',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='图文回复表' AUTO_INCREMENT=5 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
