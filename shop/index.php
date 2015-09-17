<?php
include_once('./_common.php');

    // 접속자마케팅 로그분석기 서버스크립트 삽입 150916
    if($logcorp_xml_send != true){
        $ptc = strstr($_SERVER['SERVER_PROTOCOL'],"HTTPS") ? "https://" : "http://";
        if(!isset($_SESSION)) @session_start();
        $logsrid = $_COOKIE['logsrid'];
        if($logsrid == ""){
            $microtime = explode("\.", microtime(true));
            $logsrid = substr(md5(session_id()),0,26)."-".date("Ymd") . substr($microtime[0], -5). substr($microtime[1], 0, 2);
        }
        if(session_id()){
            $_SESSION['logsid']=md5(session_id());
            $_SESSION['logref']=urlencode($_SERVER['HTTP_REFERER']);
            $logcorp_pV = "logra=".$_SERVER['REMOTE_ADDR']."&logsid=".md5(session_id())."&logsrid=".$logsrid."&logua=".urlencode($_SERVER['HTTP_USER_AGENT'])."&logha=".urlencode($_SERVER['HTTP_ACCEPT'])."&logref=".urlencode($_SERVER['HTTP_REFERER'])."&logurl=".urlencode($ptc.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])."&cdkey=vogoskorea&asp=asp3"; 
            $logcorp_headers =  "GET /jserver.php?".$logcorp_pV." HTTP/1.0\r\nHost: 114.108.138.227\r\nConnection: Close\r\n\r\n";
            $logcorp_fp = @fsockopen("114.108.138.227", 80, $errno, $errstr,0.2); 
            if($logcorp_fp) {
                fwrite($logcorp_fp, $logcorp_headers);
                fclose($logcorp_fp);
            }
            $logcorp_xml_send = True;
            setcookie("logsrid", $logsrid, time()+259200000, "/",str_replace("www.","",$_SERVER['SERVER_NAME']));
        }
    }
/*
* 특허번호 : 10-1029990
* 특허명 : 접속 정보 제공 시스템 및 방법
* 특허권자 : 주식회사 로그
* 본 프로그램 소스는 (주)로그에서 개발.배포한 것으로 등록특허 제 10-1029990호(접속 정보 제공 시스템 및 방법)의 특허 기술이 적용되었습니다.
* 특허권자의 허락없이 사용,배포,판매 등의 행위를 할 경우 특허법 제128조 및 제225조에 따라 민.형사상 책임을 질 수 있습니다.
*/

// 초기화면 파일 지정 : 이 코드는 가능한 삭제하지 마십시오.
if ($default['de_include_index'] && is_file(G5_SHOP_PATH.'/'.$default['de_include_index'])) {
    include_once(G5_SHOP_PATH.'/'.$default['de_include_index']);
    return; // 이 코드의 아래는 실행을 하지 않습니다.
}

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/index.php');
    return;
}

define("_INDEX_", TRUE);

include_once(G5_SHOP_PATH.'/shop.head.php');
?>

<?php if($default['de_type1_list_use']) { ?>
<!-- VOGOS 야외촬영 시작 { -->
<section class="sct_wrap w1160">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=1">Everywhere is Runway<br>VOGOS</a></h2>
    </header>
    <?php
    $list = new item_list();
    $list->set_type(1);
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
<!-- } VOGOS 야외촬영 끝 -->
<?php } ?>

<?php if($default['de_type2_list_use']) { ?>
<!-- VOGOS 모델스 초이스(MODEL's CHOICE) 시작 { -->
<section class="sct_wrap w1160">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=2">VOGOS<br>MODEL's CHOICE</a></h2>
    </header>
    <?php include_once(G5_SHOP_SKIN_PATH.'/main.modelslist.skin.php'); ?>
</section>
<!-- } VOGOS 모델스 초이스(MODEL's CHOICE) 끝 -->
<?php } ?>

<?php if($default['de_type4_list_use']) { ?>
<!-- VOGOS RUNWAY in VOGOS 시작 { -->
<section class="sct_wrap w1160">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=4">RUNWAY<br>IN VOGOS</a></h2>
    </header>
    <?php
    $list = new item_list();
    $list->set_type(4);
    $list->set_view('it_id', false);
    $list->set_view('it_name', false);
    $list->set_view('it_basic', false);
    $list->set_view('it_cust_price', false);
    $list->set_view('it_price', false);
    $list->set_view('it_icon', false);
    $list->set_view('sns', false);
    echo $list->run();
    ?>
</section>
<!-- } VOGOS BESTSELLERS 끝 -->
<?php } ?>

<?php if($default['de_type3_list_use']) { ?>
<!-- NEW ARRIVALS 시작 { -->
<section class="sct_wrap w1160">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=3">NEW<br>ARRIVALS</a></h2>
    </header>
    <?php
    $list = new item_list();
    $list->set_type(3);
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
<!-- } NEW ARRIVALS 끝 -->
<?php } ?>

<?php if($default['de_type5_list_use']) { ?>
<!-- 할인상품 시작 { -->
<section class="sct_wrap w1160">
    <header>
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=5">UP TO<br>7% OFF</a></h2>
    </header>
    <?php
    $list = new item_list();
    $list->set_type(5);
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
<!-- } 할인상품 끝 -->
<?php } ?>

<?php // echo poll('shop_basic'); // 설문조사 ?>

<?php // echo visit('shop_basic'); // 접속자 ?>

<?php
include_once(G5_SHOP_PATH.'/shop.tail.php');
?>