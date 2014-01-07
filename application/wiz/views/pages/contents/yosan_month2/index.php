<script type="text/javascript">
/* {{{ js general */
google.load('visualization', '1', {packages:['table', 'corechart', 'gauge']});
google.setOnLoadCallback(init);

var bar_option = {
	animation:{
		duration: 1000,
		easing: 'out',
	},
	legend: { position: "none" },
	hAxis:{
		//viewWindowMode: 'explicit',
		//viewWindowMode: 'maximized',
		viewWindow:{ min: 0, max: 100, },
		gridlines:{ count: 2, },
		//maxValue: 150,
		baseline: 0,
	},
	chartArea: {
		width: '85%',
	}
};

var table_option = {
	width: '450',
};

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
	/*
	$('#tabs').tabs();
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
	$('#summary_area').corner();
    $('#right_box').containedStickyScroll({
        duration: 150,
        closeChar: ''
    });
	*/
}
/* }}} */

/* {{{ js intro */
function draw_tab_intro(){

    var chart_target_data = google.visualization.arrayToDataTable(raw_data);
    intro_count = chart_target_data.getNumberOfRows();

    // ---------------------
    // 達成率チャート描画
    // ---------------------

    var ratio = Math.round((intro_count / <?php echo $yosan_intro_count;?>) * 100);
    var summary_intro_ratio_init = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['', 0]
    ]);
    var summary_intro_ratio = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['', ratio]
    ]);

	$("#yojitsu_done_intro_counter").flipCounter({imagePath: "/assets/wiz/img/flipCounter-medium.png"});
    var yojitsu_done_intro = new google.visualization.BarChart(document.getElementById('yojitsu_done_intro'));
    yojitsu_done_intro.draw(summary_intro_ratio_init, bar_option);
    setTimeout(function(){yojitsu_done_intro.draw(summary_intro_ratio, bar_option);}, 600);
    setTimeout(function(){$("#yojitsu_done_intro_counter").flipCounter(
		"startAnimation",
		{
			number: 0,
			end_number: ratio,
			easing: jQuery.easing.easeOutCubic,
			duration: 1000,
		}
	);}, 600);

    // ---------------------
    // データ加工
    // ---------------------

    // チャネル別集計
    var channel_data = google.visualization.data.group(chart_target_data, [5], [{
        'column': 0,
        'label': 'count',
        'aggregation': google.visualization.data.count,
        'type': 'number'
    }]);
    channel_data.sort({column:1, desc:true});

    // 時間帯別集計
    var timezone_data = google.visualization.data.group(chart_target_data, [2], [{
        'column': 0,
        'label': 'count',
        'aggregation': google.visualization.data.count,
        'type': 'number'
    }]);
    timezone_data.sort({column:1, desc:true});

    // ---------------------
    // チャート描画
    // ---------------------

    var pie_option = {
        title: '合計件数：' + intro_count,
        pieHole: 0.4,
        //is3D: true,
        chartArea: {
            //left: 30,
            //top: 30,
            width: '90%',
            height: '90%'
        },
        width: '600',
        height: '400',
        //tooltip: {text: 'value'},
        //legend: {position: 'bottom'},
    };

    // チャネル別チャート
    var pie_channel = new google.visualization.PieChart(document.getElementById('tab_intro_pie_channel'));
	var table_channel = new google.visualization.Table(document.getElementById('tab_intro_table_channel'));
    pie_channel.draw(channel_data, pie_option);
	table_channel.draw(channel_data, table_option);
	$('#bxslider_intro_channel').bxSlider();

    // 時間帯チャート
    var pie_timezone = new google.visualization.PieChart(document.getElementById('tab_intro_pie_timezone'));
    var table_timezone = new google.visualization.Table(document.getElementById('tab_intro_table_timezone'));
    pie_timezone.draw(timezone_data, pie_option);
    table_timezone.draw(timezone_data, table_option);
	$('#bxslider_intro_timezone').bxSlider();
}
/* }}} */

