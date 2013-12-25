<?php

class Date_Detail extends CI_Controller_With_Auth {

	/*
	private $_db = NULL;
	private $_wiz_month_id = NULL;
	*/

	public function __construct()
	{
		parent::__construct();
		$this->ag_auth->restrict('manager');
		$this->load->helper('wiz');
		//$this->load->helper('wiz_template');
		$this->_db = $this->load->database('wizp', TRUE);
		$this->config->load('wiz_config');
	}

	public function index()
	{
		$sql = ''.
			'SELECT '.
				'* '.
			'FROM '.
				'addup '.
			'WHERE '.
				'date = "2013-08-18"';
		$query = $this->_db->query($sql);
		$addup = $query->result_array();

		$data = array(
			'addup' => $addup,
		);
		$this->load->view('pages/contents/date_detail/index', $data);
	}
}
