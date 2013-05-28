<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

// プロファイラを有効にする
$hook['post_controller_constructor'][] = array(
	'class'    => 'General',
	'function' => 'enable_profiler',
	'filename' => 'General.php',
	'filepath' => 'hooks'
);

// どのリスティング広告から来たか
$hook['post_controller_constructor'][] = array(
	'class'    => 'General',
	'function' => 'set_cookie_where_from_ads',
	'filename' => 'General.php',
	'filepath' => 'hooks'
);

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */
