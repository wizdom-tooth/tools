--
-- Table structure for table `wiz_week`
--

DROP TABLE IF EXISTS `wiz_week_mst`;
CREATE TABLE `wiz_week_mst` (
  `wiz_week_id` varchar(8) NOT NULL,
  `wiz_halfyear_id` varchar(6) NOT NULL,
  `wiz_quarter_id` varchar(6) NOT NULL,
  `wiz_month_id` varchar(6) NOT NULL,
  `from_date`    date NOT NULL,
  `to_date`      date NOT NULL,
  PRIMARY KEY (`wiz_week_id`),
  KEY (`wiz_halfyear_id`),
  KEY (`wiz_quarter_id`),
  KEY (`wiz_month_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;
