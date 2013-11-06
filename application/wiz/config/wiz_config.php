<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| チャンネル配列 
|--------------------------------------------------------------------------
*/

$channel_sqls = array(
	'able_and_realestate' => array(
		'target_daily_addup' => TRUE,
		'tbl_addup_sql'      => 'channel in ("エイブル", "エイブル西", "ハウパ", "ハウス・トゥ", "既存店", "ミニミニ西日本", "既存店(西)")',
		'tbl_yosan_sql'      => 'channel in ("realestate_east", "realestate_west", "able_east", "able_west")',
	),
	'able_east' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => 'channel = "エイブル"',
        'tbl_yosan_sql'      => 'channel = "able_east"',
    ),
	'able_west' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => 'channel = "エイブル西"',
        'tbl_yosan_sql'      => 'channel = "able_west"',
    ),
	'realestate' => array(
		'target_daily_addup' => FALSE,
        'tbl_addup_sql'      => 'channel in ("ハウパ", "ハウス・トゥ", "既存店", "ミニミニ西日本", "既存店(西)")',
        'tbl_yosan_sql'      => 'channel in ("realestate_east", "realestate_west")',
    ),
	'realestate_east' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => 'channel in ("ハウパ", "ハウス・トゥ", "既存店")',
        'tbl_yosan_sql'      => 'channel = "realestate_east"',
    ),
	'realestate_west' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => 'channel in ("ミニミニ西日本", "既存店(西)")',
        'tbl_yosan_sql'      => 'channel = "realestate_west"',
    ),
	'ablehikkoshi_east' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => '',
        'tbl_yosan_sql'      => '',
    ),
	'ablehikkoshi_west' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => '',
        'tbl_yosan_sql'      => '',
    ),
	'aeras' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => '',
        'tbl_yosan_sql'      => '',
    ),
	'his' => array(
		'target_daily_addup' => FALSE,
        'tbl_addup_sql'      => 'channel = "HIS"',
        'tbl_yosan_sql'      => '',
    ),
	'his_east' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => 'channel = "HIS" and east_or_west = "東"',
        'tbl_yosan_sql'      => '',
    ),
	'his_west' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => 'channel = "HIS" and east_or_west = "西"',
        'tbl_yosan_sql'      => '',
    ),
	'house2house' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => '',
        'tbl_yosan_sql'      => '',
    ),
	'housepartner' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => '',
        'tbl_yosan_sql'      => '',
    ),
	'nissei' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => 'channel = "日本生命"',
        'tbl_yosan_sql'      => '',
    ),
	'nissei_east' => array(
		'target_daily_addup' => FALSE,
        'tbl_addup_sql'      => 'channel = "日本生命" and east_or_west = "東"',
        'tbl_yosan_sql'      => '',
    ),
	'nissei_west' => array(
		'target_daily_addup' => FALSE,
        'tbl_addup_sql'      => 'channel = "日本生命" and east_or_west = "西"',
        'tbl_yosan_sql'      => '',
    ),
	'ponta' => array(
		'target_daily_addup' => FALSE,
        'tbl_addup_sql'      => 'channel = "Ponta"',
        'tbl_yosan_sql'      => '',
    ),
	'ponta_east' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => 'channel = "Ponta" and east_or_west = "東"',
        'tbl_yosan_sql'      => '',
    ),
	'ponta_west' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => 'channel = "Ponta" and east_or_west = "西"',
        'tbl_yosan_sql'      => '',
    ),
	'prime' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => '',
        'tbl_yosan_sql'      => '',
    ),
	'soleil' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => '',
        'tbl_yosan_sql'      => '',
    ),
	'univ' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => 'channel in ("大学東", "大学西")',
        'tbl_yosan_sql'      => '',
    ),
	'univ_east' => array(
		'target_daily_addup' => FALSE,
        'tbl_addup_sql'      => 'channel = "大学東"',
        'tbl_yosan_sql'      => '',
    ),
	'univ_west' => array(
		'target_daily_addup' => FALSE,
        'tbl_addup_sql'      => 'channel = "大学西"',
        'tbl_yosan_sql'      => '',
    ),
	'isp' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => '',
        'tbl_yosan_sql'      => '',
    ),
	'iten' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => '',
        'tbl_yosan_sql'      => '',
    ),
	'fletsclub_iten' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => '',
        'tbl_yosan_sql'      => '',
    ),
	'ocn_upsell' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => '',
        'tbl_yosan_sql'      => '',
    ),
	'benefit' => array(
		'target_daily_addup' => TRUE,
        'tbl_addup_sql'      => '',
        'tbl_yosan_sql'      => '',
    ),
);

$daily_addup_channels = array();
$tbl_addup_sqls_with_channel = array();
$tbl_yosan_sqls_with_channel = array();

foreach ($channel_sqls as $channel => $info)
{
	if ($info['target_daily_addup']) $daily_addup_channels[] = $channel;
	$tbl_addup_sqls_with_channel[$channel] = $info['tbl_addup_sql'];
	$tbl_yosan_sqls_with_channel[$channel] = $info['tbl_yosan_sql'];
}

$config['daily_addup_channels']        = $daily_addup_channels;
$config['tbl_addup_sqls_with_channel'] = $tbl_addup_sqls_with_channel;
$config['tbl_yosan_sqls_with_channel'] = $tbl_yosan_sqls_with_channel;

/*
|--------------------------------------------------------------------------
| 時間帯配列 
|--------------------------------------------------------------------------
*/

$config['time_zones'] = array(
	'A(10-12)',
	'B(12-14)',
	'C(14-16)',
	'D(16-18)',
	'E(18-20)',
	'F(20-LAST)',
);
