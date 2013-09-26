#!/usr/bin/php
<?php

define('INFILE', '/home/wiz/g/application/wiz/var/sql/addup.tsv');
define('OUTFILE', '/home/wiz/g/application/wiz/var/sql/addup_conv.tsv');

$fpr = fopen(INFILE, 'r');
$fpw = fopen(OUTFILE, 'w');

date_default_timezone_set('Asia/Tokyo');

while (($line = fgets($fpr)) !== FALSE)
{
	$line = str_replace(',', "\t", $line); // CSVからTSVへ
	$line = mb_convert_kana($line, 'KVa', 'UTF-8'); // 全半角統一

	$fields = explode("\t", $line);
	$fields[1] = date('Ymd', strtotime($fields[1])); // 日付フォーマット変更
	$line = implode("\t", $fields);


	// 書出
	fputs($fpw, $line);
}

fclose($fpr);
fclose($fpw);




