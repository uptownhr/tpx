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
INSERT INTO `Category` VALUES (1,'Post','Web Design',0,'1','2011-10-25 02:24:39','2011-10-24 19:52:02','2011-10-24 19:52:02',0),(2,'Post','PHP',0,'2','2011-10-25 02:24:52','2011-10-24 19:24:52',NULL,1),(3,'Post','Open Source',2,'2,3','2011-10-25 02:25:01','2011-10-24 19:25:01',NULL,1),(4,'Post','Startups',0,'4','2011-10-25 02:25:26','2011-10-24 19:25:26',NULL,1),(5,'Post','Technology',0,'5','2011-10-25 02:25:37','2011-10-24 19:25:37',NULL,1),(6,'Post','Legal',4,'4,6','2011-10-25 02:30:24','2011-10-24 19:30:24',NULL,1);
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Contact`
--

LOCK TABLES `Contact` WRITE;
/*!40000 ALTER TABLE `Contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `Contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Hit`
--

DROP TABLE IF EXISTS `Hit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Hit` (
  `hit_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`hit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Hit`
--

LOCK TABLES `Hit` WRITE;
/*!40000 ALTER TABLE `Hit` DISABLE KEYS */;
/*!40000 ALTER TABLE `Hit` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Page`
--

LOCK TABLES `Page` WRITE;
/*!40000 ALTER TABLE `Page` DISABLE KEYS */;
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
  `status` enum('pending','published') NOT NULL,
  `subject` varchar(256) NOT NULL,
  `message` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL,
  UNIQUE KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Post`
--

LOCK TABLES `Post` WRITE;
/*!40000 ALTER TABLE `Post` DISABLE KEYS */;
INSERT INTO `Post` VALUES (1,38,4,'published','Obama 2012 Campaign Turns To Tumblr For â€œHuge Collaborative Storytelling Effortâ€','<p>\r\n	&nbsp;</p>\r\n<div class=\"media-container media-loading\" style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 20px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; \">\r\n	<img alt=\"obamatumblr-1\" class=\"attachment-post-detail wp-post-image\" height=\"544\" src=\"http://tctechcrunch2011.files.wordpress.com/2011/10/obamatumblr-1.png?w=586\" style=\"border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-style: initial; border-color: initial; max-width: 640px; \" title=\"obamatumblr-1\" width=\"586\" /></div>\r\n<div class=\"body-copy\" style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; \">\r\n	<p style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n		President Obama has added a new web service to his repertoire:&nbsp;<a href=\"http://www.tumblr.com/\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">Tumblr</a>, the hot blogging service that just raised another&nbsp;<a href=\"http://techcrunch.com/2011/09/26/tumblr-raises-85-million-round-from-richard-branson-vcs/\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">$85 million</a>&nbsp;in funding. You can find the new blog&nbsp;<a href=\"http://barackobama.tumblr.com/\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">right here</a>.</p>\r\n	<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n		The site was set up by the 2012 Obama/Biden campaign, which also runs his&nbsp;<a href=\"https://www.facebook.com/barackobama\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">Facebook page</a>&nbsp;and<a href=\"https://twitter.com/#!/barackobama\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">Twitter</a>&nbsp;account (The White House also recently&nbsp;<a href=\"http://techcrunch.com/2011/08/15/obama-checks-in-you-can-now-follow-our-president-on-foursquare/\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">launched</a>&nbsp;an account on&nbsp;<a href=\"https://foursquare.com/whitehouse\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">Foursquare</a>).</p>\r\n	<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n		Tumblr is generally known for having a youngish audience (particularly teens), and its reblog feature will help anything the campaign posts spread like wildfire across the service. The folks at Tumblr are undoubtedly smiling &mdash;&nbsp;the President&rsquo;s presence can be worn as a badge of honor, and also generally leads to plenty of free mainstream press coverage.</p>\r\n	<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n		In the first post on his blog, Obama&rsquo;s team writes that they want Tumblr to &ldquo;be a huge collaborative storytelling effort&mdash;a place for people across the country to share what&rsquo;s going on in our respective corners of it and how we&rsquo;re getting involved in this campaign to keep making it better.&rdquo;</p>\r\n	<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n		To do this, the site will be accepting submissions via the Tumblr submission feature. Fortunately the campaign isn&rsquo;t being naive &mdash; they&rsquo;ve preemptively asked submitters to think of their mothers before they send anything nasty.</p>\r\n	<blockquote style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0.5in; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-style: italic; \">\r\n		<p style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-style: italic; font-size: 14px; line-height: 20px; \">\r\n			There will be trolls among you: this we know.&nbsp;We ask only that you remember that we&rsquo;re people&mdash;fairly nice ones&mdash;and that your mother would want you to be polite.</p>\r\n	</blockquote>\r\n</div>\r\n<p>\r\n	&nbsp;</p>\r\n','2011-10-25 02:44:01',NULL,NULL,1),(2,38,5,'published','Amigakit Brings The Amiga Into The 21st Century With New X1000','<p>\r\n	&nbsp;</p>\r\n<div class=\"media-container media-loading\" style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 20px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; \">\r\n	<img alt=\"whynot\" class=\"attachment-post-detail wp-post-image\" height=\"433\" src=\"http://tctechcrunch2011.files.wordpress.com/2011/10/whynot.jpg?w=640\" style=\"border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-style: initial; border-color: initial; max-width: 640px; \" title=\"whynot\" width=\"640\" /></div>\r\n<div class=\"body-copy\" style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; \">\r\n	<p style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n		Amiga, Amiga&hellip; why does that name sound familiar?</p>\r\n	<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n		Ah yes,&nbsp;<em style=\"font-style: italic; \">that</em>&nbsp;Amiga. A strong early competitor in the PC wars, Commodore&rsquo;s influential and graphics-heavy OS was unfortunately more or less made extinct by Windows by the early 90s. Yet a core group of enthusiasts has kept a candle burning, and here and there you can still find a functioning machine, zealously maintained by someone who insists that the file system or multitasking kernel are still worth admiring. But would you expect a brand new PC with modern accoutrements and a price tag over $2000?</p>\r\n	<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n		That&rsquo;s just what&rsquo;s being put out by Amigakit, which has secured the distribution rights to the long-awaited (by some) X1000 desktop system. It&rsquo;s actually quite a powerhouse. Check out the specs:</p>\r\n	<ul style=\"margin-top: -15px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding-right: 0px; padding-left: 30px; \">\r\n		<li style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 30px; padding-top: 0px; padding-right: 0px; padding-bottom: 10px; padding-left: 0px; list-style-type: square; list-style-position: initial; list-style-image: initial; \">\r\n			Dual-core 2GHz PowerISA CPU (PowerPC architecture)</li>\r\n		<li style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 30px; padding-top: 0px; padding-right: 0px; padding-bottom: 10px; padding-left: 0px; list-style-type: square; list-style-position: initial; list-style-image: initial; \">\r\n			Xena 500MHz XMOS companion processor with Xorro connector</li>\r\n		<li style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 30px; padding-top: 0px; padding-right: 0px; padding-bottom: 10px; padding-left: 0px; list-style-type: square; list-style-position: initial; list-style-image: initial; \">\r\n			AMD Radeon 4650 GPU</li>\r\n		<li style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 30px; padding-top: 0px; padding-right: 0px; padding-bottom: 10px; padding-left: 0px; list-style-type: square; list-style-position: initial; list-style-image: initial; \">\r\n			1GB DDR2 RAM</li>\r\n		<li style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 30px; padding-top: 0px; padding-right: 0px; padding-bottom: 10px; padding-left: 0px; list-style-type: square; list-style-position: initial; list-style-image: initial; \">\r\n			500GB HDD</li>\r\n		<li style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 30px; padding-top: 0px; padding-right: 0px; padding-bottom: 10px; padding-left: 0px; list-style-type: square; list-style-position: initial; list-style-image: initial; \">\r\n			2 PCIe x16 slots, 4 DIMM slots, 4x SATA 2, 10x USB 2.0&lt;</li>\r\n	</ul>\r\n	<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n		<a href=\"http://www.osnews.com/story/25251/AmigaOne_X1000_To_Ship_by_Year_s_End_Amiga_Netbook_Announced\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">The rest of the specs are here at OS News</a>, with some supplementary info as well. Okay, so when I say powerhouse, I mean compared to the other Amiga machines out there. But it is, as A-EON (the system designer) says, &ldquo;powerful, modern desktop hardware,&rdquo; though spec-wise it can&rsquo;t stand up to Windows boxes a quarter its price. There&rsquo;s supposedly going to be an Amiga-based netbook arriving in mid-2012 as well if that&rsquo;s more your style.</p>\r\n	<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n		Should you buy one and take Amiga lessons? Probably not. But I think it&rsquo;s great that this community is still dedicated enough to produce something like this. It&rsquo;s hardware-software experiments and devices like this that act as a spice in the soup of consumer electronics. There are original ideas here in practice, outdated ones as well, and perhaps they will form a permutation that creates the next Photoshop, or a revolution in multithreading, or who knows what.</p>\r\n	<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n		Unfortunately this quirk of the computing world comes in at &pound;1699 in the UK before VAT. There&rsquo;s no US pricing, and I doubt it&rsquo;s any more lenient. But godspeed, Amiga-lovers.</p>\r\n</div>\r\n<p>\r\n	&nbsp;</p>\r\n','2011-10-25 02:45:28',NULL,NULL,1),(3,38,4,'published','Sencha Raises $15 Million For Their HTML5 App Development Tools','<p>\r\n	&nbsp;</p>\r\n<p style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n	<img alt=\"\" src=\"http://tctechcrunch2011.files.wordpress.com/2011/10/sencha_logo.png?w=288\" style=\"margin-left: 20px; margin-right: 20px; margin-top: 20px; margin-bottom: 20px; float: left; width: 288px; height: 120px; \" />What a week Sencha is having. Just minutes ago, they announced their new HTML 5 cloud services suite,&nbsp;<a href=\"http://techcrunch.com/2011/10/24/sencha-launches-mobile-html5-cloud-sencha-io/\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">Sencha.io</a>. Tomorrow morning, the company will announce they&rsquo;ve raised a $15 million Series B.</p>\r\n<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n	The announcement will be made during tomorrow&rsquo;s keynote of their third annual Senchacon.</p>\r\n<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n	So, what&rsquo;s a &ldquo;Sencha&rdquo;? Sencha makes Javascript frameworks and tools for HTML 5 developers. In other words, they make life easier for the people trying to make the web prettier.&nbsp;<a href=\"http://www.sencha.com/products/touch/\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">Sencha Touch</a>, for example, lets developers quickly add Native app-esque touch gestures to their web apps;&nbsp;<a href=\"http://www.sencha.com/products/animator/\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">Sencha Animator</a>, meanwhile, lets developers build complex CSS3 animations in the same way as they might build a Flash animation. It&rsquo;s also a type of green tea (specifically, it&rsquo;s green tea made without first grinding the leaves.)</p>\r\n<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n	This round was led by Jafco Venture, with existing investors Sequoia Capital and Radar Partners participating as well. Sancha previously raised $14 million in their Series A back in June of 2010.</p>\r\n','2011-10-25 02:46:42',NULL,NULL,1),(4,38,4,'published','Video-Sharing Startup Shelby.tv Launches Into Public Beta With New iOS App','<p>\r\n	&nbsp;</p>\r\n<p style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n	<a href=\"http://shelby.tv/\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \"><img alt=\"\" src=\"http://tctechcrunch2011.files.wordpress.com/2011/10/shelbytv.jpg?w=288\" style=\"margin-left: 20px; margin-right: 20px; margin-top: 20px; margin-bottom: 20px; float: left; width: 288px; height: 214px; \" />Shelby.tv</a>, the video-sharing startup (and stars of Bloomberg&rsquo;s TechStars reality show), is today exiting out of its private alpha phase and launching into a public beta. The service, founded by&nbsp;Reece Pacheco, Dan Spinosa, Henry Sztul and Joe Yevoli, aggregates the video links your friends are sharing across social networks in order to offer you personalized video recommendations.</p>\r\n<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n	It&rsquo;s now&nbsp;<a href=\"http://itunes.apple.com/us/app/shelby.tv/id467849037?mt=8\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">available in the iTunes app store</a>&nbsp;as a native app for the iPhone or iPad.</p>\r\n<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n	The new service automatically pulls all the videos your friends share on Facebook, Twitter and Tumblr into a curated video channel with videos you can watch, favorite and then re-share. There&rsquo;s also a browser bookmarklet that lets you save any video on the web into Shelby.tv for later viewing. The product is dead-simple to use, and enters into the popular (<a href=\"http://techcrunch.com/2011/07/14/shelby-tv-raises-1-5-million-to-give-you-personalized-channels-of-online-video/www.frequency.com\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">if</a>&nbsp;<a href=\"http://disrupt.techcrunch.com/NYC2011/blog/2011/05/23/deja-is-flipboard-for-video-and-its-very-slick/\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">somewhat</a>&nbsp;<a href=\"http://eu.techcrunch.com/2011/05/19/plizy-ipad-app-tries-to-be-a-flipboard-meets-pandora-for-video/\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">crowded</a>) personalized video space.</p>\r\n<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n	According to a company&nbsp;<a href=\"http://blog.shelby.tv/post/11862748816/shelbylaunch\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">blog post</a>, the newly launched iOS app has been improved based on user feedback and is now offering improved speed and performance. One notable addition is the new de-duplication feature which smartly removes duplicate copies of videos which have been shared by multiple friends.</p>\r\n<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n	There are also different ways to filter videos in the app&rsquo;s guide &ndash; by your favorites (the &ldquo;like view&rdquo;), by your saved videos (&ldquo;watch later&rdquo; view) and by the &ldquo;timeline view&rdquo; which shows you all the videos your friends are sharing. At any time, you can pull down on the video guide to refresh your recommendations.</p>\r\n<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n	Shelby.tv has $1.73 million in total funding, having most recently received a&nbsp;<a href=\"http://techcrunch.com/2011/07/14/shelby-tv-raises-1-5-million-to-give-you-personalized-channels-of-online-video/\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">$1.5 million round this summer</a>, from&nbsp;Avalon Ventures and a number of angels.</p>\r\n<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n	You can learn more about the iOS&rsquo;s app&rsquo;s features in the video below, or<a href=\"http://itunes.apple.com/us/app/shelby.tv/id467849037?mt=8\" style=\"font-weight: bold; text-decoration: none; color: rgb(10, 150, 0); outline-style: none; outline-width: initial; outline-color: initial; \">&nbsp;just download it here on iTunes</a>.</p>\r\n<p>\r\n	<span class=\"embed-youtube\" style=\"text-align: center; display: block; \"><iframe class=\"youtube-player\" frameborder=\"0\" height=\"390\" src=\"http://www.youtube.com/embed/e3PtrxwF3EA?version=3&amp;rel=1&amp;fs=1&amp;showsearch=0&amp;showinfo=1&amp;iv_load_policy=1&amp;wmode=transparent\" style=\"border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-style: initial; border-color: initial; max-width: 100%; \" type=\"text/html\" width=\"640\"></iframe></span></p>\r\n<p style=\"margin-top: 12.5px; margin-right: 0px; margin-bottom: 12.5px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; font-size: 14px; line-height: 20px; \">\r\n	&nbsp;</p>\r\n','2011-10-25 02:47:53','2011-10-24 19:48:59',NULL,1),(5,38,1,'published','20 websites that engage users with social media icons and links','<p>\r\n	&nbsp;</p>\r\n<p style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font: normal normal normal 1.25em/1.5em Verdana, Geneva, sans-serif; color: rgb(0, 0, 0); padding-top: 0px; padding-right: 0px; padding-bottom: 9px; padding-left: 0px; \">\r\n	<span style=\"font-family:arial,helvetica,sans-serif;\"><a href=\"http://netdna.webdesignerdepot.com/uploads/2011/06/wdsm_thumb02.png\" style=\"color: rgb(158, 7, 40); text-decoration: underline; font-weight: bold; word-wrap: break-word; \"><img alt=\"\" class=\"alignleft size-full wp-image-24144\" height=\"160\" src=\"http://netdna.webdesignerdepot.com/uploads/2011/06/wdsm_thumb02.png\" style=\"display: inline-block; border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-style: initial; border-color: initial; padding-top: 4px; padding-right: 4px; padding-bottom: 4px; padding-left: 0px; max-width: 100%; border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: none; border-width: initial; border-color: initial; float: left; margin-top: 0px; margin-right: 7px; margin-bottom: 2px; margin-left: 0px; vertical-align: bottom; \" title=\"wdsm_thumb02\" width=\"200\" /></a>The topic of social media is all over the web, and it is important to consider it when designing a website.</span></p>\r\n<p style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font: normal normal normal 1.25em/1.5em Verdana, Geneva, sans-serif; color: rgb(0, 0, 0); padding-top: 0px; padding-right: 0px; padding-bottom: 9px; padding-left: 0px; \">\r\n	<span style=\"font-family:arial,helvetica,sans-serif;\">The way you display&nbsp;<strong>social media icons or links</strong>&nbsp;has a direct effect on user engagement.</span></p>\r\n<p style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font: normal normal normal 1.25em/1.5em Verdana, Geneva, sans-serif; color: rgb(0, 0, 0); padding-top: 0px; padding-right: 0px; padding-bottom: 9px; padding-left: 0px; \">\r\n	<span style=\"font-family:arial,helvetica,sans-serif;\">You have to consider many details when laying out a page, including the layout, the flow of content and the main area of rest on the page.</span></p>\r\n<p style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font: normal normal normal 1.25em/1.5em Verdana, Geneva, sans-serif; color: rgb(0, 0, 0); padding-top: 0px; padding-right: 0px; padding-bottom: 9px; padding-left: 0px; \">\r\n	<span style=\"font-family:arial,helvetica,sans-serif;\">Whether you end up with typographic links in the header or icons in the footer, you should test out colors, shapes, typography and iconography to ensure that your social links are thoughtfully combined, engaging and well designed.</span></p>\r\n<p style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font: normal normal normal 1.25em/1.5em Verdana, Geneva, sans-serif; color: rgb(0, 0, 0); padding-top: 0px; padding-right: 0px; padding-bottom: 9px; padding-left: 0px; \">\r\n	<span style=\"font-family:arial,helvetica,sans-serif;\">Here, we&rsquo;ll show you some examples of how websites display their social links so that you can see the variety of options out there. Check them out, and let us know what you think.</span></p>\r\n','2011-10-25 02:50:55','2011-10-24 19:51:55','2011-10-24 19:51:55',0);
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
  `password` varchar(60) NOT NULL,
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
INSERT INTO `User` VALUES (5,'admin','$2a$08$LtbZ7x22f4uYzlBJz.2nBuIg2L5HiX0APDWPJZT0Tv1pkVvs6BYqS',1,'male','jaeq','lee','jaequery@gmail.com','1982-01-06','12908','','0','',0,'','2011-10-11 15:40:41','2011-10-24 19:17:00','0000-00-00 00:00:00','2011-10-24 19:17:00',1),(38,'jae','$2a$08$VNyW3CNQ5RiEWYiyT21xoeslr0JbsA58feoRhP2YrSSNEdocXbGHS',1,'male','jiena','ji','jaequery@gmail.com','2009-02-08','4121','','studio city','ca',0,'en','2011-10-12 20:21:33','2011-10-24 19:17:19',NULL,'2011-10-24 19:17:19',1);
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

-- Dump completed on 2011-10-24 19:52:53
