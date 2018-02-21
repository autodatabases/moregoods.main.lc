<?php


$sPrefix='manager_';
$oObject=new Manager();

switch (Base::$aRequest['action'])
{
	case $sPrefix.'profile':
		$oObject->Profile();
		break;

	case $sPrefix.'customer':
		$oObject->Customer();
		break;
	case $sPrefix.'customer_edit':
		$oObject->CustomerEdit();
		break;

	case $sPrefix.'set_user_login':
		$oObject->SetUserLogin();
		break;
	case $sPrefix.'set_user_password':
		$oObject->SetUserPassword();
		break;
		
	case $sPrefix.'customer_redirect':
		$oObject->CustomerRedirect();
		break;
		
	case $sPrefix.'customer_cart_print':
		$oObject->CustomerCartPrint();
		break;

	case $sPrefix.'customer_list':
		$oObject->CustomerList();
		break;

	case $sPrefix.'customer_list_add':
	case $sPrefix.'customer_list_edit':
		$oObject->CustomerListAdd();
		break;

	case $sPrefix.'customer_list_fill':
		$oObject->CustomerListFill();
		break;

	case $sPrefix.'customer_list_fill_add':
		$oObject->CustomerListFillAdd();
		break;
		
	case $sPrefix.'customer_list_fill_delete':
		$oObject->CustomerListFillDelete();
		break;

	case $sPrefix.'customer_list_delete':
		$oObject->CustomerListDelete();
		break;
		
	case $sPrefix.'order':
	case $sPrefix.'order_edit':
	case $sPrefix.'order_log':
		$oObject->Order();
		break;

	case $sPrefix.'change_status':
	case $sPrefix.'change_status_new':
	case $sPrefix.'change_status_work':
	case $sPrefix.'change_status_confirmed':
	case $sPrefix.'change_status_road':
	case $sPrefix.'change_status_store':
	case $sPrefix.'change_status_end':
		if (Base::$aRequest['action']!=$sPrefix.'change_status') {
			Base::$aRequest['order_status']=str_replace($sPrefix.'change_status_','',Base::$aRequest['action']);
		}
		$oObject->ChangeStatus();
		break;

	case $sPrefix.'agree_growth':
		$oObject->AgreeGrowth();
		break;

	case $sPrefix.'reorder':
		$oObject->Reorder();
		break;

	case $sPrefix.'order_archive':
		$oObject->Archive();
		break;

		//	case $sPrefix.'xajax_request':
		//		$oObject->XajaxRequest();
		//		break;

		//	case $sPrefix.'bill':
		//	case $sPrefix.'bill_add':
		//	case $sPrefix.'bill_edit':
		//	case $sPrefix.'bill_delete':
		//		$oObject->Bill();
		//		break;

	case $sPrefix.'vin_request':
	case $sPrefix.'vin_request_delete':
	case $sPrefix.'vin_request_edit':
	case $sPrefix.'vin_request_refuse_for':
	case $sPrefix.'vin_request_accept':
		$oObject->VinRequest();
		break;

	case $sPrefix.'vin_request_save':
		$oObject->VinRequestSave();
		break;

	case $sPrefix.'vin_request_send':
		$oObject->VinRequestSend();
		break;

	case $sPrefix.'vin_request_refuse':
		$oObject->VinRequestRefuse();
		break;

	case $sPrefix.'vin_request_remember':
		$oObject->VinRequestRemember();
		break;

	case $sPrefix.'package_list':
	case $sPrefix.'package_order':
	case $sPrefix.'package_edit':
		$oObject->Package();
		break;
		
	case $sPrefix.'package_add_order_item':
	    $oObject->PackageAddOrderItem();
	    break;

	case $sPrefix.'package_merge':
		$oObject->MergePakage();
		break;

		//	case $sPrefix.'package_archive':
		//		$oObject->PackageArchive();
		//		break;

	case $sPrefix.'export':
		$oObject->Export();
		break;

	case $sPrefix.'export_all':
		$oObject->ExportAll();
		break;

	case $sPrefix.'import_status':
		$oObject->ImportStatus();
		break;

	case $sPrefix.'import_weight':
		$oObject->ImportWeight();
		break;

	case $sPrefix.'finance':
	case $sPrefix.'finance_add':
		$oObject->Finance();
		break;

	case $sPrefix.'finance_export_all':
		$oObject->FinanceExportAll();
		break;

	case $sPrefix.'count_money':
		$oObject->CountMoney();
		break;

	case $sPrefix.'order_print':
		$oObject->PrintOrder();
		break;

	case $sPrefix.'order_refuse_pending':
		$oObject->RefusePending();
		break;

	case $sPrefix.'package_print':
		$oObject->PrintPakage();
		break;

	case $sPrefix.'empty_package_delete':
		$oObject->DeletePackageEmpty();
		break;

	case $sPrefix.'edit_weight':
		$oObject->EditWeight();
		break;

	case $sPrefix.'change_provider':
		$oObject->ChangeProvider();
		break;

	case $sPrefix.'package_payed':
		$oObject->SetPackagePayed();
		break;

	case $sPrefix.'cat':
	case $sPrefix.'cat_add':
		$oObject->Cat();
		break;

	case $sPrefix.'cat_pref':
	case $sPrefix.'cat_pref_add':
	case $sPrefix.'cat_pref_delete':
		$oObject->CatPref();
		break;

	case $sPrefix.'set_checked_auto':
			$oObject->SetCheckedAuto();
			break;

	case $sPrefix.'synonym':
		$oObject->Synonym();
		break;	
	
	case $sPrefix.'customer_recalc_cart':
		$oObject->CustomerRecalcCart();
		break;
		
	case $sPrefix.'package_join_orders':
		$oObject->JoinOrders();
		break;
	
	case $sPrefix.'get_user_select':
		$oObject->GetUserSelect();
		break;
		
	case $sPrefix.'user_debt':
    case $sPrefix.'order_ship':
    case $sPrefix.'payment_ship':
	    $oObject->GetUserDebt();
	    break;
		
	case $sPrefix.'user_discounts':
	    $oObject->GetUserDiscounts();
	    break;

	case $sPrefix.'send_bill_liqpay':
    $oObject->SendLiqPay();
    	break; 

    case $sPrefix.'update_number_fact':
    $oObject->UpdateNumberFact();
    	break; 

    case $sPrefix.'copy_fact':
    $oObject->CopyFact();
    	break; 

    case $sPrefix.'export_bill':
    case $sPrefix.'export_bill_all':
    $oObject->ExportBills();
    	break; 
		
	default:
		$oObject->Index();
		break;
}


?>