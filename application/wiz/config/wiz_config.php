<?php

// --------------------------------------------------------------------------
// チャンネル配列 
// --------------------------------------------------------------------------

$channel_configs = array(
	'able_and_realestate' => array(
		'name'                  => 'エイブル＆不動産',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => '',
		'channel_list' => array(
			'エイブル',
			'エイブル西',
			'ハウパ',
			'ハウス・トゥ',
			'既存店',
			'ミニミニ西日本',
			'既存店(西)',
		),
	),
	'realestate' => array(
		'name'                  => '不動産(東西)',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => '',
		'channel_list' => array(
			'ハウパ',
			'ハウス・トゥ',
			'既存店',
			'ミニミニ西日本',
			'既存店(西)',
		),
	),
	'realestate_east' => array(
		'name'                  => '不動産(東)',
		'is_target_yosan'       => TRUE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => 'east_or_west = "東"',
		'channel_list' => array(
			'ハウパ',
			'ハウス・トゥ',
			'既存店',
		),
	),
	'realestate_west' => array(
		'name'                  => '不動産(西)',
		'is_target_yosan'       => TRUE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => 'east_or_west = "西"',
		'channel_list' => array(
            'ミニミニ西日本',
            '既存店(西)',
		),
	),
	'able' => array(
		'name'                  => 'エイブル(東西)',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => '',
		'channel_list' => array(
			'エイブル',
			'エイブル西',
		),
	),
	'able_east' => array(
		'name'                  => 'エイブル(東)',
		'is_target_yosan'       => TRUE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => 'east_or_west = "東"',
		'channel_list' => array(
			'エイブル',
		),
	),
	'able_west' => array(
		'name'                  => 'エイブル(西)',
		'is_target_yosan'       => TRUE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => 'east_or_west = "西"',
		'channel_list' => array(
			'エイブル西',
		),
	),
	'ablehikkoshi' => array(
		'name'                  => 'エイブル引越(東西)',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => '',
		'channel_list' => array(
			'エイブル引越',
		),
	),
	'ablehikkoshi_east' => array(
		'name'                  => 'エイブル引越(東)',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => 'east_or_west = "東"',
		'channel_list' => array(
			'エイブル引越',
		),
	),
	'ablehikkoshi_west' => array(
		'name'                  => 'エイブル引越(西)',
		'east_or_west'          => '西',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => 'east_or_west = "西"',
		'channel_list' => array(
			'エイブル引越',
		),
	),
	'aeras' => array(
		'name'                  => 'アエラス',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => 'store_name like "アエラス%"',
		'channel_list' => array(
			'既存店',
		),
	),
	'his' => array(
		'name'                  => 'HIS(東西)',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => 'store_name like "アエラス%"',
		'channel_list' => array(
			'HIS',
		),
	),
	'his_east' => array(
		'name'                  => 'HIS(東)',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => 'east_or_west = "東"',
		'channel_list' => array(
			'HIS',
		),
	),
	'his_west' => array(
		'name'                  => 'HIS(西)',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => 'east_or_west = "西"',
		'channel_list' => array(
			'HIS',
		),
	),
	'house2house' => array(
		'name'                  => 'ハウス・トゥ',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => '',
		'channel_list' => array(
			'ハウス・トゥ',
		),
	),
	'housepartner' => array(
		'name'                  => 'ハウパ',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => '',
		'channel_list' => array(
			'ハウパ',
		),
	),
	'nissei' => array(
		'name'                  => '日本生命(東西)',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => '',
		'channel_list' => array(
			'日本生命',
		),
	),
	'nissei_east' => array(
		'name'                  => '日本生命(東)',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'east_or_west = "東"',
		'channel_list' => array(
			'日本生命',
		),
	),
	'nissei_west' => array(
		'name'                  => '日本生命(西)',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'east_or_west = "西"',
		'channel_list' => array(
			'日本生命',
		),
	),
	'ponta' => array(
		'name'                  => 'ポンタ(東西)',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => '',
		'channel_list' => array(
			'Ponta',
		),
	),
	'ponta_east' => array(
		'name'                  => 'ポンタ(東)',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => 'east_or_west = "東"',
		'channel_list' => array(
			'Ponta',
		),
	),
	'ponta_west' => array(
		'name'                  => 'ポンタ(西)',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => 'east_or_west = "西"',
		'channel_list' => array(
			'Ponta',
		),
	),
	'prime' => array(
		'name'                  => 'プライム',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => 'store_name like "プライム%"',
		'channel_list' => array(
			'既存店',
		),
	),
	'soleil' => array(
		'name'                  => 'ソレイユ',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => 'store_name like "ソレイユ%"',
		'channel_list' => array(
			'既存店',
		),
	),
	'univ' => array(
		'name'                  => '大学(東西)',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => TRUE,
		'sql_option'            => '',
		'channel_list' => array(
			'大学東',
			'大学西',
		),
	),
	'univ_east' => array(
		'name'                  => '大学(東)',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'east_or_west = "東"',
		'channel_list' => array(
			'大学東',
		),
	),
	'univ_west' => array(
		'name'                  => '大学(西)',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'east_or_west = "西"',
		'channel_list' => array(
			'大学西',
		),
	),
);

