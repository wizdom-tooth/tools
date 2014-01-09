<?php //var_dump($sum);?>

<script type='text/javascript'>

google.load('visualization', '1', {packages:['table']});
google.setOnLoadCallback(initializer);

// chart options
var table_option = {
    allowHtml: true,
    width: '782px',
};

// sum data table
var sum = {
<?php
$kinds = array_keys($sum);
foreach ($kinds as $kind)
{
    // 種別別集計表テーブル定義
    if ( ! empty($sum[$kind]))
    {
        $js_array_str = "['".implode("','", $sum[$kind])."']";
        echo "".
            "${kind}:".
                "[".
                    "[".
                        "'年月',".
                        "'予算',".
                        "'紹介',".
                        "'実績',".
                        "'達成率',".
                        "'成約率'".
                    "],".
                    $js_array_str.
                "],\n";
    }
}
?>
}

function initializer(){
    // テーブル描画
    drawChart();
    // 右カラムの追跡
    $('#right').containedStickyScroll({
        duration: 150,
        closeChar: 'ついてくんな！'
    });
    // タブ
    $('#tabs').tabs();
    // 集計結果が0のセルをグレイアウト
    $('.google-visualization-table-td').each(function(i){
        if ($(this).text() == "0") {
            $(this).css("background-color", "#D3D3D3");
        }
    });
}

// draw table
function drawChart(){
    <?php if ( ! empty($sum)):?>
        $('.no_addup').hide();
        <?php $kinds = array_keys($sum);?>
        <?php foreach ($kinds as $kind):?>
            <?php if ( ! empty($sum[$kind])):?>
                var data = google.visualization.arrayToDataTable(sum['<?php echo $kind;?>']);
                var table = new google.visualization.Table(document.getElementById('table_<?php echo $kind;?>'));
                table.draw(data, table_option);
                //$('#div_<?php echo $kind;?>').show();
            <?php endif;?>
        <?php endforeach;?>
    <?php endif;?>
    //$('#div_user').show();
}
</script>

<!--target date-->
<h2>月次集計表<?php
if ($year !== '')  echo ' - ' . $year;
if ($month !== '') echo ' / ' . $month;
?></h2>

<!--table area-->
<div class="box" id="table_wrapper">
<div id="tabs">
<ul>
<li><a href="#tabs-1">サービス別内訳</a></li>
<li><a href="#tabs-2">担当者別内訳</a></li>
</ul>
<div id="tabs-1">
<span class="no_addup">まだ集計が完了していません</span>

<div id="div_total">
<h3 class="label_yellow">契約全体</h3>
<div id="table_total"></div>
</div>
<div id="div_complete">
<h3 class="label_blue">完成</h3>
<div id="table_complete"></div>
</div>
<div id="div_flets">
<h3 class="label_skyblue">フレッツ契約内訳</h3>
<div id="table_flets"></div>
</div>
<div id="div_other">
<h3 class="label_green">その他契約</h3>
<div id="table_other"></div>
</div>

<h3 class="label_orange">ISP</h3>
<div id="div_isp_total">
<h2>合計</h2>
<div id="table_isp_total"></div>
</div>
<div id="div_isp_biglobe">
<h2>BIGLOBE</h2>
<div id="table_isp_biglobe"></div>
</div>
<div id="div_isp_ocn">
<h2>OCN</h2>
<div id="table_isp_ocn"></div>
</div>
<div id="div_isp_yahoo">
<h2>YAHOO</h2>
<div id="table_isp_yahoo"></div>
</div>

<h3 class="label_pink">移転関連</h3>
<div id="div_iten">
<h2>移転</h2>
<div id="table_iten"></div>
</div>
<div id="div_iten_with_isp">
<h2>移転同時ISP</h2>
<div id="table_iten_with_isp"></div>
</div>
<div id="div_only_isp">
<h2>ISPのみ</h2>
<div id="table_only_isp"></div>
</div>

