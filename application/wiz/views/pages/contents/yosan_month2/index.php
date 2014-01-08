<script type="text/javascript">
/* {{{ js general */
google.load('visualization', '1', {packages:['table', 'corechart', 'gauge']});
google.setOnLoadCallback(init);

var combo_option = {
	vAxis: {title: "件数"},
	series: {
		0:{type: "line", pointSize: 3},
		1:{type: "line", pointSize: 3},
		2:{type: "steppedArea", targetAxisIndex: 1},
		3:{type: "steppedArea", targetAxisIndex: 1},
	},
	curveType: "function",
	height: 570,
	chartArea: {
		width: '90%',
		height: '70%',
	},
	legend: {position: 'top', textStyle: {fontSize: 16}},
}
var counter_option = {imagePath: "/assets/wiz/img/flipCounter-medium.png"};
var pie_option = {
	//title: '合計件数：' + intro_count,
	pieHole: 0.4,
	chartArea: {width: '90%', height: '90%'},
	width: '600',
	height: '400',
};
var bar_option = {
	//animation:{duration: 1000, easing: 'inAndOut'},
	legend: {position: "none"},
	hAxis:{
		viewWindow:{min: 0, max: 100},
		gridlines:{count: 2},
		baseline: 0,
	},
	chartArea: {width: '85%'},
};
var table_option = {width: '450'};
var raw_data = [
    <?php echo "['" . implode("', '", $addup_label) . "'],\n";?>
    <?php foreach ($addup_info as $info):?>
    <?php echo "['" . implode("', '", $info) . "'],\n";?>
    <?php endforeach;?>
];

function init(){
	$('#calendar_label').bind('click', function(e){
		$('#calendar_area').animate({height:'toggle'}, {duration:'slow', easing:'swing'});
	});
    $('.chart_wrapper').corner("8px");
    $('#tabs').tabs({
        activate: function(e, ui){
            switch (ui.newTab.text())
            {
                case '紹介':
					draw_tab_intro();
                    break;
                case '契約':
					draw_tab_contract();
                    break;
                case '予算入力':
					draw_tab_yosan();
                    break;
            }
        }
    });
    draw_tab_intro();
}
/* }}} */

/* {{{ js intro */
function draw_tab_intro(){

	var group_option = [{
        'column': 0,
        'label': 'count',
        'aggregation': google.visualization.data.count,
        'type': 'number'
	}];

    // ---------------------
    // データ整理
    // ---------------------

    var chart_target_data = google.visualization.arrayToDataTable(raw_data); // データ表
    intro_count = chart_target_data.getNumberOfRows(); // 件数
    var ratio = Math.round((intro_count / <?php echo $yosan_intro_count;?>) * 100); // 予算達成率

    // チャネル別集計
    var channel_data = google.visualization.data.group(chart_target_data, [5], group_option);
    channel_data.sort({column:1, desc:true});

    // 時間帯別集計
    var timezone_data = google.visualization.data.group(chart_target_data, [2], group_option);
    timezone_data.sort({column:1, desc:true});

    // ---------------------
    // 種別チャート描画
    // ---------------------

    // チャネル別チャート
    var pie_channel   = new google.visualization.PieChart($('#tab_intro_pie_channel').get(0));
	var table_channel = new google.visualization.Table($('#tab_intro_table_channel').get(0));
    pie_channel.draw(channel_data, pie_option);
	table_channel.draw(channel_data, table_option);
	$('#bxslider_intro_channel').bxSlider({
		infiniteLoop: false,
	});

    // 時間帯チャート
    var pie_timezone   = new google.visualization.PieChart($('#tab_intro_pie_timezone').get(0));
    var table_timezone = new google.visualization.Table($('#tab_intro_table_timezone').get(0));
    pie_timezone.draw(timezone_data, pie_option);
    table_timezone.draw(timezone_data, table_option);
	$('#bxslider_intro_timezone').bxSlider({
		infiniteLoop: false,
	});

    // ---------------------
    // 予算達成率チャート描画
    // ---------------------

	// バーチャート描画
    var yojitsu_done_intro = new google.visualization.BarChart($('#yojitsu_done_intro').get(0));
    var summary_intro_ratio = google.visualization.arrayToDataTable([['', ''], ['', ratio]]);
    yojitsu_done_intro.draw(summary_intro_ratio, bar_option);

	// 百分率カウンター
	$("#yojitsu_done_intro_counter").flipCounter(counter_option);
    setTimeout(function(){$("#yojitsu_done_intro_counter").flipCounter(
		"startAnimation",
		{
			number: 0,
			end_number: ratio,
			easing: jQuery.easing.easeOutCubic,
			duration: 1000,
		}
	);}, 600);
}
/* }}} */

