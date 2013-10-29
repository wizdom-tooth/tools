#!/usr/bin/php
<?php

$MYSQL_CLI =
	"echo '%%%SQL%%%' | /usr/bin/mysql -uroot -ponetop0721 wiz_planners";
$DROP_VIEW_SQL =
	"DROP VIEW IF EXISTS addup_daily_contraction_%%%CHANNEL%%%;";
$CREATE_VIEW_SQL =
	'CREATE VIEW addup_daily_contraction_%%%CHANNEL%%% AS '.
		'select '.
			'contract_date, '.
			'time_zone, '.
			'sum(status="契約" and service not like "%移転%" and benefit in ("特典なし", "")) as contract_total, '.
			'sum(status="契約" and service="フレッツ光") as contract_flets, '.
			'sum(isp!="未入力") as isp, '.
			'sum(virus!="未入力") as virus, '.
			'sum(remote!="未入力") as remote, '.
			'sum(hikari_tv="案内了承") as hikari_tv_pa, '.
			'sum(hikari_tv like "%プラン%") as hikari_tv, '.
			'sum(hikari_tel!="未入力") as hikari_tel, '.
			'"-" as ng '.
		'from '.
			'addup '.
		'where '.
			'contract_date != "" and '.
			'%%%WHERE%%% '.
		'group by '.
			'contract_date, '.
			'time_zone;';

$channels = array(
	'able_and_realestate' => 'channel in("エイブル", "エイブル西", "ハウパ", "ハウス・トゥ", "既存店", "ミニミニ西日本", "既存店(西)")',
	'able_east' => 'channel = "エイブル"',
	'able_west' => 'channel = "エイブル西"',
	'realestate_east' => 'channel in("ハウパ", "ハウス・トゥ", "既存店")',
	'realestate_west' => 'channel in("ミニミニ西日本", "既存店(西)")',
	'aeras' => 'store_name = "アエラス%"',
	'soleil' => 'store_name = "ソレイユ%"',
	'prime' => 'store_name = "プライム%"',
	'housepartner' => 'channel = "ハウパ"',
	'house2house' => 'channel = "ハウス・トゥ"',
	'ablehikkoshi_east' => 'channel = "エイブル引越" and east_or_west = "東"',
	'ablehikkoshi_west' => 'channel = "エイブル引越" and east_or_west = "西"',
	'ponta_east' => 'channel = "Ponta" and east_or_west = "東"',
	'ponta_west' => 'channel = "Ponta" and east_or_west = "西"',
	'his_east' => 'channel = "HIS" and east_or_west = "東"',
	'his_west' => 'channel = "HIS" and east_or_west = "西"',
	'nissei' => 'channel = "日本生命"',
	'univ' => 'channel = "大学東" or channel = "大学西"',
	'isp' => 'status = "オプション契約"',
	'iten' => 'service in("フレッツ光移転(東京・千葉)", "フレッツ光(移転)")',
	'fletsclub_iten' => 'service = "フレッツ光移転(その他)"',
	'ocn_upsell' => 'channel = "hogehoge!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!保留"',
	'benefit' => 'benefit not in("特典なし", "")',
);

foreach ($channels as $channel => $where)
{
	// DROP VIEW
	$dv_sql = $DROP_VIEW_SQL;
	$dv_sql = str_replace('%%%CHANNEL%%%', $channel, $dv_sql);
	$cli = str_replace('%%%SQL%%%', $dv_sql, $MYSQL_CLI);
	exec($cli);
	//echo $cli."\n\n";

	// CREAETE VIEW
	$cv_sql = $CREATE_VIEW_SQL;
	$cv_sql = str_replace('%%%CHANNEL%%%', $channel, $cv_sql);
	$cv_sql = str_replace('%%%WHERE%%%', $where, $cv_sql);
	$cli = str_replace('%%%SQL%%%', $cv_sql, $MYSQL_CLI);
	exec($cli);
	//echo $cli."\n\n";
}

exit;
