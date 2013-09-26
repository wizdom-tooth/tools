<script type='text/javascript'>

//google.load('visualization', '1', {packages:['table', 'corechart', 'annotatedtimeline', 'geochart']});
google.load('visualization', '1', {packages:['table']});
google.setOnLoadCallback(drawChartWrapper);

// chart options
var table_option = {
	//showRowNumber: true,
};

// sum data table
var sum = {
<?php
$channels = array_keys($sum);
foreach ($channels as $channel)
{
	$js_arrays = array();
	foreach ($sum[$channel] as $sum_time_zone)
	{
		$js_arrays[] = "['".implode("','", $sum_time_zone)."']";
	}
	$js_array_str = implode(',', $js_arrays);
	echo "${channel}: [['日付','時間帯','照会実績','契約実績','内フレッツ実績','ISP','ウイルス','リモート'],${js_array_str}],\n";
}
?>
}

// draw chart wrapper
function drawChartWrapper(){
	drawChart();
	$('#calendar').containedStickyScroll({
		duration: 150,
		closeChar: 'x'
	});
}

// draw table
function drawChart(){
	<?php $channels = array_keys($sum);?>
	<?php foreach ($channels as $channel):?>
	<?php if ( ! empty($sum[$channel])):?>
	var data = google.visualization.arrayToDataTable(sum['<?php echo $channel;?>']);
	var table = new google.visualization.Table(document.getElementById('table_<?php echo $channel;?>'));
	table.draw(data, table_option);
	$('#div_<?php echo $channel;?>').show();
	<?php endif;?>
	<?php endforeach;?>
}

</script>

<!--target date-->
<h2>予実集計表<?php
if ($year !== '')  echo ' - ' . $year;
if ($month !== '') echo ' / ' . $month;
if ($day !== '')   echo ' / ' . $day;
?></h2>

<!--table area-->
<div class="box" id="table_wrapper">
<div id="div_able">
<h3>エイブル総合</h3>
<div id="table_able"></div>
</div>
<div id="div_able_east">
<h3>エイブル東</h3>
<div id="table_able_east"></div>
</div>
<div id="div_able_west">
<h3>エイブル西</h3>
<div id="table_able_west"></div>
</div>
</div>

<!--calendar area-->
<div class="box_solid" id="calendar">
月次 | 週次 | 日次
<?php echo $calendar;?>
</div>

<div class="clear"></div>
