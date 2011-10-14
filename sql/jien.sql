-- MySQL dump 10.14  Distrib 5.3.1-MariaDB-beta, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: jien
-- ------------------------------------------------------
-- Server version	5.3.1-MariaDB-beta-mariadb102~natty-log

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
-- Table structure for table `Page`
--

DROP TABLE IF EXISTS `Page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `title` varchar(128) NOT NULL,
  `content` tinytext NOT NULL,
  `url` varchar(128) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`page_id`),
  KEY `user_id` (`user_id`),
  KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Page`
--

LOCK TABLES `Page` WRITE;
/*!40000 ALTER TABLE `Page` DISABLE KEYS */;
INSERT INTO `Page` VALUES (1,5,'Welcome','Hello this is a welcome page','/welcome','2011-10-11 06:52:24','2011-10-12 20:05:22','0000-00-00 00:00:00',1);
/*!40000 ALTER TABLE `Page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Post`
--

DROP TABLE IF EXISTS `Post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Post` (
  `post_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `subject` varchar(256) NOT NULL,
  `message` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL,
  UNIQUE KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Post`
--

LOCK TABLES `Post` WRITE;
/*!40000 ALTER TABLE `Post` DISABLE KEYS */;
INSERT INTO `Post` VALUES (1,5,'This is a first post','testing 1 2 3','2011-10-11 06:51:57','2011-10-13 22:22:08','0000-00-00 00:00:00',1);
/*!40000 ALTER TABLE `Post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `level` tinyint(1) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `birthday` date DEFAULT NULL,
  `address` varchar(128) NOT NULL,
  `address2` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` int(11) NOT NULL,
  `country` varchar(2) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `accessed` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  KEY `level` (`level`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (5,'admin','demo',1,'male','jae','lee','','0000-00-00','','','0','',0,'','2011-10-11 15:40:41','2011-10-13 22:19:09','0000-00-00 00:00:00','2011-10-13 18:57:48',1),(38,'jae','demo',0,'male','jung','ji','jaequery@gmail.com','2009-02-08','','','studio city','ca',0,'','2011-10-12 20:21:33','2011-10-13 23:08:45',NULL,NULL,1);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-10-13 23:10:05
