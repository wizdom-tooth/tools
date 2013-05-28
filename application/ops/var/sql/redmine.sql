-- MySQL dump 10.13  Distrib 5.1.66, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: wiz_esta_onlinecenter
-- ------------------------------------------------------
-- Server version	5.1.66

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
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `container_id` int(11) DEFAULT NULL,
  `container_type` varchar(30) DEFAULT NULL,
  `filename` varchar(255) NOT NULL DEFAULT '',
  `disk_filename` varchar(255) NOT NULL DEFAULT '',
  `filesize` int(11) NOT NULL DEFAULT '0',
  `content_type` varchar(255) DEFAULT '',
  `digest` varchar(40) NOT NULL DEFAULT '',
  `downloads` int(11) NOT NULL DEFAULT '0',
  `author_id` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `disk_directory` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_attachments_on_author_id` (`author_id`),
  KEY `index_attachments_on_created_on` (`created_on`),
  KEY `index_attachments_on_container_id_and_container_type` (`container_id`,`container_type`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachments`
--

LOCK TABLES `attachments` WRITE;
/*!40000 ALTER TABLE `attachments` DISABLE KEYS */;
INSERT INTO `attachments` VALUES (4,7,'WikiPage','apply_select.png','130426165125_apply_select.png',48639,NULL,'2f8c0a5eabba14f9b84d9fd76658a8de',0,1,'2013-04-26 16:51:25','','2013/04'),(5,7,'WikiPage','apply_done.png','130426173603_apply_done.png',22267,NULL,'f26001663e7749c6b4b7dea94ba7ce88',0,1,'2013-04-26 17:36:03','','2013/04'),(6,7,'WikiPage','apply_reject.png','130426174022_apply_reject.png',20339,NULL,'96ee544dd24efc30b48dc0e72e5ba171',0,1,'2013-04-26 17:40:22','','2013/04');
/*!40000 ALTER TABLE `attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_sources`
--

DROP TABLE IF EXISTS `auth_sources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_sources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL DEFAULT '',
  `name` varchar(60) NOT NULL DEFAULT '',
  `host` varchar(60) DEFAULT NULL,
  `port` int(11) DEFAULT NULL,
  `account` varchar(255) DEFAULT NULL,
  `account_password` varchar(255) DEFAULT '',
  `base_dn` varchar(255) DEFAULT NULL,
  `attr_login` varchar(30) DEFAULT NULL,
  `attr_firstname` varchar(30) DEFAULT NULL,
  `attr_lastname` varchar(30) DEFAULT NULL,
  `attr_mail` varchar(30) DEFAULT NULL,
  `onthefly_register` tinyint(1) NOT NULL DEFAULT '0',
  `tls` tinyint(1) NOT NULL DEFAULT '0',
  `filter` varchar(255) DEFAULT NULL,
  `timeout` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_auth_sources_on_id_and_type` (`id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_sources`
--

LOCK TABLES `auth_sources` WRITE;
/*!40000 ALTER TABLE `auth_sources` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_sources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `boards`
--

DROP TABLE IF EXISTS `boards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `boards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT '1',
  `topics_count` int(11) NOT NULL DEFAULT '0',
  `messages_count` int(11) NOT NULL DEFAULT '0',
  `last_message_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `boards_project_id` (`project_id`),
  KEY `index_boards_on_last_message_id` (`last_message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `boards`
--

LOCK TABLES `boards` WRITE;
/*!40000 ALTER TABLE `boards` DISABLE KEYS */;
/*!40000 ALTER TABLE `boards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `changes`
--

DROP TABLE IF EXISTS `changes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `changes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `changeset_id` int(11) NOT NULL,
  `action` varchar(1) NOT NULL DEFAULT '',
  `path` text NOT NULL,
  `from_path` text,
  `from_revision` varchar(255) DEFAULT NULL,
  `revision` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `changesets_changeset_id` (`changeset_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `changes`
--

LOCK TABLES `changes` WRITE;
/*!40000 ALTER TABLE `changes` DISABLE KEYS */;
/*!40000 ALTER TABLE `changes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `changeset_parents`
--

DROP TABLE IF EXISTS `changeset_parents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `changeset_parents` (
  `changeset_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  KEY `changeset_parents_changeset_ids` (`changeset_id`),
  KEY `changeset_parents_parent_ids` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `changeset_parents`
--

LOCK TABLES `changeset_parents` WRITE;
/*!40000 ALTER TABLE `changeset_parents` DISABLE KEYS */;
/*!40000 ALTER TABLE `changeset_parents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `changesets`
--

DROP TABLE IF EXISTS `changesets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `changesets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repository_id` int(11) NOT NULL,
  `revision` varchar(255) NOT NULL,
  `committer` varchar(255) DEFAULT NULL,
  `committed_on` datetime NOT NULL,
  `comments` text,
  `commit_date` date DEFAULT NULL,
  `scmid` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `changesets_repos_rev` (`repository_id`,`revision`),
  KEY `index_changesets_on_user_id` (`user_id`),
  KEY `index_changesets_on_repository_id` (`repository_id`),
  KEY `index_changesets_on_committed_on` (`committed_on`),
  KEY `changesets_repos_scmid` (`repository_id`,`scmid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `changesets`
--

LOCK TABLES `changesets` WRITE;
/*!40000 ALTER TABLE `changesets` DISABLE KEYS */;
/*!40000 ALTER TABLE `changesets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `changesets_issues`
--

DROP TABLE IF EXISTS `changesets_issues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `changesets_issues` (
  `changeset_id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL,
  UNIQUE KEY `changesets_issues_ids` (`changeset_id`,`issue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `changesets_issues`
--

LOCK TABLES `changesets_issues` WRITE;
/*!40000 ALTER TABLE `changesets_issues` DISABLE KEYS */;
/*!40000 ALTER TABLE `changesets_issues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chart`
--

DROP TABLE IF EXISTS `chart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chart` (
  `date` date NOT NULL,
  `ad` varchar(10) NOT NULL DEFAULT '',
  `apply` int(10) unsigned NOT NULL DEFAULT '0',
  `paid` int(10) unsigned NOT NULL DEFAULT '0',
  `sex_m` int(10) unsigned NOT NULL DEFAULT '0',
  `sex_f` int(10) unsigned NOT NULL DEFAULT '0',
  `time_0` int(10) unsigned NOT NULL DEFAULT '0',
  `time_3` int(10) unsigned NOT NULL DEFAULT '0',
  `time_6` int(10) unsigned NOT NULL DEFAULT '0',
  `time_9` int(10) unsigned NOT NULL DEFAULT '0',
  `time_12` int(10) unsigned NOT NULL DEFAULT '0',
  `time_15` int(10) unsigned NOT NULL DEFAULT '0',
  `time_18` int(10) unsigned NOT NULL DEFAULT '0',
  `time_21` int(10) unsigned NOT NULL DEFAULT '0',
  `age_0` int(10) unsigned NOT NULL DEFAULT '0',
  `age_10` int(10) unsigned NOT NULL DEFAULT '0',
  `age_20` int(10) unsigned NOT NULL DEFAULT '0',
  `age_30` int(10) unsigned NOT NULL DEFAULT '0',
  `age_40` int(10) unsigned NOT NULL DEFAULT '0',
  `age_50` int(10) unsigned NOT NULL DEFAULT '0',
  `age_60` int(10) unsigned NOT NULL DEFAULT '0',
  `age_70` int(10) unsigned NOT NULL DEFAULT '0',
  `age_80` int(10) unsigned NOT NULL DEFAULT '0',
  `age_90` int(10) unsigned NOT NULL DEFAULT '0',
  `age_100` int(10) unsigned NOT NULL DEFAULT '0',
  `hokkaido` int(10) unsigned NOT NULL DEFAULT '0',
  `aomori` int(10) unsigned NOT NULL DEFAULT '0',
  `iwate` int(10) unsigned NOT NULL DEFAULT '0',
  `miyagi` int(10) unsigned NOT NULL DEFAULT '0',
  `akita` int(10) unsigned NOT NULL DEFAULT '0',
  `yamagata` int(10) unsigned NOT NULL DEFAULT '0',
  `fukushima` int(10) unsigned NOT NULL DEFAULT '0',
  `ibaraki` int(10) unsigned NOT NULL DEFAULT '0',
  `tochigi` int(10) unsigned NOT NULL DEFAULT '0',
  `gunma` int(10) unsigned NOT NULL DEFAULT '0',
  `saitama` int(10) unsigned NOT NULL DEFAULT '0',
  `chiba` int(10) unsigned NOT NULL DEFAULT '0',
  `tokyo` int(10) unsigned NOT NULL DEFAULT '0',
  `kanagawa` int(10) unsigned NOT NULL DEFAULT '0',
  `niigata` int(10) unsigned NOT NULL DEFAULT '0',
  `toyama` int(10) unsigned NOT NULL DEFAULT '0',
  `ishikawa` int(10) unsigned NOT NULL DEFAULT '0',
  `fukui` int(10) unsigned NOT NULL DEFAULT '0',
  `yamanashi` int(10) unsigned NOT NULL DEFAULT '0',
  `nagano` int(10) unsigned NOT NULL DEFAULT '0',
  `gifu` int(10) unsigned NOT NULL DEFAULT '0',
  `shizuoka` int(10) unsigned NOT NULL DEFAULT '0',
  `aichi` int(10) unsigned NOT NULL DEFAULT '0',
  `mie` int(10) unsigned NOT NULL DEFAULT '0',
  `shiga` int(10) unsigned NOT NULL DEFAULT '0',
  `kyoto` int(10) unsigned NOT NULL DEFAULT '0',
  `osaka` int(10) unsigned NOT NULL DEFAULT '0',
  `hyogo` int(10) unsigned NOT NULL DEFAULT '0',
  `nara` int(10) unsigned NOT NULL DEFAULT '0',
  `wakayama` int(10) unsigned NOT NULL DEFAULT '0',
  `tottori` int(10) unsigned NOT NULL DEFAULT '0',
  `shimane` int(10) unsigned NOT NULL DEFAULT '0',
  `okayama` int(10) unsigned NOT NULL DEFAULT '0',
  `hiroshima` int(10) unsigned NOT NULL DEFAULT '0',
  `yamaguchi` int(10) unsigned NOT NULL DEFAULT '0',
  `tokushima` int(10) unsigned NOT NULL DEFAULT '0',
  `kagawa` int(10) unsigned NOT NULL DEFAULT '0',
  `ehime` int(10) unsigned NOT NULL DEFAULT '0',
  `kochi` int(10) unsigned NOT NULL DEFAULT '0',
  `fukuoka` int(10) unsigned NOT NULL DEFAULT '0',
  `saga` int(10) unsigned NOT NULL DEFAULT '0',
  `nagasaki` int(10) unsigned NOT NULL DEFAULT '0',
  `kumamoto` int(10) unsigned NOT NULL DEFAULT '0',
  `oita` int(10) unsigned NOT NULL DEFAULT '0',
  `miyazaki` int(10) unsigned NOT NULL DEFAULT '0',
  `kagoshima` int(10) unsigned NOT NULL DEFAULT '0',
  `okinawa` int(10) unsigned NOT NULL DEFAULT '0',
  `monday` int(10) unsigned NOT NULL DEFAULT '0',
  `tuesday` int(10) unsigned NOT NULL DEFAULT '0',
  `wednesday` int(10) unsigned NOT NULL DEFAULT '0',
  `thursday` int(10) unsigned NOT NULL DEFAULT '0',
  `friday` int(10) unsigned NOT NULL DEFAULT '0',
  `saturday` int(10) unsigned NOT NULL DEFAULT '0',
  `sunday` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`date`,`ad`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chart`
--

LOCK TABLES `chart` WRITE;
/*!40000 ALTER TABLE `chart` DISABLE KEYS */;
/*!40000 ALTER TABLE `chart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commented_type` varchar(30) NOT NULL DEFAULT '',
  `commented_id` int(11) NOT NULL DEFAULT '0',
  `author_id` int(11) NOT NULL DEFAULT '0',
  `comments` text,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_comments_on_commented_id_and_commented_type` (`commented_id`,`commented_type`),
  KEY `index_comments_on_author_id` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_fields`
--

DROP TABLE IF EXISTS `custom_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL DEFAULT '',
  `name` varchar(30) NOT NULL DEFAULT '',
  `field_format` varchar(30) NOT NULL DEFAULT '',
  `possible_values` text,
  `regexp` varchar(255) DEFAULT '',
  `min_length` int(11) NOT NULL DEFAULT '0',
  `max_length` int(11) NOT NULL DEFAULT '0',
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `is_for_all` tinyint(1) NOT NULL DEFAULT '0',
  `is_filter` tinyint(1) NOT NULL DEFAULT '0',
  `position` int(11) DEFAULT '1',
  `searchable` tinyint(1) DEFAULT '0',
  `default_value` text,
  `editable` tinyint(1) DEFAULT '1',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `multiple` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_custom_fields_on_id_and_type` (`id`,`type`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_fields`
--

LOCK TABLES `custom_fields` WRITE;
/*!40000 ALTER TABLE `custom_fields` DISABLE KEYS */;
INSERT INTO `custom_fields` VALUES (1,'IssueCustomField','姓','string',NULL,'',0,0,1,0,0,1,1,NULL,1,1,0),(2,'IssueCustomField','名','string',NULL,'',0,0,1,0,0,2,1,NULL,1,1,0),(3,'IssueCustomField','出生国','string',NULL,'',0,0,1,0,0,3,1,NULL,1,1,0),(4,'IssueCustomField','国籍','string',NULL,'',0,0,1,0,0,4,1,NULL,1,1,0),(5,'IssueCustomField','居住国','string',NULL,'',0,0,1,0,0,5,1,NULL,1,1,0),(6,'IssueCustomField','生年月日','date',NULL,'',0,0,1,0,0,6,0,NULL,1,1,0),(7,'IssueCustomField','性別','string',NULL,'^(M|F)$',0,0,1,0,1,7,1,NULL,1,1,0),(8,'IssueCustomField','パスポート番号','string',NULL,'',0,0,1,0,0,8,1,NULL,1,1,0),(9,'IssueCustomField','パスポート発行日','date',NULL,'',0,0,1,0,0,9,0,NULL,1,1,0),(10,'IssueCustomField','パスポート有効期限','date',NULL,'',0,0,1,0,0,10,0,NULL,1,1,0),(11,'IssueCustomField','メールアドレス','string',NULL,'^([a-zA-Z0-9])+([a-zA-Z0-9\\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\\._-]+)+$',0,0,0,0,0,11,1,NULL,1,1,0),(12,'IssueCustomField','電話番号','string',NULL,'',0,0,1,0,0,12,1,NULL,1,1,0),(13,'IssueCustomField','アクセス元情報','string','--- \n','',0,0,1,0,1,13,1,'',1,1,0),(14,'IssueCustomField','ESTA渡航申請番号','string',NULL,'^[A-Z0-9]+$',16,16,0,0,0,14,1,NULL,1,1,0),(15,'IssueCustomField','ESTA有効期限','string',NULL,'^([1-9][0-9]{3})\\/(0[1-9]{1}|1[0-2]{1})\\/(0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})$',0,0,0,0,0,15,0,NULL,1,1,0),(16,'IssueCustomField','ESTA認証メール送信状況','list','--- \n- !binary |\n  5pyq6YCB5L+h\n\n- !binary |\n  6YCB5L+h5riI44G/\n\n- !binary |\n  6YCB5L+h5aSx5pWX\n\n','',0,0,0,0,1,16,1,'未送信',1,1,0),(17,'IssueCustomField','広告','string',NULL,'',0,0,1,0,1,17,1,NULL,1,1,0),(18,'IssueCustomField','質問A','string',NULL,'',0,0,1,0,0,18,0,NULL,1,1,0),(19,'IssueCustomField','質問B','string',NULL,'',0,0,1,0,0,19,0,NULL,1,1,0),(20,'IssueCustomField','質問C','string',NULL,'',0,0,1,0,0,20,0,NULL,1,1,0),(21,'IssueCustomField','質問D','string',NULL,'',0,0,1,0,0,21,0,NULL,1,1,0),(22,'IssueCustomField','質問E','string',NULL,'',0,0,1,0,0,22,0,NULL,1,1,0),(23,'IssueCustomField','質問F','string',NULL,'',0,0,1,0,0,23,0,NULL,1,1,0),(24,'IssueCustomField','質問F_いつ','string',NULL,'',0,0,0,0,0,24,0,NULL,1,1,0),(25,'IssueCustomField','質問F_どこで','string',NULL,'',0,0,0,0,0,25,0,NULL,1,1,0),(26,'IssueCustomField','質問G','string',NULL,'',0,0,1,0,0,26,0,NULL,1,1,0),(27,'IssueCustomField','曜日','string',NULL,'',0,0,1,0,1,27,1,NULL,1,1,0),(28,'IssueCustomField','年齢層','string',NULL,'',0,0,1,0,1,28,1,NULL,1,1,0),(29,'IssueCustomField','paypal取引ID','string',NULL,'',0,0,0,0,0,29,1,NULL,1,1,0),(30,'IssueCustomField','paypal受領書ID','string',NULL,'',0,0,0,0,0,30,1,NULL,1,1,0),(31,'IssueCustomField','paypal返金金額','string',NULL,'',0,6195,0,0,1,31,0,NULL,1,1,0),(32,'IssueCustomField','お客様ID','string',NULL,'',0,0,1,0,0,32,1,NULL,1,1,0),(33,'IssueCustomField','お申し込みID','string',NULL,'',0,0,1,0,0,33,1,NULL,1,1,0),(34,'IssueCustomField','利用デバイス','string',NULL,'^(pc|mobile|other)$',0,0,1,0,1,34,0,NULL,1,1,0);
/*!40000 ALTER TABLE `custom_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_fields_projects`
--

DROP TABLE IF EXISTS `custom_fields_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_fields_projects` (
  `custom_field_id` int(11) NOT NULL DEFAULT '0',
  `project_id` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `index_custom_fields_projects_on_custom_field_id_and_project_id` (`custom_field_id`,`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_fields_projects`
--

LOCK TABLES `custom_fields_projects` WRITE;
/*!40000 ALTER TABLE `custom_fields_projects` DISABLE KEYS */;
INSERT INTO `custom_fields_projects` VALUES (1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),(13,2),(14,2),(15,2),(16,2),(17,2),(18,2),(19,2),(20,2),(21,2),(22,2),(23,2),(24,2),(25,2),(26,2),(27,2),(28,2),(29,2),(30,2),(31,2),(32,2),(33,2),(34,2);
/*!40000 ALTER TABLE `custom_fields_projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_fields_trackers`
--

DROP TABLE IF EXISTS `custom_fields_trackers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_fields_trackers` (
  `custom_field_id` int(11) NOT NULL DEFAULT '0',
  `tracker_id` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `index_custom_fields_trackers_on_custom_field_id_and_tracker_id` (`custom_field_id`,`tracker_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_fields_trackers`
--

LOCK TABLES `custom_fields_trackers` WRITE;
/*!40000 ALTER TABLE `custom_fields_trackers` DISABLE KEYS */;
INSERT INTO `custom_fields_trackers` VALUES (1,4),(1,5),(2,4),(2,5),(3,4),(3,5),(4,4),(4,5),(5,4),(5,5),(6,4),(6,5),(7,4),(7,5),(8,4),(8,5),(9,4),(9,5),(10,4),(10,5),(11,4),(11,5),(12,4),(12,5),(13,4),(13,5),(14,4),(14,5),(15,4),(15,5),(16,4),(16,5),(17,4),(17,5),(18,4),(18,5),(19,4),(19,5),(20,4),(20,5),(21,4),(21,5),(22,4),(22,5),(23,4),(23,5),(24,4),(24,5),(25,4),(25,5),(26,4),(26,5),(27,4),(27,5),(28,4),(28,5),(29,4),(29,5),(30,4),(30,5),(31,4),(31,5),(32,4),(32,5),(33,4),(33,5),(34,4),(34,5);
/*!40000 ALTER TABLE `custom_fields_trackers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_values`
--

DROP TABLE IF EXISTS `custom_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customized_type` varchar(30) NOT NULL DEFAULT '',
  `customized_id` int(11) NOT NULL DEFAULT '0',
  `custom_field_id` int(11) NOT NULL DEFAULT '0',
  `value` text,
  PRIMARY KEY (`id`),
  KEY `custom_values_customized` (`customized_type`,`customized_id`),
  KEY `index_custom_values_on_custom_field_id` (`custom_field_id`),
  KEY `index_value` (`value`(50))
) ENGINE=InnoDB AUTO_INCREMENT=9683 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_values`
--

LOCK TABLES `custom_values` WRITE;
/*!40000 ALTER TABLE `custom_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(60) NOT NULL DEFAULT '',
  `description` text,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_project_id` (`project_id`),
  KEY `index_documents_on_category_id` (`category_id`),
  KEY `index_documents_on_created_on` (`created_on`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enabled_modules`
--

DROP TABLE IF EXISTS `enabled_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enabled_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `enabled_modules_project_id` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enabled_modules`
--

LOCK TABLES `enabled_modules` WRITE;
/*!40000 ALTER TABLE `enabled_modules` DISABLE KEYS */;
INSERT INTO `enabled_modules` VALUES (3,2,'issue_tracking'),(4,2,'wiki');
/*!40000 ALTER TABLE `enabled_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enumerations`
--

DROP TABLE IF EXISTS `enumerations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enumerations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `position` int(11) DEFAULT '1',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `project_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `position_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_enumerations_on_project_id` (`project_id`),
  KEY `index_enumerations_on_id_and_type` (`id`,`type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enumerations`
--

LOCK TABLES `enumerations` WRITE;
/*!40000 ALTER TABLE `enumerations` DISABLE KEYS */;
INSERT INTO `enumerations` VALUES (2,'通常',1,1,'IssuePriority',1,NULL,NULL,'default');
/*!40000 ALTER TABLE `enumerations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups_users`
--

DROP TABLE IF EXISTS `groups_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups_users` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  UNIQUE KEY `groups_users_ids` (`group_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups_users`
--

LOCK TABLES `groups_users` WRITE;
/*!40000 ALTER TABLE `groups_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issue_categories`
--

DROP TABLE IF EXISTS `issue_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issue_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL DEFAULT '',
  `assigned_to_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `issue_categories_project_id` (`project_id`),
  KEY `index_issue_categories_on_assigned_to_id` (`assigned_to_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue_categories`
--

LOCK TABLES `issue_categories` WRITE;
/*!40000 ALTER TABLE `issue_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `issue_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issue_relations`
--

DROP TABLE IF EXISTS `issue_relations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issue_relations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_from_id` int(11) NOT NULL,
  `issue_to_id` int(11) NOT NULL,
  `relation_type` varchar(255) NOT NULL DEFAULT '',
  `delay` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_issue_relations_on_issue_from_id_and_issue_to_id` (`issue_from_id`,`issue_to_id`),
  KEY `index_issue_relations_on_issue_from_id` (`issue_from_id`),
  KEY `index_issue_relations_on_issue_to_id` (`issue_to_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue_relations`
--

LOCK TABLES `issue_relations` WRITE;
/*!40000 ALTER TABLE `issue_relations` DISABLE KEYS */;
/*!40000 ALTER TABLE `issue_relations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issue_statuses`
--

DROP TABLE IF EXISTS `issue_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issue_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `is_closed` tinyint(1) NOT NULL DEFAULT '0',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `position` int(11) DEFAULT '1',
  `default_done_ratio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_issue_statuses_on_position` (`position`),
  KEY `index_issue_statuses_on_is_closed` (`is_closed`),
  KEY `index_issue_statuses_on_is_default` (`is_default`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue_statuses`
--

LOCK TABLES `issue_statuses` WRITE;
/*!40000 ALTER TABLE `issue_statuses` DISABLE KEYS */;
INSERT INTO `issue_statuses` VALUES (1,'新規',0,1,1,0),(7,'手続き完了',1,0,2,100),(8,'キャンセル完了',1,0,3,100),(9,'認証拒否',1,0,4,100),(10,'返金処理待ち',0,0,5,0),(11,'保留',0,0,6,0),(12,'決済待ち',1,0,7,100);
/*!40000 ALTER TABLE `issue_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issues`
--

DROP TABLE IF EXISTS `issues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tracker_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `due_date` date DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `assigned_to_id` int(11) DEFAULT NULL,
  `priority_id` int(11) NOT NULL,
  `fixed_version_id` int(11) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `lock_version` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `done_ratio` int(11) NOT NULL DEFAULT '0',
  `estimated_hours` float DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `root_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT '0',
  `closed_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `issues_project_id` (`project_id`),
  KEY `index_issues_on_status_id` (`status_id`),
  KEY `index_issues_on_category_id` (`category_id`),
  KEY `index_issues_on_assigned_to_id` (`assigned_to_id`),
  KEY `index_issues_on_fixed_version_id` (`fixed_version_id`),
  KEY `index_issues_on_tracker_id` (`tracker_id`),
  KEY `index_issues_on_priority_id` (`priority_id`),
  KEY `index_issues_on_author_id` (`author_id`),
  KEY `index_issues_on_created_on` (`created_on`),
  KEY `index_issues_on_root_id_and_lft_and_rgt` (`root_id`,`lft`,`rgt`)
) ENGINE=InnoDB AUTO_INCREMENT=288 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issues`
--

LOCK TABLES `issues` WRITE;
/*!40000 ALTER TABLE `issues` DISABLE KEYS */;
/*!40000 ALTER TABLE `issues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_details`
--

DROP TABLE IF EXISTS `journal_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `journal_id` int(11) NOT NULL DEFAULT '0',
  `property` varchar(30) NOT NULL DEFAULT '',
  `prop_key` varchar(30) NOT NULL DEFAULT '',
  `old_value` text,
  `value` text,
  PRIMARY KEY (`id`),
  KEY `journal_details_journal_id` (`journal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2492 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_details`
--

LOCK TABLES `journal_details` WRITE;
/*!40000 ALTER TABLE `journal_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `journal_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journals`
--

DROP TABLE IF EXISTS `journals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `journalized_id` int(11) NOT NULL DEFAULT '0',
  `journalized_type` varchar(30) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `notes` text,
  `created_on` datetime NOT NULL,
  `private_notes` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `journals_journalized_id` (`journalized_id`,`journalized_type`),
  KEY `index_journals_on_user_id` (`user_id`),
  KEY `index_journals_on_journalized_id` (`journalized_id`),
  KEY `index_journals_on_created_on` (`created_on`)
) ENGINE=InnoDB AUTO_INCREMENT=808 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journals`
--

LOCK TABLES `journals` WRITE;
/*!40000 ALTER TABLE `journals` DISABLE KEYS */;
/*!40000 ALTER TABLE `journals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_roles`
--

DROP TABLE IF EXISTS `member_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `inherited_from` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_member_roles_on_member_id` (`member_id`),
  KEY `index_member_roles_on_role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_roles`
--

LOCK TABLES `member_roles` WRITE;
/*!40000 ALTER TABLE `member_roles` DISABLE KEYS */;
INSERT INTO `member_roles` VALUES (3,3,3,NULL),(4,4,6,NULL),(5,5,6,NULL),(6,6,6,NULL),(7,7,6,NULL),(8,8,6,NULL);
/*!40000 ALTER TABLE `member_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `project_id` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `mail_notification` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_members_on_user_id_and_project_id` (`user_id`,`project_id`),
  KEY `index_members_on_user_id` (`user_id`),
  KEY `index_members_on_project_id` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (3,1,2,'2013-04-22 22:42:42',0),(4,3,2,'2013-04-22 22:42:42',0),(5,4,2,'2013-04-23 17:52:33',0),(6,5,2,'2013-04-23 17:52:33',0),(7,6,2,'2013-04-23 18:05:52',0),(8,7,2,'2013-04-27 13:12:11',0);
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `board_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `subject` varchar(255) NOT NULL DEFAULT '',
  `content` text,
  `author_id` int(11) DEFAULT NULL,
  `replies_count` int(11) NOT NULL DEFAULT '0',
  `last_reply_id` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `locked` tinyint(1) DEFAULT '0',
  `sticky` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `messages_board_id` (`board_id`),
  KEY `messages_parent_id` (`parent_id`),
  KEY `index_messages_on_last_reply_id` (`last_reply_id`),
  KEY `index_messages_on_author_id` (`author_id`),
  KEY `index_messages_on_created_on` (`created_on`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `title` varchar(60) NOT NULL DEFAULT '',
  `summary` varchar(255) DEFAULT '',
  `description` text,
  `author_id` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `comments_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `news_project_id` (`project_id`),
  KEY `index_news_on_author_id` (`author_id`),
  KEY `index_news_on_created_on` (`created_on`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `open_id_authentication_associations`
--

DROP TABLE IF EXISTS `open_id_authentication_associations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `open_id_authentication_associations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issued` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `handle` varchar(255) DEFAULT NULL,
  `assoc_type` varchar(255) DEFAULT NULL,
  `server_url` blob,
  `secret` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `open_id_authentication_associations`
--

LOCK TABLES `open_id_authentication_associations` WRITE;
/*!40000 ALTER TABLE `open_id_authentication_associations` DISABLE KEYS */;
/*!40000 ALTER TABLE `open_id_authentication_associations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `open_id_authentication_nonces`
--

DROP TABLE IF EXISTS `open_id_authentication_nonces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `open_id_authentication_nonces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) NOT NULL,
  `server_url` varchar(255) DEFAULT NULL,
  `salt` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `open_id_authentication_nonces`
--

LOCK TABLES `open_id_authentication_nonces` WRITE;
/*!40000 ALTER TABLE `open_id_authentication_nonces` DISABLE KEYS */;
/*!40000 ALTER TABLE `open_id_authentication_nonces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `homepage` varchar(255) DEFAULT '',
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `parent_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `identifier` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `inherit_members` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_projects_on_lft` (`lft`),
  KEY `index_projects_on_rgt` (`rgt`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (2,'esta_onlinecenter','','',0,NULL,'2013-04-22 22:42:42','2013-04-22 22:42:42','esta_onlinecenter',1,1,2,0);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects_trackers`
--

DROP TABLE IF EXISTS `projects_trackers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects_trackers` (
  `project_id` int(11) NOT NULL DEFAULT '0',
  `tracker_id` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `projects_trackers_unique` (`project_id`,`tracker_id`),
  KEY `projects_trackers_project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects_trackers`
--

LOCK TABLES `projects_trackers` WRITE;
/*!40000 ALTER TABLE `projects_trackers` DISABLE KEYS */;
INSERT INTO `projects_trackers` VALUES (2,4),(2,5);
/*!40000 ALTER TABLE `projects_trackers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `queries`
--

DROP TABLE IF EXISTS `queries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `queries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `filters` text,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `is_public` tinyint(1) NOT NULL DEFAULT '0',
  `column_names` text,
  `sort_criteria` text,
  `group_by` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_queries_on_project_id` (`project_id`),
  KEY `index_queries_on_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `queries`
--

LOCK TABLES `queries` WRITE;
/*!40000 ALTER TABLE `queries` DISABLE KEYS */;
INSERT INTO `queries` VALUES (1,2,'#0 全申請','--- {}\n\n',1,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(2,2,'#2 未完了（担当者：自分）','--- \nassigned_to_id: \n  :values: \n  - me\n  :operator: \"=\"\ntracker_id: \n  :values: \n  - \"4\"\n  :operator: \"=\"\nstatus_id: \n  :values: \n  - \"1\"\n  :operator: \"=\"\n',1,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(3,2,'#2 未完了（担当者：自分以外）','--- \nassigned_to_id: \n  :values: \n  - me\n  :operator: \"!\"\ntracker_id: \n  :values: \n  - \"4\"\n  :operator: \"=\"\nstatus_id: \n  :values: \n  - \"1\"\n  :operator: \"=\"\n',1,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(4,2,'#2 未完了（担当者：なし）','--- \nassigned_to_id: \n  :values: \n  - \"\"\n  :operator: \"!*\"\ntracker_id: \n  :values: \n  - \"4\"\n  :operator: \"=\"\nstatus_id: \n  :values: \n  - \"1\"\n  :operator: \"=\"\n',1,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(5,2,'#1 -------------------------------','--- {}\n\n',1,1,'--- \n','--- []\n\n','','IssueQuery'),(6,2,'#0 -------------------------------','--- {}\n\n',1,1,'--- \n','--- []\n\n','','IssueQuery'),(7,2,'#3 -------------------------------','--- {}\n\n',1,1,'--- \n','--- []\n\n','','IssueQuery'),(8,2,'#3 完了済み（担当者：自分）','--- \ntracker_id: \n  :values: \n  - \"4\"\n  :operator: \"=\"\nassigned_to_id: \n  :values: \n  - me\n  :operator: \"=\"\nstatus_id: \n  :values: \n  - \"\"\n  :operator: c\n',1,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(9,2,'#3 完了済み（担当者：自分以外）','--- \ntracker_id: \n  :values: \n  - \"4\"\n  :operator: \"=\"\nassigned_to_id: \n  :values: \n  - me\n  :operator: \"!\"\nstatus_id: \n  :values: \n  - \"\"\n  :operator: c\n',1,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(10,2,'#4 -------------------------------','--- {}\n\n',1,1,'--- \n','--- []\n\n','','IssueQuery'),(11,2,'#4 返金処理待ち','--- \nstatus_id: \n  :values: \n  - \"10\"\n  :operator: \"=\"\n',1,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(12,2,'#4 返金済み','--- \nstatus_id: \n  :values: \n  - \"8\"\n  :operator: \"=\"\n',1,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(13,2,'#5 -------------------------------','--- {}\n\n',1,1,'--- \n','--- []\n\n','','IssueQuery'),(14,2,'#5 保留','--- \nstatus_id: \n  :values: \n  - \"11\"\n  :operator: \"=\"\n',1,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(15,2,'#5 認証拒否','--- \nstatus_id: \n  :values: \n  - \"9\"\n  :operator: \"=\"\n',1,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(16,2,'#6 お申込みのみ - 今日','--- \nstart_date: \n  :values: \n  - \"\"\n  :operator: t\ntracker_id: \n  :values: \n  - \"5\"\n  :operator: \"=\"\n',1,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(17,2,'#6 -------------------------------','--- {}\n\n',1,1,'--- \n','--- []\n\n','','IssueQuery'),(18,2,'#9 -------------------------------','--- {}\n\n',1,1,'--- \n','--- []\n\n','','IssueQuery'),(19,2,'#2 未完了（担当者：全て）','--- \nassigned_to_id: \n  :values: \n  - \"\"\n  :operator: \"*\"\ntracker_id: \n  :values: \n  - \"4\"\n  :operator: \"=\"\nstatus_id: \n  :values: \n  - \"1\"\n  :operator: \"=\"\n',3,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(20,2,'#7 メール送信失敗','--- \ncf_16: \n  :values: \n  - !binary |\n    6YCB5L+h5aSx5pWX\n\n  :operator: \"=\"\n',3,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(21,2,'#7 -------------------------------','--- {}\n\n',3,1,'--- \n','--- []\n\n','','IssueQuery'),(22,2,'#6 お申込みのみ - 昨日','--- \nstart_date: \n  :values: \n  - \"\"\n  :operator: ld\ntracker_id: \n  :values: \n  - \"5\"\n  :operator: \"=\"\n',3,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(23,2,'#6 決済済み - 今日','--- \nstart_date: \n  :values: \n  - \"\"\n  :operator: t\ntracker_id: \n  :values: \n  - \"4\"\n  :operator: \"=\"\nstatus_id: \n  :values: \n  - \"8\"\n  - \"9\"\n  - \"10\"\n  - \"12\"\n  :operator: \"!\"\n',1,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(24,2,'#6 決済済み - 昨日','--- \nstart_date: \n  :values: \n  - \"\"\n  :operator: ld\ntracker_id: \n  :values: \n  - \"4\"\n  :operator: \"=\"\nstatus_id: \n  :values: \n  - \"8\"\n  - \"9\"\n  - \"10\"\n  :operator: \"!\"\n',1,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(25,2,'#6 お申込み＆決済済み - 今日','--- \nstart_date: \n  :values: \n  - \"\"\n  :operator: t\ntracker_id: \n  :values: \n  - \"4\"\n  - \"5\"\n  :operator: \"=\"\n',1,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery'),(26,2,'#6 お申込み＆決済済み - 昨日','--- \nstart_date: \n  :values: \n  - \"\"\n  :operator: ld\ntracker_id: \n  :values: \n  - \"4\"\n  - \"5\"\n  :operator: \"=\"\n',1,1,'--- \n','--- \n- - id\n  - desc\n','','IssueQuery');
/*!40000 ALTER TABLE `queries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repositories`
--

DROP TABLE IF EXISTS `repositories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `repositories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL DEFAULT '',
  `login` varchar(60) DEFAULT '',
  `password` varchar(255) DEFAULT '',
  `root_url` varchar(255) DEFAULT '',
  `type` varchar(255) DEFAULT NULL,
  `path_encoding` varchar(64) DEFAULT NULL,
  `log_encoding` varchar(64) DEFAULT NULL,
  `extra_info` text,
  `identifier` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_repositories_on_project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repositories`
--

LOCK TABLES `repositories` WRITE;
/*!40000 ALTER TABLE `repositories` DISABLE KEYS */;
/*!40000 ALTER TABLE `repositories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `position` int(11) DEFAULT '1',
  `assignable` tinyint(1) DEFAULT '1',
  `builtin` int(11) NOT NULL DEFAULT '0',
  `permissions` text,
  `issues_visibility` varchar(30) NOT NULL DEFAULT 'default',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Non member',1,1,1,'--- \n- :view_issues\n- :add_issues\n- :add_issue_notes\n- :save_queries\n- :view_gantt\n- :view_calendar\n- :view_time_entries\n- :comment_news\n- :view_documents\n- :view_wiki_pages\n- :view_wiki_edits\n- :add_messages\n- :view_files\n- :browse_repository\n- :view_changesets\n','default'),(2,'Anonymous',2,1,2,'--- \n- :view_issues\n- :view_gantt\n- :view_calendar\n- :view_time_entries\n- :view_documents\n- :view_wiki_pages\n- :view_wiki_edits\n- :view_files\n- :browse_repository\n- :view_changesets\n','default'),(3,'管理者',3,0,0,'--- \n- :add_project\n- :edit_project\n- :close_project\n- :select_project_modules\n- :manage_members\n- :manage_versions\n- :add_subprojects\n- :manage_boards\n- :add_messages\n- :edit_messages\n- :edit_own_messages\n- :delete_messages\n- :delete_own_messages\n- :view_calendar\n- :add_documents\n- :edit_documents\n- :delete_documents\n- :view_documents\n- :manage_files\n- :view_files\n- :view_gantt\n- :manage_categories\n- :view_issues\n- :add_issues\n- :edit_issues\n- :manage_issue_relations\n- :manage_subtasks\n- :set_issues_private\n- :set_own_issues_private\n- :add_issue_notes\n- :edit_issue_notes\n- :edit_own_issue_notes\n- :view_private_notes\n- :set_notes_private\n- :move_issues\n- :delete_issues\n- :manage_public_queries\n- :save_queries\n- :view_issue_watchers\n- :add_issue_watchers\n- :delete_issue_watchers\n- :manage_news\n- :comment_news\n- :manage_repository\n- :browse_repository\n- :view_changesets\n- :commit_access\n- :manage_related_issues\n- :log_time\n- :view_time_entries\n- :edit_time_entries\n- :edit_own_time_entries\n- :manage_project_activities\n- :manage_wiki\n- :rename_wiki_pages\n- :delete_wiki_pages\n- :view_wiki_pages\n- :export_wiki_pages\n- :view_wiki_edits\n- :edit_wiki_pages\n- :delete_wiki_pages_attachments\n- :protect_wiki_pages\n','all'),(6,'作業者',4,1,0,'--- \n- :view_calendar\n- :view_documents\n- :view_files\n- :view_gantt\n- :view_issues\n- :edit_issues\n- :add_issue_notes\n- :edit_own_issue_notes\n- :manage_public_queries\n- :save_queries\n- :browse_repository\n- :view_changesets\n- :view_wiki_pages\n- :edit_wiki_pages\n','all');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schema_migrations`
--

DROP TABLE IF EXISTS `schema_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schema_migrations` (
  `version` varchar(255) NOT NULL,
  UNIQUE KEY `unique_schema_migrations` (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schema_migrations`
--

LOCK TABLES `schema_migrations` WRITE;
/*!40000 ALTER TABLE `schema_migrations` DISABLE KEYS */;
INSERT INTO `schema_migrations` VALUES ('1'),('10'),('100'),('101'),('102'),('103'),('104'),('105'),('106'),('107'),('108'),('11'),('12'),('13'),('14'),('15'),('16'),('17'),('18'),('19'),('2'),('20'),('20090214190337'),('20090312172426'),('20090312194159'),('20090318181151'),('20090323224724'),('20090401221305'),('20090401231134'),('20090403001910'),('20090406161854'),('20090425161243'),('20090503121501'),('20090503121505'),('20090503121510'),('20090614091200'),('20090704172350'),('20090704172355'),('20090704172358'),('20091010093521'),('20091017212227'),('20091017212457'),('20091017212644'),('20091017212938'),('20091017213027'),('20091017213113'),('20091017213151'),('20091017213228'),('20091017213257'),('20091017213332'),('20091017213444'),('20091017213536'),('20091017213642'),('20091017213716'),('20091017213757'),('20091017213835'),('20091017213910'),('20091017214015'),('20091017214107'),('20091017214136'),('20091017214236'),('20091017214308'),('20091017214336'),('20091017214406'),('20091017214440'),('20091017214519'),('20091017214611'),('20091017214644'),('20091017214720'),('20091017214750'),('20091025163651'),('20091108092559'),('20091114105931'),('20091123212029'),('20091205124427'),('20091220183509'),('20091220183727'),('20091220184736'),('20091225164732'),('20091227112908'),('20100129193402'),('20100129193813'),('20100221100219'),('20100313132032'),('20100313171051'),('20100705164950'),('20100819172912'),('20101104182107'),('20101107130441'),('20101114115114'),('20101114115359'),('20110220160626'),('20110223180944'),('20110223180953'),('20110224000000'),('20110226120112'),('20110226120132'),('20110227125750'),('20110228000000'),('20110228000100'),('20110401192910'),('20110408103312'),('20110412065600'),('20110511000000'),('20110902000000'),('20111201201315'),('20120115143024'),('20120115143100'),('20120115143126'),('20120127174243'),('20120205111326'),('20120223110929'),('20120301153455'),('20120422150750'),('20120705074331'),('20120707064544'),('20120714122000'),('20120714122100'),('20120714122200'),('20120731164049'),('20120930112914'),('20121026002032'),('20121026003537'),('20121209123234'),('20121209123358'),('20121213084931'),('20130110122628'),('20130201184705'),('20130202090625'),('20130207175206'),('20130207181455'),('20130215073721'),('20130215111127'),('20130215111141'),('20130217094251'),('21'),('22'),('23'),('24'),('25'),('26'),('27'),('28'),('29'),('3'),('30'),('31'),('32'),('33'),('34'),('35'),('36'),('37'),('38'),('39'),('4'),('40'),('41'),('42'),('43'),('44'),('45'),('46'),('47'),('48'),('49'),('5'),('50'),('51'),('52'),('53'),('54'),('55'),('56'),('57'),('58'),('59'),('6'),('60'),('61'),('62'),('63'),('64'),('65'),('66'),('67'),('68'),('69'),('7'),('70'),('71'),('72'),('73'),('74'),('75'),('76'),('77'),('78'),('79'),('8'),('80'),('81'),('82'),('83'),('84'),('85'),('86'),('87'),('88'),('89'),('9'),('90'),('91'),('92'),('93'),('94'),('95'),('96'),('97'),('98'),('99');
/*!40000 ALTER TABLE `schema_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` text,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_settings_on_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'default_language','ja','2013-04-01 13:28:04'),(2,'thumbnails_enabled','0','2013-04-01 13:24:09'),(3,'gravatar_default','','2013-04-01 13:24:09'),(4,'time_format','%H:%M','2013-04-01 13:28:04'),(5,'start_of_week','1','2013-04-01 13:28:04'),(6,'ui_theme','redmine-theme-basecamp-with-icon','2013-04-26 14:04:15'),(7,'gravatar_enabled','0','2013-04-01 13:24:09'),(8,'date_format','%Y-%m-%d','2013-04-01 13:28:04'),(9,'user_format','lastname_firstname','2013-04-01 13:28:04'),(10,'thumbnails_size','100','2013-04-01 13:24:09'),(11,'welcome_text','','2013-04-01 13:27:25'),(12,'repositories_encodings','utf-8,cp932,euc-jp','2013-04-01 13:27:25'),(13,'app_title','Redmine','2013-04-22 22:48:55'),(14,'per_page_options','50,100,200','2013-04-01 13:27:25'),(15,'file_max_size_displayed','512','2013-04-01 13:27:25'),(16,'attachment_max_size','5120','2013-04-01 13:27:25'),(17,'wiki_compression','','2013-04-01 13:27:25'),(18,'protocol','https','2013-04-01 13:27:25'),(19,'diff_max_lines_displayed','1500','2013-04-01 13:27:25'),(20,'host_name','133.242.135.174/redmines/esta_onlinecenter','2013-04-22 22:46:38'),(21,'activity_days_default','30','2013-04-01 13:27:25'),(22,'text_formatting','textile','2013-04-01 13:27:25'),(23,'feeds_limit','15','2013-04-01 13:27:25'),(24,'cache_formatted_text','0','2013-04-01 13:27:25'),(25,'self_registration','2','2013-04-01 13:29:07'),(26,'session_lifetime','0','2013-04-01 13:29:07'),(27,'lost_password','0','2013-04-01 13:29:07'),(28,'jsonp_enabled','0','2013-04-01 13:29:07'),(29,'session_timeout','0','2013-04-01 13:29:07'),(30,'login_required','1','2013-04-01 13:29:07'),(31,'unsubscribe','0','2013-04-01 13:29:07'),(32,'rest_api_enabled','1','2013-04-01 13:29:07'),(33,'openid','0','2013-04-01 13:29:07'),(34,'password_min_length','8','2013-04-01 13:29:07'),(35,'autologin','0','2013-04-01 13:29:07'),(36,'default_issue_start_date_to_creation_date','1','2013-04-01 13:30:42'),(37,'gantt_items_limit','500','2013-04-01 13:30:42'),(38,'issues_export_limit','500','2013-04-01 13:30:42'),(39,'issue_group_assignment','0','2013-04-01 13:30:42'),(40,'issue_list_default_columns','--- \n- tracker\n- status\n- start_date\n- assigned_to\n- subject\n- cf_4\n- cf_16\n','2013-04-26 14:46:07'),(41,'issue_done_ratio','issue_status','2013-04-01 13:30:42'),(42,'cross_project_subtasks','tree','2013-04-01 13:30:42'),(43,'non_working_week_days','--- []\n\n','2013-04-01 13:30:42'),(44,'display_subprojects_issues','0','2013-04-01 13:30:42'),(45,'cross_project_issue_relations','0','2013-04-01 13:30:42');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time_entries`
--

DROP TABLE IF EXISTS `time_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `time_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `issue_id` int(11) DEFAULT NULL,
  `hours` float NOT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `activity_id` int(11) NOT NULL,
  `spent_on` date NOT NULL,
  `tyear` int(11) NOT NULL,
  `tmonth` int(11) NOT NULL,
  `tweek` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `time_entries_project_id` (`project_id`),
  KEY `time_entries_issue_id` (`issue_id`),
  KEY `index_time_entries_on_activity_id` (`activity_id`),
  KEY `index_time_entries_on_user_id` (`user_id`),
  KEY `index_time_entries_on_created_on` (`created_on`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_entries`
--

LOCK TABLES `time_entries` WRITE;
/*!40000 ALTER TABLE `time_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `time_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `action` varchar(30) NOT NULL DEFAULT '',
  `value` varchar(40) NOT NULL DEFAULT '',
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tokens_value` (`value`),
  KEY `index_tokens_on_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tokens`
--

LOCK TABLES `tokens` WRITE;
/*!40000 ALTER TABLE `tokens` DISABLE KEYS */;
INSERT INTO `tokens` VALUES (1,1,'feeds','f80b89da2028d81e2e8935e22289b8ccf30f748e','2013-03-31 18:07:54'),(2,1,'api','5378f40c6b498a4e0f642fd37ec81a7b373bea2f','2013-04-01 14:30:03'),(3,3,'feeds','9eadf311a0f05fc7da166353c25addba4b03f9c6','2013-04-01 15:03:56'),(4,5,'feeds','0f18c76deb4003d4cbce8aef6af93c645dcdd149','2013-04-23 17:51:50'),(5,4,'feeds','275e574ed4d044a86a5afb79acac50f2ebe4b68a','2013-04-23 17:52:09'),(6,6,'feeds','743b2cebb5253e20feec09ae2974eb28ab151f79','2013-04-23 18:06:04'),(7,7,'feeds','65e0c27d5989db4bc2bfc3e87f732836dacd1f7b','2013-04-27 13:11:50');
/*!40000 ALTER TABLE `tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trackers`
--

DROP TABLE IF EXISTS `trackers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trackers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `is_in_chlog` tinyint(1) NOT NULL DEFAULT '0',
  `position` int(11) DEFAULT '1',
  `is_in_roadmap` tinyint(1) NOT NULL DEFAULT '1',
  `fields_bits` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trackers`
--

LOCK TABLES `trackers` WRITE;
/*!40000 ALTER TABLE `trackers` DISABLE KEYS */;
INSERT INTO `trackers` VALUES (4,'決済完了',0,1,1,110),(5,'申請のみ',0,2,1,110);
/*!40000 ALTER TABLE `trackers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_preferences`
--

DROP TABLE IF EXISTS `user_preferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_preferences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `others` text,
  `hide_mail` tinyint(1) DEFAULT '0',
  `time_zone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_user_preferences_on_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_preferences`
--

LOCK TABLES `user_preferences` WRITE;
/*!40000 ALTER TABLE `user_preferences` DISABLE KEYS */;
INSERT INTO `user_preferences` VALUES (1,1,'--- \n:comments_sorting: asc\n:warn_on_leaving_unsaved: \"1\"\n:gantt_zoom: 2\n:no_self_notified: false\n:gantt_months: 6\n',1,'Tokyo'),(2,3,'--- \n:no_self_notified: false\n:my_page_layout: \n  right: []\n\n  top: \n  - issuesassignedtome\n  - issuesreportedbyme\n  left: []\n\n:comments_sorting: asc\n:warn_on_leaving_unsaved: \"1\"\n',1,'Tokyo'),(3,4,'--- \n:no_self_notified: false\n:comments_sorting: asc\n:warn_on_leaving_unsaved: \"1\"\n',1,'Tokyo'),(4,5,'--- \n:no_self_notified: false\n:comments_sorting: asc\n:warn_on_leaving_unsaved: \"1\"\n',1,'Tokyo'),(5,6,'--- \n:no_self_notified: false\n:comments_sorting: asc\n:warn_on_leaving_unsaved: \"1\"\n',1,'Tokyo'),(6,7,'--- \n:no_self_notified: false\n:my_page_layout: \n  right: []\n\n  top: \n  - issuesassignedtome\n  left: []\n\n:comments_sorting: asc\n:warn_on_leaving_unsaved: \"1\"\n',1,'Tokyo');
/*!40000 ALTER TABLE `user_preferences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL DEFAULT '',
  `hashed_password` varchar(40) NOT NULL DEFAULT '',
  `firstname` varchar(30) NOT NULL DEFAULT '',
  `lastname` varchar(255) NOT NULL DEFAULT '',
  `mail` varchar(60) NOT NULL DEFAULT '',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `last_login_on` datetime DEFAULT NULL,
  `language` varchar(5) DEFAULT '',
  `auth_source_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `identity_url` varchar(255) DEFAULT NULL,
  `mail_notification` varchar(255) NOT NULL DEFAULT '',
  `salt` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_users_on_id_and_type` (`id`,`type`),
  KEY `index_users_on_auth_source_id` (`auth_source_id`),
  KEY `index_users_on_type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','4d3135afb6c32d99629ccd319b671deea87f0517','Redmine','Admin','duck_hunter_camouflage@ezweb.ne.jp',1,1,'2013-05-17 14:10:40','ja',NULL,'2013-03-31 17:09:52','2013-05-03 14:05:35','User',NULL,'none','e1f910fb375d6a6a6a400747413fd4ae'),(2,'','','','Anonymous','',0,0,NULL,'',NULL,'2013-03-31 17:56:43','2013-03-31 17:56:43','AnonymousUser',NULL,'only_my_events',NULL),(3,'wiz_ogawa','aff705314b83177411d339518412d41e7ac57048','拓也','小川','ogawa@wiz-g.co.jp',0,1,'2013-05-16 18:37:52','ja',NULL,'2013-04-01 13:16:54','2013-04-01 13:16:54','User',NULL,'none','f1b744c85d3efabeece232a248472e53'),(4,'wiz_kishi','4a44cca5a373f8fa786b99e3b0e7dc37419361af','正浩','岸','kishi@wiz-g.co.jp',0,1,'2013-04-23 17:52:08','ja',NULL,'2013-04-01 13:18:20','2013-04-23 17:51:30','User',NULL,'none','c3fdbc5b918b8209f48fd0854055c234'),(5,'wiz_kakuda','7aa8232fb1022d4fa2fe9b2873df10cacdb7c73b','篤史','角田','kakuda@wiz-g.co.jp',0,1,'2013-04-23 20:58:11','ja',NULL,'2013-04-23 17:50:44','2013-04-23 17:50:44','User',NULL,'none','b275c9674bb7971e93d843d92e2ae865'),(6,'wiz_uetake','d05887521144dc0c8b1b4c6cd862c8309bc74e11','拓','植竹','uetake@wiz-g.co.jp',0,1,'2013-05-17 11:59:04','ja',NULL,'2013-04-23 18:05:40','2013-04-23 18:05:40','User',NULL,'none','873b34654d6cd147628ae90da7e4fac9'),(7,'wiz_saito','f52d3acb641e0dcb85178ebe362c8d70f2445a09','慧','齋藤','wiz_saito@yahoo.co.jp',0,1,'2013-05-17 11:10:13','ja',NULL,'2013-04-27 13:10:39','2013-04-27 13:10:39','User',NULL,'none','db6722848468116ad4bb5fda9dfe0f05');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `versions`
--

DROP TABLE IF EXISTS `versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT '',
  `effective_date` date DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `wiki_page_title` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'open',
  `sharing` varchar(255) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`id`),
  KEY `versions_project_id` (`project_id`),
  KEY `index_versions_on_sharing` (`sharing`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `versions`
--

LOCK TABLES `versions` WRITE;
/*!40000 ALTER TABLE `versions` DISABLE KEYS */;
/*!40000 ALTER TABLE `versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `watchers`
--

DROP TABLE IF EXISTS `watchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `watchers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `watchable_type` varchar(255) NOT NULL DEFAULT '',
  `watchable_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `watchers_user_id_type` (`user_id`,`watchable_type`),
  KEY `index_watchers_on_user_id` (`user_id`),
  KEY `index_watchers_on_watchable_id_and_watchable_type` (`watchable_id`,`watchable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `watchers`
--

LOCK TABLES `watchers` WRITE;
/*!40000 ALTER TABLE `watchers` DISABLE KEYS */;
/*!40000 ALTER TABLE `watchers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wiki_content_versions`
--

DROP TABLE IF EXISTS `wiki_content_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wiki_content_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wiki_content_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `data` longblob,
  `compression` varchar(6) DEFAULT '',
  `comments` varchar(255) DEFAULT '',
  `updated_on` datetime NOT NULL,
  `version` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `wiki_content_versions_wcid` (`wiki_content_id`),
  KEY `index_wiki_content_versions_on_updated_on` (`updated_on`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wiki_content_versions`
--

LOCK TABLES `wiki_content_versions` WRITE;
/*!40000 ALTER TABLE `wiki_content_versions` DISABLE KEYS */;
INSERT INTO `wiki_content_versions` VALUES (1,1,1,3,'h1. esta international\r\n\r\nh3. 一般\r\n* [[業務内容]]\r\n\r\nh3. 技術\r\n* 環境構築\r\n** [[Redmine]]\r\n** [[Apache]]','','','2013-04-01 17:53:37',1),(2,2,2,3,'h1. 業務内容\r\n\r\n* 申請作業\r\n** お客さまメールの振り分け\r\n** 申し込み内容の確認\r\n** 代理申請手続き\r\n** 申請結果書類作成\r\n** お客様のもとへメールにて申請結果の送信\r\n\r\n* 電話/メール応対\r\n** お客様からのお問い合わせ応対\r\n** メール送信不可能なお客様への案内\r\n** クレーム対応\r\n\r\n* 広告関連\r\n** 広告費の入金作業\r\n** 広告管理ツール内の設定\r\n　（キャンペーン作成・広告グループ作成・広告ワード作成・入札金額の設定・キーワード設定）\r\n** 日別広告費・掲載順位の推移調査\r\n\r\n* Paypal関連\r\n** 返金作業\r\n** 銀行への送金\r\n** その他問い合わせ業務\r\n\r\n* ウェブサイト関連\r\n** システム構築\r\n** 管理画面システム作成\r\n\r\n* その他\r\n** 売上げ管理表の作成','','','2013-04-01 17:55:00',1),(3,3,3,3,'h1. Redmine\r\n\r\n\r\n* 基本設定\r\n<pre>\r\n下記URLを参考にインストールしてください。\r\n</pre>\r\n** http://redmine.jp/guide/RedmineInstall/\r\n** http://blog.redmine.jp/articles/2_3/installation_centos/\r\n\r\n\r\n* apache設定\r\n<pre>\r\n/etc/httpd/conf/httpd.conf に下記設定を追加する（※内容は環境に応じて変更する事）\r\n\r\n# for redmine\r\nLoadModule passenger_module /usr/lib64/ruby/gems/1.8/gems/passenger-3.0.19/ext/apache2/mod_passenger.so\r\nPassengerRoot /usr/lib64/ruby/gems/1.8/gems/passenger-3.0.19\r\nPassengerRuby /usr/bin/ruby\r\nRackBaseURI /redmines/esta_international # redmineを追加した場合は当該設定も追加\r\nRackBaseURI /redmines/redmine\r\n</pre>\r\n\r\n\r\n* .htaccess, document root の調整\r\n\r\n\r\n* 許可するHTMLタグを追加\r\n<pre>\r\n下記URLを参考にaタグを許可してください。\r\n</pre>\r\n** http://redmine.jp/faq/wiki/use-html-tag-in-wiki/','','','2013-04-01 17:55:45',1),(4,4,4,3,'h1. Apache\r\n\r\n\r\n* 設定\r\n<pre>\r\n/etc/httpd/conf/httpd.conf\r\n\r\n# ユーザを変更\r\nUser wiz\r\nGroup wiz\r\n\r\n# ファイル一覧表示をOFF\r\nOptions -Indexes FollowSymLinks\r\n</pre>','','','2013-04-01 17:56:17',1),(5,3,3,3,'h1. Redmine\r\n\r\n\r\n* 基本設定\r\n<pre>\r\n基本的には下記URL等を参考にインストールします。\r\n</pre>\r\n** http://redmine.jp/guide/RedmineInstall/\r\n** http://blog.redmine.jp/articles/2_3/installation_centos/\r\n\r\n* Rubyインストール\r\n<pre>\r\n# 1.8.7 をインストールする\r\n\r\ncd /usr/local/src/\r\nsudo wget ftp://ftp.ruby-lang.org/pub/ruby/1.8/ruby-1.8.7-p174.tar.gz\r\nsudo  tar xvzf ruby-1.8.7-p174.tar.gz\r\ncd ruby-1.8.7-p174\r\nsudo ./configure\r\nsudo make\r\nsudo make install\r\nruby --version\r\n</pre>\r\n\r\n* rubygemインストール\r\n<pre>\r\n# 1.8.24 をインストールする\r\ncd /usr/local/src/\r\nsudo wget http://rubyforge.org/frs/download.php/76073/rubygems-1.8.24.tgz\r\nsudo tar zxvf rubygems-1.8.24.tgz \r\ncd rubygems-1.8.24\r\nsudo ruby setup.rb config　\r\nsudo ruby setup.rb setup\r\nsudo ruby setup.rb install\r\ngem -v\r\n</pre>\r\n\r\n* railsインストール\r\n<pre>\r\ncd redmine-2.3.0/ # rails project dir\r\nsudo bundle install --without development test postgresql sqlite\r\nsudo gem install passenger --no-rdoc --no-ri\r\nsudo passenger-install-apache2-module\r\n</pre>\r\n\r\n* apache設定\r\n<pre>\r\nsudo vim /etc/httpd/conf.d/passenger.conf\r\n# passenger-install-apache2-module --snippet # この出力内容を追記\r\n\r\n# for redmine\r\nLoadModule passenger_module /usr/lib64/ruby/gems/1.8/gems/passenger-3.0.19/ext/apache2/mod_passenger.so\r\nPassengerRoot /usr/lib64/ruby/gems/1.8/gems/passenger-3.0.19\r\nPassengerRuby /usr/bin/ruby\r\nRackBaseURI /redmines/esta_international # redmineを追加した場合は当該設定も追加\r\nRackBaseURI /redmines/redmine\r\n\r\nsudo /etc/init.d/httpd restart\r\n</pre>\r\n\r\n\r\n* .htaccess, document root の調整\r\n\r\n\r\n* 許可するHTMLタグを追加\r\n<pre>\r\n下記URLを参考にaタグを許可してください。\r\n</pre>\r\n** http://redmine.jp/faq/wiki/use-html-tag-in-wiki/','','','2013-04-04 16:44:20',2),(6,1,1,3,'h1. esta international\r\n\r\nh3. 一般\r\n* [[業務内容]]\r\n\r\nh3. 技術\r\n* 環境構築\r\n** [[TimeZone]]\r\n** [[Redmine]]\r\n** [[Apache]]\r\n** [[PHP]]','','','2013-04-04 17:01:06',2),(7,5,5,3,'h1. TimeZone\r\n\r\n* TimeZoneの設定\r\n<pre>\r\nsudo rm /etc/localtime\r\nsudo ls -s  /usr/share/zoneinfo/Asia/Tokyo /etc/localtime\r\n</pre>','','','2013-04-04 17:01:43',1),(8,6,6,3,'h1. PHP\r\n\r\n* 設定\r\n\r\n<pre>\r\nsudo vim /etc/php.ini\r\n\r\nshort_open_tag = Off\r\n</pre>','','','2013-04-04 17:03:03',1),(9,1,1,3,'h1. esta international\r\n\r\nh3. 一般\r\n* [[業務内容]]\r\n\r\nh3. 技術\r\n* 環境構築\r\n** [[TimeZone]]\r\n** [[Redmine]]\r\n** [[Apache]]\r\n** [[PHP]]\r\n** [[Https]]','','','2013-04-04 17:03:34',3),(10,4,4,3,'h1. Apache\r\n\r\n\r\n* 設定\r\n<pre>\r\n/etc/httpd/conf/httpd.conf\r\n\r\n# ユーザを変更\r\nUser wiz\r\nGroup wiz\r\n\r\n# ファイル一覧表示をOFF\r\nOptions -Indexes FollowSymLinks\r\n\r\n# .htaccess の許可\r\nAllowOverride All\r\n</pre>','','','2013-04-04 17:06:56',2),(11,6,6,3,'h1. PHP\r\n\r\n* 基本設定\r\n<pre>\r\nsudo vim /etc/php.ini\r\n\r\nshort_open_tag = Off\r\n</pre>\r\n\r\n* GeoIPインストール\r\n** http://blog.araishi.com/geoip-php-install/','','','2013-04-04 18:01:28',2),(12,6,6,3,'h1. PHP\r\n\r\n* 基本設定\r\n<pre>\r\nsudo vim /etc/php.ini\r\n\r\nshort_open_tag = Off\r\n</pre>\r\n\r\n* Peclインストール\r\n<pre>\r\nsudo yum install php-devel\r\nsudo yum install php-pear\r\n</pre>\r\n\r\n* GeoIPインストール\r\n** http://blog.araishi.com/geoip-php-install/\r\n\r\n* Jsonインストール\r\n<pre>\r\nsudo  pecl install json\r\nsudo vim /etc/php.d/json.ini\r\n</pre>','','','2013-04-04 18:52:13',3),(13,1,1,3,'h1. esta international\r\n\r\nh3. 一般\r\n* [[業務内容]]\r\n* [[業務運用マニュアル]]\r\n\r\nh3. 技術\r\n* 環境構築\r\n** [[TimeZone]]\r\n** [[Redmine]]\r\n** [[Apache]]\r\n** [[PHP]]\r\n** [[Https]]','','','2013-04-26 16:17:32',4),(14,7,7,3,'h1. 業務運用マニュアル\r\n\r\n* 準備\r\n自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n\r\n* 担当者の変更\r\n- チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する\r\n- 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。\r\n\r\n* 基本設定\r\n<pre>\r\n基本的には下記URL等を参考にインストールします。\r\n</pre>\r\n** http://redmine.jp/guide/RedmineInstall/\r\n** http://blog.redmine.jp/articles/2_3/installation_centos/\r\n\r\n* Rubyインストール\r\n<pre>\r\n# 1.8.7 をインストールする','','','2013-04-26 16:27:11',1),(15,7,7,3,'h1. 業務運用マニュアル\r\n\r\n* 準備\r\n自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n\r\n* 担当者の変更\r\n- チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する\r\n- 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。\r\n!https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/1/apply_select.png!\r\n\r\n* 基本設定\r\n<pre>\r\n基本的には下記URL等を参考にインストールします。\r\n</pre>\r\n** http://redmine.jp/guide/RedmineInstall/\r\n** http://blog.redmine.jp/articles/2_3/installation_centos/\r\n\r\n* Rubyインストール\r\n<pre>\r\n# 1.8.7 をインストールする','','','2013-04-26 16:30:42',2),(16,7,7,3,'h1. 業務運用マニュアル\r\n\r\n* 準備\r\n自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n\r\n* 担当者の変更\r\n# チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する\r\n# 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。\r\n!https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/1/apply_select.png!\r\n','','','2013-04-26 16:31:43',3),(17,7,7,1,'h1. 業務運用マニュアル\r\n\r\n* 準備\r\n自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n\r\n* 担当者の変更\r\n# チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する\r\n# 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。\r\n!https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/2/apply_select.png!\r\n','','','2013-04-26 16:40:24',4),(18,7,7,1,'h1. 業務運用マニュアル\r\n\r\n* 準備\r\n自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n\r\n* 担当者の変更\r\n# チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する\r\n# 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。\r\n!https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/3/apply_select.png!\r\n','','','2013-04-26 16:44:29',5),(19,7,7,1,'h1. 業務運用マニュアル\r\n\r\n* 準備\r\n自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n\r\n* 担当者の変更\r\n# チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する。\r\n# 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。（複数同時可能）\r\n!https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/3/apply_select.png!\r\n\r\n* 自分担当のチケットを確認\r\n# 方法(1) マイページにて確認　画面左上部の「マイページ」を押下してマイページに移動。担当チケットを確認する。\r\n# 方法(2) チケット一覧のカスタムクエリより「未完了（担当者：自分）」を選択する。','','','2013-04-26 16:47:29',6),(20,7,7,1,'h1. 業務運用マニュアル\r\n\r\n* 準備\r\n自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n\r\n* 担当者の変更\r\n# チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する。\r\n# 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。（複数同時可能）\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/3/apply_select.png\r\n\r\n\r\n* 自分担当のチケットを確認\r\n# 方法(1) マイページにて確認　画面左上部の「マイページ」を押下してマイページに移動。担当チケットを確認する。\r\n# 方法(2) チケット一覧のカスタムクエリより「未完了（担当者：自分）」を選択する。','','','2013-04-26 16:49:58',7),(21,7,7,1,'h1. 業務運用マニュアル\r\n\r\n* 準備\r\n自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n\r\n* 担当者の変更\r\n# チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する。\r\n# 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。（複数同時可能）\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/4/apply_select.png\r\n\r\n\r\n* 自分担当のチケットを確認\r\n# 方法(1) マイページにて確認　画面左上部の「マイページ」を押下してマイページに移動。担当チケットを確認する。\r\n# 方法(2) チケット一覧のカスタムクエリより「未完了（担当者：自分）」を選択する。','','','2013-04-26 16:51:30',8),(22,7,7,1,'h1. 業務運用マニュアル\r\n\r\n* 準備\r\n# 自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n\r\n* 担当者の変更\r\n# チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する。\r\n# 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。（複数同時可能）\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/4/apply_select.png\r\n\r\n\r\n* 自分担当のチケットを確認\r\n# 方法(1) マイページにて確認　画面左上部の「マイページ」を押下してマイページに移動。担当チケットを確認する。\r\n# 方法(2) チケット一覧のカスタムクエリより「未完了（担当者：自分）」を選択する。\r\n\r\n* aaaa','','','2013-04-26 16:53:13',9),(23,7,7,1,'h1. 業務運用マニュアル\r\n\r\n<pre>\r\n自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n</pre>\r\n\r\n*申請の基本的な流れ*\r\n\r\n* 担当者の変更\r\n# チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する。\r\n# 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。（複数同時可能）\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/4/apply_select.png\r\n\r\n\r\n* 自分担当のチケットを確認\r\n# 方法(1) マイページにて確認　画面左上部の「マイページ」を押下してマイページに移動。担当チケットを確認する。\r\n# 方法(2) チケット一覧のカスタムクエリより「未完了（担当者：自分）」を選択する。\r\n\r\n* 申請処理\r\n# 申請対象チケットの詳細ページを開く（ブラウザA）\r\n# もう一つ別のブラウザを用意して（ブラウザB）、米国大使館ESTA申請サイトを表示し、申請内容入力ページまで進む\r\n# （A）チケット詳細ページにあるリンクを、（B）のブックマークにドラッグして登録する\r\n# （B）にてブックマークレットを使用して申請処理を進める。\r\n\r\n* 認証結果の登録\r\n** 問題なく認証許可された場合\r\n*** aaa\r\n** 認証拒否となった場合\r\n*** aaa\r\n\r\n*返金処理の流れ*','','','2013-04-26 17:03:50',10),(24,7,7,1,'h1. 業務運用マニュアル\r\n\r\n<pre>\r\n自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n</pre>\r\n\r\n*申請の基本的な流れ*\r\n\r\n* 担当者の変更\r\n# チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する。\r\n# 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。（複数同時可能）\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/4/apply_select.png\r\n\r\n\r\n* 自分担当のチケットを確認\r\n# 方法(1) マイページにて確認　画面左上部の「マイページ」を押下してマイページに移動。担当チケットを確認する。\r\n# 方法(2) チケット一覧のカスタムクエリより「未完了（担当者：自分）」を選択する。\r\n\r\n* 申請処理\r\n# 申請対象チケットの詳細ページを開く（ブラウザA）\r\n# もう一つ別のブラウザを用意して（ブラウザB）、米国大使館ESTA申請サイトを表示し、申請内容入力ページまで進む\r\n# （A）チケット詳細ページにあるリンクを、（B）のブックマークにドラッグして登録する\r\n# （B）にてブックマークレットを使用して申請処理を進める。\r\n\r\n* 認証結果の登録\r\n** 問題なく認証許可された場合\r\n*** チケット詳細ページ右上より「更新」を押下。\r\n** 認証拒否となった場合\r\n*** aaa\r\n\r\n*返金処理の流れ*','','','2013-04-26 17:27:13',11),(25,7,7,1,'h1. 業務運用マニュアル\r\n\r\n<pre>\r\n自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n</pre>\r\n\r\n*申請の基本的な流れ*\r\n\r\n* 担当者の変更\r\n# チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する。\r\n# 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。（複数同時可能）\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/4/apply_select.png\r\n\r\n\r\n* 自分担当のチケットを確認\r\n# 方法(1) マイページにて確認　画面左上部の「マイページ」を押下してマイページに移動。担当チケットを確認する。\r\n# 方法(2) チケット一覧のカスタムクエリより「未完了（担当者：自分）」を選択する。\r\n\r\n* 申請処理\r\n# 申請対象チケットの詳細ページを開く（ブラウザA）\r\n# もう一つ別のブラウザを用意して（ブラウザB）、米国大使館ESTA申請サイトを表示し、申請内容入力ページまで進む\r\n# （A）チケット詳細ページにあるリンクを、（B）のブックマークにドラッグして登録する\r\n# （B）にてブックマークレットを使用して申請処理を進める。\r\n\r\n* 認証結果の登録\r\n** 問題なく認証許可された場合\r\n*** チケット詳細ページ右上より「更新」を押下。\r\n*** ステータス「手続き完了」を選択し、渡航申請番号と有効期限を転記する。\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter\r\n** 認証拒否となった場合\r\n*** チケット詳細ページ右上より「更新」を押下。\r\n*** ステータス「認証拒否」を選択し、渡航申請番号を転記する。\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter\r\n\r\n*返金処理の流れ*','','','2013-04-26 17:39:47',12),(26,7,7,1,'h1. 業務運用マニュアル\r\n\r\n<pre>\r\n自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n</pre>\r\n\r\n*申請の基本的な流れ*\r\n\r\n* 担当者の変更\r\n# チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する。\r\n# 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。（複数同時可能）\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/4/apply_select.png\r\n\r\n\r\n* 自分担当のチケットを確認\r\n# 方法(1) マイページにて確認　画面左上部の「マイページ」を押下してマイページに移動。担当チケットを確認する。\r\n# 方法(2) チケット一覧のカスタムクエリより「未完了（担当者：自分）」を選択する。\r\n\r\n* 申請処理\r\n# 申請対象チケットの詳細ページを開く（ブラウザA）\r\n# もう一つ別のブラウザを用意して（ブラウザB）、米国大使館ESTA申請サイトを表示し、申請内容入力ページまで進む\r\n# （A）チケット詳細ページにあるリンクを、（B）のブックマークにドラッグして登録する\r\n# （B）にてブックマークレットを使用して申請処理を進める。\r\n\r\n* 認証結果の登録\r\n** 問題なく認証許可された場合\r\n*** チケット詳細ページ右上より「更新」を押下。\r\n*** ステータス「手続き完了」を選択し、渡航申請番号と有効期限を転記する。\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter\r\n** 認証拒否となった場合\r\n*** チケット詳細ページ右上より「更新」を押下。\r\n*** ステータス「認証拒否」を選択し、渡航申請番号を転記する。\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/6/apply_reject.png\r\n\r\n*返金処理の流れ*','','','2013-04-26 17:40:38',13),(27,7,7,1,'h1. 業務運用マニュアル\r\n\r\n<pre>\r\n自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n</pre>\r\n\r\n*申請の基本的な流れ*\r\n\r\n* 担当者の変更\r\n# チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する。\r\n# 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。（複数同時可能）\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/4/apply_select.png\r\n\r\n\r\n* 自分担当のチケットを確認\r\n# 方法(1) マイページにて確認　画面左上部の「マイページ」を押下してマイページに移動。担当チケットを確認する。\r\n# 方法(2) チケット一覧のカスタムクエリより「未完了（担当者：自分）」を選択する。\r\n\r\n* 申請処理\r\n# 申請対象チケットの詳細ページを開く（ブラウザA）\r\n# もう一つ別のブラウザを用意して（ブラウザB）、米国大使館ESTA申請サイトを表示し、申請内容入力ページまで進む\r\n# （A）チケット詳細ページにあるリンクを、（B）のブックマークにドラッグして登録する\r\n# （B）にてブックマークレットを使用して申請処理を進める。\r\n\r\n* 認証結果の登録\r\n** 問題なく認証許可された場合\r\n*** チケット詳細ページ右上より「更新」を押下。\r\n*** ステータス「手続き完了」を選択し、渡航申請番号と有効期限を転記する。\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/5/apply_done.png\r\n** 認証拒否となった場合\r\n*** チケット詳細ページ右上より「更新」を押下。\r\n*** ステータス「認証拒否」を選択し、渡航申請番号を転記する。\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/6/apply_reject.png\r\n\r\n*返金処理の流れ*','','','2013-04-26 17:40:53',14),(28,7,7,1,'h1. 業務運用マニュアル\r\n\r\n<pre>\r\n自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n</pre>\r\n\r\n*申請の基本的な流れ*\r\n\r\n* 担当者の変更\r\n# チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する。\r\n# 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。（複数同時可能）\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/4/apply_select.png\r\n\r\n\r\n* 自分担当のチケットを確認\r\n# 方法(1) マイページにて確認　画面左上部の「マイページ」を押下してマイページに移動。担当チケットを確認する。\r\n# 方法(2) チケット一覧のカスタムクエリより「未完了（担当者：自分）」を選択する。\r\n\r\n* 申請処理\r\n# 申請対象チケットの詳細ページを開く（ブラウザA）\r\n# もう一つ別のブラウザを用意して（ブラウザB）、米国大使館ESTA申請サイトを表示し、申請内容入力ページまで進む\r\n# （A）チケット詳細ページにあるリンクを、（B）のブックマークにドラッグして登録する\r\n# （B）にてブックマークレットを使用して申請処理を進める。\r\n\r\n* 認証結果の登録\r\n** 問題なく認証許可された場合\r\n*** チケット詳細ページ右上より「更新」を押下。\r\n*** ステータス「手続き完了」を選択し、渡航申請番号と有効期限を転記する。\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/5/apply_done.png\r\n** 認証拒否となった場合\r\n*** チケット詳細ページ右上より「更新」を押下。\r\n*** ステータス「認証拒否」を選択し、渡航申請番号を転記する。\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/6/apply_reject.png\r\n\r\n*返金処理の流れ*\r\n\r\n* 返金希望のお問合せメールを受信した場合、当該チケットのステータスを確認する。\r\n** 「手続き完了」「認証拒否」の場合\r\n*** 原則として、ご返金できない旨をメールにて返信する\r\n*** 管理ツール（Redmine）上でのオペレーションは特にありません。\r\n** 「新規」「保留」の場合\r\n*** 決済手数料300円をご負担頂き、残りをご返金する旨をメールにて返信する。\r\n*** チケット詳細を更新、ステータスを「返金処理待ち」に変更、返金金額に\"300\"を入力する\r\n*** *返金処理担当者のみ* 返金処理担当者は、当該チケットを確認後にpaypal管理画面にて返金処理を行う。\r\n*** *返金処理担当者のみ* 返金処理完了後に返金済みのメールを送信し、チケット詳細を更新、ステータスを「キャンセル完了」に変更する。\r\n\r\n\r\n原則であり例外はある','','','2013-04-26 17:55:01',15),(29,7,7,1,'h1. 業務運用マニュアル\r\n\r\n<pre>\r\n自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n</pre>\r\n\r\n*申請の基本的な流れ*\r\n\r\n* 担当者の変更\r\n# チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する。\r\n# 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。（複数同時可能）\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/4/apply_select.png\r\n\r\n* 自分担当のチケットを確認\r\n# 方法(1) マイページにて確認　画面左上部の「マイページ」を押下してマイページに移動。担当チケットを確認する。\r\n# 方法(2) チケット一覧のカスタムクエリより「未完了（担当者：自分）」を選択する。\r\n\r\n* 申請処理\r\n# 申請対象チケットの詳細ページを開く（ブラウザA）\r\n# もう一つ別のブラウザを用意して（ブラウザB）、米国大使館ESTA申請サイトを表示し、申請内容入力ページまで進む\r\n# （A）チケット詳細ページにあるリンクを、（B）のブックマークにドラッグして登録する\r\n# （B）にてブックマークレットを使用して申請処理を進める。\r\n# 認証済みの申請が見つかった場合\r\n## 申請処理を一時キャンセルし、（A）にてステータスを「保留」に更新する。\r\n## （B）にて検索を行い、有効期限を確認する。\r\n## 残りの期間が概ね6か月～1年以上の場合は、メールにて当該内容を連絡する。\r\n## 残り期間が僅かである場合は、改めて通常通りの申請処理を行う。\r\n\r\n* 認証結果の登録\r\n** 問題なく認証許可された場合\r\n*** チケット詳細ページ右上より「更新」を押下。\r\n*** ステータス「手続き完了」を選択し、渡航申請番号と有効期限を転記する。\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/5/apply_done.png\r\n** 認証拒否となった場合\r\n*** チケット詳細ページ右上より「更新」を押下。\r\n*** ステータス「認証拒否」を選択し、渡航申請番号を転記する。\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/6/apply_reject.png\r\n\r\n*返金処理の流れ*\r\n\r\n* 返金希望のお問合せメールを受信した場合、当該チケットのステータスを確認する。\r\n** 「手続き完了」「認証拒否」の場合\r\n*** 原則として、ご返金できない旨をメールにて返信する\r\n*** 管理ツール（Redmine）上でのオペレーションは特にありません。\r\n** 「新規」「保留」の場合\r\n*** 決済手数料300円をご負担頂き、残りをご返金する旨をメールにて返信する。\r\n*** チケット詳細を更新、ステータスを「返金処理待ち」に変更、返金金額に\"300\"を入力する\r\n*** *返金処理担当者のみ* 返金処理担当者は、当該チケットを確認後にpaypal管理画面にて返金処理を行う。\r\n*** *返金処理担当者のみ* 返金処理完了後に返金済みのメールを送信し、チケット詳細を更新、ステータスを「キャンセル完了」に変更する。\r\n\r\n<pre>\r\n当該ルールは原則であり、状況に応じて対応してください。\r\n</pre>\r\n\r\n\r\n\r\n\r\n','','','2013-04-26 18:04:18',16),(30,1,1,1,'h1. esta international\r\n\r\nh3. 一般\r\n* [[業務内容]]\r\n* [[業務運用マニュアル]]\r\n\r\nh3. 技術\r\n* 環境構築\r\n** [[git]]\r\n** [[TimeZone]]\r\n** [[Redmine]]\r\n** [[Apache]]\r\n** [[PHP]]\r\n** [[Https]]','','','2013-04-30 18:32:11',5),(31,8,8,1,'h1. Git\r\n\r\n* リポジトリを追加する\r\n<pre>\r\nwget http://packages.sw.be/rpmforge-release/rpmforge-release-0.5.2-2.el5.rf.i386.rpm\r\n</pre>\r\n\r\n* git をインストールする\r\n<pre>\r\nyum install git\r\n</pre>','','','2013-04-30 18:33:11',1);
/*!40000 ALTER TABLE `wiki_content_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wiki_contents`
--

DROP TABLE IF EXISTS `wiki_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wiki_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `text` longtext,
  `comments` varchar(255) DEFAULT '',
  `updated_on` datetime NOT NULL,
  `version` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `wiki_contents_page_id` (`page_id`),
  KEY `index_wiki_contents_on_author_id` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wiki_contents`
--

LOCK TABLES `wiki_contents` WRITE;
/*!40000 ALTER TABLE `wiki_contents` DISABLE KEYS */;
INSERT INTO `wiki_contents` VALUES (1,1,1,'h1. esta international\r\n\r\nh3. 一般\r\n* [[業務内容]]\r\n* [[業務運用マニュアル]]\r\n\r\nh3. 技術\r\n* 環境構築\r\n** [[git]]\r\n** [[TimeZone]]\r\n** [[Redmine]]\r\n** [[Apache]]\r\n** [[PHP]]\r\n** [[Https]]','','2013-04-30 18:32:11',5),(2,2,3,'h1. 業務内容\r\n\r\n* 申請作業\r\n** お客さまメールの振り分け\r\n** 申し込み内容の確認\r\n** 代理申請手続き\r\n** 申請結果書類作成\r\n** お客様のもとへメールにて申請結果の送信\r\n\r\n* 電話/メール応対\r\n** お客様からのお問い合わせ応対\r\n** メール送信不可能なお客様への案内\r\n** クレーム対応\r\n\r\n* 広告関連\r\n** 広告費の入金作業\r\n** 広告管理ツール内の設定\r\n　（キャンペーン作成・広告グループ作成・広告ワード作成・入札金額の設定・キーワード設定）\r\n** 日別広告費・掲載順位の推移調査\r\n\r\n* Paypal関連\r\n** 返金作業\r\n** 銀行への送金\r\n** その他問い合わせ業務\r\n\r\n* ウェブサイト関連\r\n** システム構築\r\n** 管理画面システム作成\r\n\r\n* その他\r\n** 売上げ管理表の作成','','2013-04-01 17:55:00',1),(3,3,3,'h1. Redmine\r\n\r\n\r\n* 基本設定\r\n<pre>\r\n基本的には下記URL等を参考にインストールします。\r\n</pre>\r\n** http://redmine.jp/guide/RedmineInstall/\r\n** http://blog.redmine.jp/articles/2_3/installation_centos/\r\n\r\n* Rubyインストール\r\n<pre>\r\n# 1.8.7 をインストールする\r\n\r\ncd /usr/local/src/\r\nsudo wget ftp://ftp.ruby-lang.org/pub/ruby/1.8/ruby-1.8.7-p174.tar.gz\r\nsudo  tar xvzf ruby-1.8.7-p174.tar.gz\r\ncd ruby-1.8.7-p174\r\nsudo ./configure\r\nsudo make\r\nsudo make install\r\nruby --version\r\n</pre>\r\n\r\n* rubygemインストール\r\n<pre>\r\n# 1.8.24 をインストールする\r\ncd /usr/local/src/\r\nsudo wget http://rubyforge.org/frs/download.php/76073/rubygems-1.8.24.tgz\r\nsudo tar zxvf rubygems-1.8.24.tgz \r\ncd rubygems-1.8.24\r\nsudo ruby setup.rb config　\r\nsudo ruby setup.rb setup\r\nsudo ruby setup.rb install\r\ngem -v\r\n</pre>\r\n\r\n* railsインストール\r\n<pre>\r\ncd redmine-2.3.0/ # rails project dir\r\nsudo bundle install --without development test postgresql sqlite\r\nsudo gem install passenger --no-rdoc --no-ri\r\nsudo passenger-install-apache2-module\r\n</pre>\r\n\r\n* apache設定\r\n<pre>\r\nsudo vim /etc/httpd/conf.d/passenger.conf\r\n# passenger-install-apache2-module --snippet # この出力内容を追記\r\n\r\n# for redmine\r\nLoadModule passenger_module /usr/lib64/ruby/gems/1.8/gems/passenger-3.0.19/ext/apache2/mod_passenger.so\r\nPassengerRoot /usr/lib64/ruby/gems/1.8/gems/passenger-3.0.19\r\nPassengerRuby /usr/bin/ruby\r\nRackBaseURI /redmines/esta_international # redmineを追加した場合は当該設定も追加\r\nRackBaseURI /redmines/redmine\r\n\r\nsudo /etc/init.d/httpd restart\r\n</pre>\r\n\r\n\r\n* .htaccess, document root の調整\r\n\r\n\r\n* 許可するHTMLタグを追加\r\n<pre>\r\n下記URLを参考にaタグを許可してください。\r\n</pre>\r\n** http://redmine.jp/faq/wiki/use-html-tag-in-wiki/','','2013-04-04 16:44:20',2),(4,4,3,'h1. Apache\r\n\r\n\r\n* 設定\r\n<pre>\r\n/etc/httpd/conf/httpd.conf\r\n\r\n# ユーザを変更\r\nUser wiz\r\nGroup wiz\r\n\r\n# ファイル一覧表示をOFF\r\nOptions -Indexes FollowSymLinks\r\n\r\n# .htaccess の許可\r\nAllowOverride All\r\n</pre>','','2013-04-04 17:06:56',2),(5,5,3,'h1. TimeZone\r\n\r\n* TimeZoneの設定\r\n<pre>\r\nsudo rm /etc/localtime\r\nsudo ls -s  /usr/share/zoneinfo/Asia/Tokyo /etc/localtime\r\n</pre>','','2013-04-04 17:01:43',1),(6,6,3,'h1. PHP\r\n\r\n* 基本設定\r\n<pre>\r\nsudo vim /etc/php.ini\r\n\r\nshort_open_tag = Off\r\n</pre>\r\n\r\n* Peclインストール\r\n<pre>\r\nsudo yum install php-devel\r\nsudo yum install php-pear\r\n</pre>\r\n\r\n* GeoIPインストール\r\n** http://blog.araishi.com/geoip-php-install/\r\n\r\n* Jsonインストール\r\n<pre>\r\nsudo  pecl install json\r\nsudo vim /etc/php.d/json.ini\r\n</pre>','','2013-04-04 18:52:13',3),(7,7,1,'h1. 業務運用マニュアル\r\n\r\n<pre>\r\n自分用のアカウントにて、Redmineにログイン。（※もし自分用のアカウントが無い場合は発行してもらう）\r\n</pre>\r\n\r\n*申請の基本的な流れ*\r\n\r\n* 担当者の変更\r\n# チケット一覧のカスタムクエリより、「未完了（担当者：なし）」を選択する。\r\n# 一覧の左にあるチェックボックスをONにして、右クリック、担当者を自分に変更する。（複数同時可能）\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/4/apply_select.png\r\n\r\n* 自分担当のチケットを確認\r\n# 方法(1) マイページにて確認　画面左上部の「マイページ」を押下してマイページに移動。担当チケットを確認する。\r\n# 方法(2) チケット一覧のカスタムクエリより「未完了（担当者：自分）」を選択する。\r\n\r\n* 申請処理\r\n# 申請対象チケットの詳細ページを開く（ブラウザA）\r\n# もう一つ別のブラウザを用意して（ブラウザB）、米国大使館ESTA申請サイトを表示し、申請内容入力ページまで進む\r\n# （A）チケット詳細ページにあるリンクを、（B）のブックマークにドラッグして登録する\r\n# （B）にてブックマークレットを使用して申請処理を進める。\r\n# 認証済みの申請が見つかった場合\r\n## 申請処理を一時キャンセルし、（A）にてステータスを「保留」に更新する。\r\n## （B）にて検索を行い、有効期限を確認する。\r\n## 残りの期間が概ね6か月～1年以上の場合は、メールにて当該内容を連絡する。\r\n## 残り期間が僅かである場合は、改めて通常通りの申請処理を行う。\r\n\r\n* 認証結果の登録\r\n** 問題なく認証許可された場合\r\n*** チケット詳細ページ右上より「更新」を押下。\r\n*** ステータス「手続き完了」を選択し、渡航申請番号と有効期限を転記する。\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/5/apply_done.png\r\n** 認証拒否となった場合\r\n*** チケット詳細ページ右上より「更新」を押下。\r\n*** ステータス「認証拒否」を選択し、渡航申請番号を転記する。\"画像で確認\":https://133.242.135.174/redmines/esta_onlinecenter/attachments/download/6/apply_reject.png\r\n\r\n*返金処理の流れ*\r\n\r\n* 返金希望のお問合せメールを受信した場合、当該チケットのステータスを確認する。\r\n** 「手続き完了」「認証拒否」の場合\r\n*** 原則として、ご返金できない旨をメールにて返信する\r\n*** 管理ツール（Redmine）上でのオペレーションは特にありません。\r\n** 「新規」「保留」の場合\r\n*** 決済手数料300円をご負担頂き、残りをご返金する旨をメールにて返信する。\r\n*** チケット詳細を更新、ステータスを「返金処理待ち」に変更、返金金額に\"300\"を入力する\r\n*** *返金処理担当者のみ* 返金処理担当者は、当該チケットを確認後にpaypal管理画面にて返金処理を行う。\r\n*** *返金処理担当者のみ* 返金処理完了後に返金済みのメールを送信し、チケット詳細を更新、ステータスを「キャンセル完了」に変更する。\r\n\r\n<pre>\r\n当該ルールは原則であり、状況に応じて対応してください。\r\n</pre>\r\n\r\n\r\n\r\n\r\n','','2013-04-26 18:04:18',16),(8,8,1,'h1. Git\r\n\r\n* リポジトリを追加する\r\n<pre>\r\nwget http://packages.sw.be/rpmforge-release/rpmforge-release-0.5.2-2.el5.rf.i386.rpm\r\n</pre>\r\n\r\n* git をインストールする\r\n<pre>\r\nyum install git\r\n</pre>','','2013-04-30 18:33:11',1);
/*!40000 ALTER TABLE `wiki_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wiki_pages`
--

DROP TABLE IF EXISTS `wiki_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wiki_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wiki_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `protected` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wiki_pages_wiki_id_title` (`wiki_id`,`title`),
  KEY `index_wiki_pages_on_wiki_id` (`wiki_id`),
  KEY `index_wiki_pages_on_parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wiki_pages`
--

LOCK TABLES `wiki_pages` WRITE;
/*!40000 ALTER TABLE `wiki_pages` DISABLE KEYS */;
INSERT INTO `wiki_pages` VALUES (1,2,'Wiki','2013-04-01 17:53:37',0,NULL),(2,2,'業務内容','2013-04-01 17:55:00',0,1),(3,2,'Redmine','2013-04-01 17:55:45',0,1),(4,2,'Apache','2013-04-01 17:56:17',0,1),(5,2,'TimeZone','2013-04-04 17:01:43',0,1),(6,2,'PHP','2013-04-04 17:03:03',0,1),(7,2,'業務運用マニュアル','2013-04-26 16:27:11',0,1),(8,2,'Git','2013-04-30 18:33:11',0,1);
/*!40000 ALTER TABLE `wiki_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wiki_redirects`
--

DROP TABLE IF EXISTS `wiki_redirects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wiki_redirects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wiki_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `redirects_to` varchar(255) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `wiki_redirects_wiki_id_title` (`wiki_id`,`title`),
  KEY `index_wiki_redirects_on_wiki_id` (`wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wiki_redirects`
--

LOCK TABLES `wiki_redirects` WRITE;
/*!40000 ALTER TABLE `wiki_redirects` DISABLE KEYS */;
/*!40000 ALTER TABLE `wiki_redirects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wikis`
--

DROP TABLE IF EXISTS `wikis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wikis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `start_page` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `wikis_project_id` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wikis`
--

LOCK TABLES `wikis` WRITE;
/*!40000 ALTER TABLE `wikis` DISABLE KEYS */;
INSERT INTO `wikis` VALUES (1,1,'Wiki',1),(2,2,'Wiki',1);
/*!40000 ALTER TABLE `wikis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workflows`
--

DROP TABLE IF EXISTS `workflows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workflows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tracker_id` int(11) NOT NULL DEFAULT '0',
  `old_status_id` int(11) NOT NULL DEFAULT '0',
  `new_status_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `assignee` tinyint(1) NOT NULL DEFAULT '0',
  `author` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(30) DEFAULT NULL,
  `field_name` varchar(30) DEFAULT NULL,
  `rule` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wkfs_role_tracker_old_status` (`role_id`,`tracker_id`,`old_status_id`),
  KEY `index_workflows_on_old_status_id` (`old_status_id`),
  KEY `index_workflows_on_role_id` (`role_id`),
  KEY `index_workflows_on_new_status_id` (`new_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3483 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workflows`
--

LOCK TABLES `workflows` WRITE;
/*!40000 ALTER TABLE `workflows` DISABLE KEYS */;
INSERT INTO `workflows` VALUES (145,4,9,9,3,0,0,'WorkflowTransition',NULL,NULL),(146,4,9,8,3,0,0,'WorkflowTransition',NULL,NULL),(147,4,9,7,3,0,0,'WorkflowTransition',NULL,NULL),(148,4,9,1,3,0,0,'WorkflowTransition',NULL,NULL),(149,4,9,12,3,0,0,'WorkflowTransition',NULL,NULL),(150,4,9,11,3,0,0,'WorkflowTransition',NULL,NULL),(151,4,9,10,3,0,0,'WorkflowTransition',NULL,NULL),(152,4,8,9,3,0,0,'WorkflowTransition',NULL,NULL),(153,4,8,8,3,0,0,'WorkflowTransition',NULL,NULL),(154,4,8,7,3,0,0,'WorkflowTransition',NULL,NULL),(155,4,8,1,3,0,0,'WorkflowTransition',NULL,NULL),(156,4,8,12,3,0,0,'WorkflowTransition',NULL,NULL),(157,4,8,11,3,0,0,'WorkflowTransition',NULL,NULL),(158,4,8,10,3,0,0,'WorkflowTransition',NULL,NULL),(159,4,7,9,3,0,0,'WorkflowTransition',NULL,NULL),(160,4,7,8,3,0,0,'WorkflowTransition',NULL,NULL),(161,4,7,7,3,0,0,'WorkflowTransition',NULL,NULL),(162,4,7,1,3,0,0,'WorkflowTransition',NULL,NULL),(163,4,7,12,3,0,0,'WorkflowTransition',NULL,NULL),(164,4,7,11,3,0,0,'WorkflowTransition',NULL,NULL),(165,4,7,10,3,0,0,'WorkflowTransition',NULL,NULL),(166,4,1,9,3,0,0,'WorkflowTransition',NULL,NULL),(167,4,1,8,3,0,0,'WorkflowTransition',NULL,NULL),(168,4,1,7,3,0,0,'WorkflowTransition',NULL,NULL),(169,4,1,1,3,0,0,'WorkflowTransition',NULL,NULL),(170,4,1,12,3,0,0,'WorkflowTransition',NULL,NULL),(171,4,1,11,3,0,0,'WorkflowTransition',NULL,NULL),(172,4,1,10,3,0,0,'WorkflowTransition',NULL,NULL),(173,4,12,9,3,0,0,'WorkflowTransition',NULL,NULL),(174,4,12,8,3,0,0,'WorkflowTransition',NULL,NULL),(175,4,12,7,3,0,0,'WorkflowTransition',NULL,NULL),(176,4,12,1,3,0,0,'WorkflowTransition',NULL,NULL),(177,4,12,12,3,0,0,'WorkflowTransition',NULL,NULL),(178,4,12,11,3,0,0,'WorkflowTransition',NULL,NULL),(179,4,12,10,3,0,0,'WorkflowTransition',NULL,NULL),(180,4,11,9,3,0,0,'WorkflowTransition',NULL,NULL),(181,4,11,8,3,0,0,'WorkflowTransition',NULL,NULL),(182,4,11,7,3,0,0,'WorkflowTransition',NULL,NULL),(183,4,11,1,3,0,0,'WorkflowTransition',NULL,NULL),(184,4,11,12,3,0,0,'WorkflowTransition',NULL,NULL),(185,4,11,11,3,0,0,'WorkflowTransition',NULL,NULL),(186,4,11,10,3,0,0,'WorkflowTransition',NULL,NULL),(187,4,10,9,3,0,0,'WorkflowTransition',NULL,NULL),(188,4,10,8,3,0,0,'WorkflowTransition',NULL,NULL),(189,4,10,7,3,0,0,'WorkflowTransition',NULL,NULL),(190,4,10,1,3,0,0,'WorkflowTransition',NULL,NULL),(191,4,10,12,3,0,0,'WorkflowTransition',NULL,NULL),(192,4,10,11,3,0,0,'WorkflowTransition',NULL,NULL),(193,4,10,10,3,0,0,'WorkflowTransition',NULL,NULL),(2514,5,1,9,3,0,0,'WorkflowTransition',NULL,NULL),(2515,5,1,8,3,0,0,'WorkflowTransition',NULL,NULL),(2516,5,1,7,3,0,0,'WorkflowTransition',NULL,NULL),(2517,5,1,1,3,0,0,'WorkflowTransition',NULL,NULL),(2518,5,1,12,3,0,0,'WorkflowTransition',NULL,NULL),(2519,5,1,11,3,0,0,'WorkflowTransition',NULL,NULL),(2520,5,1,10,3,0,0,'WorkflowTransition',NULL,NULL),(2521,5,7,9,3,0,0,'WorkflowTransition',NULL,NULL),(2522,5,7,8,3,0,0,'WorkflowTransition',NULL,NULL),(2523,5,7,7,3,0,0,'WorkflowTransition',NULL,NULL),(2524,5,7,1,3,0,0,'WorkflowTransition',NULL,NULL),(2525,5,7,12,3,0,0,'WorkflowTransition',NULL,NULL),(2526,5,7,11,3,0,0,'WorkflowTransition',NULL,NULL),(2527,5,7,10,3,0,0,'WorkflowTransition',NULL,NULL),(2528,5,8,9,3,0,0,'WorkflowTransition',NULL,NULL),(2529,5,8,8,3,0,0,'WorkflowTransition',NULL,NULL),(2530,5,8,7,3,0,0,'WorkflowTransition',NULL,NULL),(2531,5,8,1,3,0,0,'WorkflowTransition',NULL,NULL),(2532,5,8,12,3,0,0,'WorkflowTransition',NULL,NULL),(2533,5,8,11,3,0,0,'WorkflowTransition',NULL,NULL),(2534,5,8,10,3,0,0,'WorkflowTransition',NULL,NULL),(2535,5,9,9,3,0,0,'WorkflowTransition',NULL,NULL),(2536,5,9,8,3,0,0,'WorkflowTransition',NULL,NULL),(2537,5,9,7,3,0,0,'WorkflowTransition',NULL,NULL),(2538,5,9,1,3,0,0,'WorkflowTransition',NULL,NULL),(2539,5,9,12,3,0,0,'WorkflowTransition',NULL,NULL),(2540,5,9,11,3,0,0,'WorkflowTransition',NULL,NULL),(2541,5,9,10,3,0,0,'WorkflowTransition',NULL,NULL),(2542,5,10,9,3,0,0,'WorkflowTransition',NULL,NULL),(2543,5,10,8,3,0,0,'WorkflowTransition',NULL,NULL),(2544,5,10,7,3,0,0,'WorkflowTransition',NULL,NULL),(2545,5,10,1,3,0,0,'WorkflowTransition',NULL,NULL),(2546,5,10,12,3,0,0,'WorkflowTransition',NULL,NULL),(2547,5,10,11,3,0,0,'WorkflowTransition',NULL,NULL),(2548,5,10,10,3,0,0,'WorkflowTransition',NULL,NULL),(2549,5,11,9,3,0,0,'WorkflowTransition',NULL,NULL),(2550,5,11,8,3,0,0,'WorkflowTransition',NULL,NULL),(2551,5,11,7,3,0,0,'WorkflowTransition',NULL,NULL),(2552,5,11,1,3,0,0,'WorkflowTransition',NULL,NULL),(2553,5,11,12,3,0,0,'WorkflowTransition',NULL,NULL),(2554,5,11,11,3,0,0,'WorkflowTransition',NULL,NULL),(2555,5,11,10,3,0,0,'WorkflowTransition',NULL,NULL),(2556,5,12,9,3,0,0,'WorkflowTransition',NULL,NULL),(2557,5,12,8,3,0,0,'WorkflowTransition',NULL,NULL),(2558,5,12,7,3,0,0,'WorkflowTransition',NULL,NULL),(2559,5,12,1,3,0,0,'WorkflowTransition',NULL,NULL),(2560,5,12,12,3,0,0,'WorkflowTransition',NULL,NULL),(2561,5,12,11,3,0,0,'WorkflowTransition',NULL,NULL),(2562,5,12,10,3,0,0,'WorkflowTransition',NULL,NULL),(2577,4,11,10,6,0,0,'WorkflowTransition',NULL,NULL),(2578,4,11,9,6,0,0,'WorkflowTransition',NULL,NULL),(2579,4,11,7,6,0,0,'WorkflowTransition',NULL,NULL),(2580,4,10,8,6,0,0,'WorkflowTransition',NULL,NULL),(2581,4,9,10,6,0,0,'WorkflowTransition',NULL,NULL),(2582,4,7,10,6,0,0,'WorkflowTransition',NULL,NULL),(2583,4,1,11,6,0,0,'WorkflowTransition',NULL,NULL),(2584,4,1,10,6,0,0,'WorkflowTransition',NULL,NULL),(2585,4,1,9,6,0,0,'WorkflowTransition',NULL,NULL),(2586,4,1,7,6,0,0,'WorkflowTransition',NULL,NULL),(2881,4,11,0,6,0,0,'WorkflowPermission','33','readonly'),(2882,4,12,0,6,0,0,'WorkflowPermission','33','readonly'),(2883,4,7,0,6,0,0,'WorkflowPermission','33','readonly'),(2884,4,8,0,6,0,0,'WorkflowPermission','33','readonly'),(2885,4,9,0,6,0,0,'WorkflowPermission','33','readonly'),(2886,4,1,0,6,0,0,'WorkflowPermission','33','readonly'),(2887,4,10,0,6,0,0,'WorkflowPermission','33','readonly'),(2888,4,11,0,6,0,0,'WorkflowPermission','22','readonly'),(2889,4,12,0,6,0,0,'WorkflowPermission','22','readonly'),(2890,4,7,0,6,0,0,'WorkflowPermission','22','readonly'),(2891,4,8,0,6,0,0,'WorkflowPermission','22','readonly'),(2892,4,9,0,6,0,0,'WorkflowPermission','22','readonly'),(2893,4,1,0,6,0,0,'WorkflowPermission','22','readonly'),(2894,4,10,0,6,0,0,'WorkflowPermission','22','readonly'),(2895,4,11,0,6,0,0,'WorkflowPermission','11','required'),(2896,4,12,0,6,0,0,'WorkflowPermission','11','readonly'),(2897,4,7,0,6,0,0,'WorkflowPermission','11','required'),(2898,4,8,0,6,0,0,'WorkflowPermission','11','readonly'),(2899,4,9,0,6,0,0,'WorkflowPermission','11','required'),(2900,4,1,0,6,0,0,'WorkflowPermission','11','required'),(2901,4,10,0,6,0,0,'WorkflowPermission','11','required'),(2902,4,11,0,6,0,0,'WorkflowPermission','6','readonly'),(2903,4,12,0,6,0,0,'WorkflowPermission','6','readonly'),(2904,4,7,0,6,0,0,'WorkflowPermission','6','readonly'),(2905,4,8,0,6,0,0,'WorkflowPermission','6','readonly'),(2906,4,9,0,6,0,0,'WorkflowPermission','6','readonly'),(2907,4,1,0,6,0,0,'WorkflowPermission','6','readonly'),(2908,4,10,0,6,0,0,'WorkflowPermission','6','readonly'),(2909,4,11,0,6,0,0,'WorkflowPermission','start_date','readonly'),(2910,4,12,0,6,0,0,'WorkflowPermission','start_date','readonly'),(2911,4,7,0,6,0,0,'WorkflowPermission','start_date','readonly'),(2912,4,8,0,6,0,0,'WorkflowPermission','start_date','readonly'),(2913,4,9,0,6,0,0,'WorkflowPermission','start_date','readonly'),(2914,4,1,0,6,0,0,'WorkflowPermission','start_date','readonly'),(2915,4,10,0,6,0,0,'WorkflowPermission','start_date','readonly'),(2916,4,11,0,6,0,0,'WorkflowPermission','34','readonly'),(2917,4,12,0,6,0,0,'WorkflowPermission','34','readonly'),(2918,4,7,0,6,0,0,'WorkflowPermission','34','readonly'),(2919,4,8,0,6,0,0,'WorkflowPermission','34','readonly'),(2920,4,9,0,6,0,0,'WorkflowPermission','34','readonly'),(2921,4,1,0,6,0,0,'WorkflowPermission','34','readonly'),(2922,4,10,0,6,0,0,'WorkflowPermission','34','readonly'),(2923,4,11,0,6,0,0,'WorkflowPermission','23','readonly'),(2924,4,12,0,6,0,0,'WorkflowPermission','23','readonly'),(2925,4,7,0,6,0,0,'WorkflowPermission','23','readonly'),(2926,4,8,0,6,0,0,'WorkflowPermission','23','readonly'),(2927,4,9,0,6,0,0,'WorkflowPermission','23','readonly'),(2928,4,1,0,6,0,0,'WorkflowPermission','23','readonly'),(2929,4,10,0,6,0,0,'WorkflowPermission','23','readonly'),(2930,4,11,0,6,0,0,'WorkflowPermission','12','readonly'),(2931,4,12,0,6,0,0,'WorkflowPermission','12','readonly'),(2932,4,7,0,6,0,0,'WorkflowPermission','12','readonly'),(2933,4,8,0,6,0,0,'WorkflowPermission','12','readonly'),(2934,4,9,0,6,0,0,'WorkflowPermission','12','readonly'),(2935,4,1,0,6,0,0,'WorkflowPermission','12','readonly'),(2936,4,10,0,6,0,0,'WorkflowPermission','12','readonly'),(2937,4,11,0,6,0,0,'WorkflowPermission','7','readonly'),(2938,4,12,0,6,0,0,'WorkflowPermission','7','readonly'),(2939,4,7,0,6,0,0,'WorkflowPermission','7','readonly'),(2940,4,8,0,6,0,0,'WorkflowPermission','7','readonly'),(2941,4,9,0,6,0,0,'WorkflowPermission','7','readonly'),(2942,4,1,0,6,0,0,'WorkflowPermission','7','readonly'),(2943,4,10,0,6,0,0,'WorkflowPermission','7','readonly'),(2944,4,11,0,6,0,0,'WorkflowPermission','24','readonly'),(2945,4,12,0,6,0,0,'WorkflowPermission','24','readonly'),(2946,4,7,0,6,0,0,'WorkflowPermission','24','readonly'),(2947,4,8,0,6,0,0,'WorkflowPermission','24','readonly'),(2948,4,9,0,6,0,0,'WorkflowPermission','24','readonly'),(2949,4,1,0,6,0,0,'WorkflowPermission','24','readonly'),(2950,4,10,0,6,0,0,'WorkflowPermission','24','readonly'),(2951,4,11,0,6,0,0,'WorkflowPermission','13','readonly'),(2952,4,12,0,6,0,0,'WorkflowPermission','13','readonly'),(2953,4,7,0,6,0,0,'WorkflowPermission','13','readonly'),(2954,4,8,0,6,0,0,'WorkflowPermission','13','readonly'),(2955,4,9,0,6,0,0,'WorkflowPermission','13','readonly'),(2956,4,1,0,6,0,0,'WorkflowPermission','13','readonly'),(2957,4,10,0,6,0,0,'WorkflowPermission','13','readonly'),(2958,4,11,0,6,0,0,'WorkflowPermission','8','readonly'),(2959,4,12,0,6,0,0,'WorkflowPermission','8','readonly'),(2960,4,7,0,6,0,0,'WorkflowPermission','8','readonly'),(2961,4,8,0,6,0,0,'WorkflowPermission','8','readonly'),(2962,4,9,0,6,0,0,'WorkflowPermission','8','readonly'),(2963,4,1,0,6,0,0,'WorkflowPermission','8','readonly'),(2964,4,10,0,6,0,0,'WorkflowPermission','8','readonly'),(2965,4,11,0,6,0,0,'WorkflowPermission','priority_id','readonly'),(2966,4,12,0,6,0,0,'WorkflowPermission','priority_id','readonly'),(2967,4,7,0,6,0,0,'WorkflowPermission','priority_id','readonly'),(2968,4,8,0,6,0,0,'WorkflowPermission','priority_id','readonly'),(2969,4,9,0,6,0,0,'WorkflowPermission','priority_id','readonly'),(2970,4,1,0,6,0,0,'WorkflowPermission','priority_id','readonly'),(2971,4,10,0,6,0,0,'WorkflowPermission','priority_id','readonly'),(2972,4,11,0,6,0,0,'WorkflowPermission','25','readonly'),(2973,4,12,0,6,0,0,'WorkflowPermission','25','readonly'),(2974,4,7,0,6,0,0,'WorkflowPermission','25','readonly'),(2975,4,8,0,6,0,0,'WorkflowPermission','25','readonly'),(2976,4,9,0,6,0,0,'WorkflowPermission','25','readonly'),(2977,4,1,0,6,0,0,'WorkflowPermission','25','readonly'),(2978,4,10,0,6,0,0,'WorkflowPermission','25','readonly'),(2979,4,11,0,6,0,0,'WorkflowPermission','14','readonly'),(2980,4,12,0,6,0,0,'WorkflowPermission','14','readonly'),(2981,4,7,0,6,0,0,'WorkflowPermission','14','required'),(2982,4,8,0,6,0,0,'WorkflowPermission','14','readonly'),(2983,4,9,0,6,0,0,'WorkflowPermission','14','required'),(2984,4,1,0,6,0,0,'WorkflowPermission','14','readonly'),(2985,4,10,0,6,0,0,'WorkflowPermission','14','readonly'),(2986,4,11,0,6,0,0,'WorkflowPermission','9','readonly'),(2987,4,12,0,6,0,0,'WorkflowPermission','9','readonly'),(2988,4,7,0,6,0,0,'WorkflowPermission','9','readonly'),(2989,4,8,0,6,0,0,'WorkflowPermission','9','readonly'),(2990,4,9,0,6,0,0,'WorkflowPermission','9','readonly'),(2991,4,1,0,6,0,0,'WorkflowPermission','9','readonly'),(2992,4,10,0,6,0,0,'WorkflowPermission','9','readonly'),(2993,4,11,0,6,0,0,'WorkflowPermission','is_private','readonly'),(2994,4,12,0,6,0,0,'WorkflowPermission','is_private','readonly'),(2995,4,7,0,6,0,0,'WorkflowPermission','is_private','readonly'),(2996,4,8,0,6,0,0,'WorkflowPermission','is_private','readonly'),(2997,4,9,0,6,0,0,'WorkflowPermission','is_private','readonly'),(2998,4,1,0,6,0,0,'WorkflowPermission','is_private','readonly'),(2999,4,10,0,6,0,0,'WorkflowPermission','is_private','readonly'),(3000,4,11,0,6,0,0,'WorkflowPermission','project_id','readonly'),(3001,4,12,0,6,0,0,'WorkflowPermission','project_id','readonly'),(3002,4,7,0,6,0,0,'WorkflowPermission','project_id','readonly'),(3003,4,8,0,6,0,0,'WorkflowPermission','project_id','readonly'),(3004,4,9,0,6,0,0,'WorkflowPermission','project_id','readonly'),(3005,4,1,0,6,0,0,'WorkflowPermission','project_id','readonly'),(3006,4,10,0,6,0,0,'WorkflowPermission','project_id','readonly'),(3007,4,11,0,6,0,0,'WorkflowPermission','26','readonly'),(3008,4,12,0,6,0,0,'WorkflowPermission','26','readonly'),(3009,4,7,0,6,0,0,'WorkflowPermission','26','readonly'),(3010,4,8,0,6,0,0,'WorkflowPermission','26','readonly'),(3011,4,9,0,6,0,0,'WorkflowPermission','26','readonly'),(3012,4,1,0,6,0,0,'WorkflowPermission','26','readonly'),(3013,4,10,0,6,0,0,'WorkflowPermission','26','readonly'),(3014,4,11,0,6,0,0,'WorkflowPermission','15','readonly'),(3015,4,12,0,6,0,0,'WorkflowPermission','15','readonly'),(3016,4,7,0,6,0,0,'WorkflowPermission','15','required'),(3017,4,8,0,6,0,0,'WorkflowPermission','15','readonly'),(3018,4,9,0,6,0,0,'WorkflowPermission','15','readonly'),(3019,4,1,0,6,0,0,'WorkflowPermission','15','readonly'),(3020,4,10,0,6,0,0,'WorkflowPermission','15','readonly'),(3021,4,11,0,6,0,0,'WorkflowPermission','27','readonly'),(3022,4,12,0,6,0,0,'WorkflowPermission','27','readonly'),(3023,4,7,0,6,0,0,'WorkflowPermission','27','readonly'),(3024,4,8,0,6,0,0,'WorkflowPermission','27','readonly'),(3025,4,9,0,6,0,0,'WorkflowPermission','27','readonly'),(3026,4,1,0,6,0,0,'WorkflowPermission','27','readonly'),(3027,4,10,0,6,0,0,'WorkflowPermission','27','readonly'),(3028,4,11,0,6,0,0,'WorkflowPermission','16','readonly'),(3029,4,12,0,6,0,0,'WorkflowPermission','16','readonly'),(3030,4,7,0,6,0,0,'WorkflowPermission','16','required'),(3031,4,8,0,6,0,0,'WorkflowPermission','16','readonly'),(3032,4,9,0,6,0,0,'WorkflowPermission','16','readonly'),(3033,4,1,0,6,0,0,'WorkflowPermission','16','readonly'),(3034,4,10,0,6,0,0,'WorkflowPermission','16','readonly'),(3035,4,11,0,6,0,0,'WorkflowPermission','done_ratio','readonly'),(3036,4,12,0,6,0,0,'WorkflowPermission','done_ratio','readonly'),(3037,4,7,0,6,0,0,'WorkflowPermission','done_ratio','readonly'),(3038,4,8,0,6,0,0,'WorkflowPermission','done_ratio','readonly'),(3039,4,9,0,6,0,0,'WorkflowPermission','done_ratio','readonly'),(3040,4,1,0,6,0,0,'WorkflowPermission','done_ratio','readonly'),(3041,4,10,0,6,0,0,'WorkflowPermission','done_ratio','readonly'),(3042,4,11,0,6,0,0,'WorkflowPermission','assigned_to_id','required'),(3043,4,12,0,6,0,0,'WorkflowPermission','assigned_to_id','readonly'),(3044,4,7,0,6,0,0,'WorkflowPermission','assigned_to_id','required'),(3045,4,8,0,6,0,0,'WorkflowPermission','assigned_to_id','readonly'),(3046,4,9,0,6,0,0,'WorkflowPermission','assigned_to_id','required'),(3047,4,1,0,6,0,0,'WorkflowPermission','assigned_to_id','required'),(3048,4,10,0,6,0,0,'WorkflowPermission','assigned_to_id','required'),(3049,4,11,0,6,0,0,'WorkflowPermission','subject','readonly'),(3050,4,12,0,6,0,0,'WorkflowPermission','subject','readonly'),(3051,4,7,0,6,0,0,'WorkflowPermission','subject','readonly'),(3052,4,8,0,6,0,0,'WorkflowPermission','subject','readonly'),(3053,4,9,0,6,0,0,'WorkflowPermission','subject','readonly'),(3054,4,1,0,6,0,0,'WorkflowPermission','subject','readonly'),(3055,4,10,0,6,0,0,'WorkflowPermission','subject','readonly'),(3056,4,11,0,6,0,0,'WorkflowPermission','28','readonly'),(3057,4,12,0,6,0,0,'WorkflowPermission','28','readonly'),(3058,4,7,0,6,0,0,'WorkflowPermission','28','readonly'),(3059,4,8,0,6,0,0,'WorkflowPermission','28','readonly'),(3060,4,9,0,6,0,0,'WorkflowPermission','28','readonly'),(3061,4,1,0,6,0,0,'WorkflowPermission','28','readonly'),(3062,4,10,0,6,0,0,'WorkflowPermission','28','readonly'),(3063,4,11,0,6,0,0,'WorkflowPermission','17','readonly'),(3064,4,12,0,6,0,0,'WorkflowPermission','17','readonly'),(3065,4,7,0,6,0,0,'WorkflowPermission','17','readonly'),(3066,4,8,0,6,0,0,'WorkflowPermission','17','readonly'),(3067,4,9,0,6,0,0,'WorkflowPermission','17','readonly'),(3068,4,1,0,6,0,0,'WorkflowPermission','17','readonly'),(3069,4,10,0,6,0,0,'WorkflowPermission','17','readonly'),(3070,4,11,0,6,0,0,'WorkflowPermission','1','readonly'),(3071,4,12,0,6,0,0,'WorkflowPermission','1','readonly'),(3072,4,7,0,6,0,0,'WorkflowPermission','1','readonly'),(3073,4,8,0,6,0,0,'WorkflowPermission','1','readonly'),(3074,4,9,0,6,0,0,'WorkflowPermission','1','readonly'),(3075,4,1,0,6,0,0,'WorkflowPermission','1','readonly'),(3076,4,10,0,6,0,0,'WorkflowPermission','1','readonly'),(3077,4,11,0,6,0,0,'WorkflowPermission','tracker_id','readonly'),(3078,4,12,0,6,0,0,'WorkflowPermission','tracker_id','readonly'),(3079,4,7,0,6,0,0,'WorkflowPermission','tracker_id','readonly'),(3080,4,8,0,6,0,0,'WorkflowPermission','tracker_id','readonly'),(3081,4,9,0,6,0,0,'WorkflowPermission','tracker_id','readonly'),(3082,4,1,0,6,0,0,'WorkflowPermission','tracker_id','readonly'),(3083,4,10,0,6,0,0,'WorkflowPermission','tracker_id','readonly'),(3084,4,11,0,6,0,0,'WorkflowPermission','30','readonly'),(3085,4,12,0,6,0,0,'WorkflowPermission','30','readonly'),(3086,4,7,0,6,0,0,'WorkflowPermission','30','readonly'),(3087,4,8,0,6,0,0,'WorkflowPermission','30','readonly'),(3088,4,9,0,6,0,0,'WorkflowPermission','30','readonly'),(3089,4,1,0,6,0,0,'WorkflowPermission','30','readonly'),(3090,4,10,0,6,0,0,'WorkflowPermission','30','readonly'),(3091,4,11,0,6,0,0,'WorkflowPermission','29','readonly'),(3092,4,12,0,6,0,0,'WorkflowPermission','29','readonly'),(3093,4,7,0,6,0,0,'WorkflowPermission','29','readonly'),(3094,4,8,0,6,0,0,'WorkflowPermission','29','readonly'),(3095,4,9,0,6,0,0,'WorkflowPermission','29','readonly'),(3096,4,1,0,6,0,0,'WorkflowPermission','29','readonly'),(3097,4,10,0,6,0,0,'WorkflowPermission','29','readonly'),(3098,4,11,0,6,0,0,'WorkflowPermission','18','readonly'),(3099,4,12,0,6,0,0,'WorkflowPermission','18','readonly'),(3100,4,7,0,6,0,0,'WorkflowPermission','18','readonly'),(3101,4,8,0,6,0,0,'WorkflowPermission','18','readonly'),(3102,4,9,0,6,0,0,'WorkflowPermission','18','readonly'),(3103,4,1,0,6,0,0,'WorkflowPermission','18','readonly'),(3104,4,10,0,6,0,0,'WorkflowPermission','18','readonly'),(3105,4,11,0,6,0,0,'WorkflowPermission','2','readonly'),(3106,4,12,0,6,0,0,'WorkflowPermission','2','readonly'),(3107,4,7,0,6,0,0,'WorkflowPermission','2','readonly'),(3108,4,8,0,6,0,0,'WorkflowPermission','2','readonly'),(3109,4,9,0,6,0,0,'WorkflowPermission','2','readonly'),(3110,4,1,0,6,0,0,'WorkflowPermission','2','readonly'),(3111,4,10,0,6,0,0,'WorkflowPermission','2','readonly'),(3112,4,11,0,6,0,0,'WorkflowPermission','31','readonly'),(3113,4,12,0,6,0,0,'WorkflowPermission','31','readonly'),(3114,4,7,0,6,0,0,'WorkflowPermission','31','readonly'),(3115,4,8,0,6,0,0,'WorkflowPermission','31','readonly'),(3116,4,9,0,6,0,0,'WorkflowPermission','31','readonly'),(3117,4,1,0,6,0,0,'WorkflowPermission','31','readonly'),(3118,4,10,0,6,0,0,'WorkflowPermission','31','required'),(3119,4,11,0,6,0,0,'WorkflowPermission','20','readonly'),(3120,4,12,0,6,0,0,'WorkflowPermission','20','readonly'),(3121,4,7,0,6,0,0,'WorkflowPermission','20','readonly'),(3122,4,8,0,6,0,0,'WorkflowPermission','20','readonly'),(3123,4,9,0,6,0,0,'WorkflowPermission','20','readonly'),(3124,4,1,0,6,0,0,'WorkflowPermission','20','readonly'),(3125,4,10,0,6,0,0,'WorkflowPermission','20','readonly'),(3126,4,11,0,6,0,0,'WorkflowPermission','19','readonly'),(3127,4,12,0,6,0,0,'WorkflowPermission','19','readonly'),(3128,4,7,0,6,0,0,'WorkflowPermission','19','readonly'),(3129,4,8,0,6,0,0,'WorkflowPermission','19','readonly'),(3130,4,9,0,6,0,0,'WorkflowPermission','19','readonly'),(3131,4,1,0,6,0,0,'WorkflowPermission','19','readonly'),(3132,4,10,0,6,0,0,'WorkflowPermission','19','readonly'),(3133,4,11,0,6,0,0,'WorkflowPermission','3','readonly'),(3134,4,12,0,6,0,0,'WorkflowPermission','3','readonly'),(3135,4,7,0,6,0,0,'WorkflowPermission','3','readonly'),(3136,4,8,0,6,0,0,'WorkflowPermission','3','readonly'),(3137,4,9,0,6,0,0,'WorkflowPermission','3','readonly'),(3138,4,1,0,6,0,0,'WorkflowPermission','3','readonly'),(3139,4,10,0,6,0,0,'WorkflowPermission','3','readonly'),(3140,4,11,0,6,0,0,'WorkflowPermission','description','readonly'),(3141,4,12,0,6,0,0,'WorkflowPermission','description','readonly'),(3142,4,7,0,6,0,0,'WorkflowPermission','description','readonly'),(3143,4,8,0,6,0,0,'WorkflowPermission','description','readonly'),(3144,4,9,0,6,0,0,'WorkflowPermission','description','readonly'),(3145,4,1,0,6,0,0,'WorkflowPermission','description','readonly'),(3146,4,10,0,6,0,0,'WorkflowPermission','description','readonly'),(3147,4,11,0,6,0,0,'WorkflowPermission','32','readonly'),(3148,4,12,0,6,0,0,'WorkflowPermission','32','readonly'),(3149,4,7,0,6,0,0,'WorkflowPermission','32','readonly'),(3150,4,8,0,6,0,0,'WorkflowPermission','32','readonly'),(3151,4,9,0,6,0,0,'WorkflowPermission','32','readonly'),(3152,4,1,0,6,0,0,'WorkflowPermission','32','readonly'),(3153,4,10,0,6,0,0,'WorkflowPermission','32','readonly'),(3154,4,11,0,6,0,0,'WorkflowPermission','21','readonly'),(3155,4,12,0,6,0,0,'WorkflowPermission','21','readonly'),(3156,4,7,0,6,0,0,'WorkflowPermission','21','readonly'),(3157,4,8,0,6,0,0,'WorkflowPermission','21','readonly'),(3158,4,9,0,6,0,0,'WorkflowPermission','21','readonly'),(3159,4,1,0,6,0,0,'WorkflowPermission','21','readonly'),(3160,4,10,0,6,0,0,'WorkflowPermission','21','readonly'),(3161,4,11,0,6,0,0,'WorkflowPermission','10','readonly'),(3162,4,12,0,6,0,0,'WorkflowPermission','10','readonly'),(3163,4,7,0,6,0,0,'WorkflowPermission','10','readonly'),(3164,4,8,0,6,0,0,'WorkflowPermission','10','readonly'),(3165,4,9,0,6,0,0,'WorkflowPermission','10','readonly'),(3166,4,1,0,6,0,0,'WorkflowPermission','10','readonly'),(3167,4,10,0,6,0,0,'WorkflowPermission','10','readonly'),(3168,4,11,0,6,0,0,'WorkflowPermission','4','readonly'),(3169,4,12,0,6,0,0,'WorkflowPermission','4','readonly'),(3170,4,7,0,6,0,0,'WorkflowPermission','4','readonly'),(3171,4,8,0,6,0,0,'WorkflowPermission','4','readonly'),(3172,4,9,0,6,0,0,'WorkflowPermission','4','readonly'),(3173,4,1,0,6,0,0,'WorkflowPermission','4','readonly'),(3174,4,10,0,6,0,0,'WorkflowPermission','4','readonly'),(3175,4,11,0,6,0,0,'WorkflowPermission','5','readonly'),(3176,4,12,0,6,0,0,'WorkflowPermission','5','readonly'),(3177,4,7,0,6,0,0,'WorkflowPermission','5','readonly'),(3178,4,8,0,6,0,0,'WorkflowPermission','5','readonly'),(3179,4,9,0,6,0,0,'WorkflowPermission','5','readonly'),(3180,4,1,0,6,0,0,'WorkflowPermission','5','readonly'),(3181,4,10,0,6,0,0,'WorkflowPermission','5','readonly'),(3182,5,11,0,6,0,0,'WorkflowPermission','33','readonly'),(3183,5,12,0,6,0,0,'WorkflowPermission','33','readonly'),(3184,5,7,0,6,0,0,'WorkflowPermission','33','readonly'),(3185,5,8,0,6,0,0,'WorkflowPermission','33','readonly'),(3186,5,9,0,6,0,0,'WorkflowPermission','33','readonly'),(3187,5,1,0,6,0,0,'WorkflowPermission','33','readonly'),(3188,5,10,0,6,0,0,'WorkflowPermission','33','readonly'),(3189,5,11,0,6,0,0,'WorkflowPermission','22','readonly'),(3190,5,12,0,6,0,0,'WorkflowPermission','22','readonly'),(3191,5,7,0,6,0,0,'WorkflowPermission','22','readonly'),(3192,5,8,0,6,0,0,'WorkflowPermission','22','readonly'),(3193,5,9,0,6,0,0,'WorkflowPermission','22','readonly'),(3194,5,1,0,6,0,0,'WorkflowPermission','22','readonly'),(3195,5,10,0,6,0,0,'WorkflowPermission','22','readonly'),(3196,5,11,0,6,0,0,'WorkflowPermission','11','readonly'),(3197,5,12,0,6,0,0,'WorkflowPermission','11','readonly'),(3198,5,7,0,6,0,0,'WorkflowPermission','11','readonly'),(3199,5,8,0,6,0,0,'WorkflowPermission','11','readonly'),(3200,5,9,0,6,0,0,'WorkflowPermission','11','readonly'),(3201,5,1,0,6,0,0,'WorkflowPermission','11','readonly'),(3202,5,10,0,6,0,0,'WorkflowPermission','11','readonly'),(3203,5,11,0,6,0,0,'WorkflowPermission','6','readonly'),(3204,5,12,0,6,0,0,'WorkflowPermission','6','readonly'),(3205,5,7,0,6,0,0,'WorkflowPermission','6','readonly'),(3206,5,8,0,6,0,0,'WorkflowPermission','6','readonly'),(3207,5,9,0,6,0,0,'WorkflowPermission','6','readonly'),(3208,5,1,0,6,0,0,'WorkflowPermission','6','readonly'),(3209,5,10,0,6,0,0,'WorkflowPermission','6','readonly'),(3210,5,11,0,6,0,0,'WorkflowPermission','start_date','readonly'),(3211,5,12,0,6,0,0,'WorkflowPermission','start_date','readonly'),(3212,5,7,0,6,0,0,'WorkflowPermission','start_date','readonly'),(3213,5,8,0,6,0,0,'WorkflowPermission','start_date','readonly'),(3214,5,9,0,6,0,0,'WorkflowPermission','start_date','readonly'),(3215,5,1,0,6,0,0,'WorkflowPermission','start_date','readonly'),(3216,5,10,0,6,0,0,'WorkflowPermission','start_date','readonly'),(3217,5,11,0,6,0,0,'WorkflowPermission','34','readonly'),(3218,5,12,0,6,0,0,'WorkflowPermission','34','readonly'),(3219,5,7,0,6,0,0,'WorkflowPermission','34','readonly'),(3220,5,8,0,6,0,0,'WorkflowPermission','34','readonly'),(3221,5,9,0,6,0,0,'WorkflowPermission','34','readonly'),(3222,5,1,0,6,0,0,'WorkflowPermission','34','readonly'),(3223,5,10,0,6,0,0,'WorkflowPermission','34','readonly'),(3224,5,11,0,6,0,0,'WorkflowPermission','23','readonly'),(3225,5,12,0,6,0,0,'WorkflowPermission','23','readonly'),(3226,5,7,0,6,0,0,'WorkflowPermission','23','readonly'),(3227,5,8,0,6,0,0,'WorkflowPermission','23','readonly'),(3228,5,9,0,6,0,0,'WorkflowPermission','23','readonly'),(3229,5,1,0,6,0,0,'WorkflowPermission','23','readonly'),(3230,5,10,0,6,0,0,'WorkflowPermission','23','readonly'),(3231,5,11,0,6,0,0,'WorkflowPermission','12','readonly'),(3232,5,12,0,6,0,0,'WorkflowPermission','12','readonly'),(3233,5,7,0,6,0,0,'WorkflowPermission','12','readonly'),(3234,5,8,0,6,0,0,'WorkflowPermission','12','readonly'),(3235,5,9,0,6,0,0,'WorkflowPermission','12','readonly'),(3236,5,1,0,6,0,0,'WorkflowPermission','12','readonly'),(3237,5,10,0,6,0,0,'WorkflowPermission','12','readonly'),(3238,5,11,0,6,0,0,'WorkflowPermission','7','readonly'),(3239,5,12,0,6,0,0,'WorkflowPermission','7','readonly'),(3240,5,7,0,6,0,0,'WorkflowPermission','7','readonly'),(3241,5,8,0,6,0,0,'WorkflowPermission','7','readonly'),(3242,5,9,0,6,0,0,'WorkflowPermission','7','readonly'),(3243,5,1,0,6,0,0,'WorkflowPermission','7','readonly'),(3244,5,10,0,6,0,0,'WorkflowPermission','7','readonly'),(3245,5,11,0,6,0,0,'WorkflowPermission','24','readonly'),(3246,5,12,0,6,0,0,'WorkflowPermission','24','readonly'),(3247,5,7,0,6,0,0,'WorkflowPermission','24','readonly'),(3248,5,8,0,6,0,0,'WorkflowPermission','24','readonly'),(3249,5,9,0,6,0,0,'WorkflowPermission','24','readonly'),(3250,5,1,0,6,0,0,'WorkflowPermission','24','readonly'),(3251,5,10,0,6,0,0,'WorkflowPermission','24','readonly'),(3252,5,11,0,6,0,0,'WorkflowPermission','13','readonly'),(3253,5,12,0,6,0,0,'WorkflowPermission','13','readonly'),(3254,5,7,0,6,0,0,'WorkflowPermission','13','readonly'),(3255,5,8,0,6,0,0,'WorkflowPermission','13','readonly'),(3256,5,9,0,6,0,0,'WorkflowPermission','13','readonly'),(3257,5,1,0,6,0,0,'WorkflowPermission','13','readonly'),(3258,5,10,0,6,0,0,'WorkflowPermission','13','readonly'),(3259,5,11,0,6,0,0,'WorkflowPermission','8','readonly'),(3260,5,12,0,6,0,0,'WorkflowPermission','8','readonly'),(3261,5,7,0,6,0,0,'WorkflowPermission','8','readonly'),(3262,5,8,0,6,0,0,'WorkflowPermission','8','readonly'),(3263,5,9,0,6,0,0,'WorkflowPermission','8','readonly'),(3264,5,1,0,6,0,0,'WorkflowPermission','8','readonly'),(3265,5,10,0,6,0,0,'WorkflowPermission','8','readonly'),(3266,5,11,0,6,0,0,'WorkflowPermission','priority_id','readonly'),(3267,5,12,0,6,0,0,'WorkflowPermission','priority_id','readonly'),(3268,5,7,0,6,0,0,'WorkflowPermission','priority_id','readonly'),(3269,5,8,0,6,0,0,'WorkflowPermission','priority_id','readonly'),(3270,5,9,0,6,0,0,'WorkflowPermission','priority_id','readonly'),(3271,5,1,0,6,0,0,'WorkflowPermission','priority_id','readonly'),(3272,5,10,0,6,0,0,'WorkflowPermission','priority_id','readonly'),(3273,5,11,0,6,0,0,'WorkflowPermission','25','readonly'),(3274,5,12,0,6,0,0,'WorkflowPermission','25','readonly'),(3275,5,7,0,6,0,0,'WorkflowPermission','25','readonly'),(3276,5,8,0,6,0,0,'WorkflowPermission','25','readonly'),(3277,5,9,0,6,0,0,'WorkflowPermission','25','readonly'),(3278,5,1,0,6,0,0,'WorkflowPermission','25','readonly'),(3279,5,10,0,6,0,0,'WorkflowPermission','25','readonly'),(3280,5,11,0,6,0,0,'WorkflowPermission','14','readonly'),(3281,5,12,0,6,0,0,'WorkflowPermission','14','readonly'),(3282,5,7,0,6,0,0,'WorkflowPermission','14','readonly'),(3283,5,8,0,6,0,0,'WorkflowPermission','14','readonly'),(3284,5,9,0,6,0,0,'WorkflowPermission','14','readonly'),(3285,5,1,0,6,0,0,'WorkflowPermission','14','readonly'),(3286,5,10,0,6,0,0,'WorkflowPermission','14','readonly'),(3287,5,11,0,6,0,0,'WorkflowPermission','9','readonly'),(3288,5,12,0,6,0,0,'WorkflowPermission','9','readonly'),(3289,5,7,0,6,0,0,'WorkflowPermission','9','readonly'),(3290,5,8,0,6,0,0,'WorkflowPermission','9','readonly'),(3291,5,9,0,6,0,0,'WorkflowPermission','9','readonly'),(3292,5,1,0,6,0,0,'WorkflowPermission','9','readonly'),(3293,5,10,0,6,0,0,'WorkflowPermission','9','readonly'),(3294,5,11,0,6,0,0,'WorkflowPermission','is_private','readonly'),(3295,5,12,0,6,0,0,'WorkflowPermission','is_private','readonly'),(3296,5,7,0,6,0,0,'WorkflowPermission','is_private','readonly'),(3297,5,8,0,6,0,0,'WorkflowPermission','is_private','readonly'),(3298,5,9,0,6,0,0,'WorkflowPermission','is_private','readonly'),(3299,5,1,0,6,0,0,'WorkflowPermission','is_private','readonly'),(3300,5,10,0,6,0,0,'WorkflowPermission','is_private','readonly'),(3301,5,11,0,6,0,0,'WorkflowPermission','project_id','readonly'),(3302,5,12,0,6,0,0,'WorkflowPermission','project_id','readonly'),(3303,5,7,0,6,0,0,'WorkflowPermission','project_id','readonly'),(3304,5,8,0,6,0,0,'WorkflowPermission','project_id','readonly'),(3305,5,9,0,6,0,0,'WorkflowPermission','project_id','readonly'),(3306,5,1,0,6,0,0,'WorkflowPermission','project_id','readonly'),(3307,5,10,0,6,0,0,'WorkflowPermission','project_id','readonly'),(3308,5,11,0,6,0,0,'WorkflowPermission','26','readonly'),(3309,5,12,0,6,0,0,'WorkflowPermission','26','readonly'),(3310,5,7,0,6,0,0,'WorkflowPermission','26','readonly'),(3311,5,8,0,6,0,0,'WorkflowPermission','26','readonly'),(3312,5,9,0,6,0,0,'WorkflowPermission','26','readonly'),(3313,5,1,0,6,0,0,'WorkflowPermission','26','readonly'),(3314,5,10,0,6,0,0,'WorkflowPermission','26','readonly'),(3315,5,11,0,6,0,0,'WorkflowPermission','15','readonly'),(3316,5,12,0,6,0,0,'WorkflowPermission','15','readonly'),(3317,5,7,0,6,0,0,'WorkflowPermission','15','readonly'),(3318,5,8,0,6,0,0,'WorkflowPermission','15','readonly'),(3319,5,9,0,6,0,0,'WorkflowPermission','15','readonly'),(3320,5,1,0,6,0,0,'WorkflowPermission','15','readonly'),(3321,5,10,0,6,0,0,'WorkflowPermission','15','readonly'),(3322,5,11,0,6,0,0,'WorkflowPermission','27','readonly'),(3323,5,12,0,6,0,0,'WorkflowPermission','27','readonly'),(3324,5,7,0,6,0,0,'WorkflowPermission','27','readonly'),(3325,5,8,0,6,0,0,'WorkflowPermission','27','readonly'),(3326,5,9,0,6,0,0,'WorkflowPermission','27','readonly'),(3327,5,1,0,6,0,0,'WorkflowPermission','27','readonly'),(3328,5,10,0,6,0,0,'WorkflowPermission','27','readonly'),(3329,5,11,0,6,0,0,'WorkflowPermission','16','readonly'),(3330,5,12,0,6,0,0,'WorkflowPermission','16','readonly'),(3331,5,7,0,6,0,0,'WorkflowPermission','16','readonly'),(3332,5,8,0,6,0,0,'WorkflowPermission','16','readonly'),(3333,5,9,0,6,0,0,'WorkflowPermission','16','readonly'),(3334,5,1,0,6,0,0,'WorkflowPermission','16','readonly'),(3335,5,10,0,6,0,0,'WorkflowPermission','16','readonly'),(3336,5,11,0,6,0,0,'WorkflowPermission','done_ratio','readonly'),(3337,5,12,0,6,0,0,'WorkflowPermission','done_ratio','readonly'),(3338,5,7,0,6,0,0,'WorkflowPermission','done_ratio','readonly'),(3339,5,8,0,6,0,0,'WorkflowPermission','done_ratio','readonly'),(3340,5,9,0,6,0,0,'WorkflowPermission','done_ratio','readonly'),(3341,5,1,0,6,0,0,'WorkflowPermission','done_ratio','readonly'),(3342,5,10,0,6,0,0,'WorkflowPermission','done_ratio','readonly'),(3343,5,11,0,6,0,0,'WorkflowPermission','assigned_to_id','readonly'),(3344,5,12,0,6,0,0,'WorkflowPermission','assigned_to_id','readonly'),(3345,5,7,0,6,0,0,'WorkflowPermission','assigned_to_id','readonly'),(3346,5,8,0,6,0,0,'WorkflowPermission','assigned_to_id','readonly'),(3347,5,9,0,6,0,0,'WorkflowPermission','assigned_to_id','readonly'),(3348,5,1,0,6,0,0,'WorkflowPermission','assigned_to_id','readonly'),(3349,5,10,0,6,0,0,'WorkflowPermission','assigned_to_id','readonly'),(3350,5,11,0,6,0,0,'WorkflowPermission','subject','readonly'),(3351,5,12,0,6,0,0,'WorkflowPermission','subject','readonly'),(3352,5,7,0,6,0,0,'WorkflowPermission','subject','readonly'),(3353,5,8,0,6,0,0,'WorkflowPermission','subject','readonly'),(3354,5,9,0,6,0,0,'WorkflowPermission','subject','readonly'),(3355,5,1,0,6,0,0,'WorkflowPermission','subject','readonly'),(3356,5,10,0,6,0,0,'WorkflowPermission','subject','readonly'),(3357,5,11,0,6,0,0,'WorkflowPermission','28','readonly'),(3358,5,12,0,6,0,0,'WorkflowPermission','28','readonly'),(3359,5,7,0,6,0,0,'WorkflowPermission','28','readonly'),(3360,5,8,0,6,0,0,'WorkflowPermission','28','readonly'),(3361,5,9,0,6,0,0,'WorkflowPermission','28','readonly'),(3362,5,1,0,6,0,0,'WorkflowPermission','28','readonly'),(3363,5,10,0,6,0,0,'WorkflowPermission','28','readonly'),(3364,5,11,0,6,0,0,'WorkflowPermission','17','readonly'),(3365,5,12,0,6,0,0,'WorkflowPermission','17','readonly'),(3366,5,7,0,6,0,0,'WorkflowPermission','17','readonly'),(3367,5,8,0,6,0,0,'WorkflowPermission','17','readonly'),(3368,5,9,0,6,0,0,'WorkflowPermission','17','readonly'),(3369,5,1,0,6,0,0,'WorkflowPermission','17','readonly'),(3370,5,10,0,6,0,0,'WorkflowPermission','17','readonly'),(3371,5,11,0,6,0,0,'WorkflowPermission','1','readonly'),(3372,5,12,0,6,0,0,'WorkflowPermission','1','readonly'),(3373,5,7,0,6,0,0,'WorkflowPermission','1','readonly'),(3374,5,8,0,6,0,0,'WorkflowPermission','1','readonly'),(3375,5,9,0,6,0,0,'WorkflowPermission','1','readonly'),(3376,5,1,0,6,0,0,'WorkflowPermission','1','readonly'),(3377,5,10,0,6,0,0,'WorkflowPermission','1','readonly'),(3378,5,11,0,6,0,0,'WorkflowPermission','tracker_id','readonly'),(3379,5,12,0,6,0,0,'WorkflowPermission','tracker_id','readonly'),(3380,5,7,0,6,0,0,'WorkflowPermission','tracker_id','readonly'),(3381,5,8,0,6,0,0,'WorkflowPermission','tracker_id','readonly'),(3382,5,9,0,6,0,0,'WorkflowPermission','tracker_id','readonly'),(3383,5,1,0,6,0,0,'WorkflowPermission','tracker_id','readonly'),(3384,5,10,0,6,0,0,'WorkflowPermission','tracker_id','readonly'),(3385,5,11,0,6,0,0,'WorkflowPermission','30','readonly'),(3386,5,12,0,6,0,0,'WorkflowPermission','30','readonly'),(3387,5,7,0,6,0,0,'WorkflowPermission','30','readonly'),(3388,5,8,0,6,0,0,'WorkflowPermission','30','readonly'),(3389,5,9,0,6,0,0,'WorkflowPermission','30','readonly'),(3390,5,1,0,6,0,0,'WorkflowPermission','30','readonly'),(3391,5,10,0,6,0,0,'WorkflowPermission','30','readonly'),(3392,5,11,0,6,0,0,'WorkflowPermission','29','readonly'),(3393,5,12,0,6,0,0,'WorkflowPermission','29','readonly'),(3394,5,7,0,6,0,0,'WorkflowPermission','29','readonly'),(3395,5,8,0,6,0,0,'WorkflowPermission','29','readonly'),(3396,5,9,0,6,0,0,'WorkflowPermission','29','readonly'),(3397,5,1,0,6,0,0,'WorkflowPermission','29','readonly'),(3398,5,10,0,6,0,0,'WorkflowPermission','29','readonly'),(3399,5,11,0,6,0,0,'WorkflowPermission','18','readonly'),(3400,5,12,0,6,0,0,'WorkflowPermission','18','readonly'),(3401,5,7,0,6,0,0,'WorkflowPermission','18','readonly'),(3402,5,8,0,6,0,0,'WorkflowPermission','18','readonly'),(3403,5,9,0,6,0,0,'WorkflowPermission','18','readonly'),(3404,5,1,0,6,0,0,'WorkflowPermission','18','readonly'),(3405,5,10,0,6,0,0,'WorkflowPermission','18','readonly'),(3406,5,11,0,6,0,0,'WorkflowPermission','2','readonly'),(3407,5,12,0,6,0,0,'WorkflowPermission','2','readonly'),(3408,5,7,0,6,0,0,'WorkflowPermission','2','readonly'),(3409,5,8,0,6,0,0,'WorkflowPermission','2','readonly'),(3410,5,9,0,6,0,0,'WorkflowPermission','2','readonly'),(3411,5,1,0,6,0,0,'WorkflowPermission','2','readonly'),(3412,5,10,0,6,0,0,'WorkflowPermission','2','readonly'),(3413,5,11,0,6,0,0,'WorkflowPermission','31','readonly'),(3414,5,12,0,6,0,0,'WorkflowPermission','31','readonly'),(3415,5,7,0,6,0,0,'WorkflowPermission','31','readonly'),(3416,5,8,0,6,0,0,'WorkflowPermission','31','readonly'),(3417,5,9,0,6,0,0,'WorkflowPermission','31','readonly'),(3418,5,1,0,6,0,0,'WorkflowPermission','31','readonly'),(3419,5,10,0,6,0,0,'WorkflowPermission','31','readonly'),(3420,5,11,0,6,0,0,'WorkflowPermission','20','readonly'),(3421,5,12,0,6,0,0,'WorkflowPermission','20','readonly'),(3422,5,7,0,6,0,0,'WorkflowPermission','20','readonly'),(3423,5,8,0,6,0,0,'WorkflowPermission','20','readonly'),(3424,5,9,0,6,0,0,'WorkflowPermission','20','readonly'),(3425,5,1,0,6,0,0,'WorkflowPermission','20','readonly'),(3426,5,10,0,6,0,0,'WorkflowPermission','20','readonly'),(3427,5,11,0,6,0,0,'WorkflowPermission','19','readonly'),(3428,5,12,0,6,0,0,'WorkflowPermission','19','readonly'),(3429,5,7,0,6,0,0,'WorkflowPermission','19','readonly'),(3430,5,8,0,6,0,0,'WorkflowPermission','19','readonly'),(3431,5,9,0,6,0,0,'WorkflowPermission','19','readonly'),(3432,5,1,0,6,0,0,'WorkflowPermission','19','readonly'),(3433,5,10,0,6,0,0,'WorkflowPermission','19','readonly'),(3434,5,11,0,6,0,0,'WorkflowPermission','3','readonly'),(3435,5,12,0,6,0,0,'WorkflowPermission','3','readonly'),(3436,5,7,0,6,0,0,'WorkflowPermission','3','readonly'),(3437,5,8,0,6,0,0,'WorkflowPermission','3','readonly'),(3438,5,9,0,6,0,0,'WorkflowPermission','3','readonly'),(3439,5,1,0,6,0,0,'WorkflowPermission','3','readonly'),(3440,5,10,0,6,0,0,'WorkflowPermission','3','readonly'),(3441,5,11,0,6,0,0,'WorkflowPermission','description','readonly'),(3442,5,12,0,6,0,0,'WorkflowPermission','description','readonly'),(3443,5,7,0,6,0,0,'WorkflowPermission','description','readonly'),(3444,5,8,0,6,0,0,'WorkflowPermission','description','readonly'),(3445,5,9,0,6,0,0,'WorkflowPermission','description','readonly'),(3446,5,1,0,6,0,0,'WorkflowPermission','description','readonly'),(3447,5,10,0,6,0,0,'WorkflowPermission','description','readonly'),(3448,5,11,0,6,0,0,'WorkflowPermission','32','readonly'),(3449,5,12,0,6,0,0,'WorkflowPermission','32','readonly'),(3450,5,7,0,6,0,0,'WorkflowPermission','32','readonly'),(3451,5,8,0,6,0,0,'WorkflowPermission','32','readonly'),(3452,5,9,0,6,0,0,'WorkflowPermission','32','readonly'),(3453,5,1,0,6,0,0,'WorkflowPermission','32','readonly'),(3454,5,10,0,6,0,0,'WorkflowPermission','32','readonly'),(3455,5,11,0,6,0,0,'WorkflowPermission','21','readonly'),(3456,5,12,0,6,0,0,'WorkflowPermission','21','readonly'),(3457,5,7,0,6,0,0,'WorkflowPermission','21','readonly'),(3458,5,8,0,6,0,0,'WorkflowPermission','21','readonly'),(3459,5,9,0,6,0,0,'WorkflowPermission','21','readonly'),(3460,5,1,0,6,0,0,'WorkflowPermission','21','readonly'),(3461,5,10,0,6,0,0,'WorkflowPermission','21','readonly'),(3462,5,11,0,6,0,0,'WorkflowPermission','10','readonly'),(3463,5,12,0,6,0,0,'WorkflowPermission','10','readonly'),(3464,5,7,0,6,0,0,'WorkflowPermission','10','readonly'),(3465,5,8,0,6,0,0,'WorkflowPermission','10','readonly'),(3466,5,9,0,6,0,0,'WorkflowPermission','10','readonly'),(3467,5,1,0,6,0,0,'WorkflowPermission','10','readonly'),(3468,5,10,0,6,0,0,'WorkflowPermission','10','readonly'),(3469,5,11,0,6,0,0,'WorkflowPermission','4','readonly'),(3470,5,12,0,6,0,0,'WorkflowPermission','4','readonly'),(3471,5,7,0,6,0,0,'WorkflowPermission','4','readonly'),(3472,5,8,0,6,0,0,'WorkflowPermission','4','readonly'),(3473,5,9,0,6,0,0,'WorkflowPermission','4','readonly'),(3474,5,1,0,6,0,0,'WorkflowPermission','4','readonly'),(3475,5,10,0,6,0,0,'WorkflowPermission','4','readonly'),(3476,5,11,0,6,0,0,'WorkflowPermission','5','readonly'),(3477,5,12,0,6,0,0,'WorkflowPermission','5','readonly'),(3478,5,7,0,6,0,0,'WorkflowPermission','5','readonly'),(3479,5,8,0,6,0,0,'WorkflowPermission','5','readonly'),(3480,5,9,0,6,0,0,'WorkflowPermission','5','readonly'),(3481,5,1,0,6,0,0,'WorkflowPermission','5','readonly'),(3482,5,10,0,6,0,0,'WorkflowPermission','5','readonly');
/*!40000 ALTER TABLE `workflows` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-17 14:13:28
