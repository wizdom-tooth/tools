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
    $('#summary_area').containedStickyScroll({
        duration: 150,
        closeChar: ''
    });
	*/
});
</script>


<style type="text/css">
<!--
.tmp_day th {
	font-size: 9px;
	width: 25%;
	background-image: -moz-linear-gradient(left, #FFFBC7, #C8A580);
	color: #000000;
	text-align: center;
	vertical-align: middle;
}
td.tmp {
	font-size: 9px;
	/*width: 25%;*/
	text-align: center;
	vertical-align: middle;
}
h1 {
    background-color: #FF5F00;
}
#input_area {
	float: left;
	width: 1000px;
	height: auto;
	margin: 4px;
	padding: 10px;
	background-color: #FFF799;
}
.week_box {
	width: 100%;
	background-color: #FFFFFF;
}
#summary_area {
	float: left;
	width: 230px;
	height: 400px;
	margin: 4px;
	padding: 10px;
	background-color: #FFBE73;
}
/*テーブル*/
table.yosan_month {
    width: 100%;
}
table.yosan_month th {
    width: 12.5%;
}
table.yosan_month th {
	text-align: center;
	color: #FFFFFF;
}
table.yosan_month td {
	vertical-align: top;
}
th.Mon, th.Tue, th.Wed, th.Thu, th.Fri {
	background-image: -moz-linear-gradient(left, #FFFBC7, #C8A580);
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
	height: 200px;
	background-image: -moz-linear-gradient(left, #FFFFFF, #FFFFE0);
}
td.Total {
	height: 200px;
	background-color: #A3F385;
}
td.Empty {
	height: 200px;
	background-color: #999999;
}

input[type="text"] {
    -webkit-box-shadow: 0px 1px rgba(255, 255, 255, 0.5);
    -moz-box-shadow: 0px 1px rgba(255, 255, 255, 0.5);
    box-shadow: 0px 1px rgba(255, 255, 255, 0.5);
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    width: 23px;
    height: 15px;
	margin-top: 3px;
	margin-bottom: 3px;
}
input[type="text"]:focus {
    border:solid 2px #FF4500;
}
#month_count {
	float: left;
	width: auto;
	height: 30px;
	margin: 4px;
	padding-left: 5px;
	padding-right: 5px;
	background-color: #FFF799;
}
#month_count input {
	width: 40px;
}
#weekday_weight {
	float: left;
	width: auto;
	height: 30px;
	margin: 4px;
	padding-left: 5px;
	padding-right: 5px;
	background-color: #FFF799;
}
.today {
	font-size: 15px;
	font-weight: bold;
	color: red;
	margin-right: 3px;
}
-->
</style>


<div class="space_5"></div>
<h1>ほげほげほげ</h1>


<form action="" method="post">
<div id="month_count">
月次対象数値：<input type="text" name="_month_count" value="<?php echo $month_count;?>"/>
</div>
<div id="weekday_weight">
金：<input type="text" name="_weekday_weight_fri" value="<?php echo $weekday_weights['Fri'];?>" />
土：<input type="text" name="_weekday_weight_sat" value="<?php echo $weekday_weights['Sat'];?>" />
日：<input type="text" name="_weekday_weight_sun" value="<?php echo $weekday_weights['Sun'];?>" />
月：<input type="text" name="_weekday_weight_mon" value="<?php echo $weekday_weights['Mon'];?>" />
火：<input type="text" name="_weekday_weight_tue" value="<?php echo $weekday_weights['Tue'];?>" />
水：<input type="text" name="_weekday_weight_wed" value="<?php echo $weekday_weights['Wed'];?>" />
木：<input type="text" name="_weekday_weight_thu" value="<?php echo $weekday_weights['Thu'];?>" />
</div>
<input type="submit" />
<div style="clear: both;"></div>
</form>


<div id="input_area">
<?php $week_orders = array('Total' => '計', 'Fri' => '金', 'Sat' => '土', 'Sun' => '日', 'Mon' => '月', 'Tue' => '火', 'Wed' => '水', 'Thu' => '木');?>
<?php foreach($yosan_week_infos as $wiz_week_id => $yosan_week_info):?>
<div class="week_box">
<table class="yosan_month">

<tr>
<?php foreach($week_orders as $week_order => $week_order_view): // TH層?>
<?php if ($week_order === 'Total'):?> 
<th class="Total"><?php echo $wiz_week_id;?> - 計</th>
<?php elseif (isset($yosan_week_info[$week_order])):?>
<?php list($year, $month, $day) = explode('-', $yosan_week_info[$week_order]['date']);?>
<?php $today = (date('Y-m-d') === $yosan_week_info[$week_order]['date']) ? '*' : ''; ?>
<th class="<?php echo $week_order;?>"><span class="today"><?php echo $today;?></span><?php echo $day . ' - ' . $week_order_view;?></th>
<?php else:?>
<th class="Empty">&nbsp;</th>
<?php endif;?>
<?php endforeach;?>
</tr>

<tr>
<?php foreach($week_orders as $week_order => $week_order_view): // TD層?>
<?php if ($week_order === 'Total'):?>
<td class="Total">hogehoge</td>
<?php elseif (isset($yosan_week_info[$week_order])):?>
<td class="<?php echo $week_order;?>"><?php echo $yosan_week_info[$week_order]['count'];?></td>
<?php else:?>
<td class="Empty">&nbsp;</td>
<?php endif;?>
<?php endforeach;?>
</tr>

</table>
</div>
<?php endforeach;?>
</div>

<!--
<div id="summary_area">
</div>
-->


<div style="clear: both;"></div>
