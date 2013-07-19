<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Error {
 
	public function __construct()
	{
		set_error_handler(array(&$this, 'handler')); 
	}
 
	public function handler($errno, $errstr, $errfile, $errline)
	{
		$CI =& get_instance();
		$CI->load->library('email');
		$CI->load->helper('text');

		$subject = ENV_LABEL.'[ERROR] '.character_limiter($errstr, 45, '...');
		$message = ''.
			ENV_LABEL.'エラーを検知しました。'."\n".
			'hostname: '.HOSTNAME."\n".
			'ipaddress: '.IPADDRESS."\n".
			'errno: '.$errno."\n".
			'errfile: '.$errfile."\n".
			'errline: '.$errline."\n".
			'errstr: '.$errstr."\n";

		$CI->email->to($CI->config->item('my_mail_address'));
		$CI->email->from($CI->config->item('my_mail_address'));
		$CI->email->subject($subject);
		$CI->email->message($message);

		switch ($errno) {
			case E_USER_ERROR:
			case E_USER_WARNING:
			case E_USER_NOTICE:
			default:
				$CI->email->send();
				log_message('error', $message);
				show_error('system error.');
				break;
		}
	}
}
