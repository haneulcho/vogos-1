<?php
include_once('./_common.php');

// 보관기간이 지난 상품 삭제
cart_item_clean();

// cart id 설정
set_cart_id($sw_direct);

$s_cart_id = get_session('ss_cart_id');
// 선택필드 초기화
$sql = " update {$g5['g5_shop_cart_table']} set ct_select = '0' where od_id = '$s_cart_id' ";
sql_query($sql);

$cart_action_url = G5_SHOP_URL.'/cartupdate.php';

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/cart.php');
    return;
}

$g5['title'] = 'My Cart';
include_once('./_head.php');
?>

<!-- 장바구니 시작 { -->
<script src="<?php echo G5_JS_URL; ?>/shop.js"></script>

<div id="sod_bsk">

    <div id="sct_best" class="item best_item">
        <header class="fullWidth">
            <h2>MY CART <span class="cart_item_num"></span></h2>
        </header>
    </div>

    <form name="frmcartlist" id="sod_bsk_list" method="post" action="<?php echo $cart_action_url; ?>">
    <div class="tbl_head01 tbl_wrap">
        <table>
        <thead>
        <tr>
            <th scope="col">ITEM DESCRIPTION</th>
            <th scope="col">TOTAL QTY</th>
            <th scope="col">UNIT PRICE</th>
            <th scope="col">TOTAL PRICE</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $tot_point = 0;
        $tot_sell_price = 0;

        // $s_cart_id 로 현재 장바구니 자료 쿼리
        $sql = " select a.ct_id,
                        a.it_id,
                        a.it_name,
                        a.ct_price,
                        a.ct_point,
                        a.ct_qty,
                        a.ct_status,
                        a.ct_send_cost,
                        a.it_sc_type,
                        b.ca_id,
                        b.ca_id2,
                        b.ca_id3
                   from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
                  where a.od_id = '$s_cart_id' ";
        $sql .= " group by a.it_id ";
        $sql .= " order by a.ct_id ";
        $result = sql_query($sql);

        $it_send_cost = 0;

        // 로그분석기 시작
        $row_count = mysql_num_rows($result);
        $http_SO="cart";    //장바구니페이지
        $http_PA="";    //장바구니(상품명_수량)
        // 로그분석기 끝

        for ($i=0; $row=mysql_fetch_array($result); $i++)
        {
            // 합계금액 계산
            $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
                            SUM(ct_point * ct_qty) as point,
                            SUM(ct_qty) as qty
                        from {$g5['g5_shop_cart_table']}
                        where it_id = '{$row['it_id']}'
                          and od_id = '$s_cart_id' ";
            $sum = sql_fetch($sql);

            if ($i==0) { // 계속쇼핑
                $continue_ca_id = $row['ca_id'];
            }

            $a1 = '<a href="./item.php?it_id='.$row['it_id'].'"><b>';
            $a2 = '</b></a>';
            $image = get_it_image($row['it_id'], 70, 70);

            $it_name = $a1 . stripslashes($row['it_name']) . $a2;
            $it_options = print_item_options($row['it_id'], $s_cart_id);
            if($it_options) {
                $mod_options = '<div class="sod_option_btn"><button type="button" class="mod_options">CHANGE DETAILS</button></div>';
                $it_name .= '<div class="sod_opt">'.$it_options.'</div>';
            }

            // 배송비
            switch($row['ct_send_cost'])
            {
                case 1:
                    $ct_send_cost = '착불';
                    break;
                case 2:
                    $ct_send_cost = '무료';
                    break;
                default:
                    $ct_send_cost = '선불';
                    break;
            }

            // 조건부무료
            if($row['it_sc_type'] == 2) {
                $sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $s_cart_id);

                if($sendcost == 0)
                    $ct_send_cost = '무료';
            }

            $point      = $sum['point'];
            $sell_price = $sum['price'];
        ?>

        <tr>
            <td class="sod_img"><?php echo $image; ?></td>
            <td>
                <input type="hidden" name="it_id[<?php echo $i; ?>]"    value="<?php echo $row['it_id']; ?>">
                <input type="hidden" name="it_name[<?php echo $i; ?>]"  value="<?php echo get_text($row['it_name']); ?>">
                <?php echo $it_name.$mod_options; ?>
            </td>
            <td class="td_num"><?php echo number_format($sum['qty']); ?></td>
            <td class="td_numbig"><?php echo number_format($row['ct_price']); ?></td>
            <td class="td_numbig"><span id="sell_price_<?php echo $i; ?>"><?php echo number_format($sell_price); ?></span></td>
            <td class="td_chk">
                <label for="ct_chk_<?php echo $i; ?>" class="sound_only">상품</label>
                <input type="checkbox" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" checked="checked">
            </td>
        </tr>

        <?php
            $tot_point      += $point;
            $tot_sell_price += $sell_price;

            // 로그분석기 변수 전달
            $http_PA .= $row['it_name']."_";

            if ($i < $row_count-1) {
                $http_PA .= number_format($sum['qty']).";";
            } else {
                $http_PA .= number_format($sum['qty']);
            }
            // 로그분석기 변수 전달 끝

        } // for 끝

        if ($i == 0) {
            echo '<tr><td colspan="8" class="empty_table">Your shopping cart is empty.</td></tr>';
        } else {
            // 배송비 계산
            $send_cost = get_sendcost($s_cart_id, 0);
        }
        ?>
        </tbody>
        </table>
    </div>

    <?php
    $tot_price = $tot_sell_price + $send_cost; // 총계 = 주문상품금액합계 + 배송비
    if ($tot_price > 0 || $send_cost > 0) {
    ?>
    <dl id="sod_bsk_tot">
        <?php if ($send_cost > 0) { // 배송비가 0 보다 크다면 (있다면) ?>
        <dt class="sod_bsk_dvr">Shipping Cost</dt>
        <dd class="sod_bsk_dvr"><strong>$<?php echo number_format($send_cost); ?> .00</strong></dd>
        <?php } ?>

        <?php
        if ($tot_price > 0) {
        ?>

        <dt class="sod_bsk_cnt">Subtotal/Total Point</dt>
        <dd class="sod_bsk_cnt"><strong>$<?php echo number_format($tot_price); ?> .00 / <?php echo number_format($tot_point); ?> Point</strong></dd>
        <?php } ?>

    </dl>
    <?php } ?>

    <div id="sod_bsk_act">
        <?php if ($i == 0) { ?>
        <a href="<?php echo G5_SHOP_URL; ?>/" class="btn01">Continue shopping</a>
        <?php } else { ?>
        <input type="hidden" name="url" value="./orderform.php">
        <input type="hidden" name="records" value="<?php echo $i; ?>">
        <input type="hidden" name="act" value="">
        <a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $continue_ca_id; ?>" class="btn01">Continue Shoppping</a>
        <button type="button" onclick="return form_check('buy');" class="btn_submit">Order</button>
        <button type="button" onclick="return form_check('seldelete');" class="btn01">Remove</button>
        <button type="button" onclick="return form_check('alldelete');" class="btn01">Empty</button>
        <?php } ?>
    </div>

    </form>

