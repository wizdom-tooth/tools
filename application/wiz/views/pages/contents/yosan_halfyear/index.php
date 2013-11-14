<script type="text/javascript">
<!--
$(function() {
	for (i = 0; i <= 7; i++){
		$('#title' + i).bind('click', {x:i}, function(e) {
			$('#block' + e.data.x).animate({width:'toggle'}, 'slow');
			$this
		});
	}
	for (i = 0; i <= 1; i++){
		$('#box_title' + i).bind('click', {x:i}, function(e) {
			$('#box_block' + e.data.x).animate({height:'toggle'}, 'slow');
		});
	}
});
// -->
</script>

<style type="text/css">
<!--
#sum {
	background-color: silver;
	height: 60px;
	width: 860px;
	text-align: center;
}
#box_title0, #box_title1 {
	background-color: red;
	height: 15px;
	width: 860px;
	text-align: center;
}
#box_block0, #box_block1 {
	border:black solid 1px;
	width: 860px;
}
#title0, #title1, #title2, #title3, #title4, #title5, #title6, #title7 {
	float: left;
	background-color: green;
	height: 300px;
	width: 15px;
	text-align: center;
}
#block0, #block1, #block2, #block3, #block4, #block5, #block6, #block7 {
	float: left;
	background-color: silver;
	height: 300px;
	width: 200px;
}
-->
</style>


<div class="space_5"></div>
<div id="sum">aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</div>
<div class="space_5"></div>


<?php $box_counter = 0;?>
<?php foreach($target_monthes as $quarter_name => $q_target_monthes):?>
<div id="box_title<?php echo $box_counter;?>"><?php echo $quarter_name;?></div>
<div id="box_block<?php echo $box_counter;?>">
<?php foreach($q_target_monthes as $i => $target_month):?>
<div id="title<?php echo $i + ($box_counter * 3);?>"><?php echo $target_month;?></div>
<div id="block<?php echo $i + ($box_counter * 3);?>">hogehogehoge</div>
<?php endforeach;?>
</div>
<div style="clear: both;"></div>
<div class="space_5"></div>
<?php $box_counter++;?>
<?php endforeach;?>

