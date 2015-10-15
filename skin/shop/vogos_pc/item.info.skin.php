<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 상품 정보 시작 { -->
<section id="sit_ov_inf">

    <ul id="sit_ov_tab">
        <li class="product_inf active">
            <h3><a href="#product_inf_v">Product Info</a></h3>
        </li>
        <li class="delivery_inf">
            <h3><a href="#delivery_inf_v">Delivery Info</a></h3>
        </li>
        <li class="returns_inf">
            <h3><a href="#returns_inf_v">Returns Info</a></h3>
        </li>
    </ul>
    <div id="product_inf_v" class="tab_div active">
        <p><?php echo conv_content($it['it_explan'], 1); ?></p>
        <?php
        if ($it['it_info_value']) { // 상품 정보 고시
            $info_data = unserialize(stripslashes($it['it_info_value']));
            if(is_array($info_data)) {
                $gubun = $it['it_info_gubun'];
                $info_array = $item_info[$gubun]['article'];
        ?>
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
    </div>
    <div id="delivery_inf_v" class="tab_div">
    <?php if ($default['de_baesong_content']) { // 배송정보 내용이 있다면 ?>
        <?php echo conv_content($default['de_baesong_content'], 1); ?>
    <?php } ?>
    </div>
    <div id="returns_inf_v" class="tab_div">
    <?php if ($default['de_change_content']) { // 교환/반품 내용이 있다면 ?>
        <?php echo conv_content($default['de_change_content'], 1); ?>
    <?php } ?>
    </div>

</section>
<!-- } sit_ov_inf END -->

<script>
$(window).on("load", function() {
    $("#sit_inf_explan").viewimageresize2();
});

$(function() {
    var $tabList = $('#sit_ov_tab > li');
    $tabList.each(function() {
        var tabName = null;
        $(this).click(function(e) {
            e.preventDefault();
            if(!$(this).hasClass('active')) {
                tabName = $(this).attr('class');
                $tabList.removeClass('active');
                $(this).addClass('active');
                showTabNav(tabName);
            }
        });
    });

    function showTabNav(tabName) {
        if($('.tab_div').hasClass('active')) {
            $('.tab_div').removeClass('active');
        }
        $('#' + tabName + '_v').addClass('active');
    }
});
</script>