<form name="apply_form" id="apply_form" method="post" action="/apply/step1.html">
<div id="conts">
<h2 id="apply">ESTAお申込み</h2>

<div id="apply_flow">
<ul class="clearfix">
<li class="flowbox" id="box1b"><p>申請書内容入力</p></li>
<li class="flowarrow"><img src="/assets/esta-o/img/common/arrow_flow_box.png"/></li>
<li class="flowbox" id="box2"><p>申請書内容確認</p></li>
<li class="flowarrow"><img src="/assets/esta-o/img/common/arrow_flow_box.png"/></li>
<li class="flowbox" id="box3"><p>申請料お支払い</p></li>
<li class="flowarrow"><img src="/assets/esta-o/img/common/arrow_flow_box.png"/></li>
<li class="flowbox" id="box4"><p>申請完了</p></li>
</ul>
</div>

<p id="apply_desc">お手持ちの有効なパスポート、及びクレジットカードをご用意し、詳細な情報を確認してください。<br />
入力内容に不備がないのを確認し、お申し込みください。申請後の情報変更はできません。<br />
お名前やパスポート情報等の重要な項目の修正の際は再度申請が必要ですのでご注意下さい。<br />
ご自身の入力間違いによる渡航の保証は致しかねます。 <br />
<span class="style_p01red">項目は全て必須入力です。</span><br />
申請完了後、お客様のもとへ申請結果をメールにてお送りいたしますので、<br />
必ず受信できるEメールアドレスをご入力下さい。
</p>

<div id="apply_sheet">
<h3 class="style_h3_01">ESTA必要事項記入</h3>

<div class="apply_hr">
<table>
<tbody>
<tr>
<th>姓</th>
<td><input type="text" id="lastname" class="apply_input" name="lastname" value="<?php echo set_value('lastname');?>" />
<?php echo form_error('lastname');?>
<p class="style_p02attention">例：YAMADA</p>
</td>
</tr>
<tr>
<th>名</th>
<td><input type="text" id="firstname" class="apply_input" name="firstname" value="<?php echo set_value('firstname');?>" />
<?php echo form_error('firstname');?>
<p class="style_p02attention">例：TARO</p>
</td>
</tr>
</tbody>
</table>
</div>

<div class="apply_hr">
<table>
<tbody>
<tr>
<th>Eメールアドレス</th>
<td><input type="text" id="email" class="apply_input" name="email" value="<?php echo set_value('email');?>" /><?php echo form_error('email');?></td>
</tr>
<tr>
<th>Eメールアドレス（確認）</th>
<td><input type="text" id="email_confirm" class="apply_input" name="email_confirm" value="<?php echo set_value('email_confirm');?>" /><?php echo form_error('email_confirm');?></td>
</tr>
<tr>
<th>&nbsp;</th>
<td>
<p class="style_p01red">
当該項目はESTA認証結果の送付やご連絡に使用しますので、必ず受信できるPCのEメールアドレスをご入力下さい。携帯電話アドレスはご遠慮下さい。尚、弊社から送信したメールが、迷惑メールフォルダ等へ振り分けられる可能性が御座いますので、必ずご確認をお願いいたします。
</p>
</td>
</tr>
</tbody>
</table>
</div>

<div class="apply_hr">
<table>
<tbody>
<tr>
<th>生年月日</th>
<td>
<?php $selected = ($this->input->post('birth_year')) ? $this->input->post('birth_year') : ''; ?>
<?php echo form_dropdown('birth_year', $form_birth_year, $selected); ?>年
<?php $selected = ($this->input->post('birth_month')) ? $this->input->post('birth_month') : ''; ?>
<?php echo form_dropdown('birth_month', $form_month, $selected); ?>月
<?php $selected = ($this->input->post('birth_day')) ? $this->input->post('birth_day') : ''; ?>
<?php echo form_dropdown('birth_day', $form_day, $selected); ?>日
<?php echo form_error('birth_year'); ?><?php echo form_error('birth_month'); ?><?php echo form_error('birth_day'); ?>
</td>
</tr>
<tr>
<th>性別</th>
<td>
<input id="sex_m" type="radio" name="sex" value="M" <?php echo set_radio('sex', 'M');?> /><label for="sex_m">男性</label>
<input id="sex_f" type="radio" name="sex" value="F" <?php echo set_radio('sex', 'F');?> /><label for="sex_f">女性</label>
<?php echo form_error('sex'); ?>
</td>
</tr>
<tr>
<th>国籍</th>
<td>
<?php $selected = ($this->input->post('country_national')) ? $this->input->post('country_national') : 'JP'; ?>
<?php echo form_dropdown('country_national', $form_country_national, $selected); ?>
<?php echo form_error('country_national'); ?>
</td>
</tr>
<tr>
<th>出生国</th>
<td>
<?php $selected = ($this->input->post('country_birth')) ? $this->input->post('country_birth') : 'JP'; ?>
<?php echo form_dropdown('country_birth', $form_country_birth, $selected); ?>
<?php echo form_error('country_birth'); ?>
</td>
</tr>
<tr>
<th>居住国</th>
<td>
<?php $selected = ($this->input->post('country_live')) ? $this->input->post('country_live') : 'JP'; ?>
<?php echo form_dropdown('country_live', $form_country_live, $selected); ?>
<?php echo form_error('country_live'); ?>
</td>
</tr>
<tr>
<th>電話番号</th>
<td>
<input type="text" id="tel" class="apply_input_305" name="tel" value="<?php echo set_value('tel'); ?>" /><br />
<?php echo form_error('tel'); ?>
<p class="style_p02attention">例：00-1234-5678</p>
</td>
</tr>
</tbody>
</table>
</div>

