<?php

$url = array(
	'flets_login'  => 'https://hikariweb.ntt-east.co.jp/login.php',
	'flets_search' => 'https://msearch.ntt-east.co.jp/msearch/search.php',
	'au'           => 'http://www2.auhikari.jp/CGI/search/search.cgi',
	'spaaqs'       => 'http://hikari.spaaqs.ne.jp/mod/main/act/searchmulti/',
	'jcom'         => 'http://www.jcom.co.jp/information/room/mdu_search.php',
	'jcn'          => 'http://jcntv.jp/mansion/result_zip.php',
	'flets_nishi'  => 'https://flets-w.com/cart/index.php',
	'commufa'      => 'http://www.commufa.jp/cgi-bin/apartment/ap.cgi',
	'starcat'      => 'http://web2.starcat.co.jp/search/',
	'greencity'    => 'http://www.gctv.co.jp/other/tvnet/index.html',
	'himawari'     => 'http://www.himawari.co.jp/thinking/area/',
	'eo_hikari'    => 'http://eonet.jp/area/mansion.html',
	'bbiq'         => 'http://www2.info-mapping.com/qtnet/map/mn-listzip.asp',
);

$tel_flets_nishi = array();
if ($east_or_west === 'west')
{
	switch($prefcode)
	{
		case '16': // 富山
		case '17': // 石川
		case '18': // 福井
			$tel_flets_nishi[] = '(北陸) 0120-494-948';
			break;
		case '22': // 静岡
			$tel_flets_nishi = array(
				'(静岡1) 0120-527-202',
				'(静岡2) 0120-928-338',
			);
			break;
		case '21': // 岐阜
		case '23': // 愛知
		case '24': // 三重
			$tel_flets_nishi[] = '(東海) 0120-243-937';
			break;
		case '25': // 滋賀
		case '26': // 京都
		case '27': // 大阪
			if ($is_osaka)
			{
				$tel_flets_nishi[] = '(大阪北) 0120-817-303';
			}
			if ($is_osaka_east)
			{
				$tel_flets_nishi[] = '(大阪東) 0120-817-571';
			}
			if ($is_osaka_south)
			{
				$tel_flets_nishi[] = '(大阪南) 0120-817-234';
			}
			break;
		case '28': // 兵庫
			$tel_flets_nishi[] = '(兵庫) 0120-666-612';
			break;
		case '29': // 奈良
			$tel_flets_nishi[] = '(奈良) 0120-027-484';
			break;
		case '30': // 和歌山
			$tel_flets_nishi[] = '(和歌山) 0120-817-303';
			break;
		case '31': // 鳥取
			$tel_flets_nishi[] = '(鳥取) 0120-475-701';
			break;
		case '32': // 島根
		case '34': // 広島
			$tel_flets_nishi[] = '(中国：広島/島根) 0120-105-028';
			break;
		case '33': // 岡山
		case '35': // 山口
			$tel_flets_nishi[] = '(中国：岡山/山口) 0120-928-142';
			break;
		case '36': // 徳島
		case '37': // 香川
		case '38': // 愛媛
		case '39': // 高知
			$tel_flets_nishi[] = '(四国) 0120-519-121';
			break;
		case '40': // 福岡
		case '41': // 佐賀
		case '42': // 長崎
			$tel_flets_nishi[] = '(九州：福岡/佐賀/長崎) 0120-846-009';
			break;
		case '43': // 熊本
			$tel_flets_nishi[] = '(熊本) 0120-494-304';
			break;
		case '44': // 大分
			$tel_flets_nishi[] = '(大分) 0120-335-270';
			break;
		case '45': // 宮崎
		case '46': // 鹿児島
			$tel_flets_nishi[] = '(九州：宮崎/鹿児島) 0120-027-597';
			break;
		case '47': // 沖縄
			$tel_flets_nishi[] = '(沖縄) 0120-751-939';
			break;
	}
}
?>

