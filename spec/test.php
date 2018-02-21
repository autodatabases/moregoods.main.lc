<?php

$oObject=new Test();
$sPreffix='test_';

switch (Base::$aRequest['action'])
{
	default:
		$oObject->Index();
		break;

}
?>