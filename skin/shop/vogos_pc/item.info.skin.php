<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<div id="info_content">

<ul id="tab_container">
    <li class="tab_detail active">Detail</li>
    <li class="tab_delivery">Delivery &amp; Return</li>
    <li class="tab_review">Review<span class="tab_count"><?php echo $item_use_count; ?></span></li>
    <li class="tab_qna">Q&amp;A<span class="tab_count"><?php echo $item_qa_count; ?></span></li>
</ul>

<div id="tab_detail" class="active">
    <!-- 상품 정보 시작 { -->
    <section id="sit_inf">
        <h2>상품 정보</h2>

        <?php if ($it['it_explan']) { // 상품 상세설명 ?>
        <h3>상품 상세설명</h3>
        <div id="sit_inf_explan">
            <?php echo conv_content($it['it_explan'], 1); ?>
        </div>
        <?php } ?>


        <?php
        if ($it['it_info_value']) { // 상품 정보 고시
            $info_data = unserialize(stripslashes($it['it_info_value']));
            if(is_array($info_data)) {
                $gubun = $it['it_info_gubun'];
                $info_array = $item_info[$gubun]['article'];
        ?>
        <h3>상품 정보 고시</h3>
        <table id="sit_inf_open">
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <?php
        foreach($info_data as $key=>$val) {
            $ii_title = $info_array[$key][0];
            $ii_value = $val;
        ?>
        <tr>
            <th scope="row"><?php echo $ii_title; ?></th>
            <td><?php echo $ii_value; ?></td>
        </tr>
        <?php } //foreach?>
        </tbody>
        </table>
        <!-- 상품정보고시 end -->
        <?php
            } else {
                if($is_admin) {
                    echo '<p>상품 정보 고시 정보가 올바르게 저장되지 않았습니다.<br>config.php 파일의 G5_ESCAPE_FUNCTION 설정을 addslashes 로<br>변경하신 후 관리자 &gt; 상품정보 수정에서 상품 정보를 다시 저장해주세요. </p>';
                }
            }
        } //if
        ?>

    </section>
    <!-- } 상품 정보 끝 -->
</div>
<div id="tab_delivery">
    <?php if ($default['de_baesong_content'] && $default['de_change_content']) { // 배송정보 내용이 있다면 ?>
    <!-- 배송 및 교환/반품 정보 시작 { -->
    <section id="sit_dvr">
        <h2>배송 및 교환/반품 안내</h2>
        <?php echo conv_content($default['de_baesong_content'], 1); ?>
        <?php echo conv_content($default['de_change_content'], 1); ?>
    </section>
    <!-- } 배송정보 끝 -->
    <?php } ?>
</div>
<div id="tab_review">
    <!-- 사용후기 시작 { -->
    <section id="sit_use">
        <h2>사용후기</h2>
        <div id="itemuse"><?php include_once('./itemuse.php'); ?></div>
    </section>
    <!-- } 사용후기 끝 -->
</div>
<div id="tab_qna">
    <!-- 상품문의 시작 { -->
    <section id="sit_qa">
        <h2>상품문의</h2>

        <div id="itemqa"><?php include_once('./itemqa.php'); ?></div>
    </section>
    <!-- } 상품문의 끝 -->
</div>

<?php if ($default['de_rel_list_use']) { ?>
<!-- 관련상품 시작 { -->
<section id="sit_rel">
    <h2>관련상품</h2>
    <div class="sct_wrap sct_rel">
        <?php
        $rel_skin_file = $skin_dir.'/'.$default['de_rel_list_skin'];
        if(!is_file($rel_skin_file))
            $rel_skin_file = G5_SHOP_SKIN_PATH.'/'.$default['de_rel_list_skin'];

        $sql = " select b.* from {$g5['g5_shop_item_relation_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id) where a.it_id = '{$it['it_id']}' and b.it_use='1' ";
        $list = new item_list($rel_skin_file, $default['de_rel_list_mod'], 0, $default['de_rel_img_width'], $default['de_rel_img_height']);
        $list->set_query($sql);
        echo $list->run();
        ?>
    </div>
</section>
<!-- } 관련상품 끝 -->
<?php } ?>

<script type="text/javascript">
$(function(){
    // 상품 상세보기 Tab Navigation Script
    var $tabContainer = $('body').find('#tab_container');
    var $tabList = $tabContainer.find('li');

    $tabList.each(function() {
        var types = null;
        if($(this).attr('class') == 'tab_detail active') {
            types = 'tab_detail';
        } else {
            types = $(this).attr('class');
        }
        $(this).click(function() {
            $tabList.removeClass('active');
            if(!$(this).hasClass('active')) {
                $(this).addClass('active');         
            }
            showTabNav(types);
        });
    });

    function showTabNav(types) {
        $('#' + types).addClass('active');
        switch(types){
            case 'tab_detail' :
                $('#tab_review, #tab_qna, #tab_delivery').removeClass('active');
            break;
            case 'tab_delivery' :
                $('#tab_detail, #tab_qna, #tab_review').removeClass('active');
            break;
            case 'tab_review' :
                $('#tab_detail, #tab_qna, #tab_delivery').removeClass('active');
            break;
            case 'tab_qna' :
                $('#tab_detail, #tab_review, #tab_delivery').removeClass('active');
            break;
        }
    };
}); // wrraped function END
</script>
</div> <!-- info_content END -->


<!--
<script>
$(window).on("load", function() {
    $("#sit_inf_explan").viewimageresize2();
});
</script> -->