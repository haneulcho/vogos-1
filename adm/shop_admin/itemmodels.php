<?php
$sub_menu = '500500';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '모델스초이스관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$sql_common = " from {$g5['g5_shop_models_table']} ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = "select * $sql_common order by mds_id desc ";
$result = sql_query($sql);
?>

<div class="local_ov01 local_ov">
    전체 모델스초이스 <?php echo $total_count ?>건
</div>


<div class="btn_add01 btn_add">
    <a href="./itemmodelsform.php">모델스초이스 추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">모델스초이스번호</th>
        <th scope="col">제목</th>
        <th scope="col">연결상품</th>
        <th scope="col">사용</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=mysql_fetch_array($result); $i++) {

        $href = "";
        $sql = " select count(mds_id) as cnt from {$g5['g5_shop_models_item_table']} where mds_id = '{$row['mds_id']}' ";
        $mds = sql_fetch($sql);
        if ($mds['cnt']) {
            $href = '<a href="javascript:;" onclick="itemmodelswin('.$row['mds_id'].');">';
            $href_close = '</a>';
        }
        $subject = $row['mds_subject'];
    ?>

    <tr>
        <td class="td_num"><?php echo $row['mds_id']; ?></td>
        <td><?php echo $subject; ?></td>
        <td class="td_num"><?php echo $href; ?><?php echo $mds['cnt']; ?><?php echo $href_close; ?></td>
        <td class="td_boolean"><?php echo $row['mds_use'] ? '<span class="txt_true">예</span>' : '<span class="txt_false">아니오</span>'; ?></td>
        <td class="td_mng">
            <a href="./itemmodelsform.php?w=u&amp;mds_id=<?php echo $row['mds_id']; ?>">수정</a>
            <a href="<?php echo G5_SHOP_URL; ?>/models.php?mds_id=<?php echo $row['mds_id']; ?>">보기</a>
            <a href="./itemmodelsformupdate.php?w=d&amp;mds_id=<?php echo $row['mds_id']; ?>" onclick="return delete_confirm();">삭제</a>
        </td>
    </tr>

    <?php
    }

    if ($i == 0) {
        echo '<tr><td colspan="5" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>

<script>
function itemmodelswin(mds_id)
{
    window.open("./itemmodelswin.php?mds_id="+mds_id, "itemmodelswin", "left=10,top=10,width=500,height=600,scrollbars=1");
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
