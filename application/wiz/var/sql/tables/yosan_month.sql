--
-- Table structure for table `yosan_month`
--

DROP TABLE IF EXISTS `yosan_month`;
CREATE TABLE `yosan_month` (
	`channel`                        varchar(50) NOT NULL,
	`wiz_month_id`                   varchar(6)  NOT NULL,
	`introduction_count_complex`     text        NOT NULL,
	`flets_contract_ratio`           float(3,1)  NOT NULL DEFAULT 0.0,
	`flets_complete_ratio`           float(3,1)  NOT NULL DEFAULT 0.0,
	`flets_isp_set_ratio_complex`    text        NOT NULL,
	`flets_option_set_ratio_complex` text        NOT NULL,
	`iten_contract_count_complex`    text        NOT NULL,
	`iten_isp_set_ratio_complex`     text        NOT NULL,
	`other_contract_ratio_complex`   text        NOT NULL,
	`other_complete_ratio_complex`   text        NOT NULL,
	`onlyisp_contract_ratio`         float(3,1)  NOT NULL,
	`onlyisp_complete_ratio`         float(3,1)  NOT NULL,
	`benefit_contract_ratio`         float(3,1)  NOT NULL DEFAULT 0.0,
	`benefit_complete_ratio`         float(3,1)  NOT NULL DEFAULT 0.0,
	PRIMARY KEY (`channel`, `wiz_month_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;
