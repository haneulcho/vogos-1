<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!defined("_ORDERINQUIRY_")) exit; // 개별 페이지 접근 불가
?>

<?php if (!$limit) { ?>총 <?php echo $cnt; ?> 건<?php } ?>


<div id="sod_inquiry">
    <ul>
        <?php
        $sql = " select *,
                        (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
                     from {$g5['g5_shop_order_table']}
                    where mb_id = '{$member['mb_id']}'
                    order by od_id desc
                    $limit ";
        $result = sql_query($sql);
        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            // 주문상품
            $sql = " select it_name, it_id, ct_option
                                    from {$g5['g5_shop_cart_table']}
                                    where od_id = '{$row['od_id']}'
                                    order by io_type, ct_id
                                    limit 1 ";
            $ct = sql_fetch($sql);
            $ct_name = get_text($ct['it_name']).' '.get_text($ct['ct_option']);

            // 이미지 긁어오기
            $sql = " select it_img1 from {$g5['g5_shop_item_table']} where it_id = '{$ct['it_id']}' ";
            $img = sql_fetch($sql);
            // 이미지(중) 썸네일
            $thumb_img_w = 60; // 넓이
            $thumb_img_h = 85; // 높이
            $thumb = get_it_thumbnail($img['it_img1'], $thumb_img_w, $thumb_img_h);

            $sql = " select count(*) as cnt
                                    from {$g5['g5_shop_cart_table']}
                                    where od_id = '{$row['od_id']}' ";
            $ct2 = sql_fetch($sql);
            if($ct2['cnt'] > 1)
                    $ct_name .= ' 외 '.($ct2['cnt'] - 1).'건';

            switch($row['od_status']) {
                    case '주문':
                            $od_status = '입금대기중';
                            break;
                    case '입금':
                            $od_status = '입금완료';
                            break;
                    case '준비':
                            $od_status = '배송준비중';
                            break;
                    case '배송':
                            $od_status = '배송중';
                            break;
                    case '완료':
                            $od_status = '배송완료';
                            break;
                    default:
                            $od_status = '주문취소';
                            break;
            }

            $od_invoice = '';
            if($row['od_delivery_company'] && $row['od_invoice'])
                    $od_invoice = get_text($row['od_delivery_company']).' '.get_text($row['od_invoice']);

            $uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);
        ?>

        <li>
            <div class="inquiry_img">
                <a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>" class="link"><?=$thumb ?></a>
            </div>
            <div class="inquiry_des">
                <a class="inquiry_id" href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>">주문번호<span><?php echo $row['od_id']; ?></span></a>
                <p class="inquiry_name"><a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>"><?php echo $ct_name; ?><span class="status rd"><?php echo $od_status; ?></span></a></p>
                <div class="inquiry_btns">
                    <?php if($od_invoice) {
                        echo '<a href="https://www.doortodoor.co.kr/parcel/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no='.$od_invoice.'" class="rd" target="_blank">배송추적</a>';
                    } ?>
                    <a href="" class="rd">리뷰쓰기</a>
                </div>
            </div> <!-- inquiry_des END -->
        </li>

        <?php
        }

        if ($i == 0) // 주문내역이 없으면 NEW ARRIVALS 링크로 유도하기
            echo '<li class="empty_list">주문하신 상품이 없네요.<a href="'.G5_SHOP_URL.'/listtype.php?type=3" class="btn_y rd">지금 구매하러 가기</a></li>';
        ?>
    </ul>
</div>