<div id="form_manken">
<form action="" method="get">
郵便番号 or 住所：<input type="text" name="query" value="<?php echo $query;?>" size="40"/>
<span>※全半角は不問です。入力後にEnterキーを押してください。</span>
</form>

<?php if ($is_success === FALSE):?>
<span id="red">当該キーワードでは有効な郵便番号情報が見つかりませんでした。郵便番号を識別できるキーワードを入力して下さい。</span>

<?php else:?>
<?php if ($address != ''):?>
<hr />
郵便番号：<?php echo $zip1.'-'.$zip2;?><br />
住所：<?php echo $searched_address;?><br />

<?php endif;?>
</div><!--form_manken-->


<?php if ($address != ''):?>
<div id="loading_must"><img src="/assets/wiz/img/loading.gif"/></div>
<div id="remote_src">


<!--フレッツ光-->
<div id="flets_box">
<h3 class="accordion_head label_blue">・フレッツ光</h3>
<div>
<iframe name="iframe_flets" class="iframe_box" id="iframe_flets"></iframe>
<form style="display:none" target="iframe_flets" id="form_iframe_flets_login" method="post" action="<?php echo $url['flets_login'];?>">
<input type="hidden" name="id" value="1001181152" />
<input type="hidden" name="password" value="wizp1312" />
</form>
<form style="display:none" target="iframe_flets" id="form_iframe_flets_search" method="post" action="<?php echo $url['flets_search'];?>">
<input type="hidden" value="zipcode" name="skind">
<input type="hidden" name="zip" value="<?php echo $zip1.$zip2;?>" />
</form>
</div>
</div>


<!--flets nishi-->
<div id="flets_nishi_box">
<h3 class="accordion_head label_blue">・フレッツ西</h3>
<div>
ごめんね。自動入力はサポートしてないよ。手入力して検索してね。<br />
郵便番号：<?php echo $zip1.' '.$zip2;?><br />
<?php if (count($tel_flets_nishi) > 1):?>
<span id="red">電話番号の候補が複数存在します</span><br />
<?php endif;?>
<?php foreach ($tel_flets_nishi as $tel):?>
<span class="tel"><?php echo $tel;?></span><br />
<?php endforeach;?>
<iframe name="iframe_flets_nishi" class="iframe_box" id="iframe_flets_nishi"></iframe>
<form style="display:none" target="iframe_flets_nishi" id="form_iframe_flets_nishi" method="get" action="<?php echo $url['flets_nishi'];?>">
</form>
</div>
</div>


<!--auひかり-->
<div id="au_box">
<h3 class="accordion_head label_blue">・auひかり</h3>
<div>
エラーになる場合は、<a href="http://www2.auhikari.jp/search_mansion/index.html" target="iframe_au">コチラ</a>から検索してください。<br />
<iframe name="iframe_au" class="iframe_box" id="iframe_au"></iframe>
<form style="display:none" target="iframe_au" id="form_iframe_au" method="post" action="<?php echo $url['au'];?>">
<input type="hidden" value="add_01" name="mode">
<input type="hidden" value="0" name="entry_kbn">
<input type="hidden" value="00" name="list_kbn">
<input type="hidden" value="602021NT0000831" name="entry_cd">
<input type="hidden" value="" name="dummy_tel_flg">
<input type="hidden" value="" name="cmp">
<input type="hidden" value="1" name="ck">
<input type="hidden" value="1" name="housiong_id">
<input type="hidden" value="0" name="cust_kbn">
<input type="hidden" value="" name="consul">
<input type="hidden" value="" name="ziphp">
<input type="hidden" value="" name="list">
<input type="hidden" value="<?php echo $zip1;?>" name="zip1">
<input type="hidden" value="<?php echo $zip2;?>" name="zip2">
</form>
</div>
</div>


<!--spaaqs-->
<div id="spaaqs_box">
<h3 class="accordion_head label_blue">・spaaqs</h3>
<div>
<iframe name="iframe_spaaqs" class="iframe_box" id="iframe_spaaqs"></iframe>
<form style="display:none" target="iframe_spaaqs" id="form_iframe_spaaqs" method="get" action="<?php echo $url['spaaqs'];?>">
<input type="hidden" value="2" name="buildType">
<input type="hidden" value="<?php echo $zip1;?>" name="z1">
<input type="hidden" value="<?php echo $zip2;?>" name="z2">
</form>
</div>
</div>


<!--commufa-->
<div id="commufa_box">
<h3 class="accordion_head label_blue">・コミュファ</h3>
<div>
<iframe name="iframe_commufa" class="iframe_box" id="iframe_commufa"></iframe>
<form style="display:none" target="iframe_commufa" id="form_iframe_commufa" method="get" action="<?php echo $url['commufa'];?>">
<input type="hidden" value="syu" name="jutaku">
<input type="hidden" value="2" name="op_select">
<input type="hidden" value="n" name="donyu">
<input type="hidden" value="<?php echo $zip1;?>" name="app_zip1">
<input type="hidden" value="<?php echo $zip2;?>" name="app_zip2">
</form>
</div>
</div>


<!--starcat-->
<div id="starcat_box">
<h3 class="accordion_head label_blue">・スターキャット</h3>
<div>
<iframe name="iframe_starcat" class="iframe_box" id="iframe_starcat"></iframe>
<form style="display:none" target="iframe_starcat" id="form_iframe_starcat" method="get" action="<?php echo $url['starcat'];?>">
<input type="hidden" value="zip" name="mode">
<input type="hidden" value="1" name="result">
<input type="hidden" value="<?php echo $zip1;?>" name="zip1">
<input type="hidden" value="<?php echo $zip2;?>" name="zip2">
</form>
</div>
</div>


<!--greencity-->
<div id="greencity_box">
<h3 class="accordion_head label_blue">・グリーンシティケーブル</h3>
<div>
<iframe class="iframe_box" id="iframe_greencity" src="<?php echo $url['greencity'];?>"></iframe>
</div>
</div>


<!--himawari-->
<div id="himawari_box">
<h3 class="accordion_head label_blue">・ひまわりネットワーク</h3>
<div>
<iframe class="iframe_box" id="iframe_himawari" src="<?php echo $url['himawari'];?>"></iframe>
</div>
</div>


<!--eo光-->
<div id="eo_hikari_box">
<h3 class="accordion_head label_blue">・eo光</h3>
<div>
ごめんね。自動入力はサポートしてないよ。手入力して検索してね。<br />
郵便番号：<?php echo $zip1.' '.$zip2;?><br />
<iframe name="iframe_eo_hikari" class="iframe_box" id="iframe_eo_hikari"></iframe>
<form style="display:none" target="iframe_eo_hikari" id="form_iframe_eo_hikari" method="get" action="<?php echo $url['eo_hikari'];?>">
</form>
</div>
</div>


<!--BBIQ-->
<div id="bbiq_box">
<h3 class="accordion_head label_blue">・BBIQ</h3>
<div>
<iframe name="iframe_bbiq" class="iframe_box" id="iframe_bbiq"></iframe>
<form style="display:none" target="iframe_bbiq" id="form_iframe_bbiq" method="get" action="<?php echo $url['bbiq'];?>">
<input type="hidden" value="<?php echo $zip1;?>" name="zip1">
<input type="hidden" value="<?php echo $zip2;?>" name="zip2">
</form>
</div>
</div>


<!--jcom jcn-->
<button type="button" id="jcom_jcn_button">JCOM ＆ JCN も検索する</button>
<div id="loading_jcom_jcn">
※少し待っても読み込まない時は、もう一度押して下さい。<br />
<img src="/assets/wiz/img/loading.gif"/>
</div>

