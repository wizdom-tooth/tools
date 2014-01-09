<script type="text/javascript">
<!--
/* {{{ jquery extensiton regex */
jQuery.expr[':'].regex = function(elem, index, match) {
    var matchParams = match[3].split(','),
        validLabels = /^(data|css):/,
        attr = {
            method: matchParams[0].match(validLabels) ? 
                        matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels,'')
        },
        regexFlags = 'ig',
        regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
    return regex.test(jQuery(elem)[attr.method](attr.property));
}
/* }}} */
/* {{{ jquery bussines logic */
function sum_quarter()
{
    var quarter_blocks = {
        0 : '0-2',
        1 : '3-5'
    }

    /**
     * クオーター毎に集計
     */
    for (var quarter_num in quarter_blocks) {
        var target_block = quarter_blocks[quarter_num];

        // 件数部分の集計
        var quarter_sum = {};
        $('input:regex(name, ^.*count.*_['+target_block+']$)').each(function(i){
            var val = $(this).val();
            var quarter_sum_name = $(this).attr('name').replace(/\d$/, quarter_num+'_sum');  ;
            var haskey = (quarter_sum_name in quarter_sum);
            if ( ! haskey) {
                quarter_sum[quarter_sum_name] = [];
            }
            quarter_sum[quarter_sum_name].push(parseInt(val));
        });
        for (var quarter_sum_name in quarter_sum) {
            var sum = 0;
            for (var i = 0; i < quarter_sum[quarter_sum_name].length; i++) sum += quarter_sum[quarter_sum_name][i];
            $('[name="'+quarter_sum_name+'"]').val(sum);
        }

        // 確率部分の平均
        var quarter_avg = {};
        $('input:regex(name, ^.*ratio.*_['+target_block+'].*$)').each(function(i){
            var val = $(this).val();
            var quarter_avg_name = $(this).attr('name').replace(/\d$/, quarter_num+'_sum');  ;
            var haskey = (quarter_avg_name in quarter_avg);
            if ( ! haskey) {
                quarter_avg[quarter_avg_name] = [];
            }
            quarter_avg[quarter_avg_name].push(parseFloat(val));
        });    
        for (var quarter_avg_name in quarter_avg) {
            var sum = 0;
            var length = quarter_avg[quarter_avg_name].length;
            for (var i = 0; i < length; i++) sum += quarter_avg[quarter_avg_name][i];
            var avg = Math.floor(sum / length);
            $('[name="'+quarter_avg_name+'"]').val(avg);
        }

        // 加工件数の集計
        var quarter_sum = {};
        $('span:regex(id, ^.*count.*_['+target_block+'].*$)').each(function(i){
            var val = $(this).text();
            var quarter_sum_name = $(this).attr('id').replace(/\d/, quarter_num+'_sum');  ;
            var haskey = (quarter_sum_name in quarter_sum);
            if ( ! haskey) {
                quarter_sum[quarter_sum_name] = [];
            }
            quarter_sum[quarter_sum_name].push(parseInt(val));
        });
        for (var quarter_sum_name in quarter_sum) {
            var sum = 0;
            for (var i = 0; i < quarter_sum[quarter_sum_name].length; i++) sum += quarter_sum[quarter_sum_name][i];
            $('#'+quarter_sum_name+'').text(sum);
        }

        var quarter_sum = {};
        $('span:regex(id, ^.*ratio.*_['+target_block+'].*$)').each(function(i){
            var val = $(this).text();
            var quarter_sum_name = $(this).attr('id').replace(/\d/, quarter_num+'_sum');  ;
            var haskey = (quarter_sum_name in quarter_sum);
            if ( ! haskey) {
                quarter_sum[quarter_sum_name] = [];
            }
            quarter_sum[quarter_sum_name].push(parseFloat(val));
        });
        for (var quarter_sum_name in quarter_sum) {
            var sum = 0;
            for (var i = 0; i < quarter_sum[quarter_sum_name].length; i++) sum += quarter_sum[quarter_sum_name][i];
            $('#'+quarter_sum_name+'').text(sum);
        }
    } 
}