<div class="apply_hr">
<table>
<tbody>
<tr>
<th>パスポート番号</th>
<td>
<input type="text" id="passport_number" class="apply_input_305" name="passport_number" value="<?php echo set_value('passport_number'); ?>" /><br />
<?php echo form_error('passport_number'); ?>
<p class="style_p02attention">例：TH1234567</p>
</td>
</tr>
<tr>
<th>パスポート発行日</th>
<td>
<?php $selected = ($this->input->post('passport_from_year')) ? $this->input->post('passport_from_year') : ''; ?>
<?php echo form_dropdown('passport_from_year', $form_passport_from_year, $selected); ?>年
<?php $selected = ($this->input->post('passport_from_month')) ? $this->input->post('passport_from_month') : ''; ?>
<?php echo form_dropdown('passport_from_month', $form_month, $selected); ?>月
<?php $selected = ($this->input->post('passport_from_day')) ? $this->input->post('passport_from_day') : ''; ?>
<?php echo form_dropdown('passport_from_day', $form_day, $selected); ?>日
<?php echo form_error('passport_from_year'); ?><?php echo form_error('passport_from_month'); ?><?php echo form_error('passport_from_day'); ?>
</td>
</tr>
<tr>
<th>パスポート有効期限</th>
<td>
<?php $selected = ($this->input->post('passport_to_year')) ? $this->input->post('passport_to_year') : ''; ?>
<?php echo form_dropdown('passport_to_year', $form_passport_to_year, $selected); ?>年
<?php $selected = ($this->input->post('passport_to_month')) ? $this->input->post('passport_to_month') : ''; ?>
<?php echo form_dropdown('passport_to_month', $form_month, $selected); ?>月
<?php $selected = ($this->input->post('passport_to_day')) ? $this->input->post('passport_to_day') : ''; ?>
<?php echo form_dropdown('passport_to_day', $form_day, $selected); ?>日
<?php echo form_error('passport_to_year'); ?><?php echo form_error('passport_to_month'); ?><?php echo form_error('passport_to_day'); ?>
</td>
</tr>
</tbody>
</table>
</div>

