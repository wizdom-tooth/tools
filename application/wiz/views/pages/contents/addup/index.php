<script type='text/javascript'>

google.load('visualization', '1', {packages:['table']});
google.setOnLoadCallback(initializer);

// chart options
var table_option = {
	allowHtml: true,
	width: '100%',
};

// sum data table
var sum = {
<?php
$channels = array_keys($sum);
foreach ($channels as $channel)
{
	// チャンネル別集計表テーブル定義
	if ( ! empty($sum[$channel]))
	{
		$js_arrays = array();
		foreach ($sum[$channel] as $sum_time_zone)
		{
			$js_arrays[] = "['".implode("','", $sum_time_zone)."']";
		}
		$js_array_str = implode(',', $js_arrays);
		echo "".
			"${channel}:".
				"[".
					"[".
						"'日付',".
						"'時間帯',".
						"'照会実績',".
						"'契約実績',".
						"'内フレ実績',".
						"'ISP',".
						"'ウイルス',".
						"'リモート',".
						"'ひかりTVパ',".
						"'ひかりTV',".
						"'ひかり電話',".
						"'NG'".
					"],".
					$js_array_str.
				"],\n";
	}
}
?>
}

// user data table
<?php
if ( ! empty($sum_user))
{
	$user_names = array();
	foreach ($users as $tmp)
	{
		$user_names[] = "'".$tmp['user_name']."'";
	}
	$js_array_user_str = implode(',', $user_names);

	$time_zones = array(
		'A(10-12)',
		'B(12-14)',
		'C(14-16)',
		'D(16-18)',
		'E(18-20)',
		'F(20-LAST)',
	);
	$js_array_sum_user = array();
	foreach ($time_zones as $time_zone)
	{
		$time_zone_users = array();
		foreach ($users as $user)
		{
			$user_name = $user['user_name'];
			$flg = FALSE;
			foreach ($sum_user as $sum_user_element)
			{
				if (
					$sum_user_element['time_zone'] === $time_zone &&
					$sum_user_element['user_name'] === $user_name
				)
				{
					$time_zone_users[] = "'".$sum_user_element['contract_total']."'";
					$flg = TRUE;
					break;
				}
			}
			if ($flg === FALSE)
			{
				$time_zone_users[] = "'0'";
			}
		}
		$time_zone_users_str = implode(',', $time_zone_users);
		$js_array_sum_user[] = "['${year}-${month}-${day}','${time_zone}',${time_zone_users_str}]";
	}
	$js_array_sum_user_str = implode(',', $js_array_sum_user);
	echo "var sum_user = {".
		"user:".
			"[".
				"[".
					"'日付',".
					"'時間帯',".
					$js_array_user_str.
				"],".
				$js_array_sum_user_str.
			"]}\n";
}
?>

function initializer(){
	// テーブル描画
	drawChart();
	// カレンダーの追跡
	$('#calendar').containedStickyScroll({
		duration: 150,
		closeChar: 'カレンダーついてくんな！'
	});
	// タブ
	$('#tabs').tabs();
	// カレンダーの次月リンクを非表示にするかどうか
	<?php if($month === date('m')):?>
	$('#cal_next_url').replaceWith('<span class="gray">&gt;&gt;</span>');
	<?php endif;?>
	// 対象日をハイライト
	$('#calendar td a').each(function(i){
		if ($(this).text() == "<?php echo (int)$day;?>") {
			$(this).parent('td').addClass('cal_highlight_cell');
			$(this).replaceWith('<span class="cal_highlight_text">' + $(this).text() + "</span>")
		}
	});
}

// draw table
function drawChart(){
	<?php if ( ! empty($sum_user)):?>
		$('.no_addup').hide();

		// チャンネル別集計テーブル描画
		<?php $channels = array_keys($sum);?>
		<?php foreach ($channels as $channel):?>
		<?php if ( ! empty($sum[$channel])):?>
		var data = google.visualization.arrayToDataTable(sum['<?php echo $channel;?>']);
		var table = new google.visualization.Table(document.getElementById('table_<?php echo $channel;?>'));
		table.draw(data, table_option);
		$('#div_<?php echo $channel;?>').show();
		<?php endif;?>
		<?php endforeach;?>

		// 担当者別集計テーブル描画
		var data = google.visualization.arrayToDataTable(sum_user['user']);
		var table = new google.visualization.Table(document.getElementById('table_user'));
		table.draw(data, table_option);
		$('#div_user').show();
	<?php endif;?>
}

