<?php

class Contact extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
		$this->load->library('session');
		$this->load->library('form_validation');
	}

	public function index()
	{
		if ($this->form_validation->run('contact') === FALSE)
		{
			$this->_load_view_index();
		}
		else
		{
			$this->session->set_userdata('contact', 'TRUE');
			$this->_load_view_confirm();
		}
	}

	public function done()
	{
		if ($this->session->userdata('contact') !== 'TRUE')
		{
			show_error('system error.');
		}
		$this->_load_view_done();
		$this->session->sess_destroy();

		// データ整形
		$data = $this->input->post();
		$data['hostname'] = $this->config->item('hostname');

		// お問合せメールを管理者宛てに送信する
		$this->email->to($this->config->item('my_mail_address'));
		$this->email->from($this->input->post('email'));
		$this->email->subject($this->load->view('pc/mail/contact/to_admin_subject', $data, TRUE));
		$this->email->message($this->load->view('pc/mail/contact/to_admin_message', $data, TRUE));
		if ( ! $this->email->send())
		{
			$err_message = ''.
				'!! failed to send mail to admin. contact message is accepted. !!'."\n".
				var_export($data, TRUE);
			trigger_error($err_message, E_USER_ERROR);
		}

		// お問合せメールを受理した事をお客様にメールで伝える
		$this->email->to($this->input->post('email'));
		$this->email->from($this->config->item('my_mail_address'));
		$this->email->subject($this->load->view('pc/mail/contact/to_customer_subject', $data, TRUE));
		$this->email->message($this->load->view('pc/mail/contact/to_customer_message', $data, TRUE));
		if ( ! $this->email->send())
		{
			$err_message = ''.
				'!! failed to send mail to customer. contact message is accepted. !!'."\n".
				var_export($data, TRUE);
			trigger_error($err_message, E_USER_ERROR);
		}
	}

	private function _load_view_index()
	{
		$data_contents = array();
		$contents = $this->load->view('pc/contents/contact/index', $data_contents, TRUE);
		$data_frame = array();
		$data_frame['contents'] = $contents;
		$this->load->view('pc/frame/main', $data_frame);
	}

	private function _load_view_confirm()
	{
		$data_contents = array();
		$data_contents = $this->input->post();
		$contents = $this->load->view('pc/contents/contact/confirm', $data_contents, TRUE);
		$data_frame = array();
		$data_frame['contents'] = $contents;
		$this->load->view('pc/frame/main', $data_frame);
	}

	private function _load_view_done()
	{
		$data_contents = array();
		$data_contents = $this->input->post();
		$contents = $this->load->view('pc/contents/contact/done', $data_contents, TRUE);
		$data_frame = array();
		$data_frame['contents'] = $contents;
		$this->load->view('pc/frame/main', $data_frame);
	}
}
