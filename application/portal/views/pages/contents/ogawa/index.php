<?php

$js = <<<EOT

/*お申込み日付*/
parent.main.document.getElementsByName('appliedDateyy')[0].value='2012';
parent.main.document.getElementsByName('appliedDatemm')[0].value='03';
parent.main.document.getElementsByName('appliedDatedd')[0].value='28';

/*お申込情報*/
parent.main.document.getElementsByName('salesmanCode')[0].value='aaaaaaaa';
parent.main.document.getElementsByName('mskmShonInfo[0]')[0].value='81,20,2,1';
parent.main.document.getElementsByName('mskmShonInfo[1]')[0].value='PK,20,H,0';
parent.main.document.getElementsByName('mskmShonInfo[2]')[0].value='4M,20,M,6';
parent.main.document.getElementsByName('constMark')[1].checked=true;
parent.main.document.getElementsByName('appliedLines')[0].value='3';

/*お申込者情報*/
parent.main.document.getElementsByName('applicantSurname')[0].value='小川';
parent.main.document.getElementsByName('applicantFirstname')[0].value='拓也';
parent.main.document.getElementsByName('applicantKSurname')[0].value='オガワ';
parent.main.document.getElementsByName('applicantKFirstname')[0].value='タクヤ';

parent.main.document.getElementsByName('contact1phone1')[0].value='090';
parent.main.document.getElementsByName('contact1phone2')[0].value='4451';
parent.main.document.getElementsByName('contact1phone3')[0].value='3652';
parent.main.document.getElementsByName('contact1Type')[2].checked=true;

parent.main.document.getElementsByName('contact2phone1')[0].value='03';
parent.main.document.getElementsByName('contact2phone2')[0].value='3594';
parent.main.document.getElementsByName('contact2phone3')[0].value='0749';
parent.main.document.getElementsByName('contact2Type')[0].checked=true;

parent.main.document.getElementsByName('emailAddress')[0].value='ogawa@wiz-g.co.jp';
parent.main.document.getElementsByName('callphoneMailAddress')[0].value='duck_hunter_camouflage@ezweb.ne.jp';

/*ご契約者情報*/
parent.main.document.getElementsByName('contractType')[1].checked=true;
parent.main.document.getElementsByName('applicant')[0].checked=true;
parent.main.document.getElementsByName('applicantRelations')[2].checked=true;
parent.main.document.getElementsByName('relation')[0].value='他人';
parent.main.document.getElementsByName('contractSurname')[0].value='小川';
parent.main.document.getElementsByName('contractFirstname')[0].value='拓也';
parent.main.document.getElementsByName('contractKSurname')[0].value='オガワ';
parent.main.document.getElementsByName('contractKFirstname')[0].value='タクヤ';
parent.main.document.getElementsByName('nameConfirmationMaterial')[3].checked=true;
parent.main.document.getElementsByName('dateOfBirthyy')[0].value='1982';
parent.main.document.getElementsByName('dateOfBirthmm')[0].value='03';
parent.main.document.getElementsByName('dateOfBirthdd')[0].value='23';
parent.main.document.getElementsByName('contractId3')[0].value='COP';
parent.main.document.getElementsByName('contractId8')[0].value='12345678';
parent.main.document.getElementsByName('provider')[0].value='謎のプロバイダ';

/*ご利用場所情報*/

/*工事のご案内情報*/
parent.main.document.getElementsByName('consalDateyy')[0].value='2012';
parent.main.document.getElementsByName('consalDatemm')[0].value='05';
parent.main.document.getElementsByName('consalDatedd')[0].value='16';
parent.main.document.getElementsByName('constructHopeTime')[0].value='2';
parent.main.document.getElementsByName('result')[1].checked=true;
parent.main.document.getElementsByName('resultContactSame')[1].checked=true;
parent.main.document.getElementsByName('resultContactPhoneNo1')[0].value='03';
parent.main.document.getElementsByName('resultContactPhoneNo2')[0].value='3594';
parent.main.document.getElementsByName('resultContactPhoneNo3')[0].value='0749';

/*記事欄*/
parent.main.document.getElementsByName('articleColumn1')[0].value='あああああああああああああああああああああああああああああいいいいいいいいいいいいいいいいいいいいいいうううううううううううううううううううううう';
parent.main.document.getElementsByName('articleColumn2')[0].value='いいいいいい';
parent.main.document.getElementsByName('articleColumn3')[0].value='うううううう';

/*備考欄（代理店様用）*/
parent.main.document.getElementsByName('receiptNote')[0].value='hogehoge';

/*その他属性*/
parent.main.document.getElementsByName('othersAttributeCode1')[0].value='attribute code 01';
parent.main.document.getElementsByName('othersAttributeCode2')[0].value='attribute code 02';
parent.main.document.getElementsByName('othersAttributeCode3')[0].value='attribute code 03';

EOT;
//window.scroll(0,parent.main.document.body.scrollHeight);
//parent.main.document.getElementsByName('')[0].value='';

//$js = preg_replace('/\s/', '', $js);
$js = preg_replace('/\n/', '', $js);
$bml = '<a href="javascript:(function(){'.$js.'})();">bookmark me!</a>';

?>

<h2>NTT自動入力テスト</h2>

<h3>Bookmarklet</h3>
<div class="space_20"></div>
<?php echo $bml;?>
<div class="space_20"></div>

<h3>Raw Javascript</h3>
<pre>
<?php echo $js;?>
</pre>