</script>

<!--target date-->
<h2>日次集計表<?php
if ($year !== '')  echo ' - ' . $year;
if ($month !== '') echo ' / ' . $month;
if ($day !== '')   echo ' / ' . $day;
?></h2>

<!--table area-->
<div class="box" id="table_wrapper">
<div id="tabs">
<ul>
<li><a href="#tabs-1">チャンネル別内訳</a></li>
<li><a href="#tabs-2">担当者別内訳</a></li>
</ul>
<div id="tabs-1">
<span class="no_addup">まだ集計が完了していません</span>
<div id="div_able_and_realestate">
<h3 class="label_blue">不動産・エイブル 合計</h3>
<div id="table_able_and_realestate"></div>
</div>
<div id="div_able_east">
<h3 class="label_blue">エイブル東</h3>
<div id="table_able_east"></div>
</div>
<div id="div_able_west">
<h3 class="label_blue">エイブル西</h3>
<div id="table_able_west"></div>
</div>
<div id="div_realestate_east">
<h3 class="label_blue">不動産東</h3>
<div id="table_realestate_east"></div>
</div>
<div id="div_realestate_west">
<h3 class="label_blue">不動産西</h3>
<div id="table_realestate_west"></div>
</div>
<div id="div_aeras">
<h3 class="label_pink">アエラス</h3>
<div id="table_aeras"></div>
</div>
<div id="div_soleil">
<h3 class="label_pink">ソレイユ</h3>
<div id="table_soleil"></div>
</div>
<div id="div_prime">
<h3 class="label_pink">プライム</h3>
<div id="table_prime"></div>
</div>
<div id="div_housepartner">
<h3 class="label_pink">ハウスパートナー</h3>
<div id="table_housepartner"></div>
</div>
<div id="div_house2house">
<h3 class="label_pink">ハウストゥハウス</h3>
<div id="table_house2house"></div>
</div>
<div id="div_ablehikkoshi_east">
<h3 class="label_skyblue">エイブル引越東</h3>
<div id="table_ablehikkoshi_east"></div>
</div>
<div id="div_ablehikkoshi_west">
<h3 class="label_skyblue">エイブル引越西</h3>
<div id="table_ablehikkoshi_west"></div>
</div>
<div id="div_ponta_east">
<h3 class="label_orange">ポンタ東</h3>
<div id="table_ponta_east"></div>
</div>
<div id="div_ponst_west">
<h3 class="label_orange">ポンタ西</h3>
<div id="table_ponta_west"></div>
</div>
<div id="div_his_east">
<h3 class="label_green">HIS東</h3>
<div id="table_his_east"></div>
</div>
<div id="div_his_west">
<h3 class="label_green">HIS西</h3>
<div id="table_his_west"></div>
</div>
<div id="div_nissei">
<h3 class="label_purple">日本生命</h3>
<div id="table_nissei"></div>
</div>
<div id="div_univ">
<h3 class="label_purple">大学</h3>
<div id="table_univ"></div>
</div>
<div id="div_isp">
<h3 class="label_gray">ISP</h3>
<div id="table_isp"></div>
</div>
<div id="div_iten">
<h3 class="label_gray">移転</h3>
<div id="table_iten"></div>
</div>
<div id="div_fletsclub_iten">
<h3 class="label_gray">フレッツクラブ移転</h3>
<div id="table_fletsclub_iten"></div>
</div>
<div id="div_ocn_upsell">
<h3 class="label_gray">OCNアップセル</h3>
<div id="table_ocn_upsell"></div>
</div>
<div id="div_benefit">
<h3 class="label_yellow">特典施策契約</h3>
<div id="table_benefit"></div>
</div>
</div>

<div id="tabs-2">
<span class="no_addup">まだ集計が完了していません</span>
<div id="div_user">
<h3 class="label_blue">担当者別集計</h3>
<div id="table_user"></div>
</div>
</div>

</div><!--tabs-->
</div><!--table_wrapper-->

<!--calendar area-->
<div class="box_solid" id="calendar">
<div class="space_20"></div>
<?php echo $calendar;?>
</div>

<div class="clear"></div>
