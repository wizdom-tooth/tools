<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * キャッシュ処理
 *
 * @access public
 * @param object
 *
 */
function mycache(&$CI, $minutes = 99999)
{
	if (ENVIRONMENT === 'production')
	{
		$CI->output->cache($minutes);
	}
}

/**
 * お申し込みID作成
 *
 * @access public
 * @param array
 * @return string
 *
 */
function get_esta_app_id($app_values)
{
	$app_id_key = $app_values['app_date']
	            . $app_values['lastname']
	            . $app_values['firstname']
	            . $app_values['passport_number'];
	$app_id = 'a' . md5($app_id_key);
	return $app_id;
}

/**
 * ユーザーID作成
 *
 * @access public
 * @param array
 * @return string
 *
 */
function get_esta_app_user_id($app_values)
{
	$app_user_id_key = $app_values['lastname']
	                 . $app_values['firstname']
	                 . $app_values['passport_number'];
	$app_user_id = 'u' . md5($app_user_id_key);
	return $app_user_id;
}

/**
 * 日本語曜日取得
 *
 * @access public
 * @param string
 * @return string
 *
 */
function get_mb_week($timestamp = '')
{
	$mb_weeks = array(
		0 => '日',
		1 => '月',
		2 => '火',
		3 => '水',
		4 => '木',
		5 => '金',
		6 => '土',
	);

	if ($timestamp === '')
	{
		$week = date('w');
	}
	else
	{
		$week = date('w', $timestamp);
	}
	return $mb_weeks[$week];
}

