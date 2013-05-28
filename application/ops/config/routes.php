<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

if (isset($_SERVER['HTTP_USER_AGENT']) === FALSE)
{
	$device = 'pc';
}
else
{
	if
	(
		(strstr($_SERVER['HTTP_USER_AGENT'], 'iPhone') && !strstr($_SERVER['HTTP_USER_AGENT'], 'iPad')) ||	
		(strstr($_SERVER['HTTP_USER_AGENT'], 'Android') && strstr($_SERVER['HTTP_USER_AGENT'], 'Mobile')) ||
		strstr($_SERVER['HTTP_USER_AGENT'], 'BlackBerry')
	)
	{
		$device = 'sp';
	}
	elseif
	(
		strstr($_SERVER['HTTP_USER_AGENT'], 'DoCoMo') ||
		strstr($_SERVER['HTTP_USER_AGENT'], 'Vodafone') ||
		strstr($_SERVER['HTTP_USER_AGENT'], 'SoftBank') ||
		strstr($_SERVER['HTTP_USER_AGENT'], 'MOT-') ||
		strstr($_SERVER['HTTP_USER_AGENT'], 'J-PHONE') ||
		strstr($_SERVER['HTTP_USER_AGENT'], 'KDDI') ||
		strstr($_SERVER['HTTP_USER_AGENT'], 'UP.Browser') ||
		strstr($_SERVER['HTTP_USER_AGENT'], 'WILLCOM')
	)
	{
		$device = 'fp';
	}
	else
	{
		$device = 'pc';
	}
}

$route['default_controller'] = $device.'/top';
$route['404_override']       = '';
$route['top/(.+)']           = $device.'/top/$1';
$route['aboutus/(.+)']       = $device.'/aboutus/$1';
$route['agreement/(.+)']     = $device.'/agreement/$1';
$route['apply/(.+)']         = $device.'/apply/$1';
$route['contact/(.+)']       = $device.'/contact/$1';
$route['cron/(.+)']          = $device.'/cron/$1';
$route['esta/(.+)']          = $device.'/esta/$1';
$route['faq/(.+)']           = $device.'/faq/$1';
$route['notify/(.+)']        = $device.'/notify/$1';
$route['privacy/(.+)']       = $device.'/privacy/$1';
$route['service/(.+)']       = $device.'/service/$1';
$route['status/(.+)']        = $device.'/status/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
