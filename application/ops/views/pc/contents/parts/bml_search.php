<?php

$birth_day           = (int)$birth_day;
$birth_month         = (int)$birth_month;
$passport_from_day   = (int)$passport_from_day;
$passport_from_month = (int)$passport_from_month;
$passport_to_day     = (int)$passport_to_day;
$passport_to_month   = (int)$passport_to_month;

$js = <<<EOT
document.getElementById('checkStatus.passportNumber').value='${passport_number}';
document.getElementById('checkStatus.applicant.dobDay').value='${birth_day}';
document.getElementById('checkStatus.applicant.dobMonth').value='${birth_month}';
document.getElementById('checkStatus.applicant.dobYear').value='${birth_year}';
document.getElementById('checkStatus.applicant.lastName').value='${lastname}';
document.getElementById('checkStatus.applicant.firstName').value='${firstname}';
document.getElementById('checkStatus.applicant.countryOfCitizenship').value='${country_national}';
window.scroll(0,document.body.scrollHeight);
EOT;
$js = preg_replace('/\s|\n/', '', $js);

?>
<a href="javascript:(function(){<?php echo $js;?>})();">検索用 - <?php echo $lastname.' '.$firstname;?></a>
