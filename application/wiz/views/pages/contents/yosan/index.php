<script type='text/javascript'>
</script>

<!--target date-->
<h2>予算入力ツール - <?php echo $year;?> / <?php echo $month;?></h2>

<!--calendar area-->
<form action="/yosan/index.html" method="post">
<div class="box_solid" id="calendar_input_yosan">
<?php echo $calendar;?>
<input type="hidden" name="channel" value="<?php echo $channel;?>"/>
<input type="hidden" name="year" value="<?php echo $year;?>"/>
<input type="hidden" name="month" value="<?php echo $month;?>"/>
<input type="hidden" name="action" value="input"/>
<input type="submit" />
</div>
</form>

<!--right area-->
<div class="box_solid" id="right">
<div class="space_20"></div>
<form name="input_yosan" id="input_yosan" method="get" action="/yosan/index.html">
<?php echo form_dropdown('year', $form_year, $year); ?>年
<?php echo form_dropdown('month', $form_month, $month); ?>月
<div class="space_10"></div>
<?php echo form_dropdown('channel', $form_channel, $channel); ?>
<div class="space_10"></div>
<input type="submit" />
</form>
<hr />
<a href="javascript:(function(){$('#calendar_input_yosan :text').val(0);})();">全部0埋め</a>
</div>

<div class="clear"></div>