/* {{{ js contract */
function draw_tab_contract() {

	var group_option = [{
        'column': 0,
        'label': 'count',
        'aggregation': google.visualization.data.count,
        'type': 'number'
	}];

	// ----------------
	// PICKER
	// ----------------

/*
	var picker_contract_staff = new google.visualization.ControlWrapper({
		'controlType': 'CategoryFilter',
		'containerId': 'picker_contract_staff',
		'options': {
			'filterColumnLabel': '担当者',
			'ui': {
				'labelStacking': 'vertical',
				'allowTyping': false,
				'allowMultiple': false
			}
		}
	});

	// ----------------
	// PIE CHART
	// ----------------

	var pie_contract_channel = new google.visualization.ChartWrapper({
		'chartType': 'PieChart',
		'containerId': 'pie_contract_channel',
		'options': {
			'width': 300,
			'height': 300,
			'legend': 'none',
			//'title': 'Donuts eaten per person',
			//'chartArea': {'left': 15, 'top': 15, 'right': 0, 'bottom': 0},
			//'pieSliceText': 'label'
		},
		'view': {'columns': [0, 5]}
	});

	var pie_contract_timezone = new google.visualization.ChartWrapper({
		'chartType': 'PieChart',
		'containerId': 'pie_contract_timezone',
		'options': {
			'width': 300,
			'height': 300,
			'legend': 'none',
			//'title': 'Donuts eaten per person',
			//'chartArea': {'left': 15, 'top': 15, 'right': 0, 'bottom': 0},
			//'pieSliceText': 'label'
		},
		'view': {'columns': [0, 2]}
	});

	var pie_contract_staff = new google.visualization.ChartWrapper({
		'chartType': 'PieChart',
		'containerId': 'pie_contract_staff',
		'options': {
			'width': 300,
			'height': 300,
			'legend': 'none',
			//'title': 'Donuts eaten per person',
			//'chartArea': {'left': 15, 'top': 15, 'right': 0, 'bottom': 0},
			//'pieSliceText': 'label'
		},
		'view': {'columns': [0, 19]}
	});

	// ----------------
	// TABLE
	// ----------------

	var table_contract_channel = new google.visualization.ChartWrapper({
		'chartType': 'Table',
		'containerId': 'table_contract_channel',
		'options': {
			'width': '300px'
		}
	});

	var table_contract_timezone = new google.visualization.ChartWrapper({
		'chartType': 'Table',
		'containerId': 'table_contract_timezone',
		'options': {
			'width': '300px'
		}
	});

	var table_contract_staff = new google.visualization.ChartWrapper({
		'chartType': 'Table',
		'containerId': 'table_contract_staff',
		'options': {
			'width': '300px'
		}
	});
*/

    // ---------------------
    // データ整理
    // ---------------------

    // 契約データ 契約日が空のモノを無視する
    var data = google.visualization.arrayToDataTable(raw_data);
    var chart_target_data = new google.visualization.DataView(data);
    chart_target_data.setRows(chart_target_data.getViewRows());
    chart_target_data.hideRows(chart_target_data.getFilteredRows([{column:18, value:''}]));

	// 基本データ
	var chart_target_data = chart_target_data;
    var contract_count = chart_target_data.getNumberOfRows();
    var ratio = Math.round((contract_count / <?php echo array_sum($yosan_contract_count);?>) * 100);

    // チャネル別集計
    var channel_data = google.visualization.data.group(chart_target_data, [5], group_option);
    channel_data.sort({column:1, desc:true});

    // 時間帯別集計
    var timezone_data = google.visualization.data.group(chart_target_data, [2], group_option);
    timezone_data.sort({column:1, desc:true});

    // 担当者別集計
    var staff_data = google.visualization.data.group(chart_target_data, [19], group_option);
    staff_data.sort({column:1, desc:true});

    // ---------------------
    // 種別チャート描画
    // ---------------------

    // チャネル別チャート
    var pie_channel   = new google.visualization.PieChart($('#tab_contract_pie_channel').get(0));
	var table_channel = new google.visualization.Table($('#tab_contract_table_channel').get(0));
    pie_channel.draw(channel_data, pie_option);
	table_channel.draw(channel_data, table_option);
	$('#bxslider_contract_channel').bxSlider({infiniteLoop: false});

    // 時間帯チャート
    var pie_timezone   = new google.visualization.PieChart($('#tab_contract_pie_timezone').get(0));
    var table_timezone = new google.visualization.Table($('#tab_contract_table_timezone').get(0));
    pie_timezone.draw(timezone_data, pie_option);
    table_timezone.draw(timezone_data, table_option);
	$('#bxslider_contract_timezone').bxSlider({infiniteLoop: false});

    // 担当者チャート
    var pie_staff   = new google.visualization.PieChart($('#tab_contract_pie_staff').get(0));
    var table_staff = new google.visualization.Table($('#tab_contract_table_staff').get(0));
    pie_staff.draw(staff_data, pie_option);
    table_staff.draw(staff_data, table_option);
	$('#bxslider_contract_staff').bxSlider({infiniteLoop: false});

    // ---------------------
    // 予算達成率チャート描画
    // ---------------------

	// バーチャート描画
    var yojitsu_done_contract = new google.visualization.BarChart($('#yojitsu_done_contract').get(0));
    var summary_contract_ratio = google.visualization.arrayToDataTable([['', ''], ['', ratio]]);
    yojitsu_done_contract.draw(summary_contract_ratio, bar_option);

	// 百分率カウンター
	$("#yojitsu_done_contract_counter").flipCounter(counter_option);
    setTimeout(function(){$("#yojitsu_done_contract_counter").flipCounter(
		"startAnimation",
		{
			number: 0,
			end_number: ratio,
			easing: jQuery.easing.easeOutCubic,
			duration: 1000,
		}
	);}, 600);

	// ---------------------
	// 日毎の進捗タイムラインチャート描画
    // ---------------------

	var timeline_data = google.visualization.arrayToDataTable([
		['日付', '契予積算', '契実積算', '契予', '契実'],
		<?php foreach ($week_days_info as $week_info):?>
		<?php foreach ($week_info as $day_info):?>
		['<?php echo $day_info['date'];?>', <?php echo $day_info['yosan_addup'];?>, <?php echo $day_info['result_addup'];?>, <?php echo $day_info['yosan'];?>, <?php echo $day_info['result'];?>],
		<?php endforeach;?>
		<?php endforeach;?>
	]);
	var contract_timeline = new google.visualization.LineChart($('#tab_contract_timeline').get(0));
	contract_timeline.draw(timeline_data, combo_option);
}
/* }}} */