<div class="apply_checkboxarea">
<table class="table_apply2">
<tr>
<td class="td_apply2_01">
<div>
<?php $selected = ($this->input->post('q1') === 'Yes') ? TRUE : FALSE; ?>
<?php echo form_radio('q1', 'Yes', $selected); ?>Yes
<?php $selected = ($this->input->post('q1') !== 'Yes') ? TRUE : FALSE; ?>
<?php echo form_radio('q1', 'No', $selected); ?>No
</div>
</td>
<td class="td_apply2_02">
<p>【質問A】：伝染病にかかっていますか？ 身体的または精神的障害を患っていますか？　麻薬常習者または麻薬中毒者ですか？</p></td>
</tr>
<tr>
<td class="td_apply2_01">
<div>
<?php $selected = ($this->input->post('q2') === 'Yes') ? TRUE : FALSE; ?>
<?php echo form_radio('q2', 'Yes', $selected); ?>Yes
<?php $selected = ($this->input->post('q2') !== 'Yes') ? TRUE : FALSE; ?>
<?php echo form_radio('q2', 'No', $selected); ?>No
</div>
</td>
<td class="td_apply2_02">
<p>【質問B】：これまでに不道徳な行為に関わる違法行為あるいは規 制薬物に関する違反を犯し逮捕されたこと、あるいは有罪判決を受けたことがありますか？<br />
2つ以上の罪を犯して合計5年以上の禁固判決を受けたことがありますか？<br />
規制薬物の不正取引をしたことがありますか？ 犯罪活動あるいは不道徳な行為を行なうために米国へ入国しようとしていますか？</p></td>
</tr>
<tr>
<td class="td_apply2_01">
<div>
<?php $selected = ($this->input->post('q3') === 'Yes') ? TRUE : FALSE; ?>
<?php echo form_radio('q3', 'Yes', $selected); ?>Yes
<?php $selected = ($this->input->post('q3') !== 'Yes') ? TRUE : FALSE; ?>
<?php echo form_radio('q3', 'No', $selected); ?>No
</div>
</td>
<td class="td_apply2_02">
<p>【質問C】：これまでに、あるいは現在、スパイ行為、破壊活動、テロリスト活動、もしくは集団殺戮に関係したことがありますか、あるいはしていますか？<br />
1933年から1945年の間に何らかの形でドイツ・ナチス政府やその同盟諸国に関連して迫害行為に関係していましたか？</p>
</td>
</tr>
<tr>
<td class="td_apply2_01">
<div>
<?php $selected = ($this->input->post('q4') === 'Yes') ? TRUE : FALSE; ?>
<?php echo form_radio('q4', 'Yes', $selected); ?>Yes
<?php $selected = ($this->input->post('q4') !== 'Yes') ? TRUE : FALSE; ?>
<?php echo form_radio('q4', 'No', $selected); ?>No
</div>
</td>
<td class="td_apply2_02">
<p>【質問D】：米国で働くつもりですか。米国から国外退去、あるいは強制送還されたり出国を命ぜられたことがありますか？<br />
不正手段または虚偽の申告によって米国ビザの取得またはの入国を試みたことがありますか？</p>
</td>
</tr>
<tr>
<td class="td_apply2_01">
<div>
<?php $selected = ($this->input->post('q5') === 'Yes') ? TRUE : FALSE; ?>
<?php echo form_radio('q5', 'Yes', $selected); ?>Yes
<?php $selected = ($this->input->post('q5') !== 'Yes') ? TRUE : FALSE; ?>
<?php echo form_radio('q5', 'No', $selected); ?>No
</div>
</td>
<td class="td_apply2_02">
<p>【質問E】：親権を持つ米国市民からその子供を取り上げ、拘束し、あるいはその親権を渡さなかったことがありますか？</p>
</td>
</tr>
<tr>
<td class="td_apply2_01">
<div>
<?php $selected = ($this->input->post('q6') === 'Yes') ? TRUE : FALSE; ?>
<?php echo form_radio('q6', 'Yes', $selected); ?>Yes
<?php $selected = ($this->input->post('q6') !== 'Yes') ? TRUE : FALSE; ?>
<?php echo form_radio('q6', 'No', $selected); ?>No
</div>
</td>
<td class="td_apply2_02">
<p>【質問F】：米国のビザまたは米国入国を拒否されたことがありますか。または、発行された米国ビザを取り消されたことがありますか？</p>
<table class="table_apply3">
<tr>
<td class="td_apply3_01">
<input type="text" id="q6_when" class="apply_input_200" name="q6_when" value="<?php echo set_value('q6_when');?>"/>
<p class="style_p02attention">「Yes」の場合: いつ？（例：2008）</p>
</td>
<td class="td_apply3_01">
<input type="text" id="q6_where" class="apply_input_200" name="q6_where" value="<?php echo set_value('q6_where');?>"/>
<p class="style_p02attention">「Yes」の場合: どこで？（例:JAPAN）</p>
</td>
</tr>
</table>
<?php echo form_error('q6_when');?>
<?php echo form_error('q6_where');?>
</td>
</tr>
<tr>
<td class="td_apply2_01">
<div>
<?php $selected = ($this->input->post('q7') === 'Yes') ? TRUE : FALSE; ?>
<?php echo form_radio('q7', 'Yes', $selected); ?>Yes
<?php $selected = ($this->input->post('q7') !== 'Yes') ? TRUE : FALSE; ?>
<?php echo form_radio('q7', 'No', $selected); ?>No
</div>
</td>
<td class="td_apply2_02"><p>【質問G】：追訴免責を主張したことがありますか？</p></td>
</tr>
<tr>
<td class="td_apply2_01">&nbsp;</td>
<td class="td_apply2_02">&nbsp;</td>
</tr>
</table>
</div>
</div>

