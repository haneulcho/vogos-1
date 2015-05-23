<?php
// 보안서버경로
if (G5_HTTPS_DOMAIN)
    $action_url = G5_HTTPS_DOMAIN.'/'.G5_SHOP_DIR.'/cartupdate.php';
else
    $action_url = './cartupdate.php';
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
<div class="btn_video">View Video</div></div>
<div class="modal_video">
    <div class="modal_info">
        <?php
            echo '<embed src="http://smarturl.it/jwplayer59" type="application/x-shockwave-flash" allowfullscreen="true" flashvars="skin=http://vogostest.cafe24.com/skin.swf&file="'.$row['it_1'].'"&type=video&autostart=true&repeat=always"/>';
        ?>

        <div id="vsit_ov_wrap">
            <!-- 상품 요약정보 및 구매 시작 { -->
            <section id="vsit_ov">
                <h2 id="sit_title"><?php echo stripslashes($row['it_name']); ?></h2>
                <p id="sit_desc"><?php echo $row['it_basic']; ?></p>

                <div id="sit_star_sns">
                    <?php if ($star_score) { ?>
                    고객평점 <span>별<?php echo $star_score?>개</span>
                    <img src="<?php echo G5_SHOP_URL; ?>/img/s_star<?php echo $star_score?>.png" alt="" class="sit_star">
                    <?php } ?>
                    <?php echo get_sns_share_link('facebook', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/sns_fb_s.png');
                echo get_sns_share_link('twitter', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/sns_twt_s.png');
                echo get_sns_share_link('googleplus', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/sns_goo_s.png'); ?>
                </div>
                <!-- 총 구매액 -->
                <div id="sit_tot_price"><?php echo display_price(get_price($row)); ?></div>

                <?php if($is_soldout) { ?>
                <p id="sit_ov_soldout">상품의 재고가 부족하여 구매할 수 없습니다.</p>
                <?php } ?>

                <div id="sit_ov_btn">
                    <?php if ($is_orderable) { ?>
                    <a href="<?php echo "{$this->href}{$row['it_id']}" ?>" class="sit_btn_more">SEE MORE…</a>
                    <?php } ?>
<form name="fitem<?php echo $row['it_id']; ?>" method="post" action="<?php echo G5_SHOP_URL; ?>/wishupdate.php">
<input type="hidden" name="it_id[]" value="<?php echo $it_id; ?>">
<input type="hidden" name="sw_direct">
<input type="hidden" name="url" value="<?php echo G5_SHOP_URL; ?>/wishupdate.php?it_id=<?php echo $it_id; ?>">
                    <a href="#" onclick="wish_item(this);" class="sit_btn_wish">ADD TO WISHLIST ♥</a>
</form>
                </div>
<script>
function wish_item(f){
    f.parentNode.submit();
    return false;
    //if(confirm(''))
}
</script>
            </section>
            <!-- } 상품 요약정보 및 구매 끝 -->
        </div>
    </div>
</div>