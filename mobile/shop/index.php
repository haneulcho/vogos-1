<?php
include_once('./_common.php');

define("_INDEX_", TRUE);

include_once(G5_MSHOP_PATH.'/_head.php');
?>
<script src="<?php echo G5_JS_URL; ?>/shop.mobile.main.js"></script>
<!-- 인덱스 슬라이더 owl carousel -->
<script src="<?php echo G5_MSHOP_SKIN_URL; ?>/js/owl.carousel.min.js"></script>

<style type="text/css">
.embed-container {position: relative;margin-bottom:10px;padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; height: auto; } .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
</style>
<div id="sidx">
    <div class="inv_wrap">
        <div class="inv_new"><a href="#">NEW ARRIVALS</a></div>
        <div class="inv_run"><a href="#">RUNWAY</a></div>
    </div>
<?php echo display_banner('메인', 'mainbanner.10.skin_m.php'); ?>
<div id="inv_new_view">
    <?php if($default['de_mobile_type3_list_use']) { ?>
    <div class="item new_arrivals">
        <header>
            <h2>NEW ARRIVALS</h2>
            <div class="it_more"><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=3"><i class="ion-ios-arrow-right"></i></a></div>
        </header>
        <?php
        $skin_file = G5_MSHOP_SKIN_PATH .'/main.20.skin.php';
        $item_mod = 1; //한줄당 갯수
        $item_rows = 13; //줄 수 
        $item_width= 300; //이미지 가로 
        $item_height = 450; //이미지 세로 
        $order_by = 'it_order asc'; // 출력순서 설정순


        $list = new item_list($skin_file, $item_mod , $item_rows , $item_width, $item_height); 
        $list->set_order_by($order_by); 
        $list->set_view('it_img', true);
        $list->set_view('it_id', false);
        $list->set_view('it_name', true);
        $list->set_view('it_basic', true);
        $list->set_view('it_cust_price', false);
        $list->set_view('it_price', true);
        $list->set_view('it_icon', false);
        $list->set_view('sns', false);
        echo $list->run();
        ?>
    </div>

    <?php } ?>
</div>

<div id="inv_run_view">
    <?php if($default['de_mobile_type4_list_use']) { ?>
    <div class="item new_arrivals">
        <header>
            <h2>SPOT ITEMS</h2>
            <div class="it_more"><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=2"><i class="ion-ios-arrow-right"></i></a></div>
        </header>
        <?php
        $list = new item_list();
        $list->set_mobile(true);
        $list->set_type(4);
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
</div>

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
</div> <!-- END sidx -->

<?php
include_once(G5_MSHOP_PATH.'/_tail.php');
?>