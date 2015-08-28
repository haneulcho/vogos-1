<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.
?>

</div><!-- container End -->

<div id="ft">
    <h2><?php echo $config['cf_title']; ?></h2>
    <ul>
        <li><a href="<?php echo G5_SHOP_URL; ?>/?device=pc" id="ft_to_pc"><i class="ion-monitor"></i>PC</a></li>
        <li><a href="#" id="ft_totop"><i class="ion-arrow-up-c"></i>TOP</a></li>
    </ul>
    <p>
        <span><b>회사명</b> <?php echo $default['de_admin_company_name']; ?></span>
        <span><b>대표</b> <?php echo $default['de_admin_company_owner']; ?></span><br>
        <span><b>주소</b> <?php echo $default['de_admin_company_addr']; ?></span><br>
        <span><b>전화</b> <?php echo $default['de_admin_company_tel']; ?></span>
        <span><b>팩스</b> <?php echo $default['de_admin_company_fax']; ?></span><br>
        <span><b>사업자 등록번호</b> <?php echo $default['de_admin_company_saupja_no']; ?></span>
        <!-- <span><b>운영자</b> <?php //echo $admin['mb_name']; ?></span><br> -->
        <span><b>통신판매업신고번호</b> <?php echo $default['de_admin_tongsin_no']; ?></span>
        <?php if ($default['de_admin_buga_no']) echo '<span><b>부가통신사업신고번호</b> '.$default['de_admin_buga_no'].'</span>'; ?>
        <!-- <span><b>개인정보관리책임자</b> <?php //echo $default['de_admin_info_name']; ?></span>--><br>
        Copyright &copy; 2015 <?php echo $default['de_admin_company_name']; ?>. All Rights Reserved.
    </p>
</div>
</div> <!-- main END -->

<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>
<script src="<?php echo G5_MSHOP_SKIN_URL; ?>/js/common.js"></script>
<?php
include_once(G5_PATH.'/tail.sub.php');
?>