/* {{{ js yosan */
function draw_tab_yosan(){}
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
	/*width: 900px;*/
	width: auto;
	height: auto;
}
#info_area {
	width: auto;
	height: auto;
	margin: 4px 0px 4px 4px;
	padding: 2px;
	background-color: #FFF799;
}
#calendar_label {
	height: 20px;
    background-color: #AAAAAA;
	margin: 3px 3px 0px 3px;
}
#calendar_area {
	width: auto;
	height: auto;
	margin: 3px;
	display:none;
	background-color: #FFF799;
}
.width_fix {
	width: 100%;
	min-width: 1200px;
}
.chart_border {
    float: left;
	width: 50%;
	height: auto;
}
.chart_wrapper {
	margin: 3px;
    padding: 15px;
	/*width: 100%;*/
    border:gray solid 1px;
}
.chart_unit {
    float: left;
}
.chart_unit_table {
    width: 100%;
}
span.chart_label {
    font-weight: bold;
    font-size: 20px;
    margin: 5px 0px 5px 0px;
}
#yojitsu_done_intro, #yojitsu_done_contract{
	width: 55%;
	float: left;
}
#yojitsu_done_intro_counter, #yojitsu_done_contract_counter {
	width: auto;
	margin-top: 65px;
	float: left;
}
.counter_unit {
	width: auto;
	font-size: 40px;
	font-weight: bold;
	margin-top: 60px;
	margin-left: 10px;
	float: left;
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
	background-image: -moz-linear-gradient(left, #64A8D1, #462B83);
}
th.Sun, th.Hol {
	background-image: -moz-linear-gradient(left, #FF8673, #F30021);
}
th.Total {
	background-image: -moz-linear-gradient(left, #83F03C, #138900);
}
th.Empty {
	background-color: #999999;
}
td.Mon, td.Tue, td.Wed, td.Thu, td.Fri, td.Sat, td.Sun, td.Hol {
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
.today {
    font-size: 15px;
    font-weight: bold;
    color: red;
    margin-right: 3px;
}
/* }}} */
-->
</style>


<h1><?php echo $month;?>月度 予実管理表</h1>


<div id=wrapper>
<div id="left_box">
<div id="info_area">

<!--==カレンダー==-->
<div id="calendar_label">カレンダー表示・非表示</div>
<div id="calendar_area">
<?php $week_orders = array('Total' => '計', 'Fri' => '金', 'Sat' => '土', 'Sun' => '日', 'Mon' => '月', 'Tue' => '火', 'Wed' => '水', 'Thu' => '木');?>
<?php foreach($week_days_info as $wiz_week_id => $info):?>
<table class="yosan_month">
<tr>
<?php foreach($week_orders as $week_order => $week_order_view): // TH層?>
<?php if ($week_order === 'Total'):?> 
<th class="Total"><?php list(,$week_num) = explode('_', $wiz_week_id); echo $week_num;?></th>
<?php elseif (isset($info[$week_order])):?>
<?php $today = (date('Y-m-d') === $info[$week_order]['date']) ? '*' : ''; ?>
<?php list($year, $month, $day) = explode('-', $info[$week_order]['date']);?>
<th class="<?php echo ($info[$week_order]['holiday'] === TRUE) ? 'Hol' : $week_order;?>">
<?php echo $month.'/'.$day;?><br />
<?php if ($today !== ''):?>
<span class="today"><?php echo $today;?></span>
<?php endif;?>
<?php echo $week_order_view;?>
</th>
<?php else:?>
<th class="Empty"></th>
<?php endif;?>
<?php endforeach;?>
</tr>
<tr>
<?php foreach($week_orders as $week_order => $week_order_view): // TD層?>
<?php if ($week_order === 'Total'):?>
<td class="Total">hoge</td>
<?php elseif (isset($info[$week_order])):?>
<td class="<?php echo ($info[$week_order]['holiday'] === TRUE) ? 'Hol' : $week_order;?>"><?php echo round($info[$week_order]['weight'] * 100, 2);?></td>
<?php else:?>
<td class="Empty">&nbsp;</td>
<?php endif;?>
<?php endforeach;?>
</tr>
</table>
<?php endforeach;?>
</div><!--==/カレンダー-->


<div id="tabs">
<ul>
<li><a href="#tab_intro">紹介</a></li>
<li><a href="#tab_contract">契約</a></li>
<li><a href="#tab_yosan">予算入力</a></li>
</ul>

<!--===紹介===-->
<div id="tab_intro">
<div class="width_fix">

<div class="chart_border">
<div class="chart_wrapper">
<span class="chart_label">紹介予算消化率</span>
<hr class="chart_label" />
<div id="yojitsu_done_intro"></div>
<div id="yojitsu_done_intro_counter"><input type="hidden" name="counter-value"/></div>
<div class="counter_unit">%</div>
<div style="clear: both;"></div>
</div>
</div>
<div style="clear: both;"></div>

<div class="chart_border">
<div class="chart_wrapper">
<span class="chart_label">チャネル別集計</span>
<hr class="chart_label" />
<ul id="bxslider_intro_channel">
<li><div class="chart_unit" id="tab_intro_pie_channel"></div></li>
<li><div class="chart_unit chart_unit_table" id="tab_intro_table_channel"></div></li>
</ul>
</div>
</div>

<div class="chart_border">
<div class="chart_wrapper">
<span class="chart_label">時間帯別集計</span>
<hr class="chart_label" />
<ul id="bxslider_intro_timezone">
<li><div class="chart_unit" id="tab_intro_pie_timezone"></div></li>
<li><div class="chart_unit chart_unit_table" id="tab_intro_table_timezone"></div></li>
</ul>
</div>
</div>
<div style="clear: both;"></div>

<!--for debug
<span class="chart_label">データテーブル</span>
<hr class="chart_label" />
<div class="float_left" id="tab_intro_table"></div>
-->

</div>
</div>


<!--===契約===-->
<div id="tab_contract">
<div class="width_fix"></div>

<div class="chart_border">
<div class="chart_wrapper">
<span class="chart_label">契約予算消化率</span>
<hr class="chart_label" />
<div id="yojitsu_done_contract"></div>
<div id="yojitsu_done_contract_counter"><input type="hidden" name="counter-value"/></div>
<div class="counter_unit">%</div>
<div style="clear: both;"></div>
</div>
</div>
<div style="clear: both;"></div>

<div id="tab_contract_timeline"></div>

<!--taogawa debug ここに担当者毎の絞り込み機能を入れたい-->
<div id="picker_contract_staff"></div>
<!--/taogawa debug-->

<div class="chart_border">
<div class="chart_wrapper">
<span class="chart_label">チャネル別集計</span>
<hr class="chart_label" />
<ul id="bxslider_contract_channel">
<li><div class="chart_unit" id="tab_contract_pie_channel"></div></li>
<li><div class="chart_unit chart_unit_table" id="tab_contract_table_channel"></div></li>
</ul>
</div>
</div>

<div class="chart_border">
<div class="chart_wrapper">
<span class="chart_label">時間帯別集計</span>
<hr class="chart_label" />
<ul id="bxslider_contract_timezone">
<li><div class="chart_unit" id="tab_contract_pie_timezone"></div></li>
<li><div class="chart_unit chart_unit_table" id="tab_contract_table_timezone"></div></li>
</ul>
</div>
</div>
<div style="clear: both;"></div>

<div class="chart_border">
<div class="chart_wrapper">
<span class="chart_label">担当者別集計</span>
<hr class="chart_label" />
<ul id="bxslider_contract_staff">
<li><div class="chart_unit" id="tab_contract_pie_staff"></div></li>
<li><div class="chart_unit chart_unit_table" id="tab_contract_table_staff"></div></li>
</ul>
</div>
</div>
<div style="clear: both;"></div>

</div>

<div id="tab_yosan">
<div class="width_fix"></div>
ここに指定日付の各種予実情報を記載する
</div>

</div><!--//tabs end-->
</div><!--//info_area-->
</div><!--//left_box-->



<div style="clear: both;"></div>


</div><!--wrapper-->
