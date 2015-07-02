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


-- Dumping structure for table apps.diary_life
DROP TABLE IF EXISTS `diary_life`;
CREATE TABLE IF NOT EXISTS `diary_life` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `DATA` varchar(500) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL,
  `ENTRY` int(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.health_mf
DROP TABLE IF EXISTS `health_mf`;
CREATE TABLE IF NOT EXISTS `health_mf` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.health_win
DROP TABLE IF EXISTS `health_win`;
CREATE TABLE IF NOT EXISTS `health_win` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.ins_mf
DROP TABLE IF EXISTS `ins_mf`;
CREATE TABLE IF NOT EXISTS `ins_mf` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.ins_win
DROP TABLE IF EXISTS `ins_win`;
CREATE TABLE IF NOT EXISTS `ins_win` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.life_mf
DROP TABLE IF EXISTS `life_mf`;
CREATE TABLE IF NOT EXISTS `life_mf` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.life_win
DROP TABLE IF EXISTS `life_win`;
CREATE TABLE IF NOT EXISTS `life_win` (
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


-- Dumping structure for table apps.uk_shift
DROP TABLE IF EXISTS `uk_shift`;
CREATE TABLE IF NOT EXISTS `uk_shift` (
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
  `name` char(10) NOT NULL,
  `fullname` char(20) DEFAULT NULL,
  `password` char(15) DEFAULT NULL,
  `hash` varchar(255) NULL,
  `colour` char(10) DEFAULT NULL,
  `shortdial` char(10) DEFAULT NULL,
  `longdial` char(15) DEFAULT NULL,
  `mobile` char(15) DEFAULT NULL,
  `home` char(15) DEFAULT NULL,
  `ins_mf` binary(1) DEFAULT NULL,
  `ins_win` binary(1) DEFAULT NULL,
  `health_mf` binary(1) DEFAULT NULL,
  `health_win` binary(1) DEFAULT NULL,
  `life_mf` binary(1) DEFAULT NULL,
  `life_win` binary(1) DEFAULT NULL,
  `wealth_mf` binary(1) DEFAULT NULL,
  `wealth_win` binary(1) DEFAULT NULL,
  `uk_shift` binary(1) DEFAULT NULL,
  `atss` binary(1) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='InnoDB free: 11264 kB';

INSERT INTO `users` (`name`, `fullname`, `password`, `hash`, `colour`, `shortdial`, `longdial`, `mobile`, `home`, `ins_mf`, `ins_win`, `health_mf`, `health_win`, `life_mf`, `life_win`, `wealth_mf`, `wealth_win`, `uk_shift`, `atss`) VALUES
('ADMIN', 'Administrator', 'Password1', '', 'FAD2F5', '611 7739', '07977 917739', '', '', '1', '0', '0', '1', '0', '0', '0', '1', '0', '0');


-- Dumping structure for table apps.wealth_mf
DROP TABLE IF EXISTS `wealth_mf`;
CREATE TABLE IF NOT EXISTS `wealth_mf` (
  `DAY` int(11) DEFAULT NULL,
  `MONTH` int(11) DEFAULT NULL,
  `YEAR` int(11) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL,
  `STAMP` varchar(20) DEFAULT NULL,
  `WHO` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table apps.wealth_win
DROP TABLE IF EXISTS `wealth_win`;
CREATE TABLE IF NOT EXISTS `wealth_win` (
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
