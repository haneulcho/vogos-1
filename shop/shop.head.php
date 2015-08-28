<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 상단 파일 지정 : 이 코드는 가능한 삭제하지 마십시오.
if ($default['de_include_head'] && is_file(G5_SHOP_PATH.'/'.$default['de_include_head'])) {
    include_once(G5_SHOP_PATH.'/'.$default['de_include_head']);
    return; // 이 코드의 아래는 실행을 하지 않습니다.
}

include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

if ($member['mb_level'] < 4 ) { 
  alert("VOGOS 관리자만 접근하실 수 있습니다. 로그인 하십시오.", G5_BBS_URL.'/login_guest.php?url=' . urlencode(G5_SHOP_URL));
}
?>
<?php if(defined('_INDEX_')) { ?>
<!-- 인덱스 슬라이더 owl carousel -->
<script src="<?php echo G5_SHOP_SKIN_URL; ?>/js/owl.carousel.min.js"></script>
<?php } ?>
<!-- 상단 시작 { -->
<div id="vogos">
    <div id="header" class="w940">
        <?php include(G5_SHOP_SKIN_PATH.'/boxtodayview.skin.php'); // 오늘 본 상품 ?>
        <aside id="topInfo">
            <ul id="topNav">
                <li><a href="#"><img src="<?php echo G5_SHOP_SKIN_URL; ?>/img/sns_insta_s.png" alt="VOGOS 인스타그램"></a></li>
                <li><a href="#"><img src="<?php echo G5_SHOP_SKIN_URL; ?>/img/sns_fb_s.png" alt="VOGOS 페이스북"></a></li>
                <li><a href="#"><img src="<?php echo G5_SHOP_SKIN_URL; ?>/img/sns_ks_s.png" alt="VOGOS 카카오스토리"></a></li>
            </ul>
        </aside>
        <?php include_once(G5_SHOP_SKIN_PATH.'/boxevent.skin.php'); // 이벤트, 기획전 배너 연동 ?>
        <h1 id="topLogo"><a href="<?php echo $default['de_root_index_use'] ? G5_URL : G5_SHOP_URL; ?>/"><?php echo $config['cf_title']; ?></a></h1>
        <!-- 검색창 -->
        <div id="hd_sch">
            <h3>쇼핑몰 검색</h3>
            <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);">
                <label for="sch_str" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
                <input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_str" required>
                <input type="image" src="http://vogostest.cafe24.com/skin/shop/vogos_pc/img/search.png" value="검색" id="sch_submit">
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
        <!-- join, sign in etc... sub nav -->
        <div id="tnb">
            <h3>회원메뉴</h3>
            <ul>
                <?php if ($is_member) { ?>
                <?php if ($is_admin) {  ?>
                <li class="tadmin"><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/">Admin</a></li>
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
                <?php
                if(!$default['de_root_index_use']) {
                    $com_href = G5_URL;
                    $com_name = '커뮤니티';

                    if($default['de_shop_layout_use']) {
                        if(!preg_match('#'.G5_SHOP_DIR.'/#', $_SERVER['SCRIPT_NAME'])) {
                            $com_href = G5_SHOP_URL;
                            $com_name = '쇼핑몰';
                        }
                    }
                ?>
                <li><a href="<?php //echo $com_href; ?>/"><?php //echo $com_name; ?></a></li>
                <?php
                    unset($com_href);
                    unset($com_name);
                }
                ?>
            </ul>
        </div>
    </div> <!-- id="header" -->
    <!-- global navigation -->
    <?php include_once(G5_SHOP_SKIN_PATH.'/boxcategory.skin.php'); // 상품분류 ?>

    <div id="vWrapper"> <!-- contents wrapper -->
    <?php if(defined('_INDEX_')) { ?>
        <div id="mWrapper">
            <div id="index_top" class="w940">
                <div id="slider"> <!-- slider contents -->
                    <?php if($default['de_type4_list_use']) { ?>
                    <!-- 인기상품 시작 { -->
                    <section>
                        <header>
                            <h2 class="best_item"><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=4">BEST ITEMS</a></h2>
                            <!-- <p class="sct_wrap_hdesc"><?php echo $config['cf_title']; ?> 인기상품 모음</p> -->
                        </header>
                        <?php
                        $list = new item_list();
                        $list->set_type(4);
                        $list->set_view('it_id', false);
                        $list->set_view('it_name', true);
                        $list->set_view('it_basic', true);
                        $list->set_view('it_cust_price', true);
                        $list->set_view('it_price', true);
                        $list->set_view('it_icon', false);
                        $list->set_view('sns', false);
                        echo $list->run();
                        ?>
                    </section>
                    <!-- } 인기상품 끝 -->
                    <?php } ?>

                    <?php if($default['de_type2_list_use']) { ?>
                    <!-- 추천상품 시작 { -->
                    <section>
                        <header>
                            <h2 class="md_choice"><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=2">MD's CHOICE</a></h2>
                            <!-- <p class="sct_wrap_hdesc"><?php echo $config['cf_title']; ?> 추천상품 모음</p> -->
                        </header>
                        <?php
                        $list = new item_list();
                        $list->set_type(2);
                        $list->set_view('it_id', false);
                        $list->set_view('it_name', true);
                        $list->set_view('it_basic', true);
                        $list->set_view('it_cust_price', true);
                        $list->set_view('it_price', true);
                        $list->set_view('it_icon', false);
                        $list->set_view('sns', false);
                        echo $list->run();
                        ?>
                    </section>
                    <!-- } 추천상품 끝 -->
                    <?php } ?>
                </div> <!-- slider end -->

                <!-- 보고스 대표 동영상 시작 { -->
                <div id="main_video">
                    <?php if($default['de_index_video_use']) { ?>
                    <?php echo '<iframe src="https://player.vimeo.com/video/'.$default['de_index_video_src'].'?autoplay=1&byline=0" width="'.$default['de_index_video_width'].'" height="'.$default['de_index_video_height'].'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                    ?>
                    <?php } ?>
                </div> <!-- } 보고스 대표 동영상 끝 -->
            </div> <!-- index_top 끝 -->
        </div> <!-- mWrapper 끝 -->
    <?php } ?>

        <!-- main contents -->
        <div id="contents" class="w940">
        <?php //if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) { ?><div id="wrapper_title"><?php //echo $g5['title'] ?></div><?php //} ?>
        <!-- 글자크기 조정 display:none 되어 있음 시작 { -->
        <div id="text_size">
            <button class="no_text_resize" onclick="font_resize('container', 'decrease');">작게</button>
            <button class="no_text_resize" onclick="font_default('container');">기본</button>
            <button class="no_text_resize" onclick="font_resize('container', 'increase');">크게</button>
        </div>
        <!-- } 글자크기 조정 display:none 되어 있음 끝 -->