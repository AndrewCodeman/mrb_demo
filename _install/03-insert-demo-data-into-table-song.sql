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

-- Dumping data for table mrb.Customers: ~2 rows (approximately)
/*!40000 ALTER TABLE `Customers` DISABLE KEYS */;
INSERT INTO `Customers` (`id`, `name`, `address`, `email`, `phone`, `respondMethod`, `created_at`) VALUES
	(1, 'Customer1', '1ddress', NULL, NULL, 1, '2019-11-11 12:21:52'),
	(3, 'Company', NULL, NULL, NULL, 2, '2019-11-11 19:49:50');
/*!40000 ALTER TABLE `Customers` ENABLE KEYS */;

-- Dumping data for table mrb.Employees: ~2 rows (approximately)
/*!40000 ALTER TABLE `Employees` DISABLE KEYS */;
INSERT INTO `Employees` (`id`, `firstname`, `surname`, `category`, `email`, `phone`, `started_at`, `left_at`) VALUES
	(1, 'James', 'Smitt', 'ManagerB', NULL, NULL, '2019-11-01 00:00:00', NULL),
	(2, 'Andrei', 'Rasskazov', 'MechanicB', 'andrei@rasskazoff.com', '02102671112', '2019-11-11 00:00:00', NULL),
	(3, 'Eva', 'Brown', 'MechanicA', NULL, NULL, '2019-11-12 01:46:06', NULL);
/*!40000 ALTER TABLE `Employees` ENABLE KEYS */;

-- Dumping data for table mrb.Jobs: ~3 rows (approximately)
/*!40000 ALTER TABLE `Jobs` DISABLE KEYS */;
INSERT INTO `Jobs` (`id`, `employeeId`, `orderId`, `start_at`, `completed_at`, `duration`, `end_at`) VALUES
	(1, 1, 7, '2019-11-11 22:03:51', '2019-11-12 04:10:58', '120', '2019-11-12 00:03:51'),
	(2, 2, 8, '2019-11-12 01:10:56', NULL, '240', '2019-11-12 05:10:56'),
	(3, 2, 9, '2019-11-12 06:13:24', NULL, '120', '2019-11-12 08:13:24'),
	(5, 1, 10, '2019-11-12 10:00:00', NULL, '240', '2019-11-12 14:00:00');
/*!40000 ALTER TABLE `Jobs` ENABLE KEYS */;

-- Dumping data for table mrb.Orders: ~3 rows (approximately)
/*!40000 ALTER TABLE `Orders` DISABLE KEYS */;
INSERT INTO `Orders` (`id`, `customerId`, `vehicleId`, `created_at`, `completed_at`) VALUES
	(7, 1, 1, '2019-11-11 21:42:35', '2019-11-12 04:10:58'),
	(9, 1, 1, '2019-11-11 21:43:45', NULL),
	(8, 3, 3, '2019-11-11 21:43:01', NULL),
	(10, 3, 4, '2019-11-12 03:07:08', NULL);
/*!40000 ALTER TABLE `Orders` ENABLE KEYS */;

-- Dumping data for table mrb.Vehicles: ~4 rows (approximately)
/*!40000 ALTER TABLE `Vehicles` DISABLE KEYS */;
INSERT INTO `Vehicles` (`id`, `plate`, `customerId`, `type`) VALUES
	(1, 'M007', 1, 'Car'),
	(2, 'VV996N', 1, 'Bus'),
	(3, 'MNMN70', 3, 'Motorbike'),
	(4, 'MNMN7', 3, 'Bus');
/*!40000 ALTER TABLE `Vehicles` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
