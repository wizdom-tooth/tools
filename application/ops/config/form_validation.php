<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
	// お申込み
	'apply' => array(
		array(
			'field' => 'lastname',
			'label' => '姓',
			'rules' => 'convert[single]|convert[space_compress]|trim|max_length[30]|strtoupper|required|name|strip_tags|xss_clean'
		),
		array(
			'field' => 'firstname',
			'label' => '名',
			'rules' => 'convert[single]|convert[space_compress]|trim|max_length[30]|strtoupper|required|name|strip_tags|xss_clean'
		),
		array(
			'field' => 'email',
			'label' => 'メールアドレス',
			'rules' => 'convert[single]|trim|strtolower|required|valid_email|valid_email_domain|strip_tags|xss_clean'
		),
		array(
			'field' => 'email_confirm',
			'label' => 'メールアドレス（確認）',
			'rules' => 'matches[email]|convert[single]|trim|strtolower|required|valid_email|valid_email_domain|strip_tags|xss_clean'
		),
		array(
			'field' => 'birth_year',
			'label' => '生年月日（年）',
			'rules' => 'required'
		),
		array(
			'field' => 'birth_month',
			'label' => '生年月日（月）',
			'rules' => 'required'
		),
		array(
			'field' => 'birth_day',
			'label' => '生年月日（日）',
			'rules' => 'required|valid_birth_date'
		),
		array(
			'field' => 'sex',
			'label' => '性別',
			'rules' => 'required'
		),
		array(
			'field' => 'tel',
			'label' => '電話番号',
			'rules' => 'convert[single]|convert[space_strip]|convert[phone]|trim|required|phone|strip_tags|xss_clean'
		),
		array(
			'field' => 'passport_number',
			'label' => 'パスポート番号',
			'rules' => 'convert[single]|convert[space_strip]|trim|strtoupper|required|alpha_numeric|passport_number|strip_tags|xss_clean'
		),
		array(
			'field' => 'passport_from_year',
			'label' => 'パスポート発行日（年）',
			'rules' => 'required'
		),
		array(
			'field' => 'passport_from_month',
			'label' => 'パスポート発行日（月）',
			'rules' => 'required'
		),
		array(
			'field' => 'passport_from_day',
			'label' => 'パスポート発行日（日）',
			'rules' => 'required|valid_passport_from_date'
		),
		array(
			'field' => 'passport_to_year',
			'label' => 'パスポート有効期限（年）',
			'rules' => 'required'
		),
		array(
			'field' => 'passport_to_month',
			'label' => 'パスポート有効期限（月）',
			'rules' => 'required'
		),
		array(
			'field' => 'passport_to_day',
			'label' => 'パスポート有効期限（日）',
			'rules' => 'required|valid_passport_to_date'
		),
		array(
			'field' => 'q1',
			'label' => '質問A',
			'rules' => 'required',
		),
		array(
			'field' => 'q2',
			'label' => '質問B',
			'rules' => 'required',
		),
		array(
			'field' => 'q3',
			'label' => '質問C',
			'rules' => 'required',
		),
		array(
			'field' => 'q4',
			'label' => '質問D',
			'rules' => 'required',
		),
		array(
			'field' => 'q5',
			'label' => '質問E',
			'rules' => 'required',
		),
		array(
			'field' => 'q6',
			'label' => '質問F',
			'rules' => 'required',
		),
		array(
			'field' => 'q6_when',
			'label' => '質問F いつ',
			'rules' => 'convert[space_strip]|trim|max_length[30]|strip_tags|xss_clean',
		),
		array(
			'field' => 'q6_where',
			'label' => '質問F どこで',
			'rules' => 'convert[space_strip]|trim|max_length[30]|strip_tags|xss_clean',
		),
		array(
			'field' => 'q7',
			'label' => '質問G',
			'rules' => 'required',
		),
		array(
			'field' => 'billing_last_name',
			'label' => '決済者 姓',
			'rules' => 'convert[single]|convert[space_compress]|trim|strtoupper|required|strip_tags|xss_clean',
		),
		array(
			'field' => 'billing_first_name',
			'label' => '決済者 名',
			'rules' => 'convert[single]|convert[space_compress]|trim|strtoupper|required|strip_tags|xss_clean',
		),
		array(
			'field' => 'billing_country',
			'label' => '決済者 居住国',
			'rules' => 'convert[space_strip]|trim|required|strip_tags|xss_clean',
		),
		array(
			'field' => 'billing_zip',
			'label' => '決済者 郵便番号',
			'rules' => 'convert[postal]|convert[space_strip]|trim|required|postal|strip_tags|xss_clean',
		),
		array(
			'field' => 'billing_state',
			'label' => '決済者 都道府県',
			'rules' => 'required',
		),
		array(
			'field' => 'billing_city',
			'label' => '決済者 市区町村',
			'rules' => 'convert[space_strip]|trim|required|strip_tags|xss_clean',
		),
		array(
			'field' => 'billing_address1',
			'label' => '決済者 番地',
			'rules' => 'convert[single]|convert[space_strip]|trim|required|strip_tags|xss_clean',
		),
		array(
			'field' => 'kiyaku1',
			'label' => '規約1',
			'rules' => 'required|exact_value[Yes]'
		),
		array(
			'field' => 'kiyaku2',
			'label' => '規約2',
			'rules' => 'required|exact_value[Yes]'
		),
	),
	// お問合せ
	'contact' => array(
		array(
			'field' => 'name',
			'label' => 'お名前',
			'rules' => 'convert[single]|convert[space_compress]|trim|strtoupper|required|strip_tags|xss_clean'
		),
		array(
			'field' => 'email',
			'label' => 'メールアドレス',
			'rules' => 'convert[single]|trim|strtolower|required|valid_email|valid_email_domain|strip_tags|xss_clean'
		),
		array(
			'field' => 'message',
			'label' => 'メッセージ',
			'rules' => 'trim|required|strip_tags|xss_clean'
		),
	),
	// 申請状況確認
	'status' => array(
		array(
			'field' => 'app_id',
			'label' => 'お申込みID',
			'rules' => 'convert[single]|convert[space_strip]|trim|strip_tags|required|alpha_numeric|xss_clean'
		),
	),
);

/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */
