<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/orderinquiryview.php');
    return;
}

// 불법접속을 할 수 없도록 세션에 아무값이나 저장하여 hidden 으로 넘겨서 다음 페이지에서 비교함
$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

if (!$is_member) {
    if (get_session('ss_orderview_uid') != $_GET['uid'])
        alert("An Error Occured.\\n\\nPlease sign in and try again.", G5_SHOP_URL);
}

$sql = "select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' ";
if($is_member && !$is_admin)
    $sql .= " and mb_id = '{$member['mb_id']}' ";
$od = sql_fetch($sql);
if (!$od['od_id'] || (!$is_member && md5($od['od_id'].$od['od_time'].$od['od_ip']) != get_session('ss_orderview_uid'))) {
    alert("This order is invalid.", G5_SHOP_URL);
}

// 결제방법
$settle_case = $od['od_settle_case'];

$g5['title'] = 'Your Order Details';
include_once('./_head.php');

// 로그분석기 시작
if($_SESSION['ord_num'] != $od_id) {
    $http_SO = "payend";  //결제완료페이지
    $http_OD = $od_id;    //주문번호
} else {
    $http_OD = '';
}
$_SESSION['ord_num'] = $od_id;
// 로그분석기 끝

?>

<!-- 주문상세내역 시작 { -->
<div id="sod_fin">

    <div id="sod_title" class="iqv">
        <header class="fullWidth">
            <h2>ORDER SUMMARY <span class="cart_item_num">No. <?php echo $od_id; ?></span></h2>
        </header>
    </div>

    <div class="fullWidth">

    <section id="sod_fin_list">

        <?php
        $st_count1 = $st_count2 = 0;
        $custom_cancel = false;

        $sql = " select it_id, it_name, ct_send_cost, it_sc_type
                    from {$g5['g5_shop_cart_table']}
                    where od_id = '$od_id'
                    group by it_id
                    order by ct_id ";
        $result = sql_query($sql);
        ?>
        <div class="sct_iqv_tbl">
            <table>
            <thead>
            <tr>
                <th class="th_cart_des" scope="col" colspan="2" class="itemdes">ITEM DESCRIPTION</th>
                <th class="th_cart_qty" scope="col">TOTAL QTY</th>
                <th class="th_cart_num" scope="col">UNIT PRICE</th>
                <th class="th_cart_num" scope="col">TOTAL PRICE</th>
                <th class="th_cart_status" scope="col">ORDER STATUS</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for($i=0; $row=sql_fetch_array($result); $i++) {
                $image = get_it_image_best($row['it_id'], 60, 80, 8, '', '', 'original', stripslashes($row['it_name']));

                $sql = " select ct_id, it_name, ct_option, ct_qty, ct_price, ct_point, ct_status, io_type, io_price
                            from {$g5['g5_shop_cart_table']}
                            where od_id = '$od_id'
                              and it_id = '{$row['it_id']}'
                            order by io_type asc, ct_id asc ";
                $res = sql_query($sql);
                $rowspan = mysql_num_rows($res) + 1;

                // 합계금액 계산
                $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
                                SUM(ct_qty) as qty
                            from {$g5['g5_shop_cart_table']}
                            where it_id = '{$row['it_id']}'
                              and od_id = '$od_id' ";
                $sum = sql_fetch($sql);

                // 배송비
                switch($row['ct_send_cost'])
                {
                    case 1:
                        $ct_send_cost = 'Paid';
                        break;
                    case 2:
                        $ct_send_cost = 'Free shipping';
                        break;
                    default:
                        $ct_send_cost = 'Paid';
                        break;
                }

                // 조건부무료
                if($row['it_sc_type'] == 2) {
                    $sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $od_id);

                    if($sendcost == 0)
                        $ct_send_cost = 'Free shipping';
                }

                for($k=0; $opt=sql_fetch_array($res); $k++) {
                    switch($opt['ct_status']) {
                        case '주문':
                            $ct_status = '입금확인중';
                            break;
                        case '입금':
                            $ct_status = 'Payment Completed';
                            break;
                        case '준비':
                            $ct_status = 'On hold';
                            break;
                        case '배송':
                            $ct_status = 'Out for Delivery';
                            break;
                        case '완료':
                            $ct_status = 'Delivered';
                            break;
                        default:
                            $ct_status = 'Canceled';
                            break;
                    }

                    if($opt['io_type'])
                        $opt_price = $opt['io_price'];
                    else
                        $opt_price = $opt['ct_price'] + $opt['io_price'];

                    $sell_price = $opt_price * $opt['ct_qty'];
                    $point = $opt['ct_point'] * $opt['ct_qty'];

                    if($k == 0) {
            ?>
            <?php } ?>
            <tr>
                <td class="cart_img"><?php echo $image; ?></td>
                <td class="cart_des">
                    <a class="cart_it_name" href="./item.php?it_id=<?php echo $row['it_id']; ?>"><?php echo $row['it_name']; ?></a>
                    <div class="sod_opt"><?php echo $opt['ct_option']; ?></div>
                </td>
                <td class="cart_qty"><?php echo number_format($opt['ct_qty']); ?></td>
                <td class="cart_num">$<?php echo number_format($opt_price, 2); ?></td>
                <td class="cart_num">$<?php echo number_format($sell_price, 2); ?></td>
                <td class="cart_status"><?php echo $ct_status; ?></td>
            </tr>
            <?php
                    $tot_point       += $point;

                    $st_count1++;
                    if($opt['ct_status'] == '주문')
                        $st_count2++;
                }
            }

            // 주문 상품의 상태가 모두 주문이면 고객 취소 가능
            if($st_count1 > 0 && $st_count1 == $st_count2)
                $custom_cancel = true;
            ?>
            </tbody>
            </table>
        </div>

        <div id="sod_sts_wrap">
            <span class="sound_only">상품 상태 설명</span>
            <button type="button" id="sod_sts_explan_open" class="btn_frmline">상태설명보기</button>
            <div id="sod_sts_explan">
                <dl id="sod_fin_legend">
                    <dt>주문</dt>
                    <dd>주문이 접수되었습니다.</dd>
                    <dt>입금</dt>
                    <dd>입금(결제)이 완료 되었습니다.</dd>
                    <dt>준비</dt>
                    <dd>상품 준비 중입니다.</dd>
                    <dt>배송</dt>
                    <dd>상품 배송 중입니다.</dd>
                    <dt>완료</dt>
                    <dd>상품 배송이 완료 되었습니다.</dd>
                </dl>
                <button type="button" id="sod_sts_explan_close" class="btn_frmline">상태설명닫기</button>
            </div>
        </div>

        <?php
        // 총계 = 주문상품금액합계 + 배송비 - 상품할인 - 결제할인 - 배송비할인
        $tot_price = $od['od_cart_price'] + $od['od_send_cost'] + $od['od_send_cost2']
                        - $od['od_cart_coupon'] - $od['od_coupon'] - $od['od_send_coupon']
                        - $od['od_cancel_price'];
        ?>

        <dl id="sod_bsk_tot">
            <dt class="sod_bsk_dvr">TOTAL PRICE</dt>
            <dd class="sod_bsk_dvr"><strong>$<?php echo number_format($od['od_cart_price'], 2); ?></strong></dd>

            <?php if($od['od_cart_coupon'] > 0) { ?>
            <dt class="sod_bsk_dvr">USE ITEM COUPON</dt>
            <dd class="sod_bsk_dvr"><strong>$<?php echo number_format($od['od_cart_coupon'], 2); ?></strong></dd>
            <?php } ?>

            <?php if($od['od_coupon'] > 0) { ?>
            <dt class="sod_bsk_dvr">USE PRICE COUPON</dt>
            <dd class="sod_bsk_dvr"><strong>$<?php echo number_format($od['od_coupon'], 2); ?></strong></dd>
            <?php } ?>

            <?php if ($od['od_send_cost'] > 0) { ?>
            <dt class="sod_bsk_dvr">SHIPPING COST</dt>
            <dd class="sod_bsk_dvr"><strong>$<?php echo number_format($od['od_send_cost'], 2); ?></strong></dd>
            <?php } ?>

            <?php if($od['od_send_coupon'] > 0) { ?>
            <dt class="sod_bsk_dvr">USE DELIVERY COUPON</dt>
            <dd class="sod_bsk_dvr"><strong>$<?php echo number_format($od['od_send_coupon'], 2); ?></strong></dd>
            <?php } ?>

            <?php if ($od['od_send_cost2'] > 0) { ?>
            <dt class="sod_bsk_dvr">SHIPPING COST2</dt>
            <dd class="sod_bsk_dvr"><strong>$<?php echo number_format($od['od_send_cost2'], 2); ?></strong></dd>
            <?php } ?>

            <?php if ($od['od_cancel_price'] > 0) { ?>
            <dt class="sod_bsk_dvr">REFUND</dt>
            <dd class="sod_bsk_dvr"><strong>$<?php echo number_format($od['od_cancel_price'], 2); ?></strong></dd>
            <?php } ?>

            <dt class="sod_bsk_cnt">SUBTOTAL</dt>
            <dd class="sod_bsk_cnt"><strong>$<?php echo number_format($tot_price, 2); ?></strong></dd>
        </dl>
    </section>

    <div id="sod_fin_view">
        <h2>PAYMENT/DELIVERY INFORMATION</h2>
        <?php
        $receipt_price  = $od['od_receipt_price']
                        + $od['od_receipt_point'];
        $cancel_price   = $od['od_cancel_price'];

        $misu = true;
        $misu_price = $tot_price - $receipt_price - $cancel_price;

        if ($misu_price == 0 && ($od['od_cart_price'] > $od['od_cancel_price'])) {
            //$wanbul = " (완불)";
            $wanbul = display_price($receipt_price);
            $misu = false; // 미수금 없음
        }
        else
        {
            $wanbul = display_price($receipt_price);
        }

        // 결제정보처리
        if($od['od_receipt_price'] > 0)
            $od_receipt_price = display_price($od['od_receipt_price']);
        else
            $od_receipt_price = '아직 입금되지 않았거나 입금정보를 입력하지 못하였습니다.';

        $app_no_subj = '';
        $disp_bank = true;
        $disp_receipt = false;
        if($od['od_settle_case'] == '신용카드') {
            $app_no_subj = '승인번호';
            $app_no = $od['od_app_no'];
            $disp_bank = false;
            $disp_receipt = true;
        } else if($od['od_settle_case'] == '휴대폰') {
            $app_no_subj = '휴대폰번호';
            $app_no = $od['od_bank_account'];
            $disp_bank = false;
            $disp_receipt = true;
        } else if($od['od_settle_case'] == '가상계좌' || $od['od_settle_case'] == '계좌이체') {
            $app_no_subj = '거래번호';
            $app_no = $od['od_tno'];
        }
        ?>

        <section id="sod_fin_pay">
            <h3>결제정보</h3>

            <div class="tbl_head01 tbl_wrap">
                <table>
                <colgroup>
                    <col class="grid_3">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <th scope="row">주문번호</th>
                    <td><?php echo $od_id; ?></td>
                </tr>
                <tr>
                    <th scope="row">주문일시</th>
                    <td><?php echo $od['od_time']; ?></td>
                </tr>
                <tr>
                    <th scope="row">결제방식</th>
                    <td><?php echo $od['od_settle_case']; ?></td>
                </tr>
                <tr>
                    <th scope="row">결제금액</th>
                    <td><?php echo $od_receipt_price; ?></td>
                </tr>
                <?php
                if($od['od_receipt_price'] > 0)
                {
                ?>
                <tr>
                    <th scope="row">결제일시</th>
                    <td><?php echo $od['od_receipt_time']; ?></td>
                </tr>
                <?php
                }

                // 승인번호, 휴대폰번호, 거래번호
                if($app_no_subj)
                {
                ?>
                <tr>
                    <th scope="row"><?php echo $app_no_subj; ?></th>
                    <td><?php echo $app_no; ?></td>
                </tr>
                <?php
                }

                // 계좌정보
                if($disp_bank)
                {
                ?>
                <tr>
                    <th scope="row">입금자명</th>
                    <td><?php echo get_text($od['od_deposit_name']); ?></td>
                </tr>
                <tr>
                    <th scope="row">입금계좌</th>
                    <td><?php echo get_text($od['od_bank_account']); ?></td>
                </tr>
                <?php
                }

                if ($od['od_receipt_point'] > 0) {
                ?>
                <tr>
                    <th scope="row">Used Point</th>
                    <td><?php echo display_point($od['od_receipt_point']); ?></td>
                </tr>

                <?php
                }
                if ($od['od_refund_price'] > 0) {
                ?>
                <tr>
                    <th scope="row">Refund</th>
                    <td><?php echo display_price($od['od_refund_price']); ?></td>
                </tr>
                <?php } ?>
                </tbody>
                </table>
            </div>
        </section>

        <section id="sod_fin_orderer">
            <h3>주문하신 분</h3>

            <div class="tbl_head01 tbl_wrap">
                <table>
                <colgroup>
                    <col class="grid_3">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <th scope="row">이 름</th>
                    <td><?php echo get_text($od['od_name']); ?></td>
                </tr>
                <tr>
                    <th scope="row">전화번호</th>
                    <td><?php echo get_text($od['od_tel']); ?></td>
                </tr>
                <tr>
                    <th scope="row">핸드폰</th>
                    <td><?php echo get_text($od['od_hp']); ?></td>
                </tr>
                <tr>
                    <th scope="row">주 소</th>
                    <td><?php echo get_text(sprintf("(%s%s)", $od['od_zip1'], $od['od_zip2']).' '.print_address($od['od_addr1'], $od['od_addr2'], $od['od_addr3'], $od['od_addr_jibeon'])); ?></td>
                </tr>
                <tr>
                    <th scope="row">E-mail</th>
                    <td><?php echo get_text($od['od_email']); ?></td>
                </tr>
                </tbody>
                </table>
            </div>
        </section>

        <section id="sod_fin_receiver">
            <h3>받으시는 분</h3>

            <div class="tbl_head01 tbl_wrap">
                <table>
                <colgroup>
                    <col class="grid_3">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <th scope="row">이 름</th>
                    <td><?php echo get_text($od['od_b_name']); ?></td>
                </tr>
                <tr>
                    <th scope="row">전화번호</th>
                    <td><?php echo get_text($od['od_b_tel']); ?></td>
                </tr>
                <tr>
                    <th scope="row">핸드폰</th>
                    <td><?php echo get_text($od['od_b_hp']); ?></td>
                </tr>
                <tr>
                    <th scope="row">주 소</th>
                    <td><?php echo get_text(sprintf("(%s%s)", $od['od_b_zip1'], $od['od_b_zip2']).' '.print_address($od['od_b_addr1'], $od['od_b_addr2'], $od['od_b_addr3'], $od['od_b_addr_jibeon'])); ?></td>
                </tr>
                <?php
                if ($od['od_memo'])
                {
                ?>
                <tr>
                    <th scope="row">전하실 말씀</th>
                    <td><?php echo conv_content($od['od_memo'], 0); ?></td>
                </tr>
                <?php } ?>
                </tbody>
                </table>
            </div>
        </section>

        <section id="sod_fin_dvr">
            <h3>배송정보</h3>

            <div class="tbl_head01 tbl_wrap">
                <table>
                <colgroup>
                    <col class="grid_3">
                    <col>
                </colgroup>
                <tbody>
                <?php
                if ($od['od_invoice'] && $od['od_delivery_company'])
                {
                ?>
                <tr>
                    <th scope="row">배송회사</th>
                    <td><?php echo $od['od_delivery_company']; ?> <?php echo get_delivery_inquiry($od['od_delivery_company'], $od['od_invoice'], 'dvr_link'); ?></td>
                </tr>
                <tr>
                    <th scope="row">운송장번호</th>
                    <td><?php echo $od['od_invoice']; ?></td>
                </tr>
                <tr>
                    <th scope="row">배송일시</th>
                    <td><?php echo $od['od_invoice_time']; ?></td>
                </tr>
                <?php
                }
                else
                {
                ?>
                <tr>
                    <td class="empty_table">아직 배송하지 않았거나 배송정보를 입력하지 못하였습니다.</td>
                </tr>
                <?php
                }
                ?>
                </tbody>
                </table>
            </div>
        </section>
    </div>

    <section id="sod_fin_tot">
        <h2>결제합계</h2>

        <ul>
            <li>
                총 구매액
                <strong><?php echo display_price($tot_price); ?></strong>
            </li>
            <?php
            if ($misu_price > 0) {
            echo '<li>';
            echo '미결제액'.PHP_EOL;
            echo '<strong>'.display_price($misu_price).'</strong>';
            echo '</li>';
            }
            ?>
            <li id="alrdy">
                결제액
                <strong><?php echo $wanbul; ?></strong>
            </li>
        </ul>
    </section>

    <section id="sod_fin_cancel">
        <h2>주문취소</h2>
        <?php
        // 취소한 내역이 없다면
        if ($cancel_price == 0) {
            if ($custom_cancel) {
        ?>
        <button type="button" onclick="document.getElementById('sod_fin_cancelfrm').style.display='block';">주문 취소하기</button>

        <div id="sod_fin_cancelfrm">
            <form method="post" action="./orderinquirycancel.php" onsubmit="return fcancel_check(this);">
            <input type="hidden" name="od_id"  value="<?php echo $od['od_id']; ?>">
            <input type="hidden" name="token"  value="<?php echo $token; ?>">

            <label for="cancel_memo">취소사유</label>
            <input type="text" name="cancel_memo" id="cancel_memo" required class="frm_input required" size="40" maxlength="100">
            <input type="submit" value="확인" class="btn_frmline">

            </form>
        </div>
        <?php
            }
        } else {
        ?>
        <p>주문 취소, 반품, 품절된 내역이 있습니다.</p>
        <?php } ?>
    </section>

    <?php if ($od['od_settle_case'] == '가상계좌' && $od['od_misu'] > 0 && $default['de_card_test'] && $is_admin && $od['od_pg'] == 'kcp') {
    preg_match("/\s{1}([^\s]+)\s?/", $od['od_bank_account'], $matchs);
    $deposit_no = trim($matchs[1]);
    ?>
    <p>관리자가 가상계좌 테스트를 한 경우에만 보입니다.</p>
    <div class="tbl_frm01 tbl_wrap">
        <form method="post" action="http://devadmin.kcp.co.kr/Modules/Noti/TEST_Vcnt_Noti_Proc.jsp" target="_blank">
        <table>
        <caption>모의입금처리</caption>
        <colgroup>
            <col class="grid_3">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="col"><label for="e_trade_no">KCP 거래번호</label></th>
            <td><input type="text" name="e_trade_no" value="<?php echo $od['od_tno']; ?>"></td>
        </tr>
        <tr>
            <th scope="col"><label for="deposit_no">입금계좌</label></th>
            <td><input type="text" name="deposit_no" value="<?php echo $deposit_no; ?>"></td>
        </tr>
        <tr>
            <th scope="col"><label for="req_name">입금자명</label></th>
            <td><input type="text" name="req_name" value="<?php echo $od['od_deposit_name']; ?>"></td>
        </tr>
        <tr>
            <th scope="col"><label for="noti_url">입금통보 URL</label></th>
            <td><input type="text" name="noti_url" value="<?php echo G5_SHOP_URL; ?>/settle_kcp_common.php"></td>
        </tr>
        </tbody>
        </table>
        <div id="sod_fin_test" class="btn_confirm">
            <input type="submit" value="입금통보 테스트" class="btn_submit">
        </div>
        </form>
    </div>
    <?php } ?>

