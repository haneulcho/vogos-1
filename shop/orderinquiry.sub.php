<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!defined("_ORDERINQUIRY_")) exit; // 개별 페이지 접근 불가
?>

<!-- 주문 내역 목록 시작 { -->
<?php if (!$limit) { ?>Total: <?php echo $cnt; ?><?php } ?>

<div class="sct_cart_tbl">
    <table>
    <thead>
    <tr>
        <th class="th_iqr_no" scope="col">ORDER NUMBER</th>
        <th class="th_iqr_no" scope="col">DHL TRACKING NUMBER</th>
        <th class="th_iqr_date" scope="col">ORDER DATE</th>
        <th class="th_iqr_num" scope="col">TOTAL PRICE</th>
        <th class="th_iqr_num" scope="col">SHIPPING COST</th>
        <th class="th_iqr_emp" scope="col">SUBTOTAL</th>
        <th class="th_iqr_emp" scope="col">ORDER STATUS</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sql = " select *
               from {$g5['g5_shop_order_table']}
              where mb_id = '{$member['mb_id']}'
              order by od_id desc
              $limit ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);

        switch($row['od_status']) {
            case '주문':
                $od_status = '입금확인중';
                break;
            case '입금':
                $od_status = 'Payment Completed';
                break;
            case '준비':
                $od_status = 'On hold';
                break;
            case '배송':
                $od_status = 'Out for Delivery';
                break;
            case '완료':
                $od_status = 'Delivered';
                break;
            default:
                $od_status = 'Canceled';
                break;
        }
        if ($row['od_invoice'] && $row['od_delivery_company']) {
            $dhl_link = 'http://www.dhl.com/cgi-bin/tracking.pl?awb='.$row['od_invoice'];
        }
    ?>
    <tr>
        <td>
            <input type="hidden" name="ct_id[<?php echo $i; ?>]" value="<?php echo $row['ct_id']; ?>">
            <a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>"><?php echo $row['od_id']; ?></a>
        </td>
        <td><a href="<?php echo $dhl_link; ?>" target="_blank" class="tracking_num" onclick="return popitup('<?php echo $dhl_link; ?>', 'VOGOS SHIPPING INFORMATION - <?php echo $od['od_invoice']; ?>', '550', '400')"><i class="ion-paper-airplane"></i> <?php echo $row['od_invoice']; ?></a></td>
        <td><?php echo $row['od_time']; ?></td>
        <td class="td_numbig"><?php echo display_price($row['od_cart_price']); ?></td>
        <td class="td_numbig"><?php echo display_price($row['od_send_cost'] + $row['od_send_cost2']); ?></td>
        <td class="td_numbig"><?php echo display_price($row['od_receipt_price']); ?></td>
        <td class="tomato"><a class="view_order" href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>"><?php echo $od_status; ?><span><i class="ion-ios-eye"></i> VIEW ORDER DETAILS</span></a></td>
    </tr>

    <?php
    }

    if ($i == 0)
        echo '<tr><td colspan="7" class="empty_table">Your order list is empty.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

    <div id="sod_bsk_act_con">
        <a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=10" class="continue">Continue Shopping</a>
    </div>
<!-- } 주문 내역 목록 끝 -->