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
            <div id="product_inf_v" class="tab_div active">
                <p><?php echo conv_content($it['it_explan'], 1); ?></p>
            </div>
        </li>
        <li class="delivery_inf">
            <h3><a href="#delivery_inf_v">Delivery Info</a></h3>
            <div id="delivery_inf_v" class="tab_div">
            <?php if ($default['de_baesong_content']) { // 배송정보 내용이 있다면 ?>
                <?php echo conv_content($default['de_baesong_content'], 1); ?>
            <?php } ?>
            </div>
        </li>
        <li class="returns_inf">
            <h3><a href="#returns_inf_v">Returns Info</a></h3>
            <div id="returns_inf_v" class="tab_div">
            <?php if ($default['de_change_content']) { // 교환/반품 내용이 있다면 ?>
                <?php echo conv_content($default['de_change_content'], 1); ?>
            <?php } ?>
            </div>
        </li>
    </ul>

</section>
<!-- } sit_ov_inf END -->

<script>
$(window).on("load", function() {
    $("#sit_inf_explan").viewimageresize2();
});
</script>