<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 日付から半期ID取得
 */
function get_wiz_halfyear_id(&$CI, $date = '')
{
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
