<div id="conts">
<h2 class="style_h2_02">申請状況確認</h2>
<div class="space_30"></div>
<p class="style_p09_arrow">お客様の申請IDを入力して「申請状況確認」をクリックして下さい。</p>
<p class="style_p09_arrow">申請IDは、お申込み完了時に弊社から送信するメールに記載しております。</p>
<p class="style_p09_arrow"><span class="style_p01red">当ページでは、弊社にて申請されたお客様の情報のみ検索可能となります。</span></p>
<div class="space_30"></div>


<div id="status_input_box_wrapper">
	<div id="status_input_box">
		<div id="status_input_content">
            <form method="get" action="/status/index.html">
			<span>申請ID</span>
			<input name="app_id" type="text" class="status_input_input" value="<?php echo set_value('app_id');?>" />
			<input type="submit" value="" id="status_input_submit" />
			</form>
		</div>
	</div>
</div>


<?php if ($page_type !== 'init'):?>
<div class="status_output">
<p class="style_p13">
<?php if ($page_type === 'hit'):?>
<?php echo $status_desc;?>
<?php elseif($page_type === 'invalid'):?>
<?php echo form_error('app_id');?>
<?php elseif($page_type === 'not_found'):?>
入力されたお申込みIDの情報が見つかりませんでした。
<?php endif;?>
</p>
</div>
<?php endif;?>


<?php if ($page_type === 'hit'):?>
<table class="table_status_output">
<tr>
<th>項目名</th>
<th>内容</th>
</tr>
<?php foreach ($app_values as $key => $value):?>
<tr>
<td class="td_left"><?php echo $key;?></td>
<td class="td_right"><?php echo $value;?></td>
</tr>
<?php endforeach;?>
</table>    
<?php endif;?>


</div>
