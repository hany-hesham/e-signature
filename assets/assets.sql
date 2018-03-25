-- MySQL dump 10.13  Distrib 5.5.40, for Linux (x86_64)
--
-- Host: localhost    Database: assets_assets
-- ------------------------------------------------------
-- Server version	5.5.40-cll

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `assets_assets`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `assets_assets` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `assets_assets`;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
INSERT INTO `ci_sessions` VALUES ('97dcb71b8683e11c0367151a29b06eba','41.65.31.105','Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0',1418471775,'a:6:{s:9:\"user_data\";s:0:\"\";s:7:\"user_id\";s:1:\"6\";s:8:\"username\";s:13:\"mohamed.deraz\";s:6:\"status\";s:1:\"1\";s:8:\"is_admin\";s:1:\"0\";s:9:\"user_type\";s:1:\"8\";}'),('bd7255316ac3488c0e6d51cfb0dbb065','41.65.31.105','Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0',1418469641,'a:4:{s:9:\"user_data\";s:0:\"\";s:7:\"user_id\";s:2:\"92\";s:8:\"username\";s:9:\"Ezz.sayed\";s:6:\"status\";s:1:\"1\";}');
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` text,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'كريستال للاستثمار السياحي'),(2,'Oasis Group'),(4,'رويال مكادي للاستثمار'),(5,'بلوسكاي للاستثمارلت'),(6,'صن رايز لاداره الفنادق العائمه'),(7,'غناظه للفنادق والقري السياحيه'),(8,'دايموند شارم السياحيه'),(9,'شارمينج'),(10,'شركه النخيل للاستثمارات الفندقيه');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'--'),(2,'IT'),(3,'Accounting'),(4,'Engineering '),(5,'Laundry'),(6,'Kitchen'),(7,'Food & Beverage'),(8,'A&G'),(9,'Cluster Account'),(10,'Reservation Centre'),(11,'Regional Office'),(12,'House Keeping '),(13,'Recreation '),(14,'Security'),(15,'Human Resource'),(16,'Gardens'),(18,'Front Office'),(19,'Owning Company');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees_hotels`
--

