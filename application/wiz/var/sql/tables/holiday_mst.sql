--
-- Table structure for table `holiday_mst`
--

DROP TABLE IF EXISTS `holiday_mst`;
CREATE TABLE `holiday_mst` (
  `date` date NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`date`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;
