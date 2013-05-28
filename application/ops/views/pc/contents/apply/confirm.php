<div id="conts">
<h2 id="apply">ESTAお申込み</h2>
<div id="apply_flow">
<ul class="clearfix">
<li class="flowbox" id="box1"><p>申請書内容入力</p></li>
<li class="flowarrow"><img src="/assets/esta-o/img/common/arrow_flow_box.png" /></li>
<li class="flowbox" id="box2b"><p>申請書内容確認</p></li>
<li class="flowarrow"><img src="/assets/esta-o/img/common/arrow_flow_box.png" /></li>
<li class="flowbox" id="box3"><p>申請料お支払い</p></li>
<li class="flowarrow"><img src="/assets/esta-o/img/common/arrow_flow_box.png" /></li>
<li class="flowbox" id="box4"><p>申請完了</p></li>
</ul>
</div>
<p class="style_p05center">内容に誤りが無いか、ご確認お願い致します。</p>    
<table class="table_confirm">
<tr>
<th class="th_left">項目名</th>
<th class="th_right">ご入力内容</th>
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
<td class="td_left">Eメールアドレス</td>
<td class="td_right"><?php echo $email;?></td>
</tr>
<tr>
<td class="td_left">生年月日</td>
<td class="td_right"><?php echo $birth_year;?>　年　<?php echo $birth_month;?>　月　<?php echo $birth_day;?>　日</td>
</tr>
<tr>
<td class="td_left">性別</td>
<td class="td_right"><?php echo $sex;?></td>
</tr>
<tr>
<td class="td_left">国籍</td>
<td class="td_right"><?php echo $country_national?></td>
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
<td class="td_left">電話番号</td>
<td class="td_right"><?php echo $tel;?></td>
</tr>
<tr>
<td class="td_left">パスポート番号</td>
<td class="td_right"><?php echo $passport_number;?></td>
</tr>
<tr>
<td class="td_left">パスポート発行日</td>
<td class="td_right"><?php echo $passport_from_year.'　年　'.$passport_from_month.'　月　'.$passport_from_day.'　日';?></td>
</tr>
<tr>
<td class="td_left">パスポート有効期限</td>
<td class="td_right"><?php echo $passport_to_year.'　年　'.$passport_to_month.'　月　'.$passport_to_day.'　日';?></td>
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

<p class="style_p05center">【ESTA申請料　クレジット決済者様情報（日本語可）】</p>
<table class="table_confirm">
<tr>
<th class="th_left">項目名</th>
<th class="th_right">ご入力内容</th>
</tr>
<tr>
<td class="td_left">姓</td>
<td class="td_right"><?php echo $billing_last_name;?></td>
</tr>
<tr>
<td class="td_left">名</td>
<td class="td_right"><?php echo $billing_first_name;?></td>
</tr>
<tr>
<td class="td_left">居住国</td>
<td class="td_right"><?php echo $billing_country;?></td>
</tr>
<tr>
<td class="td_left">郵便番号</td>
<td class="td_right"><?php echo $billing_zip;?></td>
</tr>
<tr>
<td class="td_left">都道府県</td>
<td class="td_right"><?php echo $billing_state;?></td>
</tr>
<tr>
<td class="td_left">市区町村</td>
<td class="td_right"><?php echo $billing_city;?></td>
</tr>
<tr>
<td class="td_left">番地</td>
<td class="td_right"><?php echo $billing_address1;?></td>
</tr>
</table>


