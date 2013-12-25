<script type="text/javascript">
/* {{{ js */

google.load('visualization', '1', {packages:['table', 'corechart']});
google.setOnLoadCallback(init);

var raw_data = [
	<?php echo "['" . implode("', '", $addup_label) . "'],\n";?>
	<?php foreach ($addup_info as $info):?>
	<?php echo "['" . implode("', '", $info) . "'],\n";?>
	<?php endforeach;?>
]

function init(){
	$('#tabs').tabs({
		select: function(e, ui) {
			draw(String(String(ui.tab).match(/tab-.*/)));
		},
	});
	draw('tab-intro');
}

function draw(tab_kind){

	// ---------------------
	// 基本データ定義
	// ---------------------

	var data = google.visualization.arrayToDataTable(raw_data);
	var contract_data = new google.visualization.DataView(data);
	contract_data.setRows(contract_data.getFilteredRows([{
		column: 9,
		value: "契約"
	}]));

	intro_count    = data.getNumberOfRows();
	contract_count = contract_data.getNumberOfRows();
	complete_count = 10; // DEBUG *********************************** 

	// DEBUG************************
	if (tab_kind == 'tab-raw') {
		var table = new google.visualization.Table(document.getElementById('table'));
		table.draw(data);
		return;
	}

	// ---------------------
	// サマリ描画
	// ---------------------

	var summary_count = google.visualization.arrayToDataTable([
		['phase', 'count', {role:'style'}, {role:'annotation'}],
		['紹介', intro_count,    '#b87333', intro_count],
		['契約', contract_count, 'silver',  contract_count],
		['完成', complete_count, 'gold',    complete_count],
	]);

	var summary_option = {
		title: "件数サマリ",
		height: 200,
		bar: {groupWidth: "75%"},
		legend: "none",
	};
	var summary = new google.visualization.ColumnChart(document.getElementById("summary"));
	summary.draw(summary_count, summary_option);

	// ---------------------
	// 描画対象データを選択
	// ---------------------

	var chart_target_data = null;
	switch (tab_kind) {
		case 'tab-intro':
			chart_target_data = data;
			break;
		case 'tab-contract':
			chart_target_data = contract_data;
			break;
		case 'tab-complete':
			chart_target_data = contract_data;
			break;
	}

	// ---------------------
	// データ加工
	// ---------------------

	// 時間帯別集計
	var timezone_data = google.visualization.data.group(chart_target_data, [2], [{
		'column': 0,
		'label': '時間帯別集計',
		'aggregation': google.visualization.data.count,
		'type': 'number'
	}]);
	timezone_data.sort({column:1, desc:true});

	// チャネル別集計
	var channel_data = google.visualization.data.group(chart_target_data, [5], [{
		'column': 0,
		'label': 'チャネル別集計',
		'aggregation': google.visualization.data.count,
		'type': 'number'
	}]);
	channel_data.sort({column:1, desc:true});

	// ---------------------
	// チャート
	// ---------------------

	var pie_option = {
        is3D: true,
        chartArea: {
			left: 30,
			top: 10,
			width: '100%',
			height: '100%'
        },
		width: '500',
        height: '300',
	};

	var table_timezone = new google.visualization.Table(document.getElementById(tab_kind + '_table_timezone'));
	table_timezone.draw(timezone_data);
	var pie_timezone = new google.visualization.PieChart(document.getElementById(tab_kind + '_pie_timezone'));
	pie_timezone.draw(timezone_data, pie_option);
	var table_channel = new google.visualization.Table(document.getElementById(tab_kind + '_table_channel'));
	table_channel.draw(channel_data);
	var pie_channel = new google.visualization.PieChart(document.getElementById(tab_kind + '_pie_channel'));
	pie_channel.draw(channel_data, pie_option);
}
/* }}} */
</script>


<style type="text/css">
<!--
/* {{{ css */
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
	width: 830px;
	height: auto;
}
#right_box {
	float: left;
	width: 350px;
	height: auto;
}
#info_area {
	width: auto;
	height: auto;
	margin: 4px 0px 4px 4px;
	padding: 4px;
	background-color: #FFF799;
}
#summary {
	margin: 4px;
}
/* }}} */
-->
</style>


<h1>XXXXXXXXXx</h1>


<div id=wrapper>
<div id="left_box">
<div id="info_area">
<div id="summary"></div>

<div id="tabs">
<?php // 後で別ファイルに定義する事
$tabs = array(
	'intro'    => '紹介',
    'contract' => '契約',
    'complete' => '完成',
);
?>

<ul>
<?php foreach($tabs as $title => $name):?>
<li><a href="#tab-<?php echo $title;?>"><?php echo $name;?></a></li>
<?php endforeach;?>
<li><a href="#tab-raw">生データ</a></li>
</ul>

<?php foreach($tabs as $title => $name):?>
<div id="tab-<?php echo $title;?>">
<div id="tab-<?php echo $title;?>_table_channel"></div>
<div id="tab-<?php echo $title;?>_pie_channel"></div>
<div id="tab-<?php echo $title;?>_table_timezone"></div>
<div id="tab-<?php echo $title;?>_pie_timezone"></div>
</div>
<?php endforeach;?>

<div id="tab-raw">
<div id="table"></div>
</div>

</div><!--//tabs-->
</div><!--//info_area-->
</div><!--//left_box-->

<div style="clear: both;"></div>

</div><!--wrapper-->