function sum_month()
{
    /**
     * 月ブロック毎に処理
     */
    $('div:regex(id, ^block[0-8]$)').each(function(i)
    {
        var box_id = $(this).attr('id').substr(-1);

        // 紹介予算の合計算出
        var sum_introduction_id = 'sum_introduction_count_' + box_id;
        var sum_introduction_count = 0;
        $(this).find('tr[class="unit_introduction_count_' + box_id + '"]').each(function(j) {
            sum_introduction_count += parseInt($(this).find('.sum_target').val());
        });
        $('#' + sum_introduction_id).text(sum_introduction_count);

        // ----------------------------
        // フレッツ契約件数 * 各種比率 = 各種件数
        // ----------------------------

        var flets_contract_ratio = parseFloat($('[name="flets_contract_ratio___contract_ratio_' + box_id + '"]').val()) / 100;
        var flets_complete_ratio = parseFloat($('[name="flets_contract_ratio___complete_ratio_' + box_id + '"]').val()) / 100;

        // フレッツ契約数＆開通数
        var flets_contract_count = Math.round(sum_introduction_count * flets_contract_ratio);
        var flets_complete_count = Math.round(flets_contract_count * flets_complete_ratio);
        var flets_contract_count_id = 'flets_contract_ratio___contract_ratio_' + box_id + '_cooked';
        $('#' + flets_contract_count_id).text(flets_contract_count);
        var flets_complete_count_id = 'flets_contract_ratio___complete_ratio_' + box_id + '_cooked';
        $('#' + flets_complete_count_id).text(flets_complete_count);

        // ISPセット数
        var sum = 0;
        $(this).find('tr[class="unit_flets_isp_set_ratio_' + box_id + '"]').each(function(j) {
            var input = $(this).find('input');
            var flets_isp_set_count_id = input.attr('name') + '_cooked';
            var flets_isp_set_count    = Math.round(flets_contract_count * parseFloat(input.val()) / 100);
            sum += flets_isp_set_count;
            $('#' + flets_isp_set_count_id).text(flets_isp_set_count);
        });
        $('#sum_flets_isp_set_ratio_' + box_id).text(sum);

        // オプションセット数
        var sum = 0;
        $(this).find('tr[class="unit_flets_option_set_ratio_' + box_id + '"]').each(function(j) {
            var input = $(this).find('input');
            var flets_option_set_count_id = input.attr('name') + '_cooked';
            var flets_option_set_count    = Math.round(flets_contract_count * parseFloat(input.val()) / 100);
            sum += flets_option_set_count;
            $('#' + flets_option_set_count_id).text(flets_option_set_count);
        });
        $('#sum_flets_option_set_ratio_' + box_id).text(sum);

        // ----------------------------
        // フレッツ移転契約数＆セット数
        // ----------------------------

        var sum_iten_contract_count_id = 'sum_iten_contract_count_' + box_id;
        var sum_iten_contract_count = 0;
        $(this).find('tr[class="unit_iten_contract_count_' + box_id + '"]').each(function(j) {
            sum_iten_contract_count += parseInt($(this).find('.sum_target').val());
        });
        $('#' + sum_iten_contract_count_id).text(sum_iten_contract_count);

        var sum = 0;
        $(this).find('tr[class="unit_iten_isp_set_ratio_' + box_id + '"]').each(function(j) {
            var input = $(this).find('input');
            var iten_isp_set_count_id = input.attr('name') + '_cooked';
            var iten_isp_set_count    = Math.round(sum_iten_contract_count * parseFloat(input.val()) / 100);
            sum += iten_isp_set_count;
            $('#' + iten_isp_set_count_id).text(iten_isp_set_count);
        });
        $('#sum_iten_isp_set_ratio_' + box_id).text(sum);

        // ----------------------------
        // 契約数(その他回線) = 照会予算件数 * その他回線契約比率
        // ----------------------------

        var sum = 0;
        $(this).find('tr[class="unit_other_contract_ratio_' + box_id + '"]').each(function(j) {
            var input = $(this).find('input');
            var other_contract_count_id = input.attr('name') + '_cooked';
            var other_contract_count    = Math.round(sum_introduction_count * parseFloat(input.val()) / 100);
            sum += other_contract_count;
            $('#' + other_contract_count_id).text(other_contract_count);
        });
        $('#sum_other_contract_ratio_' + box_id).text(sum);

        // ----------------------------
        // 開通数(その他回線) = 契約数(その他回線) * その他回線開通比率
        // ----------------------------

        var sum = 0;
        $(this).find('tr[class="unit_other_complete_ratio_' + box_id + '"]').each(function(j) {
            var input = $(this).find('input');
            var other_complete_count_id = input.attr('name') + '_cooked';
            //var other_contract_count    = parseInt($('#' + other_complete_count_id.replace('contract', 'complete')).text());
            var other_contract_count    = parseInt($('#' + other_complete_count_id.replace('complete', 'contract')).text());
            var other_complete_count    = Math.round(other_contract_count * parseFloat(input.val()) / 100);
            sum += other_complete_count;
            $('#' + other_complete_count_id).text(other_complete_count);
        });
        $('#sum_other_complete_ratio_' + box_id).text(sum);

        // ----------------------------
        // ISPのみ
        // ----------------------------

        var onlyisp_contract_ratio = parseFloat($('[name="onlyisp_contract_ratio_contract_ratio_' + box_id + '"]').val()) / 100;
        var onlyisp_complete_ratio = parseFloat($('[name="onlyisp_contract_ratio_complete_ratio_' + box_id + '"]').val()) / 100;

        // 契約数＆開通数
        var onlyisp_contract_count = Math.round(sum_introduction_count * onlyisp_contract_ratio);
        var onlyisp_complete_count = Math.round(onlyisp_contract_count * onlyisp_complete_ratio);
        var onlyisp_contract_count_id = 'onlyisp_contract_ratio_contract_ratio_' + box_id + '_cooked';
        $('#' + onlyisp_contract_count_id).text(onlyisp_contract_count);
        var onlyisp_complete_count_id = 'onlyisp_contract_ratio_complete_ratio_' + box_id + '_cooked';
        $('#' + onlyisp_complete_count_id).text(onlyisp_complete_count);

        // ----------------------------
        // 特典施策
        // ----------------------------

        var benefit_contract_ratio = parseFloat($('[name="benefit_contract_ratio_contract_ratio_' + box_id + '"]').val()) / 100;
        var benefit_complete_ratio = parseFloat($('[name="benefit_contract_ratio_complete_ratio_' + box_id + '"]').val()) / 100;

        // 契約数＆開通数
        var benefit_contract_count = Math.round(sum_introduction_count * benefit_contract_ratio);
        var benefit_complete_count = Math.round(benefit_contract_count * benefit_complete_ratio);
        var benefit_contract_count_id = 'benefit_contract_ratio_contract_ratio_' + box_id + '_cooked';
        $('#' + benefit_contract_count_id).text(benefit_contract_count);
        var benefit_complete_count_id = 'benefit_contract_ratio_complete_ratio_' + box_id + '_cooked';
        $('#' + benefit_complete_count_id).text(benefit_complete_count);
    });
}

