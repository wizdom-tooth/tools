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

    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
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

	// 月次マスタ作成
	public function create_wiz_month_mst()
	{
		//if ($this->input->is_cli_request() !== TRUE) show_error('system error.');
		$this->_db_wizp = $this->load->database('wizp', TRUE);
		for ($year = 2010; $year <= 2040; $year++)
		{
			for ($month = 1; $month <= 12; $month++)
			{
				$m = sprintf('%02d', $month);
				$this_month_timestamp = mktime(0, 0, 0, $month, 1, $year);
				$next_ym = date('Ym', strtotime('+1 month', $this_month_timestamp));
				$wiz_month_id = $next_ym;
				$from_date = $year.$m.'21';
				$to_date = $next_ym.'20';

				// DBに書き出す
				$sql = ''.
					'REPLACE INTO '.
						'wiz_month_mst '.
					'VALUES '.
						'('.
							"{$wiz_month_id},".
							"{$from_date},".
							"{$to_date}".
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

					// DBに書き出す
					$sql = ''.
						'REPLACE INTO '.
							'wiz_week_mst '.
						'VALUES '.
							'('.
								"'{$wiz_week_id}',".
								"'{$from_date}',".
								"'{$to_date}'".
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
