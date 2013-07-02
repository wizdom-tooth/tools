<?php

/**
* Authentication Library
*
* @package Authentication
* @category Libraries
* @author Adam Griffiths
* @link http://adamgriffiths.co.uk
* @version 2.0.3
* @copyright Adam Griffiths 2011
*
* Auth provides a powerful, lightweight and simple interface for user authentication .
*/

class CI_Controller_With_Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('AG_Auth', 'form_validation'));
		$this->load->helper(array('url', 'email', 'ag_auth'));
		$this->config->load('ag_auth');
	}
	
	public function field_exists($value)
	{
		$field_name  = (valid_email($value)  ? 'email' : 'username');
		$user = $this->ag_auth->get_user($value, $field_name);
		if (array_key_exists('id', $user))
		{
			$this->form_validation->set_message('field_exists', 'The ' . $field_name . ' provided already exists, please use another.');
			return FALSE;
		}
		else
		{			
			return TRUE;
		}
	}
	
	public function regist_user()
	{
		$this->ag_auth->restrict('admin');
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[6]|callback_field_exists');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[password_conf]');
		$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'required|min_length[6]|matches[password]');
		$this->form_validation->set_rules('email', 'Email Address', 'required|min_length[6]|valid_email|callback_field_exists');

		if ($this->form_validation->run() === FALSE)
		{
			$this->ag_auth->view('general/regist_user');
		}
		else
		{
			$username = set_value('username');
			$password = $this->ag_auth->salt(set_value('password'));
			$email = set_value('email');
			if ($this->ag_auth->regist_user($username, $password, $email) === TRUE)
			{
				$data['message'] = "The user account has now been created.";
				$this->ag_auth->view('general/message', $data);
				
			}
			else
			{
				$data['message'] = "The user account has not been created.";
				$this->ag_auth->view('general/message', $data);
			}
		}
	}
	
	public function login($redirect = NULL)
	{
		if ($redirect === NULL)
		{
			$redirect = $this->ag_auth->config['auth_login'];
		}
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[6]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		if ($this->form_validation->run() === FALSE)
		{
			$this->ag_auth->view('general/login');
		}
		else
		{
			$username = set_value('username');
			$password = $this->ag_auth->salt(set_value('password'));
			$field_type  = (valid_email($username)  ? 'email' : 'username');
			$user_data = $this->ag_auth->get_user($username, $field_type);
			if (isset($user_data['password']) && $user_data['password'] === $password)
			{
				unset($user_data['password']);
				unset($user_data['id']);
				$this->ag_auth->login_user($user_data);
				redirect($redirect);
			}
			else
			{
				$data['message'] = "The username and password did not match.";
				$this->ag_auth->view('general/message', $data);
			}
		}
	}
	
	public function logout()
	{
		$this->ag_auth->logout();
	}
}
