<script type="text/javascript">
<!--
/* {{{ */
jQuery.expr[':'].regex = function(elem, index, match) {
    var matchParams = match[3].split(','),
        validLabels = /^(data|css):/,
        attr = {
            method: matchParams[0].match(validLabels) ? 
                        matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels,'')
        },
        regexFlags = 'ig',
        regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
    return regex.test(jQuery(elem)[attr.method](attr.property));
}
/* }}} */

function sum_introduction()
{
	/**
	 * ブロック毎に処理
	 */
	$('div:regex(id, ^block[0-8]$)').each(function(i)
	{
		var box_id = $(this).attr('id').substr(-1);

		// 紹介予算の合計算出
		var sum_introduction_id = 'sum_introduction_count_' + box_id;
		var sum_introduction_count = 0;
		$(this).find('tr[class="unit_introduction_count_' + box_id + '"]').each(function(j) {
			sum_introduction_count += parseInt($(this).find('.sum_target').val());
		});
		$('#' + sum_introduction_id).text(sum_introduction_count);
		/*
		$('#' + sum_introduction_id).css('background-color', 'red'); // FOR DEBUG
		*/

		// ----------------------------
		// フレッツ契約件数 * 各種比率 = 各種件数
		// ----------------------------

		var flets_contract_ratio = parseInt($('[name="flets_contract_ratio_契約率_' + box_id + '"]').val()) / 100;
		var flets_complete_ratio = parseInt($('[name="flets_contract_ratio_開通率_' + box_id + '"]').val()) / 100;

		// フレッツ契約数＆開通数
		var flets_contract_count = Math.round(sum_introduction_count * flets_contract_ratio);
		var flets_complete_count = Math.round(flets_contract_count * flets_complete_ratio);
		var flets_contract_count_id = 'flets_contract_ratio_契約率_' + box_id + '_cooked';
		$('#' + flets_contract_count_id).text(flets_contract_count);
		var flets_complete_count_id = 'flets_contract_ratio_開通率_' + box_id + '_cooked';
		$('#' + flets_complete_count_id).text(flets_complete_count);

		// ISPセット数
		$(this).find('tr[class="unit_flets_isp_set_ratio_' + box_id + '"]').each(function(j) {
			var input = $(this).find('input');
			var flets_isp_set_count_id = input.attr('name') + '_cooked';
			var flets_isp_set_count    = Math.round(flets_contract_count * parseInt(input.val()) / 100);
			$('#' + flets_isp_set_count_id).text(flets_isp_set_count);
		});

		// オプションセット数
		$(this).find('tr[class="unit_flets_option_set_ratio_' + box_id + '"]').each(function(j) {
			var input = $(this).find('input');
			var flets_option_set_count_id = input.attr('name') + '_cooked';
			var flets_option_set_count    = Math.round(flets_contract_count * parseInt(input.val()) / 100);
			$('#' + flets_option_set_count_id).text(flets_option_set_count);
		});

		// ----------------------------
		// フレッツ移転セット数
		// ----------------------------

		var sum_iten_contract_count_id = 'sum_iten_contract_count_' + box_id;
		var sum_iten_contract_count = 0;
		$(this).find('tr[class="unit_iten_contract_count_' + box_id + '"]').each(function(j) {
			sum_iten_contract_count += parseInt($(this).find('.sum_target').val());
		});
		$('#' + sum_iten_contract_count_id).text(sum_iten_contract_count);

		$(this).find('tr[class="unit_iten_isp_set_ratio_' + box_id + '"]').each(function(j) {
			var input = $(this).find('input');
			var iten_isp_set_count_id = input.attr('name') + '_cooked';
			var iten_isp_set_count    = Math.round(sum_iten_contract_count * parseInt(input.val()) / 100);
			$('#' + iten_isp_set_count_id).text(iten_isp_set_count);
		});

		// ----------------------------
		// 契約数(その他回線) = 照会予算件数 * その他回線契約比率
		// ----------------------------

		$(this).find('tr[class="unit_other_contract_ratio_' + box_id + '"]').each(function(j) {
			var input = $(this).find('input');
			var other_contract_count_id = input.attr('name') + '_cooked';
			var other_contract_count    = Math.round(sum_introduction_count * parseInt(input.val()) / 100);
			$('#' + other_contract_count_id).text(other_contract_count);
		});

		// ----------------------------
		// 開通数(その他回線) = 契約数(その他回線) * その他回線開通比率
		// ----------------------------

		$(this).find('tr[class="unit_other_complete_ratio_' + box_id + '"]').each(function(j) {
			var input = $(this).find('input');
			var other_complete_count_id = input.attr('name') + '_cooked';
			var other_contract_count    = parseInt($('#' + other_complete_count_id.replace('contract', 'complete')).text());
			var other_complete_count    = Math.round(other_contract_count * parseInt(input.val()) / 100);
			$('#' + other_complete_count_id).text(other_complete_count);
		});

		// ----------------------------
		// ISPのみ
		// ----------------------------

		var onlyisp_contract_ratio = parseInt($('[name="onlyisp_contract_ratio_契約率_' + box_id + '"]').val()) / 100;
		var onlyisp_complete_ratio = parseInt($('[name="onlyisp_contract_ratio_開通率_' + box_id + '"]').val()) / 100;

		// 契約数＆開通数
		var onlyisp_contract_count = Math.round(sum_introduction_count * onlyisp_contract_ratio);
		var onlyisp_complete_count = Math.round(onlyisp_contract_count * onlyisp_complete_ratio);
		var onlyisp_contract_count_id = 'onlyisp_contract_ratio_契約率_' + box_id + '_cooked';
		$('#' + onlyisp_contract_count_id).text(onlyisp_contract_count);
		var onlyisp_complete_count_id = 'onlyisp_contract_ratio_開通率_' + box_id + '_cooked';
		$('#' + onlyisp_complete_count_id).text(onlyisp_complete_count);

		// ----------------------------
		// 特典施策
		// ----------------------------

		var benefit_contract_ratio = parseInt($('[name="benefit_contract_ratio_契約率_' + box_id + '"]').val()) / 100;
		var benefit_complete_ratio = parseInt($('[name="benefit_contract_ratio_開通率_' + box_id + '"]').val()) / 100;

		// 契約数＆開通数
		var benefit_contract_count = Math.round(sum_introduction_count * benefit_contract_ratio);
		var benefit_complete_count = Math.round(benefit_contract_count * benefit_complete_ratio);
		var benefit_contract_count_id = 'benefit_contract_ratio_契約率_' + box_id + '_cooked';
		$('#' + benefit_contract_count_id).text(benefit_contract_count);
		var benefit_complete_count_id = 'benefit_contract_ratio_開通率_' + box_id + '_cooked';
		$('#' + benefit_complete_count_id).text(benefit_complete_count);
	});
}

