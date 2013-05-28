<?php echo $lastname;?> <?php echo $firstname;?> 様


お世話になっております。ESTA Online Center です。

米国合衆国より、お客様の渡航が許可されました。
ご渡航の際、認証情報の提示を求められる事はありませんが、
国土安全保障省（DHS）では、"控え"としてこの情報の保管をお勧めしています。

┏━━━━━━━━━━━━━━━━━━━━━━━━━━━
┃ESTA認証情報
┣━━━━━━━━━━━━━━━━━━━━━━━━━━━
┃ ・渡航申請番号
┃<?php echo $esta_app_id;?> 
┃
┃・有効期限
┃<?php echo $esta_app_expired;?> 
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━

この度はESTA Online Centerをご利用頂き、誠にありがとうございました。

<?php $this->load->view('pc/mail/signature');?>
