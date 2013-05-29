<h2>データ整形</h2>

<!--==========================-->
<!-- 内容 -->
<!--==========================-->

<?php
$raw_mail = <<<EOT
姓：Oｇ Ａw　ａ
名：T Ａ kuＹ ａ
メールアドレス：ＯgAＷa＠wiｚ-Ｇ.Ｃｏ.JＰ
性別：M
国籍：JaPaＮ
電話番号：０９０-1234-５６７８
EOT;
?>

<h3>Do you like which way ?</h3>

<div id="improvement">
<div class="space_10"></div>
<a href="#anchor_overview">事例を読む</a>
<ul id="improvement">
	<li><span id="improvement">方法 (A)</span>
		<ol id="improvement">
			<li>各データ項目をコピーします</li>
			<li>全半角、大小文字、不正な形式等に注意しながら、希望の形式に直します</li>
			<li>整形したデータを表に入力します</li>
		</ol>
	</li>
</ul>
<ul id="improvement">
	<li><span id="improvement">方法 (B)</span></li>
</ul>
<form method="post" action="/improvement/data_convert.html">
<div id="table">
<div class="box" id="float_left">
<div class="box">
<textarea name="mail_body" cols="40" rows="10">
<?php
if (isset($mail_body))
{
	echo $mail_body;
}
else
{
	echo $raw_mail;
}
?>
</textarea>
</div>
<div class="clear"></div>
<div class="box">
<input type="submit" value="整形する">
<input type="button" value="初期化" onclick="location.href=''">
</div>
</div>
</form>

<?php if (isset($is_form_valid)):?>
<?php if ($is_form_valid === FALSE):?>
<div class="box" id="float_left">
<?php echo validation_errors();?>
</div>
<?php else:?>
<div class="box" id="arrow">
<img src="/assets/portal/img/arrow.gif" />
</div>
<div class="box" id="table_cell">
<table border="1">
<tr><th>項目名</th><th>値</th></tr>
<tr><td>姓</td><td><?php echo set_value('lastname');?></td></tr>
<tr><td>名</td><td><?php echo set_value('firstname');?></td></tr>
<tr><td>メールアドレス</td><td><?php echo set_value('email');?></td></tr>
<tr><td>性別</td><td><?php echo set_value('sex');?></td></tr>
<tr><td>国籍</td><td><?php echo set_value('country_national');?></td></tr>
<tr><td>電話番号</td><td><?php echo set_value('tel');?></td></tr>
</table>
</div>
<?php endif;?>
<?php endif;?>
</div>

<div class="clear"></div>

<?php if (isset($is_form_valid) && $is_form_valid === TRUE):?>
<ul id="improvement">
	<li><span id="red">ポイント</span>
		<ol id="improvement">
			<li>一定の規則があるテキストであれば、データを抽出する事が可能</li>
			<li>データを抽出する際にデータを加工・整形する事が可能</li>
			<li>データを扱う業務の場合は、工程の上流（できれば最初の入力段階）でデータを整える事</li>
		</ol>
	</li>
</ul>
<?php endif;?>

<div class="space_30"></div>
</div>

<!--==========================-->
<!-- 概要 -->
<!--==========================-->

<h3 id="anchor_overview">Overview of this case.</h3>
<div class="space_10"></div>
<div id="improvement">
<div class="box">
下記のようなメールをお客様から受信して、<br />
各データ項目を、表に入力する業務を考えます。<br />
メールの内容は全半角や大小文字がバラバラです。<br />
文字の間にスペースも入っているようです。
</div>
<pre>
<?php echo $raw_mail;?>
</pre>
</div>

<?php $this->load->view('pages/components/contents', array('sitemap' => $sitemap));?>
