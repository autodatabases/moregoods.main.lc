<?php
include "../connect.php";

if ($_GET['action']=='quit') {
	session_start();
	$_SESSION["mpanel_auth".$GENERAL_CONF['ProjectName']]='';
	$_SESSION[mpanel_auth_browser]='';
}
?>
<HTML>
<HEAD>
<TITLE>MPanel <?php echo $GENERAL_CONF['ProjectName']; ?> - Authentication</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<link href="/libp/mpanel/css/css.css" rel="stylesheet" type="text/css">
</HEAD>
<body onload="place_cursor();" class="login_page">
<SCRIPT language="JavaScript" type="text/javascript">
function place_cursor()
{try {  if (document.forms[0] && document.forms[0][0])  document.forms[0][0].focus();} catch(err) {}}
</SCRIPT>

<div class="login_wrap">
	

<div class="login_form">
		<div class="title"></div>
		<div class="cont" align="center">
			<!-- Login Box -->
			<div class="cont_hd">Login</div>
			<FORM method=post action="login.php">
			<br><?php if ($_GET[auth]=='bad') echo '<font color=red>Authentication failed. Please try again.</font>'; ?>&nbsp;<br>
			<table width="95%" cellspacing="2" cellpadding="2" border="0" align="center">
			<tr>
				<td><b>Username</b></td>
				<td align="right"><INPUT type=text name=login value='' style='width:175px;'></td>
			</tr><tr>
				<td><b>Password</b></td>
				<td align="right"><INPUT type=password name=password value='' style='width:175px;'></td>
			</tr><tr>
				<td colspan="2" align="right">
					<input type="submit" name="auth" value="Login" class="bttn gm-button">
				</td>
			</tr>
			</table>
			</FORM>
			<!-- Login Box -->
		</div>
		<div><img src="/libp/mpanel/images/login_bttm.png" width="268" height="12" alt="" /></div>
	</div>
</div>

</body>
</HTML>