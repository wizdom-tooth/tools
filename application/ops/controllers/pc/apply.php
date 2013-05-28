<?php

class Apply extends CI_Controller {

	const PAST_ORDER_STATUS_NONE  = 'none';
	const PAST_ORDER_STATUS_MATCH = 'match';
	const PAST_ORDER_STATUS_DIFF  = 'diff';

	public function __construct()
	{
		parent::__construct();
		$this->config->load('esta_form');
		$this->config->load('esta_redmine');
		$this->config->load('esta_geo');
		$this->config->load('esta_paypal');
		$this->config->load('esta_device');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('redmine');
		$this->load->database();
	}

	public function step1()
	{
		if ($this->form_validation->run('apply') === FALSE || $this->input->post('type') === 'modify')
		{
			$this->_load_view_input();
		}
		else
		{
			$this->session->set_userdata('app', 'TRUE');
			$this->_load_view_confirm();
		}
	}

	public function step1_japanese_nationality() {$this->step1();}
	public function step1_foreign_nationality() {$this->step1();}
	public function step1_revision() {$this->step1();}

	public function step2()
	{
		if ($this->session->userdata('app') !== 'TRUE')
		{
			show_error('system error.');
		}

		// お申し込み関連情報を整形
		$app_values = $this->_cook_app_values($this->input->post());

		// 決済情報の有無や申請情報の差異を検証し表示ページを出し分ける
		$app_values = $this->_get_past_ortder_status_and_values($app_values);
		$this->output->set_header('Cache-Control: no-store');
		switch ($app_values['status'])
		{
			case self::PAST_ORDER_STATUS_NONE:
				$this->_write_issue_new($app_values);
				$this->_load_view_pay($app_values);
				break;
			case self::PAST_ORDER_STATUS_DIFF:
				$this->_load_view_diff($app_values);
				break;
			case self::PAST_ORDER_STATUS_MATCH:
				$this->_load_view_match($app_values);
				$this->session->unset_userdata('app');
				break;
		}
	}

	public function step3()
	{
		if ($this->session->userdata('app') !== 'TRUE')
		{
			show_error('system error.');
		}

		// 修正項目があれば書き込む
		if ($this->input->post('diff') === 'TRUE')
		{
			$this->_write_issue_diff();
		}
		$this->_load_view_done();
		$this->session->unset_userdata('app');
	}

	private function _load_view_input()
	{
		$data_contents = array();
		$data_contents['form_birth_year'] = $this->config->item('form_birth_year');
		$data_contents['form_passport_from_year'] = $this->config->item('form_passport_from_year');
		$data_contents['form_passport_to_year'] = $this->config->item('form_passport_to_year');
		$data_contents['form_month'] = $this->config->item('form_month');
		$data_contents['form_day'] = $this->config->item('form_day');
		$data_contents['form_country_national'] = $this->config->item('form_country_national');
		$data_contents['form_country_birth'] = $this->config->item('form_country_birth');
		$data_contents['form_country_live'] = $this->config->item('form_country_live');
		$data_contents['form_billing_country'] = $this->config->item('form_billing_country');
		$contents = $this->load->view('pc/contents/apply/input', $data_contents, TRUE);
		$data_frame = array();
		$data_frame['contents'] = $contents;
		$this->load->view('pc/frame/main', $data_frame);
	}

	private function _load_view_confirm()
	{
		$data_contents = array();
		$data_contents = $this->input->post();
		$contents = $this->load->view('pc/contents/apply/confirm', $data_contents, TRUE);
		$data_frame = array();
		$data_frame['contents'] = $contents;
		$this->load->view('pc/frame/main', $data_frame);
	}

	private function _load_view_pay($app_values)
	{
		$data_contents = array();
		$data_contents = $app_values;
		$contents = $this->load->view('pc/contents/apply/pay', $data_contents, TRUE);
		$data_frame = array();
		$data_frame['contents'] = $contents;
		$this->load->view('pc/frame/main', $data_frame);

	}

