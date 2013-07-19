<?php

require_once('ActiveResource.php');

class Redmine extends ActiveResource {

	var $request_format = 'xml'; // REQUIRED!
	var $element_name = 'issue';
	var $extra_params = '?key=1973bf4c0323eca995db4a53896091c940a1c286';

	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		$this->site = 'http://wiz-corp.jp/redmine/';
	}
}
