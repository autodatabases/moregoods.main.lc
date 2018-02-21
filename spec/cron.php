<?php

$sPreffix='cron_';

switch (Base::$aRequest['action'])
{
	case $sPreffix.'minutely':
		Mail::SendDelayed(3);
		Cron::AssociateDelayedPricesMinutely();
		//		Sms::SendDelayed();
		break;
		//-----------------------------------------------------------------------------------------------
	case $sPreffix.'minutely2':
		ElitRoma::CronSecond();
		break;

	case $sPreffix.'minutely_10':
		$oPriceQueue= new PriceQueue();
		$oPriceQueue->LoadQueuePrice();
		break;
		//-----------------------------------------------------------------------------------------------

	case $sPreffix.'hourly':
		Cron::DeleteTemporaryCustomer();
		//--------------------------------------------
		$oPriceQueue= new PriceQueue();
		$oPriceQueue->GetFtpFile();
		//--------------------------------------------
		Cron::MoveExpiredCart();
		break;
		//-----------------------------------------------------------------------------------------------


	case $sPreffix.'daily':
		Discount::Refresh();

		Cron::ClearOldData();
		Cron::SendDbBackup();
		//--------------------------------------------
		$oPrice= new Price();
		$oPrice->ClearOldQueueFiles();
		//--------------------------------------------
		Cron::ClearAllOld();
		break;
		//-----------------------------------------------------------------------------------------------
	case $sPreffix.'weekly':
		//--------------------------------------------
		$oPrice= new Price();
		$oPrice->ClearOldQueueImportRecords();
		break;
		//-----------------------------------------------------------------------------------------------

	case $sPreffix.'monthly':
		//--------------------------------------------
		break;
		//-----------------------------------------------------------------------------------------------

	case $sPreffix.'get_mail':
		$oPriceQueue= new PriceQueue();
		$oPriceQueue->GetMailAttachment();
		break;
		//-----------------------------------------------------------------------------------------------

	default:
		break;
		//-----------------------------------------------------------------------------------------------
}

die(date("Y-m-d H:i:s").': Ok');
?>