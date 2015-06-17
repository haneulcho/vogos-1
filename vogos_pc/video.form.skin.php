<?php
$it_id = trim($row['it_id']);
// 상품품절체크
if(G5_SOLDOUT_CHECK)
    $is_soldout = is_soldout($row['it_id']);

// 주문가능체크
$is_orderable = true;
if(!$row['it_use'] || $row['it_tel_inq'] || $is_soldout)
    $is_orderable = false;

if($is_orderable) {
    // 선택 옵션
    $option_item = get_item_options($row['it_id'], $row['it_option_subject']);

    // 추가 옵션
    $supply_item = get_item_supply($row['it_id'], $row['it_supply_subject']);

    // 상품 선택옵션 수
    $option_count = 0;
    if($row['it_option_subject']) {
        $temp = explode(',', $row['it_option_subject']);
        $option_count = count($temp);
    }

    // 상품 추가옵션 수
    $supply_count = 0;
    if($row['it_supply_subject']) {
        $temp = explode(',', $row['it_supply_subject']);
        $supply_count = count($temp);
    }
}
// 고객선호도 별점수
$star_score = get_star_image($row['it_id']);
// 소셜 관련
$sns_title = get_text($row['it_name']).' | '.get_text($config['cf_title']);
$sns_url  = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
?>
<div class="btn_video">View Video</div>
    <div class="modal_info">
        <?php
            // 확장변수 있을 경우 비디오 삽입
            echo "<video controls=\"controls\"><source src=\"".$row['it_1']."\" type=\"video/mp4\"></video>";
        ?>
        <div class="vsit_ov_wrap">
            <!-- 상품 요약정보 및 구매 시작 { -->
            <section id="v<?php echo $row[it_id] ?>" class="vsit_ov">
                <h2 class="sit_title"><?php echo stripslashes($row['it_name']); ?></h2>
                <p class="sit_desc"><?php if ($this->view_it_basic && $row['it_basic']) { echo $row['it_basic']; } ?></p>

                <div class="sit_star_sns">
                    <?php if ($star_score) { ?>
                    고객평점 <span>별<?php echo $star_score?>개</span>
                    <img src="<?php echo G5_SHOP_URL; ?>/img/s_star<?php echo $star_score?>.png" alt="" class="sit_star">
                    <?php } ?>
                    <?php echo get_sns_share_link('facebook', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/sns_fb_s.png');
                echo get_sns_share_link('twitter', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/sns_twt_s.png');
                echo get_sns_share_link('googleplus', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/sns_goo_s.png'); ?>
                </div>
                <!-- 총 구매액 -->
                <div class="sit_tot_price"><?php echo display_price(get_price($row)); ?></div>

                <?php if($is_soldout) { ?>
                <p class="sit_ov_soldout">상품의 재고가 부족하여 구매할 수 없습니다.</p>
                <?php } ?>

                <div class="sit_ov_btn">
                    <?php if ($is_orderable) { ?>
                    <a href="<?php echo "{$this->href}{$row['it_id']}" ?>" class="sit_btn_more">SEE MORE…</a>
                    <?php } ?>
                    <a href="javascript:vitem_wish('<?php echo $it_id; ?>');" class="sit_btn_wish">ADD TO WISHLIST ♥</a>
                </div>
            </section>
            <!-- } 상품 요약정보 및 구매 끝 -->
        </div> <!-- vsit_ov_wrap END -->
    </div> <!-- modal_info END -->
</div><!-- .sct_img END -->