<?php
$sub_menu = '500500';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$sql = " select mds_subject from {$g5['g5_shop_models_table']} where mds_id = '$mds_id' ";
$mds = sql_fetch($sql);

$g5['title'] = $mds['mds_subject'].' 모델스초이스 상품';
include_once(G5_PATH.'/head.sub.php');
?>

<div class="new_win">
    <h1><?php echo $g5['title']; ?></h1>

    <div class="tbl_head01 tbl_wrap">
        <table>
        <caption><?php echo $g5['title']; ?> 입력</caption>
        <thead>
        <tr>
            <th scope="col">상품명</th>
            <th scope="col">사용</th>
            <th scope="col">삭제</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = " select b.it_id, b.it_name, b.it_use from {$g5['g5_shop_models_item_table']} a
                   left join {$g5['g5_shop_item_table']} b on (a.it_id=b.it_id)
                  where a.mds_id = '$mds_id'
                  order by b.it_id desc ";
        $result = sql_query($sql);
        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
        ?>
        <tr>
            <td>
                <a href="<?php echo $href; ?>" target="_blank">
                    <?php echo get_it_image($row['it_id'], 40, 40); ?>
                    <?php echo cut_str(stripslashes($row['it_name']), 60, "&#133"); ?>
                </a>
            </td>
            <td class="td_boolean"><?php echo ($row['it_use']?"사용":"미사용"); ?></td>
            <td class="td_mngsmall"><a href="javascript:del('./itemmodelswindel.php?mds_id=<?php echo $mds_id; ?>&amp;it_id=<?php echo $row['it_id']; ?>');">삭제</a></td>
        <tr>
        <?php
        }
        if ($i == 0)
            echo '<tr><td colspan="3" class="empty_table">자료가 없습니다.</td></tr>';
        ?>
        </tbody>
        </table>
    </div>

    <div class="btn_win01 btn_win">
        <button type="button" onclick="javascript:window.close()">창 닫기</button>
    </div>

</div>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>