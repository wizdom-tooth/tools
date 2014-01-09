<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['calendar_prefs']['start_day'] = 'monday';
$config['calendar_prefs']['day_type'] = 'short';
$config['calendar_prefs']['show_next_prev'] = FALSE;
//$config['calendar_prefs']['next_prev_url'] = base_url('addup/index');
$config['calendar_prefs']['template'] = <<<EOT
    {table_open}<table width="100%" height="100%">{/table_open}
    {heading_row_start}<tr style="background-color:#D8D8D8; text-align:center;">{/heading_row_start}
    {heading_previous_cell}<th style="width:20px; height:5px;"><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
    {heading_title_cell}<th style="width:20px; height:5px;" colspan="{colspan}">{heading}</th>{/heading_title_cell}
    {heading_next_cell}<th style="width:20px; height:5px;"><a id="cal_next_url" href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
    {heading_row_end}</tr>{/heading_row_end}
    {week_row_start}<tr style="background-color:#1C1C1C; color:#FFFFFF; text-align:center;">{/week_row_start}
    {week_day_cell}<td style="width:20px; height:20px;">{week_day}</td>{/week_day_cell}
    {week_row_end}</tr>{/week_row_end}
    {cal_row_start}<tr style="text-align:center;">{/cal_row_start}
    {cal_cell_start}<td style="width:20px; height:20px;">{/cal_cell_start}
    {cal_cell_content}{content}{/cal_cell_content}
    {cal_cell_content_today}{content}{/cal_cell_content_today}
    {cal_cell_no_content}
        <div style="background-color:green; color:white;">{day}</div>
        <table>
        <tr><td>紹介</td><td><input style="width:50px;" type="text" name="y_{day}_i" value="" /></td></tr>
        <tr><td>A(10-12)</td><td><input style="width:50px;" type="text" name="y_{day}_a" value="" /></td></tr>
        <tr><td>B(12-14)</td><td><input style="width:50px;" type="text" name="y_{day}_b" value="" /></td></tr>
        <tr><td>C(14-16)</td><td><input style="width:50px;" type="text" name="y_{day}_c" value="" /></td></tr>
        <tr><td>D(16-18)</td><td><input style="width:50px;" type="text" name="y_{day}_d" value="" /></td></tr>
        <tr><td>E(18-20)</td><td><input style="width:50px;" type="text" name="y_{day}_e" value="" /></td></tr>
        <tr><td>F(20-LAST)</td><td><input style="width:50px;" type="text" name="y_{day}_f" value="" /></td></tr>
        </table>
    {/cal_cell_no_content}
    {cal_cell_no_content_today}
        <div style="background-color:green; color:white;">{day}</div>
        <table>
        <tr><td>紹介</td><td><input style="width:50px;" type="text" name="y_{day}_i" value="" /></td></tr>
        <tr><td>A(10-12)</td><td><input style="width:50px;" type="text" name="y_{day}_a" value="" /></td></tr>
        <tr><td>B(12-14)</td><td><input style="width:50px;" type="text" name="y_{day}_b" value="" /></td></tr>
        <tr><td>C(14-16)</td><td><input style="width:50px;" type="text" name="y_{day}_c" value="" /></td></tr>
        <tr><td>D(16-18)</td><td><input style="width:50px;" type="text" name="y_{day}_d" value="" /></td></tr>
        <tr><td>E(18-20)</td><td><input style="width:50px;" type="text" name="y_{day}_e" value="" /></td></tr>
        <tr><td>F(20-LAST)</td><td><input style="width:50px;" type="text" name="y_{day}_f" value="" /></td></tr>
        </table>
    {/cal_cell_no_content_today}
    {cal_cell_blank}&nbsp;{/cal_cell_blank}
    {cal_cell_end}</td>{/cal_cell_end}
    {cal_row_end}</tr>{/cal_row_end}
    {table_close}</table>{/table_close}
EOT;