</div>

</div>
<!-- } 주문상세내역 끝 -->

<!-- 네이버 프리미엄로그분석 전환페이지 설정_ 구매완료 -->
 <script type="text/javascript" src="http://wcs.naver.net/wcslog.js"> </script> 
 <script type="text/javascript">
var $interValue = "<?php echo $tot_price; ?>";
var _nasa={};
 _nasa["cnv"] = wcs.cnv("1",$interValue);
</script>

<script>
$(function() {
    $("#sod_sts_explan_open").on("click", function() {
        var $explan = $("#sod_sts_explan");
        if($explan.is(":animated"))
            return false;

        if($explan.is(":visible")) {
            $explan.slideUp(200);
            $("#sod_sts_explan_open").text("상태설명보기");
        } else {
            $explan.slideDown(200);
            $("#sod_sts_explan_open").text("상태설명닫기");
        }
    });

    $("#sod_sts_explan_close").on("click", function() {
        var $explan = $("#sod_sts_explan");
        if($explan.is(":animated"))
            return false;

        $explan.slideUp(200);
        $("#sod_sts_explan_open").text("상태설명보기");
    });
});

function fcancel_check(f)
{
    if(!confirm("주문을 정말 취소하시겠습니까?"))
        return false;

    var memo = f.cancel_memo.value;
    if(memo == "") {
        alert("취소사유를 입력해 주십시오.");
        return false;
    }

    return true;
}
</script>

<?php
include_once('./_tail.php');
?>