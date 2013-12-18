<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
function load_database_wizp()
{
	$CI =& get_instance();
	$CI->config->load('wiz_config');
	return $CI->load->database('wizp', TRUE);
}
*/

/**
 * 日付から半期ID取得
 */
/*
function get_wiz_halfyear_id($date = '')
{
	$db = load_database_wizp();
	if ($date === '')
	{
		$date = date('Y-m-d');
	}
	$sql = ''.
		'SELECT '.
			'wiz_halfyear_id '.
		'FROM '.
			'wiz_month_mst '.
		'WHERE '.
			"from_date <= '{$date}' AND ".
			"to_date >= '{$date}'";
	$query = $db->query($sql);
	$row = $query->row();
	return $row->wiz_halfyear_id;
}
*/

/**
 * 日付から月ID取得
 */
/*
function get_wiz_month_id($date = '')
{
	$db = load_database_wizp();
	if ($date === '')
	{
		$date = date('Y-m-d');
	}
	$sql = ''.
		'SELECT '.
			'wiz_month_id '.
		'FROM '.
			'wiz_month_mst '.
		'WHERE '.
			"from_date <= '{$date}' AND ".
			"to_date >= '{$date}'";
	$query = $db->query($sql);
	if ($query->num_rows() === 0)
	{
		return FALSE;
	}
	else
	{
		$row = $query->row();
		return $row->wiz_month_id;
	}
}
*/

/**
 * 半期IDから月情報配列を取り出す
 */
/*
function get_wiz_month_infos_from_wiz_halfyear_id($wiz_halfyear_id)
{
	$db = load_database_wizp();
	$sql = ''.
		'SELECT '.
			'* '.
		'FROM '.
			'wiz_month_mst '.
		'WHERE '.
			"wiz_halfyear_id = '{$wiz_halfyear_id}'".
		'ORDER BY '.
			'wiz_month_id';
	$query = $db->query($sql);
	if ($query->num_rows() === 0)
	{
		return FALSE;
	}
	else
	{
		return $query->result_array();
	}
}
*/

/**
 * 月IDから週情報配列を取り出す
 */
function get_wiz_week_infos_from_wiz_month_id($wiz_month_id)
{
	// -------------------- 
	// 仮>>>設定情報取り出し 
	// -------------------- 

	$month_count = '1000'; 
	$weekday_weights = array( 
		'Mon' => '1', 
		'Tue' => '1', 
		'Wed' => '1', 
		'Thu' => '1', 
		'Fri' => '1.5', 
		'Sat' => '2', 
		'Sun' => '2', 
	); 
	// <<<仮

	// --------------------
	// wiz週情報をDBから取得
	// --------------------

	$db = load_database_wizp();
	$sql = ''.
		'SELECT '.
			'* '.
		'FROM '.
			'wiz_week_mst '.
		'WHERE '.
			"wiz_month_id = '{$wiz_month_id}'".
		'ORDER BY '.
			'wiz_week_id';
	$query = $db->query($sql);
	if ($query->num_rows() !== 1) return FALSE;
	$w_infos = $query->result_array();

	// --------------------
	// 1) 週ごとに配列を整理、日付毎の情報を付与する
	// --------------------

	$yosan_week_infos = array();
	foreach ($w_infos as $w_info)
	{
		$wiz_week_id = $w_info['wiz_week_id'];
		$cur_date    = $w_info['from_date'];
		$to_date     = $w_info['to_date'];

		list($cur_year, $cur_month, $cur_day) = explode('-', $cur_date);
		$cur_date_timestamp = mktime(0, 0, 0, $cur_month, $cur_day, $cur_year);
		$cur_date_weekday = date('D', $cur_date_timestamp);

		do {
			// ex) $yosan_week_infos['201312_1']['Mon']['date'] = '2013-12-18';
			$yosan_week_infos[$wiz_week_id][$cur_date_weekday]['date'] = $cur_date;
			// 日付を1日進める
			$cur_date_timestamp = strtotime('+1 day', $cur_date_timestamp);
			$cur_date = date('Y-m-d', $cur_date_timestamp);
			$cur_date_weekday = date('D', $cur_date_timestamp);
		}
		while ($cur_date <= $to_date);
	}

	// --------------------
	// 2) 週ごとの重みを計算
	// --------------------

	$yosan_week_weights = array();
	foreach ($yosan_week_infos as $wiz_week_id => $day_infos)
	{
		$yosan_week_weights[$wiz_week_id] = 0;
		foreach (array_keys($day_infos) as $weekday)
		{
			$yosan_week_weights[$wiz_week_id] += $weekday_weights[$weekday];
		}
	}

	// --------------------
	// 3) 週ごとの重みを計算
	// --------------------

	$month_mother_int = array_sum($yosan_week_weights);
	foreach ($yosan_week_weights as $wiz_week_id => $month_child_int)
	{
		$week_count = $month_count * $month_child_int / $month_mother_int;
		$week_mother_count = '0';
		// 分母の計算
		foreach (array_keys($yosan_week_infos[$wiz_week_id]) as $weekday)
		{
			$week_mother_count += $weekday_weights[$weekday];
		}
		// 当該日の数値を計算
		foreach (array_keys($yosan_week_infos[$wiz_week_id]) as $weekday)
		{
			$yosan_week_infos[$wiz_week_id][$weekday]['count'] = round($week_count * $weekday_weights[$weekday] / $week_mother_count, 2);
		}
	}

}

