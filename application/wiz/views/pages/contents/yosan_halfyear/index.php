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

function sum_introduction() {
	var sum = {};
	$('div:regex(id, ^block[0-8]$) tr[class^="unit_flets_introduction_count_"]').each(function(i){
		var sum_id = $(this).attr('class').replace('unit', 'sum');
		$(this).find('.sum_target').each(function(j){
			if ( ! (sum_id in sum)) {
				sum[sum_id] = 0;
			}
			val = parseInt($(this).val());
			if ( ! isNaN(val)) {
				sum[sum_id] += val;
			} else {
				val = parseInt($(this).text());
				if ( ! isNaN(val)) {
					sum[sum_id] += val;
				}
			}
		});
	});
	for (var key in sum) {
		$('#' + key).text(sum[key]);
		$('#' + key).css('background-color', 'red'); // DEBUG
	}
}

$(function() {
	for (i = 0; i <= 7; i++){
		$('#title' + i).bind('click', {x:i}, function(e) {
			$('#block' + e.data.x).animate({width:'toggle'}, 'slow');
		});
	}
	for (i = 0; i <= 1; i++){
		$('#title_sum' + i).bind('click', {x:i}, function(e) {
			$('#block_sum' + e.data.x).animate({width:'toggle'}, 'slow');
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
#box_title0,
#box_title1
{
	background-color: #FFBE00;
	height: auto;
	width: 100%;
	text-align: center;
	font-weight: 900;
	font-size: 20px;
}
#title0,
#title1,
#title2,
#title3,
#title4,
#title5,
#title6,
#title7
{
	background-image: -moz-linear-gradient(bottom, #FFFFFF 0%, #A65E00 100%);
}
#title_sum0,
#title_sum1
{
	background-image: -moz-linear-gradient(bottom, #FFFFFF 0%, #FF5F00 100%);
}
#title0,
#title1,
#title2,
#title3,
#title4,
#title5,
#title6,
#title7,
#title_sum0,
#title_sum1
{
	float: left;
	height: 1000px;
	width: 15px;
	color: #FFFFFF;
	text-align: center;
	margin: 1px;
}
#title0:hover,
#title1:hover,
#title2:hover,
#title3:hover,
#title4:hover,
#title5:hover,
#title6:hover,
#title7:hover,
#title_sum0:hover,
#title_sum1:hover,
#box_title0:hover,
#box_title1:hover
{
	background-image: -moz-linear-gradient(bottom, #FFFFFF 0%, #38E156 100%);
	color: #000000;
}

/*ブロック*/
#block0,
#block1,
#block2,
#block3,
#block4,
#block5,
#block6,
#block7,
#block_sum0,
#block_sum1
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
table.yosan_halfyear input[type="text"]:focus {
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
<?php $sum_id = 'sum'.$box_counter;?>
<div id="title_<?php echo $sum_id;?>">合計</div>
<div id="block_<?php echo $sum_id;?>">
<?php echo get_html_yosan_halfyear_table($yosan_month_info_for_sum, $sum_id);?>
</div>

<div style="clear: both;"></div>
</div>
<div class="space_5"></div>
<?php $box_counter++;?>
<?php endforeach;?>


</form>
</div>
