--
-- view `yosan_monthly`
--

DROP VIEW IF EXISTS `yosan_monthly`;
CREATE VIEW yosan_monthly AS 
	select 
		channel,
		DATE_FORMAT(date, "%Y%m") as month, 
		sum(yosan_introduction) as yosan_introduction, 
		sum(yosan_contraction_a) as yosan_contraction_a, 
		sum(yosan_contraction_b) as yosan_contraction_b, 
		sum(yosan_contraction_c) as yosan_contraction_c, 
		sum(yosan_contraction_d) as yosan_contraction_d, 
		sum(yosan_contraction_e) as yosan_contraction_e, 
		sum(yosan_contraction_f) as yosan_contraction_f
	from 
		yosan
	group by 
		channel, 
		DATE_FORMAT(date, "%Y%m");
