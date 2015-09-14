<?php
$cate = $_GET['ca'];

if($cate) {
    $ca_len = strlen($cate) + 2;
    $sql_where = " where ca_id like '$cate%' and length(ca_id) = $ca_len ";
} else {
    $sql_where = " where length(ca_id) = '2' ";
}

$sqlcate = " select ca_id, ca_name from {$g5['g5_shop_category_table']}
          $sql_where
            and ca_use = '1'
          order by ca_order, ca_id ";
$result = sql_query($sqlcate);
?>
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" media="screen" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<div id="hamburger">
    <i class="ion-navicon"></i>
</div>
<div id="sct_win" class="mobile-menu">
  <div class="mobile-menu-inner">
    <ul id="userNav">
        <?php if ($is_member) { ?>
        <?php if ($is_admin) {  ?>
        <li><a href="<?php echo G5_ADMIN_URL ?>/shop_admin/"><i class="ion-android-settings"></i>ADMIN</a></li>
        <?php }  ?>
        <!-- <li><a href="<?php //echo G5_BBS_URL ?>/member_confirm.php?url=<?php //echo G5_BBS_URL ?>/register_form.php">정보수정</a></li> -->
        <li><a href="<?php echo G5_BBS_URL; ?>/logout.php?url=shop"><i class="ion-android-unlock"></i>SIGN OUT</a></li>
        <li><a href="<?php echo G5_SHOP_URL; ?>/mypage.php"><i class="ion-android-person"></i>MY PAGE</a></li>
        <?php } else { ?>
        <li><a href="<?php echo G5_BBS_URL ?>/register.php" id="snb_join"><i class="ion-android-person-add"></i>JOIN</a></li>
        <li><a href="<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo $urlencode; ?>"><i class="ion-android-lock"></i>SIGN IN</a></li>
        <?php } ?>
    </ul>

    <!-- 검색 처리 -->
    <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);">
    <aside id="hd_sch">
        <div class="sch_inner">
            <h2>상품 검색</h2>
            <label for="sch_str" class="sound_only">상품명<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_str" required class="frm_input">
            <button type="submit" class="btn_submit"><i class="ion-android-search"></i></button>
        </div>
    </aside>
    </form>

    <script>
    function search_submit(f) {
        if (f.q.value.length < 2) {
            alert("검색어는 두글자 이상 입력하십시오.");
            f.q.select();
            f.q.focus();
            return false;
        }

        return true;
    }
    </script>
    <!-- 검색 처리 end -->

    <?php
    for($i=0; $row=sql_fetch_array($result); $i++) {
        if($i == 0) {
            echo '<nav><h2>카테고리 목록</h2><ul>';
        }

        $ca_href = G5_SHOP_URL.'/category.php?ca='.$row['ca_id'];
        $list_href = G5_SHOP_URL.'/list.php?ca_id='.$row['ca_id'];
    ?>
        <li>
            <a href="<?php echo $list_href; ?>"><?php echo $row['ca_name']; ?></a>
        </li>

    <?php
    }

    if($i > 0) {
        // echo '<li><a href="'.G5_MSHOP_URL.'/list_all.php">All Items</a></li>'; All Items 임시 주석처리 (To Do: Ajax Paging)
        echo '</ul></nav>';
    }

    if($i ==0) {
        echo '<p id="sct_win_empty">하위 분류가 없습니다.</p>';
    }
    ?>
    <ul id="otherNav">
        <li><a href="<?php echo G5_SHOP_URL; ?>/cart.php"><i class="ion-android-cart"></i>CART</a></li>
        <li><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=notice"><i class="ion-speakerphone"></i>NOTICE</a></li>
        <li><a href="<?php echo G5_BBS_URL; ?>/faq.php"><i class="ion-android-happy"></i>FAQ</a></li>
        <li><a href="<?php echo G5_BBS_URL; ?>/qalist.php"><i class="ion-chatbubbles"></i>QNA</a></li>
    </ul>
  </div> <!-- inner end -->
</div>