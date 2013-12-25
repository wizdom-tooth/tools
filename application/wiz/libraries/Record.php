<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Record {

	private $_CI = NULL;
	private $_db = NULL;
	private $_wiz_month_id = '';
	private $_info = array(
		'is_holiday' => FALSE,
		'is_suspend' => FALSE,
	);

    public function __construct($params)
    {
		$this->_CI =& get_instance();
		$this->_CI->config->load('wiz_config');
		$this->_db = $this->_CI->load->database('wizp', TRUE);
		$this->_date = $params['date'];

        // 祝日かどうか
        $sql = 'select date, name from holiday_mst where date = "'.$this->_date.'"';
        $query = $this->_db->query($sql);
        if ($query->num_rows() > 0) 
		{
			$this->_info['is_holiday'] = TRUE;
		}

        // 休業日かどうか
        $sql = 'select date from wiz_suspend_mst where date = "'.$this->_date.'"';
        $query = $this->_db->query($sql);
        if ($query->num_rows() > 0) 
		{
			$this->_info['is_suspend'] = TRUE;
		}
    }
}
