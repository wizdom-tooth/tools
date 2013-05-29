<?php

class Improvement extends CI_Controller_With_Auth {

	private $_sitemap = array(
		'index' => array(
			'title'    => '改善提案のヒント',
			'url'      => '/improvement/index.html',
			'children' => array(
				'data' => array(
					'title'    => 'データ関連',
					'url'      => NULL,
					'children' => array(
						'data_convert' => array(
							'title'    => 'データ整形',
							'url'      => '/improvement/data_convert.html',
							'children' => NULL,
						),
						'data_input' => array(
							'title'    => 'データ入力',
							'url'      => '/improvement/data_input.html',
							'children' => NULL,
						),
					),
				),
			),
		),
	);

	private $_data = array(
		'sitemap' => NULL,
	);

    public function __construct()
    {
		parent::__construct();
		$this->ag_auth->restrict('employee');
		$this->load->library('form_validation');
		$this->load->helper('output_html');
		$this->_data['sitemap'] = $this->_sitemap;
    }

	public function index()
	{
		$this->ag_auth->view('contents/improvement/index', $this->_data);
	}

	public function data_convert()
	{
        $mail_body = trim($this->input->post('mail_body'));
		if ( ! empty($mail_body))
		{
			$data = array();
			$lines = explode("/n", $mail_body);
			foreach ($lines as $line)
			{
				if (preg_match('/姓：(.+)/', $line, $matches))
				{
					$data['lastname'] = $matches[1];
				}
				if (preg_match('/名：(.+)/', $line, $matches))
				{
					$data['firstname'] = $matches[1];
				}
				if (preg_match('/メールアドレス：(.+)/', $line, $matches))
				{
					$data['email'] = $matches[1];
				}
				if (preg_match('/性別：(.+)/', $line, $matches))
				{
					$data['sex'] = $matches[1];
				}
				if (preg_match('/国籍：(.+)/', $line, $matches))
				{
					$data['country_national'] = $matches[1];
				}
				if (preg_match('/電話番号：(.+)/', $line, $matches))
				{
					$data['tel'] = $matches[1];
				}
			}
			$_POST = $data;
			$is_form_valid = $this->form_validation->run('improvement_data_convert');
			$this->_data['is_form_valid'] = $is_form_valid;
			$this->_data['mail_body'] = $mail_body;
		}
		$this->ag_auth->view('contents/improvement/data_convert', $this->_data);
	}

	public function data_input()
	{
		$this->ag_auth->view('contents/improvement/data_input', $this->_data);
	}
}