<div id="jcom_box"><!--jcom-->
<h3 class="accordion_head label_blue">・jcom</h3>
<div>
<iframe name="iframe_jcom" class="iframe_box" id="iframe_jcom"></iframe>
<form style="display:none" target="iframe_jcom" id="form_iframe_jcom" method="get" action="<?php echo $url['jcom'];?>">
<input type="hidden" value="zip" name="search_type">
<input type="hidden" value="<?php echo $zip1;?>" name="zipcode1">
<input type="hidden" value="<?php echo $zip2;?>" name="zipcode2">
</form>
</div>
</div>

<div id="jcn_box"><!--jcn-->
<h3 class="accordion_head label_blue">・jcn</h3>
<div>
<iframe name="iframe_jcn" class="iframe_box" id="iframe_jcn"></iframe>
<form style="display:none" target="iframe_jcn" id="form_iframe_jcn" method="get" action="<?php echo $url['jcn'];?>">
<input type="hidden" value="<?php echo $zip1.$zip2;?>" name="zip">
</form>
</div>
</div>


</div><!--remote_src-->


<script type="text/javascript">
<!--

// フレッツ光ログインしてから検索
$("#form_iframe_flets_login").bind('submit', function(){
	$("#iframe_flets").one('load', function(){
		$("#form_iframe_flets_search").submit();
	});
});

$(document).ready(function(){
    $('.accordion_head').click(function() {
        $(this).next().slideToggle();
    }).next().hide();
	$("#form_iframe_au").submit();
	$("#au_box").show();
	$("#form_iframe_spaaqs").submit();
	$("#spaaqs_box").show();
	if ("<?php echo $east_or_west;?>" == "east") {
		$("#form_iframe_flets_login").submit();
		$("#flets_box").show();
	} else {
		$("#form_iframe_flets_nishi").submit();
		$("#flets_nishi_box").show();
	}
	switch ("<?php echo $prefcode;?>") {
		// コミュファ
		case '23': // 愛知の場合は地域によって更に下記を追加
			<?php if ($is_aichi_starcat === TRUE): // スターキャット?>
			$("#form_iframe_starcat").submit();
			$("#starcat_box").show();
			<?php elseif ($is_aichi_greencity === TRUE): // グリーンシティケーブル?>
			$("#greencity_box").show();
			<?php elseif ($is_aichi_himawari === TRUE): // ひまわりネットワーク?>
			$("#himawari_box").show();
			<?php endif;?>
		case '21': // 岐阜
		case '22': // 静岡
		case '24': // 三重
			$("#form_iframe_commufa").submit();
			$("#commufa_box").show();
			break;
		// eo光
		case '18': // 福井
		case '25': // 滋賀
		case '26': // 京都
		case '27': // 大阪
		case '28': // 兵庫
		case '29': // 奈良
		case '30': // 和歌山
			$("#form_iframe_eo_hikari").submit();
			$("#eo_hikari_box").show();
			break;
		// BBIQ
		case '40': // 福岡
		case '41': // 佐賀
		case '42': // 長崎
		case '43': // 熊本
		case '44': // 大分
		case '45': // 宮崎
		case '46': // 鹿児島
			$("#form_iframe_bbiq").submit();
			$("#bbiq_box").show();
			break;
	}
	$("#loading_must").show();
	$(window).load(function(){
		$("#loading_must").fadeOut(function(){
			$("#remote_src").show();
		});
    });
});

$("#jcom_jcn_button").click(function(){
	$("#form_iframe_jcom").submit().delay(1500);
	$("#form_iframe_jcn").submit();
	$("#loading_jcom_jcn").show();
	$("#iframe_jcom").load(function(){
		$("#iframe_jcn").load(function(){
			$("#loading_jcom_jcn").fadeOut(function(){
				$("#jcom_jcn_button").hide();
				$("#jcom_box").show();
				$("#jcn_box").show();
			});
		});
    });
});
//-->
</script>

<?php endif;?>
<?php endif;?>
