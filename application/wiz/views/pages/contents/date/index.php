<script type="text/javascript">
/* {{{ js */

google.load('visualization', '1', {packages:['table', 'corechart', 'gauge']});
google.setOnLoadCallback(init);

var raw_data = [
	<?php echo "['" . implode("', '", $addup_label) . "'],\n";?>
	<?php foreach ($addup_info as $info):?>
	<?php echo "['" . implode("', '", $info) . "'],\n";?>
	<?php endforeach;?>
]

function init(){
	$('#tabs').tabs({
		activate: function(e, ui) {
			var tab_kind = '';
			switch (ui.newTab.text())
			{
				case '紹介':
					tab_kind = 'tab-intro';
					break;
				case '契約':
					tab_kind = 'tab-contract';
					break;
				case '完成':
					tab_kind = 'tab-complete';
					break;
				case '生データ':
					tab_kind = 'tab-raw';
					break;
			}
			draw(tab_kind);
			//draw(String(String(ui.newTab.tab()).match(/tab-.*/)));
		},
	});
	draw('tab-intro');
	$('.chart_wrapper').corner("8px");
}

function draw(tab_kind){

	// ---------------------
	// 基本データ定義
	// ---------------------

	// 全データ
	var data = google.visualization.arrayToDataTable(raw_data);

	// 契約データ
	var contract_data = new google.visualization.DataView(data);
	contract_data.setRows(contract_data.getViewRows());
	contract_data.hideRows(contract_data.getFilteredRows([{column:18, value:''}]));

	// 完成データ
	var complete_data = new google.visualization.DataView(data);
	complete_data.setRows(complete_data.getViewRows());
	complete_data.hideRows(complete_data.getFilteredRows([{column:22, value:''}]));

	intro_count    = data.getNumberOfRows();
	contract_count = contract_data.getNumberOfRows();
	complete_count = complete_data.getNumberOfRows();

	// DEBUG************************
	if (tab_kind == 'tab-raw') {
		var table = new google.visualization.Table(document.getElementById('table'));
		table.draw(data);
		return;
	}

	// ---------------------
	// サマリ描画
	// ---------------------

	var ratio = Math.round((intro_count / <?php echo $yosan_intro_count;?>) * 100);
	var summary_intro_ratio_init = google.visualization.arrayToDataTable([
		['Label', 'Value'],
		['紹介消化率', 0]
	]);
	var summary_intro_ratio = google.visualization.arrayToDataTable([
		['Label', 'Value'],
		['紹介消化率', ratio]
	]);

	var options = {
		width: 200,
		height: 200,
		redFrom: 95,
		redTo: 100,
		minorTicks: 5,
		animation:{
			duration: 1000,
			easing: 'out',
		},
	};

	var summary_intro = new google.visualization.Gauge(document.getElementById('summary_intro'));
	summary_intro.draw(summary_intro_ratio_init, options);
    setTimeout(function(){
		summary_intro.draw(summary_intro_ratio, options);
    }, 600);

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
			chart_target_data = complete_data;
			break;
	}

	// データテーブル描画
    var table_option = {
        width: '100%',
    };
	var table = new google.visualization.Table(document.getElementById(tab_kind + '_table'));
	table.draw(chart_target_data, table_option);

	// ---------------------
	// データ加工
	// ---------------------

	// 時間帯別集計
	var timezone_data = google.visualization.data.group(chart_target_data, [2], [{
		'column': 0,
		'label': 'count',
		'aggregation': google.visualization.data.count,
		'type': 'number'
	}]);
	timezone_data.sort({column:1, desc:true});

	// チャネル別集計
	var channel_data = google.visualization.data.group(chart_target_data, [5], [{
		'column': 0,
		'label': 'count',
		'aggregation': google.visualization.data.count,
		'type': 'number'
	}]);
	channel_data.sort({column:1, desc:true});

	// 担当者別集計
	var staff_data = google.visualization.data.group(chart_target_data, [19], [{
		'column': 0,
		'label': 'count',
		'aggregation': google.visualization.data.count,
		'type': 'number'
	}]);
	staff_data.sort({column:1, desc:true});

	// ---------------------
	// チャート
	// ---------------------

	var pie_option = {
		title: '合計件数：' + chart_target_data.getNumberOfRows(),
		pieHole: 0.4,
        //is3D: true,
        chartArea: {
			left: 30,
			top: 30,
			width: '80%',
			height: '70%'
        },
		width: '300',
        height: '400',
		tooltip: {text: 'value'},
		legend: {position: 'bottom'},
	};

	// 時間帯チャート
	var table_timezone = new google.visualization.Table(document.getElementById(tab_kind + '_table_timezone'));
	table_timezone.draw(timezone_data, table_option);
	var pie_timezone = new google.visualization.PieChart(document.getElementById(tab_kind + '_pie_timezone'));
	pie_timezone.draw(timezone_data, pie_option);

	// チャネルチャート
	var table_channel = new google.visualization.Table(document.getElementById(tab_kind + '_table_channel'));
	table_channel.draw(channel_data, table_option);
	var pie_channel = new google.visualization.PieChart(document.getElementById(tab_kind + '_pie_channel'));
	pie_channel.draw(channel_data, pie_option);

	// 担当者チャート
	var table_staff = new google.visualization.Table(document.getElementById(tab_kind + '_table_staff'));
	table_staff.draw(staff_data, table_option);
	var pie_staff = new google.visualization.PieChart(document.getElementById(tab_kind + '_pie_staff'));
	pie_staff.draw(staff_data, pie_option);
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
	width: 1180px;
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
	margin: 4px 0px 4px 0px;
	background-color: #FFF799;
}
#summary {
	padding: 4px;
}
.chart_wrapper {
	float: left;
	width: 48%;
	margin: 3px 6px 3px 0px;
	padding: 7px;
	border:gray solid 1px;
}
.chart_unit {
	float: left;
}
.chart_unit_table {
	width: 40%;
}
div.chart_label {
	font-weight: bold;
	font-size: 20px;
	margin: 5px 0px 5px 0px;
}
/* }}} */
-->
</style>


