<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| 年セレクトフォーム用配列 
|--------------------------------------------------------------------------
*/

$birth_year         = array();
$passport_from_year = array();
$passport_to_year   = array();

// 現在の年から計算
$year = (int)date('Y');
$birth_year[''] = '選択して下さい';
for ($i = $year; $i >= $year - 100; $i--)
{
    $birth_year[$i] = $i;
}
$passport_from_year[''] = '選択して下さい';
for ($i = $year; $i >= $year - 10; $i--)
{
    $passport_from_year[$i] = $i;
}
$passport_to_year[''] = '選択して下さい';
for ($i = $year; $i <= $year + 10; $i++)
{
    $passport_to_year[$i] = $i;
}

// 設定配列に格納
$config['form_birth_year']         = $birth_year;
$config['form_passport_from_year'] = $passport_from_year;
$config['form_passport_to_year']   = $passport_to_year;

/*
|--------------------------------------------------------------------------
| 月セレクトフォーム用配列 
|--------------------------------------------------------------------------
*/

$month = array(
	'' => '選択して下さい',
	'01' => 'JAN (1)',
	'02' => 'FEB (2)',
	'03' => 'MAR (3)',
	'04' => 'APR (4)',
	'05' => 'MAY (5)',
	'06' => 'JUN (6)',
	'07' => 'JUL (7)',
	'08' => 'AUG (8)',
	'09' => 'SEP (9)',
	'10' => 'OCT (10)',
	'11' => 'NOV (11)',
	'12' => 'DEC (12)',
);
$config['form_month'] = $month;

/*
|--------------------------------------------------------------------------
| 日セレクトフォーム用配列
|--------------------------------------------------------------------------
*/

$day = array();
$day[''] = '選択して下さい';
for ($i = 1; $i <= 31; $i++)
{
    $key = vsprintf('%02d', $i);
    $day[$key] = $i;
}
$config['form_day'] = $day;

/*
|--------------------------------------------------------------------------
| 国セレクトフォーム用配列
|--------------------------------------------------------------------------
*/

$all_countrys = array();
$esta_countrys = array();
$lines = file(APPPATH.'config/data/country.tsv');
foreach ($lines as $line)
{
    list($code_s2, $code_s3, $code_i3, $name_jp, $name_eg, $esta) = explode("\t", trim($line));
    $all_countrys[$code_s2] = $name_eg;
    if ($esta === '1')
    {
        $esta_countrys[$code_s2] = $name_eg;
    }
}

$config['form_country_national'] = $esta_countrys;
$config['form_country_birth'] = $all_countrys;
$config['form_country_live'] = $all_countrys;
$config['form_billing_country'] = $all_countrys;