<h3 class="label_purple">ひかり電話</h3>
<div id="div_hikari_tel_total">
<h2>合計</h2>
<div id="table_hikari_tel_total"></div>
</div>
<div id="div_hikari_tel_plan_base">
<h2>基本プラン</h2>
<div id="table_hikari_tel_plan_base"></div>
</div>
<div id="div_hikari_tel_plan_anshin">
<h2>安心プラン</h2>
<div id="table_hikari_tel_plan_anshin"></div>
</div>
<div id="div_hikari_tel_plan_anshin_more">
<h2>もっと安心プラン</h2>
<div id="table_hikari_tel_plan_anshin_more"></div>
</div>
<div id="div_hikari_tel_plan_a">
<h2>A(エース)</h2>
<div id="table_hikari_tel_plan_a"></div>
</div>

<h3 class="label_green">オプション</h3>
<div id="div_option_virus">
<h2>ウイルスクリア</h2>
<div id="table_option_virus"></div>
</div>
<div id="div_option_remote">
<h2>リモートサポート</h2>
<div id="table_option_remote"></div>
</div>
<div id="div_option_hikari_tv_pa">
<h2>光TV（パー）</h2>
<div id="table_option_hikari_tv_pa"></div>
</div>
<div id="div_option_hikari_tv">
<h2>光TV</h2>
<div id="table_option_hikari_tv"></div>
</div>
<div id="div_option_hikari_portable">
<h2>光ポータブル</h2>
<div id="table_option_hikari_portable"></div>
</div>

<h3 class="label_skyblue">電力系・光ファイバ</h3>
<div id="div_e_hikari_fiber_kddi">
<h2>KDDI</h2>
<div id="table_e_hikari_fiber_kddi"></div>
</div>
<div id="div_e_hikari_fiber_ucom">
<h2>UCOM</h2>
<div id="table_e_hikari_fiber_ucom"></div>
</div>

<h3 class="label_skyblue">モバイル・ADSL</h3>
<div id="div_mobile_adsl_emobile">
<h2>Eモバイル</h2>
<div id="table_mobile_adsl_emobile"></div>
</div>
<div id="div_mobile_adsl_eaccess">
<h2>Eアクセス</h2>
<div id="table_mobile_adsl_eaccess"></div>
</div>
<div id="div_mobile_adsl_yahoobb">
<h2>YAHOO BB</h2>
<div id="table_mobile_adsl_yahoobb"></div>
</div>

<h3 class="label_skyblue">CATV</h3>
<div id="div_catv_itiscom">
<h2>イッツコム</h2>
<div id="table_catv_itiscom"></div>
</div>
<div id="div_catv_jcnyokohama">
<h2>JCNよこはま</h2>
<div id="table_catv_jcnyokohama"></div>
</div>
</div>

<div id="tabs-2">
<span class="no_addup">まだ集計が完了していません</span>
<div id="div_user">
<h3 class="label_blue">担当者別集計</h3>
<div id="table_user"></div>
</div>
</div>

</div><!--tabs-->
</div><!--table_wrapper-->

<!--right area-->
<div class="box_solid" id="right">
<div class="space_20"></div>
<form name="addup_monthly_search" id="addup_monthly_search" method="get" action="/addup_monthly/index.html">
<?php $selected = ($this->input->get('year')) ? $this->input->get('year') : ''; ?>
<?php echo form_dropdown('year', $form_year, $selected); ?>年
<?php $selected = ($this->input->get('month')) ? $this->input->get('month') : ''; ?>
<?php echo form_dropdown('month', $form_month, $selected); ?>月<br />
<div class="space_10"></div>
<?php $selected = ($this->input->get('channel')) ? $this->input->get('channel') : ''; ?>
<?php echo form_dropdown('channel', $form_channel, $selected); ?><br />
<div class="space_10"></div>
<input type="submit" />
</form>
</div>

<div class="clear"></div>
