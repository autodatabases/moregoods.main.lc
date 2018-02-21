<?php

$oObject=new PriceGroup();

switch (Base::$aRequest['action'])
{
	default:
		$oObject->Index();
		break;
}
?>