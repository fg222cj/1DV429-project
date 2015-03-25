-- phpMyAdmin SQL Dump
-- version 3.4.3.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2015 at 12:20 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`id`, `parentid`, `title`, `text`, `author`, `timeposted`) VALUES
(1, 0, 'Jag Ã¤r bÃ¤st', 'Jag heter Tim Emanuelsson och jag Ã¤r bÃ¤st!', 1, '2015-03-25 10:39:56'),
(2, 1, 'Du Ã¤r ju fan inte bÃ¤st', 'FÃ¶r helvete', 1, '2015-03-25 10:51:32'),
(3, 1, 'Okej', 'Fabian Ã¤r ju egentligen rÃ¤tt jÃ¤vla cool, sÃ¥ vi kan vara Ã¶verens om att han Ã¤r bÃ¤st. Tim suger.', 1, '2015-03-25 10:53:15'),
(4, 0, 'Jag Ã¤r sÃ¤mst', 'Hej jag heter Fabian och Ã¤r sÃ¤mst.', 1, '2015-03-25 10:54:04');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `username`, `password`, `role`) VALUES
(1, 'Admin', 'Password', 1),
(3, 'Admin', 'dc647eb65e6711e155375218212b3964', 1),
(4, 'Tim', 'hejhej123', 2),
(5, 'HEJ', 'HejHej123', 2),
(6, 'HeeJDA', 'hejhej123', 3),
(7, 'haaaalla', 'hejhej123', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
