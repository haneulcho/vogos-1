<?php
include_once('./_common.php');

define("_INDEX_", TRUE);

include_once(G5_MSHOP_PATH.'/_head.php');
?>
<script src="<?php echo G5_JS_URL; ?>/shop.mobile.main.js"></script>
<!-- 인덱스 슬라이더 owl carousel -->
<script src="<?php echo G5_MSHOP_SKIN_URL; ?>/js/owl.carousel.min.js"></script>
<?php include_once(G5_MSHOP_SKIN_PATH.'/main.event.skin.php'); // 이벤트 ?>

<style type="text/css">
.embed-container {position: relative;margin-bottom:10px;padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; height: auto; } .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
</style>

<!-- 보고스 대표 동영상 시작 { -->
<div id="main_video" class="embed-container">
<?php if($default['de_index_video_use']) { ?>
<?php echo '<iframe src="https://player.vimeo.com/video/'.$default['de_index_video_src'].'?autoplay=0&byline=0" width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
?>
<?php } ?>
</div> <!-- } 보고스 대표 동영상 끝 -->

<?php echo display_banner('메인', 'mainbanner.10.skin_m.php'); ?>
<div id="sidx">
    <?php if($default['de_mobile_type2_list_use']) { ?>
    <div class="item md_choice">
        <header>
            <h2>MODEL's CHOICE</h2>
            <div class="it_more"><a href="<?php echo G5_MSHOP_URL; ?>/modelslist.php?type=2"><i class="ion-ios-arrow-right"></i></a></div>
        </header>
        <?php include_once(G5_MSHOP_SKIN_PATH.'/main.modelslist.skin.php'); ?>
    </div>
    <?php } ?>

    <?php if($default['de_mobile_type1_list_use']) { ?>
    <div class="item vogos_clip">
        <header>
            <h2>VOGOS CLIP</h2>
            <div class="it_more"><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=1"><i class="ion-ios-arrow-right"></i></a></div>
        </header>
        <?php
        $list = new item_list();
        $list->set_mobile(true);
        $list->set_type(1);
        $list->set_view('it_id', false);
        $list->set_view('it_name', true);
        $list->set_view('it_cust_price', true);
        $list->set_view('it_price', true);
        $list->set_view('it_icon', false);
        $list->set_view('sns', false);
        echo $list->run();
        ?>
    </div>
    <?php } ?>

    <?php if($default['de_mobile_type3_list_use']) { ?>
    <div class="item new_arrivals">
        <header>
            <h2>NEW ARRIVALS</h2>
            <div class="it_more"><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=3"><i class="ion-ios-arrow-right"></i></a></div>
        </header>
        <?php
        $list = new item_list();
        $list->set_mobile(true);
        $list->set_type(3);
        $list->set_view('it_id', false);
        $list->set_view('it_name', true);
        $list->set_view('it_cust_price', true);
        $list->set_view('it_price', true);
        $list->set_view('it_icon', false);
        $list->set_view('sns', false);
        echo $list->run();
        ?>
    </div>
    <?php } ?>


<!-- VOGOS BESTSELLER 베스트 출력 -->
    <div id="sct_best" class="item best_item">
        <header>
            <h2>VOGOS BESTSELLER</h2>
        </header>
    <?php
        // 분류 Best Item 출력
        $list_mod = 3;
        $list_row = 4;
        $limit = $list_mod * $list_row;
        $best_skin = G5_MSHOP_SKIN_PATH.'/list.best.10.skin_m.php';

        $sql = " select *
                    from {$g5['g5_shop_item_table']}
                    where it_use = '1'
                    order by it_order, it_hit desc
                    limit 0, $limit ";

        $list = new item_list($best_skin, $list_mod, $list_row, 300, 420);
        $list->set_query($sql);
        $list->set_mobile(true);
        $list->set_view('it_img', true);
        $list->set_view('it_id', false);
        $list->set_view('it_name', true);
        $list->set_view('it_price', true);
        echo $list->run();
    ?>
    </div>
<!-- VOGOS BESTSELLER 베스트 출력 끝 -->

    <?php if($default['de_mobile_type5_list_use']) { ?>
    <div class="item">
        <header>
            <h2>할인상품</h2>
            <p class="sct_wrap_hdesc"><?php echo $config['cf_title']; ?> 할인상품 모음</p>
        </header>
        <?php
        $list = new item_list();
        $list->set_mobile(true);
        $list->set_type(5);
        $list->set_view('it_id', false);
        $list->set_view('it_name', true);
        $list->set_view('it_cust_price', true);
        $list->set_view('it_price', true);
        $list->set_view('it_icon', true);
        $list->set_view('sns', true);
        echo $list->run();
        ?>
        <div class="sct_more"><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=5">더 보기</a></div>
    </div>
    <?php } ?>
</div>

<?php
include_once(G5_MSHOP_PATH.'/_tail.php');
?>