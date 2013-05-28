<div id="conts">
<h2 class="style_h2_01">お問い合わせ</h2>
<h2 class="style_h2_03">お問い合わせ内容確認</h2>
<p class="style_p12">お問い合わせ内容に誤りが無いか確認の上、下部の「決定」ボタンを押してください。</p>
<div class="space_30"></div>
<table class="table_contact_confirm">
<tr>
<th class="th_left">項目名</th>
<th class="th_right">ご入力内容</th>
</tr>
<tr>
<td class="td_left">お名前</td>
<td class="td_right"><?php echo $name;?></td>
</tr>
<tr>
<td class="td_left">メールアドレス</td>
<td class="td_right"><?php echo $email;?></td>
</tr>
<tr>
<td class="td_left">お問い合わせ内容</td>
<td class="td_right"><?php echo $message;?></td>
</tr>
</table>

<form action="/contact/done.html" method="post">
<input type="hidden" name="name" value="<?php echo $name;?>">
<input type="hidden" name="email" value="<?php echo $email;?>">
<input type="hidden" name="message" value="<?php echo $message;?>">
<div class="btn01">
<input id="btn01_copy" type="submit" value="送信する"/>
</div>
</form>

<div class="space_30"></div>    
<p class="style_p05center">確認後「送信する」ボタンを押してください。</p>
<div class="space_10"></div>    
<p class="style_p05center">送信完了までに時間がかかる場合があります。<br />
連続してボタンを押すとエラーになることがありますので、ボタンは一度だけ押してください</p>
<div class="space_50"></div>
</div>
