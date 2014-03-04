#!/usr/bin/php
<?php

$raws = file('./jcn_org.tsv');
$w = fopen('./jcn.tsv', 'w');

$converted = array();
foreach ($raws as $line)
{
    $line = mb_convert_encoding($line, 'UTF8', 'SJIS');
    $fields = explode("\t", trim($line));

    $converted_datas = array(
        'mansion_id' => $fields[0],
        'mansion_name' => $fields[1], 
        'address' => $fields[2].$fields[3].$fields[4], 
        'counts' => $fields[5], 
        'mansion_type' => $fields[6], 
        'broadcast_service' => $fields[7], 
        'communication_service' => $fields[8], 
        'cable_tel' => $fields[9], 
        'yokohama_city_name' => trim($fields[2].$fields[3]), 
    );
    $converted_line = implode("\t", $converted_datas) . "\n";
    fwrite($w, $converted_line);
}

fclose($w);

/*
while ((list($date, $time_zone, $personnel) = fgetcsv($r)) !== FALSE)
{
	list($year, $month, $day) = explode('/', $date);
	// $date_format = sprintf('%04d%02d%02d', $year, $month, $day);
	$date_format = sprintf('%02d%02d', $month, $day);

	if ( ! empty($output_lines) && $target_date !== $date)
	{
		$converted_data = array_merge($converted_data, $output_lines);
		$output_lines = array();
	}
	for ($i = 0; $i < $personnel; $i++)
	{
		if ($time_zone === 'AM')
		{
			$time_zone_str = '○AM';
			$start_time = '09:00';
			$end_time = '15:00';
		}
		else
		{
			$time_zone_str = '●PM';
			$start_time = '12:00';
			$end_time = '21:00';
		}
		$tmp = array(
			$date,
			$date,
			$time_zone_str,
			'★担当者なし',
			$start_time,
			$end_time,
			'CC業務',
			$date_format . sprintf('%02d', $i), // メモ
			'★担当者なし', // スケジュール表のコピー先
		);
		$tmp_line = implode(',', $tmp);
		$output_lines[] = mb_convert_encoding($tmp_line, 'SJIS', 'UTF-8');
	}
}
$converted_data = array_merge($converted_data, $output_lines);

foreach ($converted_data as $csv_output_lines)
{
	fwrite($w, $csv_output_lines . "\n");
}
*/
