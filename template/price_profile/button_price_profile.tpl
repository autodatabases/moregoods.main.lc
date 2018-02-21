<table cellpadding="0" cellspacing="10" border="0" align="left">
<tr>
	<td valign="top" align="left">
	<input class=btn type=button value='{$oLanguage->getMessage("New Profile")}'
		onclick="location.href='/?action=price_profile_add&return={$sReturn|escape:"url"}'">
	</td>
	<td valign="top" align="left">
	<input class=btn type=button value='{$oLanguage->getMessage("New Profile from file")}'
		onclick="location.href='/?action=price_profile_add_from_file&return={$sReturn|escape:"url"}'">
	</td>
</tr>
</table>