<?php echo date('Y/m/d H:i')?>現在の申請状況を報告します。

-------------------------------------------------
サマリ
-------------------------------------------------

申込み数：<?php echo $apply;?> 
決済数：<?php echo $paid;?> 

-------------------------------------------------
内訳詳細
-------------------------------------------------

＜性別＞
男性：<?php echo $sex_m;?> 
女性：<?php echo $sex_f;?> 

＜時間帯＞
0時：<?php echo $time_0;?> 
3時：<?php echo $time_3;?> 
6時：<?php echo $time_6;?> 
9時：<?php echo $time_9;?> 
12時：<?php echo $time_12;?> 
15時：<?php echo $time_15;?> 
18時：<?php echo $time_18;?> 
21時：<?php echo $time_21;?> 

＜年齢層＞
0代：<?php echo $age_0;?> 
10代：<?php echo $age_10;?> 
20代：<?php echo $age_20;?> 
30代：<?php echo $age_30;?> 
40代：<?php echo $age_40;?> 
50代：<?php echo $age_50;?> 
60代：<?php echo $age_60;?> 
70代：<?php echo $age_70;?> 
80代：<?php echo $age_80;?> 
90代：<?php echo $age_90;?> 
100代：<?php echo $age_100;?> 

＜都道府県＞
北海道：<?php echo $hokkaido;?> 
青森：<?php echo $aomori;?> 
岩手：<?php echo $iwate;?> 
宮城：<?php echo $miyagi;?> 
秋田：<?php echo $akita;?> 
山形：<?php echo $yamagata;?> 
福島：<?php echo $fukushima;?> 
茨城：<?php echo $ibaraki;?> 
栃木：<?php echo $tochigi;?> 
群馬：<?php echo $gunma;?> 
埼玉：<?php echo $saitama;?> 
千葉：<?php echo $chiba;?> 
東京：<?php echo $tokyo;?> 
神奈川：<?php echo $kanagawa;?> 
新潟：<?php echo $niigata;?> 
富山：<?php echo $toyama;?> 
石川：<?php echo $ishikawa;?> 
福井：<?php echo $fukui;?> 
山梨：<?php echo $yamanashi;?> 
長野：<?php echo $nagano;?> 
岐阜：<?php echo $gifu;?> 
静岡：<?php echo $shizuoka;?> 
愛知：<?php echo $aichi;?> 
三重：<?php echo $mie;?> 
滋賀：<?php echo $shiga;?> 
京都：<?php echo $kyoto;?> 
大阪：<?php echo $osaka;?> 
兵庫：<?php echo $hyogo;?> 
奈良：<?php echo $nara;?> 
和歌山：<?php echo $wakayama;?> 
鳥取：<?php echo $tottori;?> 
島根：<?php echo $shimane;?> 
岡山：<?php echo $okayama;?> 
広島：<?php echo $hiroshima;?> 
山口：<?php echo $yamaguchi;?> 
徳島：<?php echo $tokushima;?> 
香川：<?php echo $kagawa;?> 
愛媛：<?php echo $ehime;?> 
高知：<?php echo $kochi;?> 
福岡：<?php echo $fukuoka;?> 
佐賀：<?php echo $saga;?> 
長崎：<?php echo $nagasaki;?> 
熊本：<?php echo $kumamoto;?> 
大分：<?php echo $oita;?> 
宮崎：<?php echo $miyazaki;?> 
鹿児島：<?php echo $kagoshima;?> 
沖縄：<?php echo $okinawa;?> 

<?php $this->load->view('pc/mail/signature');?>
