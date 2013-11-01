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
		'contract_total',
		'contract_flets',
		'isp',
		'virus',
		'remote',
		'hikari_tv_pa',
		'hikari_tv',
		'hikari_tel',
		'ng',
		'contract_yosan',
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
		$sum_empty  = array();
		foreach ($this->_select_fields as $field)
		{
			if ($field === 'date')
			{
				$sum_empty['date'] = $date;
			}
			elseif ($field === 'time_zone')
			{
				$sum_empty['time_zone'] = $time_zone;
			}
			else
			{
				$sum_empty[$field] = 0;
			}
		}
		return $sum_empty;
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
				'introduction_total' => 0,
				'contract_total' => 0,
				'contract_flets' => 0,
				'isp' => 0,
				'virus' => 0,
				'remote' => 0,
				'hikari_tv_pa' => 0,
				'hikari_tv' => 0,
				'hikari_tel' => 0,
				'ng' => 0,
				'contract_yosan' => 0,
			);
			foreach ($time_zones as $time_zone)
			{
				$sql = ''.
					'select '.
						'a.date, '.
						'a.time_zone, '.
						'a.introduction_total, '.
						'b.contract_total, '.
						'b.contract_flets, '.
						'b.isp, '.
						'b.virus, '.
						'b.remote, '.
						'b.hikari_tv_pa, '.
						'b.hikari_tv, '.
						'b.hikari_tel, '.
						'b.ng '.
					'from '.
						"addup_daily_introduction_${channel} a, ".
						"addup_daily_contraction_${channel} b ".
					'where '.
						$cond.' and '.
						'a.date = b.contract_date and '.
						'a.time_zone = b.time_zone and '.
						"a.time_zone = '${time_zone}' ".
					'order by '.
						'a.date,'.
						'a.time_zone';

				$query = $this->_db_wizp->query($sql);
				if ($query->num_rows() > 0)
				{
					$tmp = $query->row_array();
					$sql = ''.
						'select '.
							'count '.
						'from '.
							'yosan a '.
						'where '.
							$cond.' and '.
							"yosan_kind = '{$tmp['time_zone']}' and ".
							"channel = '${channel}'";
					$q = $this->_db_wizp->query($sql);
					if ($q->num_rows() > 0)
					{
						$row = $q->row();
						$tmp['contract_yosan'] = $row->count;
					}
					else
					{
						$tmp['contract_yosan'] = 0;
					}
					foreach ($tmp as $key => $count)
					{
						if (isset($total[$key]))
						{
							$total[$key] += (int)$count;
						}
					}
					$sum[$channel][] = $tmp;
				}
				else
				{
					$sum[$channel][] = $this->_get_sum_empty($date, $time_zone);
				}
			}
			$sum[$channel][] = array(
				'date' => $date,
				'time_zone' => '計',
				'introduction_total' => $total['introduction_total'],
				'contract_total' => $total['contract_total'],
				'contract_flets' => $total['contract_flets'],
				'isp' => $total['isp'],
				'virus' => $total['virus'],
				'remote' => $total['remote'],
				'hikari_tv_pa' => $total['hikari_tv_pa'],
				'hikari_tv' => $total['hikari_tv'],
				'hikari_tel' => $total['hikari_tel'],
				//'ng' => $total['ng'],
				'ng' => '-',
				'contract_yosan' => '0', // ***************************************
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
