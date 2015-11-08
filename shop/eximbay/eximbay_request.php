<?php
	$reqURL = "https://secureapi.test.eximbay.com/Gateway/BasicProcessor.krp";//EXIMBAY TEST 서버 요청 URL입니다.
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

