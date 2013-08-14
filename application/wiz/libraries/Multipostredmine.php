<?php

require_once('MultiProcess.php');

class Multipostredmine extends MultiProcess {

    const SRC_FILE_PATH_INTORODUCTION = '/home/wiz/work/wiz/migration/introduction.csv';
    const MULTI_WORK_BLOCK_SIZE = 300;

	private $_CI = NULL;
	private $_map_introduction_data = array();
	private $_map_status = array();

    public function __construct()
    {
        parent::__construct();
        $this->work = array($this, 'post_data');

		$this->_CI =& get_instance();
		$this->_CI->config->load('redmine');
		$this->_CI->load->library('redmine');

		// {{{ ステータスIDマッピング設定
		$this->_map_status = array(
			'NG' => $this->_CI->config->item('rm_status_id_ng'),
			'アポ' => $this->_CI->config->item('rm_status_id_tel_on_apodate'),
			'オプション契約' => $this->_CI->config->item('rm_status_id_contracted'),
			'キャンセル' => $this->_CI->config->item('rm_status_id_ng'),
			'契約' => $this->_CI->config->item('rm_status_id_contracted'),
			'検討中' => $this->_CI->config->item('rm_status_id_ng'), // NG
			'新規' => $this->_CI->config->item('rm_status_id_tel_by_us'),
			'新規(未架電)' => $this->_CI->config->item('rm_status_id_tel_by_us'), // 新規
			'折衝中' => $this->_CI->config->item('rm_status_id_ng'), // NG
			'店舗戻し' => $this->_CI->config->item('rm_status_id_tel_by_us'), // 要検討
			'入電待ち' => $this->_CI->config->item('rm_status_id_tel_by_client'),
			'不出(架電済)' => $this->_CI->config->item('rm_status_id_ng'), // NG
			'未折衝' => $this->_CI->config->item('rm_status_id_manken_done'),
		);
		// }}}

		// {{{ 紹介データマッピング設定
		$this->_map_introduction_data = array(
			'紹介ID' => $this->_CI->config->item('rm_cf_id_旧DB紹介ID'),
			'紹介日' => $this->_CI->config->item('rm_cf_id_紹介日'),
			'姓' => $this->_CI->config->item('rm_cf_id_姓'),
			'名' => $this->_CI->config->item('rm_cf_id_名'),
			'姓（フリガナ）' => $this->_CI->config->item('rm_cf_id_姓（フリガナ）'),
			'名（フリガナ）' => $this->_CI->config->item('rm_cf_id_名（フリガナ）'),
			'電話番号' => $this->_CI->config->item('rm_cf_id_電話番号'),
			'連絡先' => $this->_CI->config->item('rm_cf_id_連絡先'),
			'郵便番号' => $this->_CI->config->item('rm_cf_id_郵便番号'),
			'都道府県' => $this->_CI->config->item('rm_cf_id_都道府県'),
			'市区' => $this->_CI->config->item('rm_cf_id_市区'),
			'町名' => $this->_CI->config->item('rm_cf_id_町名'),
			'番地' => $this->_CI->config->item('rm_cf_id_番地'),
			'建物名' => $this->_CI->config->item('rm_cf_id_建物名'),
			'棟/部屋番号' => $this->_CI->config->item('rm_cf_id_棟/部屋番号'),
			'プラン' => $this->_CI->config->item('rm_cf_id_プラン'),
			'AL店舗番号' => $this->_CI->config->item('rm_cf_id_AL店舗番号'),
			'紹介店舗' => $this->_CI->config->item('rm_cf_id_紹介店舗'),
			'AL担当者' => $this->_CI->config->item('rm_cf_id_AL担当者'),
			'紹介時間' => $this->_CI->config->item('rm_cf_id_紹介時間'),
			'繋がりやすい日時' => $this->_CI->config->item('rm_cf_id_繋がりやすい日時'),
			'繋がりやすい時間' => $this->_CI->config->item('rm_cf_id_繋がりやすい時間'),
			'転居予定日' => $this->_CI->config->item('rm_cf_id_転居予定日'),
			'FAX受領日' => $this->_CI->config->item('rm_cf_id_FAX受領日'),
			'顧客ID' => $this->_CI->config->item('rm_cf_id_顧客ID'),
			'コール禁止' => $this->_CI->config->item('rm_cf_id_コール禁止'),
			'最新ステータス' => $this->_CI->config->item('rm_cf_id_最新ステータス'),
			'最終コール者' => $this->_CI->config->item('rm_cf_id_最終コール者'),
			'最終コール日' => $this->_CI->config->item('rm_cf_id_最終コール日'),
			'コール件数' => $this->_CI->config->item('rm_cf_id_コール件数'),
			'エクセルID' => $this->_CI->config->item('rm_cf_id_エクセルID'),
			'備考欄' => $this->_CI->config->item('rm_cf_id_備考欄'),
			'不動産会社' => $this->_CI->config->item('rm_cf_id_不動産会社'),
			'印刷チェック' => $this->_CI->config->item('rm_cf_id_印刷チェック'),
			'契約日' => $this->_CI->config->item('rm_cf_id_契約日'),
			'DM発送日' => $this->_CI->config->item('rm_cf_id_DM発送日'),
			'NGDM発送日' => $this->_CI->config->item('rm_cf_id_NGDM発送日'),
			'導入商品' => $this->_CI->config->item('rm_cf_id_導入商品'),
			'導入タイプ' => $this->_CI->config->item('rm_cf_id_導入タイプ'),
			'DM発送' => $this->_CI->config->item('rm_cf_id_DM発送'),
			'完成月' => $this->_CI->config->item('rm_cf_id_完成月'),
			'工事日' => $this->_CI->config->item('rm_cf_id_工事日'),
			'工事完了日' => $this->_CI->config->item('rm_cf_id_工事完了日'),
			'空ポート数' => $this->_CI->config->item('rm_cf_id_空ポート数'),
			'ひかり電話対応' => $this->_CI->config->item('rm_cf_id_ひかり電話対応'),
			'提供方法' => $this->_CI->config->item('rm_cf_id_提供方法'),
			'備考' => $this->_CI->config->item('rm_cf_id_備考'),
			'入力者' => $this->_CI->config->item('rm_cf_id_入力者'),
			'インポートフラグ' => $this->_CI->config->item('rm_cf_id_インポートフラグ'),
			'生年月日' => $this->_CI->config->item('rm_cf_id_生年月日'),
			'書類送付先_郵便番号' => $this->_CI->config->item('rm_cf_id_書類送付先_郵便番号'),
			'書類送付先_都道府県' => $this->_CI->config->item('rm_cf_id_書類送付先_都道府県'),
			'書類送付先_市区' => $this->_CI->config->item('rm_cf_id_書類送付先_市区'),
			'書類送付先_町名' => $this->_CI->config->item('rm_cf_id_書類送付先_町名'),
			'書類送付先_番地' => $this->_CI->config->item('rm_cf_id_書類送付先_番地'),
			'書類送付先_建物名' => $this->_CI->config->item('rm_cf_id_書類送付先_建物名'),
			'書類送付先_棟/部屋番号' => $this->_CI->config->item('rm_cf_id_書類送付先_棟/部屋番号'),
			'NG日' => $this->_CI->config->item('rm_cf_id_NG日'),
			'架電指定日' => $this->_CI->config->item('rm_cf_id_架電指定日'),
			'DM戻り日' => $this->_CI->config->item('rm_cf_id_DM戻り日'),
			'資料送付' => $this->_CI->config->item('rm_cf_id_資料送付'),
			'資料送付先' => $this->_CI->config->item('rm_cf_id_資料送付先'),
			'DB入力者' => $this->_CI->config->item('rm_cf_id_DB入力者'),
			'NGDM発送一か月前日' => $this->_CI->config->item('rm_cf_id_NGDM発送一か月前日'),
			'NG理由' => $this->_CI->config->item('rm_cf_id_NG理由'),
			'資料送付/架電NG/クレーム' => $this->_CI->config->item('rm_cf_id_資料送付/架電NG/クレーム'),
			'性別' => $this->_CI->config->item('rm_cf_id_性別'),
			'契約サービス' => $this->_CI->config->item('rm_cf_id_契約サービス'),
			'不動産会社区分' => $this->_CI->config->item('rm_cf_id_不動産会社区分'),
			'KDDI' => $this->_CI->config->item('rm_cf_id_KDDI'),
			'KDDIプラン' => $this->_CI->config->item('rm_cf_id_KDDIプラン'),
			'KDDI提供方式' => $this->_CI->config->item('rm_cf_id_KDDI提供方式'),
			'YahooBB' => $this->_CI->config->item('rm_cf_id_YahooBB'),
			'無料PC' => $this->_CI->config->item('rm_cf_id_無料PC'),
			'無料PC入電日' => $this->_CI->config->item('rm_cf_id_無料PC入電日'),
			'無料PC発注日' => $this->_CI->config->item('rm_cf_id_無料PC発注日'),
			'インポート済み' => $this->_CI->config->item('rm_cf_id_インポート済み'),
			'ミニミニ関東本部FAXフラグ' => $this->_CI->config->item('rm_cf_id_ミニミニ関東本部FAXフラグ'),
			'ダブリフラグ' => $this->_CI->config->item('rm_cf_id_ダブリフラグ'),
			'WS契約日' => $this->_CI->config->item('rm_cf_id_WS契約日'),
			'WSステータス' => $this->_CI->config->item('rm_cf_id_WSステータス'),
			'WS備考' => $this->_CI->config->item('rm_cf_id_WS備考'),
			'WSのみフラグ' => $this->_CI->config->item('rm_cf_id_WSのみフラグ'),
			'WS開通月' => $this->_CI->config->item('rm_cf_id_WS開通月'),
			'WS開通日' => $this->_CI->config->item('rm_cf_id_WS開通日'),
			'移転NG_ISP' => $this->_CI->config->item('rm_cf_id_移転NG_ISP'),
			'UpdateUser' => $this->_CI->config->item('rm_cf_id_UpdateUser'),
			'UpdatePC' => $this->_CI->config->item('rm_cf_id_UpdatePC'),
			'UpdateDate' => $this->_CI->config->item('rm_cf_id_UpdateDate'),
			'EntryDate' => $this->_CI->config->item('rm_cf_id_EntryDate'),
			'イーアクセス' => $this->_CI->config->item('rm_cf_id_イーアクセス'),
			'イーモバイル' => $this->_CI->config->item('rm_cf_id_イーモバイル'),
			'auひかり' => $this->_CI->config->item('rm_cf_id_auひかり'),
			'メガエッグ' => $this->_CI->config->item('rm_cf_id_メガエッグ'),
			'コミュファ光' => $this->_CI->config->item('rm_cf_id_コミュファ光'),
			'スターキャット' => $this->_CI->config->item('rm_cf_id_スターキャット'),
			'グリーンシティ' => $this->_CI->config->item('rm_cf_id_グリーンシティ'),
			'ドリームウェーブ' => $this->_CI->config->item('rm_cf_id_ドリームウェーブ'),
			'イッツコム' => $this->_CI->config->item('rm_cf_id_イッツコム'),
			'YahooBB（表示）' => $this->_CI->config->item('rm_cf_id_YahooBB（表示）'),
			'JCNよこはま' => $this->_CI->config->item('rm_cf_id_JCNよこはま'),
			'BBIQ' => $this->_CI->config->item('rm_cf_id_BBIQ'),
			'TNC_ADSL' => $this->_CI->config->item('rm_cf_id_TNC_ADSL'),
			'担当者コード' => $this->_CI->config->item('rm_cf_id_担当者コード'),
			'次回架電日' => $this->_CI->config->item('rm_cf_id_次回架電日'),
			'契約者姓' => $this->_CI->config->item('rm_cf_id_契約者姓'),
			'契約者名' => $this->_CI->config->item('rm_cf_id_契約者名'),
			'契約者とのご関係' => $this->_CI->config->item('rm_cf_id_契約者とのご関係'),
			'契約者とのご関係（その他）' => $this->_CI->config->item('rm_cf_id_契約者とのご関係（その他）'),
			'連絡先第一希望（電話番号）' => $this->_CI->config->item('rm_cf_id_連絡先第一希望（電話番号）'),
			'連絡先第一希望' => $this->_CI->config->item('rm_cf_id_連絡先第一希望'),
			'名義確認方法' => $this->_CI->config->item('rm_cf_id_名義確認方法'),
			'名義確認方法（その他）' => $this->_CI->config->item('rm_cf_id_名義確認方法（その他）'),
			'連絡先第二希望（電話番号）' => $this->_CI->config->item('rm_cf_id_連絡先第二希望（電話番号）'),
			'連絡先第二希望' => $this->_CI->config->item('rm_cf_id_連絡先第二希望'),
			'光サービス' => $this->_CI->config->item('rm_cf_id_光サービス'),
			'ウィルスクリア' => $this->_CI->config->item('rm_cf_id_ウィルスクリア'),
			'リモートサポート' => $this->_CI->config->item('rm_cf_id_リモートサポート'),
			'光ポータブル本体' => $this->_CI->config->item('rm_cf_id_光ポータブル本体'),
			'wifiクレードル' => $this->_CI->config->item('rm_cf_id_wifiクレードル'),
			'無線ルータ' => $this->_CI->config->item('rm_cf_id_無線ルータ'),
			'ひかり電話番号' => $this->_CI->config->item('rm_cf_id_ひかり電話番号'),
			'ひかり電話番号（元の回線）' => $this->_CI->config->item('rm_cf_id_ひかり電話番号（元の回線）'),
			'ひかり電話ルータ' => $this->_CI->config->item('rm_cf_id_ひかり電話ルータ'),
			'ひかり電話ルータ_無線カード' => $this->_CI->config->item('rm_cf_id_ひかり電話ルータ_無線カード'),
			'A_ひかり電話移行回線の契約者とフレッツ光契約者名義' => $this->_CI->config->item('rm_cf_id_A_ひかり電話移行回線の契約者とフレッツ光契約者名義'),
			'A_ひかり電話移行回線の契約者とフレッツ光契約者電話番号' => $this->_CI->config->item('rm_cf_id_A_ひかり電話移行回線の契約者とフレッツ光契約者電話番号'),
			'A_ひかり電話移行回線の契約者とフレッツ光契約者' => $this->_CI->config->item('rm_cf_id_A_ひかり電話移行回線の契約者とフレッツ光契約者'),
			'A_ひかり電話移行回線の契約者とフレッツ光契約者との関係' => $this->_CI->config->item('rm_cf_id_A_ひかり電話移行回線の契約者とフレッツ光契約者との関係'),
			'A_ひかり電話移行回線の契約者とフレッツ光契約者との関係（その他）' => $this->_CI->config->item('rm_cf_id_A_ひかり電話移行回線の契約者とフレッツ光契約者との関係（その他）'),
			'B_休止表送付先' => $this->_CI->config->item('rm_cf_id_B_休止表送付先'),
			'C_利用回線事業者' => $this->_CI->config->item('rm_cf_id_C_利用回線事業者'),
			'C_利用回線サービス' => $this->_CI->config->item('rm_cf_id_C_利用回線サービス'),
			'ひかり電話付加サービス_NTT東日本回線契約商品を継続' => $this->_CI->config->item('rm_cf_id_ひかり電話付加サービス_NTT東日本回線契約商品を継続'),
			'ひかり電話付加サービス_その他サービス' => $this->_CI->config->item('rm_cf_id_ひかり電話付加サービス_その他サービス'),
			'ひかり電話付加サービス選択' => $this->_CI->config->item('rm_cf_id_ひかり電話付加サービス選択'),
			'ナンバーディスプレイ' => $this->_CI->config->item('rm_cf_id_ナンバーディスプレイ'),
			'キャッチホン' => $this->_CI->config->item('rm_cf_id_キャッチホン'),
			'着信お知らせメール' => $this->_CI->config->item('rm_cf_id_着信お知らせメール'),
			'ボイスワープ' => $this->_CI->config->item('rm_cf_id_ボイスワープ'),
			'ナンバーリクエスト' => $this->_CI->config->item('rm_cf_id_ナンバーリクエスト'),
			'迷惑電話おことわり' => $this->_CI->config->item('rm_cf_id_迷惑電話おことわり'),
			'ダブルチャネル' => $this->_CI->config->item('rm_cf_id_ダブルチャネル'),
			'マイナンバー' => $this->_CI->config->item('rm_cf_id_マイナンバー'),
			'ボイスワープを利用したい番号の数（1～4）' => $this->_CI->config->item('rm_cf_id_ボイスワープを利用したい番号の数（1～4）'),
			'マイナンバーを利用したい番号の数（1～4）' => $this->_CI->config->item('rm_cf_id_マイナンバーを利用したい番号の数（1～4）'),
			'電話帳の送付' => $this->_CI->config->item('rm_cf_id_電話帳の送付'),
			'電話帳の掲載（有無）' => $this->_CI->config->item('rm_cf_id_電話帳の掲載（有無）'),
			'電話帳の掲載' => $this->_CI->config->item('rm_cf_id_電話帳の掲載'),
			'その他の電話契約（有無）' => $this->_CI->config->item('rm_cf_id_その他の電話契約（有無）'),
			'その他の電話契約_現在のNTT回線での契約を継続' => $this->_CI->config->item('rm_cf_id_その他の電話契約_現在のNTT回線での契約を継続'),
			'その他の電話契約_発信者番号通知' => $this->_CI->config->item('rm_cf_id_その他の電話契約_発信者番号通知'),
			'その他の電話契約_通話明細記録' => $this->_CI->config->item('rm_cf_id_その他の電話契約_通話明細記録'),
			'その他の電話契約_記録' => $this->_CI->config->item('rm_cf_id_その他の電話契約_記録'),
			'その他の電話契約_＠ビリング' => $this->_CI->config->item('rm_cf_id_その他の電話契約_＠ビリング'),
			'工事希望' => $this->_CI->config->item('rm_cf_id_工事希望'),
			'工事希望曜日指定（月～日、祝）' => $this->_CI->config->item('rm_cf_id_工事希望曜日指定（月～日、祝）'),
			'工事希望日指定（例1/1AM）①' => $this->_CI->config->item('rm_cf_id_工事希望日指定（例1/1AM）①'),
			'工事希望日指定（例1/1AM）②' => $this->_CI->config->item('rm_cf_id_工事希望日指定（例1/1AM）②'),
			'工事立会人' => $this->_CI->config->item('rm_cf_id_工事立会人'),
			'工事立会人（その他)' => $this->_CI->config->item('rm_cf_id_工事立会人（その他)'),
			'工事立会人電話番号' => $this->_CI->config->item('rm_cf_id_工事立会人電話番号'),
			'工事立会人電話番号（その他)' => $this->_CI->config->item('rm_cf_id_工事立会人電話番号（その他)'),
			'PC台数（合計）' => $this->_CI->config->item('rm_cf_id_PC台数（合計）'),
			'OS1' => $this->_CI->config->item('rm_cf_id_OS1'),
			'OS2' => $this->_CI->config->item('rm_cf_id_OS2'),
			'OS3' => $this->_CI->config->item('rm_cf_id_OS3'),
			'ルータ用意' => $this->_CI->config->item('rm_cf_id_ルータ用意'),
			'ルータレンタル' => $this->_CI->config->item('rm_cf_id_ルータレンタル'),
			'ルータ設置' => $this->_CI->config->item('rm_cf_id_ルータ設置'),
			'ルータタイプ' => $this->_CI->config->item('rm_cf_id_ルータタイプ'),
			'無線カード（枚数）' => $this->_CI->config->item('rm_cf_id_無線カード（枚数）'),
			'請求書宛名' => $this->_CI->config->item('rm_cf_id_請求書宛名'),
			'請求書送付先' => $this->_CI->config->item('rm_cf_id_請求書送付先'),
			'セットアップガイド・機器送付宛名' => $this->_CI->config->item('rm_cf_id_セットアップガイド・機器送付宛名'),
			'セットアップガイド・機器送付先' => $this->_CI->config->item('rm_cf_id_セットアップガイド・機器送付先'),
			'その他送付先氏名' => $this->_CI->config->item('rm_cf_id_その他送付先氏名'),
			'その他送付先住所' => $this->_CI->config->item('rm_cf_id_その他送付先住所'),
			'ISP手配' => $this->_CI->config->item('rm_cf_id_ISP手配'),
			'PCとモジュラーの位置' => $this->_CI->config->item('rm_cf_id_PCとモジュラーの位置'),
			'工事実施部屋階数' => $this->_CI->config->item('rm_cf_id_工事実施部屋階数'),
			'工事実施部屋数' => $this->_CI->config->item('rm_cf_id_工事実施部屋数'),
			'フレッツ光メンバーズクラブ申込' => $this->_CI->config->item('rm_cf_id_フレッツ光メンバーズクラブ申込'),
			'メールアドレス' => $this->_CI->config->item('rm_cf_id_メールアドレス'),
			'Fstユーザ物件区分' => $this->_CI->config->item('rm_cf_id_Fstユーザ物件区分'),
			'Fstユーザ物件世帯数' => $this->_CI->config->item('rm_cf_id_Fstユーザ物件世帯数'),
			'Fst同時承諾' => $this->_CI->config->item('rm_cf_id_Fst同時承諾'),
			'Fstキーマン情報' => $this->_CI->config->item('rm_cf_id_Fstキーマン情報'),
			'Fstキーマン種別' => $this->_CI->config->item('rm_cf_id_Fstキーマン種別'),
			'Fstキーマン（会社名）' => $this->_CI->config->item('rm_cf_id_Fstキーマン（会社名）'),
			'Fstキーマン（担当者）' => $this->_CI->config->item('rm_cf_id_Fstキーマン（担当者）'),
			'Fstキーマン連絡先' => $this->_CI->config->item('rm_cf_id_Fstキーマン連絡先'),
			'ご希望内容' => $this->_CI->config->item('rm_cf_id_ご希望内容'),
			'ご連絡内容' => $this->_CI->config->item('rm_cf_id_ご連絡内容'),
			'予定日' => $this->_CI->config->item('rm_cf_id_予定日'),
			'連絡希望日' => $this->_CI->config->item('rm_cf_id_連絡希望日'),
			'連絡希望日（指定）' => $this->_CI->config->item('rm_cf_id_連絡希望日（指定）'),
			'連絡希望時間' => $this->_CI->config->item('rm_cf_id_連絡希望時間'),
			'連絡希望時間（指定）' => $this->_CI->config->item('rm_cf_id_連絡希望時間（指定）'),
			'無料PC申込' => $this->_CI->config->item('rm_cf_id_無料PC申込'),
			'安心プラン' => $this->_CI->config->item('rm_cf_id_安心プラン'),
			'おまかせプラン' => $this->_CI->config->item('rm_cf_id_おまかせプラン'),
			'ISP申込' => $this->_CI->config->item('rm_cf_id_ISP申込'),
			'ISP登録証送付先' => $this->_CI->config->item('rm_cf_id_ISP登録証送付先'),
			'ISP登録証送付先変更' => $this->_CI->config->item('rm_cf_id_ISP登録証送付先変更'),
			'ISP名義' => $this->_CI->config->item('rm_cf_id_ISP名義'),
			'ISP名義(別名義人名)' => $this->_CI->config->item('rm_cf_id_ISP名義(別名義人名)'),
			'ISP連絡先' => $this->_CI->config->item('rm_cf_id_ISP連絡先'),
			'ISP連絡先(別名義人連絡先)' => $this->_CI->config->item('rm_cf_id_ISP連絡先(別名義人連絡先)'),
			'ひかりTVパー' => $this->_CI->config->item('rm_cf_id_ひかりTVパー'),
			'WS納品指定日' => $this->_CI->config->item('rm_cf_id_WS納品指定日'),
			'サンキュー送付先' => $this->_CI->config->item('rm_cf_id_サンキュー送付先'),
			'サンキュー送付先変更' => $this->_CI->config->item('rm_cf_id_サンキュー送付先変更'),
			'ルータの必要' => $this->_CI->config->item('rm_cf_id_ルータの必要'),
			'無線ルータ手配' => $this->_CI->config->item('rm_cf_id_無線ルータ手配'),
			'DBの電話番号' => $this->_CI->config->item('rm_cf_id_DBの電話番号'),
			'DBの電話番号(その他番号)' => $this->_CI->config->item('rm_cf_id_DBの電話番号(その他番号)'),
			'別名義契約' => $this->_CI->config->item('rm_cf_id_別名義契約'),
			'別名義契約者名' => $this->_CI->config->item('rm_cf_id_別名義契約者名'),
			'別名義契約者との関係' => $this->_CI->config->item('rm_cf_id_別名義契約者との関係'),
			'別名義理由' => $this->_CI->config->item('rm_cf_id_別名義理由'),
			'別名義理由（その他）' => $this->_CI->config->item('rm_cf_id_別名義理由（その他）'),
			'コンサル相手' => $this->_CI->config->item('rm_cf_id_コンサル相手'),
			'現在のネット環境' => $this->_CI->config->item('rm_cf_id_現在のネット環境'),
			'保管契約' => $this->_CI->config->item('rm_cf_id_保管契約'),
			'保管レター送付先' => $this->_CI->config->item('rm_cf_id_保管レター送付先'),
			'保管理由' => $this->_CI->config->item('rm_cf_id_保管理由'),
			'保管理由_その他' => $this->_CI->config->item('rm_cf_id_保管理由_その他'),
			'次回架電予定日' => $this->_CI->config->item('rm_cf_id_次回架電予定日'),
			'次回架電時間' => $this->_CI->config->item('rm_cf_id_次回架電時間'),
			'次回架電（その他）' => $this->_CI->config->item('rm_cf_id_次回架電（その他）'),
			'次回架電不要' => $this->_CI->config->item('rm_cf_id_次回架電不要'),
			'引越日確認' => $this->_CI->config->item('rm_cf_id_引越日確認'),
			'工事日確認' => $this->_CI->config->item('rm_cf_id_工事日確認'),
			'無派遣可否確認' => $this->_CI->config->item('rm_cf_id_無派遣可否確認'),
			'サンキュー送付先確認' => $this->_CI->config->item('rm_cf_id_サンキュー送付先確認'),
			'ガイド送付先確認' => $this->_CI->config->item('rm_cf_id_ガイド送付先確認'),
			'その他確認' => $this->_CI->config->item('rm_cf_id_その他確認'),
			'ひかり電話NG理由' => $this->_CI->config->item('rm_cf_id_ひかり電話NG理由'),
			'工事費用' => $this->_CI->config->item('rm_cf_id_工事費用'),
			'帳票種別' => $this->_CI->config->item('rm_cf_id_帳票種別'),
			'携帯キャリア' => $this->_CI->config->item('rm_cf_id_携帯キャリア'),
			'ウォータサーバ' => $this->_CI->config->item('rm_cf_id_ウォータサーバ'),
			'契約時間' => $this->_CI->config->item('rm_cf_id_契約時間'),
			'記事欄' => $this->_CI->config->item('rm_cf_id_記事欄'),
			'引越日' => $this->_CI->config->item('rm_cf_id_引越日'),
			'契約プラン' => $this->_CI->config->item('rm_cf_id_契約プラン'),
			'契約配線方式' => $this->_CI->config->item('rm_cf_id_契約配線方式'),
			'空き状況' => $this->_CI->config->item('rm_cf_id_空き状況'),
			'レカムチェック' => $this->_CI->config->item('rm_cf_id_レカムチェック'),
			'初回代引き金額' => $this->_CI->config->item('rm_cf_id_初回代引き金額'),
			'WS備考欄' => $this->_CI->config->item('rm_cf_id_WS備考欄'),
			'TOKAI' => $this->_CI->config->item('rm_cf_id_TOKAI'),
			'コスモライフ' => $this->_CI->config->item('rm_cf_id_コスモライフ'),
		);
		// }}}

        // 移行ソースデータファイルチェック
        if (
            ! file_exists(self::SRC_FILE_PATH_INTORODUCTION) ||
            ! is_readable(self::SRC_FILE_PATH_INTORODUCTION)
        )
        {
            echo 'ERROR: request src file is not readable.'."\n";
            echo 'XXXXXXXXXXXXXX set [error handling process] afrer few XXXXXXXXXXXXXXX'."\n";
        }

		// 引数セット
        $line_num = sizeof(file(self::SRC_FILE_PATH_INTORODUCTION));
        $block_num = ceil($line_num / self::MULTI_WORK_BLOCK_SIZE);
		$args = array();
        for  ($i = 0; $i < $block_num; $i++)
        {
			$args[] = $i * self::MULTI_WORK_BLOCK_SIZE;
        }
		$this->setArgs($args);
	}

