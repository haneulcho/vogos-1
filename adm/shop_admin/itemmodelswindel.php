<?php
$sub_menu = '500500';
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "d");

$sql = " delete from {$g5['g5_shop_models_item_table']} where mds_id = '$mds_id' and it_id = '$it_id' ";
sql_query($sql);

goto_url("./itemmodelswin.php?mds_id=$mds_id");
?>
