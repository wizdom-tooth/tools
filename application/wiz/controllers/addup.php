<?php

class Addup extends CI_Controller_With_Auth {

	public function __construct()
	{
		parent::__construct();
		$this->ag_auth->restrict('admin');
		$this->db_wizp = $this->load->database('wizp', TRUE);
		$this->config->load('admin_calendar');
		$this->load->library('calendar', $this->config->item('calendar_prefs'));
	}

	public function index($year = '', $month = '', $day = '')
	{
		// SQLの条件指定文作成
		if ($year !== '' && $month !== '' && $day !== '')
		{
			$y = sprintf('%04d', $year);
			$m = sprintf('%02d', $month);
			$d = sprintf('%02d', $day);
			$cond = "date = '{$year}-{$month}-{$day}'";
		}
		elseif ($year !== '' && $month !== '' && $day === '')
		{
			$y = sprintf('%04d', $year);
			$m = sprintf('%02d', $month);
			$d = '01';
			$cond = "date like '{$year}-{$month}-%'";
		}
		elseif ($year !== '' && ($month === '' || $day === ''))
		{
			$y = sprintf('%04d', $year);
			$m = '01';
			$d = '01';
			$cond = "date like '{$year}-%'";
		}
		else
		{
			$y = $year = date('Y');
			$m = $month = date('m');
			$d = $day = date('d');
			$cond = "date = '{$y}-{$m}-{$d}'";
		}

		// 集計
		$sum = array();
		$channels = array(
			'able',
			'able_east',
			'able_west',
		);
		foreach ($channels as $channel)
		{
			$sql = ''.
				'select '.
					'* '.
				'from '.
					"addup_${channel} ".
				'where '.
					$cond.' '.
				'order by '.
					'date asc, time_zone asc';

			$query = $this->db_wizp->query($sql);
			$sum[$channel] = $query->result_array();
		}

		// カレンダー
		$calendar_links = array();
		for ($i = 1; $i <= date('t', strtotime($y.$m.$d)); $i++)
		{
			if ($day === '' || $i !== (int)$d)
			{
				$calendar_links[$i] = base_url('addup/index/'.$y.'/'.$m.'/'.sprintf('%02d', $i).'/');
			}
		}
		$calendar = $this->calendar->generate($y, $m, $calendar_links);

		// 出力
		$data = array(
			'year' => $year,
			'month' => $month,
			'day' => $day,
			'calendar' => $calendar,
			'sum' => $sum,
		);
		$this->ag_auth->view('contents/addup/index', $data);
	}
}
