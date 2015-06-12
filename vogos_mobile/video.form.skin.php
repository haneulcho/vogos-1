<script>
// list.20.skin(include video_m.php) Scripts
function view_video(vid){
    // Set Video Attribute
    var vid = '#'+vid;
    var vwrap = $(vid).parent('.sct_video');
    var videos = $(vid).children('video');
    var scrolled = vwrap.offset().top;
    $('body').animate({
        scrollTop: scrolled-100
    });
    vwrap.addClass('open');
    videos.get(0).play();
}
</script>

<div class="sct_video">
    <div id="video<?php echo $row[it_id] ?>">
        <video width="300" height="420" controls="controls">
            <source src="http://creativeinteractivemedia.com/player/videos/Big_Buck_Bunny_Trailer.mp4" type="video/mp4">
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