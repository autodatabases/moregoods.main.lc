<?php
/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2005 Frederico Caldeira Knabben
 *
 * Licensed under the terms of the GNU Lesser General Public License:
 *              http://www.opensource.org/licenses/lgpl-license.php
 *
 * For further information visit:
 *              http://www.fckeditor.net/
 *
 * "Support Open Source software. What about a donation today?"
 *
 * File Name: config.php
 *      Configuration file for the File Manager Connector for PHP.
 *
 * File Authors:
 *              Frederico Caldeira Knabben (fredck@fckeditor.net)
 */

global $Config ;

// SECURITY: You must explicitelly enable this "connector". (Set it to "true").
$Config['Enabled'] = true ;

// Path to uploaded files relative to the document root.
//$_image_base_path = explode('/mpanel/',$_SERVER["PHP_SELF"]);
//$_image_base_path=$_image_base_path[0].'/imgbank/';
$_image_base_path='/imgbank/';

$Config['UserFilesPath'] = $_image_base_path;

// Fill the following value it you prefer to specify the absolute path for the
// user files directory. Usefull if you are using a virtual directory, symbolic
// link or alias. Examples: 'C:\\MySite\\UserFiles\\' or '/root/mysite/UserFiles/'.
// Attention: The above 'UserFilesPath' must point to the same directory.
$Config['UserFilesAbsolutePath'] = '';

$Config['AllowedExtensions']['File']    = array() ;
$Config['DeniedExtensions']['File']             = array('php','php3','php5','phtml','asp','aspx','ascx','jsp','cfm','cfc','pl','bat','exe','dll','reg','cgi') ;

$Config['AllowedExtensions']['Image']   = array('jpg','gif','jpeg','png','xls','xlsx','ico') ;
$Config['DeniedExtensions']['Image']    = array() ;

$Config['AllowedExtensions']['Flash']   = array('swf','fla') ;
$Config['DeniedExtensions']['Flash']    = array() ;

$Config['AllowedExtensions']['Excel']   = array('xls','xlsx') ;
$Config['DeniedExtensions']['Excel']    = array() ;

$Config['AllowedExtensions']['Media']   = array('swf','fla','jpg','gif','jpeg','png','avi','mpg','mpeg') ;
$Config['DeniedExtensions']['Media']    = array() ;

?>