<h1>XXXXXXXXXx</h1>


<div id=wrapper>
<div id="left_box">
<div id="info_area">
<div id="summary_intro"></div>

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
</ul>

<?php foreach($tabs as $title => $name):?>
<div id="tab-<?php echo $title;?>">

<div class="chart_wrapper">
<div class="chart_label">チャネル別集計</div>
<hr class="chart_label" />
<div class="chart_unit chart_unit_table" id="tab-<?php echo $title;?>_table_channel"></div>
<div class="chart_unit" id="tab-<?php echo $title;?>_pie_channel"></div>
<div style="clear: both;"></div>
</div>

<div class="chart_wrapper">
<div class="chart_label">時間帯別集計</div>
<hr class="chart_label" />
<div class="chart_unit chart_unit_table" id="tab-<?php echo $title;?>_table_timezone"></div>
<div class="chart_unit" id="tab-<?php echo $title;?>_pie_timezone"></div>
<div style="clear: both;"></div>
</div>

<div style="clear: both;"></div>

<div class="chart_wrapper">
<div class="chart_label">担当者別集計</div>
<hr class="chart_label" />
<div class="chart_unit chart_unit_table" id="tab-<?php echo $title;?>_table_staff"></div>
<div class="chart_unit" id="tab-<?php echo $title;?>_pie_staff"></div>
<div style="clear: both;"></div>
</div>

<div style="clear: both;"></div>

<div class="chart_label">データテーブル</div>
<hr class="chart_label" />
<div class="float_left" id="tab-<?php echo $title;?>_table"></div>

</div>
<?php endforeach;?>

</div><!--//tabs-->
</div><!--//info_area-->
</div><!--//left_box-->

<div style="clear: both;"></div>

</div><!--wrapper-->
