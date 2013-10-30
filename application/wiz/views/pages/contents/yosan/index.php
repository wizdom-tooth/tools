<script type='text/javascript'>
</script>

<!--target date-->
<h2>予算入力ツール - <?php echo $year;?> / <?php echo $month;?></h2>

<!--calendar area-->
<form action="/yosan/index.html" method="post">
<div class="box_solid" id="calendar_input_yosan">
<?php echo $calendar;?>
<input type="hidden" name="action" value="input"/>
<input type="submit" />
</div>
</form>

<!--right area-->
<div class="box_solid" id="right">
<div class="space_20"></div>
<form name="input_yosan" id="input_yosan" method="get" action="/yosan/index.html">
<?php $selected = ($this->input->get('year')) ? $this->input->get('year') : ''; ?>
<?php echo form_dropdown('year', $form_year, $selected); ?>年
<?php $selected = ($this->input->get('month')) ? $this->input->get('month') : ''; ?>
<?php echo form_dropdown('month', $form_month, $selected); ?>月<br />
<div class="space_10"></div>
<?php $selected = ($this->input->get('channel')) ? $this->input->get('channel') : ''; ?>
<?php echo form_dropdown('channel', $form_channel, $selected); ?><br />
<div class="space_10"></div>
<input type="submit" />
</form>
<hr />
<a href="javascript:(function(){$('#calendar_input_yosan :text').val(0);})();">全部0埋め</a>
</div>

<div class="clear"></div>
