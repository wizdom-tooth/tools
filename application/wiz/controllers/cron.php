<?php

class Cron extends CI_Controller {

	const COMMAND_MYSQLDUMP = '/usr/bin/mysqldump';
	const COMMAND_MYSQLIMPORT = '/usr/bin/mysqlimport';

	const ADDUP_FILE_FEED_LOCK = '/home/wiz/g/application/wiz/var/feed/addup/NOW_FEEDING.LOCK';
	const ADDUP_FILE_RAW_DATA = '/home/wiz/work/tmp/out_addup_data.csv';
	const ADDUP_FILE_CONV_DATA = '/home/wiz/g/application/wiz/var/feed/addup/addup.tsv';
	const ADDUP_DIR_BACKUP = '/home/wiz/g/application/wiz/var/backup/addup';

	const MAIL_ADDUP_INFO_EXIST_LOCK = 'MAIL_ADDUP_INFO_EXIST_LOCK';
	const MAIL_ADDUP_INFO_SUCCESS = 'MAIL_ADDUP_INFO_SUCCESS';
	const MAIL_ADDUP_ERROR_FAIL_LOCK = 'MAIL_ADDUP_ERROR_FAIL_LOCK';
	const MAIL_ADDUP_ERROR_FAIL_BACKUP = 'MAIL_ADDUP_ERROR_FAIL_BACKUP';
	const MAIL_ADDUP_ERROR_FAIL_IMPORT = 'MAIL_ADDUP_ERORR_FAIL_IMPORT';

	private $_db_wizp = NULL;

