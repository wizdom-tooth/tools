<?php

$birth_day           = (int)$birth_day;
$birth_month         = (int)$birth_month;
$passport_from_day   = (int)$passport_from_day;
$passport_from_month = (int)$passport_from_month;
$passport_to_day     = (int)$passport_to_day;
$passport_to_month   = (int)$passport_to_month;

$id_sex = ($sex === 'M') ? '1' : '2';
$id_q1 = ($q1 === 'Yes') ? '1' : '2';
$id_q2 = ($q2 === 'Yes') ? '1' : '2';
$id_q3 = ($q3 === 'Yes') ? '1' : '2';
$id_q4 = ($q4 === 'Yes') ? '1' : '2';
$id_q5 = ($q5 === 'Yes') ? '1' : '2';
$id_q6 = ($q6 === 'Yes') ? '1' : '2';
$id_q7 = ($q7 === 'Yes') ? '1' : '2';

$js = <<<EOT
document.getElementById('applicant.lastName').value='${lastname}';
document.getElementById('applicant.firstName').value='${firstname}';
document.getElementById('applicant.dobDay').value='${birth_day}';
document.getElementById('applicant.dobMonth').value='${birth_month}';
document.getElementById('applicant.dobYear').value='${birth_year}';
document.getElementById('applicant.countryOfBirth').value='${country_birth}';
document.getElementById('applicant.countryOfCitizenship').value='${country_national}';
document.getElementById('applicant.countryOfLiving').value='${country_live}';
document.getElementById('applicant.sex${id_sex}').checked=true;
document.getElementById('passport.passportNumber').value='${passport_number}';
document.getElementById('passport.countryOfIssue').value='${country_national}';
document.getElementById('passport.whenIssuedDay').value='${passport_from_day}';
document.getElementById('passport.whenIssuedMonth').value='${passport_from_month}';
document.getElementById('passport.whenIssuedYear').value='${passport_from_year}';
document.getElementById('passport.expiresDay').value='${passport_to_day}';
document.getElementById('passport.expiresMonth').value='${passport_to_month}';
document.getElementById('passport.expiresYear').value='${passport_to_year}';
document.getElementById('vwp.communicableDisease${id_q1}').checked=true;
document.getElementById('vwp.criminalHistory${id_q2}').checked=true;
document.getElementById('vwp.terroristOrNazi${id_q3}').checked=true;
document.getElementById('vwp.seekingWork${id_q4}').checked=true;
document.getElementById('vwp.childCustodyViolation${id_q5}').checked=true;
document.getElementById('vwp.visaRefused${id_q6}').checked=true;
document.getElementById('vwp.visaRefusedWhen').value='${q6_when}';
document.getElementById('vwp.visaRefusedWhere').value='${q6_where}';
document.getElementById('vwp.immunity${id_q7}').checked=true;
document.getElementById('acceptWaiver1').checked=true;
document.getElementById('thirdParty1').checked=true;
window.scroll(0,document.body.scrollHeight);
EOT;
$js = preg_replace('/\s|\n/', '', $js);

?>
<a href="javascript:(function(){<?php echo $js;?>})();">入力用 - <?php echo $lastname.' '.$firstname;?></a>
