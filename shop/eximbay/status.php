<?php
	/** 
		�Ʒ� ���� �� ���� �׽�Ʈ�� secretKey�Դϴ�.
		�׽�Ʈ�θ� �����Ͻð� �߱� ������ ������ �����ϼž� �˴ϴ�.
	*/
	$secretKey = "289F40E6640124B2628640168C3C5464";//������ secretkey

	//�⺻ ���� �Ķ����
	$ver = $_POST['ver'];//���� ����
	$mid = $_POST['mid'];//������ ���̵�
	$txntype = $_POST['txntype'];//�ŷ� Ÿ��
	$ref = $_POST['ref'];//������ �������� ������ �ŷ� ���̵� 
	$cur = $_POST['cur'];//��ȭ 
	$amt = $_POST['amt'];//���� �ݾ�
	$shop = $_POST['shop'];//��������
	$buyer = $_POST['buyer'];//�����ڸ�
	$tel = $_POST['tel'];//������ ��ȭ��ȣ
	$email = $_POST['email'];//������ �̸���
	$lang = $_POST['lang'];//�������� ��� Ÿ��

	$transid = $_POST['transid'];//Eximbay ���� �ŷ� ���̵�
	$rescode = $_POST['rescode'];//0000 : ���� 
	$resmsg = $_POST['resmsg'];//���� ��� �޼���
	$authcode = $_POST['authcode'];//���ι�ȣ, PayPal, Alipay, Tenpay�� �Ϻ� ���������� ���ι�ȣ�� �����ϴ�.
	$cardco = $_POST['cardco'];//ī�� Ÿ��
	$resdt = $_POST['resdt'];//���� �ð� ���� YYYYMMDDHHSS
	$paymethod = $_POST['paymethod'];//�������� �ڵ� (�������� ����)

	$accesscountry = $_POST['accesscountry'];//������ ���� ����
	$allowedpvoid = $_POST['allowedpvoid'];//Y: �κ���� ����. N: �κ���� �Ұ�
	$fgkey = $_POST['fgkey'];//����Ű, rescode=0000�� ��쿡�� �� ���� ��
	$payto = $_POST['payto'];//û�� ��������

	//�ֹ� ��ǰ �Ķ����
	$item_0_product = $_POST['item_0_product'];
	$item_0_quantity = $_POST['item_0_quantity'];
	$item_0_unitPrice = $_POST['item_0_unitPrice'];

	//�߰� �׸� �Ķ����
	$surcharge_0_name = $_POST['surcharge_0_name'];
	$surcharge_0_quantity = $_POST['surcharge_0_quantity'];
	$surcharge_0_unitPrice = $_POST['surcharge_0_unitPrice'];

	//������ ���� �Ķ����
	$param1 = $_POST['param1'];
	$param2 = $_POST['param2'];
	$param3 = $_POST['param3'];

	//ī�� ���� ���� �Ķ����
	$cardholder = $_POST['cardholder'];//�����ڰ� �Է��� ī�� ������ ������
	$cardno1 = $_POST['cardno1'];
	$cardno4 = $_POST['cardno4'];

	//DCC �Ķ����
	$foreigncur = $_POST['foreigncur'];//�� ���� ��ȭ
	$foreignamt = $_POST['foreignamt'];//�� ���� ��ȭ �ݾ�
	$convrate = $_POST['convrate'];//���� ȯ��
	$rateid = $_POST['rateid'];//���� ȯ�� ���̵�

	//����� �Ķ���� 
	$shipTo_city = $_POST['shipTo_city'];
	$shipTo_country = $_POST['shipTo_country'];
	$shipTo_firstName = $_POST['shipTo_firstName'];
	$shipTo_lastName = $_POST['shipTo_lastName'];
	$shipTo_phoneNumber = $_POST['shipTo_phoneNumber'];
	$shipTo_postalCode = $_POST['shipTo_postalCode'];
	$shipTo_state = $_POST['shipTo_state'];
	$shipTo_street1 = $_POST['shipTo_street1'];

	//CyberSource�� DM�� ��� �ϴ� ��� �޴� �Ķ����
	$dm_decision = $_POST['dm_decision'];
	$dm_reject = $_POST['dm_reject'];
	$dm_review = $_POST['dm_review'];

	//PayPal �ŷ� ���̵�
	$pp_transid = $_POST['pp_transid'];

	//�Ϻ� ���� �Ķ����
	$status = $_POST['status'];//(�Ϻ�����)Registered or Sale :: Sale�� �ԱݿϷ� ��, statusurl�θ� ���۵� �Ϻ� ������/�¶��ι�ŷ �ĺҰ��� �̿� ��, �������� ��Ͽ� ���� ������ ������ ��� �߼۵˴ϴ�.
	$paymentURL = $_POST['paymentURL'];//�Ϻ������� ������/�¶��ι�ŷ �ĺ� ���� �̿�� ������ ���� ����� �ȳ��ϴ� URL

	
	//rescode=0000 �϶� fgkey Ȯ��
	if($rescode == "0000"){
		//fgkey ����Ű ����
		$linkBuf = $secretKey. "?mid=" . $mid ."&ref=" . $ref ."&cur=" .$cur ."&amt=" .$amt ."&rescode=" .$rescode ."&transid=" .$transid;
		$newFgkey = hash("sha256", $linkBuf);
		
		//fgkey ���� ���� �� ���� ó��
		if(strtolower($fgkey) != $newFgkey){
			$rescode = "ERROR";
			$resmsg = "Invalid transaction";
		}
	}
	
	if($rescode == "0000"){
		//������ �� DB ó���ϴ� �κ�
		//�ش� �������� Back-End�� ó���Ǳ� ������ ��ũ��Ʈ, ����, ��Ű ����� �Ұ��� �մϴ�.
	}
?>
