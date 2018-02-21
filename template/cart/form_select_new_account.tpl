<script type="text/javascript" src="/single/language_js.php"></script>
<table>
	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Login")}:</b>{$sZir}</td>
   		<td>
   		<input type=text name=data[login] value='{$smarty.request.data.login}' class='phone'
			maxlength=15 style='width:270px'></td>
  	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Password")}:</b>{$sZir}</td>
		<td>
		<input type=text name=data[password] value='{$smarty.request.data.password}'
			 maxlength=50 style='width:270px'></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Retype Password")}:</b>{$sZir}</td>
		<td>
	<input type=text name=data[verify_password] value='{$smarty.request.data.verify_password}'
		 maxlength=50 style='width:270px'></td>
	</tr>
	<tr>
		<td><nobr><b>{$oLanguage->getMessage("Email")}:</b></td>
		<td valign=center width=280>
		<input type=text name=data[email] value='{$smarty.request.data.email}' style='width:270px'></td>
	</tr>
<tr>
	<td><nobr><b>{$oLanguage->getMessage("FLName")}:</b>{$sZir}</td>
	<td valign=center width=280>
	<input type=text name=data[name] value='{if $aUser.name}{$aUser.name}{else}{$smarty.request.data.name}{/if}' style='width:270px'></td>
</tr>
<tr>
	<td><nobr><b>{$oLanguage->getMessage("Phone")}:</b>{$sZir}</td>
	<td valign=center width=280>
	<input type=text name=data[phone] value='{if $aUser.name}{$aUser.phone}{elseif $smarty.request.data.phone}{$smarty.request.data.phone}{else}{/if}' style='width:270px'
	onclick="if (this.value=='{$oLanguage->getMessage("Default phone")}') this.value=''" class='phone'></td>
</tr>
<tr>
	<td><nobr><b>{$oLanguage->getMessage("City")}:</b></td>
	<td valign=center width=280>
	<input type=text name=data[city] value='{if $aUser.name}{$aUser.city}{else}{$smarty.request.data.city}{/if}' style='width:270px'></td>
</tr>
	{* include file="user/new_account_delivery_info.tpl" *}

</table>