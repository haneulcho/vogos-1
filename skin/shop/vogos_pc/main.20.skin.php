<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 상품유형 20 시작 { -->
<?php
for ($i=1; $row=sql_fetch_array($result); $i++) {
    if ($i == 1) {
        echo "<div class=\"owl-carousel owl20\">\n";
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
}

if ($i > 1) {
    echo "</div>\n";
}

if($i == 1) echo "<p class=\"sct_noitem\">등록된 상품이 없습니다.</p>\n";
?>

<script>
$(function() {
    var owl20 = $('.owl20');
    owl20.owlCarousel({
        items: 5,
        stagePadding: 50,
        loop: true,
        margin: 10,
        dotsEach:true,
        autoplay: true,
        autoplayTimeout: 2500,
        autoplayHoverPause: true,
        autoplaySpeed: 800,
        smartSpeed: 500,
        dotsSpeed: 700
    });
});
</script>

<!-- } 상품진열 20 끝 -->