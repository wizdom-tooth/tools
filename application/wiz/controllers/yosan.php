<?php

class Addup_Monthly extends CI_Controller_With_Auth {

	private $_kinds = array(
		'total',
		'complete',
		'flets',
		'other',
		'isp_total',
		'isp_biglobe',
		'isp_ocn',
		'isp_yahoo',
		'iten',
		'iten_with_isp',
		'only_isp',
		'hikari_tel_total',
		'hikari_tel_plan_base',
		'hikari_tel_plan_anshin',
		'hikari_tel_plan_anshin_more',
		'hikari_tel_plan_a',
		'option_virus',
		'option_remote',
		'option_hikari_tv_pa',
		'option_hikari_tv',
		'option_hikari_portable',
		'e_hikari_fiber_kddi',
		'e_hikari_fiber_ucom',
		'mobile_adsl_emobile',
		'mobile_adsl_eaccess',
		'mobile_adsl_yahoobb',
		'catv_itiscom',
		'catv_jcnyokohama',
	);

	private $_select_fields = array(
		'month',
		'channel',
		'east_or_west',
		'yosan',
		'introduction',
		'contraction',
		'percent_yojitsu',
		'percent_contracted',
	);

	private $_where = array(
		'able_and_realestate' => 'channel in("エイブル", "エイブル西", "ハウパ", "ハウス・トゥ", "既存店", ">ミニミニ西日本", "既存店(西)")',
		'able_east' => 'channel = "エイブル"',
		'able_west' => 'channel = "エイブル西"',
		'realestate_east' => 'channel in("ハウパ", "ハウス・トゥ", "既存店")',
		'realestate_west' => 'channel in("ミニミニ西日本", "既存店(西)")',
		'aeras' => 'store_name = "アエラス%"',
		'soleil' => 'store_name = "ソレイユ%"',
		'prime' => 'store_name = "プライム%"',
		'housepartner' => 'channel = "ハウパ"',
		'house2house' => 'channel = "ハウス・トゥ"',
		'ablehikkoshi_east' => 'channel = "エイブル引越" and east_or_west = "東"',
		'ablehikkoshi_west' => 'channel = "エイブル引越" and east_or_west = "西"',
		'ponta_east' => 'channel = "Ponta" and east_or_west = "東"',
		'ponta_west' => 'channel = "Ponta" and east_or_west = "西"',
		'his' => 'channel = "HIS"',
		'his_east' => 'channel = "HIS" and east_or_west = "東"',
		'his_west' => 'channel = "HIS" and east_or_west = "西"',
		'nissei' => 'channel = "日本生命"',
		'nissei_east' => 'channel = "日本生命" and east_or_west = "東"',
		'nissei_west' => 'channel = "日本生命" and east_or_west = "西"',
		'univ' => 'channel = "大学東" or channel = "大学西"',
		'univ_east' => 'channel = "大学東"',
		'univ_west' => 'channel = "大学西"',
		'isp' => 'status = "オプション契約"',
		'iten' => 'service in("フレッツ光移転(東京・千葉)", "フレッツ光(移転)")',
		'fletsclub_iten' => 'service = "フレッツ光移転(その他)"',
		'ocn_upsell' => 'channel = "hogehoge!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!保留"',
		'benefit' => 'benefit not in("特典なし", "")',
	);

	private $_db_wizp = NULL;

	public function __construct()
	{
		parent::__construct();
		$this->ag_auth->restrict('manager');
		$this->config->load('wiz_form');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->_db_wizp = $this->load->database('wizp', TRUE);
	}

	// 対象データ無しの空集計配列を返す
	/*
	private function _get_sum_empty($date, $time_zone)
	{
		$sum_empty  = array();
		foreach ($this->_select_fields as $field)
		{
			if ($field === 'date')
			{
				$sum_empty['date'] = $date;
			}
			elseif ($field === 'time_zone')
			{
				$sum_empty['time_zone'] = $time_zone;
			}
			else
			{
				$sum_empty[$field] = 0;
			}
		}
		return $sum_empty;
	}
	*/

	public function index($year = date('Y'), $month = date('m'))
	{
		// 予算データが入力されていたら妥当性を確認してDBに入力

        // ------------------------------------
        // カレンダー
        // ------------------------------------

        $calendar_links = array();
		/*
        for ($i = 1; $i <= date('t', strtotime($y.$m.$d)); $i++)
        {
            $target_ym = $year.$month;
            $cur_ym = date('Ym');
            if ($target_ym < $cur_ym || $i <= date('j'))
            {
                $calendar_links[$i] = base_url('addup/index/'.$y.'/'.$m.'/'.sprintf('%02d', $i).'/');
            }
            else
            {
                break;
            }
        }
		*/
        $calendar = $this->calendar->generate($year, $month, $calendar_links);

		$data = array(
			'year' => $year,
			'month' => $month,
		);
		$this->ag_auth->view('contents/yosan/index', $data);
	}
}
