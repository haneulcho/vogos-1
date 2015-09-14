<?php
include_once('./_common.php');

include_once(G5_MSHOP_PATH.'/_head.php');

define('G5_SHOP_CSS_URL', G5_MSHOP_SKIN_URL);

$sql = " select * from {$g5['g5_shop_models_table']} where mds_use = '1' ";
$mds = sql_fetch($sql);
if (!$mds['mds_id'])
    alert('등록된 모델스초이스가 없습니다.');

$g5['title'] = '모델스초이스 리스트';

// 스킨경로
$skin_dir = G5_MSHOP_SKIN_PATH;

add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 모델스초이스 목록 시작 { -->
<div id="sct" class="sct_wrap">
    <div id="sct_location">
        <a href="<?php echo G5_MSHOP_URL; ?>/" class="sct_bg">Home</a>
        <a href="<?php echo G5_MSHOP_URL.'/modelslist.php' ?>" class="sct_here">Model's Choice</a>
    </div>
    <p align="center"><img src="<?php echo G5_SHOP_SKIN_URL.'/img/title_models.jpg'; ?>" style="width:100%" alt="모델스초이스"></p>
<?php
define('G5_MSHOP_CSS_URL', G5_MSHOP_SKIN_URL);

$models_skin = $skin_dir."/{$mds['mds_skin']}";

if (file_exists($models_skin))
{
    // 총몇개 = 한줄에 몇개 * 몇줄
    $items = 1 * 8;
    // 페이지가 없으면 첫 페이지 (1 페이지)
    if ($page < 1) $page = 1;
    // 시작 레코드 구함
    $from_record = ($page - 1) * $items;

    $sql = " select *
                from {$g5['g5_shop_models_table']} where mds_use = '1'                
                order by mds_id desc
                limit 0, $items ";
    $result = sql_query($sql);

}
?>

    <ul id="mds_list">
<?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
?>
    <li>
    <a class="mds_href" href="<?php echo G5_MSHOP_URL.'/models.php?mds_id='.$row['mds_id'] ?>">
        <div class="mds_bimg">
            <?php
            $bimg_str = "";
            $bimg = G5_DATA_PATH.'/models/'.$row['mds_id'].'_b';

            if (file_exists($bimg)) {
                $bimg_str = '<img src="'.G5_DATA_URL.'/models/'.$row['mds_id'].'_b" alt="">';
            }
            if ($bimg_str) {
                echo $bimg_str;
            }
            ?>
        </div>
        <div class="mds_des">
            <h3 class="mds_subject"><?=$row['mds_subject'] ?></h3>
            <?php
                $cut_summary = strip_tags($cut_summary);
                $cut_summary = mb_substr($row['mds_html'], 0, 214, "UTF-8");
                $cut_summary.= "...";
            ?>
            <div class="mds_sum"><?=$cut_summary; ?><span style="display:inline-block;float:right;color:#888;font-weight:bold;font-size:13px;">&gt; 더보기</span>
            <ul id="mds_imglist">
                <!-- 모델스초이스 영상 캡쳐이미지 리스트에서 최대 3개 출력 -->
                <?php for($i=1; $i<=3; $i++) { ?>
                <li>
                    <?php
                    $simg_str = "";
                    $simg = G5_DATA_PATH.'/models/'.$row['mds_id'].'_s'.$i;

                    if (file_exists($simg)) {
                        $simg_str = '<img src="'.G5_DATA_URL.'/models/'.$row['mds_id'].'_s'.$i.'" width="60" alt="">';
                    }
                    if ($simg_str) {
                        echo $simg_str;
                    }
                    ?>
                </li>
                <?php } ?>
                <!-- 모델스초이스 영상 캡쳐이미지 리스트에서 최대 3개 출력 -->
            </ul>
            </div>
        </div>
    </a>
    </li>
    <?php } // for END ?>
    </ul>
</div>
<?php
    // where 된 전체 상품수
    $total_count = $list->total_count;
    // 전체 페이지 계산
    $total_page  = ceil($total_count / $items);

$qstr .= 'skin='.$skin.'&amp;mds_id='.$mds_id.'&amp;sort='.$sort.'&amp;sortodr='.$sortodr;
echo get_paging($config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page=");

?>

<!-- } 모델스초이스 끝 -->

<?php
include_once(G5_MSHOP_PATH.'/_tail.php');
?>
