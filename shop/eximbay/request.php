<?php
	/** 
		�Ʒ� ���� �� ���� �׽�Ʈ�� secretKey, mid�Դϴ�.
		�׽�Ʈ�θ� ���� �Ͻð� �߱� ������ ������ ���� �ϼž� �˴ϴ�.
	*/
	$secretKey = "289F40E6640124B2628640168C3C5464";//������ secretkey
	$mid = "1849705C64";//������ ���̵�
	$ref = "abcd1234567890";//���������� ���� ������ ���� �ŷ� ���̵�. �ŷ��� ���� ������ �����ϴ� ���� �����մϴ�.
	$reqURL = "https://secureapi.test.eximbay.com/Gateway/BasicProcessor.krp";//EXIMBAY TEST ���� ��û URL�Դϴ�.

	$cur = $_POST['cur'];
	$amt = $_POST['amt'];
	
	//fgkey ����Ű ����
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
<input type="hidden" name="mid" value="<?php echo $mid; ?>" /> <!--�ʼ� ��-->
<input type="hidden" name="ref" value="<?php echo $ref; ?>" />	<!--�ʼ� ��-->
<input type="hidden" name="fgkey" value="<?php echo $fgkey; ?>" />	<!--�ʼ� ��-->

<?php
foreach($_POST as $Key=>$value) {
?>
<input type="hidden" name="<?php echo $Key;?>" value="<?php echo $value;?>">
<?php } ?>
</form>
</body>
</html>

