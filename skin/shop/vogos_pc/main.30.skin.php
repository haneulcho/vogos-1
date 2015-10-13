<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
add_javascript('<script src="'.G5_SHOP_SKIN_URL.'/js/jquery.shop.list.js"></script>', 10);
?>

<!-- 상품진열 30 시작 { -->
<?php
for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($i % $this->list_mod == 0)
        $sct_last = ' sct_clear'; // 줄 첫번째
    else {
        $sct_last = '';
    }

    if ($i == 0) {
        echo "<div id=\"sct_30_video\">";
        
        echo "</div>";
        if ($this->css) {
            echo "<ul class=\"{$this->css}\">\n";
        } else {
            echo "<ul class=\"sct sct_30\">\n";
        }
    }

    echo "<li class=\"sct_li{$sct_last}\" style=\"width:{$this->img_width}px\">\n";

    if ($this->href) {
        echo "<div class=\"sct_img\">\n";
        echo "<div class=\"sct_play_m\"><button type=\"button\" class=\"btn_play_m\"><img src=\"".G5_SHOP_SKIN_URL."/img/play_btn.png\" alt=\"PLAY RUNWAY\"></button></div>";
    }

    if ($this->view_it_img) {
        echo get_it_thumbnail($row['it_img10'], $this->img_width, $this->img_height);
    }

    if ($this->href) {
        echo "</div>\n";
    }


    if ($this->href) {
        echo "<div class=\"sct_des\"><div class=\"sct_txt\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_name) {
        echo stripslashes($row['it_name'])."\n";
    }

    if ($this->href) {
        echo "</a></div>\n";
    }

    if ($this->view_it_cust_price || $this->view_it_price) {

        echo "<div class=\"sct_cost\">\n";

        if ($this->view_it_cust_price && $row['it_cust_price']) {
            echo "<strike>".display_price($row['it_cust_price'])."</strike>\n";
        }

        if ($this->view_it_price) {
            echo display_price(get_price($row), $row['it_tel_inq'])."\n";
        }

        echo "</div>";

        echo"<div class=\"sct_cart_m\">
                <button type=\"button\" class=\"btn_cart_m\" onclick=\"location.href='{$this->href}{$row['it_id']}'\"><i class=\"ion-android-cart\"></i>CART</button>
        </div>\n";

        echo "</div>\n";


}
    echo "</li>\n";
}

if ($i > 0) echo "</ul>\n";

if($i == 0) echo "<p class=\"sct_noitem\">등록된 상품이 없습니다.</p>\n";
?>
<!-- } 상품진열 30 끝 -->