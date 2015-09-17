<?php
include_once('./_common.php');
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

    $sql = " select *
                from {$g5['g5_shop_models_table']} where mds_use = '1'                
                order by mds_id desc
                limit 5";
    $result = sql_query($sql);
?>

<div class="owl-carousel mdschoice">
<?php
for ($i=0; $row=sql_fetch_array($result); $i++) {
?>
    <div class="item">
        <div class="slider_img">
            <a href="<?php echo G5_SHOP_URL.'/models.php?mds_id='.$row['mds_id'] ?>" class="sct_a"><?php echo '<img src="'.G5_DATA_URL.'/models/'.$row['mds_id'].'_b" width="280">'; ?></a>
        </div>
        <div class="slider_txt">
            <a href="<?php echo G5_SHOP_URL.'/models.php?mds_id='.$row['mds_id'] ?>" class="sct_a"><?php echo $row['mds_subject'] ?></a>
        </div>
    </div>
<?php
}


if($i == 0) echo "<p class=\"sct_noitem\">등록된 모델스초이스 상품이 없습니다.</p>\n";
?>
</div>

<script>
$(function() {
    var owl40 = $('.mdschoice');
    owl40.owlCarousel({
        items: 4,
        loop: true,
        margin: 20,
        autoplay: true,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,
        autoplaySpeed: 800,
        smartSpeed: 500,
        dotsSpeed: 800
    });
});
</script>