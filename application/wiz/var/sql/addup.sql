--
-- Table structure for table `addup`
--

DROP TABLE IF EXISTS `addup`;
CREATE TABLE `addup` (
  `id` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `time_zone` varchar(100) NOT NULL,
  `store_id` varchar(100) NOT NULL,
  `store_name` varchar(100) NOT NULL,
  `channel` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `pref` varchar(100) NOT NULL,
  `east_or_west` varchar(10) NOT NULL,
  `status` varchar(100) NOT NULL,
  `contract_time_zone` varchar(100),
  `service` varchar(100),
  `hikari` varchar(100) NOT NULL,
  `isp` varchar(100) NOT NULL,
  `hikari_tel` varchar(100) NOT NULL,
  `virus` varchar(100) NOT NULL,
  `remote` varchar(100) NOT NULL,
  `router` varchar(100),
  `contract_date` varchar(100),
  `commufa` varchar(100),
  `benefit` varchar(100),
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;
