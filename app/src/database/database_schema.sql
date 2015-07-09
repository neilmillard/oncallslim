-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.42-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE=`NO_AUTO_VALUE_ON_ZERO` */;

-- Dumping structure for table apps.atss
DROP TABLE IF EXISTS `atss`;
CREATE TABLE IF NOT EXISTS `atss` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.diarylife
DROP TABLE IF EXISTS `diarylife`;
CREATE TABLE IF NOT EXISTS `diarylife` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `DATA` varchar(500) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL,
  `ENTRY` int(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.healthmf
DROP TABLE IF EXISTS `healthmf`;
CREATE TABLE IF NOT EXISTS `healthmf` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.healthwin
DROP TABLE IF EXISTS `healthwin`;
CREATE TABLE IF NOT EXISTS `healthwin` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.insmf
DROP TABLE IF EXISTS `insmf`;
CREATE TABLE IF NOT EXISTS `insmf` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.inswin
DROP TABLE IF EXISTS `inswin`;
CREATE TABLE IF NOT EXISTS `inswin` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.lifemf
DROP TABLE IF EXISTS `lifemf`;
CREATE TABLE IF NOT EXISTS `lifemf` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.lifewin
DROP TABLE IF EXISTS `lifewin`;
CREATE TABLE IF NOT EXISTS `lifewin` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.month
DROP TABLE IF EXISTS `month`;
CREATE TABLE IF NOT EXISTS `month` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` text,
  `DAYS` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `month`
--

INSERT INTO `month` (`ID`, `NAME`, `DAYS`) VALUES
(1, 'January', 31),
(2, 'February', 28),
(3, 'March', 31),
(4, 'April', 30),
(5, 'May', 31),
(6, 'June', 30),
(7, 'July', 31),
(8, 'August', 31),
(9, 'September', 30),
(10, 'October', 31),
(11, 'November', 30),
(12, 'December', 31);


-- Dumping structure for table apps.ukshift
DROP TABLE IF EXISTS `ukshift`;
CREATE TABLE IF NOT EXISTS `ukshift` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(10) NOT NULL,
  `fullname` char(20) DEFAULT NULL,
  `password` char(15) DEFAULT NULL,
  `hash` varchar(255) NULL,
  `colour` char(10) DEFAULT NULL,
  `shortdial` char(10) DEFAULT NULL,
  `longdial` char(15) DEFAULT NULL,
  `mobile` char(15) DEFAULT NULL,
  `home` char(15) DEFAULT NULL,
  `insmf` binary(1) DEFAULT NULL,
  `inswin` binary(1) DEFAULT NULL,
  `healthmf` binary(1) DEFAULT NULL,
  `healthwin` binary(1) DEFAULT NULL,
  `lifemf` binary(1) DEFAULT NULL,
  `lifewin` binary(1) DEFAULT NULL,
  `wealthmf` binary(1) DEFAULT NULL,
  `wealthwin` binary(1) DEFAULT NULL,
  `ukshift` binary(1) DEFAULT NULL,
  `atss` binary(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='InnoDB free: 11264 kB';

INSERT INTO `users` (`name`, `fullname`, `password`, `hash`, `colour`, `shortdial`, `longdial`, `mobile`, `home`, `insmf`, `inswin`, `healthmf`, `healthwin`, `lifemf`, `lifewin`, `wealthmf`, `wealthwin`, `ukshift`, `atss`) VALUES
('ADMIN', 'Administrator', 'Password1', '', 'FAD2F5', '611 7739', '07977 917739', '', '', '1', '0', '0', '1', '0', '0', '0', '1', '0', '0');


-- Dumping structure for table apps.wealthmf
DROP TABLE IF EXISTS `wealthmf`;
CREATE TABLE IF NOT EXISTS `wealthmf` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.wealthwin
DROP TABLE IF EXISTS `wealthwin`;
CREATE TABLE IF NOT EXISTS `wealthwin` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, ``) */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
