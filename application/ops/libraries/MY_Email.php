<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class MY_Email extends CI_Email {
 
	public function __construct()
	{
		parent::__construct();
	}
 
	public function subject($subject)
	{
		//$subject = $this->_prep_q_encoding($subject);
		$this->_set_header('Subject', $subject);
		return $this;
	}

	public function message($body)
	{
		if (strtolower($this->charset) == 'iso-2022-jp')
		{
			$this->_body = rtrim(str_replace("\r", "", $body));
		}
		else
		{
			//$this->_body = stripslashes(rtrim(str_replace("\r", "", $body)));
			$this->_body = rtrim(str_replace("\r", "", $body));
		}
		return $this;
	}
}
// END MY_Email class
 
/* End of file MY_Email.php */
/* Location: ./application/libraries/MY_Email.php */
