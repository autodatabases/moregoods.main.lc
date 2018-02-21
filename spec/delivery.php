<?php

$oObject=new Delivery();
$sPrefix='delivery_';

switch (Base::$aRequest['action'])
{
	case $sPrefix.'set':
		$oObject->Set();
		break;

	case $sPrefix.'setbonus':
		$oObject->SetBonus();
		break;

	default:
		$oObject->Index();
		break;
}


?>