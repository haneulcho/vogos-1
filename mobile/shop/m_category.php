<?php
$ca = $_GET['ca'];

if($ca) {
    $ca_len = strlen($ca) + 2;
    $sql_where = " where ca_id like '$ca%' and length(ca_id) = $ca_len ";
} else {
    $sql_where = " where length(ca_id) = '2' ";
}

$sql = " select ca_id, ca_name from {$g5['g5_shop_category_table']}
          $sql_where
            and ca_use = '1'
          order by ca_order, ca_id ";
$result = sql_query($sql);
?>

<div class="hamburger">
  <div class="hamburger-inner">
    <div class="bar bar1 hide"></div>
    <div class="bar bar2 cross"></div>
    <div class="bar bar3 cross hidden"></div>
    <div class="bar bar4 hide"></div>
  </div>
</div>

<div id="sct_win">

    <h1><?php echo $config['cf_title']; ?> 카테고리</h1>

<div class="mobile-menu">
  <div class="mobile-menu-inner">


    <?php
    for($i=0; $row=sql_fetch_array($result); $i++) {
        if($i == 0)
            echo '<nav><h2>카테고리 목록</h2><ul>';

        $ca_href = G5_SHOP_URL.'/category.php?ca='.$row['ca_id'];
        $list_href = G5_SHOP_URL.'/list.php?ca_id='.$row['ca_id'];
    ?>
        <li>
            <a href="<?php echo $list_href; ?>"><?php echo $row['ca_name']; ?></a>
        </li>

    <?php
    }

    if($i > 0)
        echo '</ul></nav>';

    if($i ==0) {
        echo '<p id="sct_win_empty">하위 분류가 없습니다.</p>';
    }
    ?>
  </div>
</div>




</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.15.0/TweenMax.min.js"></script>
<script src="<?php echo G5_MSHOP_SKIN_URL; ?>/js/jv-jquery-mobile-menu-min.js"></script>
<script src="<?php echo G5_MSHOP_SKIN_URL; ?>/js/script.js"></script>
