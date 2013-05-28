<?php

$birth_day           = (int)$birth_day;
$birth_month         = (int)$birth_month;
$passport_from_day   = (int)$passport_from_day;
$passport_from_month = (int)$passport_from_month;
$passport_to_day     = (int)$passport_to_day;
$passport_to_month   = (int)$passport_to_month;

$js = <<<EOT
document.getElementById('passport.verifyNumber').value='${passport_number}';
document.getElementById('applicant.lastNameVerify').value='${lastname}';
document.getElementById('applicant.countryOfCitizenshipVerify').value='${country_national}';
document.getElementById('applicant.dobDayVerify').value='${birth_day}';
document.getElementById('applicant.dobMonthVerify').value='${birth_month}';
document.getElementById('applicant.dobYearVerify').value='${birth_year}';
window.scroll(0,document.body.scrollHeight);
EOT;
$js = preg_replace('/\s|\n/', '', $js);

?>
<a href="javascript:(function(){<?php echo $js;?>})();">認証用 - <?php echo $lastname.' '.$firstname;?></a>