    /**
     * 子プロセスで実行される処理。
     * @param $args
     */
    protected function post_data($arg)
    {
		$db = $this->_CI->load->database('redmine', TRUE);

		// 引数で指定された分だけDBからデータを取り出す
		$sql = "select src from tmp limit ${arg}, ".self::MULTI_WORK_BLOCK_SIZE;
		$query = $db->query($sql);
		$db->close();
		if ($query->num_rows() === 0)
		{
			echo 'src data is not found';
		}
		else
		{
			foreach ($query->result() as $raw_line)
			{
				$introduction_data = array();

				// 1行分ずつデータを配列に読み込む
				$raw_fields = explode(',', (string)$raw_line->src);
				$keys = array_keys($this->_map_introduction_data);
				foreach ($keys as $key)
				{
					$field = array_shift($raw_fields);
					$field = mb_convert_kana(trim($field), 'KVas');
					$introduction_data[$key] = $field;
				}

				// Redmine標準データ加工
				if (preg_match('/^\d*\/\d*\/\d*$/', $introduction_data['紹介日']))
				{
					list($y, $m, $d) = explode('/', $introduction_data['紹介日']);
					$introduction_data['紹介日'] = sprintf('%04d-%02d-%02d', $y, $m, $d);
				}
				else
				{
					echo "[WARN] 紹介日 is invalid date field.\n";
					echo "ID:{$introduction_data['紹介ID']} {$introduction_data['紹介日']}\n";
					$introduction_data['紹介ID'] = date('Y-m-d');
				}

				// Redmineカスタムフィールド書き込み準備
				$cf = array();
				foreach ($introduction_data as $key => $val)
				{
					if ($this->_map_introduction_data[$key] === FALSE) continue;

					// データ加工
					switch ($key)
					{
						case '無料PC入電日':
						case '無料PC発注日':
						case '生年月日':
						case '工事日':
						case '工事完了日':
						case '最新アポイント日付':
						case '最短':
						case '第一希望日':
						case '第二希望日':
						case '第三希望日':
						case 'その他希望日':
						case '39メール送付日':
						case '保管情報 次回架電予定日':
						case '予定日':
						case '連絡希望日':
						case '連絡希望日（指定）':
						case '即決判定日':
						case '後追架電日':
						case '船送日':
						case 'プロバイダ登録日':
						case 'CB発送日':
						case 'CB受付日':
						case '工事日架電日':
						case 'キャンセル日':
						case 'WS開通日':
						case 'WS契約日':
						case 'WPプレゼント受付日':
						case 'WPプレゼント発注日':
						case 'プレゼント受付日':
						case 'プレゼント発注日':
						case '2年割契約日':
						case '2年割登録日':
						case '2年割39送付日':
						case 'ISP用生年月日':
							if ($val !== '')
							{
								if (preg_match('/^\d*\/\d*\/\d*$/', $val))
								{
									list($y, $m, $d) = explode('/', $val);
									$val = sprintf('%04d-%02d-%02d', $y, $m, $d);
								}
								else
								{
									echo "[WARN] this is invalid date field.\n";
									echo "ID:{$introduction_data['紹介ID']} KEY:${key} VAL:${val}\n";
									$val = date('Y-m-d');
								}
							}
							break;
						case '不動産会社':
						case '紹介時間':
							$val = strtoupper($val);
							break;
					}
					$cf[] = array(
						'id'    => $this->_map_introduction_data[$key],
						'value' => $val,
					);
				}
				$address = ''.
					$introduction_data['都道府県'].
					$introduction_data['市区'].
					$introduction_data['町名'].
					$introduction_data['番地'];
				$cf[] = array(
					'id' => $this->_CI->config->item('rm_cf_id_住所'),
					'value' => mb_convert_kana($address, 'KVas'),
				);
				$building = ''.
					$introduction_data['建物名'].' '.
					$introduction_data['棟/部屋番号'];
				$cf[] = array(
					'id' => $this->_CI->config->item('rm_cf_id_建物名- 棟・部屋番号'),
					'value' => mb_convert_kana($building, 'KVas'),
				);

				// ステータス移行先をセット
				if (isset($this->_map_status[$introduction_data['最新ステータス']]))
				{
					$status_id = $this->_map_status[$introduction_data['最新ステータス']];
				}
				else
				{
					$status_id = $this->_CI->config->item('rm_status_id_UNKNOWN');
				}

				// チケットタイトル
				$subject_items = array();
				$froms = array();
				$names = array();
				$contacts = array();

				if ($introduction_data['不動産会社'])
					$froms[] = "[{$introduction_data['不動産会社']}]";
				if ($introduction_data['不動産会社区分'])
					$froms[] = $introduction_data['不動産会社区分'];
				if ($introduction_data['姓'])
					$names[] = $introduction_data['姓'];
				if ($introduction_data['名'])
					$names[] = $introduction_data['名'];
				if ($introduction_data['連絡先'])
					$contacts[] = $introduction_data['連絡先'];
				if (empty($contacts))
				{
					if ($introduction_data['電話番号'])
						$contacts[] = $introduction_data['電話番号'];
				}

				if ( ! empty($names))
					$subject_items[] = implode(' ', $names);
				if ( ! empty($contacts))
					$subject_items[] = implode(' ', $contacts);
				if ( ! empty($froms))
					$subject_items[] = implode(' ', $froms);
				$subject = implode(' - ', $subject_items);

				// Redmineに書き出す
				$values = array(
					'id' => NULL,
					'key' => $this->_CI->config->item('rm_rest_key'),
					'project_id' => $this->_CI->config->item('rm_project_id'),
					'tracker_id' => $this->_CI->config->item('rm_tracker_id'),
					'status_id' => $status_id,
					'priority_id' => $this->_CI->config->item('rm_priority_id_normal'),
					'author_id' => $this->_CI->config->item('rm_author_id_admin'),
					'start_date' => $introduction_data['紹介日'],
					'subject' => $subject,
					'description' => '',
					'custom_fields' => $cf,
				);
				$this->_CI->redmine->set($values)->save();
				if ($this->_CI->redmine->error !== FALSE)
				{
					$message = ''.
						'!! failed to write migration data on redmine db !!'."\n".
						'error message is ... '.$this->_CI->redmine->error."\n".
						'$values => '.var_export($values, TRUE);
					trigger_error($message, E_USER_ERROR);
				}
			}
		}
		echo "[INFO] {$arg} section is finished.\n";
    }
}
/* vim:set foldmethod=marker: */
