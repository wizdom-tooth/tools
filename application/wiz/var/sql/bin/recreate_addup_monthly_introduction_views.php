#!/usr/bin/php
<?php

$MYSQL_CLI =
    "echo '%%%SQL%%%' | /usr/bin/mysql -uroot -ponetop0721 wiz_planners";
$DROP_VIEW_SQL =
    "DROP VIEW IF EXISTS addup_monthly_introduction_%%%KIND%%%;";
$CREATE_VIEW_SQL =
    'CREATE VIEW addup_monthly_introduction_%%%KIND%%% AS '.
        'select '.
            'DATE_FORMAT(date, "%Y%m") as month, '.
            'channel, '.
            'east_or_west, '.
            'sum(1) as introduction '.
        'from '.
            'addup '.
        'where '.
            '%%%WHERE%%% '.
        'group by '.
            'DATE_FORMAT(date, "%Y%m"), '.
            'channel, '.
            'east_or_west';

$kinds = array(
    // general
    'total' => 'date != ""', // *********************
    'complete' => 'date != ""', // ******************
    'flets' => 'service = "フレッツ光"',
    'other' => 'service != "フレッツ光"',
    // isp
    'isp_total' => 'isp in ("OCN", "OCN(2年割)", "OCN(安心パック)", "YAHOO", "BIGLOBE")',
    'isp_biglobe' => 'isp = "BIGLOBE"',
    'isp_ocn' => 'isp in ("OCN", "OCN(2年割)", "OCN(安心パック)")',
    'isp_yahoo' => 'isp = "YAHOO"',
    // iten
    'iten' => 'service like "%移転%"',
    'iten_with_isp' => 'service like "%移転%" and isp in ("OCN", "OCN(2年割)", "OCN(安心パック)", "YAHOO", "BIGLOBE")',
    'only_isp' => 'service not like "%移転%" and isp in ("OCN", "OCN(2年割)", "OCN(安心パック)", "YAHOO", "BIGLOBE")',
    // hikari tel
    'hikari_tel_total' => 'hikari_tel not in ("", "無", "無し", "未入力")',
    'hikari_tel_plan_base' => 'hikari_tel like "%基本%"',
    'hikari_tel_plan_anshin' => 'hikari_tel like "%安心%"',
    'hikari_tel_plan_anshin_more' => 'hikari_tel like "%安心%"', // ***********************
    'hikari_tel_plan_a' => 'hikari_tel like "%エース%"',
    // option
    'option_virus' => 'virus not in ("", "未入力", "客意NG", "ウィルス無")',
    'option_remote' => 'remote not in ("", "未入力", "客意NG", "リモート無")',
    'option_hikari_tv_pa' => 'hikari_tv not in ("", "未入力", "不可", "客意NG")', // ***********
    'option_hikari_tv' => 'hikari_tv not in ("", "未入力", "不可", "客意NG")', // ***********
    'option_hikari_portable' => 'router = "光ポータブル"', // **********
    // 電力系・光ファイバ
    'e_hikari_fiber_kddi' => 'service = "AUひかり"', // *************
    'e_hikari_fiber_ucom' => 'service = "UCOM"', // ******************
    // mobile adsl
    'mobile_adsl_emobile' => 'service = "イーモバイル"',
    'mobile_adsl_eaccess' => 'service = "SO-NETイー・アクセス"',
    'mobile_adsl_yahoobb' => 'service = "YAHOOBB"',
    // catv
    'catv_itiscom' => 'service = "イッツコミュニケーションズ"', // **************
    'catv_jcnyokohama' => 'service = "イッツコミュニケーションズ"', // ***********
);

foreach ($kinds as $kind => $where)
{
    // DROP VIEW
    $dv_sql = $DROP_VIEW_SQL;
    $dv_sql = str_replace('%%%KIND%%%', $kind, $dv_sql);
    $cli = str_replace('%%%SQL%%%', $dv_sql, $MYSQL_CLI);
    exec($cli);

    // CREAETE VIEW
    $cv_sql = $CREATE_VIEW_SQL;
    $cv_sql = str_replace('%%%KIND%%%', $kind, $cv_sql);
    $cv_sql = str_replace('%%%WHERE%%%', $where, $cv_sql);
    $cli = str_replace('%%%SQL%%%', $cv_sql, $MYSQL_CLI);
    exec($cli);
}

exit;