DROP TABLE IF EXISTS `employees_hotels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees_hotels` (
  `employee_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees_hotels`
--

LOCK TABLES `employees_hotels` WRITE;
/*!40000 ALTER TABLE `employees_hotels` DISABLE KEYS */;
INSERT INTO `employees_hotels` VALUES (6,1),(9,1),(9,2),(4,2),(3,13),(3,11),(3,12),(3,10),(3,2),(3,9),(3,1),(3,7),(3,3),(3,8),(3,5),(3,6),(3,4),(4,13),(4,11),(4,12),(4,10),(4,1),(4,3),(4,5),(2,13),(2,11),(2,12),(2,10),(2,2),(2,9),(2,1),(2,7),(2,3),(2,8),(2,5),(2,6),(2,4),(17,1),(18,2),(18,1),(19,1),(20,1),(21,1),(22,1),(23,2),(23,1),(23,3),(6,2),(9,3),(24,2),(25,3),(26,13),(26,11),(26,12),(26,10),(26,2),(26,1),(26,3),(26,5),(27,3),(28,3),(29,3),(30,4),(31,4),(32,4),(33,4),(34,4),(35,4),(36,4),(37,4),(39,4),(40,5),(41,5),(42,5),(43,5),(44,4),(45,4),(46,4),(47,4),(48,7),(49,7),(50,7),(51,7),(52,7),(53,7),(54,7),(55,13),(55,11),(55,12),(55,10),(55,2),(55,9),(55,1),(55,7),(55,3),(55,8),(55,5),(55,6),(55,4),(57,7),(58,7),(59,9),(59,7),(59,8),(59,6),(59,4),(53,8),(53,6),(60,6),(61,6),(63,6),(64,6),(65,6),(66,6),(67,6),(68,13),(68,11),(68,12),(68,10),(69,11),(69,12),(70,13),(70,11),(70,12),(70,10),(71,11),(71,12),(72,11),(72,12),(73,13),(73,11),(73,12),(73,10),(74,13),(74,11),(74,12),(74,10),(75,11),(75,12),(76,11),(76,12),(77,10),(78,10),(79,10),(80,10),(81,10),(82,4),(83,8),(85,8),(5,5),(86,2),(86,1),(90,10),(91,10),(92,3),(93,8),(94,10),(95,13),(95,11),(95,12),(95,10),(95,2),(95,9),(95,16),(95,1),(95,7),(95,3),(95,8),(95,5),(95,6),(95,4),(96,3),(97,1),(1,13),(1,11),(1,12),(1,10),(1,2),(1,9),(1,16),(1,1),(1,7),(1,3),(1,8),(1,5),(1,6),(1,4),(1,14),(1,15),(99,13),(99,11),(99,12),(99,10),(99,2),(99,9),(99,16),(99,1),(99,7),(99,3),(99,8),(99,5),(99,6),(99,4),(100,13),(100,11),(100,12),(100,10),(100,2),(100,9),(100,16),(100,1),(100,7),(100,3),(100,8),(100,5),(100,6),(100,4),(101,13),(101,11),(101,12),(101,10),(101,2),(101,9),(101,16),(101,1),(101,7),(101,3),(101,8),(101,5),(101,6),(101,4),(102,13),(102,11),(102,12),(102,10),(102,2),(102,9),(102,16),(102,1),(102,7),(102,3),(102,8),(102,5),(102,6),(102,4),(103,10);
/*!40000 ALTER TABLE `employees_hotels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_states`
--

DROP TABLE IF EXISTS `form_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_states`
--

LOCK TABLES `form_states` WRITE;
/*!40000 ALTER TABLE `form_states` DISABLE KEYS */;
INSERT INTO `form_states` VALUES (1,'Submitted'),(2,'Awaiting approval'),(3,'Locally approved'),(4,'Destination approved'),(5,'Finally approved'),(6,'Recieved'),(7,'Confirmed');
/*!40000 ALTER TABLE `form_states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forms`
--

DROP TABLE IF EXISTS `forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `from_hotel_id` int(11) NOT NULL,
  `to_hotel_id` int(11) NOT NULL,
  `issue_date` date NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `location` text NOT NULL,
  `movement_reason` text NOT NULL,
  `destination` text NOT NULL,
  `rcv_user_date` datetime DEFAULT NULL,
  `rcv_user_id` int(11) DEFAULT NULL,
  `rcv_hotel_acc_id` int(11) DEFAULT NULL,
  `rcv_dpt_head_id` int(11) DEFAULT NULL,
  `rcv_chrmn_cai_id` int(11) DEFAULT NULL,
  `src_dpt_head_id` int(11) DEFAULT NULL,
  `src_hotel_gm_id` int(11) DEFAULT NULL,
  `src_hotel_fc_id` int(11) DEFAULT NULL,
  `dstn_dpt_head_id` int(11) DEFAULT NULL,
  `dstn_hotel_gm_id` int(11) DEFAULT NULL,
  `dstn_hotel_fc_id` int(11) DEFAULT NULL,
  `fin_cluster_fc_id` int(11) DEFAULT NULL,
  `fin_rdof_id` int(11) DEFAULT NULL,
  `fin_chrmn_cai_id` int(11) DEFAULT NULL,
  `pur_sec_mgr_id` int(11) DEFAULT NULL,
  `tech_mgr_id` int(11) DEFAULT NULL,
  `pur_dpt_mgr_id` int(11) DEFAULT NULL,
  `acc_mgr_id` int(11) DEFAULT NULL,
  `inv_dpt_mgr_id` int(11) DEFAULT NULL,
  `state_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forms`
--

LOCK TABLES `forms` WRITE;
/*!40000 ALTER TABLE `forms` DISABLE KEYS */;
INSERT INTO `forms` VALUES (14,9,8,3,'2014-11-11','2014-12-01',2,'IT','For Zero Client Project','Data Center Room',NULL,NULL,NULL,NULL,NULL,83,93,85,9,25,92,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4),(20,91,3,10,'2014-11-14','2014-11-20',6,'Sunrise Grand Select Crystal BY','It is needed as in shedwan proffer cabinet is out of order and can not be repaired.','FESTIVAL SHEDWAN ( KITCHEN )',NULL,NULL,NULL,NULL,NULL,NULL,25,92,91,77,103,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3),(21,9,5,3,'2014-11-19','2014-11-23',2,'Information Technology Room','For Invoice System Migration','data Center Room',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,9,25,92,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3),(22,94,3,10,'2014-11-22','2014-11-29',12,'Sunrise Grand Select Crystal Bay Resort','For Renewal','Lobby Shedwan',NULL,NULL,NULL,NULL,NULL,96,25,92,94,77,103,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4),(23,20,3,16,'2014-11-24','2014-11-24',13,'Sun Rise El Rabae','to cover the shortage in the sun Beds by Sun Rise crystal bay','Sun Rise Grand Select Crystal Bay',NULL,NULL,NULL,NULL,NULL,NULL,25,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(24,6,7,1,'2014-12-06','2014-12-06',4,'<p>\n	Arabian Beach Rooms</p>\n','<p>\n	New TVs Needed</p>\n','<p>\n	Garden Beach Rooms</p>\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,97,6,86,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3),(25,97,8,1,'2014-12-06','2014-12-06',4,'Montemare Hotel rooms','New TVs needed','Garden Beach Rooms',NULL,NULL,NULL,NULL,NULL,NULL,93,85,97,6,86,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3),(26,24,3,2,'2014-12-06','2014-12-10',4,'CB','TVs Needed','MP',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,24,6,86,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3),(27,24,3,2,'2014-12-06','2014-12-10',4,'CB','Needed TV for rooms','MP',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,24,6,86,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3),(28,24,7,2,'2014-12-06','2014-12-10',4,'Arabian Beach Rooms','TV s Needed for rooms','MP',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,24,6,86,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3),(29,24,7,2,'2014-12-06','2014-12-10',4,'Arabian Beach Rooms','TV needed for our rooms','MP',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,24,6,86,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3),(30,24,8,2,'2014-12-06','2014-12-10',4,'Montemare Hotel rooms','Tvs Needed','MP',NULL,NULL,NULL,NULL,NULL,NULL,93,NULL,24,6,86,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3);
/*!40000 ALTER TABLE `forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hotels`
--

DROP TABLE IF EXISTS `hotels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hotels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotels`
--

LOCK TABLES `hotels` WRITE;
/*!40000 ALTER TABLE `hotels` DISABLE KEYS */;
INSERT INTO `hotels` VALUES (1,'SUNRISE Garden Beach',2),(2,'SENTIDO Mamlouk Palace',2),(3,'SUNRISE Grand Select Crystal Bay',1),(4,'SUNRISE Select Royal Makadi',4),(5,'SUNRISE Hloidays',5),(6,'SUNRISE Select Diamond Beach',8),(7,'SUNRISE Grand Select Arabian Beach',7),(8,'SUNRISE Grand Select Montemare',9),(9,'SENTIDO Oriental Dream',6),(10,'Festival Shedwan',6),(11,'Festival Le Jardin',6),(12,'Festival Riviera',6),(13,'Color Beach Club',6),(14,'test hotel 1',5),(15,'test hotel 2',8),(16,'SUNRISE EL Rabae ',10);
/*!40000 ALTER TABLE `hotels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,1,'item 1','first item',1),(2,1,'item 2','second item',2),(3,1,'item 4 ','longer description for the forth item!',13),(4,2,'test','test',1),(5,3,'cdsfds','dsfdsf',2),(6,4,'test','vdsvad',1),(7,4,'','',0),(8,5,'test','test',1),(9,6,'tewst','test',2),(10,6,'','',0),(11,7,'test','test',1),(12,8,'test','test',1),(13,9,'PC ','PC test',1),(14,9,'printer','test',2),(15,10,'Color Xerox Printer 7120','To provide Color printer at Montemare',1),(16,10,'firewwall Fortigate 80 C','install firewall at Montemare hotel',1),(17,11,'server 530','intinstall new domian',1),(18,11,'printer','move tp it office',2),(19,12,'test','test',1),(20,13,'test','nddfkg',1),(21,13,'glragl/','gmr.',2),(22,14,'HP Proliant Server','HP Proliant Server',1),(23,15,'xz','x',1),(24,16,'a','ds',1),(25,17,'x','s',1),(26,18,'sa','a',1),(27,19,'q','ws',1),(28,20,'Proffer cabinet','local made (height 230 cm & width 140 cm)',1),(29,21,'Server HP ML 370 G6','For Invoice System Migration',1),(30,22,'Chair One Seat','For Lobby Terrace Shedwan',33),(31,22,'Sofa 2 Seat','For Lobby Terrace Shedwan',13),(32,22,'Large Table','For Lobby Terrace Shedwan',17),(33,23,'sun beds ','sun beds ',40),(34,23,'table ','tables ',40),(35,24,'TV','LG 32&quot;',44),(36,25,'TV','LG 32\"',96),(37,26,'Tv','LG 32\"',324),(38,27,'TV','Hisense',8),(39,28,'Tv','LG 32\"',256),(40,29,'TV','Hisense',27),(41,30,'TV','LG 32\"',4);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Chairman'),(2,'Chairman office Cai'),(3,'R.D.O.F'),(4,'Cluster FC'),(5,'Hotel FC'),(6,'Hotel GM'),(7,'Dep. Head'),(8,'Hotel Acc'),(9,'Employee'),(10,'رئيس قسم المشتريات '),(11,'رئيس قسم المكتب الفنى '),(12,'مدير ادارة المشتريات '),(13,'مدير حسابات '),(14,'مدير ادارة الاستثمار ');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_autologin`
--

DROP TABLE IF EXISTS `user_autologin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_autologin`
--

LOCK TABLES `user_autologin` WRITE;
/*!40000 ALTER TABLE `user_autologin` DISABLE KEYS */;
INSERT INTO `user_autologin` VALUES ('0157bb9c059346e9f557d5b54b2cc8a5',30,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0','41.65.39.45','2014-08-12 11:36:54'),('1d21a7962550b6d843f78dac00ac8eff',20,'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0','41.65.31.105','2014-11-19 09:58:22'),('3326daf38f114079f5267b114de5ad7f',92,'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0','41.65.31.105','2014-11-22 07:52:18'),('7047d7f1d222126c3a8b65fc5cc99f5e',77,'Mozilla/5.0 (Windows NT 5.1; rv:33.0) Gecko/20100101 Firefox/33.0','41.32.14.218','2014-11-18 14:45:03'),('76e98992d303e122fe28c99b68fb6642',84,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36','41.65.207.75','2014-08-27 08:38:08'),('7c0ab645d7b5adb5f84523f847049e39',25,'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0','41.65.31.105','2014-11-11 15:44:17'),('edda6358b2f65cbc25ca9e08a3671afd',22,'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:28.0) Gecko/20100101 Firefox/28.0','41.65.31.123','2014-08-14 11:57:33'),('f8b1cb915f9d38da0e747076d395dcd4',2,'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0','41.65.109.70','2014-11-05 12:02:14');
/*!40000 ALTER TABLE `user_autologin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profiles`
--

LOCK TABLES `user_profiles` WRITE;
/*!40000 ALTER TABLE `user_profiles` DISABLE KEYS */;
INSERT INTO `user_profiles` VALUES (1,2,NULL,NULL);
/*!40000 ALTER TABLE `user_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_alias` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `fullname` varchar(255) COLLATE utf8_bin NOT NULL,
  `signature` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_alias` (`id_alias`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,1,'admin','$2a$08$IYtfQHiBTKJDlLkpuCoWM.z10N/OB80M0sSDcVZ67wsOYa9AKnxzq','abbas.elshabasy@sunrise-resorts.com','Admin Account test','!',0,19,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.31.105','2014-12-10 15:07:06','0000-00-00 00:00:00','2014-12-10 15:07:07'),(2,2,0,'chairman','$2a$08$OXsuLe0ciVSW3T.3UUE.R.aRqy0eER7CCnysvjEt/qH4Fi1xk77I6','chairman@sunrise-resorts.com','Chairman','76478-mr.-hossam-sig.jpg',2,1,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.109.70','2014-11-24 08:25:26','0000-00-00 00:00:00','2014-11-24 08:25:26'),(3,3,0,'hazim.elshamy','$2a$08$As6vXOqih6SF1NR8TEOuxOkRzKKYtVidn.NrXf7L6i8joZ1xUc9Ke','hazim.elshamy@sunrise-resorts.com','Hazim EL Shamy','20550-mr.-hazim-signature.png',3,1,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.31.123','2014-08-12 09:27:46','0000-00-00 00:00:00','2014-10-27 08:00:59'),(4,4,0,'samy.nasser','$2a$08$FiXFZNvUwpFSjh57i/RycOne9LXFF2uE8V9HzlWdOSh4DD/l.z0PS','samy.nasser@sunrise-resorts.com','Samy A.Naser','124a0-sami-abdel-nasser.png',4,3,1,0,NULL,NULL,NULL,NULL,NULL,'41.91.137.50','2014-12-11 12:36:41','0000-00-00 00:00:00','2014-12-11 12:36:41'),(5,5,0,'tarek.desouki','$2a$08$kj/EYH0zgXNim2tz.PjFfOZRuCKjd/6vM4igWQM3q/K7i2lJq73e.','tarek.desouki@sunrise-resorts.com','Tarek Desouki','62be7-tarek-desouki.png',5,3,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.31.123','2014-08-06 12:22:31','0000-00-00 00:00:00','2014-10-27 08:03:26'),(6,6,0,'mohamed.deraz','$2a$08$YBatNFT0rs1qYr1kTB8TluByWQ5OnDUbJAShTI8DKkzEBTQIC4JZK','mohamed.deraz@sunrise-resorts.com','Mohamed Deraz','b9ebc-mr--deraz--signature.png',6,8,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.31.105','2014-12-13 11:56:27','0000-00-00 00:00:00','2014-12-13 11:56:27'),(9,9,0,'mohamed.fouad','$2a$08$0ZhH4jCuV9OYEtDQCes2xeRPr/3TUhdTZSPJq0ogPdwgTsx063DO2','mohamed.fouad@sunrise-resorts.com','Mohamed Fouad','9a279-mfouad.png',7,2,1,0,NULL,NULL,NULL,NULL,NULL,'197.133.172.62','2014-11-20 12:50:39','0000-00-00 00:00:00','2014-11-20 12:50:39'),(22,22,0,'Sameh.nagar','$2a$08$X0RHb1.cGle6jKP1emXRsOQx4YQHHboNDArhEboprhcs0yz6an1Be','Sameh.nagar@sunrise-resorts.com','Sameh.nagar','d85e0-sameh-el-nagar.png',7,18,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.31.123','2014-08-14 11:57:33','0000-00-00 00:00:00','2014-08-14 11:57:33'),(21,21,0,'Ahmed.badr','$2a$08$/rW9iCLQiTLwhJrExiFoK.McLbS6WnamWanGpvpZqFlhB3kDshAY6','Ahmed.badr@sunrise-resorts.com','Ahmed.badr','90abc-ahmed-badr-gsc.png',7,8,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 06:58:40'),(20,20,0,'Amr.latif','$2a$08$1RjBF7UWTCtEeP45wveeCu61oKjWXv0gRF3ishCnU.sDtglgwK9uO','Amr.latif@sunrise-resorts.com','Amr.latif','08bd0-amr-ibrahim-recreation.png',7,13,1,0,NULL,NULL,NULL,NULL,NULL,'105.93.149.53','2014-11-24 12:30:14','0000-00-00 00:00:00','2014-11-24 12:30:14'),(19,19,0,'essam.hagras','$2a$08$RQYrGUZxlmRd76fJ4Cdi4u9yZ9EJ7X/b0dHku8jNSbUcEDiFMP91W','Essam.hagras@sunrise-resorts.com','essam.hagras','2db26-essam-sign.png',7,6,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-05 12:39:56'),(18,18,0,'Nader.sheikh','$2a$08$i8rRTPI2lM0JqC7JsPU52.9yM.U2DZwJyCrTZ9WUrP2Q3hSZVa77S','Nader.sheikh@sunrise-resorts.com','Nader El Sheikh','44d54-nader-hk.png',7,12,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-05 07:58:51'),(17,17,0,'arahman.shahin','$2a$08$EneRUGtxwlh4zQkWXuXB7ukndTMizo9vPf5JuUVTo8s3M8C4RBUbS','arahman.shahin@sunrise-resorts.com','Abdel Rahman Shahin','30b7f-abdel-rahman-shahin-fb.png',7,7,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-05 08:33:50'),(24,24,0,'Mohamed.hussien','$2a$08$nsefEo2BEuiWjLITvvTNAugnTjUTkdDWjzUVXEA/lrWUXaznOUReu','mohamed.hussien@sunrise-resorts.com','mohamed.hussien','ca7ff-mohmed-hussien.gif',7,4,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.31.105','2014-12-06 15:26:58','0000-00-00 00:00:00','2014-12-06 15:26:58'),(23,23,0,'Mohamed.yazeed','$2a$08$S2TfD2DMvvUPXr8gv8yMk.0vUxubt8bCmqOKP0.0glcKPls9TTkQ.','Mohamed.yazeed@sunrise-resorts.com','Mohamed.yazeed','705af-mohamed-abo-yazied.png',7,15,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 07:02:28'),(25,25,0,'gouda.ramadan','$2a$08$MH0B3jLh7es2.vz26qwySOgxhHiyx6dW24VqSPFFwoZ/suqoBrHsW','gouda.ramadan@sunrise-resorts.com','gouda.ramadan','5d134-gouda-ramadan-(gm).png',6,8,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.31.105','2014-12-13 08:57:27','0000-00-00 00:00:00','2014-12-13 08:57:27'),(26,26,0,'emad.mousaad','$2a$08$rsInuRjg.xtswEKTEGlLdOp65UCTkFaATWe4v4/SGOLVJ3z7Ms1F6','emad.mousad@sunrise-resorts.com','emad.mousad','7fa33-emad-mosaad.png',0,0,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 08:23:37'),(27,27,0,'nasser.othman','$2a$08$Hl2dSNWIY85Pqr2FUq.ohecEmd0g7Gl1iggSQwZU8kOOUF0r6qtnq','nasser.othman@sunrise-resorts.com','nasser.othman','af97a-nasser-othman(hkm).png',7,12,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 08:24:59'),(28,28,0,'ahmed.aziz','$2a$08$X97YWGE/AY8evFBdYlHj/.aclPPgb1mATw7/EePPrUx9Nygo67X2C','ahmed.aziz@sunrise-resorts.com','ahmed.aziz','30c42-ahmad-abdel-aziz(fom).png',7,18,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 08:25:59'),(29,29,0,'Rafik.Ramadan','$2a$08$NQ0dDcGU4XnqZzguHmDaFeobQ3EI7f7UMWj3nWC1WvsJ81ppkqgfK','fb.mgr.cb@sunrisehotels-egypt.com','Rafik Ramadan','19cef-rafik-ramadan.jpg',7,7,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 08:27:39'),(30,30,0,'saed.atek','$2a$08$HVk4e/wRXx83ihOsJ0dT8eiJZx7xP1AYIfnaELLrpW9s0M5p8SCgO','Saed.atek@sunrisehotels-egypt.com','Saed.atek','8efaa-said-el-atiek-(gm).png',6,8,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.39.45','2014-08-12 11:36:54','0000-00-00 00:00:00','2014-08-12 11:36:54'),(31,31,0,'AbdAziem.lbrahim','$2a$08$6ONcRL9a/oI8FYz0VvWWi.09TX68ldQRK2lKJ9gKkyBuj9bPS4dbu','AbdAziem.lbrahim@sunrisehotelsegypt.com','AbdAziem.lbrahim','31d58-abdel-azim-el-sweedy-(hr).png',7,15,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 08:30:46'),(32,32,0,'khaled.zweil','$2a$08$E2qAhsHHu.e689owitzA3upqkc4VCizQATwvT5Olp0y3ydhPw.d1i','khaled.zweil@sunrise-resorts.com','khaled.zweil','13f62-khaled-zwiel-(afc).png',5,3,1,0,NULL,NULL,NULL,NULL,NULL,'105.202.45.168','2014-12-01 06:02:37','0000-00-00 00:00:00','2014-12-01 06:02:37'),(33,33,0,'khaled.elsagher-rm','$2a$08$bogGh4mr6ESfparbhGgp/O6f1rnUD2fs2JzaUzystD9VZWCpElY/W','khaled.elsagher-rm@sunrise-resorts.com','khaled.elsagher-rm','7e98a-khaled-el-saghier-(fbm).png',7,7,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 08:33:13'),(34,34,0,'ayman.salah','$2a$08$yx2Hn1p6LAH7sO09Jv8nDOIZHAFl3TBYi5/9OJ63Ak0L2X5Z8whE2','ayman.salah@sunrise-resorts.com','ayman.salah','9701d-ayman-salah-(-exec-chref.png',7,6,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 08:35:32'),(35,35,0,'hashim.lotfy','$2a$08$c3KqqxPDqTqxhiKwlwO9Pes86b1W2lGr7Gn7OGnaJvTAAaipQbChu','hashim.lotfy-rm@sunrisehotelsegypt.com','hashim.lotfy-rm','3703a-hashem-lotfy-(fo-mnager).png',7,18,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 08:36:32'),(36,36,0,'ibrahim.hasan','$2a$08$AKlKKXiFpCN99QXw/3sdo.TwOlM/EYxwDabrLXK/UVqMQYWWMrSIe','ibrahim.hasan@sunrisehotelsegypt.com','Ibrahim Hasan','4581d-ibrahim-hassan-(hk).png',7,12,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-11-12 10:10:38'),(37,37,0,'Ibrahim.belal','$2a$08$KAfJX/FwUl2axSA9n69h.Owd3rX29jzb1yCjQdpTYWhOBpmPuN8pK','recreation.managerrm@sunrisehotels-egypt.com','ibrahim Belal','c0c25-ibrahim-belal-(recreation).png',7,13,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 08:39:28'),(82,82,0,'ehab.rostom','$2a$08$Ea5Z7f5fLQmhv.gwt7p0Jeq0aum3twSzDRHqK8aR8QaRsAHiNgAAG','ehab.rostom@sunrise-resortys.com','ehab rostom','c513b-ehab-rostom-(it).png',7,2,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.39.45','2014-12-01 11:34:01','0000-00-00 00:00:00','2014-12-01 11:34:01'),(39,39,0,'ahmed.fawzy','$2a$08$FKz4rR2e8uwRuH/9CWWuzudN.0lzqKiI7s8y/dewExBomHOTXYcQu','ahmed.fawzy@sunrisehotels-egypt.com','Ahmed Fawzy','46aa5-ahmed-fawzy(eng).png',7,4,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-11-12 10:11:39'),(40,40,0,'mohamed.syd','$2a$08$i3THxMzTyCuEomXLhxD/HuFCDie4ifeFl4s77/mYlVRvVykZwSohm','mohamed.syd@sunrisehotels-egypt.com','mohamed.syd','0d2f7-mohamed-syd.jpg',6,8,1,0,NULL,NULL,NULL,NULL,NULL,'41.32.50.19','2014-11-20 10:43:06','0000-00-00 00:00:00','2014-11-20 10:43:06'),(41,41,0,'ehab.radwan','$2a$08$0cECuwrK59I32T39LwecyeYx4IOQPHYxK49W9338Iwydg5xxa5lO2','ehab.radwan@sunrisehotels-egypt.com','ehab.radwan','247ac-ehab-radwan-fb.jpg',7,7,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 08:46:27'),(42,42,0,'mohamed.abdelkarim','$2a$08$WDW1.CZG9MAV7UAyd5IepODid8Ig3jt3OWPMDTOjg/LUQnheWQmiC','ENG.Holidays@sunrisehotels-egypt.com','mohamed.abdelkarim','75940-mohamed-abdel-karim-eng.jpg',7,4,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 08:48:41'),(43,43,0,'hamza.tawfik','$2a$08$CQdy3Hefj4lKd78KlPWV2uXCWvN9ptllwAAPjUJehrXVTUowijT4i','hamza.tawfik@sunrisehotels-egypt.com','hamza.tawfik','7dc0a-hamza-it.jpg',7,2,1,0,NULL,NULL,NULL,NULL,NULL,'41.32.50.19','2014-11-20 13:35:11','0000-00-00 00:00:00','2014-11-20 13:35:11'),(48,48,0,'Assem.Elsayed','$2a$08$24NXwB29VkM6tiUh312Jge0zLW1A.ziYOBVF9N16y7re9JXbKiBE6','Assem.Elsayed@Sunrisehotels-Egypt.com','Assem.Elsayed','7b63c-assem-el-sayed-(engineering).png',7,4,1,0,NULL,NULL,NULL,NULL,NULL,'41.131.204.44','2014-08-10 13:38:07','0000-00-00 00:00:00','2014-08-10 13:38:07'),(49,49,0,'Reda.Mohamed','$2a$08$KRfnLzFfsD0Y4aMkTvxtaO9lzCPJAJq8Y8GujuqPUGq0Wc5PKgRzy','Reda.Mohamed@Sunrisehotels-Egypt.com','Reda.Mohamed','e9570-reda-mohamed-(accounting-manager).png',5,3,1,1,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:19:14'),(50,50,0,'Hany.Ahmed','$2a$08$CX0x.pJGW9Qu0cjtb1xUeekxWbmlAFBrdMuteTyyWi6wWm2uA0B4y','v','Hany.Ahmed','0ba94-hany-ahmed-(fo-).png',7,18,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:19:50'),(51,51,0,'Waleed.Elghanam','$2a$08$NRcAFCPEPStF.fimrFuVWuJq9iYYCKYjNGoQWgRyYfoYosvjGiYE.','Waleed.Elghanam@Sunrisehotels-Egypt.com','Waleed.Elghanam','ee362-waleed-el-ghanam-(rooms-division).png',7,8,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:20:24'),(52,52,0,'Basher.Agazia','$2a$08$vCSHbphs47ROAH6lk4JUMem54cWtWm6FsWzgMUKexw/bipRY9QEWO','Basher.Agazia@Sunrisehotels-Egypt.com','Basher.Agazia','af517-basheer-abou-gazia(hr).png',7,15,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:21:03'),(53,53,0,'Mostafa.Elkheshen','$2a$08$0cnprRU4dul8YcmZisVFaO2fSJl2F0lVtBhhuj/z3uhGKH2gJ6ib.','Mostafa.Elkheshen@Sunrisehotels-Egypt.com','Mostafa.Elkheshen','7e4d3-moustafa-elkheshen-(pur).png',7,3,1,0,NULL,NULL,NULL,NULL,NULL,'197.134.255.229','2014-08-06 16:56:27','0000-00-00 00:00:00','2014-08-06 16:56:27'),(54,54,0,'Tarek.Ahmed','$2a$08$YeB92xWywXL2MGrC2G8MUOOdUdXEqdEfhwNC3xb738TcPjsqL15H.','Tarek.Ahmed@Sunrisehotels-Egypt.com','Tarek.Ahmed','36c2f-tarek-ahme-(resident-manager).png',6,8,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.71.144','2014-08-07 08:37:12','0000-00-00 00:00:00','2014-08-07 08:37:12'),(55,55,0,'Philippe.deVizcaya','$2a$08$ZqZv4PHcp2VMTklvmQzDIuDrEw6x9TM7ZQ3tV93xnkGNr0I74gSwe','Philippe.deVizcaya@sunrise-resorts.com','Philippe.deVizcaya','27543-philippe-sign.png',7,8,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:25:19'),(56,56,0,'','','','',NULL,0,0,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:25:30'),(57,57,0,'Hossam.Elfettouh','$2a$08$3kOTTNh1oD7F.Y76hT97Yefatuoqbmk5sVMSeeEQolT35ShlsW.q.','Hossam.Elfettouh@Sunrisehotels-Egypt.com','Hossam.Elfettouh','3e055-hossam-abou-el-fetouh-(housekeeping).png',7,12,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:26:13'),(58,58,0,'elSayed.youssif','$2a$08$2iET7BGtl0Dd4BRhos2uz.sBJsb.zCzY6VurMcOFyiiLM5PxciJSy','Laundrymgr.AB@Sunrisehotels-Egypt.com','elSayed.youssif','bf6fa-laundry-manager-(-el-sayed-yousef).png',7,12,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:27:20'),(59,59,0,'mohamed.elserwy','$2a$08$eihBk4k/Za0eclzUMiiTvuTFHW9s1BUbfbkh2P27tLUfFPDRfrcJi','mohamed.elserwy@sunrise-resorts.com','mohamed.elserwy','7c359-mohamed-serwy.png',4,9,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.31.124','2014-08-27 08:40:23','0000-00-00 00:00:00','2014-08-27 08:40:23'),(60,60,0,'waleed.mohamed-db','$2a$08$72NprvaK.Skm8iKc0qaJPehPkulwU3iLnpo4WtfXhX.D6YWW43myO','waleed.mohamed-db@sunrisehotels-egypt.com','waleed.mohamed-db','2a4dc-waleed-mohamed-(hotel-manager).png',6,8,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:32:29'),(61,61,0,'mohamed.mekky','$2a$08$w2LbzLL/LtfnxeLs9bh9a.YeTPw9s1xrwm3KFJAkl1QFdAajYVKXm','fb.manager@sunrisehotels-egypt.com','mohamed Mekky','1b084-mohamed-meky-(-assistant-fb).png',7,7,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:33:22'),(62,62,0,'emad.salah','$2a$08$UU36z3gP2OYV27qhyeln7.Afhb78t24VgV5cqF9gld2b7a56oyrsG','xec.chef@sunrisehotels-egypt.com','Emad Salah','e49ff-emad-salah-(-executive-chef).png',7,6,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:34:32'),(63,63,0,'hossam.salah','$2a$08$HTt/JnPC17hGOBm5co0GKOR.fZf2/MaH/HB6ZFp1WW7u.Z/aOMhni','hossam.salah@sunrisehotels-egypt.com','hossam.salah','4eae9-hossam-salah(fc).png',5,3,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:35:30'),(64,64,0,'hany.mosaad','$2a$08$2B3hLDvbKy2x77bXJeTmJ.8BPJKNK53tvr63Np2N8XGXEyKhSYLuW','chief.engineer@sunrisehotels-egypt.com','Hany Mosaad','3dd02-hany-mosaad-(assistant-engineering).png',7,4,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:36:34'),(65,65,0,'Elsayed.rezk','$2a$08$LFb21Tl2kLVVIo0waMPm2.FRk8vkg.9kiSAg7ZZOvrMV12PT0zZbK','Elsayed.rezk@sunrisehotels-egypt.com','Elsayed.rezk','20a84-sayed-rezk.png',7,18,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:37:39'),(66,66,0,'waleed.moawad','$2a$08$L4LlpDjKXs/7Z8NYLAUbUODRDz2cTopginke8xFW8brXPxZScOv4C','waleed.moawad@sunrisehotels-egypt.com','waleed.moawad','40293-waleed-moawad-(-hr).png',7,15,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:39:31'),(67,67,0,'ahmed.hameed','$2a$08$5peUqTg/9hXU7mlIJcZNPuThanYMsKbEHJOSCy5OCDT40HUSVQXaW','it.db@sunrisehotels-egypt.com','Ahmed Hameed','d8bc9-ahmed-a.hameed.png',7,2,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:40:48'),(68,68,0,'mohamed.khalifa','$2a$08$BmHMbvIsZVi7N/ncXMz4BeXrIvWz2l20taXJDalx2i8lchwYTTBmu','mohamed.khalifa@festivalhotels-egypt.com','mohamed.khalifa','e9591-mohammed-khalifa.jpg',6,8,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:42:23'),(69,69,0,'Tarek.Fahmy','$2a$08$OXBkPkfarfa2C9JpWiNtyehDxvokHXAkvhCLWnqBGkYPHbBqquE4.','Tarek.Fahmy@Festival-Resorts.com','Tarek.Fahmy','e2e3a-tarek-fahmy.jpg',7,18,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:43:11'),(70,70,0,'Safwat.Saber','$2a$08$sqfzHdAPyFq40UD/UhYkO.No5JvdnhSz.p2KbqXhp/I7duTJlb6dK','Safwat.Saber@Festival-Resorts.com','Safwat.Saber','4fbb8-safwat-saber.jpg',7,15,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:43:56'),(71,71,0,'Aly.Nagy','$2a$08$KO1XClC7fBc4ImIOefzVa.iF9OGE/3LEDfC6Rpj1cN7yXxa/6/Y1e','Aly.Nagy@Festival-Resorts.com','Aly.Nagy','a923f-aly-nagy.jpg',7,6,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:45:11'),(72,72,0,'Haytham.Mohamed','$2a$08$/C8ny4RpJylZ67KMRDrFC.cXbds4jNCqwEpzVHrscPRhUSBZJ.rSy','Haytham.Mohamed@Festival-Resorts.com','Haytham.Mohamed','c6445-haytham-mohamed.jpg',7,7,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:46:04'),(73,73,0,'Waleed.Ibrahim','$2a$08$z66wCu1XsvIa1BVZfv5VGeNJzfnbFb9VYyWVINcF5Xqzrj/HIxumi','Waleed.Ibrahim@Festival-Resorts.com','Waleed.Ibrahim','09576-waleed-ibrahim.jpg',7,4,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:46:56'),(74,74,0,'Mohamed.Fouad-fes','$2a$08$M.fTQ9/IUhyBa9YGJCJOs.vCkrF3xN17aD0VcUqu9bOu44QD6hJ8W','Mohamed.Fouad@Festival-Resorts.com','Mohamed.Fouad','b6a59-mohamed-fouad.jpg',7,2,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.149.132','2014-11-05 11:56:03','0000-00-00 00:00:00','2014-11-05 11:56:03'),(75,75,0,'Mohamed.Karim','$2a$08$5a9y3Lkc25UwOSMOQhiEkuXS1b/YXNT5NpHBbDZakQrnmH30GMUCK','Mohamed.Karim@Festival-Resorts.com','Mohamed.Karim','26bbc-mohamed-abd-el-karim.jpg',5,3,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:48:59'),(76,76,0,'Mohamed.Aleem','$2a$08$nrRNBsgd3hiCBzALloS8iuMrGOrTjUlkDsizl487gWJvOBKqmWksu','Mohamed.Aleem@Festival-Resorts.com','Mohamed.Aleem','18302-mohamed-abd-el-aleem.jpg',7,12,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:51:08'),(77,77,0,'yasser.nabil','$2a$08$35NYUvjPzOkJ3CcovfbZjO7bbCWzKxOsqB324bpk6KgkAbJAwMJgu','yasser.nabil@festival-resorts.com','Yasser Nabil','62faa-yasser-nabil.jpg',6,8,1,0,NULL,NULL,NULL,NULL,NULL,'41.32.14.218','2014-12-13 06:56:19','0000-00-00 00:00:00','2014-12-13 06:56:19'),(78,78,0,'mohamed.zayed','$2a$08$282AdZzr7uK4QiV1ehGO/.JEEGUUDOIhkxkaOlGfgmqZuty6BKcJO','mohamed.zayed@festivalhotels-egypt.com','mohamed.zayed','4dc3c-mohamed-zayed.jpg',7,8,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:53:07'),(79,79,0,'Sameh.nashat','$2a$08$GF2KAWrKnASfB0Z/cmaIWuOdl/T.3iY5eFf.IRYpJERL5mFdmfE5W','Sameh.nashat@festivalhotels-egypt.com','Sameh.nashat','6cb66-sameh-nashaat.jpg',7,12,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:54:03'),(80,80,0,'Mohamed.kamel','$2a$08$afNmXN7LqvkJW4NVuWL9YeXcqowBAP21dZJ5sxKJFsMfgQhU.mGT6','Fbmgr.shedwan@festivalhotels-egypt.com','Mohamed.kamel','3c3e2-mohamed-kamel.jpg',7,7,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:54:54'),(81,81,0,'Hussien.embaby','$2a$08$suPRYJKsQBOfHJSHjFGraOuBCIJDV8ibNvxqaTMYEdOk.hF2pNvoi','exchef.shedwan@festivalhotels-egypt.com','Hussien.embaby','60809-hussein-imbaby.jpg',7,6,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-06 11:56:18'),(83,83,1,'Marwan.gendy','$2a$08$aT3Sy5sTX12H6kRTXnDOn.wNaXDPw.vfpow2OmX1QqR54H4XmqXA.','Marwan.gendy@sunrise-resorts.com','Marwan EL Gendy','50148-marwan.elgendy-assistant_it.png',7,2,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.207.75','2014-12-10 08:12:58','0000-00-00 00:00:00','2014-12-10 08:12:58'),(84,84,0,'emad.milad','$2a$08$cXbaUkz/fK1SE.6F/W8fJeKg2ZperLn2yjEfJC7fZAeOkpt0NFdnO','emad.milad@sunrise-resorts.com','emad.milad','c8da0-emad.milad-general_manager.png',6,8,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.207.100','2014-11-21 12:39:59','0000-00-00 00:00:00','2014-11-21 12:39:59'),(85,85,0,'ayman.selim','$2a$08$cmXaH2p2FbBg.dS.k1UOmeXZTeaUyUPsHbuAAtvVCDnxU7bwxDAue','ayman.selim@sunrise-resorts.com','ayman.selim','b8115-ayman.selim-assistant_fc.png',5,3,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.207.75','2014-12-07 17:45:13','0000-00-00 00:00:00','2014-12-07 17:45:13'),(86,86,0,'moustafa.mahmoud','$2a$08$CUKm5sZhC/AuZpjcoPOkkOpXoMJzlP.tnR/OBAM.vDraToTBPbhx.','Moustafa.Mahmoud@sunrise-resorts.com','moustafa.mahmoud','a15a1-moustafa-mahmoud-asst.-fc.jpg',5,3,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.31.105','2014-12-07 11:18:35','0000-00-00 00:00:00','2014-12-07 11:18:35'),(91,91,0,'hussein.imbaby','$2a$08$gdXhkmVRyABzrgMwIt8aRe51xs3bZ9XTTFvbsg086j/8xb0p5eNsq','Hussein.Imbaby@festival-resorts.com','Hussein Imbaby','2abc6-hussein-imbaby.jpg',7,6,1,0,NULL,NULL,NULL,NULL,NULL,'41.32.14.218','2014-11-14 11:58:28','0000-00-00 00:00:00','2014-11-14 11:58:28'),(92,92,0,'Ezz.sayed','$2a$08$DMp7daz3HhTIsCPRmMpo9OcwhNLZBUn78qoVvPMbxVJ.LpZO/lxR2','Ezz.sayed@sunrise-resorts.com','Ezz.sayed','861f4-ezz-chief-acc.jpg',5,3,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.31.105','2014-12-13 11:20:41','0000-00-00 00:00:00','2014-12-13 11:20:41'),(93,93,0,'wael.wali','$2a$08$.weZHuA.8D3bK7k8qxjrMuI2QIKxTQuiXgOZLF8d8kL4PJ1nZg/L6','wael.wali@sunrise-resorts.com','Wael Wali','6d83f-wael.wali-general_manager.png',6,8,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.207.75','2014-12-07 14:47:23','0000-00-00 00:00:00','2014-12-07 14:47:23'),(94,94,0,'sameh.nashaat','$2a$08$sj/e3JioI8tKQF6KxzdnQ.gJ7QN5EuRTGEGWoPtqj02Qnwnlehqvy','sameh.nashaat@festival-resorts.com','sameh.nashaat','95aab-sameh-nashaat.jpg',7,12,1,0,NULL,NULL,NULL,NULL,NULL,'41.32.14.218','2014-12-07 11:08:47','0000-00-00 00:00:00','2014-12-07 11:08:47'),(95,95,0,'salem.kamal','$2a$08$N3bNkqDxtftaYwO.tqlryuZl6124rtsy7ta3WQ5.iyLQBFTPH0CCe','salem.kamal@sunrisegroup-eg.com','salem.kamal','b155a-salem-kamal.jpg',0,19,1,0,NULL,NULL,NULL,NULL,NULL,'196.218.169.163','2014-12-11 14:03:07','0000-00-00 00:00:00','2014-12-11 14:03:07'),(96,96,0,'Ismail.Ali','$2a$08$s6Fz4lnBdu1X1yN5h741kewU0Cxqv0x6hA6mL.9uzo8p0B/nM74ye','Ismail.Ali@sunrise-resorts.com','Ismail.Ali','0feb6-ismail-ali.jpg',7,12,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.31.105','2014-11-25 12:26:24','0000-00-00 00:00:00','2014-11-25 12:26:24'),(97,97,0,'Essam.Khalil','$2a$08$wRbxjo9dd9AXZfw9YEGlEuwvaEK5CNTtkm1D1JL3Y9yyKYA1MIN7C','Essam.Khalil@sunrise-resorts.com','Essam.Khalil','aa7f6-essam-khalil-engineering.png',7,4,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.31.105','2014-12-07 11:17:46','0000-00-00 00:00:00','2014-12-07 11:17:46'),(99,99,0,'mohamed.hamdy','$2a$08$QvNDMs4wZe6iAkMnfjZkQ.GCMgBZkGdbTM1A5eWIXyMeDcjljb5oi','mohamed.hamdy@sunrisegroup-eg.com','mohamed.hamdy','8c2f2-mohamed.-hamdy.jpg',11,19,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-12-10 10:56:39'),(100,100,0,'sameh.farouk','$2a$08$PKDEYao3m05b.ku1D93X2O3kusSAFmT.tp.vkWUU1amC7STaKq/u6','sameh.farouk@sunrisegroup-eg.com','sameh.farouk','9c8f5-sameh-farouk.jpg',12,19,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-12-10 08:35:04'),(101,101,0,'mohamed-attia','$2a$08$rQQekHcsc/izMwb45P8oZevARYGYPXSW.Kv/5C/flVvCP2vsqbP62','mohamed-attia@sunrisegroup-eg.com','mohamed-attia','e25e2-mohamed-attia.jpg',13,19,1,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-12-10 08:36:57'),(102,102,0,'khaled.fahmy','$2a$08$JnlbpXA/MF4MbKX21K.Yw.ysChOG6aaQS99Co3MEMFILxTtAZmMd2','khaled.fahmy@sunrisegroup-eg.com','khaled.fahmy','4b4ef-khaled-fahmy.jpg',14,19,1,0,NULL,NULL,NULL,NULL,NULL,'41.65.31.105','2014-12-10 08:38:49','0000-00-00 00:00:00','2014-12-10 08:38:49'),(103,103,0,'rehab.ibrahim','$2a$08$wEWCebdVX.OwYclxy3.wcu9L60HBmd0OzC8AY8IF6imK4O28hoCmG','rehab.ibrahim@festival-resorts.com','rehab.ibrahim','c57c7-rehab-fc.jpg',5,3,1,0,NULL,NULL,NULL,NULL,NULL,'41.32.14.218','2014-12-11 07:02:39','0000-00-00 00:00:00','2014-12-11 07:02:39');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-13 19:16:05
