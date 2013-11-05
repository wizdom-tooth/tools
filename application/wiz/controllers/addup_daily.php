<?php

class Addup_Daily extends CI_Controller_With_Auth {

	private $_channels = array(
		'able_and_realestate',
		'able_east',
		'able_west',
		'realestate_east',
		'realestate_west',
		'ablehikkoshi_east',
		'ablehikkoshi_west',
		'aeras',
		'his_east',
		'his_west',
		'house2house',
		'housepartner',
		'nissei',
		'ponta_east',
		'ponta_west',
		'prime',
		'soleil',
		'univ',
		'isp',
		'iten',
		'fletsclub_iten',
		'ocn_upsell',
		'benefit',
	);

	private $_select_fields = array(
		'date',
		'time_zone',
		'introduction_total',
		//'contract_yosan',
		'contract_total',
		'contract_flets',
		'isp',
		'virus',
		'remote',
		'hikari_tv_pa',
		'hikari_tv',
		'hikari_tel',
		'ng',
	);

	private $_db_wizp = NULL;

	public function __construct()
	{
		parent::__construct();
		$this->ag_auth->restrict('manager');
		$this->_db_wizp = $this->load->database('wizp', TRUE);
		$this->config->load('admin_calendar');
		$this->load->library('calendar', $this->config->item('calendar_prefs'));
	}

	// 対象データ無しの空集計配列を返す
	private function _get_sum_empty($date, $time_zone)
	{
		return array(
			'date' => $date,
			'time_zone' => $time_zone,
			'introduction_total' => 0,
			'contract_total' => '0 / 0',
			'contract_flets' => 0,
			'isp' => 0,
			'virus' => 0,
			'remote' => 0,
			'hikari_tv_pa' => 0,
			'hikari_tv' => 0,
			'hikari_tel' => 0,
			'ng' => 0,
		);
	}

