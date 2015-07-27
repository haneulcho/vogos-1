<?php
include_once('./_common.php');

// 초기화면 파일 지정 : 이 코드는 가능한 삭제하지 마십시오.
if ($default['de_include_index'] && is_file(G5_SHOP_PATH.'/'.$default['de_include_index'])) {
    include_once(G5_SHOP_PATH.'/'.$default['de_include_index']);
    return; // 이 코드의 아래는 실행을 하지 않습니다.
}

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/index.php');
    return;
}

define("_INDEX_", TRUE);

include_once(G5_SHOP_PATH.'/shop.head.php');
?>

<?php if($default['de_type1_list_use']) { ?>
<!-- VOGOS COLLECTION 시작 { -->
<section class="sct_wrap">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=1">VOGOS<br>COLLECTION</a></h2>
    </header>
    <?php
    $list = new item_list();
    $list->set_type(1);
    $list->set_view('it_id', false);
    $list->set_view('it_name', false);
    $list->set_view('it_basic', false);
    $list->set_view('it_cust_price', false);
    $list->set_view('it_price', false);
    $list->set_view('it_icon', false);
    $list->set_view('sns', false);
    echo $list->run();
    ?>
</section>
<!-- } VOGOS COLLECTION 끝 -->
<?php } ?>

<?php if($default['de_type3_list_use']) { ?>
<!-- 최신상품 시작 { -->
<section class="sct_wrap">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=3">NEW<br>ARRIVALS</a></h2>
    </header>
    <?php
    $list = new item_list();
    $list->set_type(3);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', false);
    $list->set_view('sns', false);
    echo $list->run();
    ?>
</section>
<!-- } 최신상품 끝 -->
<?php } ?>

<?php if($default['de_type5_list_use']) { ?>
<!-- 할인상품 시작 { -->
<section class="sct_wrap">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=5">할인상품</a></h2>
        <p class="sct_wrap_hdesc"><?php echo $config['cf_title']; ?> 할인상품 모음</p>
    </header>
    <?php
    $list = new item_list();
    $list->set_type(5);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', true);
    $list->set_view('sns', true);
    echo $list->run();
    ?>
</section>
<!-- } 할인상품 끝 -->
<?php } ?>

<?php // echo poll('shop_basic'); // 설문조사 ?>

<?php // echo visit('shop_basic'); // 접속자 ?>

<?php
include_once(G5_SHOP_PATH.'/shop.tail.php');
?>