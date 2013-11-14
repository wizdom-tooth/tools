<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 日付から半期ID取得
 */
function get_wiz_halfyear_id($date = '')
{
	$CI =& get_instance();
	$db = $CI->load->database('wizp', TRUE);
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
