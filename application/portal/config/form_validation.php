<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
	'improvement_data_convert' => array(
		array(
			'field' => 'lastname',
			'label' => '姓',
			'rules' => 'convert[single]|convert[space_strip]|trim|strtoupper|name|strip_tags|xss_clean|required'
		),
		array(
			'field' => 'firstname',
			'label' => '名',
			'rules' => 'convert[single]|convert[space_strip]|trim|strtoupper|name|strip_tags|xss_clean|required'
		),
		array(
			'field' => 'email',
			'label' => 'メールアドレス',
			'rules' => 'convert[single]|trim|strtolower|valid_email|valid_email_domain|strip_tags|xss_clean|required'
		),
		array(
			'field' => 'country_national',
			'label' => '国籍',
			'rules' => 'convert[single]|convert[space_strip]|trim|strtoupper|strip_tags|xss_clean|required'
		),
		array(
			'field' => 'sex',
			'label' => '性別',
			'rules' => 'convert[single]|convert[space_compress]|trim|strtoupper|sex|strip_tags|xss_clean|required'
		),
		array(
			'field' => 'tel',
			'label' => '電話番号',
			'rules' => 'convert[single]|convert[space_strip]|convert[phone]|trim|phone|strip_tags|xss_clean|required'
		),
	),
);

/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */
