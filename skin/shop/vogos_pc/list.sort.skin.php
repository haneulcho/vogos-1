<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$sct_sort_href = $_SERVER['PHP_SELF'].'?';
if($ca_id)
    $sct_sort_href .= 'ca_id='.$ca_id;
else if($ev_id)
    $sct_sort_href .= 'ev_id='.$ev_id;
if($skin)
    $sct_sort_href .= '&amp;skin='.$skin;
$sct_sort_href .= '&amp;sort=';

// 상품 정렬 선택시 active 클래스 추가
$it_order_type = $_GET['sort'];
$it_order_sc = $_GET['sortodr'];

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>

<!-- 상품 정렬 선택 시작 { -->
<section id="sct_sort">
    <h2>상품 정렬</h2>

    <!-- <ul>
        <li><a href="<?php echo $sct_sort_href; ?>it_price&amp;sortodr=asc" class="btn01">낮은가격순</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_price&amp;sortodr=desc" class="btn01">높은가격순</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_name&amp;sortodr=asc" class="btn01">상품명순</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_type1&amp;sortodr=desc" class="btn01">히트상품</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_type2&amp;sortodr=desc" class="btn01">추천상품</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_type3&amp;sortodr=desc" class="btn01">최신상품</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_type4&amp;sortodr=desc" class="btn01">인기상품</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_type5&amp;sortodr=desc" class="btn01">할인상품</a></li>
    </ul> -->

    <ul id="ssch_sort">
        <li>
        <?php if($it_order_type == 'it_price' && $it_order_sc == 'asc') {
            echo '<a href="'.$sct_sort_href.'it_price&amp;sortodr=asc" class="active btn01">가격 ↓</a>';
        } else {
            echo '<a href="'.$sct_sort_href.'it_price&amp;sortodr=asc" class="btn01">가격 ↓</a>';
        }
        ?>
        </li>
        <li>
        <?php if($it_order_type == 'it_price' && $it_order_sc == 'desc') {
            echo '<a href="'.$sct_sort_href.'it_price&amp;sortodr=desc" class="active btn01">가격 ↑</a>';
        } else {
            echo '<a href="'.$sct_sort_href.'it_price&amp;sortodr=desc" class="btn01">가격 ↑</a>';
        }
        ?>
        </li>
        <li>
        <?php if($it_order_type == 'it_update_time' && $it_order_sc == 'desc') {
            echo '<a href="'.$sct_sort_href.'it_update_time&amp;sortodr=desc" class="active btn01">최신순</a>';
        } else {
            echo '<a href="'.$sct_sort_href.'it_update_time&amp;sortodr=desc" class="btn01">최신순</a>';
        }
        ?>
        </li>
        <li>
        <?php if($it_order_type == 'it_order' && $it_order_sc == 'desc') {
            echo '<a href="'.$sct_sort_href.'it_order&amp;sortodr=desc" class="active btn01">인기순</a>';
        } else {
            echo '<a href="'.$sct_sort_href.'it_order&amp;sortodr=desc" class="btn01">인기순</a>';
        }
        ?>
        </li>
    </ul>
</section>
<!-- } 상품 정렬 선택 끝 -->