<?php

class Tools extends CI_Controller_With_Auth {

	const YAHOO_APPID = 'dj0zaiZpPTFuZXFSYWF0aWNGUSZkPVlXazlPREJOYkZSVk4ya21jR285TUEtLSZzPWNvbnN1bWVyc2VjcmV0Jng9N2E-';

	/*
	public function index()
	{
		$this->ag_auth->view('contents/ogawa/index');
	}
	*/

	public function print_for_tel()
	{
		$this->ag_auth->view('contents/toos/print_for_tel');
	}

	public function mansion_search()
	{
		$address = $this->input->get('address');
		if (empty($address))
		{
			$data = array(
				'address' => '',
				'address_el' => '',
				'zip1' => '',
				'zip2' => '',
				'prefcode' => '',
				'east_or_west' => '',
				'is_osaka' => '',
				'is_osaka_east' => '',
				'is_osaka_south' => '',
			);
			$this->ag_auth->view('contents/tools/mansion_search', $data);
			exit;
		}

		// -------------------------
		// ジオコーダ
		// -------------------------

		$url = 'http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder';
		$post = array(
			'appid' => self::YAHOO_APPID,
			'query' => $address,
			'ei' => 'UTF-8',
			'results' => 1,
			'detail' => 'detail',
		);
		$url .= '?' . http_build_query($post);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$xml = simplexml_load_string($result);
		//var_dump($xml);
		list($lon, $lat) = explode(',', (string)$xml->Feature->Geometry->Coordinates);
		$governmentcode = (string)$xml->Feature->Property->GovernmentCode;
		$prefcode = substr($governmentcode, 0, 2);


		// 東西日本判定
		$east_or_west = ((int)$prefcode <= 15 || $prefcode === '19' || $prefcode === '20') ? 'east' : 'west';

		// 大阪府の場合は細分化
		$is_osaka       = false;
		$is_osaka_east  = false;
		$is_osaka_south = false;

		if ($prefcode === '27')
		{
			switch ($governmentcode)
			{
				// -------------------
				// 跨ぎ
				// -------------------

				case '27106': //大阪市西区
				case '27128': //大阪市中央区
					$is_osaka = true;
					$is_osaka_south = true;
					break;
				case '27102': //大阪市都島区
					$is_osaka = true;
					$is_osaka_east = true;
					break;

				// -------------------
				// 無印
				// -------------------

				case '27103': //大阪市福島区
				case '27104': //大阪市此花区
				case '27113': //大阪市西淀川区
				case '27114': //大阪市東淀川区
				case '27123': //大阪市淀川区
				case '27127': //大阪市北区
				case '27203': //豊中市
				case '27204': //池田市
				case '27205': //吹田市
				case '27207': //高槻市
				case '27211': //茨木市
				case '27220': //箕面市
				case '27224': //摂津市
				case '27321': //豊能郡豊能町
				case '27322': //豊能郡能勢町
					$is_osaka = true;
					break;

				// -------------------
				// 東
				// -------------------

				case '27115': //大阪市東成区
				case '27117': //大阪市旭区
				case '27118': //大阪市城東区
				case '27124': //大阪市鶴見区
				case '27209': //守口市
				case '27210': //枚方市
				case '27212': //八尾市
				case '27214': //富田林市
				case '27215': //寝屋川市
				case '27216': //河内長野市
				case '27218': //大東市
				case '27221': //柏原市
				case '27222': //羽曳野市
				case '27223': //門真市
				case '27226': //藤井寺市
				case '27227': //東大阪市
				case '27229': //四條畷市
				case '27230': //交野市
				case '27381': //南河内郡太子町
				case '27382': //南河内郡河南町
				case '27383': //南河内郡千早赤阪村
					$is_osaka_east = true;
					break;

				// -------------------
				// 南
				// -------------------

				case '27107': //大阪市港区
				case '27108': //大阪市大正区
				case '27109': //大阪市天王寺区
				case '27111': //大阪市浪速区
				case '27116': //大阪市生野区
				case '27119': //大阪市阿倍野区
				case '27120': //大阪市住吉区
				case '27121': //大阪市東住吉区
				case '27122': //大阪市西成区
				case '27125': //大阪市住之江区
				case '27126': //大阪市平野区
				case '27141': //堺市堺区
				case '27142': //堺市中区
				case '27143': //堺市東区
				case '27144': //堺市西区
				case '27145': //堺市南区
				case '27146': //堺市北区
				case '27147': //堺市美原区
				case '27202': //岸和田市
				case '27206': //泉大津市
				case '27208': //貝塚市
				case '27213': //泉佐野市
				case '27217': //松原市
				case '27219': //和泉市
				case '27225': //高石市
				case '27228': //泉南市
				case '27231': //狭山市
				case '27232': //阪南市
				case '27341': //泉北郡忠岡町
				case '27361': //泉南郡熊取町
				case '27362': //泉南郡田尻町
				case '27366': //泉南郡岬町
					$is_osaka_south = true;
					break;
			}
		}

		// -------------------------
		// リバースジオコーダ
		// -------------------------

		$url = 'http://reverse.search.olp.yahooapis.jp/OpenLocalPlatform/V1/reverseGeoCoder';
		$post = array(
			'appid' => self::YAHOO_APPID,
			'lat' => $lat,
			'lon' => $lon,
			'results' => 1,
		);
		$url .= '?' . http_build_query($post);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$xml = simplexml_load_string($result);
		//var_dump($xml);
		foreach ($xml->Feature->Property->AddressElement as $el)
		{
			$address_el[(string)$el->Level] = (string)$el->Name;
		}

		// -------------------------
		// 郵便番号検索
		// -------------------------

		$url = 'http://search.olp.yahooapis.jp/OpenLocalPlatform/V1/zipCodeSearch';
		$post = array(
			'appid' => self::YAHOO_APPID,
			'query' => $address,
			'detail' => 'simple',
			'results' => 1,
		);
		$url .= '?' . http_build_query($post);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$xml = simplexml_load_string($result);
		$zip = str_replace('〒', '', $xml->Feature->Name);
		list($zip1, $zip2) = explode('-', $zip);
		//var_dump($xml);
		curl_close($ch);

		$data = array(
			'address' => $address,
			'address_el' => $address_el,
			'zip1' => $zip1,
			'zip2' => $zip2,
			'prefcode' => $prefcode,
			'east_or_west' => $east_or_west,
			'is_osaka' => $is_osaka,
			'is_osaka_east' => $is_osaka_east,
			'is_osaka_south' => $is_osaka_south,
		);
		$this->ag_auth->view('contents/tools/mansion_search', $data);
	}
}