$(function() {
	$('.sum_area').each(function(i) {
		$(this).attr('disabled', 'disabled');
	});
	for (i = 0; i <= 7; i++){
		$('#title' + i).bind('click', {x:i}, function(e) {
			$('#block' + e.data.x).animate({width:'toggle'}, 'slow');
		});
	}
	for (i = 0; i <= 1; i++){
		$('#title' + i + '_sum').bind('click', {x:i}, function(e) {
			$('#block' + e.data.x + '_sum').animate({width:'toggle'}, 'slow');
		});
	}
	for (i = 0; i <= 1; i++){
		$('#box_title' + i).bind('click', {x:i}, function(e) {
			$('#box_block' + e.data.x).animate({height:'toggle'}, {duration:'slow', easing:'swing'});
		});
	}
	sum_introduction();
	$('input').change(function (){
		sum_introduction();
	});
});

// -->
</script>

<style type="text/css">
<!--
#wrapper{
	background-color: #ffffcc;
}
#sum {
	background-color: silver;
	height: 60px;
	width: auto; 
	text-align: center;
}
/*タイトル*/
#box_title0, #box_title1
{
	background-color: #FFBE00;
	height: auto;
	width: 100%;
	text-align: center;
	font-weight: 900;
	font-size: 20px;
}

#title0, #title1, #title2,
#title3, #title4, #title5
{
	background-image: -moz-linear-gradient(bottom, #FFFFFF 0%, #A65E00 100%);
}

#title0_sum, #title1_sum
{
	background-image: -moz-linear-gradient(bottom, #FFFFFF 0%, #FF5F00 100%);
}

#title0, #title1, #title2,
#title3, #title4, #title5,
#title0_sum, #title1_sum
{
	float: left;
	height: 1000px;
	width: 15px;
	color: #FFFFFF;
	text-align: center;
	margin: 1px;
}
#title0:hover, #title1:hover, #title2:hover,
#title3:hover, #title4:hover, #title5:hover,
#title0_sum:hover, #title1_sum:hover,
#box_title0:hover, #box_title1:hover
{
	background-image: -moz-linear-gradient(bottom, #FFFFFF 0%, #38E156 100%);
	color: #000000;
}

/*ブロック*/
#block0, #block1, #block2,
#block3, #block4, #block5,
#block0_sum, #block1_sum
{
	float: left;
	background-color: #ffffcc;
	width: 23%;
}

/*テーブル*/
table.yosan_halfyear {
	width: 100%;
}
table.yosan_halfyear td {
	font-size: 10px;
	width: 33.3%;
}
table.yosan_halfyear input[type="text"] {
	-webkit-box-shadow: 0px 1px rgba(255, 255, 255, 0.5);
	-moz-box-shadow: 0px 1px rgba(255, 255, 255, 0.5);
	box-shadow: 0px 1px rgba(255, 255, 255, 0.5);
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	width: 35px;
}
table.yosan_halfyear input[class="sum_target"]:focus,
table.yosan_halfyear input[class=""]:focus
{
    border:solid 2px #FF4500;
}
.label_row {
	background-color: gray;
	color: #FFFFFF;
}
-->
</style>


<div class="space_5"></div>
<!--
<div class="space_5"></div>
<div id="sum">hoge</div>
<div class="space_5"></div>
-->

<div id="wrapper">
<form action="" method="post">


<?php $box_counter = 0;?>
<?php foreach($yosan_month_infos as $quarter_name => $q):?>
<div id="box_title<?php echo $box_counter;?>"><?php echo $quarter_name;?></div>
<div id="box_block<?php echo $box_counter;?>">


<!--クオータエリア-->
<?php foreach($q as $i => $yosan_month_info):?>
<?php $view_id = $i + ($box_counter * 3);?>
<div id="title<?php echo $view_id;?>"><?php echo (int)substr($yosan_month_info['wiz_month_id'], 4, 2);?>月</div>
<div id="block<?php echo $view_id;?>">
<?php echo get_html_yosan_halfyear_table($yosan_month_info, $view_id);?>
</div>
<?php endforeach;?>

<!--クオータ合計エリア-->
<?php $sum_id = $box_counter.'_sum';?>
<div id="title<?php echo $sum_id;?>">合計</div>
<div id="block<?php echo $sum_id;?>">
<?php echo get_html_yosan_halfyear_table($yosan_month_info_for_sum, $sum_id);?>
</div>

<div style="clear: both;"></div>
</div>
<div class="space_5"></div>
<?php $box_counter++;?>
<?php endforeach;?>


</form>
</div>