<form class="apply_confirm_form01" action="/apply/step2.html" method="post">
<fieldset class="apply_confirm_form01">
<input type="hidden" name="lastname" value="<?php echo $lastname;?>">
<input type="hidden" name="firstname" value="<?php echo $firstname;?>">
<input type="hidden" name="email" value="<?php echo $email;?>">
<input type="hidden" name="birth_year" value="<?php echo $birth_year;?>">
<input type="hidden" name="birth_month" value="<?php echo $birth_month;?>">
<input type="hidden" name="birth_day" value="<?php echo $birth_day;?>">
<input type="hidden" name="sex" value="<?php echo $sex;?>">
<input type="hidden" name="country_national" value="<?php echo $country_national;?>">
<input type="hidden" name="country_birth" value="<?php echo $country_birth;?>">
<input type="hidden" name="country_live" value="<?php echo $country_live;?>">
<input type="hidden" name="tel" value="<?php echo $tel;?>">
<input type="hidden" name="passport_number" value="<?php echo $passport_number;?>">
<input type="hidden" name="passport_from_year" value="<?php echo $passport_from_year;?>">
<input type="hidden" name="passport_from_month" value="<?php echo $passport_from_month;?>">
<input type="hidden" name="passport_from_day" value="<?php echo $passport_from_day;?>">
<input type="hidden" name="passport_to_year" value="<?php echo $passport_to_year;?>">
<input type="hidden" name="passport_to_month" value="<?php echo $passport_to_month;?>">
<input type="hidden" name="passport_to_day" value="<?php echo $passport_to_day;?>">
<input type="hidden" name="q1" value="<?php echo $q1;?>">
<input type="hidden" name="q2" value="<?php echo $q2;?>">
<input type="hidden" name="q3" value="<?php echo $q3;?>">
<input type="hidden" name="q4" value="<?php echo $q4;?>">
<input type="hidden" name="q5" value="<?php echo $q5;?>">
<input type="hidden" name="q6" value="<?php echo $q6;?>">
<input type="hidden" name="q6_when" value="<?php echo $q6_when;?>">
<input type="hidden" name="q6_where" value="<?php echo $q6_where;?>">
<input type="hidden" name="q7" value="<?php echo $q7;?>">
<input type="hidden" name="billing_last_name" value="<?php echo $billing_last_name;?>">
<input type="hidden" name="billing_first_name" value="<?php echo $billing_first_name;?>">
<input type="hidden" name="billing_country" value="<?php echo $billing_country;?>">
<input type="hidden" name="billing_zip" value="<?php echo $billing_zip;?>">
<input type="hidden" name="billing_state" value="<?php echo $billing_state;?>">
<input type="hidden" name="billing_city" value="<?php echo $billing_city;?>">
<input type="hidden" name="billing_address1" value="<?php echo $billing_address1;?>">
<div class="btn01">
<input id="btn01_copy" type="submit" value="上記内容で送信する"/>
</div>
</fieldset>
</form>


<form class="apply_confirm_form02" action="/apply/step1.html" method="post">
<fieldset class="apply_confirm_form02">
<input type="hidden" name="lastname" value="<?php echo $lastname;?>">
<input type="hidden" name="firstname" value="<?php echo $firstname;?>">
<input type="hidden" name="email" value="<?php echo $email;?>">
<input type="hidden" name="email_confirm" value="<?php echo $email;?>">
<input type="hidden" name="birth_year" value="<?php echo $birth_year;?>">
<input type="hidden" name="birth_month" value="<?php echo $birth_month;?>">
<input type="hidden" name="birth_day" value="<?php echo $birth_day;?>">
<input type="hidden" name="sex" value="<?php echo $sex;?>">
<input type="hidden" name="country_national" value="<?php echo $country_national;?>">
<input type="hidden" name="country_birth" value="<?php echo $country_birth;?>">
<input type="hidden" name="country_live" value="<?php echo $country_live;?>">
<input type="hidden" name="tel" value="<?php echo $tel;?>">
<input type="hidden" name="passport_number" value="<?php echo $passport_number;?>">
<input type="hidden" name="passport_from_year" value="<?php echo $passport_from_year;?>">
<input type="hidden" name="passport_from_month" value="<?php echo $passport_from_month;?>">
<input type="hidden" name="passport_from_day" value="<?php echo $passport_from_day;?>">
<input type="hidden" name="passport_to_year" value="<?php echo $passport_to_year;?>">
<input type="hidden" name="passport_to_month" value="<?php echo $passport_to_month;?>">
<input type="hidden" name="passport_to_day" value="<?php echo $passport_to_day;?>">
<input type="hidden" name="q1" value="<?php echo $q1;?>">
<input type="hidden" name="q2" value="<?php echo $q2;?>">
<input type="hidden" name="q3" value="<?php echo $q3;?>">
<input type="hidden" name="q4" value="<?php echo $q4;?>">
<input type="hidden" name="q5" value="<?php echo $q5;?>">
<input type="hidden" name="q6" value="<?php echo $q6;?>">
<input type="hidden" name="q6_when" value="<?php echo $q6_when;?>">
<input type="hidden" name="q6_where" value="<?php echo $q6_where;?>">
<input type="hidden" name="q7" value="<?php echo $q7;?>">
<input type="hidden" name="billing_last_name" value="<?php echo $billing_last_name;?>">
<input type="hidden" name="billing_first_name" value="<?php echo $billing_first_name;?>">
<input type="hidden" name="billing_country" value="<?php echo $billing_country;?>">
<input type="hidden" name="billing_zip" value="<?php echo $billing_zip;?>">
<input type="hidden" name="billing_state" value="<?php echo $billing_state;?>">
<input type="hidden" name="billing_city" value="<?php echo $billing_city;?>">
<input type="hidden" name="billing_address1" value="<?php echo $billing_address1;?>">
<input type="hidden" name="kiyaku1" value="Yes">
<input type="hidden" name="kiyaku2" value="Yes">
<input type="hidden" name="type" value="modify">
<div class="btn01">
<input id="btn01_copy" type="submit" value="内容を修正する"/>
</div>
</fieldset>
</form>

<div class="space_50"></div>

</div>
