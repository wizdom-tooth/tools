<?php

class Cron extends CI_Controller {

	const COMMAND_MYSQLDUMP = '/usr/bin/mysqldump';
	const COMMAND_MYSQLIMPORT = '/usr/bin/mysqlimport';
	const ADDUP_FILE_FEED_LOCK = '/home/wiz/g/application/wiz/var/feed/addup/NOW_FEEDING.LOCK';
	const ADDUP_FILE_RAW_DATA = '/home/wiz/g/application/wiz/var/feed/addup/addup_raw.csv';
	const ADDUP_FILE_CONV_DATA = '/home/wiz/g/application/wiz/var/feed/addup/addup.tsv';
	const ADDUP_DIR_BACKUP = '/home/wiz/g/application/wiz/var/backup/addup';

	// 集計用データをDBに取り込む
	public function feed_addup_data()
	{
		if ($this->input->is_cli_request() !== TRUE) show_error('system error.');

		// --------------------------------------
		// ロック処理
		// --------------------------------------

		if (file_exists(self::ADDUP_FILE_FEED_LOCK))
		{
			// メールして何もしない旨を報告
			// *********************************
			exit;
		}
		else
		{
			if (touch(self::ADDUP_FILE_FEED_LOCK) === FALSE)
			{
				// エラー報告
				// *********************************
				exit;
			}
		}

		// --------------------------------------
		// 継続の場合はDBのバックアップを取る 曜日時間ごと？？
		// --------------------------------------
		$command = ''.
			self::COMMAND_MYSQLDUMP.' '.
				'-u root '.
				//'-ponetop0721 '. // .my.cnf
				'wiz_planners '.
			'> '.
				self::ADDUP_DIR_BACKUP.'/'.date('l_H').'.sql';
		$result = exec($command);
		if ($result === '0')
		{
			// エラーメールして報告
			// *********************************
			echo "failed to output backup file of mysqldb.\n";
			exit;
		}

		// --------------------------------------
		// データ加工処理＞加工済みデータをTSVファイルに書き出す
		// --------------------------------------

		$fpr = fopen(self::ADDUP_FILE_RAW_DATA, 'r');
		$fpw = fopen(self::ADDUP_FILE_CONV_DATA, 'w');

		$i = 1;
		$skip_message = array();

		while (($line = fgets($fpr)) !== FALSE)
		{
			$line = mb_convert_encoding($line, 'UTF-8', 'SJIS'); // UTF8に変換
			$line = str_replace(',', "\t", $line); // CSVからTSVへ
			$line = mb_convert_kana($line, 'KVa', 'UTF-8'); // 全半角統一
			$line = strtoupper($line); // 小文字アルファベットを大文字に統一

			$fields = explode("\t", $line);
			foreach ($fields as $j => $field)
			{
				$fields[$j] = preg_replace('/\s+/', '', $field); // ホワイトスペースのストリップ
			}
			$fields[1] = date('Ymd', strtotime($fields[1])); // 日付フ>ォーマット変更

			// 不正なデータをスキップ
			$is_invlid_emptyid = FALSE;
			$is_invlid_date = FALSE;
			$is_invlid_timezone = FALSE;

			if (empty($fields[0]))
			{
				$is_invlid_emptyid = TRUE;
				$message = ''.
					"LINE_NUM:[{$i}] VALINE:[{$fields[0]}] - invalid id.";
				$skip_message[] = $message;
			}
			elseif ($fields[1] === '19700101')
			{
				$is_invlid_date = TRUE;
				$message = ''.
					"LINE_NUM:[{$i}] VALINE:[{$fields[1]}] - invalid date.";
				$skip_message[] = $message;
			}
			elseif ( ! preg_match('/^[A-Z].+$/', $fields[2]))
			{
				$is_invlid_timezone = TRUE;
				$message = ''.
					"LINE_NUM:[{$i}] VALINE:[{$fields[2]}] - invalid timezone.";
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
			}
		}

		// --------------------------------------
		// DBに流し込む
		// --------------------------------------

		$command = ''.
			self::COMMAND_MYSQLIMPORT.' '.
				'-u root '.
				//'-ponetop0721 '. // .my.cnf
				'--replace '.
				'wiz_planners '.
				self::ADDUP_FILE_CONV_DATA;
		$result = exec($command);
		if ($result === '')
		{
			// エラーメールして報告
			// *********************************
			echo "failed to import add data file.\n";
		}
		else
		{
			// レポートメール送信
			// *********************************
			/*
			if ( ! empty($skip_message))
			{
				// ***************************************
				// 
				//	var_dump($skip_message);
			}
			*/
			// ロックファイルを削除	
			if (unlink(self::ADDUP_FILE_FEED_LOCK) === FALSE)
			{
                // エラー報告
                // *********************************
				exit;
			}
		}
	}
}
