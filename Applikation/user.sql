-- phpMyAdmin SQL Dump
-- version 3.4.3.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2015 at 02:54 PM
-- Server version: 5.5.15
-- PHP Version: 5.3.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `user`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminlog`
--

CREATE TABLE IF NOT EXISTS `adminlog` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `oldrole` int(1) NOT NULL,
  `newrole` int(1) NOT NULL,
  `timedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `adminlog`
--

INSERT INTO `adminlog` (`ID`, `adminid`, `userid`, `oldrole`, `newrole`, `timedate`) VALUES
(1, 1, 7, 2, 3, '2015-03-25 14:07:25'),
(2, 1, 4, 2, 3, '2015-03-25 14:14:14'),
(3, 1, 6, 3, 2, '2015-03-26 09:17:06'),
(4, 3, 1, 1, 3, '2015-03-26 10:30:55'),
(5, 8, 8, 1, 3, '2015-03-26 10:52:01');

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE IF NOT EXISTS `forum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(10) unsigned NOT NULL,
  `title` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `text` varchar(1024) COLLATE utf8_swedish_ci NOT NULL,
  `author` int(11) NOT NULL,
  `timeposted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`id`, `parentid`, `title`, `text`, `author`, `timeposted`) VALUES
(4, 0, 'Jag Ã¤r sÃ¤mst', 'Hej jag heter Fabian och Ã¤r sÃ¤mst.', 1, '2015-03-25 10:54:04'),
(6, 4, 'reply', 'Du Ã¤r iallafall rÃ¤tt sÃ¶t.', 4, '2015-03-25 14:13:15'),
(7, 4, 'reply', 'Ellller?', 8, '2015-03-26 09:32:48');

-- --------------------------------------------------------

--
-- Table structure for table `forumlog`
--

CREATE TABLE IF NOT EXISTS `forumlog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postid` int(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `text` varchar(1024) COLLATE utf8_swedish_ci NOT NULL,
  `author` int(11) NOT NULL,
  `timeposted` datetime NOT NULL,
  `deletedby` int(11) NOT NULL,
  `timedeleted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `forumlog`
--

INSERT INTO `forumlog` (`id`, `postid`, `parentid`, `title`, `text`, `author`, `timeposted`, `deletedby`, `timedeleted`) VALUES
(11, 9, 4, 'reply', '<p></p>', 8, '2015-03-26 10:35:15', 8, '2015-03-26 13:14:27'),
(12, 8, 4, 'reply', '$html .= "<p> Fabian Ã¤r sÃ¤mst <p>";', 8, '2015-03-26 10:34:30', 8, '2015-03-26 13:15:06');

-- --------------------------------------------------------

--
-- Table structure for table `loginlog`
--

CREATE TABLE IF NOT EXISTS `loginlog` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) DEFAULT NULL,
  `timedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `IP` varchar(16) NOT NULL,
  `success` int(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `loginlog`
--

INSERT INTO `loginlog` (`ID`, `username`, `timedate`, `IP`, `success`) VALUES
(1, 'sdfsdghuu', '2015-03-25 12:04:58', '127.0.0.1', 0),
(2, 'Admin', '2015-03-25 12:05:39', '127.0.0.1', 1),
(3, 'gfdf', '2015-03-25 12:19:16', '127.0.0.1', 0),
(4, 'fguhi', '2015-03-25 12:56:35', '127.0.0.1', 0),
(5, 'admin', '2015-03-25 13:10:31', '127.0.0.1', 1),
(6, 'admin', '2015-03-25 14:00:04', '127.0.0.1', 1),
(7, 'admin', '2015-03-25 14:11:22', '127.0.0.1', 1),
(8, 'Tim', '2015-03-25 14:12:56', '127.0.0.1', 1),
(9, 'admin', '2015-03-25 14:13:59', '127.0.0.1', 1),
(10, 'Tim', '2015-03-25 14:15:10', '127.0.0.1', 0),
(11, 'Tim', '2015-03-25 14:15:14', '127.0.0.1', 0),
(12, 'Tim', '2015-03-25 14:15:17', '127.0.0.1', 0),
(13, 'Tim', '2015-03-25 14:15:22', '127.0.0.1', 0),
(14, 'Tim', '2015-03-25 14:15:26', '127.0.0.1', 0),
(15, 'admin', '2015-03-26 08:43:34', '127.0.0.1', 1),
(16, 'Tim', '2015-03-26 08:49:18', '127.0.0.1', 1),
(17, 'admin', '2015-03-26 08:59:22', '127.0.0.1', 1),
(18, 'Tim', '2015-03-26 09:30:24', '127.0.0.1', 0),
(19, 'Time', '2015-03-26 09:30:58', '127.0.0.1', 0),
(20, 'Time', '2015-03-26 09:31:03', '127.0.0.1', 0),
(21, 'Time', '2015-03-26 09:31:08', '127.0.0.1', 1),
(22, 'admin', '2015-03-26 10:30:19', '127.0.0.1', 1),
(23, 'Tim', '2015-03-26 10:31:44', '127.0.0.1', 0),
(24, 'Tim', '2015-03-26 10:31:48', '127.0.0.1', 0),
(31, 'Time', '2015-03-26 10:37:03', '127.0.0.1', 1),
(32, 'Admin', '2015-03-26 12:04:58', '127.0.0.1', 1),
(33, 'time', '2015-03-26 12:07:17', '127.0.0.1', 1),
(34, 'admin', '2015-03-26 13:31:03', '127.0.0.1', 0),
(35, 'admin', '2015-03-26 13:31:09', '127.0.0.1', 1),
(36, 'admin', '2015-03-26 13:31:40', '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `passwordupdatelog`
--

CREATE TABLE IF NOT EXISTS `passwordupdatelog` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `timedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `IP` varchar(16) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `passwordupdatelog`
--

INSERT INTO `passwordupdatelog` (`ID`, `userid`, `timedate`, `IP`) VALUES
(1, 1, '2015-03-25 14:15:16', '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `username` varchar(30) COLLATE utf8_swedish_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `role` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `username`, `password`, `role`) VALUES
(1, 'Admin', 'Password', 1),
(3, 'Admin', 'dc647eb65e6711e155375218212b3964', 1),
(4, 'Tim', 'hejhej123', 1),
(5, 'HEJ', 'HejHej123', 2),
(6, 'HeeJDA', 'hejhej123', 2),
(7, 'haaaalla', 'hejhej123', 3),
(8, 'Time', 'b215c2dfc8c2d62d21e991b4cd010447', 3),
(9, 'Erik', 'b215c2dfc8c2d62d21e991b4cd010447', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
