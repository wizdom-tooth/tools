<?php

class Migration extends CI_Controller {

	const SRC_FILE_PATH_INTORODUCTION = '/home/wiz/work/wiz/migration/introduction.csv';

	public function __construct()
	{
		parent::__construct();
		$this->config->load('redmine');
		/*
		$this->load->library('redmine');
		$this->load->database('redmine');
		*/
	}

	public function csv_to_db()
	{
		//if ($this->input->is_cli_request() !== TRUE) show_error('system error.');

		$_map = array(
			'紹介ID' => $this->config->item('rm_cf_id_紹介ID'),
			'紹介日' => $this->config->item('rm_cf_id_紹介日'),
			'姓' => $this->config->item('rm_cf_id_姓'),
			'名' => $this->config->item('rm_cf_id_名'),
			'姓（フリガナ）' => $this->config->item('rm_cf_id_姓（フリガナ）'),
			'名（フリガナ）' => $this->config->item('rm_cf_id_名（フリガナ）'),
			'電話番号' => $this->config->item('rm_cf_id_電話番号'),
			'連絡先' => $this->config->item('rm_cf_id_連絡先'),
			'郵便番号' => $this->config->item('rm_cf_id_郵便番号'),
			'都道府県' => $this->config->item('rm_cf_id_都道府県'),
			'市区' => $this->config->item('rm_cf_id_市区'),
			'町名' => $this->config->item('rm_cf_id_町名'),
			'番地' => $this->config->item('rm_cf_id_番地'),
			'建物名' => $this->config->item('rm_cf_id_建物名'),
			'棟/部屋番号' => $this->config->item('rm_cf_id_棟/部屋番号'),
			'プラン' => $this->config->item('rm_cf_id_プラン'),
			'AL店舗番号' => $this->config->item('rm_cf_id_AL店舗番号'),
			'AL店舗名' => $this->config->item('rm_cf_id_AL店舗名'),
			'AL担当者' => $this->config->item('rm_cf_id_AL担当者'),
			'紹介時間' => $this->config->item('rm_cf_id_紹介時間'),
			'繋がりやすい日時' => $this->config->item('rm_cf_id_繋がりやすい日時'),
			'繋がりやすい時間' => $this->config->item('rm_cf_id_繋がりやすい時間'),
			'転居予定日' => $this->config->item('rm_cf_id_転居予定日'),
			'FAX受領日' => $this->config->item('rm_cf_id_FAX受領日'),
			'顧客ID' => $this->config->item('rm_cf_id_顧客ID'),
			'コール禁止' => $this->config->item('rm_cf_id_コール禁止'),
			'最新ステータス' => $this->config->item('rm_cf_id_最新ステータス'),
			'最終コール者' => $this->config->item('rm_cf_id_最終コール者'),
			'最終コール日' => $this->config->item('rm_cf_id_最終コール日'),
			'コール件数' => $this->config->item('rm_cf_id_コール件数'),
			'エクセルID' => $this->config->item('rm_cf_id_エクセルID'),
			'備考欄' => $this->config->item('rm_cf_id_備考欄'),
			'アライアンス番号' => $this->config->item('rm_cf_id_アライアンス番号'),
			'印刷チェック' => $this->config->item('rm_cf_id_印刷チェック'),
			'契約日' => $this->config->item('rm_cf_id_契約日'),
			'DM発送日' => $this->config->item('rm_cf_id_DM発送日'),
			'NGDM発送日' => $this->config->item('rm_cf_id_NGDM発送日'),
			'導入商品' => $this->config->item('rm_cf_id_導入商品'),
			'導入タイプ' => $this->config->item('rm_cf_id_導入タイプ'),
			'DM発送' => $this->config->item('rm_cf_id_DM発送'),
			'完成月' => $this->config->item('rm_cf_id_完成月'),
			'工事日' => $this->config->item('rm_cf_id_工事日'),
			'工事完了日' => $this->config->item('rm_cf_id_工事完了日'),
			'空ポート数' => $this->config->item('rm_cf_id_空ポート数'),
			'ひかり電話対応' => $this->config->item('rm_cf_id_ひかり電話対応'),
			'提供方法' => $this->config->item('rm_cf_id_提供方法'),
			'備考' => $this->config->item('rm_cf_id_備考'),
			'入力者' => $this->config->item('rm_cf_id_入力者'),
			'インポートフラグ' => $this->config->item('rm_cf_id_インポートフラグ'),
			'生年月日' => $this->config->item('rm_cf_id_生年月日'),
			'書類送付先_郵便番号' => $this->config->item('rm_cf_id_書類送付先_郵便番号'),
			'書類送付先_都道府県' => $this->config->item('rm_cf_id_書類送付先_都道府県'),
			'書類送付先_市区' => $this->config->item('rm_cf_id_書類送付先_市区'),
			'書類送付先_町名' => $this->config->item('rm_cf_id_書類送付先_町名'),
			'書類送付先_番地' => $this->config->item('rm_cf_id_書類送付先_番地'),
			'書類送付先_建物名' => $this->config->item('rm_cf_id_書類送付先_建物名'),
			'書類送付先_棟/部屋番号' => $this->config->item('rm_cf_id_書類送付先_棟/部屋番号'),
			'NG日' => $this->config->item('rm_cf_id_NG日'),
			'架電指定日' => $this->config->item('rm_cf_id_架電指定日'),
			'DM戻り日' => $this->config->item('rm_cf_id_DM戻り日'),
			'資料送付' => $this->config->item('rm_cf_id_資料送付'),
			'資料送付先' => $this->config->item('rm_cf_id_資料送付先'),
			'DB入力者' => $this->config->item('rm_cf_id_DB入力者'),
			'NGDM発送一か月前日' => $this->config->item('rm_cf_id_NGDM発送一か月前日'),
			'NG理由' => $this->config->item('rm_cf_id_NG理由'),
			'資料送付/架電NG/クレーム' => $this->config->item('rm_cf_id_資料送付/架電NG/クレーム'),
			'性別' => $this->config->item('rm_cf_id_性別'),
			'契約サービス' => $this->config->item('rm_cf_id_契約サービス'),
			'不動産小カテゴリ' => $this->config->item('rm_cf_id_不動産小カテゴリ'),
			'KDDI' => $this->config->item('rm_cf_id_KDDI'),
			'KDDIプラン' => $this->config->item('rm_cf_id_KDDIプラン'),
			'KDDI提供方式' => $this->config->item('rm_cf_id_KDDI提供方式'),
			'YahooBB' => $this->config->item('rm_cf_id_YahooBB'),
			'無料PC' => $this->config->item('rm_cf_id_無料PC'),
			'無料PC入電日' => $this->config->item('rm_cf_id_無料PC入電日'),
			'無料PC発注日' => $this->config->item('rm_cf_id_無料PC発注日'),
			'インポート済み' => $this->config->item('rm_cf_id_インポート済み'),
			'ミニミニ関東本部FAXフラグ' => $this->config->item('rm_cf_id_ミニミニ関東本部FAXフラグ'),
			'ダブリフラグ' => $this->config->item('rm_cf_id_ダブリフラグ'),
			'WS契約日' => $this->config->item('rm_cf_id_WS契約日'),
			'WSステータス' => $this->config->item('rm_cf_id_WSステータス'),
			'WS備考' => $this->config->item('rm_cf_id_WS備考'),
			'WSのみフラグ' => $this->config->item('rm_cf_id_WSのみフラグ'),
			'WS開通月' => $this->config->item('rm_cf_id_WS開通月'),
			'WS開通日' => $this->config->item('rm_cf_id_WS開通日'),
			'移転NG_ISP' => $this->config->item('rm_cf_id_移転NG_ISP'),
			'UpdateUser' => $this->config->item('rm_cf_id_UpdateUser'),
			'UpdatePC' => $this->config->item('rm_cf_id_UpdatePC'),
			'UpdateDate' => $this->config->item('rm_cf_id_UpdateDate'),
			'EntryDate' => $this->config->item('rm_cf_id_EntryDate'),
			'イーアクセス' => $this->config->item('rm_cf_id_イーアクセス'),
			'イーモバイル' => $this->config->item('rm_cf_id_イーモバイル'),
			'auひかり' => $this->config->item('rm_cf_id_auひかり'),
			'メガエッグ' => $this->config->item('rm_cf_id_メガエッグ'),
			'コミュファ光' => $this->config->item('rm_cf_id_コミュファ光'),
			'スターキャット' => $this->config->item('rm_cf_id_スターキャット'),
			'グリーンシティ' => $this->config->item('rm_cf_id_グリーンシティ'),
			'ドリームウェーブ' => $this->config->item('rm_cf_id_ドリームウェーブ'),
			'イッツコム' => $this->config->item('rm_cf_id_イッツコム'),
			'YahooBB（表示）' => $this->config->item('rm_cf_id_YahooBB（表示）'),
			'JCNよこはま' => $this->config->item('rm_cf_id_JCNよこはま'),
			'BBIQ' => $this->config->item('rm_cf_id_BBIQ'),
			'TNC_ADSL' => $this->config->item('rm_cf_id_TNC_ADSL'),
			'担当者コード' => $this->config->item('rm_cf_id_担当者コード'),
			'次回架電日' => $this->config->item('rm_cf_id_次回架電日'),
			'契約者姓' => $this->config->item('rm_cf_id_契約者姓'),
			'契約者名' => $this->config->item('rm_cf_id_契約者名'),
			'契約者とのご関係' => $this->config->item('rm_cf_id_契約者とのご関係'),
			'契約者とのご関係（その他）' => $this->config->item('rm_cf_id_契約者とのご関係（その他）'),
			'連絡先第一希望（電話番号）' => $this->config->item('rm_cf_id_連絡先第一希望（電話番号）'),
			'連絡先第一希望' => $this->config->item('rm_cf_id_連絡先第一希望'),
			'名義確認方法' => $this->config->item('rm_cf_id_名義確認方法'),
			'名義確認方法（その他）' => $this->config->item('rm_cf_id_名義確認方法（その他）'),
			'連絡先第二希望（電話番号）' => $this->config->item('rm_cf_id_連絡先第二希望（電話番号）'),
			'連絡先第二希望' => $this->config->item('rm_cf_id_連絡先第二希望'),
			'光サービス' => $this->config->item('rm_cf_id_光サービス'),
			'ウィルスクリア' => $this->config->item('rm_cf_id_ウィルスクリア'),
			'リモートサポート' => $this->config->item('rm_cf_id_リモートサポート'),
			'光ポータブル本体' => $this->config->item('rm_cf_id_光ポータブル本体'),
			'wifiクレードル' => $this->config->item('rm_cf_id_wifiクレードル'),
			'無線ルータ' => $this->config->item('rm_cf_id_無線ルータ'),
			'ひかり電話番号' => $this->config->item('rm_cf_id_ひかり電話番号'),
			'ひかり電話番号（元の回線）' => $this->config->item('rm_cf_id_ひかり電話番号（元の回線）'),
			'ひかり電話ルータ' => $this->config->item('rm_cf_id_ひかり電話ルータ'),
			'ひかり電話ルータ_無線カード' => $this->config->item('rm_cf_id_ひかり電話ルータ_無線カード'),
			'A_ひかり電話移行回線の契約者とフレッツ光契約者名義' => $this->config->item('rm_cf_id_A_ひかり電話移行回線の契約者とフレッツ光契約者名義'),
			'A_ひかり電話移行回線の契約者とフレッツ光契約者電話番号' => $this->config->item('rm_cf_id_A_ひかり電話移行回線の契約者とフレッツ光契約者電話番号'),
			'A_ひかり電話移行回線の契約者とフレッツ光契約者' => $this->config->item('rm_cf_id_A_ひかり電話移行回線の契約者とフレッツ光契約者'),
			'A_ひかり電話移行回線の契約者とフレッツ光契約者との関係' => $this->config->item('rm_cf_id_A_ひかり電話移行回線の契約者とフレッツ光契約者との関係'),
			'A_ひかり電話移行回線の契約者とフレッツ光契約者との関係（その他）' => $this->config->item('rm_cf_id_A_ひかり電話移行回線の契約者とフレッツ光契約者との関係（その他）'),
			'B_休止表送付先' => $this->config->item('rm_cf_id_B_休止表送付先'),
			'C_利用回線事業者' => $this->config->item('rm_cf_id_C_利用回線事業者'),
			'C_利用回線サービス' => $this->config->item('rm_cf_id_C_利用回線サービス'),
			'ひかり電話付加サービス_NTT東日本回線契約商品を継続' => $this->config->item('rm_cf_id_ひかり電話付加サービス_NTT東日本回線契約商品を継続'),
			'ひかり電話付加サービス_その他サービス' => $this->config->item('rm_cf_id_ひかり電話付加サービス_その他サービス'),
			'ひかり電話付加サービス選択' => $this->config->item('rm_cf_id_ひかり電話付加サービス選択'),
			'ナンバーディスプレイ' => $this->config->item('rm_cf_id_ナンバーディスプレイ'),
			'キャッチホン' => $this->config->item('rm_cf_id_キャッチホン'),
			'着信お知らせメール' => $this->config->item('rm_cf_id_着信お知らせメール'),
			'ボイスワープ' => $this->config->item('rm_cf_id_ボイスワープ'),
			'ナンバーリクエスト' => $this->config->item('rm_cf_id_ナンバーリクエスト'),
			'迷惑電話おことわり' => $this->config->item('rm_cf_id_迷惑電話おことわり'),
			'ダブルチャネル' => $this->config->item('rm_cf_id_ダブルチャネル'),
			'マイナンバー' => $this->config->item('rm_cf_id_マイナンバー'),
			'ボイスワープを利用したい番号の数（1～4）' => $this->config->item('rm_cf_id_ボイスワープを利用したい番号の数（1～4）'),
			'マイナンバーを利用したい番号の数（1～4）' => $this->config->item('rm_cf_id_マイナンバーを利用したい番号の数（1～4）'),
			'電話帳の送付' => $this->config->item('rm_cf_id_電話帳の送付'),
			'電話帳の掲載（有無）' => $this->config->item('rm_cf_id_電話帳の掲載（有無）'),
			'電話帳の掲載' => $this->config->item('rm_cf_id_電話帳の掲載'),
			'その他の電話契約（有無）' => $this->config->item('rm_cf_id_その他の電話契約（有無）'),
			'その他の電話契約_現在のNTT回線での契約を継続' => $this->config->item('rm_cf_id_その他の電話契約_現在のNTT回線での契約を継続'),
			'その他の電話契約_発信者番号通知' => $this->config->item('rm_cf_id_その他の電話契約_発信者番号通知'),
			'その他の電話契約_通話明細記録' => $this->config->item('rm_cf_id_その他の電話契約_通話明細記録'),
			'その他の電話契約_記録' => $this->config->item('rm_cf_id_その他の電話契約_記録'),
			'その他の電話契約_＠ビリング' => $this->config->item('rm_cf_id_その他の電話契約_＠ビリング'),
			'工事希望' => $this->config->item('rm_cf_id_工事希望'),
			'工事希望曜日指定（月～日、祝）' => $this->config->item('rm_cf_id_工事希望曜日指定（月～日、祝）'),
			'工事希望日指定（例1/1AM）①' => $this->config->item('rm_cf_id_工事希望日指定（例1/1AM）①'),
			'工事希望日指定（例1/1AM）②' => $this->config->item('rm_cf_id_工事希望日指定（例1/1AM）②'),
			'工事立会人' => $this->config->item('rm_cf_id_工事立会人'),
			'工事立会人（その他)' => $this->config->item('rm_cf_id_工事立会人（その他)'),
			'工事立会人電話番号' => $this->config->item('rm_cf_id_工事立会人電話番号'),
			'工事立会人電話番号（その他)' => $this->config->item('rm_cf_id_工事立会人電話番号（その他)'),
			'PC台数（合計）' => $this->config->item('rm_cf_id_PC台数（合計）'),
			'OS1' => $this->config->item('rm_cf_id_OS1'),
			'OS2' => $this->config->item('rm_cf_id_OS2'),
			'OS3' => $this->config->item('rm_cf_id_OS3'),
			'ルータ用意' => $this->config->item('rm_cf_id_ルータ用意'),
			'ルータレンタル' => $this->config->item('rm_cf_id_ルータレンタル'),
			'ルータ設置' => $this->config->item('rm_cf_id_ルータ設置'),
			'ルータタイプ' => $this->config->item('rm_cf_id_ルータタイプ'),
			'無線カード（枚数）' => $this->config->item('rm_cf_id_無線カード（枚数）'),
			'請求書宛名' => $this->config->item('rm_cf_id_請求書宛名'),
			'請求書送付先' => $this->config->item('rm_cf_id_請求書送付先'),
			'セットアップガイド・機器送付宛名' => $this->config->item('rm_cf_id_セットアップガイド・機器送付宛名'),
			'セットアップガイド・機器送付先' => $this->config->item('rm_cf_id_セットアップガイド・機器送付先'),
			'その他送付先氏名' => $this->config->item('rm_cf_id_その他送付先氏名'),
			'その他送付先住所' => $this->config->item('rm_cf_id_その他送付先住所'),
			'ISP手配' => $this->config->item('rm_cf_id_ISP手配'),
			'PCとモジュラーの位置' => $this->config->item('rm_cf_id_PCとモジュラーの位置'),
			'工事実施部屋階数' => $this->config->item('rm_cf_id_工事実施部屋階数'),
			'工事実施部屋数' => $this->config->item('rm_cf_id_工事実施部屋数'),
			'フレッツ光メンバーズクラブ申込' => $this->config->item('rm_cf_id_フレッツ光メンバーズクラブ申込'),
			'メールアドレス' => $this->config->item('rm_cf_id_メールアドレス'),
			'Fstユーザ物件区分' => $this->config->item('rm_cf_id_Fstユーザ物件区分'),
			'Fstユーザ物件世帯数' => $this->config->item('rm_cf_id_Fstユーザ物件世帯数'),
			'Fst同時承諾' => $this->config->item('rm_cf_id_Fst同時承諾'),
			'Fstキーマン情報' => $this->config->item('rm_cf_id_Fstキーマン情報'),
			'Fstキーマン種別' => $this->config->item('rm_cf_id_Fstキーマン種別'),
			'Fstキーマン（会社名）' => $this->config->item('rm_cf_id_Fstキーマン（会社名）'),
			'Fstキーマン（担当者）' => $this->config->item('rm_cf_id_Fstキーマン（担当者）'),
			'Fstキーマン連絡先' => $this->config->item('rm_cf_id_Fstキーマン連絡先'),
			'ご希望内容' => $this->config->item('rm_cf_id_ご希望内容'),
			'ご連絡内容' => $this->config->item('rm_cf_id_ご連絡内容'),
			'予定日' => $this->config->item('rm_cf_id_予定日'),
			'連絡希望日' => $this->config->item('rm_cf_id_連絡希望日'),
			'連絡希望日（指定）' => $this->config->item('rm_cf_id_連絡希望日（指定）'),
			'連絡希望時間' => $this->config->item('rm_cf_id_連絡希望時間'),
			'連絡希望時間（指定）' => $this->config->item('rm_cf_id_連絡希望時間（指定）'),
			'無料PC申込' => $this->config->item('rm_cf_id_無料PC申込'),
			'安心プラン' => $this->config->item('rm_cf_id_安心プラン'),
			'おまかせプラン' => $this->config->item('rm_cf_id_おまかせプラン'),
			'ISP申込' => $this->config->item('rm_cf_id_ISP申込'),
			'ISP登録証送付先' => $this->config->item('rm_cf_id_ISP登録証送付先'),
			'ISP登録証送付先変更' => $this->config->item('rm_cf_id_ISP登録証送付先変更'),
			'ISP名義' => $this->config->item('rm_cf_id_ISP名義'),
			'ISP名義(別名義人名)' => $this->config->item('rm_cf_id_ISP名義(別名義人名)'),
			'ISP連絡先' => $this->config->item('rm_cf_id_ISP連絡先'),
			'ISP連絡先(別名義人連絡先)' => $this->config->item('rm_cf_id_ISP連絡先(別名義人連絡先)'),
			'ひかりTVパー' => $this->config->item('rm_cf_id_ひかりTVパー'),
			'WS納品指定日' => $this->config->item('rm_cf_id_WS納品指定日'),
			'サンキュー送付先' => $this->config->item('rm_cf_id_サンキュー送付先'),
			'サンキュー送付先変更' => $this->config->item('rm_cf_id_サンキュー送付先変更'),
			'ルータの必要' => $this->config->item('rm_cf_id_ルータの必要'),
			'無線ルータ手配' => $this->config->item('rm_cf_id_無線ルータ手配'),
			'DBの電話番号' => $this->config->item('rm_cf_id_DBの電話番号'),
			'DBの電話番号(その他番号)' => $this->config->item('rm_cf_id_DBの電話番号(その他番号)'),
			'別名義契約' => $this->config->item('rm_cf_id_別名義契約'),
			'別名義契約者名' => $this->config->item('rm_cf_id_別名義契約者名'),
			'別名義契約者との関係' => $this->config->item('rm_cf_id_別名義契約者との関係'),
			'別名義理由' => $this->config->item('rm_cf_id_別名義理由'),
			'別名義理由（その他）' => $this->config->item('rm_cf_id_別名義理由（その他）'),
			'コンサル相手' => $this->config->item('rm_cf_id_コンサル相手'),
			'現在のネット環境' => $this->config->item('rm_cf_id_現在のネット環境'),
			'保管契約' => $this->config->item('rm_cf_id_保管契約'),
			'保管レター送付先' => $this->config->item('rm_cf_id_保管レター送付先'),
			'保管理由' => $this->config->item('rm_cf_id_保管理由'),
			'保管理由_その他' => $this->config->item('rm_cf_id_保管理由_その他'),
			'次回架電予定日' => $this->config->item('rm_cf_id_次回架電予定日'),
			'次回架電時間' => $this->config->item('rm_cf_id_次回架電時間'),
			'次回架電（その他）' => $this->config->item('rm_cf_id_次回架電（その他）'),
			'次回架電不要' => $this->config->item('rm_cf_id_次回架電不要'),
			'引越日確認' => $this->config->item('rm_cf_id_引越日確認'),
			'工事日確認' => $this->config->item('rm_cf_id_工事日確認'),
			'無派遣可否確認' => $this->config->item('rm_cf_id_無派遣可否確認'),
			'サンキュー送付先確認' => $this->config->item('rm_cf_id_サンキュー送付先確認'),
			'ガイド送付先確認' => $this->config->item('rm_cf_id_ガイド送付先確認'),
			'その他確認' => $this->config->item('rm_cf_id_その他確認'),
			'ひかり電話NG理由' => $this->config->item('rm_cf_id_ひかり電話NG理由'),
			'工事費用' => $this->config->item('rm_cf_id_工事費用'),
			'帳票種別' => $this->config->item('rm_cf_id_帳票種別'),
			'携帯キャリア' => $this->config->item('rm_cf_id_携帯キャリア'),
			'ウォータサーバ' => $this->config->item('rm_cf_id_ウォータサーバ'),
			'契約時間' => $this->config->item('rm_cf_id_契約時間'),
			'記事欄' => $this->config->item('rm_cf_id_記事欄'),
			'引越日' => $this->config->item('rm_cf_id_引越日'),
			'契約プラン' => $this->config->item('rm_cf_id_契約プラン'),
			'契約配線方式' => $this->config->item('rm_cf_id_契約配線方式'),
			'空き状況' => $this->config->item('rm_cf_id_空き状況'),
			'レカムチェック' => $this->config->item('rm_cf_id_レカムチェック'),
			'初回代引き金額' => $this->config->item('rm_cf_id_初回代引き金額'),
			'WS備考欄' => $this->config->item('rm_cf_id_WS備考欄'),
			'TOKAI' => $this->config->item('rm_cf_id_TOKAI'),
			'コスモライフ' => $this->config->item('rm_cf_id_コスモライフ'),
		);

		// 紹介CSVデータファイルを読み込む
		// 各フィールドごとに配列に展開する
		// 紹介IDもカスタムフィールドに書き出す
		// 後で通話履歴をそこと紐づけて書き出す為

		if (
			! file_exists(self::SRC_FILE_PATH_INTORODUCTION) ||
			! is_readable(self::SRC_FILE_PATH_INTORODUCTION)
		)
		{
			echo 'ERROR: request src file is not readable.'."\n";
			echo 'XXXXXXXXXXXXXX set [error handling process] afrer few XXXXXXXXXXXXXXX'."\n";
		}

        // 紹介CSVデータファイルを読み込む
		$fp = fopen(self::SRC_FILE_PATH_INTORODUCTION, 'r');
		while ($i_data_row = fgetcsv($fp))
		{
			/*
			$i_data = array(
				'紹介ID' => '',
				'紹介日' => '',
				'姓' => '',
				'名' => '',
				'姓（フリガナ）' => '',
				'名（フリガナ）' => '',
				'電話番号' => '',
				'連絡先' => '',
				'郵便番号' => '',
				'都道府県' => '',
				'市区' => '',
				'町名' => '',
				'番地' => '',
				'建物名' => '',
				'棟/部屋番号' => '',
				'プラン' => '',
				'AL店舗番号' => '',
				'AL店舗名' => '',
				'AL担当者' => '',
				'紹介時間' => '',
				'繋がりやすい日時' => '',
				'繋がりやすい時間' => '',
				'転居予定日' => '',
				'FAX受領日' => '',
				'顧客ID' => '',
				'コール禁止' => '',
				'最新ステータス' => '',
				'最終コール者' => '',
				'最終コール日' => '',
				'コール件数' => '',
				'エクセルID' => '',
				'備考欄' => '',
				'アライアンス番号' => '',
				'印刷チェック' => '',
				'契約日' => '',
				'DM発送日' => '',
				'NGDM発送日' => '',
				'導入商品' => '',
				'導入タイプ' => '',
				'DM発送' => '',
				'完成月' => '',
				'工事日' => '',
				'工事完了日' => '',
				'空ポート数' => '',
				'ひかり電話対応' => '',
				'提供方法' => '',
				'備考' => '',
				'入力者' => '',
				'インポートフラグ' => '',
				'生年月日' => '',
				'書類送付先_郵便番号' => '',
				'書類送付先_都道府県' => '',
				'書類送付先_市区' => '',
				'書類送付先_町名' => '',
				'書類送付先_番地' => '',
				'書類送付先_建物名' => '',
				'書類送付先_棟/部屋番号' => '',
				'NG日' => '',
				'架電指定日' => '',
				'DM戻り日' => '',
				'資料送付' => '',
				'資料送付先' => '',
				'DB入力者' => '',
				'NGDM発送一か月前日' => '',
				'NG理由' => '',
				'資料送付/架電NG/クレーム' => '',
				'性別' => '',
				'契約サービス' => '',
				'不動産小カテゴリ' => '',
				'KDDI' => '',
				'KDDIプラン' => '',
				'KDDI提供方式' => '',
				'YahooBB' => '',
				'無料PC' => '',
				'無料PC入電日' => '',
				'無料PC発注日' => '',
				'インポート済み' => '',
				'ミニミニ関東本部FAXフラグ' => '',
				'ダブリフラグ' => '',
				'WS契約日' => '',
				'WSステータス' => '',
				'WS備考' => '',
				'WSのみフラグ' => '',
				'WS開通月' => '',
				'WS開通日' => '',
				'移転NG_ISP' => '',
				'UpdateUser' => '',
				'UpdatePC' => '',
				'UpdateDate' => '',
				'EntryDate' => '',
				'イーアクセス' => '',
				'イーモバイル' => '',
				'auひかり' => '',
				'メガエッグ' => '',
				'コミュファ光' => '',
				'スターキャット' => '',
				'グリーンシティ' => '',
				'ドリームウェーブ' => '',
				'イッツコム' => '',
				'YahooBB（表示）' => '',
				'JCNよこはま' => '',
				'BBIQ' => '',
				'TNC_ADSL' => '',
				'担当者コード' => '',
				'次回架電日' => '',
				'契約者姓' => '',
				'契約者名' => '',
				'契約者とのご関係' => '',
				'契約者とのご関係（その他）' => '',
				'連絡先第一希望（電話番号）' => '',
				'連絡先第一希望' => '',
				'名義確認方法' => '',
				'名義確認方法（その他）' => '',
				'連絡先第二希望（電話番号）' => '',
				'連絡先第二希望' => '',
				'光サービス' => '',
				'ウィルスクリア' => '',
				'リモートサポート' => '',
				'光ポータブル本体' => '',
				'wifiクレードル' => '',
				'無線ルータ' => '',
				'ひかり電話番号' => '',
				'ひかり電話番号（元の回線）' => '',
				'ひかり電話ルータ' => '',
				'ひかり電話ルータ_無線カード' => '',
				'A_ひかり電話移行回線の契約者とフレッツ光契約者名義' => '',
				'A_ひかり電話移行回線の契約者とフレッツ光契約者電話番号' => '',
				'A_ひかり電話移行回線の契約者とフレッツ光契約者' => '',
				'A_ひかり電話移行回線の契約者とフレッツ光契約者との関係' => '',
				'A_ひかり電話移行回線の契約者とフレッツ光契約者との関係（その他）' => '',
				'B_休止表送付先' => '',
				'C_利用回線事業者' => '',
				'C_利用回線サービス' => '',
				'ひかり電話付加サービス_NTT東日本回線契約商品を継続' => '',
				'ひかり電話付加サービス_その他サービス' => '',
				'ひかり電話付加サービス選択' => '',
				'ナンバーディスプレイ' => '',
				'キャッチホン' => '',
				'着信お知らせメール' => '',
				'ボイスワープ' => '',
				'ナンバーリクエスト' => '',
				'迷惑電話おことわり' => '',
				'ダブルチャネル' => '',
				'マイナンバー' => '',
				'ボイスワープを利用したい番号の数（1～4）' => '',
				'マイナンバーを利用したい番号の数（1～4）' => '',
				'電話帳の送付' => '',
				'電話帳の掲載（有無）' => '',
				'電話帳の掲載' => '',
				'その他の電話契約（有無）' => '',
				'その他の電話契約_現在のNTT回線での契約を継続' => '',
				'その他の電話契約_発信者番号通知' => '',
				'その他の電話契約_通話明細記録' => '',
				'その他の電話契約_記録' => '',
				'その他の電話契約_＠ビリング' => '',
				'工事希望' => '',
				'工事希望曜日指定（月～日、祝）' => '',
				'工事希望日指定（例1/1AM）①' => '',
				'工事希望日指定（例1/1AM）②' => '',
				'工事立会人' => '',
				'工事立会人（その他)' => '',
				'工事立会人電話番号' => '',
				'工事立会人電話番号（その他)' => '',
				'PC台数（合計）' => '',
				'OS1' => '',
				'OS2' => '',
				'OS3' => '',
				'ルータ用意' => '',
				'ルータレンタル' => '',
				'ルータ設置' => '',
				'ルータタイプ' => '',
				'無線カード（枚数）' => '',
				'請求書宛名' => '',
				'請求書送付先' => '',
				'セットアップガイド・機器送付宛名' => '',
				'セットアップガイド・機器送付先' => '',
				'その他送付先氏名' => '',
				'その他送付先住所' => '',
				'ISP手配' => '',
				'PCとモジュラーの位置' => '',
				'工事実施部屋階数' => '',
				'工事実施部屋数' => '',
				'フレッツ光メンバーズクラブ申込' => '',
				'メールアドレス' => '',
				'Fstユーザ物件区分' => '',
				'Fstユーザ物件世帯数' => '',
				'Fst同時承諾' => '',
				'Fstキーマン情報' => '',
				'Fstキーマン種別' => '',
				'Fstキーマン（会社名）' => '',
				'Fstキーマン（担当者）' => '',
				'Fstキーマン連絡先' => '',
				'ご希望内容' => '',
				'ご連絡内容' => '',
				'予定日' => '',
				'連絡希望日' => '',
				'連絡希望日（指定）' => '',
				'連絡希望時間' => '',
				'連絡希望時間（指定）' => '',
				'無料PC申込' => '',
				'安心プラン' => '',
				'おまかせプラン' => '',
				'ISP申込' => '',
				'ISP登録証送付先' => '',
				'ISP登録証送付先変更' => '',
				'ISP名義' => '',
				'ISP名義(別名義人名)' => '',
				'ISP連絡先' => '',
				'ISP連絡先(別名義人連絡先)' => '',
				'ひかりTVパー' => '',
				'WS納品指定日' => '',
				'サンキュー送付先' => '',
				'サンキュー送付先変更' => '',
				'ルータの必要' => '',
				'無線ルータ手配' => '',
				'DBの電話番号' => '',
				'DBの電話番号(その他番号)' => '',
				'別名義契約' => '',
				'別名義契約者名' => '',
				'別名義契約者との関係' => '',
				'別名義理由' => '',
				'別名義理由（その他）' => '',
				'コンサル相手' => '',
				'現在のネット環境' => '',
				'保管契約' => '',
				'保管レター送付先' => '',
				'保管理由' => '',
				'保管理由_その他' => '',
				'次回架電予定日' => '',
				'次回架電時間' => '',
				'次回架電（その他）' => '',
				'次回架電不要' => '',
				'引越日確認' => '',
				'工事日確認' => '',
				'無派遣可否確認' => '',
				'サンキュー送付先確認' => '',
				'ガイド送付先確認' => '',
				'その他確認' => '',
				'ひかり電話NG理由' => '',
				'工事費用' => '',
				'帳票種別' => '',
				'携帯キャリア' => '',
				'ウォータサーバ' => '',
				'契約時間' => '',
				'記事欄' => '',
				'引越日' => '',
				'契約プラン' => '',
				'契約配線方式' => '',
				'空き状況' => '',
				'レカムチェック' => '',
				'初回代引き金額' => '',
				'WS備考欄' => '',
				'TOKAI' => '',
				'コスモライフ' => '',
			);
			*/

			$keys = array_keys($i_data);
			foreach ($keys as $key)
			{
				$i_data[$key] = array_shift($i_data_row);
			}
			var_dump($i_data);
		}
		fclose($fp);

		/*
		$values = array(
			'id' => $issue->id,
			'key' => $this->config->item('redmine_rest_key'),
			'status_id' => $this->config->item('redmine_status_id_new'),
			'tracker_id' => $this->config->item('redmine_tracker_id_paid'),
			'custom_fields' => array(
				array(
					'id' => $this->config->item('redmine_custom_field_id_paypal_txn_id'),
					'value' => $post['txn_id'],
				),
				array(
					'id' => $this->config->item('redmine_custom_field_id_paypal_receipt_id'),
					'value' => $post['receipt_id'],
				),
			),
		);
		$this->redmine->set($values)->save();
		if ($this->redmine->error !== FALSE)
		{
			$message = ''.
				'!! failed to write paypal info on redmine db !!'."\n".
				'error message is ... '.$this->redmine->error."\n".
				'$values => '.var_export($values, TRUE);
			trigger_error($message, E_USER_ERROR);
		}
		else
		{
			// 決済完了メールをお客様に送信
			$this->email->to($app_values['email']);
			$this->email->from($this->config->item('my_mail_address'));
			$this->email->subject($this->load->view('pc/mail/paid/subject', $app_values, TRUE));
			$this->email->message($this->load->view('pc/mail/paid/message', $app_values, TRUE));
			if ( ! $this->email->send())
			{
				$err_message = ''.
					'!! failed to send mail to customer. a payment process is completed. !!'."\n".
					'$app_values => '.var_export($app_values, TRUE);
				trigger_error($err_message, E_USER_ERROR);
			}

			// 管理者宛てにコピーを送信する
			$this->email->to($this->config->item('my_mail_address'));
			$this->email->from($app_values['email']);
			$this->email->subject($this->load->view('pc/mail/paid/subject', $app_values, TRUE));
			$this->email->message($this->load->view('pc/mail/paid/message', $app_values, TRUE));
			if ( ! $this->email->send())
			{
				$err_message = ''.
					'!! failed to send mail to admin. a payment process is completed. !!'."\n".
					'$app_values => '.var_export($app_values, TRUE);
				trigger_error($err_message, E_USER_ERROR);
			}
		}


		/*
		$tracker_id = $this->config->item('rm_tracker_id');

		$err_msg = '';
		foreach ($convert_status_sets as $convert_status_set)
		{
			$sql = ''.
				'select '.
					'id '.
				'from '.
					'issues '.
				'where '.
					'tracker_id = "'.$tracker_id.'" and '.
					'status_id = "'.$convert_status_set['src'].'"';
			$query = $this->db->query($sql);

			if ($query->num_rows() === 0)
			{
				echo $convert_status_set['label'].' target ticket is nothing.<br />'."\n";
				continue;
			}
			else
			{
				foreach ($query->result() as $row)
				{
					$values = array(
						'id' => $row->id,
						'key' => $this->config->item('redmine_rest_key'),
						'status_id' => $convert_status_set['dst'],
						'assigned_to_id' => '',
					);
					$this->redmine->set($values)->save();
					if ($this->redmine->error !== FALSE)
					{
						$err_msg .=
							'!! failed to auto migrate status and stirp assignment on redmine db !!'."\n".
							'error message is ... '.$this->redmine->error."\n".
							'$values => '.var_export($values, TRUE)."\n".
							'-----'."\n";
					}
				}
			}
		}
		if ($err_msg !== '')
		{
			trigger_error($err_msg, E_USER_ERROR);
		}
		else
		{
			echo 'done all process without error.';
		}
		*/
	}
}
