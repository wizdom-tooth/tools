--
-- Table structure for table `time_zone_mst`
--

DROP TABLE IF EXISTS `time_zone_mst`;
CREATE TABLE `time_zone_mst` (
  `time_zone` varchar(30) NOT NULL,
  PRIMARY KEY (`time_zone`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;