/**
 * wiz_halfyear_id から情報取得
 */
/*
function get_wiz_halfyear_info($wiz_halfyear_id)
{
	list($year, $halfyear_kind) = explode('_', $wiz_halfyear_id);
	switch ($halfyear_kind)
	{
		case '1':
			$halfyear_name = '上半期';
			break;
		case '2':
			$halfyear_name = '下半期';
			break;
	}
	$halfyear_info = array(
		'wiz_halfyear_id' => $wiz_halfyear_id,
		'year'            => $year,
		'halfyear_kind'   => $halfyear_kind,
		'halfyear_name'   => $halfyear_name,
	);
	return $halfyear_info;
}
*/

/**
 * wiz_quarter_id から情報取得
 */
/*
function get_wiz_quarter_info($wiz_quarter_id)
{
	list($year, $quarter_num) = explode('_', $wiz_quarter_id);
	$quarter_info = array(
		'wiz_quarter_id' => $wiz_quarter_id,
		'year'           => $year,
		'quarter_kind'   => $quarter_num,
		'quarter_name'   => $quarter_num.'Q',
	);
	return $quarter_info;
}
*/

/**
 * wiz_month_id から情報取得
 */
/*
function get_wiz_month_info($wiz_month_id)
{
	$db = load_database_wizp();
	$sql = ''.
		'SELECT '.
			'* '.
		'FROM '.
			'wiz_month_mst '.
		'WHERE '.
			"wiz_month_id = '{$wiz_month_id}'".
		'ORDER BY '.
			'wiz_month_id';
	$query = $db->query($sql);
	if ($query->num_rows() === 0)
	{
		return FALSE;
	}
	else
	{
		return $query->row_array();
	}
}
*/

/**
 * チャンネルと月IDから月次予算情報を取り出す
 */
/*
function get_yosan_month_info($channel, $wiz_month_id = 'empty')
{
	$template_yosan_month_info = array(
		'channel'                        => $channel,
		'wiz_month_id'                   => $wiz_month_id,
		'introduction_count_complex'     => get_yosan_default_complex($channel, 0),
		'flets_contract_ratio'           => 0.0,
		'flets_complete_ratio'           => 0.0,
		'flets_isp_set_ratio_complex'    => get_yosan_default_complex('flets_isps', 0.0),
		'flets_option_set_ratio_complex' => get_yosan_default_complex('flets_options', 0.0),
		'iten_contract_count_complex'    => get_yosan_default_complex('iten_lines', 0),
		'iten_isp_set_ratio_complex'     => get_yosan_default_complex('iten_flets_isps', 0.0),
		'other_contract_ratio_complex'   => get_yosan_default_complex('other_lines', 0.0),
		'other_complete_ratio_complex'   => get_yosan_default_complex('other_lines', 0.0),
		'onlyisp_contract_ratio'         => 0.0,
		'onlyisp_complete_ratio'         => 0.0,
		'benefit_contract_ratio'         => 0.0,
		'benefit_complete_ratio'         => 0.0,
	);
	if ($wiz_month_id === 'empty')
	{
		return $template_yosan_month_info;
	}
	$select_fields = array_keys($template_yosan_month_info);
	$select_fields_str = implode(',', $select_fields);

	$db = load_database_wizp();
	$sql = ''.
		'SELECT '.
			"{$select_fields_str} ".
		'FROM '.
			'yosan_month '.
		'WHERE '.
			"channel = '{$channel}' AND ".
			"wiz_month_id = '{$wiz_month_id}' ".
		'ORDER BY '.
			'wiz_month_id';
	$query = $db->query($sql);
	if ($query->num_rows() === 0)
	{
		return $template_yosan_month_info;
	}
	else
	{
		return $query->row_array();
	}
}
*/

/**
 * 予算対象情報PHPシリアライズを取得する
 */
/*
function get_yosan_default_complex($kind, $default_val)
{
	$CI =& get_instance();
    $CI->config->load('wiz_config');

	$yosan_target_elements = array();
	switch ($kind)
	{
		case 'realestate_east':
		case 'realestate_west':
			$channel_configs = $CI->config->item('channel_configs');
			$yosan_target_elements = $channel_configs[$kind]['channel_list'];
			break;
		case 'able_east':
		case 'able_west':
			break;
		case 'flets_isps':
		case 'flets_options':
		case 'iten_lines':
		case 'iten_flets_isps':
		case 'other_lines':
			$yosan_target_elements = $CI->config->item("yosan_{$kind}");
			break;
		default:
			return FALSE;
	}
	if ($yosan_target_elements === FALSE)
	{
		// do error handling
	}

	$tmp = array();
	foreach ($yosan_target_elements as $element)
	{
		$tmp[$element] = $default_val;
	}
	//var_dump(serialize($tmp));
	return serialize($tmp);
}
*/
