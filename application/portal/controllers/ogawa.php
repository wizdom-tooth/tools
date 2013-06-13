<?php

class Ogawa extends CI_Controller_With_Auth {

    public function __construct()
    {
		parent::__construct();
		$this->ag_auth->restrict('employee');
    }

	public function index()
	{
		$this->ag_auth->view('contents/ogawa/index');
	}
}
