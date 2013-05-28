<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| paypal用設定
|--------------------------------------------------------------------------
*/

// posted params
$config['paypal_iframe_action_url']    = 'https://securepayments.sandbox.paypal.com/cgi-bin/acquiringweb';
$config['paypal_hidden_business']      = '4SG4PKAAZXEF6';
$config['paypal_hidden_cbt']           = '申請結果を確認する';
$config['paypal_hidden_subtotal']      = '6825';
$config['paypal_hidden_item_name']     = 'ESTA申請（テスト）';
$config['paypal_hidden_currency_code'] = 'JPY';
$config['paypal_hidden_notify_url']    = 'http://'.$_SERVER['HTTP_HOST'].'/notify/index.html';

// for validation of notification
$config['paypal_api_url_webscr']       = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
$config['paypal_param_receiver_email'] = 'plus_1352900311_biz@yahoo.co.jp';
$config['paypal_param_mc_gross']       = $config['paypal_hidden_subtotal'];
$config['paypal_param_mc_currency']    = 'JPY';
