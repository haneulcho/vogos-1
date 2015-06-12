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
?>
<script>
// list.20.skin(include video_m.php) Scripts
/*$('.sct_video').click(function() {
    if ($(this).hasClass('active')) {
        $('video').each(function() {
            $(this).get(0).pause();
        });
        $('.sct_video').removeClass('active');
    }   
});*/
function view_video(vid){
    // Set Video Attribute
    var vid = '#'+vid;
    var vwrap = $(vid).parent('.sct_video');
    var videos = $(vid).children('video');
    var scrolled = vwrap.offset().top;
    $('body').animate({
        scrollTop: scrolled-100
    });
    if (vwrap.hasClass('active')) {
        videos.get(0).pause();
        vwrap.removeClass('active');
    } else {
        $('video').each(function() {
            $(this).get(0).pause();
        });
        $('.sct_video').removeClass('active');
        vwrap.addClass('active');
        videos.get(0).play();
    }
}
</script>

<div class="sct_video">
    <div id="video<?php echo $row[it_id] ?>">
        <video width="215" height="301" controls="controls">
            <source src="<?php echo $row[it_1] ?>" type="video/mp4">
        </video>
    </div> <!-- video END -->

    <div class="vsit_ov_wrap">
        <!-- 상품 요약정보 및 구매 시작 { -->
        <section id="v<?php echo $row[it_id] ?>" class="vsit_ov">
            <?php if($is_soldout) { ?>
            <p class="sit_ov_soldout">상품의 재고가 부족하여 구매할 수 없습니다.</p>
            <?php } ?>
            <div class="sit_ov_btn">
                <?php if ($is_orderable) { ?>
                <a href="<?php echo "{$this->href}{$row['it_id']}" ?>" class="sit_btn_more">SEE MORE…</a>
                <?php } ?>
            </div>
        </section>
        <!-- } 상품 요약정보 및 구매 끝 -->
    </div>
</div>