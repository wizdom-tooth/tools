<?php

class Notify extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->config->load('esta_paypal');
		$this->config->load('esta_redmine');
		$this->load->database();
		$this->load->library('redmine');
		$this->load->library('email');
	}

	public function index()
	{
		// paypal設定情報を取り出す
		$paypal_api_url_webscr = $this->config->item('paypal_api_url_webscr');
		$paypal_param_receiver_email = $this->config->item('paypal_param_receiver_email');
		$paypal_param_mc_gross = $this->config->item('paypal_param_mc_gross');
		$paypal_param_mc_currency = $this->config->item('paypal_param_mc_currency');

		// paypal照合用api実行
		$post = $this->input->post();
		$post['cmd'] = '_notify-validate';
		$query = http_build_query($post);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $paypal_api_url_webscr);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$result = curl_exec($ch);
		curl_close($ch);

		// リクエストの妥当性チェック
		if ($result === FALSE || $result === 'INVALID')
		{
			$message = ''.
				'!! failed to verify paypal IPN. validation result is not "VERIFIED". !!'."\n".
				'result: '.$result."\n".
				'$post => '.var_export($post, TRUE);
			trigger_error($message, E_USER_ERROR);
			exit;
		}
		else if ($result === 'VERIFIED')
		{
			// check the payment status
			if ($post['payment_status'] !== 'Completed')
			{
				$pending_reason = (isset($post['pending_reason'])) ? $post['pending_reason'] : 'unknown';
				$message = ''.
					'failed to verify paypal IPN. payment status is not "Completed".'."\n".
					'payment status ... '.$post['payment_status']."\n".
					'app_id ... '.$post['custom']."\n".
					'pending_reason ... '.$pending_reason;
				log_message('info', $message);
				exit;
			}
			// check the payment info
			elseif (
				$post['receiver_email'] !== $paypal_param_receiver_email ||
				$post['mc_gross'] !== $paypal_param_mc_gross ||
				$post['mc_currency'] !== $paypal_param_mc_currency
			)
			{
				$message = ''.
					'!! failed to verify paypal IPN. following payment values is wrong. !!'."\n".
					'receiver_email: '.$post['receiver_email']."\n".
					'mc_gross: '.$post['mc_gross']."\n".
					'mc_currency: '.$post['mc_currency'];
				trigger_error($message, E_USER_ERROR);
				exit;
			}
			// check that txn_id has not been previously processed
			else
			{
				$query_str = ''.
					'select '.
						'* '.
					'from '.
						'custom_values '.
					'where '.
						'value = "' . $post['txn_id'] . '"';
				$query = $this->db->query($query_str);
				if ($query->num_rows() > 0)
				{
					$message = ''.
						'failed to verify paypal IPN. following txn_id is already exists.'."\n".
						'txn_id: '.$post['txn_id']."\n".
						'$post => '.var_export($post, TRUE);
					trigger_error($message, E_USER_ERROR);
					exit;
				}
			}
		}
		else
		{
			$message = ''.
				'failed to verify paypal IPN. unknown result.'."\n".
				'result: '.$result."\n".
				'$post => '.var_export($post, TRUE);
			trigger_error($message, E_USER_ERROR);
			exit;
		}

		// 受領書IDが付与されていない場合がある
		if ( ! isset($post['receipt_id']) || $post['receipt_id'] === '')
		{
			$post['receipt_id'] = 'UNKNOWN';
		}

		// ---------------------------
		// 申請受付処理
		// ---------------------------

		// 対象チケットの情報を取り出す
		$query_str = ''.
			'select '.
				'i.* '.
			'from '.
				'issues i, custom_values c '.
			'where '.
				'i.tracker_id = "' . $this->config->item('redmine_tracker_id_shinsei') . '" and '.
				'c.customized_id = i.id and '.
				'c.value = "' . $post['custom'] . '"';
		$query = $this->db->query($query_str);
		if ($query->num_rows() > 0)
		{
			$issue = $query->row();

			// お申込み情報を取り出す
			$items = array(
				'lastname',
				'firstname',
				'country_birth',
				'country_national',
				'country_live',
				'birth_date',
				'sex',
				'passport_number',
				'passport_from_date',
				'passport_to_date',
				'email',
				'tel',
				'app_id',
				'q1',
				'q2',
				'q3',
				'q4',
				'q5',
				'q6',
				'q6_when',
				'q6_where',
				'q7',
				'txn_id',
				'receipt_id',
			);
			$app_values = array();
			foreach ($items as $item)
			{
				$custom_field_id = $this->config->item('redmine_custom_field_id_'.$item);
				$s = ''.
					'select '.
						'value '.
					'from '.
						'custom_values '.
					'where '.
						'customized_id = "'.$issue->id.'" and '.
						'custom_field_id = "'.$custom_field_id.'"';
				$q = $this->db->query($s);
				if ($q->num_rows() > 0)
				{
					$r = $q->row();
					$app_values[$item] = $r->value;
				}
				else
				{
					$app_values[$item] = '';
				}
			}

			// 既に決済済み且つ受領書IDが違った場合
			if
			(
				($app_values['txn_id'] !== '' && $app_values['receipt_id'] !== '') &&
				($app_values['receipt_id'] !== $post['receipt_id'])
			)
			{
				$message = ''.
					'!! detected duplicate payments, please repayment overcharging !!'."\n".
					'!! 重複決済の可能性があります。必要があれば、下記お申込みについて全額返金処理を行って下さい !!'."\n".
					'name => ' . $app_values['lastname'].' '.$app_values['firstname']."\n".
					'txn_id => ' . $post['txn_id']."\n".
					'receipt_id => ' . $post['receipt_id']."\n";
				trigger_error($message, E_USER_ERROR);
			}

			// redmineチケットのトラッカーを決済完了に更新
			$values = array(
				'id' => $issue->id,
				'key' => $this->config->item('redmine_rest_key'),
				'status_id' => $this->config->item('redmine_status_id_new'),
				'tracker_id' => $this->config->item('redmine_tracker_id_paid'),
				'custom_fields' => array(
					array(
						'id' => $this->config->item('redmine_custom_field_id_paypal_txn_id'),
						'value' => $post['txn_id'],
					),
					array(
						'id' => $this->config->item('redmine_custom_field_id_paypal_receipt_id'),
						'value' => $post['receipt_id'],
					),
				),
			);
			$this->redmine->set($values)->save();
			if ($this->redmine->error !== FALSE)
			{
				$message = ''.
					'!! failed to write paypal info on redmine db !!'."\n".
					'error message is ... '.$this->redmine->error."\n".
					'$values => '.var_export($values, TRUE);
				trigger_error($message, E_USER_ERROR);
			}
			else
			{
				// 決済完了メールをお客様に送信
				$this->email->to($app_values['email']);
				$this->email->from($this->config->item('my_mail_address'));
				$this->email->subject($this->load->view('pc/mail/paid/subject', $app_values, TRUE));
				$this->email->message($this->load->view('pc/mail/paid/message', $app_values, TRUE));
				if ( ! $this->email->send())
				{
					$err_message = ''.
						'!! failed to send mail to customer. a payment process is completed. !!'."\n".
						'$app_values => '.var_export($app_values, TRUE);
					trigger_error($err_message, E_USER_ERROR);
				}

				// 管理者宛てにコピーを送信する
				$this->email->to($this->config->item('my_mail_address'));
				$this->email->from($app_values['email']);
				$this->email->subject($this->load->view('pc/mail/paid/subject', $app_values, TRUE));
				$this->email->message($this->load->view('pc/mail/paid/message', $app_values, TRUE));
				if ( ! $this->email->send())
				{
					$err_message = ''.
						'!! failed to send mail to admin. a payment process is completed. !!'."\n".
						'$app_values => '.var_export($app_values, TRUE);
					trigger_error($err_message, E_USER_ERROR);
				}
			}
		}
	}
}
