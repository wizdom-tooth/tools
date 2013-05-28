<div id="conts">
<h2 id="apply">ESTAお申込み</h2>

<div class="same_textbox">
<p class="style_p06">
同一内容にて決済済みの情報が見つかりました。<br />
申請状況は<a href="/status/index.html?app_id=<?php echo $past['app_id'];?>">コチラ</a>からご確認下さい。
</p>
</div>

<table class="table_same2">
<tr>
<th>項目名</th>
<th>情報</th>
</tr>
<tr>
<td class="td_left">過去の申請日</td>
<td class="td_right"><?php echo $past['start_date'];?></td>
</tr>
<tr>
<td class="td_left">姓</td>
<td class="td_right"><?php echo $lastname;?></td>
</tr>
<tr>
<td class="td_left">名</td>
<td class="td_right"><?php echo $firstname;?></td>
</tr>
<tr>
<td class="td_left">生年月日</td>
<td class="td_right"><?php echo $birth_date;?></td>
</tr>
<tr>
<td class="td_left">性別</td>
<td class="td_right"><?php echo $sex;?></td>
</tr>
<tr>
<td class="td_left">国籍</td>
<td class="td_right"><?php echo $country_national;?></td>
</tr>
<tr>
<td class="td_left">出生国</td>
<td class="td_right"><?php echo $country_birth;?></td>
</tr>
<tr>
<td class="td_left">居住国</td>
<td class="td_right"><?php echo $country_live;?></td>
</tr>
<tr>
<td class="td_left">パスポート番号</td>
<td class="td_right"><?php echo $passport_number;?></td>
</tr>
<tr>
<td class="td_left">パスポート発行日</td>
<td class="td_right"><?php echo $passport_from_date;?></td>
</tr>
<tr>
<td class="td_left">パスポート有効期限</td>
<td class="td_right"><?php echo $passport_to_date;?></td>
</tr>
<tr>
<td class="td_left">質問 A）</td>
<td class="td_right"><?php echo $q1;?></td>
</tr>
<tr>
<td class="td_left">質問 B）</td>
<td class="td_right"><?php echo $q2;?></td>
</tr>
<tr>
<td class="td_left">質問 C）</td>
<td class="td_right"><?php echo $q3;?></td>
</tr>
<tr>
<td class="td_left">質問 D）</td>
<td class="td_right"><?php echo $q4;?></td>
</tr>
<tr>
<td class="td_left">質問 E）</td>
<td class="td_right"><?php echo $q5;?></td>
</tr>
<tr>
<td class="td_left">質問 F）</td>
<td class="td_right"><?php echo $q6.' '.$q6_when.' '.$q6_where;?></td>
</tr>
<tr>
<td class="td_left">質問 G）</td>
<td class="td_right"><?php echo $q7;?></td>
</tr>
</table>

<form action="/" method="post">
<div class="btn01">
<input id="btn01_copy" type="submit" value="トップページへ戻る" />
</div>
</form>

<div class="space_30"></div>

</div>
