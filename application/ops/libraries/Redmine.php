<?php

require_once('ActiveResource.php');

class Redmine extends ActiveResource {

	var $request_format = 'xml'; // REQUIRED!
	var $element_name = 'issue';
	var $extra_params = '?key=5378f40c6b498a4e0f642fd37ec81a7b373bea2f';

	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		$this->site = 'https://'.IPADDRESS.'/redmines/esta_onlinecenter/';
	}
}
