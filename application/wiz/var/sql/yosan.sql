--
-- Table structure for table `yosan`
--

DROP TABLE IF EXISTS `yosan`;
CREATE TABLE `yosan` (
  `channel` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `yosan_introduction` integer(10) NOT NULL DEFAULT 0,
  `yosan_contraction_a` integer(10) NOT NULL DEFAULT 0,
  `yosan_contraction_b` integer(10) NOT NULL DEFAULT 0,
  `yosan_contraction_c` integer(10) NOT NULL DEFAULT 0,
  `yosan_contraction_d` integer(10) NOT NULL DEFAULT 0,
  `yosan_contraction_e` integer(10) NOT NULL DEFAULT 0,
  `yosan_contraction_f` integer(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`channel`, `date`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;
