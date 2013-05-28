<?php

class Agreement extends CI_Controller {

	public function index()
	{
		mycache($this);
		$data_contents = array();
		$contents = $this->load->view('pc/contents/agreement/index', $data_contents, TRUE);
		$data_frame = array();
		$data_frame['contents'] = $contents;
		$this->load->view('pc/frame/main', $data_frame);
	}
}