// --------------------------------------------------------------------------
// 種別配列 
// --------------------------------------------------------------------------

$kind_configs = array(
	'flets' => array(
		'name'                  => 'フレッツ光',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'service = "フレッツ光"',
	),
	'without_flets' => array(
		'name'                  => 'フレッツ光以外',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'service != "フレッツ光',
	),
	'isp_total' => array(
		'name'                  => 'ISP - 合計',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'isp in ("OCN", "OCN(2年割)", "OCN(安心パック)", "YAHOO", "BIGLOBE")',
	),
	'isp_biglobe' => array(
		'name'                  => 'ISP - BIGLOBE',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'isp = "BIGLOBE"',
	),
	'isp_ocn' => array(
		'name'                  => 'ISP - OCN',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'isp in ("OCN", "OCN(2年割)", "OCN(安心パック)")',
	),
	'isp_yahoo' => array(
		'name'                  => 'ISP - YAHOO',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'isp = "YAHOO"',
	),
	'iten' => array(
		'name'                  => '移転',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'service like "%移転%"',
	),
	'iten_with_isp' => array(
		'name'                  => '移転＆ISP',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'service like "%移転%" and isp in ("OCN", "OCN(2年割)", "OCN(安心パ>ック)", "YAHOO", "BIGLOBE")',
	),
	'only_isp' => array(
		'name'                  => 'ISPのみ',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'service not like "%移転%" and isp in ("OCN", "OCN(2年割)", "OCN(安心パッ
ク)", "YAHOO", "BIGLOBE")',
	),
	'hikari_tel_total' => array(
		'name'                  => 'ひかり電話 - 合計',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'hikari_tel not in ("", "無", "無し", "未入力")',
	),
	'hikari_tel_plan_base' => array(
		'name'                  => 'ひかり電話 - 基本プラン',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'hikari_tel like "%基本%"',
	),
	'hikari_tel_plan_anshin' => array(
		'name'                  => 'ひかり電話 - 安心',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'hikari_tel like "%安心%"',
	),
	'hikari_tel_plan_anshin_more' => array(
		'name'                  => 'ひかり電話 - もっと安心',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'hikari_tel like "%安心%"',
	),
	'hikari_tel_plan_a' => array(
		'name'                  => 'ひかり電話 - エース',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'hikari_tel like "%エース%"',
	),
	'option_virus' => array(
		'name'                  => 'オプション - ウィルス',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'virus not in ("", "未入力", "客意NG", "ウィルス無")',
	),
	'option_remote' => array(
		'name'                  => 'オプション - リモート',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'remote not in ("", "未入力", "客意NG", "リモート無")',
	),
	'option_hikari_tv_pa' => array(
		'name'                  => 'オプション - ひかりTVパ',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'hikari_tv not in ("", "未入力", "不可", "客意NG")',
	),
	'option_hikari_tv' => array(
		'name'                  => 'オプション - ひかりTV',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'hikari_tv not in ("", "未入力", "不可", "客意NG")',
	),
	'option_hikari_portable' => array(
		'name'                  => 'オプション - ひかりポータブル',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'router = "光ポータブル"',
	),
	'e_hikari_fiber_kddi' => array(
		'name'                  => '光ファイバ - KDDI',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'service = "AUひかり"',
	),
	'e_hikari_fiber_ucom' => array(
		'name'                  => '光ファイバ - UCOM',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'service = "UCOM"',
	),
	'mobile_adsl_emobile' => array(
		'name'                  => 'モバイルADSL - EMOBILE',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'service = "イーモバイル"',
	),
	'mobile_adsl_eaccess' => array(
		'name'                  => 'モバイルADSL - イーアクセス',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'service = "SO-NETイー・アクセス"',
	),
	'mobile_adsl_yahoobb' => array(
		'name'                  => 'モバイルADSL - YAHOOBB',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'service = "YAHOOBB"',
	),
	'catv_itiscom' => array(
		'name'                  => 'CATV - イッツコム',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'service = "イッツコミュニケーションズ"',
	),
	'catv_jcnyokohama' => array(
		'name'                  => 'CATV - JCNよこはま',
		'is_target_yosan'       => FALSE,
		'is_target_daily_addup' => FALSE,
		'sql_option'            => 'service = "イッツコミュニケーションズ"',
	),
);

