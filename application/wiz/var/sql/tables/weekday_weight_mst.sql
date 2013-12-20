--
-- Table structure for table `weekday_weight_mst`
--

DROP TABLE IF EXISTS `weekday_weight_mst`;
CREATE TABLE `weekday_weight_mst` (
  `weekday` varchar(10) NOT NULL,
  `weight` float NOT NULL,
  PRIMARY KEY (`weekday`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;