	public function index($year = '', $month = '', $day = '')
	{
		// 取得対象日付条件指定SQL WHERE句作成
		if ($year !== '' && $month !== '' && $day !== '')
		{
			$y = sprintf('%04d', $year);
			$m = sprintf('%02d', $month);
			$d = sprintf('%02d', $day);
			$date = "{$year}-{$month}-{$day}";
			$cond = "a.date = '{$year}-{$month}-{$day}'";
		}
		elseif ($year !== '' && $month !== '' && $day === '')
		{
			$y = sprintf('%04d', $year);
			$m = sprintf('%02d', $month);
			$d = '01';
			$date = "{$year}-{$month}-01";
			$cond = "a.date like '{$year}-{$month}-%'";
		}
		elseif ($year !== '' && ($month === '' || $day === ''))
		{
			$y = sprintf('%04d', $year);
			$m = '01';
			$d = '01';
			$date = "{$year}-01-01";
			$cond = "a.date like '{$year}-%'";
		}
		else
		{
			$y = $year = date('Y');
			$m = $month = date('m');
			$d = $day = date('d');
			$date = "{$y}-{$m}-{$d}";
			$cond = "a.date = '{$y}-{$m}-{$d}'";
		}

		// ------------------------------------
		// カレンダー
		// ------------------------------------

		$calendar_links = array();
		for ($i = 1; $i <= date('t', strtotime($y.$m.$d)); $i++)
		{
			$target_ym = $year.$month;
			$cur_ym = date('Ym');
			if ($target_ym < $cur_ym || $i <= date('j'))
			{
				$calendar_links[$i] = base_url('addup_daily/index/'.$y.'/'.$m.'/'.sprintf('%02d', $i).'/');
			}
			else
			{
				break;
			}
		}
		$calendar = $this->calendar->generate($y, $m, $calendar_links);

		// ------------------------------------
		// 担当者別集計
		// ------------------------------------

		// 担当者一覧
		$sum_user = array();
		$sql = ''.
			'select '.
				'distinct user_name '.
			'from '.
				'addup_user a '.
			'where '.
				$cond.' '.
			'order by '.
				'user_name';
		$query = $this->_db_wizp->query($sql);
		$users = $query->result_array();

		// 担当者毎の集計
		$sql = ''.
			'select '.
				'* '.
			'from '.
				'addup_user a '.
			'where '.
				$cond.' '.
			'order by '.
				'time_zone';
		$query = $this->_db_wizp->query($sql);
		$sum_user = $query->result_array();

		// ------------------------------------
		// チャンネル別集計
		// ------------------------------------

		// 時間帯情報を取得
		$time_zones = array();
		$sql = ''.
			'select '.
				'time_zone '.
			'from '.
				'time_zone_mst '.
			'order by '.
				'time_zone';
		$query = $this->_db_wizp->query($sql);
		foreach ($query->result() as $row)
		{
			$time_zones[] = $row->time_zone;
		}

		// チャンネル毎の集計情報を取得
		$sum = array();
		foreach ($this->_channels as $channel)
		{
			$total = array(
				'02_introduction_total' => 0,
				'03_contract_yosan'     => 0,
				'04_contract_total'     => 0,
				'05_contract_flets'     => 0,
				'06_isp'                => 0,
				'07_virus'              => 0,
				'08_remote'             => 0,
				'09_hikari_tv_pa'       => 0,
				'10_hikari_tv'          => 0,
				'11_hikari_tel'         => 0,
				'12_ng'                 => 0,
			);
			if ($channel === 'able_and_realestate')
			{
				$cond_channel = ''.
					'channel in ('.
						'"realestate_east",'.
						'"realestate_west",'.
						'"able_east",'.
						'"able_west"'.
					')';
			}
			else
			{
				$cond_channel = "channel = '${channel}'";
			}
			foreach ($time_zones as $time_zone)
			{
				$sql = ''.
					'select '.
						'a.date as 00_date, '.
						'a.time_zone as 01_time_zone, '.
						'ifnull(a.introduction_total, "0") as 02_introduction_total, '.
						'ifnull(b.contract_total, "0") as 04_contract_total, '.
						'ifnull(b.contract_flets, "0") as 05_contract_flets, '.
						'ifnull(b.isp, "0") as 06_isp, '.
						'ifnull(b.virus, "0") as 07_virus, '.
						'ifnull(b.remote, "0") as 08_remote, '.
						'ifnull(b.hikari_tv_pa, "0") as 09_hikari_tv_pa, '.
						'ifnull(b.hikari_tv, "0") as 10_hikari_tv, '.
						'ifnull(b.hikari_tel, "0") as 11_hikari_tel, '.
						'ifnull(b.ng, "0") as 12_ng '.
					'from '.
						"addup_daily_introduction_${channel} a left join ".
						"addup_daily_contraction_${channel} b ".
					'on '.
						'a.date = b.contract_date and '.
						'a.time_zone = b.time_zone '.
					'where '.
						$cond.' and '.
						"a.time_zone = '${time_zone}' ".
					'order by '.
						'00_date,'.
						'01_time_zone';

				$query = $this->_db_wizp->query($sql);
				if ($query->num_rows() > 0)
				{
					// 時間帯ごとの契約予算情報を付加する
					$tmp = $query->row_array();
					$sql = ''.
						'select '.
							'ifnull(sum(count), "0") as count '.
						'from '.
							'yosan a '.
						'where '.
							$cond.' and '.
							"yosan_kind = '{$tmp['01_time_zone']}' and ".
							$cond_channel;
					$q = $this->_db_wizp->query($sql);
					if ($q->num_rows() > 0)
					{
						$row = $q->row();
						$tmp['03_contract_yosan'] = $row->count; 
					}
					else
					{
						$tmp['03_contract_yosan'] = 0;
					}

					// 表示用に配列を整形する
					$view_data = array();
					foreach ($tmp as $key => $val)
					{
						if (isset($total[$key])) $total[$key] += (int)$val;
						if ($key === '03_contract_yosan')
						{
							continue;
						}
						if ($key !== '04_contract_total')
						{
							$view_data[$key] = $val;
						}
						else
						{
							$view_data['03_contact'] = $val.' / '.$tmp['03_contract_yosan'];
						}
					}
					ksort($view_data);
					$sum[$channel][] = $view_data;
				}
				else
				{
					$sum[$channel][] = $this->_get_sum_empty($date, $time_zone);
				}
			}

			// 紹介予算情報を付加する
			$sql = ''.
				'select '.
					'sum(count) as count '.
				'from '.
					'yosan a '.
				'where '.
					$cond.' and '.
					"yosan_kind = '紹介予算' and ".
					$cond_channel;
			$q = $this->_db_wizp->query($sql);
			if ($q->num_rows() > 0)
			{
				$row = $q->row();
				$introduction_yosan = (empty($row->count)) ? 0 : $row->count;
			}
			else
			{
				$introduction_yosan = 0;
			}

			$sum[$channel][] = array(
				'date'               => $date,
				'time_zone'          => '計',
				'introduction_total' => $total['02_introduction_total'].' / '.$introduction_yosan,
				//'contract_yosan'     => $total['03_contract_yosan'],
				'contract_total'     => $total['04_contract_total'].' / '.$total['03_contract_yosan'],
				'contract_flets'     => $total['05_contract_flets'],
				'isp'                => $total['06_isp'],
				'virus'              => $total['07_virus'],
				'remote'             => $total['08_remote'],
				'hikari_tv_pa'       => $total['09_hikari_tv_pa'],
				'hikari_tv'          => $total['10_hikari_tv'],
				'hikari_tel'         => $total['11_hikari_tel'],
				'ng'                 => $total['12_ng'], // ******************
			); 
		}

		// ------------------------------------
		// 出力
		// ------------------------------------

		$data = array(
			'year' => $year,
			'month' => $month,
			'day' => $day,
			'calendar' => $calendar,
			'sum' => $sum,
			'users' => $users,
			'sum_user' => $sum_user,
		);
		$this->ag_auth->view('contents/addup_daily/index', $data);
	}
}