</div>

<!-- 네이버 프리미엄로그분석 전환페이지 설정_ 장바구니담기 -->
 <script type="text/javascript" src="http://wcs.naver.net/wcslog.js"> </script> 
 <script type="text/javascript">
var $interValue = "<?php echo $tot_price; ?>";
var _nasa={};
 _nasa["cnv"] = wcs.cnv("3",$interValue);
</script>

<script>
$(function() {
    var close_btn_idx;

    // 선택사항수정
    $(".mod_options").click(function() {
        var it_id = $(this).closest("tr").find("input[name^=it_id]").val();
        var $this = $(this);
        close_btn_idx = $(".mod_options").index($(this));

        $.post(
            "./cartoption.php",
            { it_id: it_id },
            function(data) {
                $("#mod_option_frm").remove();
                $this.after("<div id=\"mod_option_frm\"></div>");
                $("#mod_option_frm").html(data);
                price_calculate();
            }
        );
    });

    // 모두선택
    $("input[name=ct_all]").click(function() {
        if($(this).is(":checked"))
            $("input[name^=ct_chk]").attr("checked", true);
        else
            $("input[name^=ct_chk]").attr("checked", false);
    });

    // 옵션수정 닫기
    $("#mod_option_close").live("click", function() {
        $("#mod_option_frm").remove();
        $(".mod_options").eq(close_btn_idx).focus();
    });
    $("#win_mask").click(function () {
        $("#mod_option_frm").remove();
        $(".mod_options").eq(close_btn_idx).focus();
    });

});

function form_check(act) {
    var f = document.frmcartlist;
    var cnt = f.records.value;

    if (act == "buy")
    {
        if($("input[name^=ct_chk]:checked").size() < 1) {
            alert("Please select at least one item.");
            return false;
        }

        f.act.value = act;
        f.submit();
    }
    else if (act == "alldelete")
    {
        f.act.value = act;
        f.submit();
    }
    else if (act == "seldelete")
    {
        if($("input[name^=ct_chk]:checked").size() < 1) {
            alert("Please select at least one item.");
            return false;
        }

        f.act.value = act;
        f.submit();
    }

    return true;
}
</script>
<!-- } 장바구니 끝 -->

<?php
include_once('./_tail.php');
?>