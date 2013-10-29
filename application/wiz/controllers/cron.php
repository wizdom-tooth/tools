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

	// 集計用データをDBに取り込む
	public function feed_addup_data()
	{
		if ($this->input->is_cli_request() !== TRUE) show_error('system error.');

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
			$fields[1] = date('Ymd', strtotime($fields[1])); // 日付フ>ォーマット変更
			$fields[18] = date('Ymd', strtotime($fields[18])); // 日付フ>ォーマット変更

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

			$i++;
			if ($is_invlid_emptyid || $is_invlid_date || $is_invlid_timezone)
			{
				continue;
			}
			else
			{
				$line = implode("\t", $fields)."\n";
				fputs($fpw, $line);
				$success_count++;
			}
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
