<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Redmine用設定
|--------------------------------------------------------------------------
*/

// API関連
$config['redmine_rest_key'] = '5378f40c6b498a4e0f642fd37ec81a7b373bea2f';

// プロジェクト
$config['redmine_project_id_esta'] = 'esta_onlinecenter';

// トラッカー
$config['redmine_tracker_id_paid'] = '4';
$config['redmine_tracker_id_shinsei'] = '5';

// 優先度
$config['redmine_priority_id_normal'] = '2';

// ユーザー
$config['redmine_author_id_admin'] = '1';

// カスタムフィールド
$config['redmine_custom_field_id_lastname'] = '1';
$config['redmine_custom_field_id_firstname'] = '2';
$config['redmine_custom_field_id_country_birth'] = '3';
$config['redmine_custom_field_id_country_national'] = '4';
$config['redmine_custom_field_id_country_live'] = '5';
$config['redmine_custom_field_id_birth_date'] = '6';
$config['redmine_custom_field_id_sex'] = '7';
$config['redmine_custom_field_id_passport_number'] = '8';
$config['redmine_custom_field_id_passport_from_date'] = '9';
$config['redmine_custom_field_id_passport_to_date'] = '10';
$config['redmine_custom_field_id_email'] = '11';
$config['redmine_custom_field_id_tel'] = '12';
$config['redmine_custom_field_id_where_access_from'] = '13';
$config['redmine_custom_field_id_esta_app_id'] = '14';
$config['redmine_custom_field_id_esta_app_expired'] = '15';
$config['redmine_custom_field_id_esta_mail_status'] = '16';
$config['redmine_custom_field_id_ad'] = '17';
$config['redmine_custom_field_id_q1'] = '18';
$config['redmine_custom_field_id_q2'] = '19';
$config['redmine_custom_field_id_q3'] = '20';
$config['redmine_custom_field_id_q4'] = '21';
$config['redmine_custom_field_id_q5'] = '22';
$config['redmine_custom_field_id_q6'] = '23';
$config['redmine_custom_field_id_q6_when'] = '24';
$config['redmine_custom_field_id_q6_where'] = '25';
$config['redmine_custom_field_id_q7'] = '26';
$config['redmine_custom_field_id_app_week'] = '27';
$config['redmine_custom_field_id_age_zone'] = '28';
$config['redmine_custom_field_id_paypal_txn_id'] = '29';
$config['redmine_custom_field_id_paypal_receipt_id'] = '30';
$config['redmine_custom_field_id_paypal_repay'] = '31';
$config['redmine_custom_field_id_user_id'] = '32';
$config['redmine_custom_field_id_app_id'] = '33';
$config['redmine_custom_field_id_what_device_access_from'] = '34';

$config['checked_elements'] = array(
	'出生国' => 'country_birth',
	'国籍' => 'country_national',
	'居住国' => 'country_live',
	'生年月日' => 'birth_date',
	'性別' => 'sex',
	'パスポート発行日' => 'passport_from_date',
	'パスポート有効期限' => 'passport_to_date',
	'質問A' => 'q1',
	'質問B' => 'q2',
	'質問C' => 'q3',
	'質問D' => 'q4',
	'質問E' => 'q5',
	'質問F' => 'q6',
	'質問F いつ？' => 'q6_when',
	'質問F どこで？' => 'q6_where',
	'質問G' => 'q7',
);

// ステータスID
$config['redmine_status_id_new'] = '1';
$config['redmine_status_id_done'] = '7';
$config['redmine_status_id_canceled'] = '8';
$config['redmine_status_id_app_reject'] = '9';
$config['redmine_status_id_repay'] = '10';
$config['redmine_status_id_pending'] = '11';
$config['redmine_status_id_wait'] = '12';

// ステータス説明
$config['redmine_status_desc_'.$config['redmine_status_id_new']] =
	'現在、申請手続きを進めております。<br />'.
	'認証結果メールがお手元に届くまで、今しばらくお待ちください。';
$config['redmine_status_desc_'.$config['redmine_status_id_done']] =
	'米国への渡航認証が許可されました。<br />'.
	'ESTA渡航申請番号、ESTA有効期限は下記表をご参照下さい。';
$config['redmine_status_desc_'.$config['redmine_status_id_canceled']] =
	'お客様のお申込みはキャンセルされました。<br />'.
	'ご返金の手続きにつきましても、処理を完了しております。';
$config['redmine_status_desc_'.$config['redmine_status_id_app_reject']] =
	'米国への渡航認証が拒否されました。<br>'.
	'詳しい情報は開示されない為、弊社ではご案内する事ができません。<br />'.
	'大使館・領事館でビザを申請すれば渡米する条件を満たすことが可能です。';
$config['redmine_status_desc_'.$config['redmine_status_id_repay']] =
	'お客様のお申込みはキャンセルされました。<br />'.
	'現在、ご返金のお手続きを行っておりますので、今暫くお待ちいただけますと幸いです。';
$config['redmine_status_desc_'.$config['redmine_status_id_pending']] =
	'現在、一時的に申請手続きを保留とさせていただいております。<br />'.
	'保留の原因としては、お客様の申請情報が既に登録済みである事等が考えられますが、<br />'.
	'詳細につきましては、弊社からお送りしておりますメールをご確認頂けますと幸いです。';