	private function _load_view_diff($app_values)
	{
		$data_contents = array();
		$data_contents = $app_values;
		$contents = $this->load->view('pc/contents/apply/diff', $data_contents, TRUE);
		$data_frame = array();
		$data_frame['contents'] = $contents;
		$this->load->view('pc/frame/main', $data_frame);
	}

	private function _load_view_match($app_values)
	{
		$data_contents = array();
		$data_contents = $app_values;
		$contents = $this->load->view('pc/contents/apply/match', $data_contents, TRUE);
		$data_frame = array();
		$data_frame['contents'] = $contents;
		$this->load->view('pc/frame/main', $data_frame);
	}

	private function _load_view_done()
	{
		$data_contents = array();
		$contents = $this->load->view('pc/contents/apply/done', $data_contents, TRUE);
		$data_frame = array();
		$data_frame['contents'] = $contents;
		$this->load->view('pc/frame/main', $data_frame);
	}

	private function _get_past_ortder_status_and_values($app_values)
	{
		$app_values['past'] = array();
		$app_values['diff'] = array();
		$app_values['status'] = NULL;

		// ユーザの最新決済済み申し込み情報を取り出す
		$query_str = ''.
			'select '.
				'i.id, i.start_date '.
			'from '.
				'issues i, custom_values c '.
			'where '.
				'c.customized_id = i.id and '.
				'c.value = "'.$app_values['user_id'].'" and '.
				'i.tracker_id = "'.$this->config->item('redmine_tracker_id_paid').'" and '.
				'i.start_date >= "'.date('Y-m-d', strtotime('-6 months')).'" '.// 半年以内
			'order by '.
				'i.created_on desc '.
			'limit '.
				'1';
		$query = $this->db->query($query_str);
		$issue = $query->row();

		if (empty($issue)) // 過去の申請情報なし
		{
			$app_values['status'] = self::PAST_ORDER_STATUS_NONE;
			return $app_values;
		}
		else
		{
			// 過去の申請のESTA有効期限が切れていたら、新規扱い
			$query_str = ''.
				'select '.
					'replace(value, "/", "") as value '.
				'from '.
					'custom_values '.
				'where '.
					'customized_id = "'.$issue->id.'" and '.
					'custom_field_id = "'.$this->config->item('redmine_custom_field_id_esta_app_expired').'"';
			$query = $this->db->query($query_str);
			if ($query->num_rows() === 0)
			{
				$app_expired = NULL;
			}
			else
			{
				$row = $query->row();
				$app_expired = $row->value;
			}
			if ( ! empty($app_expired) && (int)$app_expired <= (int)$app_values['app_date'])
			{
				$app_values['status'] = self::PAST_ORDER_STATUS_NONE;
				return $app_values;
			}

			// -----------------------------------------
			// 過去の申請情報を取得して、現在の申請情報と比較する
			// -----------------------------------------

			$app_values_past = array();
			$app_values_past['issue_id'] = $issue->id;
			$app_values_past['start_date'] = $issue->start_date;

			// 過去の申請情報（比較対象カスタムフィールド）取得
			foreach ($this->config->item('checked_elements') as $checked_elemet)
			{
				$custom_field_id = $this->config->item('redmine_custom_field_id_' . $checked_elemet);
				$query_str = ''.
					'select '.
						'value '.
					'from '.
						'custom_values '.
					'where '.
						'customized_id = "'.$issue->id.'" and '.
						'custom_field_id = "'.$custom_field_id.'"';
				$query = $this->db->query($query_str);
				$row = $query->row();
				$app_values_past[$checked_elemet] = $row->value;
			}

			// 過去の申請情報（お申込みID）取得	
			$query_str = ''.
				'select '.
					'value '.
				'from '.
					'custom_values '.
				'where '.
					'customized_id = "'.$issue->id.'" and '.
					'custom_field_id = "'.$this->config->item('redmine_custom_field_id_app_id').'"';
			$query = $this->db->query($query_str);
			$row = $query->row();
			$app_values_past['app_id'] = $row->value;

			// 現在の申請情報と過去の申請情報を比較して差異があるか評価
			$app_values_diff = array();
			foreach ($this->config->item('checked_elements') as $checked_elemet)
			{
				if ($app_values[$checked_elemet] != $app_values_past[$checked_elemet])
				{
					$app_values_diff[$checked_elemet] = TRUE;
				}
			}
			if (empty($app_values_diff) === TRUE) // 同一の申請情報
			{
				$app_values['past'] = $app_values_past;
				$app_values['status'] = self::PAST_ORDER_STATUS_MATCH;
				return $app_values;
			}
			else // 申請情報に差異あり
			{
				$app_values['past'] = $app_values_past;
				$app_values['diff'] = $app_values_diff;
				$app_values['status'] = self::PAST_ORDER_STATUS_DIFF;
				return $app_values;
			}
		}
	}

	private function _write_issue_new($app_values)
	{
		// 既に申請情報が存在した場合は上書き更新
		$query_str = ''.
			'select '.
				'i.id '.
			'from '.
				'issues i, custom_values c '.
			'where '.
				'c.customized_id = i.id and '.
				'c.value = "' . $app_values['app_id'] . '"';
		$query = $this->db->query($query_str);
		$issue = $query->row();
		$id = (empty($issue) === TRUE) ? NULL : $issue->id;

		$values = array(
			'id' => $id,
			'key' => $this->config->item('redmine_rest_key'),
			'project_id' => $this->config->item('redmine_project_id_esta'),
			'tracker_id' => $this->config->item('redmine_tracker_id_shinsei'),
			'status_id' => $this->config->item('redmine_status_id_wait'),
			'priority_id' => $this->config->item('redmine_priority_id_normal'),
			'author_id' => $this->config->item('redmine_author_id_admin'),
			'start_date' => $app_values['app_date_sep'],
			'subject' => $app_values['subject'],
			'description' => $app_values['description'],
			'custom_fields' => array(
				array(
					'id' => $this->config->item('redmine_custom_field_id_lastname'),
					'value' => $app_values['lastname'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_firstname'),
					'value' => $app_values['firstname'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_country_birth'),
					'value' => $app_values['country_birth'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_country_national'),
					'value' => $app_values['country_national'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_country_live'),
					'value' => $app_values['country_live'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_birth_date'),
					'value' => $app_values['birth_date'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_sex'),
					'value' => $app_values['sex'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_passport_number'),
					'value' => $app_values['passport_number'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_passport_from_date'),
					'value' => $app_values['passport_from_date'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_passport_to_date'),
					'value' => $app_values['passport_to_date'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_email'),
					'value' => $app_values['email'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_tel'),
					'value' => $app_values['tel'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_user_id'),
					'value' => $app_values['user_id'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_app_id'),
					'value' => $app_values['app_id'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_age_zone'),
					'value' => $app_values['age_zone'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_q1'),
					'value' => $app_values['q1'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_q2'),
					'value' => $app_values['q2'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_q3'),
					'value' => $app_values['q3'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_q4'),
					'value' => $app_values['q4'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_q5'),
					'value' => $app_values['q5'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_q6'),
					'value' => $app_values['q6'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_q6_when'),
					'value' => $app_values['q6_when'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_q6_where'),
					'value' => $app_values['q6_where'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_q7'),
					'value' => $app_values['q7'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_app_week'),
					'value' => $app_values['app_week'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_where_access_from'),
					'value' => $this->config->item('where_access_from'),
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_paypal_txn_id'),
					'value' => '',
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_paypal_receipt_id'),
					'value' => '',
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_ad'),
					'value' => (string)$this->session->userdata('ad'),
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_what_device_access_from'),
					'value' => $this->config->item('what_device_access_from'),
				),
			),
		);
		$this->redmine->set($values)->save();
		if ($this->redmine->error !== FALSE)
		{
			$message = ''.
				'failed to write redmine db. app values without paid.'."\n".
				'error message is ... '.$this->redmine->error."\n".
				'$values => '.var_export($values, TRUE);
			trigger_error($message, E_USER_ERROR);
		}
	}

	private function _write_issue_diff()
	{
		$values = array(
			'id' => $this->input->post('issue_id'),
			'key' => $this->config->item('redmine_rest_key'),
			'status_id' => $this->config->item('redmine_status_id_new'),
			'assigned_to_id' => '',
		);
		foreach ($this->config->item('checked_elements') as $checked_elemet)
		{
			if ($this->input->post($checked_elemet) !== FALSE)
			{
				$values['custom_fields'][] = array(
					'id' => $this->config->item('redmine_custom_field_id_' . $checked_elemet),
					'value' => $this->input->post($checked_elemet),
				);
			}
		}
		$values['custom_fields'][] = array(
			'id' => $this->config->item('redmine_custom_field_id_esta_app_id'),
			'value' => '',
		);
		$values['custom_fields'][] = array(
			'id' => $this->config->item('redmine_custom_field_id_esta_app_expired'),
			'value' => '',
		);
		$values['custom_fields'][] = array(
			'id' => $this->config->item('redmine_custom_field_id_esta_mail_status'),
			'value' => '未送信',
		);
		$this->redmine->set($values)->save();
		if ($this->redmine->error !== FALSE)
		{
			$message = ''.
				'failed to write redmine db. diff values.'."\n".
				'error message is ... '.$this->redmine->error."\n".
				'$values => '.var_export($values, TRUE);
			trigger_error($message, E_USER_ERROR);
		}
	}

	private function _cook_app_values($app_values)
	{
		$timestamp = time();
		$app_date = date('Ymd', $timestamp);
		$app_date_sep = date('Y-m-d', $timestamp);
		$app_week = get_mb_week($timestamp);
		$app_values['app_date'] = $app_date;
		$app_values['app_date_sep'] = $app_date_sep;
		$app_values['app_week'] = $app_week;
		$app_values['app_id'] = get_esta_app_id($app_values);
		$app_values['user_id'] = get_esta_app_user_id($app_values);
		$app_values['birth_date'] = sprintf(
			'%04d-%02d-%02d',
			$app_values['birth_year'],
			$app_values['birth_month'],
			$app_values['birth_day']
		);
		$birth_date = sprintf(
			'%04d%02d%02d',
			$app_values['birth_year'],
			$app_values['birth_month'],
			$app_values['birth_day']
		);
		$app_values['passport_from_date'] = sprintf(
			'%04d-%02d-%02d',
			$app_values['passport_from_year'],
			$app_values['passport_from_month'],
			$app_values['passport_from_day']
		);
		$app_values['passport_to_date'] = sprintf(
			'%04d-%02d-%02d',
			$app_values['passport_to_year'],
			$app_values['passport_to_month'],
			$app_values['passport_to_day']
		);
		$app_values['subject'] = $app_values['lastname'].' '.$app_values['firstname'].' '.$app_values['country_national'];
		$app_values['age_zone'] = floor(($app_values['app_date'] - $birth_date) / 100000) * 10;
		$tmp['bml_apply'] = $this->load->view('pc/contents/parts/bml_apply', $app_values, TRUE);
		$tmp['bml_confirm'] = $this->load->view('pc/contents/parts/bml_confirm', $app_values, TRUE);
		$tmp['bml_search'] = $this->load->view('pc/contents/parts/bml_search', $app_values, TRUE);
		$app_values['description'] = $this->load->view('pc/contents/parts/redmine_description', $tmp, TRUE);
		return $app_values;
	}
}
