<?php
/**
 * @author Oleksandr Starovoit
 */

$oObject=new PriceFtp();
$sPrefix=$oObject->sPrefix."_";
switch (Base::$aRequest['action'])
{
/*
	case $sPrefix.'import':
		$oObject->Import();
		break;
*/	
	default:
		$oObject->Index();
		break;

}
?>