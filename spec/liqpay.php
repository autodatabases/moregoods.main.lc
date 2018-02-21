<?php
require_once(SERVER_PATH.'/class/module/LiqPay.php'); 
$sPrefix='liqpay';
$oObject=new LiqPay(i54276112930, R15mltUEp2UkL7pPI3FebTV10V0nsZ7w3DPoehz9);

switch (Base::$aRequest['action'])
{
		default:
		$oObject->LiqPayRequest();
		break;
}
?>