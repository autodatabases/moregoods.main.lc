<script type="text/javascript" src="/single/language_js.php"></script>
<table>
	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Login")}:</b>{$sZir}</td>
   		<td>
   		<input type=text name=data[login] value='{$smarty.request.data.login}'
			maxlength=15 style='width:270px'></td>
  	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Password")}:</b>{$sZir}</td>
		<td>
		<input type=password name=data[password] value='{$smarty.request.data.password}'
			 maxlength=50 style='width:270px'></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Retype Password")}:</b>{$sZir}</td>
		<td>
	<input type=password name=data[verify_password] value='{$smarty.request.data.verify_password}'
		 maxlength=50 style='width:270px'></td>
	</tr>
	<tr>
		<td><nobr><b>{$oLanguage->getMessage("Email")}:</b>{$sZir}</td>
		<td valign=center width=280>
		<input type=text name=data[email] value='{$smarty.request.data.email}' style='width:270px'></td>
	</tr>
	{ include file="user/new_account_delivery_info.tpl" }
	<tr>
		<td colspan=2 align=center>
		<input type=checkbox name=data[user_agreement] value='1'
			{if $smarty.request.data.user_agreement} checked{/if}>
		{$oLanguage->getMessage("I agree to")} <a href='/pages/agreement' target=_blank
			>{$oLanguage->getMessage("User agreement")}</a>
		</td>
	</tr>

</table>