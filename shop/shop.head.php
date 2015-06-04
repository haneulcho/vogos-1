<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

// 상단 파일 지정 : 이 코드는 가능한 삭제하지 마십시오.
if ($default['de_include_head'] && is_file(G5_SHOP_PATH.'/'.$default['de_include_head'])) {
    include_once(G5_SHOP_PATH.'/'.$default['de_include_head']);
    return; // 이 코드의 아래는 실행을 하지 않습니다.
}
?>
<!-- 상단 시작 { -->
<div id="vogos">
    <div id="header">
        <h1 id="topLogo"><a href="<?php echo $default['de_root_index_use'] ? G5_URL : G5_SHOP_URL; ?>/"><?php echo $config['cf_title']; ?></a></h1>
    </div>
    <div id="vWrapper">
        <div id="tnb"> <!-- join, sign in etc... sub nav -->
            <h3>회원메뉴</h3>
            <ul>
                <?php if ($is_member) { ?>
                <?php if ($is_admin) {  ?>
                <li class="tadmin"><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/"><b>Admin</b></a></li>
                <?php }  ?>
                <li class="tmypage"><a href="<?php echo G5_SHOP_URL; ?>/mypage.php">My Page</a></li>
                <li class="tsignout"><a href="<?php echo G5_BBS_URL; ?>/logout.php?url=shop">Sign Out</a></li>
                <?php } else { ?>
                <li class="tjoin"><a href="<?php echo G5_BBS_URL; ?>/register.php">Join</a></li>
                <li class="tsignin"><a href="<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo $urlencode; ?>"><b>Sign In</b></a></li>
                <?php } ?>
            </ul>
            <ul>
                <li class="tfaq"><a href="<?php echo G5_BBS_URL; ?>/faq.php">FAQ</a></li>
                <li class="tqna"><a href="<?php echo G5_BBS_URL; ?>/qalist.php">Q&amp;A</a></li>
                <li class="tonlyu"><a href="<?php echo G5_SHOP_URL; ?>/personalpay.php">Only You</a></li>
                <li class="treviews"><a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php">Reviews</a></li>
                <?php if(!$default['de_root_index_use']) { ?>
                <!-- <li><a href="<?php echo G5_URL; ?>/">커뮤니티</a></li> -->
                <?php } ?>
            </ul>
        </div>

        <div id="container"> <!-- contents wrapper -->

            <div id="side"> <!-- side contents -->
                <?php include_once(G5_SHOP_SKIN_PATH.'/boxcategory.skin.php'); // 상품분류 ?>
                <div id="hd_sch">
                    <h3>쇼핑몰 검색</h3>
                    <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);">
                        <label for="sch_str" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
                        <input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_str" required>
                        <input type="submit" value="검색" id="sch_submit">
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
                </div>

                <?php include(G5_SHOP_SKIN_PATH.'/boxtodayview.skin.php'); // 오늘 본 상품 ?>

                <div id="lst">
                    <?php //echo outlogin('shop_basic'); // 아웃로그인 ?>

                    <?php //include_once(G5_SHOP_SKIN_PATH.'/boxcart.skin.php'); // 장바구니 ?>

                    <?php //include_once(G5_SHOP_SKIN_PATH.'/boxwish.skin.php'); // 위시리스트 ?>

                    <?php //include_once(G5_SHOP_SKIN_PATH.'/boxevent.skin.php'); // 이벤트 ?>

                    <?php //include_once(G5_SHOP_SKIN_PATH.'/boxcommunity.skin.php'); // 커뮤니티 ?>

                    <!-- 쇼핑몰 배너 시작 { -->
                    <?php echo display_banner('왼쪽'); ?>
                    <!-- } 쇼핑몰 배너 끝 -->
                </div>

            </div> <!-- side end -->

            <div id="contents"> <!-- main contents -->
                <?php if(defined('_INDEX_')) { ?>
                <div id="hd_video"> <!-- weekly video -->
                    <embed src="http://smarturl.it/jwplayer59" type="application/x-shockwave-flash" allowfullscreen="true" flashvars="skin=http://cfs.tistory.com/custom/blog/152/1525660/skin/images/skin2.swf&amp;file=http://www.googledrive.com/host/0B1nP4TpJdXCbSnYtbEM3aHhRdms&amp;type=video&amp;autostart=false&amp;repeat=always"></embed>
                </div> <!-- weekly video end -->
                <?php } ?>

            <!-- 콘텐츠 시작 { -->
            <?php //if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) { ?><div id="wrapper_title"><?php //echo $g5['title'] ?></div><?php //} ?>
            <!-- 글자크기 조정 display:none 되어 있음 시작 { -->
            <div id="text_size">
                <button class="no_text_resize" onclick="font_resize('container', 'decrease');">작게</button>
                <button class="no_text_resize" onclick="font_default('container');">기본</button>
                <button class="no_text_resize" onclick="font_resize('container', 'increase');">크게</button>
            </div>
            <!-- } 글자크기 조정 display:none 되어 있음 끝 -->