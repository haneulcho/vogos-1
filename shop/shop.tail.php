<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 하단 파일 지정 : 이 코드는 가능한 삭제하지 마십시오.
if ($default['de_include_tail'] && is_file(G5_SHOP_PATH.'/'.$default['de_include_tail'])) {
    include_once(G5_SHOP_PATH.'/'.$default['de_include_tail']);
    return; // 이 코드의 아래는 실행을 하지 않습니다.
}

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.
?>
        </div> <!-- main contents end -->
        <div id="ftMenu">
            <img src="<?php echo G5_SHOP_SKIN_URL ?>/img/footer_info.png" usemap="vogos_ft_imageMap" alt="VOGOS Navigation" />
            <map name="vogos_ft_imageMap">
            <area alt="Notice, Event" href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=notice" shape="rect" coords="852,35,956,60" style="outline:none;" target="_self" />
            <area alt="My page" href="<?php echo G5_SHOP_URL; ?>/mypage.php" shape="rect" coords="851,60,916,85" style="outline:none;" target="_self" />
            <area alt="QnA" title="" href="<?php echo G5_BBS_URL; ?>/qalist.php" shape="rect" coords="916,61,959,85" style="outline:none;" target="_self" />
            <area alt="" title="" href="<?php echo G5_SHOP_URL; ?>/itemuselist.php" shape="rect" coords="955,62,1017,86" style="outline:none;" target="_self" />
            <area alt="" title="" href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=3" shape="rect" coords="852,86,940,110" style="outline:none;" target="_self" />
            <area alt="" title="" href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=4" shape="rect" coords="943,86,1018,109" style="outline:none;" target="_self" />
            <area alt="" title="" href="<?php echo G5_SHOP_URL; ?>/modelslist.php" shape="rect" coords="1019,85,1105,110" style="outline:none;" target="_self" />
            </map>
        </div>
    </div> <!-- wrapper end -->
</div> <!-- vogos end -->

<!-- 하단 시작 { -->
<div id="ft">
    <div class="lineDeco"></div>
    <div>
        <a href="<?php echo $default['de_root_index_use'] ? G5_URL : G5_SHOP_URL; ?>/" id="ft_logo"><img src="<?php echo G5_SHOP_SKIN_URL; ?>/img/logo_footer.png" alt="처음으로"></a>
        <ul>
            <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=company">회사소개</a></li>
            <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision">이용약관</a></li>
            <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy">개인정보취급방침</a></li>
        </ul>
        <p>
            <span><b>회사명</b> <?php echo $default['de_admin_company_name']; ?></span>
            <span><b>주소</b> <?php echo $default['de_admin_company_addr']; ?></span><br>
            <span><b>사업자 등록번호</b> <?php echo $default['de_admin_company_saupja_no']; ?></span>
            <span><b>대표</b> <?php echo $default['de_admin_company_owner']; ?></span>
            <span><b>전화</b> <?php echo $default['de_admin_company_tel']; ?></span>
            <span><b>팩스</b> <?php echo $default['de_admin_company_fax']; ?></span><br>
            <!-- <span><b>운영자</b> <?php echo $admin['mb_name']; ?></span><br> -->
            <span><b>통신판매업신고번호</b> <?php echo $default['de_admin_tongsin_no']; ?></span>
            <span><b>개인정보관리책임자</b> <?php echo $default['de_admin_info_name']; ?></span>

            <?php if ($default['de_admin_buga_no']) echo '<span><b>부가통신사업신고번호</b> '.$default['de_admin_buga_no'].'</span>'; ?><br>
            Copyright &copy; 2015 <?php echo $default['de_admin_company_name']; ?>. All Rights Reserved.
        </p>
        <a href="#" id="ft_totop">상단으로</a>
    </div>
</div>

<?php 
if(G5_USE_MOBILE && !G5_IS_MOBILE && is_mobile()) { 
    $seq = 0; 
    $href = $_SERVER['PHP_SELF']; 
    if($_SERVER['QUERY_STRING']) { 
        $sep = '?'; 
        foreach($_GET as $key=>$val) { 
            if($key == 'device') 
                continue; 

            $href .= $sep.$key.'='.strip_tags($val); 
            $sep = '&amp;'; 
            $seq++; 
        } 
    } 
    if($seq) 
        $href .= '&amp;device=mobile'; 
    else 
        $href .= '?device=mobile'; 
?> 
<a href="<?php echo $href; ?>" id="device_change">모바일 버전으로 보기</a> 
<?php } // end of 'check mobile' ?> 

<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script src="<?php echo G5_SHOP_SKIN_URL; ?>/js/common.js"></script>
<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>
<!-- } 하단 끝 -->

<?php
include_once(G5_PATH.'/tail.sub.php');
?>