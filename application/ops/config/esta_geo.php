<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| 地理情報
|--------------------------------------------------------------------------
*/

// 都道府県情報
$pref_infos = array();
$lines = file(APPPATH.'config/data/pref.tsv');
foreach ($lines as $key => $line)
{
    list(
        $pref_infos[$key]['pref_code'],
        $pref_infos[$key]['geoip_code'],
        $pref_infos[$key]['pref_name_mb1'],
        $pref_infos[$key]['pref_name_mb2'],
        $pref_infos[$key]['pref_name']
    ) = explode("\t", trim($line));
}

// アクセス元情報
$where_access_from = '';
$geo = (isset($_SERVER['REMOTE_ADDR'])) ? geoip_record_by_name($_SERVER['REMOTE_ADDR']) : array();


// DEBUG taogawa
//log_message('error', var_export($geo, TRUE));


if (empty($geo))
{
    $where_access_from = '';
}
else
{
	if ($geo['country_code'] === '' || $geo['region'] === '')
	{
		$where_access_from = 'UNKNOWN';
	}
	else
	{
		if ($geo['country_code'] !== 'JP')
		{
			$where_access_from = $geo['country_code'].':'.$geo['region'];
		}
		else
		{
			foreach ($pref_infos as $pref_info)
			{
				if (($pref_info['geoip_code'] === $geo['region']) && $geo['country_code'] === 'JP')
				{
					$where_access_from = 'JP:'.$pref_info['pref_name_mb2'];
				}
			}
			if ($where_access_from === '')
			{
				$where_access_from = 'JP:UNKNOWN';
			}
		}
	}
}

$config['pref_infos'] = $pref_infos;
$config['where_access_from'] = $where_access_from;
