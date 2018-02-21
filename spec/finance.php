<?php

require_once(SERVER_PATH.'/class/module/Finance.php'); ;
$sPreffix='finance_';
$oObject=new Finance();

switch (Base::$aRequest['action'])
{
	case $sPreffix.'bill':
	case $sPreffix.'bill_add':
	case $sPreffix.'bill_edit':
	case $sPreffix.'bill_delete':
		$oObject->Bill();
		break;

	case $sPreffix.'bill_print':
		$oObject->BillPrint();
		break;

	case $sPreffix.'cart_pay':
		$oObject->CartPay();
		break;

	case $sPreffix.'payforaccount':
		$oObject->PayForAccount();
		break;

	case $sPreffix.'export_all':
		$oObject->ExportAll();
		break;
		
	case $sPreffix.'user_debt':
    case $sPreffix.'order_ship':
    case $sPreffix.'payment_ship':
	    $oObject->GetMyDebt();
	    break;
	case $sPreffix.'user_discounts':
	    $oObject->GetMyDiscounts();
	    break;
	    
	default:
		$oObject->Bill();
		//$oObject->Index();
		break;

}


?>