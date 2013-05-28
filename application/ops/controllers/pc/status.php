<?php

class Status extends CI_Controller {

	const PAGE_TYPE_INIT      = 'init';
	const PAGE_TYPE_INVALID   = 'invalid';
	const PAGE_TYPE_NOT_FOUND = 'not_found';
	const PAGE_TYPE_HIT       = 'hit';

	private $_issue_id = '';
	private $_status_id = '';

	private $_data_contents = array(
		'page_type'   => self::PAGE_TYPE_INIT,
		'status_desc' => '',
		'app_values'  => array(),
	);

	public function __construct()
	{
		parent::__construct();
		$this->config->load('esta_redmine');
		$this->load->library('form_validation');
		$this->load->database();
	}

	public function index()
	{
		// お申込みIDの状態確認、データ取得
		$app_id = $this->input->get('app_id');
		if ($app_id !== FALSE && $app_id !== '')
		{
			$_POST['app_id'] = $app_id;
			if ($this->form_validation->run('status') === FALSE)
			{
				$this->_data_contents['page_type'] = self::PAGE_TYPE_INVALID;
			}
			else
			{
				$this->_set_issue_id_and_status_id($app_id);
				$status_id = $this->_get_status_id();
				if ($status_id === '')
				{
					$this->_data_contents['page_type'] = self::PAGE_TYPE_NOT_FOUND; 
				}
				else
				{
					$issue_id = $this->_get_issue_id();
					$this->_data_contents = array(
						'page_type'   => self::PAGE_TYPE_HIT,
						'status_desc' => $this->config->item('redmine_status_desc_'.$status_id),
						'app_values'  => $this->_get_app_values($issue_id),
					);
				}
			}
		}

		// ページ出力
		$data_contents = $this->_data_contents;
		$contents = $this->load->view('pc/contents/status/index', $data_contents, TRUE);
		$data_frame = array();
		$data_frame['contents'] = $contents;
		$this->load->view('pc/frame/main', $data_frame);
	}

	private function _set_issue_id_and_status_id($app_id)
	{
		$query_str = ''.
			'select '.
				'i.id, '.
				'i.status_id '.
			'from '.
				'issues i, custom_values c '.
			'where '.
				'c.customized_id = i.id and '.
				'c.value = "'.$app_id.'" and '.
				'i.tracker_id = "'.$this->config->item('redmine_tracker_id_paid').'"';
		$query = $this->db->query($query_str);
		$issue = $query->row();
		if ( ! empty($issue))
		{
			$this->_issue_id  = $issue->id;
			$this->_status_id = $issue->status_id;
		}
	}

	private function _get_issue_id()
	{
		return $this->_issue_id;
	}

	private function _get_status_id()
	{
		return $this->_status_id;
	}

	private function _get_app_values($issue_id)
	{
		// 取得対象アイテム
		$c = 'redmine_custom_field_id_';
		$items = array(
			$this->config->item($c.'esta_app_id'),
			$this->config->item($c.'esta_app_expired'),
			$this->config->item($c.'lastname'),
			$this->config->item($c.'firstname'),
			$this->config->item($c.'country_birth'),
			$this->config->item($c.'country_national'),
			$this->config->item($c.'country_live'),
			$this->config->item($c.'birth_date'),
			$this->config->item($c.'sex'),
			$this->config->item($c.'passport_number'),
			$this->config->item($c.'passport_from_date'),
			$this->config->item($c.'passport_to_date'),
			//$this->config->item($c.'email'), // 個人情報保護の目的で非表示
			//$this->config->item($c.'tel'),
			$this->config->item($c.'q1'),
			$this->config->item($c.'q2'),
			$this->config->item($c.'q3'),
			$this->config->item($c.'q4'),
			$this->config->item($c.'q5'),
			$this->config->item($c.'q6'),
			$this->config->item($c.'q6_when'),
			$this->config->item($c.'q6_where'),
			$this->config->item($c.'q7'),
		);

		// アイテム取得
		$app_values = array();
		foreach ($items as $custom_field_id)
		{
			$sql = ''.
				'select '.
					'c.name, '.
					'v.value '.
				'from '.
					'custom_fields c, '.
					'custom_values v '.
				'where '.
					'c.id = v.custom_field_id and '.
					'v.customized_id = "'.$issue_id.'" and '.
					'v.custom_field_id = "'.$custom_field_id.'"';
			$query = $this->db->query($sql);
			$row = $query->row(); 
			$app_values[$row->name] = $row->value;
		}
		return $app_values;
	}
}
