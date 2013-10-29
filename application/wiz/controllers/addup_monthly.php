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

	public function index()
	{
		$cond = '';

		// 取得対象年月条件指定SQL WHERE句作成
		if ($this->input->get('year') === FALSE)
		{
			$year = $_GET['year'] = date('Y');
		}
		if ($this->input->get('month') === FALSE)
		{
			$month = $_GET['month'] = date('m');
		}
		if ($this->input->get('year') !== FALSE && $this->input->get('month') !== FALSE)
		{
			$year  = $_GET['year']  = $this->input->get('year');
			$month = $_GET['month'] = $this->input->get('month');
		}
		$y = sprintf('%04d', $year);
		$m = sprintf('%02d', $month);
		$ym = "{$y}{$m}";
		$cond = "month = '{$ym}'";

		// 取得対象チャネル条件指定SQL WHERE句作成
		$channel = $this->input->get('channel');
		if ($channel === FALSE)
		{
			$channel = $_GET['channel'] = 'realestate_east';
		}
		$cond .= ' and '.$this->_where[$channel];

		// ------------------------------------
		// 担当者別集計
		// ------------------------------------

/*
		// 担当者一覧
		$sum_user = array();
		$sql = ''.
			'select '.
				'distinct user_name '.
			'from '.
				'addup_user '.
			'where '.
				$cond.' '.
			'order by '.
				'user_name';
		$query = $this->_db_wizp->query($sql);
		$users = $query->result_array();

		// 担当者毎の集計
		$sql = ''.
			'select '.
				'* '.
			'from '.
				'addup_user '.
			'where '.
				$cond.' '.
			'order by '.
				'time_zone';
		$query = $this->_db_wizp->query($sql);
		$sum_user = $query->result_array();
*/

		// ------------------------------------
		// 種別別集計
		// ------------------------------------

		// 種別毎の集計情報を取得
		$sum = array();
		$select_fields_list = implode(', ', $this->_select_fields);

		foreach ($this->_kinds as $kind)
		{
			/*
			$total = array(
				'introduction_total' => 0,
				'contract_total' => 0,
				'contract_flets' => 0,
				'isp' => 0,
				'virus' => 0,
				'remote' => 0,
				'hikari_tv_pa' => 0,
				'hikari_tv' => 0,
				'hikari_tel' => 0,
				'ng' => 0,
			);
			*/
			$sql = ''.
				'select '.
					$select_fields_list.' '.
				'from '.
					"addup_monthly_${kind} ".
				'where '.
					$cond;

			$query = $this->_db_wizp->query($sql);
			if ($query->num_rows() > 0)
			{
				$rows = $query->result_array();
				if ($channel === 'realestate_east' || $channel === 'realestate_west')
				{
					$total_yosan = 0;
					$total_introduction = 0;
					$total_contraction = 0;

					foreach ($rows as $row)
					{
						$total_yosan        += (int)$row['yosan'];
						$total_introduction += (int)$row['introduction'];
						$total_contraction  += (int)$row['contraction'];
					}
					$rows[] = array(
						'month' => '計',
						'channel' => '-',
						'east_or_west' => '-',
						'yosan' => $total_yosan,
						'introduction' => $total_introduction,
						'contraction' => $total_contraction,
						'percent_yojitsu' => '0', //*****************
						'percent_contracted' => '0', //*****************
					);
				}
				$sum[$kind] = $rows;
			}
			else
			{
				// ****************************************************************
				//$sum[$kind][] = $this->_get_sum_empty($date, $time_zone);
			}
		}

		// ------------------------------------
		// 出力
		// ------------------------------------

		$data = array(
			'year' => $year,
			'month' => $month,
			'sum' => $sum,
			'form_year' => $this->config->item('form_year'),
			'form_month' => $this->config->item('form_month'),
			'form_channel' => $this->config->item('form_channel'),
		);
		$this->ag_auth->view('contents/addup_monthly/index', $data);
	}
}
