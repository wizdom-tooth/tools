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
                case '予算入力':
                    tab_kind = 'tab-yosan';
                    break;
            }
            draw(tab_kind);
            //draw(String(String(ui.newTab.tab()).match(/tab-.*/)));
        },
    });
    draw('tab-intro');
    $('.chart_wrapper').corner("8px");
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
    /*
    var complete_data = new google.visualization.DataView(data);
    complete_data.setRows(complete_data.getViewRows());
    complete_data.hideRows(complete_data.getFilteredRows([{column:22, value:''}]));
    */

    intro_count    = data.getNumberOfRows();
    contract_count = contract_data.getNumberOfRows();
    //complete_count = complete_data.getNumberOfRows();

    // ---------------------
    // サマリ描画
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

    var options = {
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
    };

    var yojistu_done_intro = new google.visualization.BarChart(document.getElementById('yojistu_done_intro'));
    yojistu_done_intro.draw(summary_intro_ratio_init, options);
    setTimeout(function(){
        yojistu_done_intro.draw(summary_intro_ratio, options);
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
    }

    // データテーブル描画
    var table_option = {
        width: '100%',
    };
    var table = new google.visualization.Table(document.getElementById(tab_kind + '_table'));
    //table.draw(chart_target_data, table_option);

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
        width: '180',
        height: '300',
        tooltip: {text: 'value'},
        legend: {position: 'bottom'},
    };

    // 時間帯チャート
    var table_timezone = new google.visualization.Table(document.getElementById(tab_kind + '_table_timezone'));    table_timezone.draw(timezone_data, table_option);
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
	width: 900px;
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
	padding: 2px;
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
.chart_wrapper {
    float: left;
    width: 47%;
    margin: 3px 6px 3px 0px;
    padding: 7px;
    border:gray solid 1px;
}
.chart_unit {
    float: left;
}
.chart_unit_table {
    width: 50%;
}
div.chart_label {
    font-weight: bold;
    font-size: 20px;
    margin: 5px 0px 5px 0px;
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
<div id="tabs">
<ul>
<li><a href="#tabs-intro">紹介</a></li>
<li><a href="#tabs-contract">契約</a></li>
<li><a href="#tabs-yosan">予算入力</a></li>
</ul>

<div id="tabs-intro">
<div class="chart_wrapper">
<div class="chart_label">紹介予算消化率</div>
<hr class="chart_label" />
<div id="yojistu_done_intro"></div>
</div>
<div style="clear: both;"></div>

<div class="chart_wrapper">
<div class="chart_label">チャネル別集計</div>
<hr class="chart_label" />
<div class="chart_unit chart_unit_table" id="tab-intro_table_channel"></div>
<div class="chart_unit" id="tab-intro_pie_channel"></div>
<div style="clear: both;"></div>
</div>
<div class="chart_wrapper">
<div class="chart_label">時間帯別集計</div>
<hr class="chart_label" />
<div class="chart_unit chart_unit_table" id="tab-intro_table_timezone"></div>
<div class="chart_unit" id="tab-intro_pie_timezone"></div>
<div style="clear: both;"></div>
</div>
<div style="clear: both;"></div>
<div class="chart_wrapper">
<div class="chart_label">担当者別集計</div>
<hr class="chart_label" />
<div class="chart_unit chart_unit_table" id="tab-intro_table_staff"></div>
<div class="chart_unit" id="tab-intro_pie_staff"></div>
<div style="clear: both;"></div>
</div>


<div style="clear: both;"></div>
<div class="chart_label">データテーブル</div>
<hr class="chart_label" />
<div class="float_left" id="tab-intro_table"></div>
</div>
<div id="tabs-contract">
ここに指定日付の各種予実情報を記載する
</div>
<div id="tabs-yosan">
ここに指定日付の各種予実情報を記載する
</div>

</div><!--//tabs end-->
</div><!--//info_area-->
</div><!--//left_box-->


<div id="right_box">
<div id="summary_area">
ここに当該月度情報のサマリを記載する
</div>
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
<span class="today"><?php echo $today;?></span>
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
</div>


<div style="clear: both;"></div>

</div><!--wrapper-->
