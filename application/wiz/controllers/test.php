<?php

class Test extends CI_Controller_With_Auth {

	private $_db = NULL;

	public function __construct()
	{
		parent::__construct();
		$this->ag_auth->restrict('manager');
		$this->_db = $this->load->database('wizp', TRUE);
	}

	public function index()
	{
		// 日毎の照会件数
		$sql = 'select date, count(*) as count from addup group by date order by date';
		$query = $this->_db->query($sql);
		$intro_counts_by_date = $query->result_array();

		// 祝日マスタ
		$sql = 'select date, name from holiday_mst order by date';
		$query = $this->_db->query($sql);
		$holidays = $query->result_array();

		$intro_counts_by_weekday = array(
			'Mon' => 0,
			'Tue' => 0,
			'Wed' => 0,
			'Thu' => 0,
			'Fri' => 0,
			'Sat' => 0,
			'Sun' => 0,
		);
		foreach ($intro_counts_by_date as $intro_counts)
		{
			$weekday = date('D', strtotime($intro_counts['date']));
			$intro_counts_by_weekday[$weekday] += $intro_counts['count'];
		}
		$base_count = min($intro_counts_by_weekday);

		$weekday_weights = array();
		foreach ($intro_counts_by_weekday as $weekday => $count)
		{
			$weekday_weights[$weekday] = round($count / $base_count, 3);
		}
		var_dump($weekday_weights);

		/*
		$data = array(
		);
		$this->ag_auth->view('contents/yosan_month2/index', $data);
		*/
	}
}