	private $_work_week_number = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
        $this->load->helper('wiz');
    }

	// レポートメール送信
	private function _send_wiz_admin($kind, $optional_message = array())
	{
		switch ($kind)
		{
			case self::MAIL_ADDUP_INFO_EXIST_LOCK:
				$subject = '[INFO][wiz-p batch of addup] exit without anything';
				$message = "exit without anything, because the data file can not be found.\n";
				break;
			case self::MAIL_ADDUP_INFO_SUCCESS:
				$subject = '[INFO][wiz-p batch of addup] success !!';
				$message = "All procedures of addup were successful.\n";
				break;
			case self::MAIL_ADDUP_ERROR_FAIL_LOCK:
				$subject = '[ERROR][wiz-p batch of addup] failed to create lock file';
				$message = "failed to create lock file. permission denied ??.\n";
				break;
			case self::MAIL_ADDUP_ERROR_FAIL_UNLOCK:
				$subject = '[ERROR][wiz-p batch of addup] failed to remove lock file';
				$message = "failed to remove lock file. permission denied ??.\n";
				break;
			case self::MAIL_ADDUP_ERROR_FAIL_BACKUP:
				$subject = '[ERROR][wiz-p batch of addup] failed to output backup file of mysqldb';
				$message = "failed to output backup file of mysqldb.\n";
				break;
			case self::MAIL_ADDUP_ERORR_FAIL_IMPORT:
				$subject = '[ERROR][wiz-p batch of addup] failed to import new data for adddup';
				$message = "failed to import new data for adddup.\n";
				break;
		}
		if ( ! empty($optional_message))
		{
			foreach ($optional_message as $tmp)
			{
				$message .= "${tmp}\n";
			}
		}
		$this->email->send_wiz_admin($subject, $message);
	}

	private function _get_wiz_month_info($real_year, $real_month)
	{
		$real_m = sprintf('%02d', $real_month);
		$real_month_timestamp = mktime(0, 0, 0, $real_month, 1, $real_year);
		$next_year  = date('Y', strtotime('+1 month', $real_month_timestamp));
		$next_month = date('m', strtotime('+1 month', $real_month_timestamp));

		$wiz_month_info = array(
			'wiz_month_id'    => $next_year.$next_month,
			'from_date'       => $real_year.$real_m.'21',
			'to_date'         => $next_year.$next_month.'20',
			'wiz_halfyear_id' => $this->_get_wiz_halfyear_id($next_year, $next_month),
			'wiz_quarter_id'  => $this->_get_wiz_quarter_id($next_year, $next_month),
		);
		return $wiz_month_info;
	}

	private function _get_wiz_week_info($real_year, $real_month, $real_day)
	{
		$real_y = $real_year;
		$real_m = sprintf('%02d', $real_month);
		$real_d = sprintf('%02d', $real_day);
		$target_date = $real_y.'-'.$real_m.'-'.$real_d;
		$wiz_month_id = get_wiz_month_id($target_date);
		if ($wiz_month_id === FALSE) return FALSE;
		$wiz_month_info = get_wiz_month_info($wiz_month_id);
		$real_day_timestamp = mktime(0, 0, 0, $real_month, $real_day, $real_year);
		if ($real_day === 21)
		{
			$this->_work_week_number = 1;
			switch (date('D', $real_day_timestamp))
			{
				case 'Mon':
					$offset = 3;
					break;
				case 'Tue':
					$offset = 2;
					break;
				case 'Wed':
					$offset = 1;
					break;
				case 'Thu':
					$offset = 0;
					break;
				case 'Fri':
					$offset = 6;
					break;
				case 'Sat':
					$offset = 5;
					break;
				case 'Sun':
					$offset = 4;
					break;
			}
			$wiz_week_id = $wiz_month_info['wiz_month_id'].'_'.$this->_work_week_number;
			$from_date = $real_year.$real_m.'21';
			$to_date = date('Ymd', strtotime("+{$offset} day", $real_day_timestamp));
			$this->_work_week_number++;
		}
		else
		{
			if ($this->_work_week_number === NULL) return FALSE;
			$real_day_weekday = date('D', $real_day_timestamp);
			if ($real_day_weekday !== 'Fri') return FALSE;

			$real_d = sprintf('%02d', $real_day);
			$wiz_week_id = $wiz_month_info['wiz_month_id'].'_'.$this->_work_week_number;
			$from_date = $real_year.$real_m.$real_d;
			$to_date_timestamp = strtotime('+6 day', $real_day_timestamp);
			$to_day = (int)date('j', $to_date_timestamp);
			if ($real_d <= 20 && $to_day > 20)
			{
				$to_date = $real_year.$real_m.'20';
			}
			else
			{
				$to_date = date('Ymd', $to_date_timestamp);
			}
			$this->_work_week_number++;
		}

		$wiz_week_info = array(
			'wiz_week_id'     => $wiz_week_id,
			'from_date'       => $from_date,
			'to_date'         => $to_date,
			'wiz_halfyear_id' => $wiz_month_info['wiz_halfyear_id'],
			'wiz_quarter_id'  => $wiz_month_info['wiz_quarter_id'],
			'wiz_month_id'    => $wiz_month_info['wiz_month_id'],
		);

		return $wiz_week_info;
	}

	private function _get_wiz_halfyear_id($year, $month)
	{
		switch ($month)
		{
			case '12':
				$wiz_halfyear_id = $year.'_2';
				break;
			case '01':
			case '02':
			case '03':
			case '04':
			case '05':
				$wiz_halfyear_id = ($year - 1).'_2';
				break;
			case '06':
			case '07':
			case '08':
			case '09':
			case '10':
			case '11':
				$wiz_halfyear_id = $year.'_1';
				break;
		}
		return $wiz_halfyear_id;
	}

	private function _get_wiz_quarter_id($year, $month)
	{
		switch ($month)
		{
			case '12':
				$wiz_quarter_id = $year.'_3';
				break;
			case '01':
			case '02':
				$wiz_quarter_id = ($year - 1).'_3';
				break;
			case '03':
			case '04':
			case '05':
				$wiz_quarter_id = ($year - 1).'_4';
				break;
			case '06':
			case '07':
			case '08':
				$wiz_quarter_id = $year.'_1';
				break;
			case '09':
			case '10':
			case '11':
				$wiz_quarter_id = $year.'_2';
				break;
		}
		return $wiz_quarter_id;
	}

    public function create_weekday_weight_mst()
    {
		$this->_db_wizp = $this->load->database('wizp', TRUE);

        // 日毎の照会件数
		$intro_counts_by_date = array();
        $sql = 'select date, count(*) as count from addup group by date order by date';
        $query = $this->_db_wizp->query($sql);
        $intro_counts_by_date = $query->result_array();

        // 祝日マスタ
		$holidays = array();
        $sql = 'select date, name from holiday_mst order by date';
        $query = $this->_db_wizp->query($sql);
        foreach ($query->result_array() as $tmp)
		{
			$holidays[$tmp['date']] = $tmp['name'];
		}

		// 曜日毎に集計
        $intro_counts_by_weekday = array();
        foreach ($intro_counts_by_date as $intro_counts)
        {
			$date  = $intro_counts['date'];
			$count = $intro_counts['count'];

			// 対象日の曜日或いは祝日かどうか
			if (isset($holidays[$date]))
			{
				$weekday = 'Hol';
			}
			else
			{
				$weekday = date('D', strtotime($date));
			}
			// 集計用配列を初期化
			if ( ! isset($intro_counts_by_weekday[$weekday]))
			{
				$intro_counts_by_weekday[$weekday] = array();
			}
			
            $intro_counts_by_weekday[$weekday][] = $intro_counts['count'];
        }

		// 曜日毎の1日の平均件数を取得
		$intro_counts_by_weekday_avg = array();
		foreach ($intro_counts_by_weekday as $weekday => $counts)
		{
			$intro_counts_by_weekday_avg[$weekday] = array_sum($counts) / count($counts);
		}

		// 曜日毎の比率を計算
        $base_count = min($intro_counts_by_weekday_avg);
        $weekday_weights = array();
        foreach ($intro_counts_by_weekday_avg as $weekday => $count)
        {
            $weekday_weights[$weekday] = round($count / $base_count, 3);
        }

		// DBに書き出す
		foreach ($weekday_weights as $weekday => $weight)
		{
			$sql = ''.
				'REPLACE INTO '.
					'weekday_weight_mst '.
				'VALUES '.
					'('.
						"'{$weekday}',".
						"'{$weight}'".
					')';
			$this->_db_wizp->query($sql);
		}
		echo 'all green.';
	}

	// 祝日マスタ作成
	public function create_holiday_mst()
	{
		$this->_db_wizp = $this->load->database('wizp', TRUE);
		$holidays = array();
		for ($y = 2010; $y <= 2040; $y++)
		{
			$holidays_url = sprintf(
				'http://www.google.com/calendar/feeds/%s/public/full-noattendees?start-min=%s&start-max=%s&max-results=%d&alt=json' ,
				'outid3el0qkcrsuf89fltf7a4qbacgt9@import.calendar.google.com' , // 'japanese@holiday.calendar.google.com' ,
				$y.'-01-01',    // 取得開始日
				$y.'-12-31',
				50              // 最大取得数
			);
			if ( ! $results = file_get_contents($holidays_url))
			{
				trigger_error('aaaaa');
			}
			$results = json_decode($results, TRUE);
			foreach($results['feed']['entry'] as $val) {
				$date = $val['gd$when'][0]['startTime']; // 日付を取得
				list($title) = explode(' / ', $val['title']['$t']); // 何の日かを取得
				$holidays[$date] = $title; // 日付をキーに、祝日名を値に格納
			}
		}
		ksort($holidays);
		foreach ($holidays as $date => $name)
		{
			$sql = ''.
				'REPLACE INTO '.
					'holiday_mst '.
				'VALUES '.
					'('.
						"'{$date}',".
						"'{$name}'".
					')';
			$query = $this->_db_wizp->query($sql);
		}
		echo 'all green';
	}

	// 月次マスタ作成
	public function create_wiz_month_mst()
	{
		//if ($this->input->is_cli_request() !== TRUE) show_error('system error.');
		$this->_db_wizp = $this->load->database('wizp', TRUE);
		for ($year = 2010; $year <= 2040; $year++)
		{
			for ($month = 1; $month <= 12; $month++)
			{
				$wiz_month_info = $this->_get_wiz_month_info($year, $month);
				$sql = ''.
					'REPLACE INTO '.
						'wiz_month_mst '.
					'VALUES '.
						'('.
							"'{$wiz_month_info['wiz_month_id']}',".
							"'{$wiz_month_info['wiz_halfyear_id']}',".
							"'{$wiz_month_info['wiz_quarter_id']}',".
							"'{$wiz_month_info['from_date']}',".
							"'{$wiz_month_info['to_date']}'".
						')';
				$query = $this->_db_wizp->query($sql);
				// ****************
				// エラー処理
				// ****************
			}
		}
		echo 'all green';
	}

	// 週マスタ作成
	public function create_wiz_week_mst()
	{
		//if ($this->input->is_cli_request() !== TRUE) show_error('system error.');
		$this->_db_wizp = $this->load->database('wizp', TRUE);
		for ($year = 2010; $year <= 2040; $year++)
		{
			for ($month = 1; $month <= 12; $month++)
			{
				$m = sprintf('%02d', $month);
				$this_month_timestamp = mktime(0, 0, 0, $month, 1, $year);
				$this_month_lastday = date('t', $this_month_timestamp);

				for ($day = 1; $day <= $this_month_lastday; $day++)
				{
					$wiz_week_info = $this->_get_wiz_week_info($year, $month, $day);
					if ($wiz_week_info === FALSE) continue;
					/*
					$this_day_timestamp = mktime(0, 0, 0, $month, $day, $year);
					if ($day === 21)
					{
						switch (date('D', $this_day_timestamp))
						{
							case 'Mon':
								$offset = 3;
								break;
							case 'Tue':
								$offset = 2;
								break;
							case 'Wed':
								$offset = 1;
								break;
							case 'Thu':
								$offset = 0;
								break;
							case 'Fri':
								$offset = 6;
								break;
							case 'Sat':
								$offset = 5;
								break;
							case 'Sun':
								$offset = 4;
								break;
						}
						$week_number = 1;
						$wiz_month = date('Ym', strtotime('+1 month', $this_month_timestamp));
						$wiz_week_id = $wiz_month.'_'.$week_number;
						$from_date = $year.$m.'21';
						$to_date = date('Ymd', strtotime("+{$offset} day", $this_day_timestamp));
						$week_number++;
					}
					else
					{
						if ( ! isset($week_number)) continue;
						$this_day_weekday = date('D', $this_day_timestamp);
						if ($this_day_weekday !== 'Fri') continue;

						$d = sprintf('%02d', $day);
						$wiz_week_id = $wiz_month.'_'.$week_number;
						$from_date = $year.$m.$d;
						$to_day = (int)date('j', strtotime('+6 day', $this_day_timestamp));
						if ($to_day > 20)
						{
							$to_date = $year.$m.'20';
						}
						else
						{
							$to_date = date('Ymd', strtotime('+6 day', $this_day_timestamp));
						}
						$week_number++;
					}
					*/

					// DBに書き出す
					$sql = ''.
						'REPLACE INTO '.
							'wiz_week_mst '.
						'VALUES '.
							'('.
								"'{$wiz_week_info['wiz_week_id']}',".
								"'{$wiz_week_info['wiz_halfyear_id']}',".
								"'{$wiz_week_info['wiz_quarter_id']}',".
								"'{$wiz_week_info['wiz_month_id']}',".
								"'{$wiz_week_info['from_date']}',".
								"'{$wiz_week_info['to_date']}'".
							')';
					$query = $this->_db_wizp->query($sql);
					// ****************
					// エラー処理
					// ****************
				}
			}
		}
		echo 'all green';
	}

	// 集計用データをDBに取り込む
	public function feed_addup_data()
	{
		//if ($this->input->is_cli_request() !== TRUE) show_error('system error.');
		$this->_db_wizp = $this->load->database('wizp', TRUE);

		// --------------------------------------
		// ロック処理
		// --------------------------------------

		if (file_exists(self::ADDUP_FILE_FEED_LOCK))
		{
			$this->_send_wiz_admin(self::MAIL_ADDUP_INFO_EXIST_LOCK);
			exit;
		}
		else
		{
			if (touch(self::ADDUP_FILE_FEED_LOCK) === FALSE)
			{
				$this->_send_wiz_admin(self::MAIL_ADDUP_ERROR_FAIL_LOCK);
				exit;
			}
		}

		// --------------------------------------
		// DBのバックアップを取る
		// --------------------------------------

		$command = ''.
			self::COMMAND_MYSQLDUMP.' '.
				'-u root '.
				'wiz_planners '.
			'> '.
				self::ADDUP_DIR_BACKUP.'/'.date('l_H').'.sql';
		$result = exec($command);
		if ($result === '0')
		{
			$this->_send_wiz_admin(self::MAIL_ADDUP_ERROR_FAIL_BACKUP);
			exit;
		}

		// --------------------------------------
		// データ加工処理＞加工済みデータをTSVファイルに書き出す
		// --------------------------------------

		$fpr = fopen(self::ADDUP_FILE_RAW_DATA, 'r');
		$fpw = fopen(self::ADDUP_FILE_CONV_DATA, 'w');

		$i = 1;
		$success_count = 1;
		$skip_message = array();

		$i_or_cs = array('introduction', 'contract');
		$date_kinds = array('month', 'week');

		while (($line = fgets($fpr)) !== FALSE)
		{
			$line = mb_convert_encoding($line, 'UTF-8', 'SJIS'); // UTF8に変換
			$line = str_replace(',', "\t", $line); // CSVからTSVへ
			$line = str_replace('"', '', $line); // ダブルクォートをストリップ
			$line = mb_convert_kana($line, 'KVa', 'UTF-8'); // 全半角統一
			$line = strtoupper($line); // 小文字アルファベットを大文字に統一

			$fields = explode("\t", $line);
			foreach ($fields as $j => $field)
			{
				$fields[$j] = preg_replace('/\s+/', '', $field); // ホワイトスペースのストリップ
			}
			$introduction_date = $fields[1] = date('Ymd', strtotime($fields[1])); // 紹介日 日付フォーマット変更
			$contract_date = $fields[18] = date('Ymd', strtotime($fields[18])); // 契約日 日付フォーマット変更
			if ($contract_date === '19700101')
			{
				$contract_date = $fields[18] = '';
			}

			// 不正なデータをスキップ
			$is_invlid_emptyid = FALSE;
			$is_invlid_date = FALSE;
			$is_invlid_timezone = FALSE;

			if (empty($fields[0]))
			{
				$is_invlid_emptyid = TRUE;
				$message = ''.
					"LINE NUMBER:[{$i}] VALINE:[{$fields[0]}] - invalid id.";
				$skip_message[] = $message;
			}
			elseif ($fields[1] === '19700101')
			{
				$is_invlid_date = TRUE;
				$message = ''.
					"LINE NUMBER:[{$i}] VALINE:[{$fields[1]}] - invalid date.";
				$skip_message[] = $message;
			}
			elseif ( ! preg_match('/^[A-Z].+$/', $fields[2]))
			{
				$is_invlid_timezone = TRUE;
				$message = ''.
					"LINE NUMBER:[{$i}] VALINE:[{$fields[2]}] - invalid timezone.";
				$skip_message[] = $message;
			}

			if ($is_invlid_emptyid || $is_invlid_date || $is_invlid_timezone)
			{
				continue;
			}

			// 紹介日と契約日の月ID及び週IDを取り出す
			foreach ($i_or_cs as $i_or_c)
			{
				foreach ($date_kinds as $date_kind)
				{
					$target_date_var = "{$i_or_c}_date";
					$target_date = $$target_date_var;
					$select_field_name = "wiz_{$date_kind}_id";
					$table_name = "wiz_{$date_kind}_mst";
					$pickup_var = $i_or_c.'_'.$select_field_name;

					if ($target_date !== '')
					{
						$sql = "SELECT $select_field_name FROM $table_name WHERE from_date <= '$target_date' AND to_date >= '$target_date'";
						$query = $this->_db_wizp->query($sql);
						if ($query->num_rows() > 0)
						{
							$row = $query->row();
							$$pickup_var = $row->$select_field_name;
						}
						else
						{
							$$pickup_var = '';
						}
					}
					else
					{
						$$pickup_var = '';
					}
				}
			}
			$fields[] = $introduction_wiz_month_id;
			$fields[] = $introduction_wiz_week_id;
			$fields[] = $contract_wiz_month_id;
			$fields[] = $contract_wiz_week_id;

			$line = implode("\t", $fields)."\n";
			fputs($fpw, $line);
			$success_count++;
			$i++;
		}
		fclose($fpr);
		fclose($fpw);

		// --------------------------------------
		// DBに流し込む
		// --------------------------------------

		$command = ''.
			self::COMMAND_MYSQLIMPORT.' '.
				'-u root '.
				'--replace '.
				'wiz_planners '.
				self::ADDUP_FILE_CONV_DATA;
		$result = exec($command);
		if ($result === '')
		{
			$this->_send_wiz_admin(self::MAIL_ADDUP_ERROR_FAIL_IMPORT);
			exit;
		}
		else
		{
			// 成功レポートメール送信
			$optional_message = array();
			$optional_message[] = "${success_count} records are inserted.";
			if ( ! empty($skip_message))
			{
				array_unshift($skip_message, '--- skipped records are as follows ---');
				$optional_message = array_merge($optional_message, $skip_message);
			}
			$this->_send_wiz_admin(self::MAIL_ADDUP_INFO_SUCCESS, $optional_message);
			// ロックファイルを削除
			if (unlink(self::ADDUP_FILE_FEED_LOCK) === FALSE)
			{
				$this->_send_wiz_admin(self::MAIL_ADDUP_ERROR_FAIL_UNLOCK);
				exit;
			}
		}
		echo 'all green.';
	}
}
