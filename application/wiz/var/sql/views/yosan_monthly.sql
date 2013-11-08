--
-- view `yosan_monthly`
--

DROP VIEW IF EXISTS `yosan_monthly`;
CREATE VIEW yosan_monthly AS 
	select 
		channel,
		DATE_FORMAT(date, "%Y%m") as month, 
		yosan_kind,
		sum(count) as count 
	from 
		yosan
	group by 
		channel, 
		DATE_FORMAT(date, "%Y%m"),
		yosan_kind;
