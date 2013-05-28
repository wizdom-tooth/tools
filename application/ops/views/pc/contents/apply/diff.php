<div id="conts">
<h2 id="apply">ESTAお申込み</h2>

<div class="change_textbox">
<p class="style_p09_arrow">同一氏名・パスポート情報にて申請済みの情報が見つかりました。</p>
<div class="change_textbox_line">
<table>
<tr>
<td class="td_left">氏名</td>
<td class="td_center">：</td>
<td class="td_right"><?php echo $lastname . ' ' . $firstname;?></td>
</tr>
</table>
</div>
<div class="change_textbox_line">
<table>
<tr>
<td class="td_left">パスポート番号</td>
<td class="td_center">：</td>
<td class="td_right"><?php echo $passport_number; ?></td>
</tr>
</table>
</div>
</div>

<table class="table_change">
<tr>
<th>項目名</th>
<th>新しい入力情報</th>
<th>過去の入力情報</th>
</tr>
<?php foreach ($this->config->item('checked_elements') as $checked_elemet_name => $checked_elemet):?>
<tr>
<td class="td_left"><?php echo $checked_elemet_name;?></td>
<?php if (isset($diff[$checked_elemet]) === TRUE && $diff[$checked_elemet] === TRUE):?>
<td class="td_center"><p class="style_p01red"><?php echo ${$checked_elemet};?></p></td>
<?php else:?>
<td class="td_center"><?php echo ${$checked_elemet};?></td>
<?php endif;?>
<?php if (isset($diff[$checked_elemet]) === TRUE && $diff[$checked_elemet] === TRUE):?>
<td class="td_right"><p class="style_p01disable"><?php echo $past[$checked_elemet];?></p></td>
<?php else:?>
<td class="td_right">変更なし</td>
<?php endif;?>
</tr>
<?php endforeach;?>
</table>

<form action="/apply/step3.html" method="post">
<input type="hidden" name="issue_id" value="<?php echo $past['issue_id'];?>" />
<input type="hidden" name="diff" value="TRUE" />
<?php foreach($diff as $key => $val):?>
<input type="hidden" name="<?php echo $key;?>" value="<?php echo ${$key};?>" />
<?php endforeach;?>
<div class="btn01">
<input id="btn01_copy" type="submit" value="修正情報を送信"/>
</div>
</form>

</div>
