<?php
$sub_menu = '500500';
include_once('./_common.php');

if ($w == "u" || $w == "d")
    check_demo();

if ($w == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

@mkdir(G5_DATA_PATH."/models", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/models", G5_DIR_PERMISSION);

if ($mds_bimg_del)  @unlink(G5_DATA_PATH."/models/{$mds_id}_b"); // 영상대표이미지
if ($mds_simg1_del)  @unlink(G5_DATA_PATH."/models/{$mds_id1}_s"); // 영상서브캡쳐이미지
if ($mds_simg2_del)  @unlink(G5_DATA_PATH."/models/{$mds_id2}_s");
if ($mds_simg3_del)  @unlink(G5_DATA_PATH."/models/{$mds_id3}_s");
if ($mds_simg4_del)  @unlink(G5_DATA_PATH."/models/{$mds_id4}_s");
if ($mds_simg5_del)  @unlink(G5_DATA_PATH."/models/{$mds_id5}_s");
if ($mds_simg6_del)  @unlink(G5_DATA_PATH."/models/{$mds_id6}_s");
if ($mds_simg7_del)  @unlink(G5_DATA_PATH."/models/{$mds_id7}_s");
if ($mds_simg8_del)  @unlink(G5_DATA_PATH."/models/{$mds_id8}_s");

$sql_common = " set mds_skin             = '$mds_skin',
                    mds_mobile_skin      = '$mds_mobile_skin',
                    mds_bimg_width        = '$mds_bimg_width',
                    mds_bimg_height       = '$mds_bimg_height',
                    mds_simg_width        = '$mds_simg_width',
                    mds_simg_height       = '$mds_simg_height',
                    mds_list_mod         = '$mds_list_mod',
                    mds_list_row         = '$mds_list_row',
                    mds_mobile_img_width = '$mds_mobile_img_width',
                    mds_mobile_img_height= '$mds_mobile_img_height',
                    mds_mobile_list_mod  = '$mds_mobile_list_mod',
                    mds_subject          = '$mds_subject',
                    mds_html        = '$mds_html',
                    mds_use              = '$mds_use'
                    ";

if ($w == "")
{
    $mds_id = G5_SERVER_TIME;

    $sql = " insert {$g5['g5_shop_models_table']}
                    $sql_common
                  , mds_id = '$mds_id' ";
    sql_query($sql);
}
else if ($w == "u")
{
    $sql = " update {$g5['g5_shop_models_table']}
                $sql_common
              where mds_id = '$mds_id' ";
    sql_query($sql);
}
else if ($w == "d")
{
    @unlink(G5_DATA_PATH."/models/{$mds_id}_b"); // 영상대표이미지
    @unlink(G5_DATA_PATH."/models/{$mds_id1}_s");
    @unlink(G5_DATA_PATH."/models/{$mds_id2}_s");
    @unlink(G5_DATA_PATH."/models/{$mds_id3}_s");
    @unlink(G5_DATA_PATH."/models/{$mds_id4}_s");
    @unlink(G5_DATA_PATH."/models/{$mds_id5}_s");
    @unlink(G5_DATA_PATH."/models/{$mds_id6}_s");
    @unlink(G5_DATA_PATH."/models/{$mds_id7}_s");
    @unlink(G5_DATA_PATH."/models/{$mds_id8}_s");

    // 모델스초이스 상품삭제
    $sql = " delete from {$g5['g5_shop_models_item_table']} where mds_id = '$mds_id' ";
    sql_query($sql);

    $sql = " delete from {$g5['g5_shop_models_table']} where mds_id = '$mds_id' ";
    sql_query($sql);
}

if ($w == "" || $w == "u")
{
    // 모델스초이스 대표이미지 및 영상서브캡쳐이미지 업로드
    if ($_FILES['mds_bimg']['name']) upload_file($_FILES['mds_bimg']['tmp_name'], $mds_id."_b", G5_DATA_PATH."/models");
    if ($_FILES['mds_simg1']['name']) upload_file($_FILES['mds_simg1']['tmp_name'], $mds_id."_s", G5_DATA_PATH."/models");
    if ($_FILES['mds_simg2']['name']) upload_file($_FILES['mds_simg2']['tmp_name'], $mds_id."_s", G5_DATA_PATH."/models");
    if ($_FILES['mds_simg3']['name']) upload_file($_FILES['mds_simg3']['tmp_name'], $mds_id."_s", G5_DATA_PATH."/models");
    if ($_FILES['mds_simg4']['name']) upload_file($_FILES['mds_simg4']['tmp_name'], $mds_id."_s", G5_DATA_PATH."/models");
    if ($_FILES['mds_simg5']['name']) upload_file($_FILES['mds_simg5']['tmp_name'], $mds_id."_s", G5_DATA_PATH."/models");
    if ($_FILES['mds_simg6']['name']) upload_file($_FILES['mds_simg6']['tmp_name'], $mds_id."_s", G5_DATA_PATH."/models");
    if ($_FILES['mds_simg7']['name']) upload_file($_FILES['mds_simg7']['tmp_name'], $mds_id."_s", G5_DATA_PATH."/models");
    if ($_FILES['mds_simg8']['name']) upload_file($_FILES['mds_simg8']['tmp_name'], $mds_id."_s", G5_DATA_PATH."/models");

    // 등록된 모델스초이스 상품 먼저 삭제
    $sql = " delete from {$g5['g5_shop_models_item_table']} where mds_id = '$mds_id' ";
    sql_query($sql);

    // 모델스초이스 상품등록
    $item = explode(',', $mds_item);
    $count = count($item);

    for($i=0; $i<$count; $i++) {
        $it_id = $item[$i];
        if($it_id) {
            $sql = " insert into {$g5['g5_shop_models_item_table']}
                        set mds_id = '$mds_id',
                            it_id = '$it_id' ";
            sql_query($sql);
        }
    }

    goto_url("./itemmodelsform.php?w=u&amp;mds_id=$mds_id");
}
else
{
    goto_url("./itemmodels.php");
}
?>