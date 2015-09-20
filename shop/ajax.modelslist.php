<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/json.lib.php');

$data = array();

$sql = " select *
           from {$g5['g5_shop_models_table']}";
$mds = sql_fetch($sql);

// 스킨경로
$skin_dir = G5_MSHOP_SKIN_PATH;

$skin_file = $skin_dir."/list.models.10.skin.php";
$order_by = 'mds_id desc';

// 총몇개 = 한줄에 몇개 * 몇줄
$list_mod = 1;
$list_row = 8;
$items = $list_mod * $list_row;
// 페이지가 없으면 첫 페이지 (1 페이지)
if ($page < 1) $page = 1;

$page++;

// 시작 레코드 구함
$from_record = ($page - 1) * $items;

ob_start();

$list = new item_list($skin_file, $list_mod, $list_row);
$list->set_order_by($order_by);
$list->set_is_mdschoice(true);
$list->set_is_page(true);
$list->set_mobile(true);
$list->set_list_mod($list_mod);
$list->set_list_row($list_row);
$list->set_from_record($from_record);
$list->set_view('it_icon', false); // 추천, 신상, 베스트 아이콘 안 보이게
$list->set_view('sns', false); // sns 아이콘 안 보이게
echo $list->run();

$content = ob_get_contents();
ob_end_clean();

$data['item']  = $content;
$data['error'] = '';
$data['page']  = $page;

die(json_encode($data));
?>