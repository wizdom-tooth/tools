<?php

class Yosan_Halfyear extends CI_Controller_With_Auth {

	private $_db = NULL;

	public function __construct()
	{
		parent::__construct();
		$this->ag_auth->restrict('manager');
		$this->load->helper('wiz');
		$this->_db = $this->load->database('wizp', TRUE);
		$this->config->load('wiz_config');
		/*
		$this->config->load('wiz_form');
        $this->config->load('input_yosan_calendar');
        $this->load->library('calendar', $this->config->item('calendar_prefs'));
		//$this->load->library('form_validation');
		$this->load->helper('form');
		*/
	}

	public function index()
	{
        // 対象半期整理
		if ($this->input->get_post('halfyear') === FALSE)
		{
			$halfyear = get_wiz_halfyear_id();
		}
		else
		{
			$halfyear = $this->input->get_post('halfyear');
		}

        // 対象チャネル整理
		$channel = $this->input->get_post('channel');
		if ($channel === FALSE)
		{
			$channel = 'realestate_east';
		}

		$_GET['halfyear'] = $_POST['halfyear'] = $halfyear;
		$_GET['channel']  = $_POST['channel']  = $channel;

		// --------------------
		// 半期分の予算情報を取り出す
		// --------------------

		$yosan_month_infos = array();
		$m_infos = get_wiz_month_infos_from_wiz_halfyear_id($halfyear);
		if ($m_infos === FALSE)
		{
			// do error handling ********
		}
		foreach ($m_infos as $m_info)
		{
			$q_info = get_wiz_quarter_info($m_info['wiz_quarter_id']);
			$yosan_month_info = get_yosan_month_info($channel, $m_info['wiz_month_id']);
			$yosan_month_infos[$q_info['quarter_name']][] = $yosan_month_info;
		}

		/*
		$channel_configs = $this->config->item('channel_configs');
		$channels_include = $channel_configs[$channel]['channel_list'];
		*/

/*
var_dump($halfyear);
var_dump($target_monthes);
*/

/*
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
					$yosan_kind_ids = array('i', 'a', 'b', 'c', 'd', 'e', 'f');
					foreach ($yosan_kind_ids as $yosan_kind_id)
					{
						switch ($yosan_kind_id)
						{
							case 'i':
								$yosan_kind = '紹介予算';
								$count = $req_input_data["y_{$d}_i"];
								break;
							case 'a':
								$yosan_kind = 'A(10-12)';
								$count = $req_input_data["y_{$d}_a"];
								break;
							case 'b':
								$yosan_kind = 'B(12-14)';
								$count = $req_input_data["y_{$d}_b"];
								break;
							case 'c':
								$yosan_kind = 'C(14-16)';
								$count = $req_input_data["y_{$d}_c"];
								break;
							case 'd':
								$yosan_kind = 'D(16-18)';
								$count = $req_input_data["y_{$d}_d"];
								break;
							case 'e':
								$yosan_kind = 'E(18-20)';
								$count = $req_input_data["y_{$d}_e"];
								break;
							case 'f':
								$yosan_kind = 'F(20-LAST)';
								$count = $req_input_data["y_{$d}_f"];
								break;
						}

						$sql = ''.
							'replace into yosan '.
								'('.
									'channel, '.
									'date, '.
									'yosan_kind, '.
									'count '.
								') '.
							'values '.
								'('.
									"'{$channel}', ".
									"'{$y}-{$m}-${d}', ".
									"'{$yosan_kind}', ".
									"{$count} ".
								')';
						$this->_db_wizp->query($sql);
						//var_dump($sql);
						// エラー処理 ****************************************
						// do anything
					}
				}
			}
		}

        // ------------------------------------
        // 予算情報を取り出す
        // ------------------------------------

        $sql = ''.
            'select '.
                'DATE_FORMAT(date, "%e") as day '.
            'from '.
                'yosan '.
            'where '.
                $cond.' '.
            'order by '.
                'day';

        $query = $this->_db_wizp->query($sql);
        $days = $query->result_array();

		$yosan_datas = array();
		foreach ($days as $tmp)
		{
			$counts = array();
			$day = $tmp['day'];
			$d = sprintf('%02d', $day);
			$yosan_kinds = array(
				'i' => '紹介予算',
				'a' => 'A(10-12)',
				'b' => 'B(12-14)',
				'c' => 'C(14-16)',
				'd' => 'D(16-18)',
				'e' => 'E(18-20)',
				'f' => 'F(20-LAST)',
			);
			foreach ($yosan_kinds as $yosan_kind_id => $yosan_kind_val)
			{
				$sql = ''.
					'select '.
						'count '.
					'from '.
						'yosan '.
					'where '.
						"date = '{$y}-{$m}-{$d}' and ".
						"channel = '{$channel}' and ".
						"yosan_kind = '${yosan_kind_val}'";
				$query = $this->_db_wizp->query($sql);
				$row = $query->row();
				$counts[$yosan_kind_id] = $row->count;
			}
			$yosan_datas[$day] = array(
				'day' => $day,
				'i'   => $counts['i'],
				'a'   => $counts['a'],
				'b'   => $counts['b'],
				'c'   => $counts['c'],
				'd'   => $counts['d'],
				'e'   => $counts['e'],
				'f'   => $counts['f'],
			);
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
		*/

		$data = array(
			'halfyear' => $halfyear,
			'yosan_month_infos' => $yosan_month_infos,
			//'month' => $month,
			//'calendar' => $calendar,
			'channel' => $channel,
            //'form_year' => $this->config->item('form_year'),
            //'form_month' => $this->config->item('form_month'),
            //'form_channel' => $this->config->item('form_channel'),
		);
		$this->ag_auth->view('contents/yosan_halfyear/index', $data);
	}
}
