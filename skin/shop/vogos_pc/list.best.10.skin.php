<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>
<!-- Load owl carousel -->
<script src="<?php echo G5_SHOP_SKIN_URL; ?>/js/owl.carousel.min.js"></script>

<?php
if($this->total_count > 0) {
    $li_width = intval(100 / $this->list_mod);
    $li_width_style = ' style="width:'.$li_width.'%;"';
    $k = 1;

for ($i=1; $row=sql_fetch_array($result); $i++) {
    if ($i == 1) {
        echo "<div class=\"owl-carousel owlbest\">\n";
    }

    echo "<div class=\"item\">\n";

    if ($this->href) {
        echo "<div class=\"slider_img\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_img) {
        echo get_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes($row['it_name']))."\n";
    }

    if ($this->href) {
        echo "</a></div>\n";
    }

    if ($this->href) {
        echo "<div class=\"slider_txt\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_name) {
        echo stripslashes($row['it_name'])."\n";
    }

    if ($this->href) {
        echo "</a></div>\n";
    }

    echo "</div>\n";
} // for END

if ($i > 1) {
    echo "</div>\n";
}

if($i == 1) echo "<p class=\"sct_noitem\">등록된 상품이 없습니다.</p>\n";
?>

<script>
$(function() {
    var owlbest = $('.owlbest');
    owlbest.owlCarousel({
        items: 5,
        stagePadding: 0,
        loop: true,
        margin: 30,
        autoplay: true,
        autoplayTimeout: 2500,
        autoplayHoverPause: true,
        autoplaySpeed: 800,
        smartSpeed: 500,
        dotsSpeed: 700
    });
});
</script>

<?php
}
?>