$(function() {
    /* 表示制御 */
    $('#tabs').tabs();
    $('.sum_area').each(function(i) {
        $(this).attr('disabled', 'disabled');
    });
    for (i = 0; i <= 7; i++){
        $('#title' + i).bind('click', {x:i}, function(e) {
            $('#block' + e.data.x).animate({width:'toggle'}, 'slow');
        });
    }
    for (i = 0; i <= 1; i++){
        $('#title' + i + '_sum').bind('click', {x:i}, function(e) {
            $('#block' + e.data.x + '_sum').animate({width:'toggle'}, 'slow');
        });
    }
    for (i = 0; i <= 1; i++){
        $('#box_title' + i).bind('click', {x:i}, function(e) {
            $('#box_block' + e.data.x).animate({height:'toggle'}, {duration:'slow', easing:'swing'});
        });
    }

    /* 計算処理 */
    sum_month();
    sum_quarter();
    $('input').change(function (){
        sum_month();
        sum_quarter();
    });
});
/* }}} */
-->
</script>

<style type="text/css">
<!--
/* {{{ style */
h1 {
    margin-top: 5px;
    background-color: #FF5F00;
}
td {
    padding-top: 3px;
    padding-left: 3px;
    padding-bottom: 3px;
}
#wrapper{
    width: 1240px;
}
#box_block0, #box_block1 {
    height: 1320px;
}
/*タイトル*/
#box_title0, #box_title1
{
    background-color: #FFA940;
    height: auto;
    width: 100%;
    text-align: center;
    font-weight: 900;
    font-size: 20px;
    margin-top: 2px;
    margin-bottom: 2px;
}

