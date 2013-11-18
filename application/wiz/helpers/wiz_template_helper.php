<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_html_yosan_halfyear_rows($yosan_serialize, $view_id, $label, $suffix = '%')
{
	$html = '';
	$html .= '<tr><td class="label_row" colspan="3">'.$label.'</td></tr>';
	foreach (unserialize($yosan_serialize) as $name => $count)
	{
		$html .= '<tr>'."\n";
		$html .= '<td>'.$name.'</td>'."\n";
		$html .= '<td><input type="text" name="'.$name.'_'.$view_id.'" value="'.$count.'"/>'.$suffix.'</td>'."\n";
		$html .= '<td>aaaa</td>'."\n";
		$html .= '</tr>'."\n";
	}
	return $html;
}

function get_html_yosan_halfyear_table($yosan_month_info, $view_id)
{
	$html_introduction_count = get_html_yosan_halfyear_rows($yosan_month_info['introduction_count_complex'], $view_id, '照会予算', '件');
	$html_flets_isp_set_ratio = get_html_yosan_halfyear_rows($yosan_month_info['flets_isp_set_ratio_complex'], $view_id, 'ISPセット率');
	$html_flets_option_set_ratio = get_html_yosan_halfyear_rows($yosan_month_info['flets_option_set_ratio_complex'], $view_id, 'オプションセット率');
	$html_iten_contract_count = get_html_yosan_halfyear_rows($yosan_month_info['iten_contract_count_complex'], $view_id, '移転契約数', '件');
	$html_iten_isp_set_ratio = get_html_yosan_halfyear_rows($yosan_month_info['iten_isp_set_ratio_complex'], $view_id, '移転セット率');
	$html_other_contract_ratio = get_html_yosan_halfyear_rows($yosan_month_info['other_contract_ratio_complex'], $view_id, 'その他回線契約率');
	$html_other_complete_ratio = get_html_yosan_halfyear_rows($yosan_month_info['other_complete_ratio_complex'], $view_id, 'その他回線開通率');

echo <<< EOF
<table class="yosan_halfyear" style="width:100%;">
{$html_introduction_count}
<tr><td class="label_row" colspan="3">フレッツ契約率＆開通率</td></tr>
<tr>
<td>契約率</td>
<td><input type="text" name="フレッツ契約率_{$view_id}" value="{$yosan_month_info['flets_contract_ratio']}"/>%</td>
</tr>
<tr>
<td>開通率</td>
<td><input type="text" name="フレッツ開通率_{$view_id}" value="{$yosan_month_info['flets_complete_ratio']}"/>%</td>
</tr>
{$html_flets_isp_set_ratio}
{$html_flets_option_set_ratio}
{$html_iten_contract_count}
{$html_iten_isp_set_ratio}
{$html_other_contract_ratio}
{$html_other_complete_ratio}
<tr><td class="label_row" colspan="3">ISPのみ</td></tr>
<tr>
<td>契約率</td>
<td><input type="text" name="ISPのみ契約率_{$view_id}" value="{$yosan_month_info['onlyisp_contract_ratio']}"/>%</td>
</tr>
<tr>
<td>開通率</td>
<td><input type="text" name="ISPのみ開通率_{$view_id}" value="{$yosan_month_info['onlyisp_complete_ratio']}"/>%</td>
</tr>
<tr><td class="label_row" colspan="3">特典施策契約率＆開通率</td></tr>
<tr>
<td>契約率</td>
<td><input type="text" name="特典施策契約率_{$view_id}" value="{$yosan_month_info['benefit_contract_ratio']}"/>%</td>
</tr>
<tr>
<td>開通率</td>
<td><input type="text" name="特典施策契約率_{$view_id}" value="{$yosan_month_info['benefit_complete_ratio']}"/>%</td>
</tr>
</table>
EOF;
}
