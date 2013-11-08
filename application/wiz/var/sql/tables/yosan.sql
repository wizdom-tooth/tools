--
-- Table structure for table `yosan`
--

DROP TABLE IF EXISTS `yosan`;
CREATE TABLE `yosan` (
  `channel` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `yosan_kind` varchar(50) NOT NULL, 
  `count` integer(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`channel`, `date`, `yosan_kind`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;