<div id="apply_sheet_credit">
<h3 class="style_h3_01">ESTA申請料　クレジット決済者様情報（日本語可）</h3>
<p class="style_p03attention"></p>
<table>
<tbody>
<tr>
<th>姓（例：YAMADA または山田）</th>
<td>
<input type="text" id="billing_last_name" class="apply_input_200" name="billing_last_name" value="<?php echo set_value('billing_last_name'); ?>"/>
<?php echo form_error('billing_last_name'); ?>
</td>
</tr>
<tr>
<th>名（例：TARO または太郎）</th>
<td>
<input type="text" id="billing_first_name" class="apply_input_200" name="billing_first_name" value="<?php echo set_value('billing_first_name'); ?>"/>
<?php echo form_error('billing_first_name'); ?>
</td>
</tr>
<tr>
<th>居住国</th>
<td>
<?php $selected = ($this->input->post('billing_country')) ? $this->input->post('billing_country') : 'JP'; ?>
<?php echo form_dropdown('billing_country', $form_billing_country, $selected); ?>
<?php echo form_error('billing_country'); ?>
</td>
</tr>
<tr>
<th>郵便番号（例：123-0000）</th>
<td>
<input type="text" id="billing_zip" class="apply_input_100" name="billing_zip" value="<?php echo set_value('billing_zip'); ?>" />
<?php echo form_error('billing_zip'); ?>
</td>
</tr>
<tr>
<th>都道府県（例：Tokyoまたは東京都）</th>
<td>
<input type="text" id="billing_state" class="apply_input_200" name="billing_state" value="<?php echo set_value('billing_state'); ?>" />
<?php echo form_error('billing_state'); ?>
</td>
</tr>
<tr>
<th>市区町村（例：Shibuyaまたは渋谷区）</th>
<td>
<input type="text" id="billing_city" class="apply_input_305" name="billing_city" value="<?php echo set_value('billing_city'); ?>" />
<?php echo form_error('billing_city'); ?>
</td>
</tr>
<tr>
<th>番地（例：XX1-2またはXX町1-2）</th>
<td>
<input type="text" id="billing_address1" class="apply_input_305" name="billing_address1" value="<?php echo set_value('billing_address1'); ?>" />
<?php echo form_error('billing_address1'); ?>
</td>
</tr>
</tbody>
</table>
</div>

