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
-- Table structure for table `Category`
--

DROP TABLE IF EXISTS `Category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(32) NOT NULL,
  `category` varchar(128) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `path` varchar(512) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`category_id`),
  KEY `path` (`path`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Category`
--

LOCK TABLES `Category` WRITE;
/*!40000 ALTER TABLE `Category` DISABLE KEYS */;
INSERT INTO `Category` VALUES (2,'Post','Biz',0,'2','2011-10-20 06:16:52','2011-10-19 23:16:52',NULL,1),(3,'Post','Stiqr',2,'2,3','2011-10-20 06:18:53','2011-10-19 23:18:53',NULL,1),(4,'Post','CMS',3,'2,3,4','2011-10-20 06:24:00','2011-10-19 23:24:00',NULL,1),(5,'Post','Spiritual',0,'5','2011-10-20 06:24:16','2011-10-19 23:24:16',NULL,1),(6,'Post','Christianity',5,'5,6','2011-10-20 06:24:29','2011-10-19 23:24:29',NULL,1);
/*!40000 ALTER TABLE `Category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Contact`
--

DROP TABLE IF EXISTS `Contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Contact` (
  `contact_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `subject` varchar(256) NOT NULL,
  `message` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL,
  UNIQUE KEY `post_id` (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Contact`
--

LOCK TABLES `Contact` WRITE;
/*!40000 ALTER TABLE `Contact` DISABLE KEYS */;
INSERT INTO `Contact` VALUES (1,'jae lee','jaequery@gmail.com','jae is cool','too hot','2011-10-16 01:49:30',NULL,NULL,1),(2,'jae','jae@stiqr.com','yo','yo aman','2011-10-16 02:06:04',NULL,NULL,1),(3,'jaelen lee','jaelen@stiqr.com','jaelen is cool','i love jaelen','2011-10-16 02:21:28',NULL,NULL,1),(4,'jaelen lee','jaelen@stiqr.com','jaelen is cool','i love jaelen','2011-10-16 02:21:53',NULL,NULL,1),(5,'jaelen','jaelen@stiqr.com','jae is cool','hi jae','2011-10-16 02:23:26',NULL,NULL,1);
/*!40000 ALTER TABLE `Contact` ENABLE KEYS */;
UNLOCK TABLES;

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
  `category_id` int(11) NOT NULL,
  `subject` varchar(256) NOT NULL,
  `message` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL,
  UNIQUE KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Post`
--

LOCK TABLES `Post` WRITE;
/*!40000 ALTER TABLE `Post` DISABLE KEYS */;
INSERT INTO `Post` VALUES (1,5,3,'This is a first REAL ee post by jae','<p>\r\n	Hello amigoes,<br />\r\n	<br />\r\n	This is <strong>Jae&nbsp;</strong>the coolest dude in the whole wide world.&nbsp;<br />\r\n	And I&#39;m here to tell you a little story, and it goes like this:</p>\r\n<p>\r\n	Once up on a time...</p>\r\n','2011-10-11 06:51:57','2011-10-19 23:59:22','0000-00-00 00:00:00',1),(3,5,4,'Akunama tada','<p>\r\n	What a wonderful phrase.</p>\r\n<p>\r\n	It means no worries!</p>\r\n<p>\r\n	<span style=\"font-family:comic sans ms,cursive;\"><strong>Haknama Tada</strong></span></p>\r\n<p>\r\n	<br />\r\n	<font class=\"Apple-style-span\" face=\"\'comic sans ms\', cursive\">Hehehe</font></p>\r\n','2011-10-16 00:15:45','2011-10-20 00:37:53',NULL,1),(5,5,5,'I really want to go to disney land','<p>\r\n	I always wanted to go to disney land because my daughter loves it so much. I know how excited she will be once I take her there because we went there a few years ago when she was a little baby.</p>\r\n<p>\r\n	<img alt=\"\" src=\"http://files.stiqr.com/public/images/63670.png\" style=\"margin-left: 10px; margin-right: 10px; margin-top: 10px; margin-bottom: 10px; width: 199px; height: 210px; \" /></p>\r\n<p>\r\n	Now she knows and her expectations will be much higher, and she will know how to fully enjoy the moment.</p>\r\n','2011-10-16 00:21:59','2011-10-19 23:58:17',NULL,1),(6,5,2,'biz','<p>\r\n	biz</p>\r\n','2011-10-20 07:02:30',NULL,NULL,1),(7,5,6,'Christians','<p>\r\n	Christ</p>\r\n','2011-10-20 07:06:03','2011-10-20 00:44:13',NULL,1);
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
INSERT INTO `User` VALUES (5,'admin','demo',1,'male','jae','lee','jaequery@gmail.com','1982-01-06','','','0','',0,'','2011-10-11 15:40:41','2011-10-19 21:49:25','0000-00-00 00:00:00','2011-10-19 21:49:25',1),(38,'jae','demo',0,'male','jung','ji','jaequery@gmail.com','2009-02-08','','','studio city','ca',0,'en','2011-10-12 20:21:33','2011-10-17 16:07:09',NULL,NULL,1);
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

-- Dump completed on 2011-10-20  0:48:21
