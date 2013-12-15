<?php

class Yosan_Month2 extends CI_Controller_With_Auth {

	private $_db = NULL;

	public function __construct()
	{
		parent::__construct();
		$this->ag_auth->restrict('manager');
		$this->load->helper('wiz');
		$this->load->helper('wiz_template');
		$this->_db = $this->load->database('wizp', TRUE);
		$this->config->load('wiz_config');
		$this->load->library('yosanmonth');
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
		if ($this->input->get_post('wiz_month_id') === FALSE)
		{
			$wiz_month_id = get_wiz_month_id();
		}
		else
		{
			$wiz_month_id = $this->input->get_post('wiz_month_id');
		}

        // 対象チャネル整理
		$channel = $this->input->get_post('_channel');
		if ($channel === FALSE)
		{
			$channel = 'realestate_east';
		}

		// --------------------
		// 対象期間情報取得
		// --------------------

		$yosan_week_infos = array();
		$w_infos = get_wiz_week_infos_from_wiz_month_id($wiz_month_id);
		if ($w_infos === FALSE)
		{
			// do error handling ********
		}

		$yosan_week_infos = array();
		foreach ($w_infos as $w_info)
		{
			$wiz_week_id = $w_info['wiz_week_id'];
			$from_date = $w_info['from_date'];
			$to_date = $w_info['to_date'];

			list($from_year, $from_month, $from_day) = explode('-', $from_date);
			$target_date_timestamp = mktime(0, 0, 0, $from_month, $from_day, $from_year);
			$target_date = date('Y-m-d', $target_date_timestamp);
			$target_date_weekday = date('D', $target_date_timestamp);

			do {
				$yosan_week_infos[$wiz_week_id][$target_date_weekday] = $target_date;

				$target_date_timestamp = strtotime('+1 day', $target_date_timestamp);
				$target_date = date('Y-m-d', $target_date_timestamp);
				$target_date_weekday = date('D', $target_date_timestamp);
			}
			while ($target_date <= $to_date);
		}

		// --------------------
		// 予算情報を書き出す
		// --------------------

/*
$post = $this->input->post();
//var_dump($post);
if ($post !== FALSE)
{
	$written_infos = array();
	foreach ($post as $key => $val)
	{
		if ( ! preg_match('/^_/', $key))
		{
			list($kind, $name_and_id) = explode('___', $key);
			preg_match('/^(.*)_(\d)$/', $name_and_id, $matches);
			$name = $matches[1];
			$wiz_month_id = $m_infos[$matches[2]]['wiz_month_id'];
			$written_infos[$wiz_month_id][$kind][$name] = $val;
		}
	}
	//var_dump($written_infos);
	foreach ($written_infos as $wiz_month_id => $written_info)
	{
		$serialize_targets = array(
			'introduction_count',
			'flets_isp_set_ratio',
			'flets_option_set_ratio',
			'iten_contract_count',
			'iten_isp_set_ratio',
			'other_contract_ratio',
			'other_complete_ratio',
		);
		foreach ($serialize_targets as $target)
		{
			$variable_name = $target.'_complex';
			${$variable_name} = serialize($written_info[$target]);
		}
		$sql = ''.
			'replace into yosan_month values ('.
				"'{$channel}', ".
				"'{$wiz_month_id}', ".
				"'{$introduction_count_complex}', ".
				"'".$written_info['flets_contract_ratio']['contract_ratio']."', ".
				"'".$written_info['flets_contract_ratio']['complete_ratio']."', ".
				"'{$flets_isp_set_ratio_complex}', ".
				"'{$flets_option_set_ratio_complex}', ".
				"'{$iten_contract_count_complex}', ".
				"'{$iten_isp_set_ratio_complex}', ".
				"'{$other_contract_ratio_complex}', ".
				"'{$other_complete_ratio_complex}', ".
				"'".$written_info['onlyisp_contract_ratio']['contract_ratio']."', ".
				"'".$written_info['onlyisp_contract_ratio']['complete_ratio']."', ".
				"'".$written_info['benefit_contract_ratio']['contract_ratio']."', ".
				"'".$written_info['benefit_contract_ratio']['complete_ratio']."'".
			')';
		$this->_db->query($sql);
		if (is error)
		{
			// do error handling
		}
	}
}
*/

		// 対象月の予算情報を取り出す
		$yosan_month_info = get_yosan_month_info($channel, $wiz_month_id);
		$this->yosanmonth->init($yosan_month_info);
		$introduction_info = $this->yosanmonth->get('introduction_info');
		$sum_count_introduction = $this->yosanmonth->get('sum_introduction');
		$flets_contract_count = $this->yosanmonth->get('flets_contract_count');
		$flets_complete_count = $this->yosanmonth->get('flets_complete_count');
		$flets_isp_set_count_info = $this->yosanmonth->get('flets_isp_set_count_info');
		$flets_option_set_count_info = $this->yosanmonth->get('flets_option_set_count_info');
		$sum_iten_contract_count = $this->yosanmonth->get('sum_iten_contract_count');
		$sum_iten_isp_set_count = $this->yosanmonth->get('sum_iten_isp_set_count');


/*
var_dump($sum_iten_contract_count);
var_dump($sum_iten_isp_set_count);

var_dump($flets_contract_count);
var_dump($flets_complete_count);
var_dump($introduction_info);
var_dump($sum_count_introduction);
*/

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
*/

//var_dump($yosan_week_infos);

		list($year, $month) = sscanf($wiz_month_id, '%4d%2d');

		$data = array(
			//'halfyear_info' => get_wiz_halfyear_info($halfyear),
			'yosan_week_infos' => $yosan_week_infos,
			'year' => $year,
			'month' => $month,
			//'yosan_month_info_for_sum' => get_yosan_month_info($channel, 'empty'),
			//'channel' => $channel,
			//'month' => $month,
			//'calendar' => $calendar,
            //'form_year' => $this->config->item('form_year'),
            //'form_month' => $this->config->item('form_month'),
            //'form_channel' => $this->config->item('form_channel'),
		);
		$this->ag_auth->view('contents/yosan_month2/index', $data);
	}
}
