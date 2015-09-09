<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/models.php');
    return;
}

$mds_id = trim($_GET['mds_id']);

// 모델스초이스 게시글의 정보를 얻음
$sql = " select * from {$g5['g5_shop_models_table']} where mds_id = '$mds_id' ";
$mds = sql_fetch($sql);
if (!$mds['mds_id'])
    alert('모델스초이스 게시글이 없습니다.');
if (!($mds['mds_use'])) {
    if (!$is_admin)
        alert('현재 진행중인 모델스초이스가 아닙니다.');
}

// 조회수 증가
if (get_cookie('ck_mds_id') != $mds_id) {
    sql_query(" update {$g5['g5_shop_models_table']} set mds_hit = mds_hit + 1 where mds_id = '$mds_id' "); // 1증가
    set_cookie("ck_mds_id", $mds_id, time() + 3600); // 1시간동안 저장
}

// 스킨경로
$skin_dir = G5_PATH.'/'.G5_SKIN_DIR.'/shop/vogos_pc';

if(is_dir($skin_dir)) {
    $form_skin_file = $skin_dir.'/models.form.skin.php';
}

define('G5_SHOP_CSS_URL', str_replace(G5_PATH, G5_URL, $skin_dir));

$g5['title'] = $mds['mds_subject'].' &gt; 모델스초이스';

// 기본 상단 코드 출력
    include_once('./_head.php');

if ($is_admin) {
    echo '<div class="sit_admin"><a href="'.G5_ADMIN_URL.'/shop_admin/itemmodelsform.php?w=u&amp;mds_id='.$mds_id.'" class="btn_admin">모델스초이스 관리</a></div>';
}
?>

<!-- 모델스초이스 상세보기 시작 { -->
<?php
// 보안서버경로
if (G5_HTTPS_DOMAIN)
    $action_url = G5_HTTPS_DOMAIN.'/'.G5_SHOP_DIR.'/cartupdate.php';
else
    $action_url = './cartupdate.php';

// 이전 상품보기
$sql = " select mds_id, mds_subject from {$g5['g5_shop_models_table']} where mds_id > '$mds_id' and mds_use = '1' order by mds_id asc limit 1 ";
$row = sql_fetch($sql);
if ($row['mds_id']) {
    $prev_title = '<img src="'.G5_SHOP_SKIN_URL.'/img/lArrow.png" alt="이전 모델스초이스"><span class="sound_only"> '.$row['mds_subject'].'</span>';
    $prev_href = '<a href="./models.php?mds_id='.$row['mds_id'].'" id="siblings_prev">';
    $prev_href2 = '</a>'.PHP_EOL;
} else {
    $prev_title = '';
    $prev_href = '';
    $prev_href2 = '';
}

// 다음 상품보기
$sql = " select mds_id, mds_subject from {$g5['g5_shop_models_table']} where mds_id < '$mds_id' and mds_use = '1' order by mds_id desc limit 1 ";
$row = sql_fetch($sql);
if ($row['mds_id']) {
    $next_title = '<img src="'.G5_SHOP_SKIN_URL.'/img/rArrow.png" alt="다음 모델스초이스"><span class="sound_only"> '.$row['mds_subject'].'</span>';
    $next_href = '<a href="./models.php?mds_id='.$row['mds_id'].'" id="siblings_next">';
    $next_href2 = '</a>'.PHP_EOL;
} else {
    $next_title = '';
    $next_href = '';
    $next_href2 = '';
}

// 관련상품의 개수를 얻음
$sql = " select count(*) as cnt from {$g5['g5_shop_models_item_table']} a left join {$g5['g5_shop_models_table']} b on (a.mds_id2=b.mds_id and b.mds_use='1') where a.mds_id = '{$mds['mds_id']}' ";
$row = sql_fetch($sql);
$models_relation_count = $row['cnt'];

// 소셜 관련
$sns_title = get_text($mds['mds_subject']).' | '.get_text($config['cf_title']);
$sns_url  = G5_SHOP_URL.'/models.php?mds_id='.$mds['mds_id'];
$sns_share_links .= get_sns_share_link('facebook', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/sns_fb_s.png', $thumb_url).' ';
$sns_share_links .= get_sns_share_link('twitter', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/sns_twt_s.png', $thumb_url).' ';
$sns_share_links .= get_sns_share_link('googleplus', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/sns_goo_s.png', $thumb_url);

?>

<?php if($is_orderable) { ?>
<script src="<?php echo G5_JS_URL; ?>/shop.js"></script>
<?php } ?>

<div id="sit">

    <?php
    // 상품 상세정보
    $info_skin = $skin_dir.'/models.item.info.skin.php';
    if(!is_file($info_skin))
        $info_skin = G5_SHOP_SKIN_PATH.'/models.info.skin.php';
    include $info_skin;
    ?>

</div>

<?php
include_once('./_tail.php');
?>