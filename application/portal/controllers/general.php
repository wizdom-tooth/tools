<?php

class General extends CI_Controller_With_Auth
{
	public function index()
	{
		if (logged_in())
		{
			$this->ag_auth->view('general/top');
		}
		else
		{
			$this->login();
		}
	}

	public function delete_user()
	{
		$this->ag_auth->restrict('admin');
	    $this->load->library('table');		
		$data = $this->db->get($this->ag_auth->config['auth_user_table']);
		$result = $data->result_array();
		$this->table->set_heading('Username', 'Email', 'Actions'); // Setting headings for the table
		foreach($result as $value => $key)
		{
			$actions = anchor('delete_user_done/'.$key['id'].'/', '[Delete]'); // Build actions links
			$this->table->add_row($key['username'], $key['email'], $actions); // Adding row to table
		}
		$this->ag_auth->view('general/delete_user'); // Load the view
	}
	
	public function delete_user_done($id)
	{
		$this->ag_auth->restrict('admin');
		$this->db->where('id', $id)->delete($this->ag_auth->config['auth_user_table']);
		$this->ag_auth->view('general/delete_user_done');
	}
}
