<?php

class Date extends CI_Controller_With_Auth {

	private $_intro_count = 0;
	private $_contract_count = array();

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

		// 予算情報取得
		// ******************************** 専用のクラスを作る
		// 日付係数をかける
		$contract_ratio = array(
			'flets'     => 400,
			'au_hikari' => 550,
			'ucom'      => 350,
			'emobile'   => 240,
		);
		$this->_intro_count = 4400 * $this->_day_info['weight'];
		foreach ($contract_ratio as $key => $val)
		{
			$this->_contract_count[$key] = $val * $this->_day_info['weight'];
		}
	}

	public function index()
	{
        $sql = ''.
			'select '.
				'id, '.
				'date, '.
				'time_zone, '.
				'store_id, '.
				'store_name, '.
				'channel, '.
				'area, '.
				'pref, '.
				'east_or_west, '.
				'status, '.
				'contract_time_zone, '.
				'service, '.
				'hikari, '.
				'isp, '.
				'hikari_tel, '.
				'virus, '.
				'remote, '.
				'router, '.
				'replace(contract_date, "0000-00-00", "") as contract_date, '.
				'user_name, '.
				'hikari_tv, '.
				'benefit, '.
				'replace(complete_date, "0000-00-00", "") as complete_date '.
			'from '.
				'addup '.
			'where '.
				"date = '{$this->_date}'";
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
//var_dump($this->_intro_count);
//var_dump($this->_contract_count);
		$data = array(
			'day_info'             => $this->_day_info,
			'addup_label'          => array_keys($addup_info[0]),
			'addup_info'           => $addup_info,
			'yosan_intro_count'    => $this->_intro_count,
			'yosan_contract_count' => $this->_contract_count,
			//'channel_group' => $channel_group,
		);
		$this->ag_auth->view('contents/date/index', $data);
	}
}
