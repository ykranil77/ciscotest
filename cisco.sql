-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.30-0ubuntu0.18.04.1 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table cisco.routers
CREATE TABLE IF NOT EXISTS `routers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sapid` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `hostname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `loopback` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mac_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sapid` (`sapid`),
  UNIQUE KEY `hostname` (`hostname`),
  UNIQUE KEY `loopback` (`loopback`),
  UNIQUE KEY `mac_address` (`mac_address`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table cisco.routers: ~17 rows (approximately)
/*!40000 ALTER TABLE `routers` DISABLE KEYS */;
INSERT INTO `routers` (`id`, `type`, `sapid`, `hostname`, `loopback`, `mac_address`, `status`, `created`) VALUES
	(1, 'AGS', 'UTBU6567SSW12', '192.168.0.11', 'UTSGH34S12', 'SH6:67S:65:23S:72', 1, '2020-07-09 14:07:23'),
	(2, 'CSS', 'UTBU6567A', '192.168.0.9', 'UTSGH34A', 'SH6:67S:65:23S:78', 1, '2020-07-09 14:08:57'),
	(3, 'CSS', 'VWJD5EXTRAE7A9PU49', '152.118.5.118', '9THLU9MIMF393A', 'RH2:9KF:98:1SI:20', 0, '2020-07-09 14:09:52'),
	(4, 'CSS', 'PFCL14MW8RFXHQNENF', '236.134.183.157', '1HXQFE67KUFMT3', '062:4IS:51:C3X:77', 1, '2020-07-09 14:09:52'),
	(5, 'CSS', 'HATX9RR8PC28RE11SJ', '152.228.22.44', '0EAPIBZ4XLT4Q0', '76W:98V:44:S70:27', 1, '2020-07-09 14:09:52'),
	(6, 'CSS', 'C4PS668B1SIYIXAQAB', '77.25.240.181', '7HI83R1OA5S8SZ', '040:6NX:31:32F:84', 0, '2020-07-09 14:09:52'),
	(7, 'CSS', 'V4G7BC9RB6AQ9DSBQ5', '144.9.174.35', '60JBXH2VDEBW9K', '6S0:4Y6:40:HQP:55', 1, '2020-07-09 14:09:52'),
	(8, 'AG1', '4ZWP8SG4J1J14OI9RW', '144.9.174.5', 'AAAAA345S', 'N08:5PV:50:ITH:95', 1, '2020-07-09 15:08:45'),
	(9, 'AG1', 'Y14KS9F2LVIGZVTP6A', '144.9.174.25', 'UTSGH324SS', 'MHH:9L9:4:KFM:98', 0, '2020-07-09 15:09:16'),
	(10, 'AG1', 'JSTFZHVYA0Y0B0CNN2', '144.96.174.25', 'UTSGH324S', '6NX:0OD:21:9UP:49', 1, '2020-07-09 15:09:52'),
	(11, 'AG1', 'VVO2OZBU2PVH449T5G', '172.138.202.246', 'UMESAQK8A314XI', 'CPM:9QG:82:0K8:67', 1, '2020-07-09 15:27:22'),
	(12, 'AG1', 'X2EJKDG4T7QK2AJWYN', '135.152.13.61', 'ZRTGIVU7IC40DA', '0W5:3BY:65:Z9O:97', 1, '2020-07-09 15:27:23'),
	(13, 'AG1', 'TOA75MJPG0DK4UZVRK', '144.9.114.5', 'ADDF345SR', '6FE:8WX:38:QIF:22', 1, '2020-07-09 16:19:31'),
	(14, 'AG1', 'Adsda12324A', '192.168.0.3', 'ASDER345T', '23S:W2:RT3:SW2:W1', 1, '2020-07-09 16:21:45'),
	(15, 'CSS', 'ZMRZ4ASVR6RKGPCSI1', '185.164.196.254', '9LB5W1C4MIUAT5', 'PGP:1TW:64:GTC:31', 1, '2020-07-09 16:23:54'),
	(16, 'CSS', 'PWJG5BGTCQQRLUQPIW', '152.171.221.16', 'WHAWSNEGH2HVZ8', '00M:6O1:0:ML1:19', 1, '2020-07-09 16:23:54'),
	(17, 'CSS', 'B2GESST3ZEXLJUO73V', '228.213.111.98', 'TG6ANW2K4K6YOM', 'UW5:7NO:44:Q9C:49', 1, '2020-07-09 16:23:54');
/*!40000 ALTER TABLE `routers` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
