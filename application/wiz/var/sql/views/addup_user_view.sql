--
-- view `addup_user`
--

DROP VIEW IF EXISTS `addup_user`;
CREATE VIEW addup_user AS 
	select 
		date, 
		user_name, 
		time_zone, 
		sum(status="契約" and service not like "%移転%" and benefit in ("特典なし", "")) as contract_total 
	from 
		addup 
	where
		user_name != '' 
	group by 
		date, 
		user_name,
		time_zone;
