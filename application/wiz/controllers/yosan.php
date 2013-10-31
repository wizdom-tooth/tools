<?php

class Yosan extends CI_Controller_With_Auth {

	private $_db_wizp = NULL;

	public function __construct()
	{
		parent::__construct();
		$this->ag_auth->restrict('manager');
		$this->config->load('wiz_form');
        $this->config->load('input_yosan_calendar');
        $this->load->library('calendar', $this->config->item('calendar_prefs'));
		//$this->load->library('form_validation');
		$this->load->helper('form');
		$this->_db_wizp = $this->load->database('wizp', TRUE);
	}

	public function index()
	{
        // 対象年月整理
        $year  = ($this->input->get_post('year') === FALSE) ? date('Y') : $this->input->get_post('year');
		$month = ($this->input->get_post('month') === FALSE) ? date('m') : $this->input->get_post('month');

		$_GET['year']  = $_POST['year']  = $year;
		$_GET['month'] = $_POST['month'] = $month;

        $y = sprintf('%04d', $year);
        $m = sprintf('%02d', $month);

        // 対象チャネル整理
		$channel = ($this->input->get_post('channel') === FALSE) ? 'realestate_east' : $this->input->get_post('channel');
		$_GET['channel'] = $_POST['channel'] = $channel;

        // 条件指定SQL WHERE句作成
        $cond = "date like '{$y}-{$m}-%' and channel = '{$channel}'";

        // ------------------------------------
        // DBに予算情報を入力する 
        // ------------------------------------

		if ($this->input->post('action') === 'input')
		{
			$req_input_data = $this->input->post();

			// 予算データが入力されていたら妥当性を確認してDBに入力 *******************************
			for ($d = 1; $d <= 31; $d++)
			{
				if (isset($req_input_data["y_{$d}_i"]) === TRUE)
				{
					$sql = ''.
						'replace into yosan '.
							'('.
								'channel, '.
								'date, '.
								'yosan_introduction, '.
								'yosan_contraction_a, '.
								'yosan_contraction_b, '.
								'yosan_contraction_c, '.
								'yosan_contraction_d, '.
								'yosan_contraction_e, '.
								'yosan_contraction_f '.
							') '.
						'values '.
							'('.
								"'{$channel}', ".
								"'{$y}-{$m}-${d}', ".
								"{$req_input_data["y_{$d}_i"]}, ".
								"{$req_input_data["y_{$d}_a"]}, ".
								"{$req_input_data["y_{$d}_b"]}, ".
								"{$req_input_data["y_{$d}_c"]}, ".
								"{$req_input_data["y_{$d}_d"]}, ".
								"{$req_input_data["y_{$d}_e"]}, ".
								"{$req_input_data["y_{$d}_f"]} ".
							')';
					$this->_db_wizp->query($sql);
					//var_dump($sql);
					// エラー処理 ****************************************_
					// do anything
				}
			}
		}

        // ------------------------------------
        // 予算情報を取り出す
        // ------------------------------------

        $sql = ''.
            'select '.
                'channel, '.
                'DATE_FORMAT(date, "%e") as day, '.
                'yosan_introduction, '.
                'yosan_contraction_a, '.
                'yosan_contraction_b, '.
                'yosan_contraction_c, '.
                'yosan_contraction_d, '.
                'yosan_contraction_e, '.
                'yosan_contraction_f '.
            'from '.
                'yosan '.
            'where '.
                $cond.' '.
            'order by '.
                'day';

        $query = $this->_db_wizp->query($sql);
        $tmp = $query->result_array();

		$yosan_datas = array();
		foreach ($tmp as $yosan_data)
		{
			$yosan_datas[$yosan_data['day']] = $yosan_data;
		}

        // ------------------------------------
        // カレンダー
        // ------------------------------------

        $calendar_contents = array();
		foreach ($yosan_datas as $day => $yosan_data)
        {
			$calendar_contents[$day] = $this->load->view('pages/components/calendar/input_yosan', $yosan_data, TRUE);
        }
        $calendar = $this->calendar->generate($year, $month, $calendar_contents);

		$data = array(
			'year' => $year,
			'month' => $month,
			'calendar' => $calendar,
			'channel' => $channel,
            'form_year' => $this->config->item('form_year'),
            'form_month' => $this->config->item('form_month'),
            'form_channel' => $this->config->item('form_channel'),
		);
		$this->ag_auth->view('contents/yosan/index', $data);
	}
}
