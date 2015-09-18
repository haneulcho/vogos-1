<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$begin_time = get_microtime();

// 사용자가 지정한 head.sub.php 파일이 있다면 include
if(defined('G5_HEAD_SUB_FILE') && is_file(G5_PATH.'/'.G5_HEAD_SUB_FILE)) {
    include_once(G5_PATH.'/'.G5_HEAD_SUB_FILE);
    return;
}

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    $g5_head_title = $g5['title']; // 상태바에 표시될 제목
    $g5_head_title .= " | ".$config['cf_title'];
}

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<?php
if (G5_IS_MOBILE) {
    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10">'.PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
} else {
    echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
    echo '<meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1">'.PHP_EOL;
}

if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;
?>
<meta property="og:type" content="website">
<?php if (!isset($og_title)) { ?>
<meta property="og:title" content="VOGOS (보고스)">
<meta property="og:url" content="<?php "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]; ?>">
<meta property="og:description" content="Everywhere is Runway, Every VOGOS - 보고스 패션을 지금 만나보세요!">
<meta property="og:image" content="<?php echo G5_SHOP_SKIN_URL.'/img/logo.png' ?>">
<?php } else { ?>
<meta property="og:title" content="<?=$og_title ?>">
<meta property="og:url" content="<?=$og_url ?>">
<meta property="og:description" content="<?=$og_description?>">
<meta property="og:image" content="<?=$og_img?>"> 
<?php } ?>
<title><?php echo $g5_head_title; ?></title>
<?php
if (defined('G5_IS_ADMIN')) {
    echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/css/admin.css">'.PHP_EOL;
} else {
    $shop_css = '';
    if (defined('_SHOP_')) $shop_css = '_shop';
    echo '<link rel="stylesheet" href="'.G5_CSS_URL.'/'.(G5_IS_MOBILE?'mobile':'default').$shop_css.'.css">'.PHP_EOL;
}
?>
<!--[if lte IE 8]>
<script src="<?php echo G5_JS_URL ?>/html5.js"></script>
<![endif]-->
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
<?php
if ($is_admin) {
    echo 'var g5_admin_url = "'.G5_ADMIN_URL.'";'.PHP_EOL;
}
?>
</script>
<!--  LOG corp Web Analitics & Live Chat  START -->
<script type="text/javascript">
//<![CDATA[
function logCorpAScript_full(){
    HTTP_MSN_MEMBER_NAME="";/*member name*/
    LOGSID = "<?=$_SESSION['logsid']?>";/*logsid*/
    LOGREF = "<?=$_SESSION['logref']?>";/*logref*/
    var prtc=(document.location.protocol=="https:")?"https://":"http://";
    var hst=prtc+"asp3.http.or.kr"; 
    var rnd="r"+(new  Date().getTime()*Math.random()*9);
    this.ch=function(){
        if(document.getElementsByTagName("head")[0]){logCorpAnalysis_full.dls();}else{window.setTimeout(logCorpAnalysis_full.ch,30)}
    }
    this.dls=function(){
        var  h=document.getElementsByTagName("head")[0];
        var  s=document.createElement("script");s.type="text/jav"+"ascript";try{s.defer=true;}catch(e){};try{s.async=true;}catch(e){};
        if(h){s.src=hst+"/HTTP_MSN/UsrConfig/vogoskorea/js/ASP_Conf.js?s="+rnd;h.appendChild(s);}
    }
    this.init= function(){
        document.write('<img src="'+hst+'/sr.gif?d='+rnd+'"  style="width:1px;height:1px;position:absolute;" alt="" onload="logCorpAnalysis_full.ch()" />');
    }
}
if(typeof logCorpAnalysis_full=="undefined"){   var logCorpAnalysis_full=new logCorpAScript_full();logCorpAnalysis_full.init();}
//]]>
</script>
<noscript><img src="http://asp3.http.or.kr/HTTP_MSN/Messenger/Noscript.php?key=vogoskorea" border="0" style="display:none;width:0;height:0;" /></noscript>
<!-- LOG corp Web Analitics & Live Chat END  -->
<!-- <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script> -->
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<?php
if (defined('_SHOP_')) {
    if(!G5_IS_MOBILE) {
?>
<script src="<?php echo G5_JS_URL ?>/jquery.shop.menu.js"></script>
<?php
    }
} else {
?>
<script src="<?php echo G5_JS_URL ?>/jquery.menu.js"></script>
<?php } ?>
<script src="<?php echo G5_JS_URL ?>/common.js"></script>
<script src="<?php echo G5_JS_URL ?>/wrest.js"></script>
<?php
if(G5_IS_MOBILE) {
    echo '<script src="'.G5_JS_URL.'/modernizr.custom.70111.js"></script>'.PHP_EOL; // overflow scroll 감지
}
if(!defined('G5_IS_ADMIN'))
    echo $config['cf_add_script'];
?>
</head>
<body<?php echo isset($g5['body_script']) ? $g5['body_script'] : ''; ?>>

<?
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
?>

<?php
if ($is_member) { // 회원이라면 로그인 중이라는 메세지를 출력해준다.
    $sr_admin_msg = '';
    if ($is_admin == 'super') $sr_admin_msg = "최고관리자 ";
    else if ($is_admin == 'group') $sr_admin_msg = "그룹관리자 ";
    else if ($is_admin == 'board') $sr_admin_msg = "게시판관리자 ";

    echo '<div id="hd_login_msg">'.$sr_admin_msg.$member['mb_nick'].'님 로그인 중 ';
    echo '<a href="'.G5_BBS_URL.'/logout.php">로그아웃</a></div>';
}
?>