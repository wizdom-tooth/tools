<?php

class Cron extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->config->load('redmine');
		$this->load->library('redmine');
		$this->load->database('redmine');
	}

	// 自動ステータス移行＆担当者削除
	public function convert_status_and_strip_assignment()
	{
		//if ($this->input->is_cli_request() !== TRUE) show_error('system error.');

		$tracker_id = $this->config->item('rm_tracker_id');
		$convert_status_sets = array(
			array(
				'label' => '[move status] BASE => MANKEN',
				'src'   => $this->config->item('rm_status_id_base_done'),
				'dst'   => $this->config->item('rm_status_id_manken_wait'),
			),
			array(
				'label' => '[move status] MANKEN => TEL_BY_US',
				'src' => $this->config->item('rm_status_id_manken_done'),
				'dst' => $this->config->item('rm_status_id_tel_by_us'),
			),
			array(
				'label' => "[move status] TEL_BY_US' => TEL_BY_US",
				'src' => $this->config->item('rm_status_id_tel_by_us#'),
				'dst' => $this->config->item('rm_status_id_tel_by_us'),
			),
			array(
				'label' => "[move status] TEL_BY_CLIENT' => TEL_BY_CLIENT",
				'src' => $this->config->item('rm_status_id_tel_by_client#'),
				'dst' => $this->config->item('rm_status_id_tel_by_client'),
			),
			array(
				'label' => "[move status] TEL_ON_APODATE' => TEL_ON_APODATE",
				'src' => $this->config->item('rm_status_id_tel_on_apodate#'),
				'dst' => $this->config->item('rm_status_id_tel_on_apodate'),
			),
		);

		$err_msg = '';
		foreach ($convert_status_sets as $convert_status_set)
		{
			$sql = ''.
				'select '.
					'id '.
				'from '.
					'issues '.
				'where '.
					'tracker_id = "'.$tracker_id.'" and '.
					'status_id = "'.$convert_status_set['src'].'"';
			$query = $this->db->query($sql);

			if ($query->num_rows() === 0)
			{
				echo $convert_status_set['label'].' target ticket is nothing.<br />'."\n";
				continue;
			}
			else
			{
				foreach ($query->result() as $row)
				{
					$values = array(
						'id' => $row->id,
						'key' => $this->config->item('redmine_rest_key'),
						'status_id' => $convert_status_set['dst'],
						'assigned_to_id' => '',
					);
					$this->redmine->set($values)->save();
					if ($this->redmine->error !== FALSE)
					{
						$err_msg .=
							'!! failed to auto migrate status and stirp assignment on redmine db !!'."\n".
							'error message is ... '.$this->redmine->error."\n".
							'$values => '.var_export($values, TRUE)."\n".
							'-----'."\n";
					}
				}
			}
		}
		if ($err_msg !== '')
		{
			trigger_error($err_msg, E_USER_ERROR);
		}
		else
		{
			echo 'done all process without error.';
		}
	}
}
