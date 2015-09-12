<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if ($ca_id)
{
    $str = $bar = "";
    $len = strlen($ca_id) / 2;
    for ($i=1; $i<=$len; $i++)
    {
        $code = substr($ca_id,0,$i*2);

        $sql = " select ca_name from {$g5['g5_shop_category_table']} where ca_id = '$code' ";
        $row = sql_fetch($sql);
        $b_ca_name = $row['ca_name'];
        $b_ca_imgname = strtolower($b_ca_name);
    }
}
?>
    <div id="sct_best" class="item best_item">
        <header>
            <h2>VOGOS에서 가장 인기 있는 <?php echo $b_ca_name ?> 상품입니다.</h2>
        </header>
        <div class="sct_best_tooltip">
            <img src="<?php echo G5_SHOP_SKIN_URL.'/img/title_bs_'.$b_ca_imgname.'.png' ?>">
        </div>
<?php
    // 분류 Best Item 출력
    $list_mod = 10;
    $list_row = 1;
    $limit = $list_mod * $list_row;
    $best_skin = G5_SHOP_SKIN_PATH.'/list.best.10.skin.php';

    $sql = " select *
                from {$g5['g5_shop_item_table']}
                where ( ca_id like '$ca_id%' or ca_id2 like '$ca_id%' or ca_id3 like '$ca_id%' )
                  and it_use = '1'
                order by it_order, it_hit desc
                limit 0, $limit ";

    $list = new item_list($best_skin, $list_mod, $list_row, $ca['ca_mobile_img_width'], $ca['ca_mobile_img_height']);
    $list->set_query($sql);
    $list->set_mobile(true);
    $list->set_view('it_img', true);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_price', true);
    echo $list->run();
?>
    </div>