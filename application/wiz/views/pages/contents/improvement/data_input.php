<?php
$js1 .= <<<EOT
document.getElementById('lastname').value='OGAWA';
document.getElementById('firstname').value='TAKUYA';
document.getElementById('email').value='ogawa@wiz-g.co.jp';
document.getElementById('birth_year').value='1982';
document.getElementById('birth_month').value='3';
document.getElementById('birth_day').value='23';
EOT;
$js2 .= <<<EOT
document.getElementById('lastname').value='UETAKE';
document.getElementById('firstname').value='HIROMU';
document.getElementById('email').value='uetake@wiz-g.co.jp';
document.getElementById('birth_year').value='1978';
document.getElementById('birth_month').value='8';
document.getElementById('birth_day').value='20';
EOT;
$js3 .= <<<EOT
document.getElementById('em').value='ogawa@wiz-g.co.jp';
document.getElementById('yid').value='wiz_group_sample';
document.getElementById('pw').value='w1zhogefoobar';
document.getElementById('pw2').value='w1zhogefoobar';
document.getElementById('postalCode_a').value='1770045';
document.getElementById('male').checked=true;;
document.getElementById('birth').value='19820323';
document.getElementById('numok').checked=false;
window.scroll(0,document.body.scrollHeight);
EOT;
$js1 = preg_replace('/\s/', '', $js1);
$bm1 = '<a href="javascript:(function(){'.$js1.'})();">Click Me!</a>';
$js2 = preg_replace('/\s/', '', $js2);
$bm2 = '<a href="javascript:(function(){'.$js2.'})();">Click Me!</a>';
$js3 = preg_replace('/\s/', '', $js3);
$bm3 = '<a href="javascript:(function(){'.$js3.'})();">Bookmark Me!</a>';
?>

<h2>DEMO: データ入力</h2>

<h3>Do you like which way ?</h3>

<div id="improvement">

<div class="box">
下記のような顧客データを、WEBフォームに入力する業務を考えます。<br />
</div>

<pre>
---SAMPLE 01--------------------------
姓：OGAWA
名：TAKUYA
メールアドレス：ogawa@wiz-g.co.jp
生年月日：1982年3月23日

---SAMPLE 02--------------------------
姓：UETAKE
名：HIROMU
メールアドレス：uetake@wiz-g.co.jp
生年月日：1978年8月20日
</pre>

<ul id="improvement">
    <li><span id="improvement">方法 (A)</span>
        <ol id="improvement">
            <li>各データ項目をコピー＆ペーストして入力し、プルダウンを選択します</li>
        </ol>
    </li>
</ul>
<ul id="improvement">
    <li><span id="improvement">方法 (B)</span>
        <ol id="improvement">
            <li>SAMPLE01 [<?php echo $bm1;?>]</li>
            <li>SAMPLE02 [<?php echo $bm2;?>]</li>
        </ol>
    </li>
</ul>
<form>
<table frame="box">
<tr><td>姓</td><td><input type="text" id="lastname"/></td></tr>
<tr><td>名</td><td><input type="text" id="firstname"/></td></tr>
<tr><td>メールアドレス</td><td><input type="text" id="email"/></td></tr>
<tr>
<td>生年月日</td>
<td>
<select id="birth_year">
<option value="">選択して下さい</option>
<option value="1990">1990</option>
<option value="1989">1989</option>
<option value="1988">1988</option>
<option value="1987">1987</option>
<option value="1986">1986</option>
<option value="1985">1985</option>
<option value="1984">1984</option>
<option value="1983">1983</option>
<option value="1982">1982</option>
<option value="1981">1981</option>
<option value="1980">1980</option>
<option value="1979">1979</option>
<option value="1978">1978</option>
<option value="1977">1977</option>
<option value="1976">1976</option>
<option value="1975">1975</option>
<option value="1974">1974</option>
<option value="1973">1973</option>
<option value="1972">1972</option>
<option value="1971">1971</option>
<option value="1970">1970</option>
</select>年
<select id="birth_month">
<option value="">選択して下さい</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
</select>月
<select id="birth_day">
<option value="">選択して下さい</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
</select>日
</td>
</tr>
</table>
</form>

<ul id="improvement">
    <li><span id="red">ポイント</span>
        <ul id="improvement">
            <li>この手法はリンクをブックマークする事で、任意のページに適用する事が可能です</li>
            <li>下記はサンプルですので、フォームを送信しないように御注意ください</li>
            <li>ex) <a href="https://account.edit.yahoo.co.jp/registration" target="blank">Yahoo! Japan ID登録</a> [<?php echo $bm3;?>]</li>
        </ul>
    </li>
</ul>

</div>

<?php $this->load->view('pages/components/sitemap', array('sitemap' => $sitemap));?>
