<?php
$big_img_count = 0;
for($i=1; $i<=10; $i++) {
    if(!$it['it_img'.$i])
        continue;
    $img = get_it_thumbnail($it['it_img'.$i], $default['de_mimg_width'], $default['de_mimg_height']);
    // 정규식으로 상세정보 작은 이미지의 src, width, height를 가져옴
    if($img) {
        $big_img_count++;

        for($k=0; $k<3; $k++) {
        	if ($k==0) {
        		$regex = '@src="([^"]+)"@';
        	}
        	else if ($k==1) {
        		$regex = '@width\=\"([0-9]+)"@';
        	}
        	else {
        		$regex = '@height\=\"([0-9]+)"@';
        	}
        	preg_match_all($regex, $img, ${'match'.$k});
        	${'s'.$k} = ${'match'.$k}[1][0];
        }
        // 큰 이미지의 width, height를 가져옴
        $size = getimagesize(G5_DATA_PATH.'/item/'.$it['it_img1']);
    }
}
if($big_img_count == 0) {
    $sSrc = '<img src="'.G5_SHOP_URL.'/img/no_image.gif" alt="">';
}
?>
<script>
// img_mag.js에서 사용하는 상품 이미지 돋보기 변수 처리
sSrc = "<?php echo $s0; ?>";
sWidth = "<?php echo $s1; ?>";
sHeight = "<?php echo $s2; ?>";
bSrc = "<?php echo G5_DATA_URL.'/item/'.$it['it_img1']; ?>";
bWidth = "<?php echo $size[0]; ?>";
bHeight = "<?php echo $size[1]; ?>";
</script>
<script src="<?php echo G5_SHOP_SKIN_URL; ?>/img_mag.js"></script>
		<div id="sit_pvi">
            <div id="sit_pvi_img">
    			<div id="sit_pvi_small">
    				<span id="mask">
    					<div></div>
    				</span>
    				<samp id="bg"></samp>
    			</div>
    			<div id="sit_pvi_big">
    			</div>
            </div>
<?php
    if (!empty($it['it_1'])) { // 확장변수 있을 경우 비디오 삽입
    echo "<div id=\"sit_pvi_video_btn\">
        <a onclick=\"javascript:showModal(true)\"><img src=\"".G5_SHOP_SKIN_URL."/img/play_button_info.png\"></a></div>"; // view video 버튼
    echo "<div class=\"modal_info\"><div id=\"sit_pvi_video\"><video controls=\"controls\">
        <source src=\"".$it['it_1']."\" type=\"video/mp4\"></video></div></div>"; // video modal창
    }
?>
<?php
    if (!empty($it['it_1'])) {
?>
<?php
    }
?>
        </div> <!-- sit_pvi END -->