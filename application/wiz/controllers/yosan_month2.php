<?php

class Yosan_Month2 extends CI_Controller_With_Auth {

    private $_intro_count = 0;
    private $_contract_count = array();

	private $_db = NULL;
	private $_wiz_month_id = NULL;

	public function __construct()
	{
		parent::__construct();
		$this->ag_auth->restrict('manager');
		$this->load->helper('wiz');
		$this->load->helper('wiz_template');
		$this->_db = $this->load->database('wizp', TRUE);
		$this->config->load('wiz_config');

        // 対象月整理
		$this->_wiz_month_id = $this->input->get('wiz_month_id');
		if ($this->_wiz_month_id === FALSE) {
			$this->_wiz_month_id = get_wiz_month_id();
		}
		$this->load->library('wizweek', array('wiz_month_id' => $this->_wiz_month_id));

        // 予算情報取得
        // ******************************** 専用のクラスを作る
        // 日付係数をかける
        $this->_contract_count = array(
            'flets'     => 200,
            'au_hikari' => 350,
            'ucom'      => 150,
            'emobile'   => 40,
        );
        $this->_intro_count = 3000;

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
		$yosan_addup  = 0;
		$result_addup = 0;

		// 実績情報取り出す
		$result_info = array();
		$sql = ''.
			'select '.
				'date, '.
				'count(*) as result '.
			'from '.
				'addup '.
			'where '.
				"wiz_month_id = '{$this->_wiz_month_id}' and ".
				//"status like '%契約%'".
				'contract_date != "0000-00-00" '.
			'group by '.
				'date '.
			'order by '.
				'date';
        $query = $this->_db->query($sql);
        $tmp = $query->result_array();
		foreach ($tmp as $info) 
		{
			$result_info[$info['date']] = (int)$info['result'];
		}

		// 予実情報を日付情報配列に追加
		$contract_count = (int)array_sum($this->_contract_count);
		$week_days_info = $this->wizweek->get_week_days_info();
		foreach ($week_days_info as $wiz_week_id => $week_info)
		{
			foreach ($week_info as $weekday => $day_info)
			{
				$result = $result_info[$day_info['date']];
				$result_addup += (int)$result;
				$yosan = round($contract_count * $day_info['weight']);
				$yosan_addup += (int)$yosan;

				$week_days_info[$wiz_week_id][$weekday]['yosan']        = $yosan;
				$week_days_info[$wiz_week_id][$weekday]['yosan_addup']  = $yosan_addup;
				$week_days_info[$wiz_week_id][$weekday]['result']       = $result;
				$week_days_info[$wiz_week_id][$weekday]['result_addup'] = $result_addup;
			}
		}

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
                "wiz_month_id = '{$this->_wiz_month_id}'";
        $query = $this->_db->query($sql);
        $addup_info = $query->result_array();

        // 対象チャネル整理
		/*
		$channel = $this->input->get_post('_channel');
		if ($channel === FALSE)
		{
			$channel = 'realestate_east';
		}
		*/

		// --------------------
		// 対象期間情報取得
		// --------------------

/*
		$yosan_week_infos = array();
		$w_infos = get_wiz_week_infos_from_wiz_month_id($this->_wiz_month_id);
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
*/

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
		/*
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
		*/


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

		list($year, $month) = sscanf($this->_wiz_month_id, '%4d%2d');

		$data = array(
			//'halfyear_info' => get_wiz_halfyear_info($halfyear),
            'yosan_intro_count'    => $this->_intro_count,
            'yosan_contract_count' => $this->_contract_count,
			'week_days_info'       => $week_days_info,
			'year'                 => $year,
			'month'                => $month,
            'addup_label'          => array_keys($addup_info[0]),
            'addup_info'           => $addup_info,
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
