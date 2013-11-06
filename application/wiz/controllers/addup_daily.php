<?php

class Addup_Daily extends CI_Controller_With_Auth {

	CONST BASEURL = 'addup_daily/index';

	private $_db_wizp              = NULL;
	private $_daily_addup_channels = array();
	private $_time_zones           = array();

	public function __construct()
	{
		parent::__construct();
		$this->ag_auth->restrict('manager');
		$this->config->load('admin_calendar');
		$this->config->load('wiz_config');
		$this->load->library('calendar', $this->config->item('calendar_prefs'));
		$this->_db_wizp = $this->load->database('wizp', TRUE);
		$this->_daily_addup_channels = $this->config->item('daily_addup_channels');
		$this->_time_zones = $this->config->item('time_zones');
	}

	public function index($y = '', $m = '', $d = '')
	{
		// 取得対象日付作成
		if ($y === '' || $m === '' || $d === '')
		{
			$y  = date('Y');
			$m  = date('m');
			$d  = date('d');
		}
		$date = "{$y}-{$m}-{$d}";

		// カレンダー作成
		$target_ym_is_current_ym = ("$y$m" === date('Ym')) ? TRUE : FALSE;
		$last_day_of_the_month = date('t', strtotime($date));
		$today = date('j');

		$cal_data = array();
		for ($i = 1; $i <= $last_day_of_the_month; $i++)
		{
			if ($i > $today && $target_ym_is_current_ym) break;
			$url = self::BASEURL.'/'.$y.'/'.$m.'/'.sprintf('%02d', $i).'/';
			$cal_data[$i] = base_url($url);
		}
		$calendar = $this->calendar->generate($y, $m, $cal_data);

		// 担当者別集計
		$sql = "SELECT DISTINCT user_name FROM addup_user WHERE date = '{$date}'"; // 担当者一覧
		$query = $this->_db_wizp->query($sql);
		$users = $query->result_array();

		$sql = "SELECT * FROM addup_user WHERE date = '{$date}' ORDER BY time_zone"; // 担当者毎の集計
		$query = $this->_db_wizp->query($sql);
		$sum_user = $query->result_array();

		// ------------------------------------
		// チャンネル別集計
		// ------------------------------------

		$sum = array();

		// 予算情報を配列に展開
		$sql = ''.
			'SELECT '.
				'channel, '.
				'yosan_kind, '.
				'IFNULL(SUM(count), "0") AS count '.
			'FROM '.
				'yosan '.
			'WHERE '.
				"date = '${date}' ".
			'GROUP BY '.
				'channel, '.
				'yosan_kind';

		$query = $this->_db_wizp->query($sql);
		$yosan_data = array();
		if ($query->num_rows() > 0)
		{
			$row_yosan_datas = $query->result_array();
			foreach ($row_yosan_datas as $row_yosan_data)
			{
				$channel    = $row_yosan_data['channel'];
				$yosan_kind = $row_yosan_data['yosan_kind'];
				$count      = (int)$row_yosan_data['count'];
				switch ($channel)
				{
					case 'realestate_east':
					case 'realestate_west':
					case 'able_east':
					case 'able_west':
						if (isset($yosan_data['able_and_realestate'][$yosan_kind])) {
							$yosan_data['able_and_realestate'][$yosan_kind] += $count;
						} else {
							$yosan_data['able_and_realestate'][$yosan_kind] = $count;
						}
					default:
						$yosan_data[$channel][$yosan_kind] = $count;
				}
			}
		}

		// チャンネル毎の集計情報を取得
		foreach ($this->_daily_addup_channels as $channel)
		{
			// チャンネル毎の小計変数を初期化
			$sum_introduction_total = 0;
			$sum_contract_yosan     = 0;
			$sum_contract_total     = 0;
			$sum_contract_flets     = 0;
			$sum_isp                = 0;
			$sum_virus              = 0;
			$sum_remote             = 0;
			$sum_hikari_tv_pa       = 0;
			$sum_hikari_tv          = 0;
			$sum_hikari_tel         = 0;
			$sum_ng                 = 0;

			foreach ($this->_time_zones as $time_zone)
			{
				// 時間帯ごとの契約予算情報を取得する
				if (isset($yosan_data[$channel][$time_zone])) {
					$contract_yosan = $yosan_data[$channel][$time_zone];
				} else {
					$contract_yosan = 0;
				}
				$sum_contract_yosan += $contract_yosan;

				// チャンネル＆時間帯毎の集計情報を取得
				$sql = ''.
					'SELECT '.
						'i.date                            AS date, '.
						'i.time_zone                       AS time_zone, '.
						'IFNULL(i.introduction_total, "0") AS introduction_total, '.
						'IFNULL(c.contract_total,     "0") AS contract_total, '.
						'IFNULL(c.contract_flets,     "0") AS contract_flets, '.
						'IFNULL(c.isp,                "0") AS isp, '.
						'IFNULL(c.virus,              "0") AS virus, '.
						'IFNULL(c.remote,             "0") AS remote, '.
						'IFNULL(c.hikari_tv_pa,       "0") AS hikari_tv_pa, '.
						'IFNULL(c.hikari_tv,          "0") AS hikari_tv, '.
						'IFNULL(c.hikari_tel,         "0") AS hikari_tel, '.
						'IFNULL(c.ng,                 "0") AS ng '.
					'FROM '.
						"addup_daily_introduction_${channel} i LEFT JOIN ".
						"addup_daily_contraction_${channel}  c ".
					'ON '.
						'i.date      = c.contract_date AND '.
						'i.time_zone = c.time_zone '.
					'WHERE '.
						"i.date = '{$date}' AND ".
						"i.time_zone = '${time_zone}' ".
					'ORDER BY '.
						'date,'.
						'time_zone';

				$query = $this->_db_wizp->query($sql);
				if ($query->num_rows() <= 0)
				{
					$sum[$channel][] = $this->_get_sum_empty($date, $time_zone, $contract_yosan);
				}
				else
				{
					$row = $query->row();

					// チャンネル毎に各フィールドの小計を取る
					$sum_introduction_total += $row->introduction_total;
					$sum_contract_total     += $row->contract_total;
					$sum_contract_flets     += $row->contract_flets ;
					$sum_isp                += $row->isp;
					$sum_virus              += $row->virus;
					$sum_remote             += $row->remote;
					$sum_hikari_tv_pa       += $row->hikari_tv_pa;
					$sum_hikari_tv          += $row->hikari_tv;
					$sum_hikari_tel         += $row->hikari_tel;
					$sum_ng                 += $row->ng;

					// 表示用に配列を整形する
					$sum[$channel][] = array(
						$row->date,
						$row->time_zone,
						$row->introduction_total,
						$row->contract_total.' / '.$contract_yosan,
						$row->contract_flets,
						$row->isp,
						$row->virus,
						$row->remote,
						$row->hikari_tv_pa,
						$row->hikari_tv,
						$row->hikari_tel,
						$row->ng,
					);
				}
			}

			// 紹介予算情報を取得する
			if (isset($yosan_data[$channel]['紹介予算'])) {
				$introduction_yosan = $yosan_data[$channel]['紹介予算'];
			} else {
				$introduction_yosan = 0;
			}

			// チャンネル毎の小計行を追加する
			$sum[$channel][] = array(
				'date'               => $date,
				'time_zone'          => '小計',
				'introduction_total' => $sum_introduction_total.' / '.$introduction_yosan,
				'contract_total'     => $sum_contract_total.' / '.$sum_contract_yosan,
				'contract_flets'     => $sum_contract_flets,
				'isp'                => $sum_isp,
				'virus'              => $sum_virus,
				'remote'             => $sum_remote,
				'hikari_tv_pa'       => $sum_hikari_tv_pa,
				'hikari_tv'          => $sum_hikari_tv,
				'hikari_tel'         => $sum_hikari_tel,
				'ng'                 => $sum_ng,
			); 
		}

		// 出力
		$data = array(
			'year'     => $y,
			'month'    => $m,
			'day'      => $d,
			'calendar' => $calendar,
			'sum'      => $sum,
			'users'    => $users,
			'sum_user' => $sum_user,
		);
		$this->ag_auth->view('contents/addup_daily/index', $data);
	}

	// 対象データ無しの空集計配列を返す
	private function _get_sum_empty($date, $time_zone, $contract_yosan)
	{
		return array(
			'date'               => $date,
			'time_zone'          => $time_zone,
			'introduction_total' => 0,
			'contract_total'     => '0 / '.$contract_yosan,
			'contract_flets'     => 0,
			'isp'                => 0,
			'virus'              => 0,
			'remote'             => 0,
			'hikari_tv_pa'       => 0,
			'hikari_tv'          => 0,
			'hikari_tel'         => 0,
			'ng'                 => 0,
		);
	}
}
