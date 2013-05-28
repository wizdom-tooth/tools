<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class General
{
	public function enable_profiler()
	{
		if (ENVIRONMENT === 'development')
		{
			$CI = &get_instance();
			$CI->output->enable_profiler(TRUE);
		}
	}

	public function set_cookie_where_from_ads()
	{
		$CI = &get_instance();
		$CI->load->library('user_agent');
		$CI->load->library('session');

		if ($CI->agent->is_referral())
		{
			if (ENVIRONMENT === 'development')
			{
				switch ($CI->agent->referrer())
				{
					case 'http://133.242.135.174/referer_google.html':
						$ad = 'google';
						break;
					case 'http://133.242.135.174/referer_yahoo.html':
						$ad = 'yahoo';
						break;
					default:
						$ad = 'other';
						break;
				}
			}
			else if (ENVIRONMENT === 'production')
			{
				$ref_host = parse_url($CI->agent->referrer(), PHP_URL_HOST);
				switch ($ref_host)
				{
					case 'www.google.com':
						$ad = 'google';
						break;
					case 'search.yahoo.co.jp':
						$ad = 'yahoo';
						break;
					default:
						$ad = 'other';
						break;
				}
			}
			if ($ad === 'other')
			{
				if ($CI->session->userdata('ad') === FALSE) $CI->session->set_userdata('ad', 'other');
			}
			else
			{
				$CI->session->set_userdata('ad', $ad);
			}
		}
		else
		{
			if ($CI->session->userdata('ad') === FALSE) $CI->session->set_userdata('ad', 'other');
		}
	}
}
