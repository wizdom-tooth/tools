#!/usr/bin/php
<?php

define('INFILE', './addup_utf8.tsv');
define('OUTFILE', './addup_conv.tsv');

$fpr = fopen(INFILE, 'r');
$fpw = fopen(OUTFILE, 'w');

date_default_timezone_set('Asia/Tokyo');

while (($line = fgets($fpr)) !== FALSE)
{
	$line = str_replace(',', "\t", $line); // CSVからTSVへ
	$line = mb_convert_kana($line, 'KVa', 'UTF-8'); // 全半角統一

	$fields = explode("\t", $line);
	foreach ($fields as $i => $field)
	{
		$fields[$i] = preg_replace('/\s+/', '', $field);
	}
	$fields[1] = date('Ymd', strtotime($fields[1])); // 日付フォーマット変更
	if (empty($fields[0]) || ! preg_match('/^[A-Z].+$/', $fields[2]) || $fields[1] === '19700101')
	{
		continue;
	}
	$line = implode("\t", $fields)."\n";
	fputs($fpw, $line);
}

fclose($fpr);
fclose($fpw);




