<?php
//================================================================================
//This script check whether seesion is checked and if not - stops execution
//================================================================================
session_start();

//-----------------------------------------
//Check here your $_SESSION[auth_variable]
//-----------------------------------------
if ($_SESSION[mpanel_auth_browser]!="ok")  {
        Header("Location: http://$_SERVER_NAME/mpanel/?auth=bad");
        //session_unset();
        //session_destroy();
        die();
}
//================================================================================

?>