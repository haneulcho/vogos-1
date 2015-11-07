<?php
	/** 
		아래 설정 된 값은 테스트용 secretKey, mid입니다.
		테스트로만 진행 하시고 발급 받으신 값으로 변경 하셔야 됩니다.
	*/
	$secretKey = "289F40E6640124B2628640168C3C5464";//가맹점 secretkey
	$mid = "1849705C64";//가맹점 아이디
	$ref = "abcd1234567890";//가맹점에서 설정 가능한 고유 거래 아이디. 거래별 고유 값으로 설정하는 것을 권장합니다.
	$reqURL = "https://secureapi.test.eximbay.com/Gateway/BasicProcessor.krp";//EXIMBAY TEST 서버 요청 URL입니다.

	$cur = $_POST['cur'];
	$amt = $_POST['amt'];
	
	//fgkey 검증키 생성
	$linkBuf = $secretKey. "?mid=" . $mid ."&ref=" . $ref ."&cur=" .$cur ."&amt=" .$amt;
	$fgkey = hash("sha256", $linkBuf);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body leftmargin="0" topmargin="0" align="center" onload="javascript:document.regForm.submit();">
<form name="regForm" method="post" action="<?php echo $reqURL; ?>">
<input type="hidden" name="mid" value="<?php echo $mid; ?>" /> <!--필수 값-->
<input type="hidden" name="ref" value="<?php echo $ref; ?>" />	<!--필수 값-->
<input type="hidden" name="fgkey" value="<?php echo $fgkey; ?>" />	<!--필수 값-->

<?php
foreach($_POST as $Key=>$value) {
?>
<input type="hidden" name="<?php echo $Key;?>" value="<?php echo $value;?>">
<?php } ?>
</form>
</body>
</html>

