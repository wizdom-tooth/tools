--
-- Table structure for table `wiz_month`
--

DROP TABLE IF EXISTS `wiz_month_mst`;
CREATE TABLE `wiz_month_mst` (
  `wiz_month_id` varchar(6) NOT NULL,
  `from_date`    date NOT NULL,
  `to_date`      date NOT NULL,
  PRIMARY KEY (`wiz_month_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;
