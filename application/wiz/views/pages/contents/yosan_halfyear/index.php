<script type="text/javascript">
<!--
$(function() {
	for (i = 0; i <= 8; i++){
		$('#title' + i).bind('click', {x:i}, function(e) {
			$('#block' + e.data.x).animate({width:'toggle'}, 'slow');
		});
	}
});
// -->
</script>

<style type="text/css">
<!--
#sum {
	background-color: silver;
	height: 150px;
	width: 880px;
	text-align: center;
}
#title1, #title2, #title3, #title4, #title5, #title6, #title7, #title8 {
	float: left;
	background-color: green;
	height: 500px;
	width: 20px;
	text-align: center;
}
#block1, #block2, #block3, #block4, #block5, #block6, #block7, #block8 {
	float: left;
	background-color: silver;
	height: 500px;
	width: 200px;
}
-->
</style>

<div class="space_20"></div>
<div id="sum">aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</div>
<div class="space_20"></div>

<div id="title1"></div>
<div id="block1"></div>
<div id="title2"></div>
<div id="block2"></div>
<div id="title3"></div>
<div id="block3"></div>
<div id="title4"></div>
<div id="block4"></div>
<div style="clear: both;"></div>
<div class="space_20"></div>

<div id="title5"></div>
<div id="block5"></div>
<div id="title6"></div>
<div id="block6"></div>
<div id="title7"></div>
<div id="block7"></div>
<div id="title8"></div>
<div id="block8"></div>
<div style="clear: both;"></div>
<div class="space_20"></div>
