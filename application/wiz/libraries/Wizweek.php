<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wizweek {

	private $_CI = NULL;
	private $_db = NULL;
	private $_wiz_month_id = '';
	private $_week_raw_info = array();
	private $_week_days_info = array();
	private $_week_weight_info = array();

	// 仮 >>> 設定情報取り出し 
	private $_month_count = '1000'; 
	private $_weekday_weights = array( 
		'Mon' => '1', 
		'Tue' => '1', 
		'Wed' => '1', 
		'Thu' => '1', 
		'Fri' => '1', 
		'Sat' => '2', 
		'Sun' => '3', 
	); 

    public function __construct($params)
    {
		$this->_CI =& get_instance();
		$this->_CI->config->load('wiz_config');
		$this->_db = $this->_CI->load->database('wizp', TRUE);
		$this->_wiz_month_id = $params['wiz_month_id'];
    }

	// 加工なし
    public function get_week_raw_info($week_num = 9)
	{
		$this->_set_week_raw_info($this->_wiz_month_id);
		if ($week_num === 9) // 一か月分を全て取得
		{
			return $this->_week_raw_info;
		}
		else // 指定週情報を取得
		{
			if (isset($this->_week_raw_info[$week_num]))
			{
				return $this->_week_raw_info[$week_num];
			}
			else
			{
				trigger_error('following week_num is not exists in week info array  ... '.$week_num);
			}
		}
	}
    private function _set_week_raw_info()
    {
		$sql = ''.
			'SELECT '.
				'* '.
			'FROM '.
				'wiz_week_mst '.
			'WHERE '.
				"wiz_month_id = '{$this->_wiz_month_id}'".
			'ORDER BY '.
				'wiz_week_id';
		$query = $this->_db->query($sql);
		if ($query->num_rows() === 0)
		{
			trigger_error('following wiz_month_id is not found ... '.$this->_wiz_month_id);
		}
		$this->_week_raw_info = $query->result_array();
	}

	// 各種日付情報を付与する
	public function get_week_days_info()
	{
		$this->_set_week_days_info();
		return $this->_week_days_info;
	}
    private function _set_week_days_info()
	{
		if (empty($this->_week_raw_info))
		{
			$this->_set_week_raw_info();
		}

		// 日付毎の情報を付与する
		foreach ($this->_week_raw_info as $info)
		{
			$wiz_week_id = $info['wiz_week_id'];
			$cur_date    = $info['from_date'];
			$to_date     = $info['to_date'];

			list($cur_year, $cur_month, $cur_day) = explode('-', $cur_date);
			$cur_date_timestamp = mktime(0, 0, 0, $cur_month, $cur_day, $cur_year);
			$cur_date_weekday = date('D', $cur_date_timestamp);

			do {
				// ex) $yosan_week_infos['201312_1']['Mon']['date'] = '2013-12-18';
				$this->_week_days_info[$wiz_week_id][$cur_date_weekday]['date'] = $cur_date;
				// 日付を1日進める
				$cur_date_timestamp = strtotime('+1 day', $cur_date_timestamp);
				$cur_date = date('Y-m-d', $cur_date_timestamp);
				$cur_date_weekday = date('D', $cur_date_timestamp);
			}
			while ($cur_date <= $to_date);
		}

		// 週ごとの重みを計算
		foreach ($this->_week_days_info as $wiz_week_id => $week_days_info)
		{
			$this->_week_weight_info[$wiz_week_id] = 0;
			foreach (array_keys($week_days_info) as $weekday)
			{
				$this->_week_weight_info[$wiz_week_id] += $this->get_weekday_weight($weekday);
			}
		}

		// 日付ごとの重み係数を付与
		foreach ($this->_week_days_info as $wiz_week_id => $week_days_info)
		{
			foreach ($week_days_info as $weekday => $day_info)
			{
				$this->_week_days_info[$wiz_week_id][$weekday]['weight'] = 
					($this->_week_weight_info[$wiz_week_id] / array_sum($this->_week_weight_info)) *
					($this->get_weekday_weight($weekday) / $this->_week_weight_info[$wiz_week_id]);
			}
		}
	}

	// 曜日別重み比率情報を取得
	public function get_weekday_weight($weekday)
	{
		if (isset($this->_weekday_weights[$weekday]))
		{
			return $this->_weekday_weights[$weekday];
		}
		else
		{
			trigger_error('following weekday is not exists in weekday weights info array ... '.$weekday);
		}
	}
}
