<?php

class Cron extends CI_Controller {

	const FILE_FEED_LOCK = '/hoge/fuga/fullpath.LOCK';
	const FILE_RAW_DATA = '/hoge/fuga/fullpath.';
	const FILE_CONV_DATA = '/hoge/fuga/fullpath.';

	public function __construct()
	{
		parent::__construct();
		/*
		$this->config->load('redmine');
		$this->load->library('redmine');
		$this->load->database('redmine');
		*/
	}

	// 集計用データをDBに取り込む
	public function feed_addup_data()
	{
		//if ($this->input->is_cli_request() !== TRUE) show_error('system error.');
		// ロックされているかチェック ロックあり＞終了 ロック無しロックして継続
		// 継続の場合はDBのバックアップを取る 曜日時間ごと？？
		// データ加工処理＞加工済みデータをTSVファイルに書き出す
			// 文字コードをUTF8
			// CSV2TSV
			// 全半角統一
			// ホワイトスペースのストリップ
			// 日付のフォーマット変換
			// 不正？データの除去
		// load data infile でDBに流し込む with replace
		// 終わり
	}
}
