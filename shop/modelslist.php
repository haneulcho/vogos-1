<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/modelslist.php');
    return;
}

$sql = " select * from {$g5['g5_shop_models_table']} where mds_use = '1' ";
$mds = sql_fetch($sql);
if (!$mds['mds_id'])
    alert('등록된 모델스초이스가 없습니다.');

$g5['title'] = '모델스초이스';

$og_title = '모델스초이스 | VOGOS';
$og_url = G5_SHOP_URL.'/modelslist.php';
$og_img = G5_SHOP_SKIN_URL.'/img/og_img.png';
$og_description = 'Everywhere is Runway, Everyday VOGOS';

include_once('./_head.php');


// 스킨경로
$skin_dir = G5_SHOP_SKIN_PATH;

define('G5_SHOP_CSS_URL', str_replace(G5_PATH, G5_URL, $skin_dir));

if ($is_admin)
    echo '<div class="sev_admin"><a href="'.G5_ADMIN_URL.'/shop_admin/itemmodels.php" class="btn_admin">모델스초이스 관리</a></div>';
?>

<!-- 모델스초이스 목록 시작 { -->
<div id="sct" class="sct_wrap">
    <div id="sct_location">
        <a href="<?php echo G5_SHOP_URL; ?>/" class="sct_bg">Home</a>
        <a href="<?php echo G5_SHOP_URL.'/modelslist.php' ?>" class="sct_here">Model's Choice</a>
    </div>
    <p align="center"><img src="<?php echo G5_SHOP_SKIN_URL.'/img/title_models.jpg'; ?>" alt="모델스초이스"></p>
<?php
define('G5_SHOP_CSS_URL', G5_SHOP_SKIN_URL);

$skin_file = $skin_dir."/list.models.10.skin.php";

if (file_exists($skin_file))
{
    // 총몇개 = 한줄에 몇개 * 몇줄
    $list_mod = 1;
    $list_row = 12;
    $items = $list_mod * $list_row;
    // 페이지가 없으면 첫 페이지 (1 페이지)
    if ($page < 1) $page = 1;
    // 시작 레코드 구함
    $from_record = ($page - 1) * $items;
    $order_by = "mds_id desc";
}

    $list = new item_list($skin_file, $list_mod, $list_row);
    $list->set_order_by($order_by);
    $list->set_is_mdschoice(true);
    $list->set_is_page(true);
    $list->set_list_mod($list_mod);
    $list->set_list_row($list_row);
    $list->set_from_record($from_record);
    $list->set_view('it_icon', false); // 추천, 신상, 베스트 아이콘 안 보이게
    $list->set_view('sns', false); // sns 아이콘 안 보이게
    echo $list->run();

    // where 된 전체 상품수
    $total_count = $list->total_count;
    // 전체 페이지 계산
    $total_page  = ceil($total_count / $items);
?>

</div>
<?php
    echo get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?');
?>

<!-- } 모델스초이스 끝 -->

<?php
include_once('./_tail.php');
?>
