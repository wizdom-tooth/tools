<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| デバイス情報
|--------------------------------------------------------------------------
*/

$CI =& get_instance();
$CI->load->library('user_agent');

if ($CI->agent->is_browser())
{
	$config['what_device_access_from'] = 'pc';
}
else if ($CI->agent->is_mobile())
{
	$config['what_device_access_from'] = 'mobile';
}
else
{
	$config['what_device_access_from'] = 'other';
}
$config['agent'] = $CI->agent->agent_string();