<div id="apply_sheet_agreement">
<h3 class="style_h3_01">ESTAお申し込みに関する同意事項</h3>
<p class="style_p04agree_red">規約1．米国Webサイトに掲示されている下記の内容について同意しますか？</p>
<table class="table_apply4">
<tr>
<td class="td_apply4_01">
<div>
<input type="checkbox" name="kiyaku1" id="kiyaku1" value="Yes" <?php echo set_checkbox('kiyaku1', 'Yes');?> />
<label for="kiyaku1"> 同意する</label>
</div>
</td>
<td class="td_apply4_02">
<div class="div_scr">
<p>電子渡航認証システム（ESTA）は、法施行機関のデータベースとの照合を行ないます。ビザ免除プログラムを利用して米国に入国するすべての渡航者は、搭乗前にこのシステムを用いて電子渡航認証を取得することが義務付けられています。<br />
<br />
渡航認証申請が承認されている場合、渡航資格があることが証明されたことになりますが、ビザ免除プログラムに基づき米国に入国が認められることを証明するものではありません。米国に到着すると、入国地で税関国境警備局審査官の審査を受けることになりますが、ビザ免除プログラムに基づき、または米国法による何 らかの理由で入国拒否と判定されることがあります。<br />
<br />
電子渡航認証の資格がないと判定されても、渡米のためのビザ申請ができないということではありません。<br />
<br />
あなた自身または第三者の代行者により提供されたすべての情報は、真実、かつ正確なものでなければなりません。電子渡航認証資格に影響を与える新しい情報な ど、何らかの理由によりいつでも取り消されることがあります。あなた自身または代行により提出された電子渡航認証申請において故意に重大な偽り、虚偽、または詐欺の供述あるいは表明を行なった場合には、行政処分や刑事処分を受けることがあります。</p>
<p>■権利の放棄<br />
私は、ESTAで取得した渡航認証の期間中、米国税関国境警備局審査官の入国に関する決定に対して審査または不服申立を行う、あるいは亡命の申請事由を除き、ビザ免除プログラムでの入国申請から生じる除外措置について異議を申し立てる権利を放棄する旨の説明を読み、了解しました。<br />
上記の権利放棄に加え、ビザ免除プログラムに基づく米国への入国の条件として、私は、米国に到着時の審査において、生体認証識別（指紋や写真など）を提出することにより、米国税関国境警備局審査官の入国に関する決定に対して審査または不服申立を行う、あるいは亡命の申請事由を除き、ビザ免除プログラムによる入国申請から生じる除外措置について異議を申し立てる権利を放棄することが再確認されるものであることに同意します。<br />
<br />
■証明<br />
私、申請者は、本申請書のすべての質問事項および記載事項を読み、または代読してもらい、本申請書のすべての質問事項および記載事項を理解したことを証明します。本申請書で記述した回答および内容は、私の知る限り、また信じる限りにおいて真実、かつ正確なものです。<br />
申請者の代行者として申請書を提出する第三者として、私は、本申請書に名前が記載された人（申請者）に本申請書のすべての質問事項および記載事項を読み上 げたことを証明します。私は、さらに、申請者が本申請書のすべての質問事項および記載内容を読み、または代読してもらい、理解し、また、米国税関国境警備局審査官の入国に関する決定に対して審査または不服申立を行う、あるいは亡命の申請事由を除き、ビザ免除プログラムによる入国申請から生じる除外措置について、異議を唱える権利を放棄することを証明していることを証明します。<br />
本申請書で記述した回答および内容は、申請者の知る限り、また信じる限りにおいて 真実、かつ正確なものです。</p>
</div>
<?php echo form_error('kiyaku1');?>
</td>
</tr>
</table>
<div class="apply_hr2"></div>
<p class="style_p04agree_red">規約2．当Webサイトに掲示されている下記の内容について同意しますか？</p>
<table class="table_apply4">
<tr>
<td class="td_apply4_01">
<div>
<input type="checkbox" name="kiyaku2" id="kiyaku2" value="Yes" <?php echo set_checkbox('kiyaku2', 'Yes');?> />
<label for="kiyaku2"> 同意する</label>
</div>
</td>
<td class="td_apply4_02">
<div class="div_scr">
<p>ESTA Online Centerのすべての利用者は、このサイト内で規定している個人情報保護方針を順守します。</p>
<p>個人情報保護方針で、当社・当社のサイトという言葉はESTA Online Centerを言います。</p>
<p>個人情報保護方針で、申請者･利用者･お客様と第3者を表現する言葉や文章は、<br />
当社サイトを通して契約する人をさします。</p>
<p>当社サイトの利用する者はサイト内に記載されている規約及び規定に同意します。</p>
<p>当社サイトとはサイト内で使用されているすべての情報・デザイン・システムを含みます。</p>
<p>当社サイトの利用者は、不法的な目的で利用しない事に同意します。</p>
<p>当社サイトの利用者は、当社所有の著作権、特許権、知的財産権を侵害しない事に同意します。</p>
<p>当社サイトの利用者は意図的なソフトウェアのコピー、保存、製作、ホスティング、配布をしない事に同意します。</p>
<p>当社の著作権には、当社が持つシステム、イメージ、テキスト、グラフィックなどが含まれています。</p>
<p>当社は個人情報保護方針により運営されており、お客様にESTA申請のために情報を求めることができます。</p>
<p>サービスの進行によりサービス料が発生します。</p>
<p>当社が定める申請手数料には、米国国土安全保障省および旅行促進法により定められた14$が含まれています。<br />
これらの支払いはクレジットカードおよびPayPalでの決済が可能です。</p>
<p>申請代行完了後のキャンセルはできませんのでご了承下さい。</p>
<p>お客様からのサービスの進行の要請とお支払いが確認できた時点からサービスが進行されます。</p>
<p>当社のサービスとはお客様に代わってESTAの申請を行うサービスを提供するのみとなります。</p>
<p>当社サイトの利用者は、いかなる損害に対して、当社に直接または間接的に請求することはできません。<br />
お客様の決済をされたサービス料だけに責任を取ります。</p>
<p>当社サイトの利用者が契約破棄した場合、当社は権利を保護するため、<br />
利用者のサイトへのアクセスを制限し、法的措置等を行います。</p>
<p>当社サービスに関する問題はお問い合わせフォームよりご連絡下さい。 </p>
<p>1名あたりの申請代行料金<br />
米国国土安全保障省申請料（14$）＋申請代行サービス料＝6500円（税込6825円）</p>
</div>
<?php echo form_error('kiyaku2'); ?>
</td>
</tr>
</table>
</div>

<div class="btn01">
<input id="btn01_copy" type="submit" value="送信確認画面へ移動する"/>
</div>

</div>
</form>