$channel_names_for_daily_addup = array();
//$tbl_addup_sqls_with_channel = array();
//$tbl_yosan_sqls_with_channel = array();

foreach ($channel_configs as $channel_name => $config)
{
	if ($config['is_target_daily_addup'] === TRUE)
	{
		$channel_names_for_daily_addup[] = $channel_name;
	}
	/*
	$tbl_addup_sqls_with_channel[$channel] = $info['tbl_addup_sql'];
	$tbl_yosan_sqls_with_channel[$channel] = $info['tbl_yosan_sql'];
	*/
}

$config['channel_configs'] = $channel_configs;
$config['channel_names_for_daily_addup'] = $channel_names_for_daily_addup;
//$config['tbl_addup_sqls_with_channel'] = $tbl_addup_sqls_with_channel;
//$config['tbl_yosan_sqls_with_channel'] = $tbl_yosan_sqls_with_channel;

/*
$config['addup_kinds'] = array(
	'total',
	'complete',
	'flets',
	'other',
	'isp_total',
	'isp_biglobe',
	'isp_ocn',
	'isp_yahoo',
	'iten',
	'iten_with_isp',
	'only_isp',
	'hikari_tel_total',
	'hikari_tel_plan_base',
	'hikari_tel_plan_anshin',
	'hikari_tel_plan_anshin_more',
	'hikari_tel_plan_a',
	'option_virus',
	'option_remote',
	'option_hikari_tv_pa',
	'option_hikari_tv',
	'option_hikari_portable',
	'e_hikari_fiber_kddi',
	'e_hikari_fiber_ucom',
	'mobile_adsl_emobile',
	'mobile_adsl_eaccess',
	'mobile_adsl_yahoobb',
	'catv_itiscom',
	'catv_jcnyokohama',
);
*/

// --------------------------------------------------------------------------
// 時間帯配列 
// --------------------------------------------------------------------------

$config['time_zones'] = array(
	'A(10-12)',
	'B(12-14)',
	'C(14-16)',
	'D(16-18)',
	'E(18-20)',
	'F(20-LAST)',
);

// --------------------------------------------------------------------------
// 予算化対象情報マスタ
// --------------------------------------------------------------------------

// フレッツ＆ISP
$config['yosan_flets_isps'] = array(
	'OCN_2年割',
	'OCN_2年割無',
	'BIGLOBE',
);

// フレッツオプション
$config['yosan_flets_options'] = array(
	'ウィルス',
	'リモート',
	'ひ電_基本',
	'ひ電_安心',
	'ひ電_エース',
	'ひ電_もっと安心',
	'光ポータブル',
	'ひかりTVパ',
);

// 移転回線
$config['yosan_iten_lines'] = array(
	'フレッツ光',
);

// 移転 - フレッツISP
$config['yosan_iten_flets_isps'] = array(
	'ISP合計',
);

// その他回線
$config['yosan_other_lines'] = array(
	'auひかり',
	'UCOM',
	'イーモバ',
	'イーアクセス',
	'イッツコム',
	'JCNよこはま',
);
