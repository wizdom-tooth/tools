<?php

class Tools extends CI_Controller_With_Auth {

    const YAHOO_APPID = 'dj0zaiZpPTFuZXFSYWF0aWNGUSZkPVlXazlPREJOYkZSVk4ya21jR285TUEtLSZzPWNvbnN1bWVyc2VjcmV0Jng9N2E-';

    private function _show_mansion_search_error($query)
    {
        $data = array(
            'query' => $query,
            'is_success' => FALSE,
            'address' => '',
            'searched_address' => '',
            'zip1' => '',
            'zip2' => '',
            'prefcode' => '',
            'east_or_west' => '',
            'is_osaka' => FALSE,
            'is_osaka_east' => FALSE,
            'is_osaka_south' => FALSE,
            'is_aichi_starcat' => FALSE,
            'is_aichi_greencity' => FALSE,
            'is_aichi_himawari' => FALSE,
            'governmentcode' => '',
            'jcn_yokohama_matches' => array(),
        );
        $this->ag_auth->view('contents/tools/mansion_search', $data);
        exit;
    }

    public function mansion_search()
    {
        $query = $this->input->get('query');
        if (empty($query) || strlen($query) <= 7)
        {
            $this->_show_mansion_search_error($query);
        }
        else
        {
            $address = preg_replace('/\s+/', '', $query);
            $address = preg_replace('/　+/', '', $address);
            $address = mb_convert_kana($address, 'KVa');
        }

        // -------------------------
        // もし郵便番号が指定された場合、住所に変換する
        // -------------------------

        if (preg_match('/^\d{3}\-?\d{4}$/', $address))
        {
            $url = 'http://search.olp.yahooapis.jp/OpenLocalPlatform/V1/zipCodeSearch';
            $post = array(
                'appid' => self::YAHOO_APPID,
                'query' => $address,
                //'detail' => 'simple',
                'results' => 1,
            );
            $url .= '?' . http_build_query($post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $xml = simplexml_load_string($result);
            if ((int)$xml->ResultInfo->Count === 0)
            {
                $this->_show_mansion_search_error($query);
            }
            $address = (string)$xml->Feature->Property->Address;
            //var_dump($xml);
            curl_close($ch);
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
        if ((int)$xml->ResultInfo->Count === 0 || (int)$xml->Feature->Property->AddressMatchingLevel < 3)
        {
            $this->_show_mansion_search_error($query);
        }
        list($lon, $lat) = explode(',', (string)$xml->Feature->Geometry->Coordinates);
        $governmentcode = (string)$xml->Feature->Property->GovernmentCode;
        $prefcode = substr($governmentcode, 0, 2);

        // 東西日本判定
        $east_or_west = ((int)$prefcode <= 15 || $prefcode === '19' || $prefcode === '20') ? 'east' : 'west';

        // 愛知県の場合は細分化
        $is_aichi_starcat = FALSE;
        $is_aichi_greencity = FALSE;
        $is_aichi_himawari = FALSE;

        if ($prefcode === '23')
        {
            switch ($governmentcode)
            {
                case '23113': //愛知県名古屋市守山区
                case '23226': //愛知県尾張旭市
                case '23204': //愛知県瀬戸市
                    $is_aichi_greencity = TRUE;
                    break;
                case '23211': //愛知県豊田市
                case '23236': //愛知県みよし市
                case '23238': //愛知県長久手市 
                    $is_aichi_himawari = TRUE;
                    break;
                default:
                    $is_aichi_starcat = TRUE;
                    break;
            }
        }

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
        // 郵便番号検索
        // -------------------------

        $url = 'http://search.olp.yahooapis.jp/OpenLocalPlatform/V1/zipCodeSearch';
        $post = array(
            'appid' => self::YAHOO_APPID,
            'query' => $address,
            'results' => 1,
            'sort' => 'zip_kana',
            'zkind' => '0',
        );
        $url .= '?' . http_build_query($post);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $xml = simplexml_load_string($result);
        if ((int)$xml->ResultInfo->Count === 0)
        {
            $this->_show_mansion_search_error($query);
        }
        $searched_address = strval($xml->Feature->Property->Address);
        $zip = str_replace('〒', '', $xml->Feature->Name);
        list($zip1, $zip2) = explode('-', $zip);
        //var_dump($xml);
        curl_close($ch);

        // 神奈川県横浜市の場合はJCN横浜に該当データがあるか検索
        $jcn_yokohama_matches = array();
        if (preg_match('/^神奈川県横浜市/', $searched_address))
        {
            $yokohama_city_name = preg_replace('/^神奈川県/', '', $searched_address);
            $jcn_yokohama_lines = file('/home/wiz/g/application/wiz/var/feed/tools/mansion_search/jcn.tsv');
            foreach ($jcn_yokohama_lines as $jcn_yokohama_line)
            {
                $jcn_yokohama_fields = explode("\t", trim($jcn_yokohama_line));
                if ($yokohama_city_name === $jcn_yokohama_fields[8]) {
                    $jcn_yokohama_matches[] = $jcn_yokohama_fields;
                }
            }
            $sort = array();
            foreach ($jcn_yokohama_matches as $i => $tmp) {
                $sort[$i] = $tmp[2]; // 住所
            }
            array_multisort($sort, SORT_ASC, $jcn_yokohama_matches);
        }

        $data = array(
            'query' => $query,
            'is_success' => TRUE,
            'address' => $address,
            'searched_address' => $searched_address,
            'zip1' => $zip1,
            'zip2' => $zip2,
            'prefcode' => $prefcode,
            'east_or_west' => $east_or_west,
            'is_osaka' => $is_osaka,
            'is_osaka_east' => $is_osaka_east,
            'is_osaka_south' => $is_osaka_south,
            'is_aichi_starcat' => $is_aichi_starcat,
            'is_aichi_greencity' => $is_aichi_greencity,
            'is_aichi_himawari' => $is_aichi_himawari,
            'governmentcode' => $governmentcode,
            'jcn_yokohama_matches' => $jcn_yokohama_matches,
        );
        $this->ag_auth->view('contents/tools/mansion_search', $data);
    }
}