/* {{{ js contract */
function draw_tab_contract() {

    // ---------------------
    // 基本データ定義
    // ---------------------

    // 契約データ 契約日が空のモノを無視する
    var data = google.visualization.arrayToDataTable(raw_data);
    var contract_data = new google.visualization.DataView(data);
    contract_data.setRows(contract_data.getViewRows());
    contract_data.hideRows(contract_data.getFilteredRows([{column:18, value:''}]));
    var contract_count = contract_data.getNumberOfRows();
	var chart_target_data = contract_data;

    // ---------------------
    // 達成率チャート描画
    // ---------------------

	<?php $yosan_contract_count_sum = array_sum($yosan_contract_count);?>
    var ratio = Math.round((contract_count / <?php echo $yosan_contract_count_sum;?>) * 100);
    var summary_contract_ratio_init = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['', 0]
    ]);
    var summary_contract_ratio = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['', ratio]
    ]);

	$("#yojitsu_done_contract_counter").flipCounter({imagePath: "/assets/wiz/img/flipCounter-medium.png"});
    var yojitsu_done_contract = new google.visualization.BarChart(document.getElementById('yojitsu_done_contract'));
    yojitsu_done_contract.draw(summary_contract_ratio_init, bar_option);
    setTimeout(function(){yojitsu_done_contract.draw(summary_contract_ratio, bar_option);}, 600);
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
	// EEEEEEEEEEEEEEEE
    // ---------------------

	var timeline_data_init = google.visualization.arrayToDataTable([
	['x', '契約予算', '契約実績'],
	<?php
	foreach ($week_days_info as $week_info)
	{
		foreach ($week_info as $day_info)
		{
			echo "['{$day_info['date']}', 0, 0],\n";
		}
	}
	?>
	]);


	var timeline_data = google.visualization.arrayToDataTable([
	['x', '契約予算', '契約実績'],
	<?php
	foreach ($week_days_info as $week_info)
	{
		foreach ($week_info as $day_info)
		{
			echo "['{$day_info['date']}', {$day_info['yosan_addup']}, {$day_info['result_addup']}],\n";
		}
	}
	?>
	]);

	var options = {
        animation:{
            duration: 1000,
            easing: 'out',
        },
		curveType: "function",
		height: 570,
		chartArea: {
			width: '90%',
			height: '75%',
		},
		legend: {position: 'top', textStyle: {fontSize: 16}},
	}
	var contract_timeline = new google.visualization.LineChart(document.getElementById('tab_contract_timeline'));
	contract_timeline.draw(timeline_data_init, options);
	setTimeout(function(){contract_timeline.draw(timeline_data, options);}, 600);

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
            height: '90%'
        },
        width: '240',
        height: '300',
        tooltip: {text: 'value'},
        legend: {position: 'bottom'},
    };

    // 時間帯チャート
    var table_timezone = new google.visualization.Table(document.getElementById('tab_contract_table_timezone'));
    table_timezone.draw(timezone_data, table_option);
    var pie_timezone = new google.visualization.PieChart(document.getElementById('tab_contract_pie_timezone'));
    pie_timezone.draw(timezone_data, pie_option);

    // チャネルチャート
    var table_channel = new google.visualization.Table(document.getElementById('tab_contract_table_channel'));
    table_channel.draw(channel_data, table_option);
    var pie_channel = new google.visualization.PieChart(document.getElementById('tab_contract_pie_channel'));
    pie_channel.draw(channel_data, pie_option);

    // 担当者チャート
    var table_staff = new google.visualization.Table(document.getElementById('tab_contract_table_staff'));
    table_staff.draw(staff_data, table_option);
    var pie_staff = new google.visualization.PieChart(document.getElementById('tab_contract_pie_staff'));
    pie_staff.draw(staff_data, pie_option);
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
</div>

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

<div class="chart_border">
<div class="chart_wrapper">
<span class="chart_label">チャネル別集計</span>
<hr class="chart_label" />
<div class="chart_unit chart_unit_table" id="tab_contract_table_channel"></div>
<div class="chart_unit" id="tab_contract_pie_channel"></div>
<div style="clear: both;"></div>
</div>
</div>

<div class="chart_border">
<div class="chart_wrapper">
<span class="chart_label">時間帯別集計</span>
<hr class="chart_label" />
<div class="chart_unit chart_unit_table" id="tab_contract_table_timezone"></div>
<div class="chart_unit" id="tab_contract_pie_timezone"></div>
<div style="clear: both;"></div>
</div>
</div>
<div style="clear: both;"></div>

<div class="chart_border">
<div class="chart_wrapper">
<span class="chart_label">担当者別集計</span>
<hr class="chart_label" />
<div class="chart_unit chart_unit_table" id="tab_contract_table_staff"></div>
<div class="chart_unit" id="tab_contract_pie_staff"></div>
<div style="clear: both;"></div>
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
