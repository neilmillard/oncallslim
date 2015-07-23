-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.44-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping structure for table apps.rotas
DROP TABLE IF EXISTS `rotas`;
CREATE TABLE IF NOT EXISTS `rotas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.


-- Dumping structure for table apps.rotas_users
DROP TABLE IF EXISTS `rotas_users`;
CREATE TABLE IF NOT EXISTS `rotas_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `users_id` int(11) unsigned DEFAULT NULL,
  `rotas_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_1c53a186da714da27d2a3d895fa728d59dc97258` (`rotas_id`,`users_id`),
  KEY `index_foreignkey_rotas_users_users` (`users_id`),
  KEY `index_foreignkey_rotas_users_rotas` (`rotas_id`),
  CONSTRAINT `c_fk_rotas_users_rotas_id` FOREIGN KEY (`rotas_id`) REFERENCES `rotas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.


-- Dumping structure for table apps.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(10) NOT NULL,
  `fullname` char(20) DEFAULT NULL,
  `password` char(15) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `colour` char(10) DEFAULT NULL,
  `shortdial` char(10) DEFAULT NULL,
  `longdial` char(15) DEFAULT NULL,
  `mobile` char(15) DEFAULT NULL,
  `home` char(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='InnoDB free: 11264 kB';

INSERT INTO `users` (`id`, `name`, `fullname`, `password`, `hash`, `colour`, `shortdial`, `longdial`, `mobile`, `home`) VALUES
	(1, 'ADMIN', 'Administrator_', 'Password1', '$2y$10$/Z3v5y2T/jBWaNcxXzFsA.KyF34yy0Dpbxz/R6Ba09Wn19J2tiSiW', 'FAD2F5', '611 7739', '07977 917739', '', '');

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
