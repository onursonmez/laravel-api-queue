-- MariaDB dump 10.18  Distrib 10.5.8-MariaDB, for osx10.15 (x86_64)
--
-- Host: localhost    Database: iap
-- ------------------------------------------------------
-- Server version	10.5.8-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `callback_at` timestamp NULL DEFAULT NULL,
  `app_id` bigint(20) unsigned NOT NULL,
  `uid` bigint(20) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `activities_app_id_foreign` (`app_id`),
  KEY `activities_uid_foreign` (`uid`),
  CONSTRAINT `activities_app_id_foreign` FOREIGN KEY (`app_id`) REFERENCES `apps` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `activities_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `devices` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apps`
--

DROP TABLE IF EXISTS `apps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `apps_title_unique` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apps`
--

LOCK TABLES `apps` WRITE;
/*!40000 ALTER TABLE `apps` DISABLE KEYS */;
INSERT INTO `apps` VALUES (1,NULL,NULL,'Hello Kitty App',1),(2,NULL,NULL,'Dating App',1),(3,NULL,NULL,'E-commerce App',1);
/*!40000 ALTER TABLE `apps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `app_id` bigint(20) unsigned NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` int(11) NOT NULL DEFAULT 1,
  `os` tinyint(4) NOT NULL DEFAULT 1,
  `timezone` tinyint(4) NOT NULL DEFAULT 16,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `devices_app_id_uid_unique` (`app_id`,`uid`),
  CONSTRAINT `devices_app_id_foreign` FOREIGN KEY (`app_id`) REFERENCES `apps` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
INSERT INTO `devices` VALUES (1,'2021-09-13 16:51:04','2021-09-13 16:51:04',1,'1234-5678-1234-5678',1,1,16,'8898d6d7172bd0da2b25416b58752389'),(2,'2021-09-13 20:11:00','2021-09-13 20:11:00',1,'1234-5678-1234-7777',1,1,16,'b8e959863b65033f2e9a66efa6a386dc'),(3,'2021-09-14 04:49:53','2021-09-14 04:49:53',1,'1234-5678-1234-2222',1,1,16,'0959b57f23a8fd663ecb7398cbaf5767'),(4,'2021-09-14 05:48:18','2021-09-14 05:48:18',1,'1234-5678-1234-1111',1,1,16,'d9e21cf64ea88f68a2ea9adff2e2fa8b'),(5,'2021-09-14 05:59:34','2021-09-14 05:59:34',1,'1234-5678-1234-3333',1,1,16,'8e483785ee9ce267e177db14aca041af'),(6,'2021-09-14 06:01:19','2021-09-14 06:01:19',1,'1234-5678-1234-4444',1,1,16,'7ee6bd76aca16fbc423ce48bd18384bf'),(7,'2021-09-14 06:04:25','2021-09-14 06:04:25',1,'1234-5678-1234-1212',1,1,16,'eb83df4aeb498bbfd8fe772d79b63450'),(8,'2021-09-14 06:04:34','2021-09-14 06:04:34',1,'1234-5678-1234-2323',1,1,16,'480bcbea83c2f438ad8d5775939d206c'),(9,'2021-09-14 06:06:37','2021-09-14 06:06:37',1,'1234-5678-1234-3434',1,1,16,'dbd2af57ff1743bde474df7723255b8e');
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (13,'2019_08_19_000000_create_failed_jobs_table',1),(14,'2021_08_18_113558_create_timezones',1),(15,'2021_08_18_113612_create_apps',1),(16,'2021_08_18_113747_create_devices',1),(17,'2021_08_18_115309_create_orders',1),(18,'2021_08_18_123225_create_activities',1),(19,'2021_09_14_094922_create_jobs_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` bigint(20) unsigned NOT NULL,
  `app_id` bigint(20) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `receipt` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_at` timestamp NULL DEFAULT NULL,
  `end_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_device_id_foreign` (`device_id`),
  KEY `orders_app_id_foreign` (`app_id`),
  CONSTRAINT `orders_app_id_foreign` FOREIGN KEY (`app_id`) REFERENCES `apps` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `orders_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,1,1,'767482564265747','2021-09-13 16:51:16','2021-11-14 08:31:58','2021-09-13 16:51:16','2021-09-14 07:31:58'),(2,1,1,1,'767482564265747','2021-09-14 04:33:52','2021-11-14 05:33:52','2021-09-14 04:33:52','2021-09-14 04:33:52'),(3,9,1,1,'767482564265749','2021-09-14 06:08:05','2021-11-14 07:08:05','2021-09-14 06:08:05','2021-09-14 06:08:05');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timezones`
--

DROP TABLE IF EXISTS `timezones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timezones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `offset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timezones`
--

LOCK TABLES `timezones` WRITE;
/*!40000 ALTER TABLE `timezones` DISABLE KEYS */;
INSERT INTO `timezones` VALUES (1,'-11:00','(GMT-11:00) Pago Pago','Pacific/Pago_Pago'),(2,'-10:00','(GMT-10:00) Hawaii Time','Pacific/Honolulu'),(3,'-10:00','(GMT-10:00) Tahiti','Pacific/Tahiti'),(4,'-09:00','(GMT-09:00) Alaska Time','America/Anchorage'),(5,'-08:00','(GMT-08:00) Pacific Time','America/Los_Angeles'),(6,'-07:00','(GMT-07:00) Mountain Time','America/Denver'),(7,'-06:00','(GMT-06:00) Central Time','America/Chicago'),(8,'-05:00','(GMT-05:00) Eastern Time','America/New_York'),(9,'-04:00','(GMT-04:00) Atlantic Time - Halifax','America/Halifax'),(10,'-03:00','(GMT-03:00) Buenos Aires','America/Argentina/Buenos_Aires'),(11,'-02:00','(GMT-02:00) Sao Paulo','America/Sao_Paulo'),(12,'-01:00','(GMT-01:00) Azores','Atlantic/Azores'),(13,'+00:00','(GMT+00:00) London','Europe/London'),(14,'+01:00','(GMT+01:00) Berlin','Europe/Berlin'),(15,'+02:00','(GMT+02:00) Helsinki','Europe/Helsinki'),(16,'+03:00','(GMT+03:00) Istanbul','Europe/Istanbul'),(17,'+04:00','(GMT+04:00) Dubai','Asia/Dubai'),(18,'+04:30','(GMT+04:30) Kabul','Asia/Kabul'),(19,'+05:00','(GMT+05:00) Maldives','Indian/Maldives'),(20,'+05:30','(GMT+05:30) India Standard Time','Asia/Calcutta'),(21,'+05:45','(GMT+05:45) Kathmandu','Asia/Kathmandu'),(22,'+06:00','(GMT+06:00) Dhaka','Asia/Dhaka'),(23,'+06:30','(GMT+06:30) Cocos','Indian/Cocos'),(24,'+07:00','(GMT+07:00) Bangkok','Asia/Bangkok'),(25,'+08:00','(GMT+08:00) Hong Kong','Asia/Hong_Kong'),(26,'+08:30','(GMT+08:30) Pyongyang','Asia/Pyongyang'),(27,'+09:00','(GMT+09:00) Tokyo','Asia/Tokyo'),(28,'+09:30','(GMT+09:30) Central Time - Darwin','Australia/Darwin'),(29,'+10:00','(GMT+10:00) Eastern Time - Brisbane','Australia/Brisbane'),(30,'+10:30','(GMT+10:30) Central Time - Adelaide','Australia/Adelaide'),(31,'+11:00','(GMT+11:00) Eastern Time - Melbourne, Sydney','Australia/Sydney'),(32,'+12:00','(GMT+12:00) Nauru','Pacific/Nauru'),(33,'+13:00','(GMT+13:00) Auckland','Pacific/Auckland'),(34,'+14:00','(GMT+14:00) Kiritimati','Pacific/Kiritimati');
/*!40000 ALTER TABLE `timezones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-09-14 13:38:47
