<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Yosanmonth {

    // raw
    private $_channel = '';
    private $_wiz_month_id = '';
    private $_introduction_info = array();
    private $_flets_contract_ratio = 0;
    private $_flets_complete_ratio = 0;
    private $_flets_isp_set_ratio_info = array();
    private $_flets_option_set_ratio_info = array();
    private $_iten_contract_count_info = array();
    private $_iten_isp_set_ratio_info = array();
    private $_other_contract_ratio_info = array();
    private $_other_complete_ratio_info = array();
    private $_onlyisp_contract_ratio = 0;
    private $_onlyisp_complete_ratio = 0;
    private $_benefit_contract_ratio = 0;
    private $_benefit_complete_ratio = 0;
    // cooked
    private $_sum_introduction = 0;
    private $_flets_contract_count = 0;
    private $_flets_complete_count = 0;
    private $_flets_isp_set_count_info = array();
    private $_sum_flets_isp_set_count = 0;
    private $_flets_option_set_count_info = array();
    private $_sum_flets_option_set_count = 0;
    private $_sum_iten_contract_count = 0;
    private $_iten_isp_set_count_info = array();
    private $_sum_iten_isp_set_count = 0;
    private $_other_contract_count_info = array();
    private $_sum_other_contract_count = 0;
    private $_other_complete_count_info = array();
    private $_sum_other_complete_count = 0;
    private $_onlyisp_contract_count = 0;
    private $_onlyisp_complete_count = 0;
    private $_benefit_contract_count = 0;
    private $_benefit_complete_count = 0;

    public function init(array $yosan_month_info)
    {
        // raw
        $this->_channel = $yosan_month_info['channel'];
        $this->_wiz_month_id = $yosan_month_info['wiz_month_id'];
        $this->_introduction_info = unserialize($yosan_month_info['introduction_count_complex']);
        $this->_flets_contract_ratio = $yosan_month_info['flets_contract_ratio'];
        $this->_flets_complete_ratio = $yosan_month_info['flets_complete_ratio'];
        $this->_flets_isp_set_ratio_info = unserialize($yosan_month_info['flets_isp_set_ratio_complex']);
        $this->_flets_option_set_ratio_info = unserialize($yosan_month_info['flets_option_set_ratio_complex']);
        $this->_iten_contract_count_info = unserialize($yosan_month_info['iten_contract_count_complex']);
        $this->_iten_isp_set_ratio_info = unserialize($yosan_month_info['iten_isp_set_ratio_complex']);
        $this->_other_contract_ratio_info = unserialize($yosan_month_info['other_contract_ratio_complex']);
        $this->_other_complete_ratio_info = unserialize($yosan_month_info['other_complete_ratio_complex']);
        $this->_onlyisp_contract_ratio = $yosan_month_info['onlyisp_contract_ratio'];
        $this->_onlyisp_complete_ratio = $yosan_month_info['onlyisp_complete_ratio'];
        $this->_benefit_contract_ratio = $yosan_month_info['benefit_contract_ratio'];
        $this->_benefit_contract_ratio = $yosan_month_info['benefit_complete_ratio'];

        // cooked
        $this->_sum_introduction = array_sum($this->_introduction_info);
        $this->_flets_contract_count = round($this->_sum_introduction * ($this->_flets_contract_ratio / 100));
        $this->_flets_complete_count = round($this->_flets_contract_count * ($this->_flets_complete_ratio / 100));
        foreach ($this->_flets_isp_set_ratio_info as $key => $ratio)
        {
            $this->_flets_isp_set_count_info[$key] = round($this->_flets_contract_count * ($ratio / 100));
        }
        $this->_sum_flets_option_set_count = array_sum($this->_flets_isp_set_count_info);
        foreach ($this->_flets_option_set_ratio_info as $key => $ratio)
        {
            $this->_flets_option_set_count_info[$key] = round($this->_flets_contract_count * ($ratio / 100));
        }
        $this->_sum_flets_option_set_count = array_sum($this->_flets_option_set_count_info);
        $this->_sum_iten_contract_count = array_sum($this->_iten_contract_count_info);
        foreach ($this->_iten_isp_set_ratio_info as $key => $ratio)
        {
            $this->_iten_isp_set_count_info[$key] = round($this->_sum_iten_contract_count * ($ratio / 100));
        }
        $this->_sum_iten_isp_set_count = array_sum($this->_iten_isp_set_count_info);
        foreach ($this->_other_contract_ratio_info as $key => $ratio)
        {
            $this->_other_contract_count_info[$key] = round($this->_sum_introduction * ($ratio / 100));
        }
        $this->_sum_other_contract_count = array_sum($this->_other_contract_count_info);
        foreach ($this->_other_complete_ratio_info as $key => $ratio)
        {
            $this->_other_complete_count_info[$key] = round($this->_other_contract_count_info[$key] * ($ratio / 100));
        }
        $this->_onlyisp_contract_count = round($this->_sum_introduction * ($this->_onlyisp_contract_ratio / 100));
        $this->_onlyisp_complete_count = round($this->_onlyisp_contract_count * ($this->_onlyisp_complete_ratio / 100));
        $this->_benefit_contract_count = round($this->_sum_introduction * ($this->_benefit_contract_ratio / 100));
        $this->_benefit_complete_count = round($this->_benefit_contract_count * ($this->_benefit_complete_ratio / 100));
    }

    public function get($key)
    {
        $key = '_'.$key;
        return $this->$key;
    }
}
