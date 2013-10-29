<script type='text/javascript'>
</script>

<!--target date-->
<h2>予算入力ツール - <?php echo $year;?> / <?php echo $month;?></h2>

<!--calendar area-->
<div class="box_solid" id="calendar_input_yosan">
<?php echo $calendar;?>
</div>

<!--right area-->
<div class="box_solid" id="right">
<div class="space_20"></div>
<form name="input_yosan" id="input_yosan" method="post" action="/yosan/index.html">
<?php $selected = ($this->input->post('year')) ? $this->input->post('year') : ''; ?>
<?php echo form_dropdown('year', $form_year, $selected); ?>年
<?php $selected = ($this->input->post('month')) ? $this->input->post('month') : ''; ?>
<?php echo form_dropdown('month', $form_month, $selected); ?>月<br />
<div class="space_10"></div>
<?php $selected = ($this->input->post('channel')) ? $this->input->post('channel') : ''; ?>
<?php echo form_dropdown('channel', $form_channel, $selected); ?><br />
<div class="space_10"></div>
<input type="submit" />
</form>
</div>

<div class="clear"></div>
