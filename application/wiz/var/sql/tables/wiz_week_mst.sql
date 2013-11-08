--
-- Table structure for table `wiz_week`
--

DROP TABLE IF EXISTS `wiz_week_mst`;
CREATE TABLE `wiz_week_mst` (
  `wiz_week_id` varchar(8) NOT NULL,
  `from_date`    date NOT NULL,
  `to_date`      date NOT NULL,
  PRIMARY KEY (`wiz_week_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;
