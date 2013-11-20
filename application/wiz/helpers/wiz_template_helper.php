<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_html_yosan_halfyear_rows($yosan_serialize, $view_id, $kind_id, $label, $unit)
{
	switch ($unit)
	{
		case 'ratio':
			$unit_view = '%';
			$sum_target = '';
			break;
		case 'count':
			$unit_view = '件';
			$sum_target = 'class="sum_target"';
			break;
	}

	$html = '';
	$html .= '<tr><td class="label_row" colspan="3">'.$label.'</td></tr>'."\n";
	foreach (unserialize($yosan_serialize) as $name => $val)
	{
		$html .= '<tr class="unit_'.$kind_id.'_'.$view_id.'">'."\n";
		$html .= '<td>'.$name.'</td>'."\n";
		$html .= '<td><input type="text" '.$sum_target.' name="'.$name.'_'.$view_id.'" value="'.$val.'"/>'.$unit_view.'</td>'."\n";
		if ($unit === 'ratio')
		{
			$html .= '<td><span class="sum_target" id="'.$name.'_'.$view_id.'_cook">0</span></td>'."\n";
		}
		elseif ($unit === 'count')
		{
			$html .= '<td>&nbsp</td>'."\n";
		}
		$html .= '</tr>'."\n";
	}
	$html .= '<tr>'."\n";
	if ($unit === 'ratio')
	{
		$html .= '<td>小計</td>'."\n";
		$html .= '<td>&nbsp</td>'."\n";
		$html .= '<td><span id="sum_'.$kind_id.'_'.$view_id.'">9999</span></td>'."\n";
	}
	elseif ($unit === 'count')
	{
		$html .= '<td>小計</td>'."\n";
		$html .= '<td><span id="sum_'.$kind_id.'_'.$view_id.'">9999</span></td>'."\n";
		$html .= '<td>&nbsp</td>'."\n";
	}
	$html .= '</tr>'."\n";
	return $html;
}

function get_html_yosan_halfyear_table($yosan_month_info, $view_id)
{
	$flets_contract_ratio_complex = serialize(array(
		'契約率' => $yosan_month_info['flets_contract_ratio'],
		'開通率' => $yosan_month_info['flets_complete_ratio'],
	));
	$onlyisp_contract_ratio_complex = serialize(array(
		'契約率' => $yosan_month_info['onlyisp_contract_ratio'],
		'開通率' => $yosan_month_info['onlyisp_complete_ratio'],
	));
	$benefit_contract_ratio_complex = serialize(array(
		'契約率' => $yosan_month_info['benefit_contract_ratio'],
		'開通率' => $yosan_month_info['benefit_complete_ratio'],
	));

	$html_flets_introduction_count = get_html_yosan_halfyear_rows(
		$yosan_month_info['introduction_count_complex'],
		$view_id,
		'flets_introduction_count',
		'照会予算',
		'count'
	);
	$html_flets_contract_ratio = get_html_yosan_halfyear_rows(
		$flets_contract_ratio_complex,
		$view_id,
		'flets_contract_ratio',
		'フレッツ契約率＆開通率',
		'ratio'
	);
	$html_flets_isp_set_ratio = get_html_yosan_halfyear_rows(
		$yosan_month_info['flets_isp_set_ratio_complex'],
		$view_id,
		'flets_isp_set_ratio',
		'ISPセット率',
		'ratio'
	);
	$html_flets_option_set_ratio = get_html_yosan_halfyear_rows(
		$yosan_month_info['flets_option_set_ratio_complex'],
		$view_id,
		'flets_option_set_ratio',
		'オプションセット率',
		'ratio'
	);
	$html_iten_contract_count = get_html_yosan_halfyear_rows(
		$yosan_month_info['iten_contract_count_complex'],
		$view_id,
		'iten_contract_count',
		'移転契約数',
		'count'
	);
	$html_iten_isp_set_ratio = get_html_yosan_halfyear_rows(
		$yosan_month_info['iten_isp_set_ratio_complex'],
		$view_id,
		'iten_isp_set_ratio',
		'移転セット率',
		'ratio'
	);
	$html_other_contract_ratio = get_html_yosan_halfyear_rows(
		$yosan_month_info['other_contract_ratio_complex'],
		$view_id,
		'other_contract_ratio',
		'その他回線契約率',
		'ratio'
	);
	$html_other_complete_ratio = get_html_yosan_halfyear_rows(
		$yosan_month_info['other_complete_ratio_complex'],
		$view_id,
		'other_complete_ratio',
		'その他回線開通率',
		'ratio'
	);
	$html_onlyisp_contract_ratio = get_html_yosan_halfyear_rows(
		$onlyisp_contract_ratio_complex,
		$view_id,
		'onlyisp_contract_ratio',
		'ISPのみ契約率＆開通率',
		'ratio'
	);
	$html_benefit_contract_ratio = get_html_yosan_halfyear_rows(
		$benefit_contract_ratio_complex,
		$view_id,
		'benefit_contract_ratio',
		'特典施策契約率＆開通率',
		'ratio'
	);

echo <<< EOF
<table class="yosan_halfyear">
{$html_flets_introduction_count}
{$html_flets_contract_ratio}
{$html_flets_isp_set_ratio}
{$html_flets_option_set_ratio}
{$html_iten_contract_count}
{$html_iten_isp_set_ratio}
{$html_other_contract_ratio}
{$html_other_complete_ratio}
{$html_onlyisp_contract_ratio}
{$html_benefit_contract_ratio}
</table>
EOF;
}
