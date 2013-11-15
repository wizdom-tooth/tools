<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function load_database_wizp()
{
	$CI =& get_instance();
	$CI->config->load('wiz_config');
	return $CI->load->database('wizp', TRUE);
}

/**
 * 日付から半期ID取得
 */
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

/**
 * 半期IDから月ID配列を取り出す
 */
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

/**
 * wiz_quarter_id から情報取得
 */
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

/**
 * チャンネルと月IDから月次予算情報を取り出す
 */
function get_yosan_month_info($channel, $wiz_month_id)
{
	$empty_serialize = serialize('');
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
		return $query->result_array();
	}
}

/**
 * 予算対象情報PHPシリアライズを取得する
 */
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
	return serialize($tmp);
}
