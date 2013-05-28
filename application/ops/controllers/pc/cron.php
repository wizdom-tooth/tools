<?php

class Cron extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->config->load('esta_redmine');
		$this->config->load('esta_geo');
		$this->load->library('email');
		$this->load->library('redmine');
		$this->load->helper('file');
		$this->load->database();
		$this->load->dbutil();
	}

	public function send_mail_backup_esta_onlinecenter()
	{
		if ($this->input->is_cli_request() !== TRUE) show_error('system error.');

		$backupdir = APPPATH.'var/backup';
		$backupfile = $backupdir.'/wiz_esta_onlinecenter_'.date('D').'.gz';

		// DBバックアップディレクトリ作成
		if ( ! file_exists($backupdir))
		{
			if ( ! mkdir($backupdir))
			{
				$err_message = ''.
					'!! failed to make backup dir. !!'."\n".
					'path is : '.$backupdir;
				trigger_error($err_message, E_USER_ERROR);
			}
		}

		// DBバックアップ作成
		$backupdata = $this->dbutil->backup(); 
		if ( ! write_file($backupfile, $backupdata))
		{
			$err_message = ''.
				'!! failed to write backup file. !!'."\n".
				'path is : '.$backupfile;
			trigger_error($err_message, E_USER_ERROR);
		}

		// バックアップファイルを管理者宛てにメール送信
		$tmp = array();
		$this->email->to($this->config->item('my_mail_address'));
		$this->email->from($this->config->item('my_mail_address'));
		$this->email->subject($this->load->view('pc/mail/dbdump/subject', $tmp, TRUE));
		$this->email->message($this->load->view('pc/mail/dbdump/message', $tmp, TRUE));
		$this->email->attach($backupfile);
		if ( ! $this->email->send())
		{
			$err_message = ''.
				'!! failed to send mail to admin. attach mysqldump file of esta-o database. !!'."\n";
			trigger_error($err_message, E_USER_ERROR);
		}
	}

	public function send_mail_apply_done()
	{
		if ($this->input->is_cli_request() !== TRUE) show_error('system error.');

		$tracker_id = $this->config->item('redmine_tracker_id_paid');
		$status_id = $this->config->item('redmine_status_id_done');
		$cfi_esta_app_id = $this->config->item('redmine_custom_field_id_esta_app_id');
		$cfi_esta_app_expired = $this->config->item('redmine_custom_field_id_esta_app_expired');
		$cfi_esta_mail_status = $this->config->item('redmine_custom_field_id_esta_mail_status');
		// ------------------------------------------------------------------
		// 副問い合わせの連続で処理が著しく遅くなるので、SQLを変更しました。
		// redmine側でESTA情報入力必須にしているのでコチラのSQLでも問題なく処理できると思います。
		// written by ogawa
		// ------------------------------------------------------------------
		/*
		$sql1 = 'select id from issues where tracker_id = "'.$tracker_id.'" and status_id = "'.$status_id.'"';
		$sql2 = 'select customized_id from custom_values where (custom_field_id = "'.$cfi_esta_app_id.'" and value != "")';
		$sql3 = 'select customized_id from custom_values where (custom_field_id = "'.$cfi_esta_app_expired.'" and value != "")';
		$sql4 = 'select customized_id from custom_values where (custom_field_id = "'.$cfi_esta_mail_status.'" and value = "未送信")';
		$sql_i = $sql1.' and id in ('.$sql2.' and customized_id in ('.$sql3.' and customized_id in ('.$sql4.')))';
		*/
		$sql1 = 'select id from issues where tracker_id = "'.$tracker_id.'" and status_id = "'.$status_id.'"';
		$sql2 = 'select customized_id from custom_values where (custom_field_id = "'.$cfi_esta_mail_status.'" and value = "未送信")';
		$sql_i = $sql1.' and id in ('.$sql2.')';
		$query_i = $this->db->query($sql_i);

		if ($query_i->num_rows() > 0)
		{
			$app_values = array();
			$items = array(
				'lastname' => $this->config->item('redmine_custom_field_id_lastname'),
				'firstname' => $this->config->item('redmine_custom_field_id_firstname'),
				'email' => $this->config->item('redmine_custom_field_id_email'),
				'esta_app_id' => $this->config->item('redmine_custom_field_id_esta_app_id'),
				'esta_app_expired' => $this->config->item('redmine_custom_field_id_esta_app_expired'),
			);
			foreach ($query_i->result() as $row_i)
			{
				foreach ($items as $key => $item)
				{
					$sql_c = ''.
						'select '.
							'value '.
						'from '.
							'custom_values '.
						'where '.
							'customized_id = "'.$row_i->id.'" and '.
							'custom_field_id = "'.$item.'"';
					$query_c = $this->db->query($sql_c);
					$row_c = $query_c->row(); 
					$app_values[$key] = $row_c->value;
				}

				// 渡航認証通知メールをお客様に送信（コピーを管理者に送信）
				$this->email->to($app_values['email']);
				$this->email->from($this->config->item('my_mail_address'));
				$this->email->subject($this->load->view('pc/mail/done/subject', $app_values, TRUE));
				$this->email->message($this->load->view('pc/mail/done/message', $app_values, TRUE));
				$this->email->bcc($this->config->item('my_mail_address'));
				if ( ! $this->email->send())
				{
					$mail_status = '送信失敗';
					$err_message = ''.
						'!! failed to send mail to customer (and admin). a application process is completed. !!'."\n".
						'$app_values => '.var_export($app_values, TRUE);
					trigger_error($err_message, E_USER_ERROR);
				}
				else
				{
					$mail_status = '送信済み';
				}
				$this->_write_esta_mail_status(
					$mail_status,
					$row_i->id,
					$app_values['esta_app_id'],
					$app_values['esta_app_expired']
				);
			}
		}
	}

	private function _write_esta_mail_status($esta_mail_status, $id, $esta_app_id, $esta_app_expired)
	{
		$values = array(
			'id' => $id,
			'key' => $this->config->item('redmine_rest_key'),
			'custom_fields' => array(
				array(
					'id' => $this->config->item('redmine_custom_field_id_esta_app_id'),
					'value' => $esta_app_id,
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_esta_app_expired'),
					'value' => $esta_app_expired,
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_esta_mail_status'),
					'value' => $esta_mail_status,
				),
			),
		);
		$this->redmine->set($values)->save();
		if ($this->redmine->error !== FALSE)
		{
			$message = ''.
				'failed to update mail status on redmine db.'."\n".
				'error message is ... '.$this->redmine->error."\n".
				'$values => '.var_export($values, TRUE);
			trigger_error($message, E_USER_ERROR);
		}
	}

	public function addup_chart()
	{
		if ($this->input->is_cli_request() !== TRUE) show_error('system error.');

		// 直近のお申込みのあった日から数えて何番目からを対象に集計するか
		$target_count = 5;
		$sql_date = ''.
			'select '.
				'distinct date_format(start_date, "%Y%m%d") as start_date '.
			'from '.
				'issues '.
			'order by '.
				'start_date desc';
		$query_date = $this->db->query($sql_date);
		if ($query_date->num_rows() === 0) exit;
		$rows = $query_date->result_array();
		if (count($rows) > $target_count)
		{
			$target_date = $rows[$target_count]['start_date'];
		}
		else
		{
			$row = end($rows);
			$target_date = $row['start_date'];
		}

		// 集計処理
		$ads = array(
			'all',
			'google',
			'yahoo',
			'other',
		);
		$limit_date = date('Ymd');
		for ($i = $target_date; $i <= $limit_date; $i = date('Ymd', strtotime('+1 day', strtotime($i))))
		{
			foreach ($ads as $ad)
			{
				$addup = array();

				// 共通抽出条件
				$cnd_date = 'start_date = "'.$i.'"';
				$subquery_ad = 'select distinct customized_id from custom_values';
				if ($ad !== 'all')
				{
					$subquery_ad .= ' where '.
						'custom_field_id = "'.$this->config->item('redmine_custom_field_id_ad').'" and '.
						'value = "'.$ad.'"';
				}

				// 申請数
				$sql_apply = ''.
					'select '.
						'count(id) as apply '.
					'from '.
						'issues '.
					'where '.
						$cnd_date.' and '.
						'id in ('.$subquery_ad.')';

				// 決済数
				$sql_paid = ''.
					'select '.
						'count(id) as paid '.
					'from '.
						'issues '.
					'where '.
						'tracker_id = "'.$this->config->item('redmine_tracker_id_paid').'" and '.
						$cnd_date.' and '.
						'id in ('.$subquery_ad.')';

				// 各件数情報を取得
				$sqls = array(
					'apply' => $sql_apply,
					'paid'  => $sql_paid,
				);
				foreach ($sqls as $key => $sql)
				{
					$query_{$key} = $this->db->query($sql);
					$row_{$key} = $query_{$key}->row(); 
					$addup[$key] = $row_{$key}->{$key};
				}

				// 性別
				$sexs = array('M', 'F');
				foreach ($sexs as $sex)
				{
					$subquery_sex = ''.
						'select '.
							'distinct customized_id '.
						'from '.
							'custom_values '.
						'where '.
							'custom_field_id = "'.$this->config->item('redmine_custom_field_id_sex').'" and '.
							'value = "'.$sex.'"';

					$sql = ''.
						'select '.
							'count(id) as sex '.
						'from '.
							'issues '.
						'where '.
							$cnd_date.' and '.
							'id in ('.$subquery_sex.' and customized_id in ('.$subquery_ad.'))';

					$query = $this->db->query($sql);
					$row = $query->row(); 
					$addup['sex_'.$sex] = $row->sex;
				}

				// 時間帯
				$times = array(
					'0'  => array('0', '2'),
					'3'  => array('3', '5'),
					'6'  => array('6', '8'),
					'9'  => array('9', '11'),
					'12' => array('12', '14'),
					'15' => array('15', '17'),
					'18' => array('18', '20'),
					'21' => array('21', '23'),
				);
				foreach ($times as $key => $time)
				{
					$sql = ''.
						'select '.
							'count(id) as time '.
						'from '.
							'issues '.
						'where '.
							'hour(created_on) between '.$time[0].' and '.$time[1].' and '.
							$cnd_date.' and '.
							'id in ('.$subquery_ad.')';

					$query = $this->db->query($sql);
					$row = $query->row(); 
					$addup['time_'.$key] = $row->time;
				}

				// 年齢層
				$ages = array('0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100');
				foreach ($ages as $age)
				{
					$subquery_age = ''.
						'select '.
							'distinct customized_id '.
						'from '.
							'custom_values '.
						'where '.
							'custom_field_id = "'.$this->config->item('redmine_custom_field_id_age_zone').'" and '.
							'value = "'.$age.'"';

					$sql = ''.
						'select '.
							'count(id) as age '.
						'from '.
							'issues '.
						'where '.
							$cnd_date.' and '.
							'id in ('.$subquery_age.' and customized_id in ('.$subquery_ad.'))';

					$query = $this->db->query($sql);
					$row = $query->row(); 
					$addup['age_'.$age] = $row->age;
				}

				// 都道府県
				$pref_names = array();
				$pref_infos = $this->config->item('pref_infos');
				foreach ($pref_infos as $pref_info)
				{
					$pref_names[] = $pref_info['pref_name_mb2'];
				}
				foreach ($pref_names as $pref_name)
				{
					$subquery_pref = ''.
						'select '.
							'distinct customized_id '.
						'from '.
							'custom_values '.
						'where '.
							'custom_field_id = "'.$this->config->item('redmine_custom_field_id_where_access_from').'" and '.
							'value = "JP:'.$pref_name.'"';

					$sql = ''.
						'select '.
							'count(id) as pref '.
						'from '.
							'issues '.
						'where '.
							$cnd_date.' and '.
							'id in ('.$subquery_pref.' and customized_id in ('.$subquery_ad.'))';

					$query = $this->db->query($sql);
					$row = $query->row(); 
					$addup[$pref_name] = $row->pref;
				}

				// 曜日
				$week_days = array('月', '火', '水', '木', '金', '土', '日');
				foreach ($week_days as $week_day)
				{
					$subquery_week = ''.
						'select '.
							'distinct customized_id '.
						'from '.
							'custom_values '.
						'where '.
							'custom_field_id = "'.$this->config->item('redmine_custom_field_id_app_week').'" and '.
							'value = "'.$week_day.'"';

					$sql = ''.
						'select '.
							'count(id) as week_day '.
						'from '.
							'issues '.
						'where '.
							$cnd_date.' and '.
							'id in ('.$subquery_week.' and customized_id in ('.$subquery_ad.'))';

					$query = $this->db->query($sql);
					$row = $query->row(); 
					$addup[$week_day] = $row->week_day;
				}

				// 集計情報をDBに書き出す
				$sql = 'replace into chart values ("'.$i.'", "'.$ad.'", "'.implode($addup, '","').'")';
				if ($this->db->query($sql) === FALSE)
				{
					$message = 'failed to write db chart info.';
					trigger_error($message, E_USER_ERROR);
				}
			}
		}
	}

	public function report()
	{
		$sql = ''.
			'select '.
				'* '.
			'from '.
				'chart '.
			'where '.
				'ad = "all" and '.
				'date = CURDATE()'.
			'limit '.
				'1';

		$query = $this->db->query($sql);
		if ($query->num_rows() === 0) exit;
		$rows = $query->result_array();

		$this->email->to($this->config->item('my_mail_address'));
		$this->email->from($this->config->item('my_mail_address'));
		$this->email->subject($this->load->view('pc/mail/report/subject', $rows[0], TRUE));
		$this->email->message($this->load->view('pc/mail/report/message', $rows[0], TRUE));
		if ( ! $this->email->send())
		{
			$err_message = ''.
				'!! failed to send mail. report application counts of today. !!'."\n";
			trigger_error($err_message, E_USER_ERROR);
		}
	}
}
