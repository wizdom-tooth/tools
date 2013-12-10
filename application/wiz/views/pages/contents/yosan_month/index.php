<script type="text/javascript">
$(function(){
	/*$('#input_area').corner().corner('dog tr 20px');*/
	$('#summary_area').corner();
    $('#summary_area').containedStickyScroll({
        duration: 150,
        closeChar: ''
    });
});
</script>


<style type="text/css">
<!--
td.tmp {
	font-size: 9px;
}
td.tmp_l {
	width: 55px;
}
td.tmp_r {
	width: auto;
}
h1 {
    background-color: #FF5F00;
}
#wrapper{
    width: 1240px;
}
#input_area {
	float: left;
	width: 950px;
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
    width: 32px;
    height: 15px;
	margin: 3px;
}
input[type="text"]:focus {
    border:solid 2px #FF4500;
}
-->
</style>


<div class="space_5"></div>
<h1>ほげほげほげ</h1>
<div id="wrapper">


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
<?php list($year, $month, $day) = explode('-', $yosan_week_info[$week_order]);?>
<th class="<?php echo $week_order;?>"><?php echo $day . ' - ' . $week_order_view;?></th>
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
<td class="<?php echo $week_order;?>">
<table>
<tr><td class="tmp tmp_l">ハウパ</td><td class="tmp tmp_r"><input type="text" value="aaaa" />件</td></tr>
<tr><td class="tmp tmp_l">ハウストゥ</td><td class="tmp tmp_r"><input type="text" value="aaaa" />件</td></tr>
<tr><td class="tmp tmp_l">既存店</td><td class="tmp tmp_r"><input type="text" value="aaaa" />件</td></tr>
<tr><td class="tmp tmp_l">既存店西</td><td class="tmp tmp_r"><input type="text" value="aaaa" />件</td></tr>
<tr><td class="tmp tmp_l">エイブル東</td><td class="tmp tmp_r"><input type="text" value="aaaa" />件</td></tr>
<tr><td class="tmp tmp_l">エイブル西</td><td class="tmp tmp_r"><input type="text" value="aaaa" />件</td></tr>
</table>
</td>
<?php else:?>
<td class="Empty">&nbsp;</td>
<?php endif;?>
<?php endforeach;?>
</tr>

</table>
</div>
<?php endforeach;?>
</div>

<div id="summary_area">
aaaaa
</div>

<div style="clear: both;"></div>

</div>
