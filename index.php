<?php
require_once('connect.php');

session_start();
require('init.php');


if (Base::$aRequest['xajax']) {
	require( SERVER_PATH.'/xajax_request_parser.php');
}
else {
	require( SERVER_PATH.'/action_includer.php');
	Base::Process();
}

?>
