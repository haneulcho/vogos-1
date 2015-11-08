<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!defined("_ORDERINQUIRY_")) exit; // 개별 페이지 접근 불가
?>

<!-- 주문 내역 목록 시작 { -->
<?php if (!$limit) { ?>Total: <?php echo $cnt; ?><?php } ?>

<div class="tbl_head01 tbl_wrap">
    <table>
    <thead>
    <tr>
        <th scope="col">Order Number</th>
        <th scope="col">Order Date</th>
        <th scope="col">Quantity</th>
        <th scope="col">Total Price</th>
        <th scope="col">Shipping Cost</th>
        <th scope="col">Order status</th>
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
    ?>

    <tr>
        <td>
            <input type="hidden" name="ct_id[<?php echo $i; ?>]" value="<?php echo $row['ct_id']; ?>">
            <a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>"><?php echo $row['od_id']; ?></a>
        </td>
        <td><?php echo substr($row['od_time'],2,14); ?></td>
        <td class="td_num"><?php echo $row['od_cart_count']; ?></td>
        <td class="td_numbig"><?php echo display_price($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']); ?></td>
        <td class="td_numbig"><?php echo display_price($row['od_receipt_price']); ?></td>
        <td><?php echo $od_status; ?></td>
    </tr>

    <?php
    }

    if ($i == 0)
        echo '<tr><td colspan="7" class="empty_table">Your order list is empty.</td></tr>';
    ?>
    </tbody>
    </table>
</div>
<!-- } 주문 내역 목록 끝 -->