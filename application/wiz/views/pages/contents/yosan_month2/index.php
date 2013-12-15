<script type="text/javascript">
$(function(){
	$('.tmp').each(function(i){
		var val = $(this).text();
		if (/^\+/.test(val)) {
			$(this).css('color', 'blue');
			$(this).css('font-weight', 'bold');
		} else if (/^\-/.test(val)) {
			$(this).css('color', 'red');
			$(this).css('font-weight', 'bold');
		}
	});
	/*
	$('#summary_area').corner();
	*/
    $('#right_box').containedStickyScroll({
        duration: 150,
        closeChar: ''
    });
});
</script>


<style type="text/css">
<!--
h1 {
	margin-top: 5px;
    background-color: #FFB700;
}
h3 {
	margin-top: 5px;
}
th, td {
	text-align: center;
	vertical-align: middle;
}
#wrapper {
	height: auto;
}
#left_box {
	float: left;
	width: 850px;
	height: auto;
}
#right_box {
	float: left;
	width: 350px;
	height: auto;
}
#info_area {
	width: auto;
	height: 800px;
	margin: 4px 0px 4px 4px;
	padding: 10px;
	background-color: #FFF799;
}
#summary_area {
	width: auto;
	height: 200px;
	margin: 4px 0px 4px 4px;
	padding: 10px;
    background-color: #FFF799;
}
#calendar_area {
	width: auto;
	height: auto;
	margin: 4px 0px 4px 4px;
	padding: 10px;
	background-color: #FFF799;
}

/*テーブル*/
table.yosan_month th, table.yosan_month td {
	font-size: 9px;
    width: 40px;
}
table.yosan_month th {
	color: #FFFFFF;
}
table.yosan_month td {
	height: 20px;
}
th.Mon, th.Tue, th.Wed, th.Thu, th.Fri {
	background-image: -moz-linear-gradient(left, #EFB98F, #C8A580);
}
th.Sat {
	background-color: #64A8D1;
}
th.Sun {
	background-color: #FF8673;
}
th.Total {
	background-color: #138900;
}
th.Empty {
	background-color: #999999;
}
td.Mon, td.Tue, td.Wed, td.Thu, td.Fri, td.Sat, td.Sun {
	height: 20px;
	background-image: -moz-linear-gradient(left, #FFFFFF, #FFFFD0);
}
td.Total {
	height: 20px;
	background-color: #A3F385;
}
td.Empty {
	height: 20px;
	background-color: #999999;
}
-->
</style>


<h1><?php echo $month;?>月度 予実管理表</h1>

<div id=wrapper>

<div id="left_box">
<div id="info_area">
ここに指定日付の各種予実情報を記載する
</div>
</div>


<div id="right_box">
<div id="summary_area">
ここに当該月度情報のサマリを記載する
</div>
<div id="calendar_area">
<?php $week_orders = array('Total' => '計', 'Fri' => '金', 'Sat' => '土', 'Sun' => '日', 'Mon' => '月', 'Tue' => '火', 'Wed' => '水', 'Thu' => '木');?>
<?php foreach($yosan_week_infos as $wiz_week_id => $yosan_week_info):?>
<table class="yosan_month">

<tr>
<?php foreach($week_orders as $week_order => $week_order_view): // TH層?>
<?php if ($week_order === 'Total'):?> 
<th class="Total"><?php list(,$week_num) = explode('_', $wiz_week_id); echo $week_num;?></th>
<?php elseif (isset($yosan_week_info[$week_order])):?>
<?php list($year, $month, $day) = explode('-', $yosan_week_info[$week_order]);?>
<th class="<?php echo $week_order;?>"><?php echo $month.'/'.$day.'<br />'.$week_order_view;?></th>
<?php else:?>
<th class="Empty"></th>
<?php endif;?>
<?php endforeach;?>
</tr>

<tr>
<?php foreach($week_orders as $week_order => $week_order_view): // TD層?>
<?php if ($week_order === 'Total'):?>
<td class="Total">hoge</td>
<?php elseif (isset($yosan_week_info[$week_order])):?>
<td class="<?php echo $week_order;?>">aa</td>
<?php else:?>
<td class="Empty">&nbsp;</td>
<?php endif;?>
<?php endforeach;?>
</tr>

</table>
<?php endforeach;?>
</div>
</div>


<div style="clear: both;"></div>

</div><!--wrapper-->
