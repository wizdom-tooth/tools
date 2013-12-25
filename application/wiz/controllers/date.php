<?php

class Date extends CI_Controller_With_Auth {

	private $_db = NULL;
	private $_date = '';
	private $_wiz_month_id = '';
	private $_day_info = array();

	public function __construct()
	{
		parent::__construct();
		$this->ag_auth->restrict('manager');
		$this->load->helper('wiz');
		$this->_db = $this->load->database('wizp', TRUE);
		$this->config->load('wiz_config');

		// 日付情報取得
		$this->_date = $this->input->get('date');
        if ($this->_date === FALSE) $this->_date = date('Y-m-d');
		$this->_wiz_month_id = get_wiz_month_id($this->_date);
        $params = array(
            'wiz_month_id' => $this->_wiz_month_id,
        );
		$this->load->library('wizweek', $params);
		$this->_day_info = $this->wizweek->get_day_info($this->_date);
	}

	public function index()
	{
        $sql = "select * from addup where date = '{$this->_date}'";
        $query = $this->_db->query($sql);
        $addup_info = $query->result_array();

		// error handling
		if (empty($addup_info)) echo 'aaaaaaaaaa';

		/*
		$channel_group = $this->input->get('channel_group');
		if ($channel_group === FALSE)
		{
			$channel_group = 'total';
		}
		*/
//var_dump($this->_day_info);
//var_dump($this->_wiz_month_id);
		$data = array(
			'day_info' => $this->_day_info,
			'addup_label' => array_keys($addup_info[0]),
			'addup_info' => $addup_info,
			//'channel_group' => $channel_group,
		);
		$this->ag_auth->view('contents/date/index', $data);
	}
}
