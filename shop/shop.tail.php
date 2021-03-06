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
        <!-- <a href="#hd" id="top_btn">상단으로</a> -->
    </div><!-- } container 콘텐츠 끝 -->
</div><!-- } Wrapper 끝 -->

<!-- 하단 시작 { -->
<div id="ft">
    <div class="fullWidth">
    <div id="ft_wr">
        <div id="ft_about">
            <h2>ABOUT VOGOS</h2>
            <ul>
                <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=company">Who Are We?</a></li>
            </ul>       
        </div>
        <div id="ft_help">
            <h2>HOW CAN WE HELP</h2>
            <ul>
                <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy">Privacy Policy</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision">Terms and Conditions</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=shippinginfo">Shipping Info</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=returnpolicy">Returns and Policies</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=sizeguide">Size Guide</a></li>
            </ul>
        </div>
        <div id="ft_like">
            <h2>LIKE &amp; FOLLOW US</h2>
            <ul class="ft_sns">
                <li><a href="https://instagram.com/vogos_style" target="_blank"><span class="ft_sns_in">Instagram</span></a></li>
                <li><a href="https://facebook.com/vogos.style" target="_blank"><span class="ft_sns_fb">Facebook</span></a></li>
                <li><a href="#" target="_blank" onClick="alert('Coming Soon!');return false;"><span class="ft_sns_yt">Youtube</span></a></li>
                <li><a href="https://www.pinterest.com/vogos_style" target="_blank"><span class="ft_sns_pt">Pinterest</span></a></li>
                <!-- <li><a href="http://"><span>Tumblr</span></a></li> -->                
            </ul>
        </div>
    </div>
    <div class="ft_bottom">
        <div id="ft_copy">
            Copyright &copy; 2015 <?php echo $default['de_admin_company_name']; ?>. All Rights Reserved.
        </div>
        <p>Tel: +1 323-319-3888 / help@vogos.com / Business License: 123-88-00091<br>
        Tel: +44 (0)20-3239-8282 / 8 Berwick Street, London W1F 0PH, United Kingdom<br>
        Tel: +82 (0)70-7771-5527 / B2 Floor, 31, Teheran-ro 33-gil Gangnam-gu, Seoul, Korea<br></p>
        <div id="ft_pay">
            <img src="<?php echo G5_SHOP_SKIN_URL ?>/img/payment.png">
        </div>
    </div>
    </div>
</div>

<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>
<script>
$(function() {
    $("#top_btn").on("click", function() {
        $("html, body").animate({scrollTop:0}, '500');
        return false;
    });
});
</script>
<!-- } 하단 끝 -->

<?php
include_once(G5_PATH.'/tail.sub.php');
?>