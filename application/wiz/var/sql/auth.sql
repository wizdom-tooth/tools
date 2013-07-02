--
-- Table structure for table `ag_auth_groups`
--

DROP TABLE IF EXISTS `ag_auth_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ag_auth_groups` (
  `id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL DEFAULT '',
  `description` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ag_auth_groups`
--

LOCK TABLES `ag_auth_groups` WRITE;
/*!40000 ALTER TABLE `ag_auth_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `ag_auth_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ag_auth_users`
--

DROP TABLE IF EXISTS `ag_auth_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ag_auth_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '100',
  `token` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ag_auth_users`
--

LOCK TABLES `ag_auth_users` WRITE;
/*!40000 ALTER TABLE `ag_auth_users` DISABLE KEYS */;
INSERT INTO `ag_auth_users` VALUES (2,'wiz_ogawa','ogawa@wiz-g.co.jp','5b406433ad4f25a2e3360a1685c2e1f06db26728bbd3f25c121a7cf5246bc869',1,'',''),(4,'wiz_ops','ogataqu@yahoo.co.jp','5fe0a12915ef7e9a9e3c46e734d38fcc83a9bdace91527fd3351c76255d6d1e5',50,'',''),(6,'wiz_kakuda','kakuda@wiz-g.co.jp','efbb1407f20ed8d4176d49169eefe8ae1da371d77f69e2be554115658cdda339',1,'',''),(7,'wiz_kishi','kishi@wiz-g.co.jp','ce90e3552b94c8051cc828e575dc9a5dac7807509b142a1785b07552864609ed',1,'','');
