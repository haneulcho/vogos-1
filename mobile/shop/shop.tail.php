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
    Business License: 123-88-00091<br>
    Tel: +82 (0)70-7771-5527 / help@vogos.com<br>
    B2 Floor, 31, Teheran-ro 33-gil Gangnam-gu, Seoul, Korea<br>
        Copyright &copy; 2015 VOGOS.com All Rights Reserved.
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