#title0, #title1, #title2,
#title3, #title4, #title5
{
    background-image: -moz-linear-gradient(bottom, #FFFBC7 0%, #C8A580 100%);
}

#title0_sum, #title1_sum
{
    background-image: -moz-linear-gradient(bottom, #FFF799 0%, #76421B 100%);
}

#title0, #title1, #title2,
#title3, #title4, #title5,
#title0_sum, #title1_sum
{
    float: left;
    width: 2%;
    height: 100%;
    color: #FFFFFF;
    text-align: center;
}
#title0:hover, #title1:hover, #title2:hover,
#title3:hover, #title4:hover, #title5:hover
{
    background-image: -moz-linear-gradient(bottom, #FFFBC7 0%, #FF4900 100%);
}
#title0_sum:hover, #title1_sum:hover,
#box_title0:hover, #box_title1:hover
{
    background-image: -moz-linear-gradient(bottom, #FFF799 0%, #FF4900 100%);
}

/*ブロック*/
#block0, #block1, #block2,
#block3, #block4, #block5,
#block0_sum, #block1_sum
{
    float: left;
    width: 23%;
    height: 100%;
}
#block0, #block1, #block2,
#block3, #block4, #block5
{
    background-color: #FFFBC7; /*薄イエロー*/
}
[id^="sum_"] {
    font-size: 15px;
    font-weight: bold;
    color: green;
}
[id$="_cooked"] {
    font-size: 12px;
    color: purple;
}
#block0_sum, #block1_sum
{
    background-color: #FFF799; /*薄オレンジ*/
}
/*テーブル*/
table.yosan_halfyear {
    width: 100%;
}
table.yosan_halfyear td {
    word-break: break-all;
    font-size: 10px;
    width: 33.3%;
}
table.yosan_halfyear input[type="text"] {
    -webkit-box-shadow: 0px 1px rgba(255, 255, 255, 0.5);
    -moz-box-shadow: 0px 1px rgba(255, 255, 255, 0.5);
    box-shadow: 0px 1px rgba(255, 255, 255, 0.5);
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    width: 35px;
    height: 15px;
}
table.yosan_halfyear input[class="sum_target"]:focus,
table.yosan_halfyear input[class=""]:focus
{
    border:solid 2px #FF4500;
}
.label_row {
    background-color: gray;
    color: #FFFFFF;
}
.sum_area {
    background-color: #FEECD2;
    color: red;
    font-weight: bold;
}
/* }}} */
-->
</style>


<h1><?php echo $halfyear_info['year'];?>年度 <?php echo $halfyear_info['halfyear_name'];?> - <?php echo $channel;?></h1>
<div id="wrapper">
<div id="tabs">

<!--tab menu-->
<?php
$tab_channels = array(
    'realestate_east',
    'realestate_west',
    'able_east',
    'able_west',
);
?>
<ul>
<?php foreach($tab_channels as $i => $tab_channel):?>
<li><a href="#tabs-<?php echo $i;?>"><?php echo $tab_channel;?></a></li>
<?php endforeach;?>
</ul>

<!--tab unit start-->
<?php foreach($tab_channels as $i => $tab_channel):?>
<div id="tabs-<?php echo $i;?>">


<form action="" method="post">
<input type="hidden" name="_channel" value="<?php echo $tab_channel;?>" />
<input type="submit" />


<?php $box_counter = 0;?>
<?php foreach($yosan_month_infos as $quarter_name => $q):?>
<div id="box_title_<?php echo $tab_channel;?>_<?php echo $box_counter;?>"><?php echo $quarter_name;?></div>
<div id="box_block_<?php echo $tab_channel;?>_<?php echo $box_counter;?>">


<!--月別エリア-->
<?php foreach($q as $i => $yosan_month_info):?>
<?php $view_id = $i + ($box_counter * 3);?>
<div id="title_<?php echo $tab_channel;?>_<?php echo $view_id;?>"><?php echo (int)substr($yosan_month_info['wiz_month_id'], 4, 2);?>月</div>
<div id="block_<?php echo $tab_channel;?>_<?php echo $view_id;?>">
<?php echo get_html_yosan_halfyear_table($yosan_month_info, $view_id);?>
</div>
<?php endforeach;?><!--//月別エリア-->


</form>


<!--クオータ合計エリア-->
<?php $sum_id = $box_counter.'_sum';?>
<div id="title_<?php echo $tab_channel;?>_<?php echo $sum_id;?>">
合計
</div>
<div id="block_<?php echo $tab_channel;?>_<?php echo $sum_id;?>">
<?php echo get_html_yosan_halfyear_table($yosan_month_info_for_sum, $sum_id);?>
</div><!--//クオータ合計エリア-->


<div style="clear: both;"></div>
</div>
<?php $box_counter++;?>
<?php endforeach;?>

</div><!--//tab unit end-->
<?php endforeach;?>

</div><!--//tabs end-->
</div><!--//wrapper end-->
