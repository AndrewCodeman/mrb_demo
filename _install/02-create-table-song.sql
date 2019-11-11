-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.25-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5738
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping structure for table mrb.Customers
CREATE TABLE IF NOT EXISTS `Customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `respondMethod` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `Index 1` (`id`),
  KEY `Index 2` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table mrb.Employees
CREATE TABLE IF NOT EXISTS `Employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `category` enum('ManagerA','ManagerB','MechanicA','MechanicB') NOT NULL DEFAULT 'MechanicA',
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `started_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `left_at` datetime DEFAULT NULL,
  UNIQUE KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table mrb.Jobs
CREATE TABLE IF NOT EXISTS `Jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employeeId` int(10) unsigned NOT NULL,
  `orderId` int(10) unsigned NOT NULL,
  `start_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `duration` enum('30','120','240') NOT NULL DEFAULT '120',
  `end_at` datetime DEFAULT NULL,
  UNIQUE KEY `Index 1` (`id`),
  KEY `FK_Jobs_Orders` (`orderId`),
  KEY `Index 4` (`employeeId`,`orderId`),
  CONSTRAINT `FK_Jobs_Employees` FOREIGN KEY (`employeeId`) REFERENCES `Employees` (`id`),
  CONSTRAINT `FK_Jobs_Orders` FOREIGN KEY (`orderId`) REFERENCES `Orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table mrb.Orders
CREATE TABLE IF NOT EXISTS `Orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customerId` int(10) unsigned NOT NULL,
  `vehicleId` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `completed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`vehicleId`,`customerId`,`created_at`),
  UNIQUE KEY `Index 1` (`id`),
  KEY `FK_Orders_Customers` (`customerId`),
  CONSTRAINT `FK_Orders_Customers` FOREIGN KEY (`customerId`) REFERENCES `Customers` (`id`),
  CONSTRAINT `FK_Orders_Venicles` FOREIGN KEY (`vehicleId`) REFERENCES `Vehicles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table mrb.Vehicles
CREATE TABLE IF NOT EXISTS `Vehicles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `plate` varchar(10) NOT NULL,
  `customerId` int(10) unsigned DEFAULT NULL,
  `type` enum('Car','Bus','Motorbike') NOT NULL DEFAULT 'Car',
  UNIQUE KEY `Index 1` (`id`),
  KEY `Index 2` (`customerId`,`plate`),
  CONSTRAINT `FK_Venicles_Customers` FOREIGN KEY (`customerId`) REFERENCES `Customers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
