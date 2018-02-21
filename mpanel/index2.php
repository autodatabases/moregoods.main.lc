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
		<div class="title"><img src="/libp/mpanel/images/title.png" width="86" height="14" alt="MstarPanel" /></div>
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
					<input type="submit" name="auth" value="Login" class="bttn">
				</td>
			</tr>
			</table>
			</FORM>
			<!-- Login Box -->
		</div>
		<div><img src="/libp/mpanel/images/login_bttm.png" width="268" height="12" alt="" /></div>
	</div>


	<h3>MPanel</h3>
	<div class="txt">
		<div align="right" style="width:135px;"><img src="/libp/mpanel/images/s_button.png" width="20" height="30" alt="" /></div>
		<br />
		<p>Welcome to <b>MPanel&trade;</b></p>
		<p>Use a valid username and<br />password to gain access to<br />the administration console</p>
		<br /><br /><br /><br />
		<table border="0" width=390 align="center" cellpadding="5" cellspacing="0">
		<tr>
			<td align="right" valign="top">
				<font color=red><b>Caution:</b></font>
			</td>
			<td>
				This is a private secure administration section for <font color="#137892" size=2><b>
					<?php echo $GENERAL_CONF['ProjectName']; ?></b></font>.
				<br />Any unauthorized use of this section could be prosecuted.
			</td>
		</tr>
		<tr>
			<td align="right" valign="top"><b>Note:</b></td>
			<td>
				Authorized users are instructed to log out of the system and close the browser window to ensure security of
					data and transactions done online.
			</td>
		</tr>
		</table>
		<br /><br /><br />
	</div>
</div>

</body>
</HTML>