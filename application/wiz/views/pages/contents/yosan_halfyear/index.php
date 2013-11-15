<script type="text/javascript">
<!--
$(function() {
	for (i = 0; i <= 7; i++){
		$('#title' + i).bind('click', {x:i}, function(e) {
			$('#block' + e.data.x).animate({width:'toggle'}, 'fast');
			$this
		});
	}
	for (i = 0; i <= 1; i++){
		$('#box_title' + i).bind('click', {x:i}, function(e) {
			$('#box_block' + e.data.x).animate({height:'toggle'}, 'fast');
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
	width: 1060px;
	text-align: center;
}
#box_block0, #box_block1 {
}
#title0, #title1, #title2, #title3, #title4, #title5, #title6, #title7 {
	float: left;
	background-color: green;
	height: 700px;
	width: 15px;
	text-align: center;
}
#block0, #block1, #block2, #block3, #block4, #block5, #block6, #block7 {
	overflow: hidden;
	float: left;
	background-color: silver;
	height: 700px;
	width: 250px;
}
-->
</style>


<div class="space_5"></div>
<!--
<div class="space_5"></div>
<div id="sum">aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</div>
<div class="space_5"></div>
-->


<form action="" method="post">

<?php $box_counter = 0;?>
<?php foreach($yosan_month_infos as $quarter_name => $q):?>
<div id="box_title<?php echo $box_counter;?>"><?php echo $quarter_name;?></div>
<div id="box_block<?php echo $box_counter;?>">
<?php foreach($q as $i => $yosan_month_info):?>
<?php $view_id = $i + ($box_counter * 3);?>
<div id="title<?php echo $view_id;?>"></div>
<div id="block<?php echo $view_id;?>">


<?php //var_dump($yosan_month_info);?>


<h2 class="blue">照会予算</h2>
<table>
<?php foreach(unserialize($yosan_month_info['introduction_count_complex']) as $name => $count):?>
<tr>
<td><?php echo $name;?></td>
<td><input type="text" name="<?php echo $name.'_'.$view_id;?>" value="<?php echo $count;?>" size="5"/></td>
</tr>
<?php endforeach;?>
</table>


<h2 class="blue">フレッツ契約率＆開通率</h2>
<table>
<tr><td>契約率</td><td><?php echo $yosan_month_info['flets_contract_ratio'];?></td></tr>
<tr><td>開通率</td><td><?php echo $yosan_month_info['flets_complete_ratio'];?></td></tr>
</table>


<h2 class="blue">ISPセット率</h2>
<table>
<?php foreach(unserialize($yosan_month_info['flets_isp_set_ratio_complex']) as $name => $count):?>
<tr>
<td><?php echo $name;?></td>
<td><input type="text" name="<?php echo $name.'_'.$view_id;?>" value="<?php echo $count;?>" size="5"/></td>
</tr>
<?php endforeach;?>
</table>


<h2 class="blue">オプションセット率</h2>
<table>
<?php foreach(unserialize($yosan_month_info['flets_option_set_ratio_complex']) as $name => $count):?>
<tr>
<td><?php echo $name;?></td>
<td><input type="text" name="<?php echo $name.'_'.$view_id;?>" value="<?php echo $count;?>" size="5"/></td>
</tr>
<?php endforeach;?>
</table>


</div>
<?php endforeach;?>
<div style="clear: both;"></div>
</div>
<div class="space_5"></div>
<?php $box_counter++;?>
<?php endforeach;?>

</form>
